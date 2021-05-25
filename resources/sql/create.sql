DROP TABLE IF EXISTS images             CASCADE;
DROP TABLE IF EXISTS tags               CASCADE;
DROP TABLE IF EXISTS "users"            CASCADE; -- previously user
DROP TABLE IF EXISTS clients            CASCADE;
DROP TABLE IF EXISTS suppliers          CASCADE;
DROP TABLE IF EXISTS purchases          CASCADE;
DROP TABLE IF EXISTS items              CASCADE;
DROP TABLE IF EXISTS coupons            CASCADE;
DROP TABLE IF EXISTS products           CASCADE;
DROP TABLE IF EXISTS ship_details       CASCADE;
DROP TABLE IF EXISTS credit_cards       CASCADE;
DROP TABLE IF EXISTS reviews            CASCADE;
DROP TABLE IF EXISTS temp_purchases     CASCADE;
DROP TABLE IF EXISTS item_purchase      CASCADE;
DROP TABLE IF EXISTS item_product       CASCADE;
DROP TABLE IF EXISTS item_tag           CASCADE;
DROP TABLE IF EXISTS image_product      CASCADE;
DROP TABLE IF EXISTS client_item        CASCADE;
DROP TABLE IF EXISTS carts              CASCADE;

DROP MATERIALIZED VIEW IF EXISTS fts_view_weights;

DROP TYPE IF EXISTS unit_type           CASCADE;
DROP TYPE IF EXISTS coupon_type         CASCADE;
DROP TYPE IF EXISTS purchase_type       CASCADE;

DROP FUNCTION IF EXISTS expired_coupon          CASCADE;
DROP FUNCTION IF EXISTS inactive_item           CASCADE;
DROP FUNCTION IF EXISTS update_rating           CASCADE;
DROP FUNCTION IF EXISTS item_review             CASCADE;
DROP FUNCTION IF EXISTS search_update           CASCADE;
DROP FUNCTION IF EXISTS supplier_search_update  CASCADE;
DROP FUNCTION IF EXISTS item_search_update      CASCADE;
DROP FUNCTION IF EXISTS tag_search_update       CASCADE;


-- Types
CREATE TYPE unit_type       AS ENUM ('Kg', 'Un');
CREATE TYPE coupon_type     AS ENUM ('%', '€');
CREATE TYPE purchase_type   AS ENUM ('SingleBuy', 'Day', 'Week', 'Month');

-- Tables
CREATE TABLE images (
                        id          SERIAL      PRIMARY KEY,
                        path        TEXT        NOT NULL
);

CREATE TABLE tags (
                      id              SERIAL      PRIMARY KEY,
                      value           text        UNIQUE NOT NULL,
                      search          tsvector    DEFAULT '' NOT NULL
);

CREATE TABLE "users" (
                         id              SERIAL      PRIMARY KEY,
                         email           TEXT        NOT NULL CONSTRAINT user_email_uk UNIQUE,
                         password        TEXT        NOT NULL,
                         is_admin        boolean     NOT NULL DEFAULT 'false'
);

CREATE TABLE clients (
                         id              INTEGER     NOT NULL REFERENCES "users" (id) ON UPDATE CASCADE ON DELETE CASCADE,
                         name            TEXT        NOT NULL,
                         image_id        INTEGER     NOT NULL DEFAULT 1 REFERENCES images (id) ON UPDATE CASCADE ON DELETE SET DEFAULT,
                         PRIMARY KEY (id)
);

CREATE TABLE suppliers (
                           id              INTEGER     NOT NULL REFERENCES "users" (id) ON UPDATE CASCADE ON DELETE SET NULL,
                           name            TEXT        NOT NULL,
                           address         TEXT        NOT NULL,
                           post_code       TEXT        NOT NULL,
                           city            TEXT        NOT NULL,
                           description     TEXT        NOT NULL,
                           accepted        BOOLEAN     NOT NULL DEFAULT 'false',
                           image_id        INTEGER     NOT NULL DEFAULT 1 REFERENCES images (id) ON UPDATE CASCADE ON DELETE SET DEFAULT,
                           search          tsvector    DEFAULT '' NOT NULL,
                           PRIMARY KEY (id)
);

CREATE TABLE ship_details (
                              id              SERIAL      PRIMARY KEY,
                              first_name      TEXT        NOT NULL,
                              last_name       TEXT        NOT NULL,
                              address         TEXT        NOT NULL,
                              door_n          INTEGER     NOT NULL,
                              post_code       TEXT        NOT NULL,
                              district        TEXT        NOT NULL,
                              city            TEXT        NOT NULL,
                              country         TEXT        NOT NULL,
                              phone_n         TEXT        NOT NULL,
                              client_id       INTEGER     NOT NULL UNIQUE REFERENCES clients (id) ON UPDATE CASCADE ON DELETE CASCADE,
                              to_save         BOOLEAN     NOT NULL DEFAULT 'true'
);

CREATE TABLE credit_cards (
                              id              SERIAL      PRIMARY KEY,
                              card_n          text        NOT NULL,
                              expiration      text        NOT NULL,
                              cvv             INTEGER     NOT NULL,
                              holder          TEXT        NOT NULL,
                              client_id       INTEGER     NOT NULL REFERENCES clients (id) ON UPDATE CASCADE ON DELETE CASCADE,
                              to_save         BOOLEAN     NOT NULL DEFAULT 'true'

);


CREATE TABLE purchases (
                           id              SERIAL              PRIMARY KEY,
                           client_id       INTEGER             NOT NULL REFERENCES clients (id) ON UPDATE CASCADE ON DELETE CASCADE,
                           paid            DECIMAL             NOT NULL,
                           created_at      DATE                NOT NULL,
                           updated_at      DATE                DEFAULT NULL,
                           sd_id           INTEGER             REFERENCES ship_details (id) ON UPDATE CASCADE ON DELETE SET NULL,
                           cc_id           INTEGER             REFERENCES credit_cards (id) ON UPDATE CASCADE ON DELETE SET NULL,
                           type            purchase_type       NOT NULL,
                           CONSTRAINT      amount_positive_ck  CHECK (paid > 0)
    -- CONSTRAINT      old_date_ck         CHECK (purchase_date <= CURRENT_DATE)
);

-- BusinessRule: Item either is a bundle, or a product, can't have is_bundle true and be referenced in product
CREATE TABLE items (
                       id              SERIAL                  PRIMARY KEY,
                       supplier_id     INTEGER                 NOT NULL REFERENCES suppliers (id) ON UPDATE CASCADE ON DELETE SET NULL ,
                       name            TEXT                    NOT NULL,
                       price           DECIMAL                 NOT NULL,
                       stock           DECIMAL                 NOT NULL,
                       description     TEXT                    NOT NULL,
                       active          BOOLEAN                 NOT NULL,
                       rating          DECIMAL,
                       is_bundle       BOOLEAN                 NOT NULL DEFAULT 'false',
                       search          tsvector                DEFAULT '' NOT NULL,
                       CONSTRAINT      price_positive_ck       CHECK (price > 0),
                       CONSTRAINT      stock_not_negative_ck   CHECK (stock >= 0)
);

CREATE TABLE coupons (
                         id              SERIAL          PRIMARY KEY,
                         code            TEXT            NOT NULL UNIQUE,
                         name            TEXT            NOT NULL,
                         description     TEXT            NOT NULL,
                         expiration      DATE            NOT NULL CHECK (expiration > now()),
                         type            coupon_type     NOT NULL,
                         amount          DECIMAL         NOT NULL CHECK (amount > 0),
                         supplier_id     INTEGER         NOT NULL REFERENCES suppliers (id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE products (
                          id              INTEGER     PRIMARY KEY REFERENCES items (id) ON UPDATE CASCADE ON DELETE CASCADE ,
                          unit            unit_type   NOT NULL
);


CREATE TABLE reviews (
                         client_id       INTEGER     NOT NULL REFERENCES clients (id) ON UPDATE CASCADE ON DELETE SET NULL,
                         item_id         INTEGER     NOT NULL REFERENCES items (id) ON UPDATE CASCADE ON DELETE NO ACTION,
                         rating          INTEGER     NOT NULL,
                         description     TEXT        NOT NULL,
                         CONSTRAINT      rating_ck   CHECK (rating >= 1 AND rating <= 5),
                         PRIMARY KEY (client_id, item_id)
);

CREATE TABLE temp_purchases(
                               id              SERIAL              PRIMARY KEY,
                               client_id       INTEGER             NOT NULL REFERENCES clients (id) ON UPDATE CASCADE ON DELETE SET NULL,
                               total           DECIMAL             NOT NULL,
                               type            purchase_type       NOT NULL
);


/**
  Information about each item in a purchase
 */
CREATE TABLE item_purchase (
                               purchase_id     INTEGER     NOT NULL REFERENCES purchases (id) ON UPDATE CASCADE ON DELETE CASCADE ,
                               item_id         INTEGER     NOT NULL REFERENCES items (id) ON UPDATE CASCADE ON DELETE CASCADE ,
                               price           DECIMAL     NOT NULL CHECK ( price > 0 ),
                               amount          DECIMAL     NOT NULL CHECK ( amount > 0 ),
                               PRIMARY KEY (purchase_id, item_id)
);

/*
 Association between products and the item(only bundle) to which they belong
 */
CREATE TABLE item_product (
                              item_id         INTEGER             NOT NULL REFERENCES items (id) ON UPDATE CASCADE ON DELETE CASCADE,
                              product_id      INTEGER             NOT NULL REFERENCES products (id) ON UPDATE CASCADE ON DELETE CASCADE,
                              quantity        DECIMAL             NOT NULL CHECK ( quantity > 0 ),
                              constraint      quantity_positive   CHECK ( quantity >= 0),
                              PRIMARY KEY (item_id, product_id)
);

/*
 Association between an item and its tags
 */
CREATE TABLE item_tag (
                          tag_id          INTEGER     NOT NULL REFERENCES tags (id) ON UPDATE CASCADE ON DELETE CASCADE ,
                          item_id         INTEGER     NOT NULL REFERENCES items (id) ON UPDATE CASCADE ON DELETE CASCADE ,
                          PRIMARY KEY (tag_id, item_id)
);

/*
 Association between a product and its images
 */
CREATE TABLE image_product (
                               product_id      INTEGER     REFERENCES products (id) ON UPDATE CASCADE ON DELETE CASCADE ,
                               image_id        INTEGER     REFERENCES images (id) ON UPDATE CASCADE ON DELETE CASCADE ,
                               PRIMARY KEY (product_id, image_id)
);

/*
 favorite - Association between a client and their favorite items
 */
CREATE TABLE client_item (
                             client_id       INTEGER     NOT NULL REFERENCES clients (id) ON UPDATE CASCADE ON DELETE CASCADE ,
                             item_id         INTEGER     NOT NULL REFERENCES items (id) ON UPDATE CASCADE ON DELETE SET NULL ,
                             PRIMARY KEY (client_id, item_id)
);

/*
 cart - Association between a client and their cart items
 */
CREATE TABLE carts (
                       client_id       INTEGER     NOT NULL REFERENCES clients (id) ON UPDATE CASCADE ON DELETE CASCADE ,
                       item_id         INTEGER     NOT NULL REFERENCES items (id) ON UPDATE CASCADE ON DELETE SET NULL ,
                       quantity        DECIMAL     NOT NULL,
                       PRIMARY KEY (client_id, item_id)
);


-----------------------------------------
-- MATERIALIZED VIEWS
-----------------------------------------

CREATE MATERIALIZED VIEW fts_view_weights AS
SELECT items.id                                               as items_id,
       string_agg(value, ' ')                                 as tags,
       suppliers.id                                           as suppliers_id,
       (setweight(to_tsvector('simple', items.name), 'A') ||
        setweight(to_tsvector('simple', string_agg(value, ' ')), 'C') ||
        setweight(to_tsvector('simple', suppliers.name), 'B')
           ) as text_search
FROM items
         JOIN item_tag ON (items.id = item_tag.item_id)
         JOIN tags ON (item_tag.tag_id = tags.id)
         JOIN suppliers ON (items.supplier_id = suppliers.id)
GROUP BY items_id, suppliers_id
ORDER BY items_id;


-----------------------------------------
-- INDEXES
-----------------------------------------

CREATE INDEX favorite_client        ON client_item      USING hash (client_id);

CREATE INDEX credit_card_client     ON credit_cards     USING hash (client_id);

CREATE INDEX search_weight_idx      ON fts_view_weights USING GIST (text_search);

CREATE INDEX search_product_idx     ON items            USING GIST (search);

CREATE INDEX search_supplier_idx    ON suppliers        USING GIST (search);

CREATE INDEX search_tag_idx         ON tags             USING GIST (search);

-----------------------------------------
-- TRIGGERS and UDFs
-----------------------------------------

CREATE OR REPLACE FUNCTION expired_coupon() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS
        (SELECT *
         FROM coupons
         WHERE expiration = now())
    THEN
        DELETE FROM coupons
        WHERE id = OLD.id;
    END IF;
    RETURN NEW;
END
$BODY$
    LANGUAGE plpgsql;

CREATE TRIGGER expired_coupon
    BEFORE INSERT OR UPDATE ON coupons
    FOR EACH ROW
EXECUTE PROCEDURE expired_coupon();



CREATE OR REPLACE FUNCTION inactive_item() RETURNS TRIGGER AS
$BODY$
BEGIN

    IF EXISTS
        (SELECT *
         FROM items, suppliers
         WHERE items.supplier_id = suppliers.id)
    THEN
        UPDATE items
        SET active = FALSE
        WHERE id = OLD.id;
    END IF;
    RETURN NEW;

END
$BODY$
    LANGUAGE plpgsql;

CREATE TRIGGER inactive_item
    BEFORE DELETE ON suppliers
    FOR EACH ROW
EXECUTE PROCEDURE inactive_item();



CREATE OR REPLACE FUNCTION update_rating() RETURNS TRIGGER AS
$BODY$
BEGIN

    UPDATE items
    SET rating = (SELECT AVG(reviews.rating) FROM reviews WHERE reviews.item_id = NEW.item_id)
    WHERE items.id = NEW.item_id;
    RETURN NULL;

END
$BODY$
    LANGUAGE plpgsql;

CREATE TRIGGER update_rating
    AFTER INSERT OR UPDATE ON reviews
    FOR EACH ROW
EXECUTE PROCEDURE update_rating();



CREATE OR REPLACE FUNCTION item_review() RETURNS TRIGGER AS
$BODY$
BEGIN

    IF NOT EXISTS
        (SELECT * FROM item_purchase, purchases
         WHERE NEW.client_id = purchases.client_id
           AND item_purchase.purchase_id = purchases.id
           AND item_purchase.item_id = NEW.item_id)
    THEN
        RAISE EXCEPTION
            'A client cannot leave a review on a not purchased item: id_client: % | id_item: %', NEW.client_id, NEW.item_id;
    END IF;
    RETURN NEW;

END
$BODY$
    LANGUAGE plpgsql;

CREATE TRIGGER item_review
    BEFORE INSERT OR UPDATE ON reviews
    FOR EACH ROW
EXECUTE PROCEDURE item_review();

CREATE OR REPLACE FUNCTION search_update() RETURNS TRIGGER AS
$BODY$
BEGIN
    REFRESH MATERIALIZED VIEW fts_view_weights;
    RETURN NULL;
END
$BODY$
    LANGUAGE plpgsql;

CREATE TRIGGER item_tag_search_update
    AFTER INSERT OR UPDATE ON item_tag
    FOR EACH ROW
EXECUTE PROCEDURE search_update();



CREATE OR REPLACE FUNCTION supplier_search_update() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF TG_OP = 'INSERT'
    THEN
        NEW.search = setweight(to_tsvector('english', NEW.name), 'B');
        -- || setweight(to_tsvector('english', NEW.description), 'C');
    END IF;

    IF TG_OP = 'UPDATE'
    THEN
        IF NEW.name <> OLD.name
        THEN
            NEW.search = setweight(to_tsvector('english', NEW.name), 'B');
            -- || setweight(to_tsvector('english', NEW.description), 'C');
        END IF;
    END IF;
    REFRESH MATERIALIZED VIEW fts_view_weights;
    RETURN NEW;

END
$BODY$
    LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION item_search_update() RETURNS TRIGGER AS
$BODY$
BEGIN

    IF TG_OP = 'INSERT' THEN
        NEW.search = setweight(to_tsvector('english', NEW.name), 'A');
    END IF;

    IF TG_OP = 'UPDATE'
    THEN
        IF NEW.name <> OLD.name
        THEN
            NEW.search = setweight(to_tsvector('english', new.name),'A');
        END IF;
    END IF;
    REFRESH MATERIALIZED VIEW fts_view_weights;
    RETURN NEW;

END
$BODY$
    LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION tag_search_update() RETURNS TRIGGER AS
$BODY$
BEGIN

    IF TG_OP = 'INSERT'
    THEN
        NEW.search = setweight(to_tsvector('english', NEW.value),'C');
    END IF;

    IF TG_OP = 'UPDATE'
    THEN
        IF NEW.name <> OLD.name
        THEN
            NEW.search = setweight(to_tsvector('english', NEW.value),'C');
        END IF;
    END IF;
    REFRESH MATERIALIZED VIEW fts_view_weights;
    RETURN NEW;

END
$BODY$
    LANGUAGE plpgsql;



CREATE TRIGGER supplier_search_update
    BEFORE INSERT OR UPDATE ON suppliers
    FOR EACH ROW
EXECUTE PROCEDURE supplier_search_update();

CREATE TRIGGER item_search_update
    BEFORE INSERT OR UPDATE ON items
    FOR EACH ROW
EXECUTE PROCEDURE item_search_update();

CREATE TRIGGER tag_search_update
    BEFORE INSERT OR UPDATE ON tags
    FOR EACH ROW
EXECUTE PROCEDURE tag_search_update();
