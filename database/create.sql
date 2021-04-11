DROP TABLE IF EXISTS image              CASCADE;
DROP TABLE IF EXISTS credit_card        CASCADE;
DROP TABLE IF EXISTS tag                CASCADE;
DROP TABLE IF EXISTS shopper            CASCADE; -- previously user
DROP TABLE IF EXISTS client             CASCADE;
DROP TABLE IF EXISTS supplier           CASCADE;
DROP TABLE IF EXISTS purchase           CASCADE;
DROP TABLE IF EXISTS item               CASCADE;
DROP TABLE IF EXISTS coupon             CASCADE;
DROP TABLE IF EXISTS product            CASCADE;
DROP TABLE IF EXISTS ship_detail        CASCADE;
DROP TABLE IF EXISTS review             CASCADE;
DROP TABLE IF EXISTS item_info          CASCADE;
DROP TABLE IF EXISTS bundle_product     CASCADE;
DROP TABLE IF EXISTS tag_item           CASCADE;
DROP TABLE IF EXISTS product_image      CASCADE;
DROP TABLE IF EXISTS favorite           CASCADE;
DROP TABLE IF EXISTS cart               CASCADE;

DROP MATERIALIZED VIEW IF EXISTS fts_view_weights;
DROP MATERIALIZED VIEW IF EXISTS fts_view;

DROP TYPE IF EXISTS unit_type           CASCADE;
DROP TYPE IF EXISTS coupon_type         CASCADE;
DROP TYPE IF EXISTS purchase_type       CASCADE;

DROP FUNCTION IF EXISTS expired_coupon;
DROP FUNCTION IF EXISTS inactive_item;
DROP FUNCTION IF EXISTS post_supplier_search_update;
DROP FUNCTION IF EXISTS post_item_search_update;
DROP FUNCTION IF EXISTS post_tag_search_update;
DROP FUNCTION IF EXISTS update_rating;
DROP FUNCTION IF EXISTS item_review;

-- Types
CREATE TYPE unit_type       AS ENUM ('Kg', 'Un');
CREATE TYPE coupon_type     AS ENUM ('%', '€');
CREATE TYPE purchase_type   AS ENUM ('SingleBuy', 'Day', 'Week', 'Month');

-- Tables
CREATE TABLE image (
    image_id    SERIAL      PRIMARY KEY,
    path        TEXT        NOT NULL
);

CREATE TABLE tag (
    tag_id          SERIAL      PRIMARY KEY,
    value           text        NOT NULL
);

CREATE TABLE shopper (
    shopper_id      SERIAL      PRIMARY KEY,
    email           TEXT        NOT NULL CONSTRAINT user_email_uk UNIQUE,
    password        TEXT        NOT NULL,
    is_admin        boolean     NOT NULL
);

CREATE TABLE client (
    client_id       INTEGER     NOT NULL REFERENCES shopper (shopper_id) ON UPDATE CASCADE,
    name            TEXT        NOT NULL,
    id_image        INTEGER     NOT NULL DEFAULT 1 REFERENCES image (image_id) ON UPDATE CASCADE,
    PRIMARY KEY (client_id)
);

CREATE TABLE supplier (
    supplier_id     INTEGER     NOT NULL REFERENCES shopper (shopper_id) ON UPDATE CASCADE,
    name            TEXT        NOT NULL,
    address         TEXT        NOT NULL,
    post_code       TEXT        NOT NULL,
    city            TEXT        NOT NULL,
    description     TEXT        NOT NULL,
    accepted        BOOLEAN     NOT NULL,
    id_image        INTEGER     NOT NULL DEFAULT 1 REFERENCES image (image_id) ON UPDATE CASCADE,
    PRIMARY KEY (supplier_id)
);

CREATE TABLE purchase (
    purchase_id     SERIAL              PRIMARY KEY,
    id_client       INTEGER             NOT NULL REFERENCES client (client_id),
    amount          DECIMAL             NOT NULL,
    purchase_date   DATE                NOT NULL,
    type            purchase_type       NOT NULL,
    CONSTRAINT      amount_positive_ck  CHECK (amount > 0),
    CONSTRAINT      old_date_ck         CHECK (purchase_date <= CURRENT_DATE)
);

-- BusinessRule: Item either is a bundle, or a product, can't have is_bundle true and be referenced in product
CREATE TABLE item (
    item_id         SERIAL                  PRIMARY KEY,
    id_supplier     INTEGER                 NOT NULL REFERENCES supplier (supplier_id),
    name            TEXT                    NOT NULL,
    price           DECIMAL                 NOT NULL,
    stock           DECIMAL                 NOT NULL,
    description     TEXT                    NOT NULL,
    active          BOOLEAN                 NOT NULL,
    rating          DECIMAL,
    is_bundle       BOOLEAN                 NOT NULL,
    CONSTRAINT      price_positive_ck       CHECK (price > 0),
    CONSTRAINT      stock_not_negative_ck   CHECK (stock >= 0)
);

CREATE TABLE coupon (
    coupon_id       SERIAL          PRIMARY KEY,
    code            TEXT            NOT NULL UNIQUE,
    name            TEXT            NOT NULL,
    description     TEXT            NOT NULL,
    expiration      DATE            NOT NULL CHECK (expiration > now()),
    type            coupon_type     NOT NULL,
    amount          DECIMAL         NOT NULL CHECK (amount > 0),
    id_supplier     INTEGER         NOT NULL REFERENCES supplier(supplier_id)
);

CREATE TABLE product (
    product_id      INTEGER     PRIMARY KEY REFERENCES item (item_id) ON UPDATE CASCADE,
    type            unit_type   NOT NULL
);

CREATE TABLE ship_detail (
    ship_det_id     SERIAL      PRIMARY KEY,
    first_name      TEXT        NOT NULL,
    last_name       TEXT        NOT NULL,
    address         TEXT        NOT NULL,
    door_n          INTEGER     NOT NULL,
    post_code       TEXT        NOT NULL,
    district        TEXT        NOT NULL,
    city            TEXT        NOT NULL,
    country         TEXT        NOT NULL,
    phone_n         TEXT        NOT NULL,
    id_client       INTEGER     NOT NULL REFERENCES client(client_id)
);

CREATE TABLE credit_card (
    cc_id           SERIAL      PRIMARY KEY,
    card_n          text        NOT NULL,
    expiration      DATE        NOT NULL,
    cvv             INTEGER     NOT NULL,
    holder          TEXT        NOT NULL,
    id_client       INTEGER     NOT NULL REFERENCES client(client_id)
);

CREATE TABLE review (
    id_client       INTEGER     NOT NULL REFERENCES client (client_id) ON UPDATE CASCADE,
    id_item         INTEGER     NOT NULL REFERENCES item (item_id) ON UPDATE CASCADE,
    rating          INTEGER     NOT NULL,
    description     TEXT        NOT NULL,
    CONSTRAINT      rating_ck   CHECK (rating >= 1 AND rating <= 5),
    PRIMARY KEY (id_client, id_item)
);

CREATE TABLE item_info (
    id_purchase     INTEGER     NOT NULL REFERENCES purchase (purchase_id),
    id_item         INTEGER     NOT NULL REFERENCES item (item_id),
    price           DECIMAL,
    amount          DECIMAL,
    PRIMARY KEY (id_purchase, id_item)
);

CREATE TABLE bundle_product (
    id_bundle       INTEGER             NOT NULL REFERENCES item(item_id),
    id_product      INTEGER             NOT NULL REFERENCES product(product_id),
    quantity        DECIMAL             NOT NULL,
    constraint      quantity_positive   check (quantity >= 0),
    PRIMARY KEY (id_bundle, id_product)
);


CREATE TABLE tag_item (
    id_tag          INTEGER     NOT NULL REFERENCES tag (tag_id) ON UPDATE CASCADE,
    id_item         INTEGER     NOT NULL REFERENCES item (item_id) ON UPDATE CASCADE,
    PRIMARY KEY (id_tag, id_item)
);

CREATE TABLE product_image (
    id_product      INTEGER     REFERENCES product (product_id) ON UPDATE CASCADE,
    id_image        INTEGER     REFERENCES image (image_id) ON UPDATE CASCADE,
    PRIMARY KEY (id_product, id_image)
);

CREATE TABLE favorite (
    id_client       INTEGER     NOT NULL REFERENCES client (client_id) ON UPDATE CASCADE,
    id_item         INTEGER     NOT NULL REFERENCES item (item_id) ON UPDATE CASCADE,
    PRIMARY KEY (id_client, id_item)
);

CREATE TABLE cart (
    id_client       INTEGER     NOT NULL REFERENCES client (client_id) ON UPDATE CASCADE,
    id_item         INTEGER     NOT NULL REFERENCES item (item_id) ON UPDATE CASCADE,
    quantity        DECIMAL     NOT NULL,
    PRIMARY KEY (id_client, id_item)
);


-----------------------------------------
-- MATERIALIZED VIEWS
-----------------------------------------

CREATE MATERIALIZED VIEW fts_view_weights AS
SELECT item.item_id                                           as item_id,
       item.name                                              as item_name,
       string_agg(value, ' ')                                 as tags,
       supplier.name                                          as supplier_name,
       (setweight(to_tsvector('simple', item.name), 'A') ||
        setweight(to_tsvector('simple', string_agg(value, ' ')), 'C') ||
        setweight(to_tsvector('simple', supplier.name), 'B')) as "search"
FROM item
         JOIN tag_item ON (item.item_id = tag_item.id_item)
         JOIN tag ON (tag_item.id_tag = tag.tag_id)
         JOIN supplier ON (item.id_supplier = supplier.supplier_id)
GROUP BY item_id, supplier_name
ORDER BY item.item_id;


DROP MATERIALIZED VIEW IF EXISTS fts_view;
CREATE MATERIALIZED VIEW fts_view AS
SELECT item.item_id           as item_id,
       item.name              as item_name,
       string_agg(value, ' ') as tags,
       supplier.name          as supplier_name,
       to_tsvector(
               'simple', item.name || ' ' ||
                string_agg(value, ' ') || ' ' ||
                supplier.name
           )                  as "search"
FROM item
         JOIN tag_item ON (item.item_id = tag_item.id_item)
         JOIN tag ON (tag_item.id_tag = tag.tag_id)
         JOIN supplier ON (item.id_supplier = supplier.supplier_id)
GROUP BY item_id, supplier_name
ORDER BY item.item_id;

-----------------------------------------
-- INDEXES
-----------------------------------------

CREATE INDEX favorite_client        ON favorite         USING hash (id_client);

CREATE INDEX credit_card_client     ON credit_card      USING hash (id_client);

CREATE INDEX search_weight_idx      ON fts_view_weights USING GIST (search);

CREATE INDEX search_idx             ON fts_view         USING GIST (search);

-----------------------------------------
-- TRIGGERS and UDFs
-----------------------------------------

CREATE OR REPLACE FUNCTION expired_coupon() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF EXISTS
        (SELECT *
        FROM coupon
        WHERE expiration = now())
    THEN
        DELETE FROM coupon
        WHERE coupon_id = OLD.coupon_id;
    END IF;
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER expired_coupon
    BEFORE INSERT OR UPDATE ON coupon
    FOR EACH ROW
    EXECUTE PROCEDURE expired_coupon();



CREATE OR REPLACE FUNCTION inactive_item() RETURNS TRIGGER AS
$BODY$
BEGIN

    IF EXISTS
        (SELECT *
        FROM item, supplier
        WHERE item.id_supplier = supplier.supplier_id)
    THEN
        UPDATE item
        SET active = FALSE
        WHERE supplier_id = OLD.supplier_id;
    END IF;
    RETURN NEW;

END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER inactive_item
    BEFORE DELETE ON supplier
    FOR EACH ROW
    EXECUTE PROCEDURE inactive_item();



CREATE OR REPLACE FUNCTION search_update() RETURNS TRIGGER AS
$BODY$
BEGIN
    REFRESH MATERIALIZED VIEW fts_view;
    RETURN NULL;
END
$BODY$
LANGUAGE plpgsql;

-- On Populate, triggers to many times, need to check this

CREATE TRIGGER supplier_search_update
    BEFORE INSERT OR UPDATE ON supplier
EXECUTE PROCEDURE search_update();
CREATE TRIGGER item_search_update
    BEFORE INSERT OR UPDATE ON item
EXECUTE PROCEDURE search_update();
CREATE TRIGGER tag_search_update
    BEFORE INSERT OR UPDATE ON tag
EXECUTE PROCEDURE search_update();
CREATE TRIGGER tag_item_search_update
    BEFORE INSERT OR UPDATE ON tag_item
EXECUTE PROCEDURE search_update();



CREATE OR REPLACE FUNCTION update_rating() RETURNS TRIGGER AS
$BODY$
BEGIN

    Update item
    SET rating = (SELECT AVG(review.rating) FROM review WHERE review.id_item = NEW.id_item)
    WHERE item.item_id = NEW.id_item;
    RETURN NEW;

END
$BODY$
    LANGUAGE plpgsql;

CREATE TRIGGER update_rating
    AFTER INSERT OR UPDATE ON review
    FOR EACH STATEMENT
EXECUTE PROCEDURE update_rating();



CREATE OR REPLACE FUNCTION item_review() RETURNS TRIGGER AS
$BODY$
BEGIN

    IF NOT EXISTS
        (SELECT * FROM item_info, purchase
         WHERE NEW.id_client = purchase.id_client
           AND item_info.id_purchase = purchase.purchase_id
           AND item_info.id_item = NEW.id_item)
    THEN
        RAISE EXCEPTION
            'A client cannot leave a review on a not purchased item: id_client: % | id_item: %', NEW.id_client, NEW.id_item;
    END IF;
    RETURN NEW;

END
$BODY$
    LANGUAGE plpgsql;

CREATE TRIGGER item_review
    BEFORE INSERT OR UPDATE ON review
    FOR EACH ROW
EXECUTE PROCEDURE item_review();
