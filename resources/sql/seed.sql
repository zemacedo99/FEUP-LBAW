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
DROP TABLE IF EXISTS password_resets    CASCADE;

DROP MATERIALIZED VIEW IF EXISTS fts_view_weights;

DROP TYPE IF EXISTS unit_type           CASCADE;
DROP TYPE IF EXISTS coupon_type         CASCADE;
DROP TYPE IF EXISTS purchase_type       CASCADE;
DROP TYPE IF EXISTS purchase_status     CASCADE;


DROP INDEX IF EXISTS favorite_client                CASCADE;
DROP INDEX IF EXISTS credit_card_client             CASCADE;
DROP INDEX IF EXISTS search_weight_idx              CASCADE;
DROP INDEX IF EXISTS search_product_idx             CASCADE;
DROP INDEX IF EXISTS search_supplier_idx            CASCADE;
DROP INDEX IF EXISTS search_tag_idx                 CASCADE;
DROP INDEX IF EXISTS password_resets_email_index    CASCADE;
DROP INDEX IF EXISTS password_resets_token_index    CASCADE;

DROP FUNCTION IF EXISTS expired_coupon          CASCADE;
DROP FUNCTION IF EXISTS inactive_item           CASCADE;
DROP FUNCTION IF EXISTS update_rating           CASCADE;
DROP FUNCTION IF EXISTS item_review             CASCADE;
DROP FUNCTION IF EXISTS search_update           CASCADE;
DROP FUNCTION IF EXISTS supplier_search_update  CASCADE;
DROP FUNCTION IF EXISTS item_search_update      CASCADE;
DROP FUNCTION IF EXISTS tag_search_update       CASCADE;
DROP FUNCTION IF EXISTS client_search_update    CASCADE;


-- Types
CREATE TYPE unit_type           AS ENUM ('Kg', 'Un');
CREATE TYPE coupon_type         AS ENUM ('%', '€');
CREATE TYPE purchase_type       AS ENUM ('SingleBuy', 'Day', 'Week', 'Month');
CREATE TYPE purchase_status     AS ENUM ('InProgress', 'Canceled', 'Paid');

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
    is_admin        boolean     NOT NULL DEFAULT 'false',
    remember_token  VARCHAR     DEFAULT NULL
);

CREATE TABLE clients (
    id              INTEGER     NOT NULL REFERENCES "users" (id) ON UPDATE CASCADE ON DELETE CASCADE,
    name            TEXT        NOT NULL,
    image_id        INTEGER     NOT NULL DEFAULT 1 REFERENCES images (id) ON UPDATE CASCADE ON DELETE SET DEFAULT,
    search          tsvector    DEFAULT '' NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE suppliers (
    id              INTEGER     NOT NULL REFERENCES "users" (id) ON UPDATE CASCADE ON DELETE CASCADE,
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
    CONSTRAINT      amount_positive_ck  CHECK (paid > 0),
    status          purchase_status     NOT NULL DEFAULT 'Paid'
    -- CONSTRAINT      old_date_ck         CHECK (purchase_date <= CURRENT_DATE)
);

-- BusinessRule: Item either is a bundle, or a product, can't have is_bundle true and be referenced in product
CREATE TABLE items (
    id              SERIAL                  PRIMARY KEY,
    supplier_id     INTEGER                 DEFAULT 0 REFERENCES suppliers (id) ON UPDATE CASCADE ON DELETE SET DEFAULT ,--0 is the deleted supplier
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
    supplier_id     INTEGER         DEFAULT 0 REFERENCES suppliers (id) ON UPDATE CASCADE ON DELETE SET DEFAULT
);

CREATE TABLE products (
    id              INTEGER     PRIMARY KEY REFERENCES items (id) ON UPDATE CASCADE ON DELETE CASCADE ,
    unit            unit_type   NOT NULL
);


CREATE TABLE reviews (
    id              SERIAL      PRIMARY KEY,
    client_id       INTEGER     NOT NULL REFERENCES clients (id) ON UPDATE CASCADE ON DELETE CASCADE,
    item_id         INTEGER     NOT NULL REFERENCES items (id) ON UPDATE CASCADE ON DELETE NO ACTION,
    rating          INTEGER     NOT NULL,
    description     TEXT        NOT NULL,
    CONSTRAINT      rating_ck   CHECK (rating >= 1 AND rating <= 5)
);

CREATE TABLE temp_purchases(
    id              SERIAL              PRIMARY KEY,
    client_id       INTEGER             NOT NULL REFERENCES clients (id) ON UPDATE CASCADE ON DELETE CASCADE,
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

CREATE TABLE password_resets
(
    email      VARCHAR NOT NULL,
    token      VARCHAR NOT NULL,
    created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL
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

CREATE INDEX favorite_client                ON client_item      USING hash (client_id);

CREATE INDEX credit_card_client             ON credit_cards     USING hash (client_id);

CREATE INDEX search_weight_idx              ON fts_view_weights USING GIST (text_search);

CREATE INDEX search_product_idx             ON items            USING GIST (search);

CREATE INDEX search_supplier_idx            ON suppliers        USING GIST (search);

CREATE INDEX search_tag_idx                 ON tags             USING GIST (search);

CREATE INDEX password_resets_email_index    ON password_resets (email);

CREATE index password_resets_token_index    ON password_resets (token);
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
$inactive_item$
BEGIN

        UPDATE items
        SET active = FALSE
        WHERE supplier_id = 0;
    
    RETURN NEW;

END
$inactive_item$
    LANGUAGE plpgsql;

CREATE TRIGGER inactive_item
    AFTER DELETE ON suppliers
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

CREATE OR REPLACE FUNCTION client_search_update() RETURNS TRIGGER AS
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

CREATE TRIGGER client_search_update
    BEFORE INSERT OR UPDATE ON clients
    FOR EACH ROW
EXECUTE PROCEDURE client_search_update();

insert into images (path) values ('storage/users/avatar.png');
insert into images (path) values ('storage/products/bundle.jpg');
insert into images (path) values ('storage/products/apple_test.jpg');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/blueberry_test.jpg');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/kiwi_test.jpg');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/dragonfruit_test.jpg');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
insert into images (path) values ('storage/products/fruit_test.png');
-- Branch Ricardo
-- insert into images (path) values ('mZDX2ocLoxUpvveqxpTUrbf0LhmTmZhW4v69FUwb.png');
-- insert into images (path) values ('otap071yo9zJOzlhOLXJsgtvxAmlG0D5SkwfJzOJ.jpg');


insert into tags (value) values ('strategy');
insert into tags (value) values ('well-modulated');
insert into tags (value) values ('hardware');
insert into tags (value) values ('multi-layered');
insert into tags (value) values ('access');
insert into tags (value) values ('upward-trending');
insert into tags (value) values ('Distributed');
insert into tags (value) values ('synergy');
insert into tags (value) values ('leverage');
insert into tags (value) values ('secured');
insert into tags (value) values ('non-volatile');
insert into tags (value) values ('groupware');
insert into tags (value) values ('didatic');
insert into tags (value) values ('didactic');
insert into tags (value) values ('Polarised');
insert into tags (value) values ('process');
insert into tags (value) values ('Synergistic');
insert into tags (value) values ('set');
insert into tags (value) values ('cohesive');
insert into tags (value) values ('model');
insert into tags (value) values ('grid-enabled');
insert into tags (value) values ('organic');
insert into tags (value) values ('line');
insert into tags (value) values ('challenge');
insert into tags (value) values ('Organic');
insert into tags (value) values ('volatile');
insert into tags (value) values ('radical');
insert into tags (value) values ('intranet');
insert into tags (value) values ('local');
insert into tags (value) values ('Optimized');
insert into tags (value) values ('area');
insert into tags (value) values ('generations');
insert into tags (value) values ('help-desk');
insert into tags (value) values ('intermediate');
insert into tags (value) values ('Progressive');
insert into tags (value) values ('Compatible');
insert into tags (value) values ('toolshop');
insert into tags (value) values ('annealing');
insert into tags (value) values ('pertruding');
insert into tags (value) values ('tangible');
insert into tags (value) values ('transitional');
insert into tags (value) values ('Triple-buffered');
insert into tags (value) values ('Cross-platform');
insert into tags (value) values ('Ameliorated');
insert into tags (value) values ('Devolved');
insert into tags (value) values ('Enterprise-wide');
insert into tags (value) values ('toolset');
insert into tags (value) values ('runway');
insert into tags (value) values ('Customizable');
insert into tags (value) values ('bye-desk');
insert into tags (value) values ('leveraging');
insert into tags (value) values ('integrated');
insert into tags (value) values ('Focused');
insert into tags (value) values ('hour');
insert into tags (value) values ('generation');
insert into tags (value) values ('Exclusive');
insert into tags (value) values ('circuit');
insert into tags (value) values ('clear-thinking');
insert into tags (value) values ('foreground');
insert into tags (value) values ('software');
insert into tags (value) values ('Optional');
insert into tags (value) values ('analyzing');
insert into tags (value) values ('exported');
insert into tags (value) values ('distributing');
insert into tags (value) values ('Programmable');
insert into tags (value) values ('heuristic');
insert into tags (value) values ('bad_modulated');
insert into tags (value) values ('attitude-oriented');
insert into tags (value) values ('utilisation');
insert into tags (value) values ('Fundamental');
insert into tags (value) values ('fresh-thinking');
insert into tags (value) values ('matrix');
insert into tags (value) values ('moratorium');
insert into tags (value) values ('exuding');
insert into tags (value) values ('middleware');
insert into tags (value) values ('leveragated');
insert into tags (value) values ('User');
insert into tags (value) values ('Innovative');
insert into tags (value) values ('disintermediate');
insert into tags (value) values ('array');
insert into tags (value) values ('Automated');
insert into tags (value) values ('zero tolerance');
insert into tags (value) values ('projection');
insert into tags (value) values ('Balanced');
insert into tags (value) values ('dirt');
insert into tags (value) values ('Down-sized');
insert into tags (value) values ('task-force');
insert into tags (value) values ('improvement');
insert into tags (value) values ('solution');
insert into tags (value) values ('needs-based');
insert into tags (value) values ('leading edge');
insert into tags (value) values ('support');
insert into tags (value) values ('functionalities');
insert into tags (value) values ('Robust');
insert into tags (value) values ('modular');
insert into tags (value) values ('value-added');
insert into tags (value) values ('firmware');
insert into tags (value) values ('attitude');
insert into tags (value) values ('ability');
insert into tags (value) values ('Graphical');

-- password is "1234" for everyone
insert into "users" (id, email, password, is_admin) values (0,'DELETEDCOSTUMER', 'DELETEDCOSTUMER', 'false');
insert into "users" (email, password, is_admin) values ('bshovelbottom0@storify.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('rwhitley1@vistaprint.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('kcantle2@answers.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('tromaint3@livejournal.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('btambling4@guardian.co.uk', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('jpoytheras5@fotki.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('pwilcockes6@irs.gov', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('grameau7@state.tx.us', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('mforseith8@ihg.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('mfuentes9@twitter.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('bbrindleya@paypal.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('flandisb@acquirethisname.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('ebrigdalec@tripod.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('ahennemannd@soup.io', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('gdoggarte@topsy.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('jgoshawkf@squarespace.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('lmanachg@sciencedaily.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('lcazaleth@google.com.br', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('ameindli@netscape.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('aandragj@vimeo.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('aedowesk@php.net', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('devel@opensource.org', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('bverduinm@theguardian.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('sfilern@technorati.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('klaingo@wp.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('kupjohnp@answers.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('jwardaleq@discuz.net', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('mcaseyr@bing.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('aheyburns@mapquest.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('mtabardt@technorati.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('dramstedu@ucsd.edu', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('llufkinv@live.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('ocaddw@cisco.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('tmecchix@ebay.co.uk', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('mashey@gnu.org', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('zmackintoshz@seesaa.net', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('sglennie10@google.nl', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('cgiffkins11@ifeng.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('marington12@w3.org', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('kcorssen13@smh.com.au', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('dpilipets14@goo.gl', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('fcogin15@ucsd.edu', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('hsowrah16@free.fr', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('salforde17@unicef.org', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('lshorton18@prnewswire.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('akikke19@eepurl.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('ceddis1a@bluehost.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('acasseldine1b@usatoday.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('mwoodburne1c@fastcompany.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('fscholer1d@fastcompany.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('lyendle1e@theglobeandmail.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('ckirdsch1f@independent.co.uk', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('fdeppen1g@hhs.gov', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('malleyne1h@t.co', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('etremonte1i@clickbank.net', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('vcaley1j@icq.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('mvertey1k@umn.edu', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('efinkle1l@prlog.org', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('nmosby1m@google.it', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('ibow1n@ibm.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('achasen1o@ucla.edu', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('rmclaughlan1p@zimbio.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('glancetter1q@google.fr', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('gclempton1r@ox.ac.uk', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('bstopher1s@cpanel.net', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('kbacon1t@apache.org', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('cstodhart1u@nytimes.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('abeattie1v@economist.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('cdron1w@gnu.org', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('hcastillou1x@amazonaws.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('rcains1y@businessinsider.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('fmartynikhin1z@moonfruit.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('kmaplesden20@wordpress.org', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('kshorton21@dailymail.co.uk', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('jsimoncello22@soundcloud.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'false');
insert into "users" (email, password, is_admin) values ('admin1@admin.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'true');
insert into "users" (email, password, is_admin) values ('admin2@admin.com', '$2a$10$S2oxDuxIi60Xcq5fj/S7g.vyaE29mWlqnp6.F43kVNXUTuoT5wmiW', 'true');

insert into clients (id, name, image_id) values (1, 'Eudora Jencken', 1);
insert into clients (id, name, image_id) values (2, 'Marcos Lambdon', 1);
insert into clients (id, name, image_id) values (3, 'Rennie Bartoshevich', 1);
insert into clients (id, name, image_id) values (4, 'Wenona Bearblock', 1);
insert into clients (id, name, image_id) values (5, 'Gene Coddrington', 1);
insert into clients (id, name, image_id) values (6, 'Artus Siberry', 1);
insert into clients (id, name, image_id) values (7, 'Helenelizabeth Rappoport', 1);
insert into clients (id, name, image_id) values (8, 'Mord Bewshire', 1);
insert into clients (id, name, image_id) values (9, 'Pattin Dyton', 1);
insert into clients (id, name, image_id) values (10, 'Lauren Kubica', 1);
insert into clients (id, name, image_id) values (11, 'Will Bonifazio', 1);
insert into clients (id, name, image_id) values (12, 'Aluino Ding', 1);
insert into clients (id, name, image_id) values (13, 'Jess Scourfield', 1);
insert into clients (id, name, image_id) values (14, 'Warde Kordovani', 1);
insert into clients (id, name, image_id) values (15, 'Gare Hyatt', 1);
insert into clients (id, name, image_id) values (16, 'Josey Carnew', 1);
insert into clients (id, name, image_id) values (17, 'Robin Challicombe', 1);
insert into clients (id, name, image_id) values (18, 'Fanchon Jodkowski', 1);
insert into clients (id, name, image_id) values (19, 'Moreen Keppin', 1);
insert into clients (id, name, image_id) values (20, 'Carol Rouchy', 1);
insert into clients (id, name, image_id) values (21, 'Jefferson Musterd', 1);
insert into clients (id, name, image_id) values (22, 'Maren Luno', 1);
insert into clients (id, name, image_id) values (23, 'Joela Sammars', 1);
insert into clients (id, name, image_id) values (24, 'Penelopa Brooksbie', 1);
insert into clients (id, name, image_id) values (25, 'Hamel Hawford', 1);
insert into clients (id, name, image_id) values (26, 'Kaylil Pevsner', 1);
insert into clients (id, name, image_id) values (27, 'Colet Carayol', 1);
insert into clients (id, name, image_id) values (28, 'Lanni Warwicker', 1);
insert into clients (id, name, image_id) values (29, 'Reece Beentjes', 1);
insert into clients (id, name, image_id) values (30, 'Wilek Sharrem', 1);
insert into clients (id, name, image_id) values (31, 'Willie Macci', 1);
insert into clients (id, name, image_id) values (32, 'Gaven Thorald', 1);
insert into clients (id, name, image_id) values (33, 'Corney Pywell', 1);
insert into clients (id, name, image_id) values (34, 'Diane Buttfield', 1);
insert into clients (id, name, image_id) values (35, 'Goldarina Kinleyside', 1);
insert into clients (id, name, image_id) values (36, 'Jdavie Plaistowe', 1);
insert into clients (id, name, image_id) values (37, 'La verne Wince', 1);
insert into clients (id, name, image_id) values (38, 'Walker Antoniewski', 1);
insert into clients (id, name, image_id) values (39, 'Matt Lukehurst', 1);
insert into clients (id, name, image_id) values (40, 'Dene Hallowell', 1);
insert into clients (id, name, image_id) values (41, 'Romain Birtwisle', 1);
insert into clients (id, name, image_id) values (42, 'Ruggiero Eayres', 1);
insert into clients (id, name, image_id) values (43, 'Sergio Pinke', 1);
insert into clients (id, name, image_id) values (44, 'Gypsy Yven', 1);
insert into clients (id, name, image_id) values (45, 'Muffin Bantham', 1);
insert into clients (id, name, image_id) values (46, 'Ulrick Grayley', 1);
insert into clients (id, name, image_id) values (47, 'Mortie Durrant', 1);
insert into clients (id, name, image_id) values (48, 'Rolland Whitbread', 1);
insert into clients (id, name, image_id) values (49, 'Samantha Woolaghan', 1);
insert into clients (id, name, image_id) values (50, 'Scott Sansbury', 1);

insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (0, 'Deleted Supplier', 'Deleted supplier', '0000-000', 'Deleted', 'Deleted supplier', false, 1);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (51, 'BlackBerry Limited', '9428 Manley Hill', '7396-768', 'Veiga', 'Nam ultrices, libero non mattis pulvinar, nulla pede ullamcorper augue, a suscipit nulla elit ac nulla. Sed vel enim sit amet nunc viverra dapibus. Nulla suscipit ligula in lacus. Curabitur at ipsum ac tellus semper interdum. Mauris ullamcorper purus sit amet nulla. Quisque arcu libero, rutrum ac, lobortis vel, dapibus at, diam.', false, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (52, 'Cantel Medical Corp.', '5 Tomscot Road', '7377-528', 'Segodim', 'Phasellus sit amet erat. Nulla tempus. Vivamus in felis eu sapien cursus vestibulum. Proin eu mi. Nulla ac enim. In tempor, turpis nec euismod scelerisque, quam turpis adipiscing lorem, vitae mattis nibh ligula nec sem.', false, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (53, 'Bob Evans Farms, Inc.', '9802 Summer Ridge Place', '9764-707', 'Valada', 'Maecenas leo odio, condimentum id, luctus nec, molestie sed, justo. Pellentesque viverra pede ac diam. Cras pellentesque volutpat dui. Maecenas tristique, est et tempus semper, est quam pharetra magna, ac consequat metus sapien ut nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra diam vitae quam. Suspendisse potenti. Nullam porttitor lacus at turpis. Donec posuere metus vitae ipsum. Aliquam non mauris.', false, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (54, 'Flexsteel Industries, Inc.', '0315 Raven Park', '5374-769', 'Mosteiro', 'In congue. Etiam justo. Etiam pretium iaculis justo. In hac habitasse platea dictumst. Etiam faucibus cursus urna. Ut tellus. Nulla ut erat id mauris vulputate elementum. Nullam varius. Nulla facilisi.', true, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (55, 'Nexstar Media Group, Inc.', '65781 Truax Lane', '7607-889', 'Alcorriol', 'Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis. Fusce posuere felis sed lacus. Morbi sem mauris, laoreet ut, rhoncus aliquet, pulvinar sed, nisl. Nunc rhoncus dui vel sem. Sed sagittis. Nam congue, risus semper porta volutpat, quam pede lobortis ligula, sit amet eleifend pede libero quis orci. Nullam molestie nibh in lectus.', false, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (56, 'Bazaarvoice, Inc.', '8 Dorton Lane', '3626-435', 'Carvoeira', 'Mauris enim leo, rhoncus sed, vestibulum sit amet, cursus id, turpis. Integer aliquet, massa id lobortis convallis, tortor risus dapibus augue, vel accumsan tellus nisi eu orci. Mauris lacinia sapien quis libero. Nullam sit amet turpis elementum ligula vehicula consequat. Morbi a ipsum. Integer a nibh.', false, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (57, 'Miragen Therapeutics, Inc.', '804 Rigney Park', '7547-703', 'Sapataria', 'Duis bibendum, felis sed interdum venenatis, turpis enim blandit mi, in porttitor pede justo eu massa. Donec dapibus. Duis at velit eu est congue elementum. In hac habitasse platea dictumst. Morbi vestibulum, velit id pretium iaculis, diam erat fermentum justo, nec condimentum neque sapien placerat ante. Nulla justo. Aliquam quis turpis eget elit sodales scelerisque. Mauris sit amet eros. Suspendisse accumsan tortor quis turpis.', true, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (58, 'Corbus Pharmaceuticals Holdings, Inc.', '5 Delaware Crossing', '1102-739', 'Tentúgal', 'Maecenas tristique, est et tempus semper, est quam pharetra magna, ac consequat metus sapien ut nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra diam vitae quam. Suspendisse potenti. Nullam porttitor lacus at turpis. Donec posuere metus vitae ipsum. Aliquam non mauris. Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis.', false, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (59, 'Corporate Asset Backed Corp CABCO', '70 Doe Crossing Road', '1598-248', 'Prado', 'Nullam sit amet turpis elementum ligula vehicula consequat. Morbi a ipsum. Integer a nibh. In quis justo. Maecenas rhoncus aliquam lacus. Morbi quis tortor id nulla ultrices aliquet.', true, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (60, 'United States Cellular Corporation', '563 Spenser Pass', '9438-153', 'Terra Chã', 'In quis justo. Maecenas rhoncus aliquam lacus. Morbi quis tortor id nulla ultrices aliquet. Maecenas leo odio, condimentum id, luctus nec, molestie sed, justo. Pellentesque viverra pede ac diam. Cras pellentesque volutpat dui. Maecenas tristique, est et tempus semper, est quam pharetra magna, ac consequat metus sapien ut nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra diam vitae quam. Suspendisse potenti.', true, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (61, 'Canadian Solar Inc.', '870 Coolidge Plaza', '8517-596', 'Tabuaço', 'Sed ante. Vivamus tortor. Duis mattis egestas metus. Aenean fermentum. Donec ut mauris eget massa tempor convallis. Nulla neque libero, convallis eget, eleifend luctus, ultricies eu, nibh.', true, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (62, 'New Home Company Inc. (The)', '49 Blue Bill Park Road', '9704-818', 'Paradela', 'Curabitur gravida nisi at nibh. In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem. Integer tincidunt ante vel ipsum. Praesent blandit lacinia erat. Vestibulum sed magna at nunc commodo placerat. Praesent blandit. Nam nulla. Integer pede justo, lacinia eget, tincidunt eget, tempus vel, pede.', false, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (63, 'AXT Inc', '6 Ilene Parkway', '2546-405', 'Duas Igrejas', 'Phasellus sit amet erat. Nulla tempus. Vivamus in felis eu sapien cursus vestibulum. Proin eu mi. Nulla ac enim. In tempor, turpis nec euismod scelerisque, quam turpis adipiscing lorem, vitae mattis nibh ligula nec sem.', true, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (64, 'Melrose Bancorp, Inc.', '66572 Clarendon Point', '9269-303', 'Arcena', 'Duis aliquam convallis nunc. Proin at turpis a pede posuere nonummy. Integer non velit. Donec diam neque, vestibulum eget, vulputate ut, ultrices vel, augue. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec pharetra, magna vestibulum aliquet ultrices, erat tortor sollicitudin mi, sit amet lobortis sapien sapien non mi. Integer ac neque. Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus.', false, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (65, 'Emerge Energy Services LP', '530 Farwell Circle', '6227-858', 'Vila Verde', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Proin risus. Praesent lectus. Vestibulum quam sapien, varius ut, blandit non, interdum in, ante. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Duis faucibus accumsan odio. Curabitur convallis.', true, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (66, 'AeroVironment, Inc.', '36584 Gateway Pass', '5368-347', 'Póvoa', 'Maecenas tristique, est et tempus semper, est quam pharetra magna, ac consequat metus sapien ut nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra diam vitae quam. Suspendisse potenti.', true, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (67, 'MaxLinear, Inc', '4 Anhalt Road', '2088-936', 'Marinha', 'Cras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl. Aenean lectus. Pellentesque eget nunc. Donec quis orci eget orci vehicula condimentum.', true, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (68, 'Blackrock Municipal 2018 Term Trust', '2 Eliot Crossing', '7630-654', 'Casal das Figueiras', 'Etiam vel augue. Vestibulum rutrum rutrum neque. Aenean auctor gravida sem. Praesent id massa id nisl venenatis lacinia. Aenean sit amet justo. Morbi ut odio.', false, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (69, 'SPS Commerce, Inc.', '4807 Arrowood Place', '5506-954', 'Alvide', 'Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis. Fusce posuere felis sed lacus. Morbi sem mauris, laoreet ut, rhoncus aliquet, pulvinar sed, nisl. Nunc rhoncus dui vel sem. Sed sagittis. Nam congue, risus semper porta volutpat, quam pede lobortis ligula, sit amet eleifend pede libero quis orci. Nullam molestie nibh in lectus.', false, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (70, 'Dimension Therapeutics, Inc.', '0 Pankratz Center', '1440-617', 'Vila', 'Nullam sit amet turpis elementum ligula vehicula consequat. Morbi a ipsum. Integer a nibh. In quis justo. Maecenas rhoncus aliquam lacus. Morbi quis tortor id nulla ultrices aliquet.', false, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (71, 'NMI Holdings Inc', '6 Mayfield Alley', '9049-290', 'Esposende', 'Integer ac leo. Pellentesque ultrices mattis odio. Donec vitae nisi. Nam ultrices, libero non mattis pulvinar, nulla pede ullamcorper augue, a suscipit nulla elit ac nulla. Sed vel enim sit amet nunc viverra dapibus. Nulla suscipit ligula in lacus. Curabitur at ipsum ac tellus semper interdum. Mauris ullamcorper purus sit amet nulla. Quisque arcu libero, rutrum ac, lobortis vel, dapibus at, diam.', false, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (72, 'Federal Agricultural Mortgage Corporation', '447 Maple Street', '6571-952', 'Covas da Raposa', 'Quisque porta volutpat erat. Quisque erat eros, viverra eget, congue eget, semper rutrum, nulla. Nunc purus. Phasellus in felis. Donec semper sapien a libero. Nam dui. Proin leo odio, porttitor id, consequat in, consequat ut, nulla. Sed accumsan felis. Ut at dolor quis odio consequat varius.', true, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (73, 'PDF Solutions, Inc.', '3691 Oakridge Junction', '3008-636', 'Macedo de Cavaleiros', 'Quisque id justo sit amet sapien dignissim vestibulum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla dapibus dolor vel est. Donec odio justo, sollicitudin ut, suscipit a, feugiat et, eros. Vestibulum ac est lacinia nisi venenatis tristique. Fusce congue, diam id ornare imperdiet, sapien urna pretium nisl, ut volutpat sapien arcu sed augue. Aliquam erat volutpat. In congue. Etiam justo. Etiam pretium iaculis justo.', true, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (74, 'UMH Properties, Inc.', '1518 Kings Junction', '2138-855', 'Agrela', 'Nam ultrices, libero non mattis pulvinar, nulla pede ullamcorper augue, a suscipit nulla elit ac nulla. Sed vel enim sit amet nunc viverra dapibus. Nulla suscipit ligula in lacus. Curabitur at ipsum ac tellus semper interdum. Mauris ullamcorper purus sit amet nulla. Quisque arcu libero, rutrum ac, lobortis vel, dapibus at, diam.', false, 2);
insert into suppliers (id, name, address, post_code, city, description, accepted, image_id) values (75, 'Hibbett Sports, Inc.', '9 Pearson Circle', '2306-032', 'Barreiro', 'Maecenas ut massa quis augue luctus tincidunt. Nulla mollis molestie lorem. Quisque ut erat. Curabitur gravida nisi at nibh. In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem.', true, 2);

insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (51, 'Nut - Almond, Blanched, Whole', 2.9, 59, 'Nam ultrices, libero non mattis pulvinar, nulla pede ullamcorper augue, a suscipit nulla elit ac nulla. Sed vel enim sit amet nunc viverra dapibus. Nulla suscipit ligula in lacus.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (52, 'Oil - Truffle, White', 27.8, 87, 'Etiam vel augue. Vestibulum rutrum rutrum neque. Aenean auctor gravida sem.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (53, 'Alize Gold Passion', 35.4, 67, 'Duis consequat dui nec nisi volutpat eleifend. Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (54, 'Doilies - 12, Paper', 31.2, 33, 'Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (55, 'Melon - Watermelon, Seedless', 33.5, 87, 'Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (56, 'Cheese - Romano, Grated', 30.5, 16, 'Duis bibendum, felis sed interdum venenatis, turpis enim blandit mi, in porttitor pede justo eu massa. Donec dapibus. Duis at velit eu est congue elementum.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (57, 'Cheese - Swiss Sliced', 42.9, 15, 'Aliquam quis turpis eget elit sodales scelerisque. Mauris sit amet eros. Suspendisse accumsan tortor quis turpis.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (58, 'Lemon Tarts', 44.5, 86, 'Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (59, 'Beans - Green', 17.8, 22, 'In sagittis dui vel nisl. Duis ac nibh. Fusce lacus purus, aliquet at, feugiat non, pretium quis, lectus.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (60, 'Chip - Potato Dill Pickle', 81.2, 70, 'Nullam porttitor lacus at turpis. Donec posuere metus vitae ipsum. Aliquam non mauris.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (61, 'Cheese - Havarti, Roasted Garlic', 59.3, 39, 'In sagittis dui vel nisl. Duis ac nibh. Fusce lacus purus, aliquet at, feugiat non, pretium quis, lectus.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (62, 'Lotus Rootlets - Canned', 57.1, 17, 'Quisque id justo sit amet sapien dignissim vestibulum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla dapibus dolor vel est. Donec odio justo, sollicitudin ut, suscipit a, feugiat et, eros.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (63, 'Salmon - Smoked, Sliced', 29.2, 99, 'Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (64, 'Tamarillo', 10.2, 8, 'Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (65, 'Halibut - Steaks', 66.8, 65, 'Duis aliquam convallis nunc. Proin at turpis a pede posuere nonummy. Integer non velit.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (66, 'Trout - Rainbow, Frozen', 57.5, 48, 'Cras non velit nec nisi vulputate nonummy. Maecenas tincidunt lacus at velit. Vivamus vel nulla eget eros elementum pellentesque.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (67, 'Pomello', 23.0, 4, 'Integer tincidunt ante vel ipsum. Praesent blandit lacinia erat. Vestibulum sed magna at nunc commodo placerat.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (68, 'Bag - Clear 7 Lb', 75.0, 80, 'Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (69, 'Veal - Slab Bacon', 15.8, 96, 'Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (70, 'Bread - Granary Small Pull', 59.1, 84, 'Phasellus in felis. Donec semper sapien a libero. Nam dui.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (71, 'Sole - Dover, Whole, Fresh', 39.1, 50, 'Sed ante. Vivamus tortor. Duis mattis egestas metus.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (72, 'Eggplant - Baby', 99.7, 94, 'Praesent blandit. Nam nulla. Integer pede justo, lacinia eget, tincidunt eget, tempus vel, pede.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (73, 'Wine La Vielle Ferme Cote Du', 22.3, 45, 'Praesent id massa id nisl venenatis lacinia. Aenean sit amet justo. Morbi ut odio.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (74, 'Wine - Chateau Timberlay', 9.1, 44, 'Curabitur gravida nisi at nibh. In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (75, 'Garam Masala Powder', 43.5, 76, 'Etiam vel augue. Vestibulum rutrum rutrum neque. Aenean auctor gravida sem.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (51, 'Cheese - Brie, Triple Creme', 38.9, 24, 'Mauris enim leo, rhoncus sed, vestibulum sit amet, cursus turpis. Integer aliquet, massa id lobortis convallis, tortor risus dapibus augue, vel accumsan tellus nisi eu orci. Mauris lacinia sapien quis libero.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (52, 'Sage - Fresh', 22.3, 79, 'Phasellus in felis. Donec semper sapien a libero. Nam dui.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (53, 'Cleaner - Comet', 12.8, 41, 'Cras non velit nec nisi vulputate nonummy. Maecenas tincidunt lacus at velit. Vivamus vel nulla eget eros elementum pellentesque.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (54, 'Rosemary - Dry', 50.5, 11, 'Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (55, 'Roe - Lump Fish, Black', 80.9, 81, 'Sed sagittis. Nam congue, risus semper porta volutpat, quam pede lobortis ligula, sit amet eleifend pede libero quis orci. Nullam molestie nibh in lectus.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (56, 'Rice Paper', 1.3, 57, 'Duis bibendum, felis sed interdum venenatis, turpis enim blandit mi, in porttitor pede justo eu massa. Donec dapibus. Duis at velit eu est congue elementum.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (57, 'Eggroll', 11.1, 29, 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus vestibulum sagittis sapien. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (58, 'Capicola - Hot', 52.4, 6, 'Nullam sit amet turpis elementum ligula vehicula consequat. Morbi a ipsum. Integer a nibh.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (59, 'Cake - Bande Of Fruit', 67.0, 84, 'Curabitur gravida nisi at nibh. In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (60, 'Pepper - Chillies, Crushed', 59.6, 9, 'Curabitur at ipsum ac tellus semper interdum. Mauris ullamcorper purus sit amet nulla. Quisque arcu libero, rutrum ac, lobortis vel, dapibus at, diam.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (61, 'Chocolate - Liqueur Cups With Foil', 77.1, 28, 'Integer tincidunt ante vel ipsum. Praesent blandit lacinia erat. Vestibulum sed magna at nunc commodo placerat.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (62, 'Cookies - Fortune', 36.5, 53, 'Proin eu mi. Nulla ac enim. In tempor, turpis nec euismod scelerisque, quam turpis adipiscing lorem, vitae mattis nibh ligula nec sem.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (63, 'Lid Tray - 12in Dome', 85.4, 13, 'Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (64, 'Pork Casing', 53.3, 11, 'Duis aliquam convallis nunc. Proin at turpis a pede posuere nonummy. Integer non velit.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (65, 'Chips Potato Swt Chilli Sour', 1.7, 30, 'In quis justo. Maecenas rhoncus aliquam lacus. Morbi quis tortor id nulla ultrices aliquet.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (66, 'Wine - White Cab Sauv.on', 66.2, 72, 'Sed ante. Vivamus tortor. Duis mattis egestas metus.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (67, 'Eggplant - Baby', 48.0, 27, 'Integer ac leo. Pellentesque ultrices mattis odio. Donec vitae nisi.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (68, 'Garbag Bags - Black', 44.0, 41, 'Sed sagittis. Nam congue, risus semper porta volutpat, quam pede lobortis ligula, sit amet eleifend pede libero quis orci. Nullam molestie nibh in lectus.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (69, 'Hersey Shakes', 32.8, 36, 'Curabitur at ipsum ac tellus semper interdum. Mauris ullamcorper purus sit amet nulla. Quisque arcu libero, rutrum ac, lobortis vel, dapibus at, diam.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (70, 'Wine - Chablis J Moreau Et Fils', 44.8, 92, 'Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (71, 'Yogurt - Blueberry, 175 Gr', 63.9, 45, 'Maecenas ut massa quis augue luctus tincidunt. Nulla mollis molestie lorem. Quisque ut erat.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (72, 'Wine - White, Gewurtzraminer', 72.2, 80, 'Sed sagittis. Nam congue, risus semper porta volutpat, quam pede lobortis ligula, sit amet eleifend pede libero quis orci. Nullam molestie nibh in lectus.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (73, 'Avocado', 3.9, 58, 'Integer tincidunt ante vel ipsum. Praesent blandit lacinia erat. Vestibulum sed magna at nunc commodo placerat.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (74, 'Muffin Hinge - 211n', 83.7, 31, 'Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (75, 'Wine - Pinot Noir Mondavi Coastal', 50.3, 6, 'Curabitur at ipsum ac tellus semper interdum. Mauris ullamcorper purus sit amet nulla. Quisque arcu libero, rutrum ac, lobortis vel, dapibus at, diam.', true, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (51, 'Cherries - Fresh', 30.1, 69, 'Cras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (52, 'Wine - Fat Bastard Merlot', 37.1, 85, 'Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (53, 'Marsala - Sperone, Fine, D.o.c.', 38.8, 47, 'Nullam porttitor lacus at turpis. Donec posuere metus vitae ipsum. Aliquam non mauris.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (54, 'Cheese - Brick With Pepper', 81.1, 47, 'Aenean fermentum. Donec ut mauris eget massa tempor convallis. Nulla neque libero, convallis eget, eleifend luctus, ultricies eu, nibh.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (55, 'C - Plus, Orange', 48.3, 87, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Proin risus. Praesent lectus.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (56, 'Onion Powder', 88.7, 31, 'Maecenas tristique, est et tempus semper, est quam pharetra magna, ac consequat metus sapien ut nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra diam vitae quam. Suspendisse potenti.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (57, 'Pears - Bosc', 89.9, 39, 'Maecenas ut massa quis augue luctus tincidunt. Nulla mollis molestie lorem. Quisque ut erat.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (58, 'Bread - White Mini Epi', 39.5, 81, 'Aenean fermentum. Donec ut mauris eget massa tempor convallis. Nulla neque libero, convallis eget, eleifend luctus, ultricies eu, nibh.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (59, 'Danishes - Mini Cheese', 92.2, 81, 'Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (60, 'Cheese Cheddar Processed', 81.9, 6, 'Cras non velit nec nisi vulputate nonummy. Maecenas tincidunt lacus at velit. Vivamus vel nulla eget eros elementum pellentesque.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (61, 'Yogurt - Strawberry, 175 Gr', 94.6, 85, 'Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (62, 'Mini - Vol Au Vents', 49.7, 79, 'Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (63, 'Wine - Sauvignon Blanc', 45.2, 50, 'Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (64, 'Juice - Grapefruit, 341 Ml', 23.1, 69, 'Quisque id justo sit amet sapien dignissim vestibulum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla dapibus dolor vel est. Donec odio justo, sollicitudin ut, suscipit a, feugiat et, eros.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (65, 'Strawberries', 48.7, 51, 'Fusce consequat. Nulla nisl. Nunc nisl.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (66, 'Gelatine Leaves - Bulk', 53.3, 23, 'Quisque id justo sit amet sapien dignissim vestibulum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla dapibus dolor vel est. Donec odio justo, sollicitudin ut, suscipit a, feugiat et, eros.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (67, 'Calypso - Pineapple Passion', 71.5, 39, 'Etiam vel augue. Vestibulum rutrum rutrum neque. Aenean auctor gravida sem.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (68, 'Butcher Twine 4r', 68.1, 64, 'Morbi porttitor lorem id ligula. Suspendisse ornare consequat lectus. In est risus, auctor sed, tristique in, tempus sit amet, sem.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (69, 'Tea - Orange Pekoe', 42.2, 94, 'Nam ultrices, libero non mattis pulvinar, nulla pede ullamcorper augue, a suscipit nulla elit ac nulla. Sed vel enim sit amet nunc viverra dapibus. Nulla suscipit ligula in lacus.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (70, 'Hipnotiq Liquor', 11.5, 70, 'Morbi porttitor lorem id ligula. Suspendisse ornare consequat lectus. In est risus, auctor sed, tristique in, tempus sit amet, sem.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (71, 'Calypso - Black Cherry Lemonade', 28.8, 64, 'Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (72, 'Pastry - Mini French Pastries', 27.0, 45, 'Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (73, 'Muffin Mix - Oatmeal', 44.3, 70, 'In congue. Etiam justo. Etiam pretium iaculis justo.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (74, 'Pate - Cognac', 20.2, 60, 'Praesent id massa id nisl venenatis lacinia. Aenean sit amet justo. Morbi ut odio.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (75, 'Beef - Bones, Cut - Up', 22.5, 70, 'Cras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', false, false);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (51, 'Cheese - Valancey', 30.3, 71, 'Fusce posuere felis sed lacus. Morbi sem mauris, laoreet ut, rhoncus aliquet, pulvinar sed, nisl. Nunc rhoncus dui vel sem.', true, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (52, 'Pate - Peppercorn', 16.9, 51, 'In hac habitasse platea dictumst. Morbi vestibulum, velit id pretium iaculis, diam erat fermentum justo, nec condimentum neque sapien placerat ante. Nulla justo.', true, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (53, 'Devonshire Cream', 58.5, 96, 'Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.', true, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (54, 'Cheese - Fontina', 80.2, 73, 'Integer ac leo. Pellentesque ultrices mattis odio. Donec vitae nisi.', true, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (55, 'Mushroom - Enoki, Dry', 28.5, 59, 'In hac habitasse platea dictumst. Etiam faucibus cursus urna. Ut tellus.', true, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (56, 'Brandy Apricot', 10.1, 9, 'Aliquam quis turpis eget elit sodales scelerisque. Mauris sit amet eros. Suspendisse accumsan tortor quis turpis.', true, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (57, 'Water - Evian 355 Ml', 46.9, 94, 'Integer ac leo. Pellentesque ultrices mattis odio. Donec vitae nisi.', true, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (58, 'Mussels - Frozen', 47.9, 34, 'In hac habitasse platea dictumst. Etiam faucibus cursus urna. Ut tellus.', true, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (59, 'Horseradish - Prepared', 74.4, 57, 'Aenean fermentum. Donec ut mauris eget massa tempor convallis. Nulla neque libero, convallis eget, eleifend luctus, ultricies eu, nibh.', true, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (60, 'Bread - 10 Grain', 15.5, 80, 'Suspendisse potenti. In eleifend quam a odio. In hac habitasse platea dictumst.', true, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (61, 'Chocolate - Dark', 58.8, 8, 'Praesent id massa id nisl venenatis lacinia. Aenean sit amet justo. Morbi ut odio.', true, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (62, 'Cookie Dough - Chunky', 44.2, 38, 'Sed ante. Vivamus tortor. Duis mattis egestas metus.', true, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (63, 'Juice - Apple, 341 Ml', 37.7, 23, 'Sed ante. Vivamus tortor. Duis mattis egestas metus.', true, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (64, 'Wine - Red, Pinot Noir, Chateau', 86.8, 12, 'Praesent id massa id nisl venenatis lacinia. Aenean sit amet justo. Morbi ut odio.', true, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (65, 'Sea Urchin', 86.8, 34, 'Nulla ut erat id mauris vulputate elementum. Nullam varius. Nulla facilisi.', true, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (66, 'Apple - Macintosh', 43.8, 59, 'Aenean fermentum. Donec ut mauris eget massa tempor convallis. Nulla neque libero, convallis eget, eleifend luctus, ultricies eu, nibh.', true, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (67, 'Salmon - Atlantic, No Skin', 91.4, 68, 'Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.', true, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (68, 'The Pop Shoppe - Cream Soda', 43.9, 87, 'Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.', true, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (69, 'Nantucket - Carrot Orange', 83.4, 72, 'Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis.', true, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (70, 'C - Plus, Orange', 84.8, 58, 'Praesent id massa id nisl venenatis lacinia. Aenean sit amet justo. Morbi ut odio.', true, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (71, 'Cocktail Napkin Blue', 63.3, 53, 'Phasellus in felis. Donec semper sapien a libero. Nam dui.', false, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (72, 'The Pop Shoppe Pinapple', 80.1, 82, 'Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.', false, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (73, 'Rice - Jasmine Sented', 91.3, 32, 'Curabitur gravida nisi at nibh. In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem.', false, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (74, 'Wine - White, Riesling, Semi - Dry', 21.4, 56, 'Praesent blandit. Nam nulla. Integer pede justo, lacinia eget, tincidunt eget, tempus vel, pede.', false, true);
insert into items (supplier_id, name, price, stock, description, active, is_bundle) values (75, 'Pasta - Shells, Medium, Dry', 69.6, 73, 'In quis justo. Maecenas rhoncus aliquam lacus. Morbi quis tortor id nulla ultrices aliquet.', false, true);

insert into products (id, unit) values (1, 'Un');
insert into products (id, unit) values (2, 'Un');
insert into products (id, unit) values (3, 'Un');
insert into products (id, unit) values (4, 'Kg');
insert into products (id, unit) values (5, 'Un');
insert into products (id, unit) values (6, 'Un');
insert into products (id, unit) values (7, 'Un');
insert into products (id, unit) values (8, 'Kg');
insert into products (id, unit) values (9, 'Kg');
insert into products (id, unit) values (10, 'Un');
insert into products (id, unit) values (11, 'Kg');
insert into products (id, unit) values (12, 'Kg');
insert into products (id, unit) values (13, 'Un');
insert into products (id, unit) values (14, 'Un');
insert into products (id, unit) values (15, 'Un');
insert into products (id, unit) values (16, 'Kg');
insert into products (id, unit) values (17, 'Kg');
insert into products (id, unit) values (18, 'Un');
insert into products (id, unit) values (19, 'Un');
insert into products (id, unit) values (20, 'Kg');
insert into products (id, unit) values (21, 'Kg');
insert into products (id, unit) values (22, 'Kg');
insert into products (id, unit) values (23, 'Un');
insert into products (id, unit) values (24, 'Un');
insert into products (id, unit) values (25, 'Kg');
insert into products (id, unit) values (26, 'Kg');
insert into products (id, unit) values (27, 'Un');
insert into products (id, unit) values (28, 'Un');
insert into products (id, unit) values (29, 'Un');
insert into products (id, unit) values (30, 'Un');
insert into products (id, unit) values (31, 'Un');
insert into products (id, unit) values (32, 'Un');
insert into products (id, unit) values (33, 'Kg');
insert into products (id, unit) values (34, 'Kg');
insert into products (id, unit) values (35, 'Un');
insert into products (id, unit) values (36, 'Un');
insert into products (id, unit) values (37, 'Un');
insert into products (id, unit) values (38, 'Un');
insert into products (id, unit) values (39, 'Kg');
insert into products (id, unit) values (40, 'Kg');
insert into products (id, unit) values (41, 'Kg');
insert into products (id, unit) values (42, 'Kg');
insert into products (id, unit) values (43, 'Un');
insert into products (id, unit) values (44, 'Kg');
insert into products (id, unit) values (45, 'Kg');
insert into products (id, unit) values (46, 'Un');
insert into products (id, unit) values (47, 'Un');
insert into products (id, unit) values (48, 'Kg');
insert into products (id, unit) values (49, 'Kg');
insert into products (id, unit) values (50, 'Un');
insert into products (id, unit) values (51, 'Un');
insert into products (id, unit) values (52, 'Un');
insert into products (id, unit) values (53, 'Un');
insert into products (id, unit) values (54, 'Un');
insert into products (id, unit) values (55, 'Kg');
insert into products (id, unit) values (56, 'Kg');
insert into products (id, unit) values (57, 'Un');
insert into products (id, unit) values (58, 'Kg');
insert into products (id, unit) values (59, 'Kg');
insert into products (id, unit) values (60, 'Un');
insert into products (id, unit) values (61, 'Un');
insert into products (id, unit) values (62, 'Kg');
insert into products (id, unit) values (63, 'Kg');
insert into products (id, unit) values (64, 'Un');
insert into products (id, unit) values (65, 'Kg');
insert into products (id, unit) values (66, 'Un');
insert into products (id, unit) values (67, 'Un');
insert into products (id, unit) values (68, 'Kg');
insert into products (id, unit) values (69, 'Un');
insert into products (id, unit) values (70, 'Kg');
insert into products (id, unit) values (71, 'Kg');
insert into products (id, unit) values (72, 'Un');
insert into products (id, unit) values (73, 'Un');
insert into products (id, unit) values (74, 'Un');
insert into products (id, unit) values (75, 'Kg');

insert into coupons ( code, name, description, expiration, type, amount, supplier_id) values ('volutpat', 'habitasse platea dictumst morbi', 'Nullam sit amet turpis elementum ligula vehicula consequat. Morbi a ipsum. Integer a nibh.', '2022-11-24 22:35:26', '%', 20, 55);
insert into coupons ( code, name, description, expiration, type, amount, supplier_id) values ('ridiculus', 'eu nibh quisque', 'Donec diam neque, vestibulum eget, vulputate ut, ultrices vel, augue. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec pharetra, magna vestibulum aliquet ultrices, erat tortor sollicitudin mi, sit amet lobortis sapien sapien non mi. Integer ac neque.', '2022-09-03 22:02:34', '%', 99, 75);
insert into coupons ( code, name, description, expiration, type, amount, supplier_id) values ('congue', 'mattis nibh ligula nec', 'Phasellus sit amet erat. Nulla tempus. Vivamus in felis eu sapien cursus vestibulum.', '2022-07-19 11:35:22', '%', 31, 53);
insert into coupons ( code, name, description, expiration, type, amount, supplier_id) values ('tellus', 'hac habitasse platea', 'Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.', '2022-10-06 00:27:34', '€', 6.06, 68);
insert into coupons ( code, name, description, expiration, type, amount, supplier_id) values ('vulputate', 'justo nec condimentum neque', 'Fusce posuere felis sed lacus. Morbi sem mauris, laoreet ut, rhoncus aliquet, pulvinar sed, nisl. Nunc rhoncus dui vel sem.', '2022-03-14 08:42:08', '%', 97, 52);
insert into coupons ( code, name, description, expiration, type, amount, supplier_id) values ('orci', 'justo nec condimentum', 'Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus.', '2022-02-26 17:20:48', '%', 39, 66);
insert into coupons ( code, name, description, expiration, type, amount, supplier_id) values ('another', 'tristique in tempus sit', 'Suspendisse potenti. In eleifend quam a odio. In hac habitasse platea dictumst.', '2022-03-24 15:45:57', '€', 0.75, 59);
insert into coupons ( code, name, description, expiration, type, amount, supplier_id) values ('pede', 'purus phasellus in', 'Mauris enim leo, rhoncus sed, vestibulum sit amet, cursus id, turpis. Integer aliquet, massa id lobortis convallis, tortor risus dapibus augue, vel accumsan tellus nisi eu orci. Mauris lacinia sapien quis libero.', '2022-07-31 23:28:43', '%', 24, 59);
insert into coupons ( code, name, description, expiration, type, amount, supplier_id) values ('cubilia', 'sapien sapien non', 'Etiam vel augue. Vestibulum rutrum rutrum neque. Aenean auctor gravida sem.', '2022-09-30 08:51:05', '€', 6.69, 51);
insert into coupons ( code, name, description, expiration, type, amount, supplier_id) values ( 'lectus', 'vestibulum ac est', 'Maecenas leo odio, condimentum id, luctus nec, molestie sed, justo. Pellentesque viverra pede ac diam. Cras pellentesque volutpat dui.', '2022-11-19 08:00:36', '€', 79.32, 75);
insert into coupons ( code, name, description, expiration, type, amount, supplier_id) values ( 'non', 'quis orci nullam', 'Cras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', '2022-08-03 16:36:02', '€', 7.02, 66);
insert into coupons ( code, name, description, expiration, type, amount, supplier_id) values ( 'ipsum', 'magna ac consequat', 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus vestibulum sagittis sapien. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', '2022-09-06 19:21:22', '€', 67.59, 63);
insert into coupons ( code, name, description, expiration, type, amount, supplier_id) values ( 'nisl', 'non velit donec', 'Morbi porttitor lorem id ligula. Suspendisse ornare consequat lectus. In est risus, auctor sed, tristique in, tempus sit amet, sem.', '2022-12-02 14:47:47', '€', 15.42, 65);
insert into coupons ( code, name, description, expiration, type, amount, supplier_id) values ( 'vestibulum', 'metus arcu adipiscing molestie', 'Aenean lectus. Pellentesque eget nunc. Donec quis orci eget orci vehicula condimentum.', '2022-10-05 23:53:54', '€', 66.03, 70);
insert into coupons ( code, name, description, expiration, type, amount, supplier_id) values ( 'vel', 'molestie hendrerit at', 'Praesent id massa id nisl venenatis lacinia. Aenean sit amet justo. Morbi ut odio.', '2022-09-06 16:36:33', '€', 9.87, 75);
insert into coupons ( code, name, description, expiration, type, amount, supplier_id) values ( 'nibh', 'sed tristique in', 'Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.', '2022-08-01 23:45:44', '%', 79, 57);
insert into coupons ( code, name, description, expiration, type, amount, supplier_id) values ( 'libero', 'eleifend quam a odio', 'Curabitur gravida nisi at nibh. In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem.', '2022-05-22 23:14:31', '€', 10.42, 69);
insert into coupons ( code, name, description, expiration, type, amount, supplier_id) values ( 'lorem', 'ante vel ipsum praesent', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Proin risus. Praesent lectus.', '2022-02-09 22:18:37', '€', 46.56, 57);
insert into coupons ( code, name, description, expiration, type, amount, supplier_id) values ( 'tellas', 'tellus semper interdum', 'Maecenas ut massa quis augue luctus tincidunt. Nulla mollis molestie lorem. Quisque ut erat.', '2022-01-14 18:37:19', '€', 23.82, 68);
insert into coupons ( code, name, description, expiration, type, amount, supplier_id) values ( 'erat', 'quis turpis eget elit', 'Curabitur gravida nisi at nibh. In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem.', '2022-07-09 08:11:46', '€', 95.14, 68);

insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ('Kayla', 'Wilden', '2 Thierer Park', '95879', '0657-937', 'Braga', 'Picoto', 'Portugal', '954062263', 1);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ('Clair', 'Lacky', '0336 Russell Hill', '6', '5207-497', 'Lisboa', 'Aldeia de Juzo', 'Portugal', '984172568', 2);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ('Berkley', 'McKeller', '6 Prentice Trail', '869', '5408-251', 'Lisboa', 'Baratã', 'Portugal', '969012311', 3);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ('Dorotea', 'Aburrow', '8 Barnett Junction', '181', '0354-935', 'Viana do Castelo', 'Vila', 'Portugal', '963987023', 4);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ('Lurleen', 'Dougharty', '0624 Memorial Plaza', '33636', '7993-891', 'Lisboa', 'Fonte Boa dos Nabos', 'Portugal', '929769432', 5);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ('Andree', 'Prothero', '60455 Burning Wood Pass', '32', '5297-645', 'Vila Real', 'Amieiro', 'Portugal', '904425126', 6);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ('Yvonne', 'Delacroux', '503 Arkansas Drive', '095', '3942-555', 'Porto', 'Quintão', 'Portugal', '920538418', 7);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ('Dominica', 'Litherland', '41904 Sunnyside Plaza', '76328', '0710-514', 'Leiria', 'Granja', 'Portugal', '951483947', 8);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ('Vincents', 'Blaine', '4 Melody Road', '45', '4795-955', 'Porto', 'Cimo de Vila', 'Portugal', '951772486', 9);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Netty', 'Snelgrove', '16884 Upham Point', '99', '8556-118', 'Braga', 'Guardizela', 'Portugal', '928800427', 10);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Stacy', 'Elleray', '5698 Kings Lane', '80010', '5418-528', 'Guarda', 'Sabugal', 'Portugal', '942218399', 11);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Gage', 'Dermot', '8 Atwood Lane', '44', '8758-635', 'Leiria', 'Arrabal', 'Portugal', '948140820', 12);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Mendie', 'Kunze', '2789 Algoma Street', '3196', '4033-709', 'Lisboa', 'Arruda dos Vinhos', 'Portugal', '951171848', 13);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Lizzie', 'Bigly', '5 Bunker Hill Alley', '3', '0182-954', 'Braga', 'Celorico de Basto', 'Portugal', '922741993', 14);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Wyatan', 'McCullagh', '9 Hazelcrest Drive', '035', '9556-804', 'Lisboa', 'Casal da Serra', 'Portugal', '901741328', 15);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Sebastian', 'Godart', '30311 Village Lane', '77576', '8079-362', 'Lisboa', 'Sabugo', 'Portugal', '962628258', 16);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Adan', 'Davidsen', '4925 Crest Line Plaza', '3718', '3818-104', 'Lisboa', 'Prior Velho', 'Portugal', '939522458', 17);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Trudy', 'Luckey', '6097 High Crossing Lane', '51970', '8056-849', 'Viseu', 'Portela', 'Portugal', '977842544', 18);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Kahlil', 'Mayoh', '4 West Circle', '01', '1304-316', 'Santarém', 'Fontaínhas', 'Portugal', '955629289', 19);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Clea', 'Jedrachowicz', '043 Vermont Point', '05', '2250-124', 'Lisboa', 'Casa Nova', 'Portugal', '959134487', 20);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Gladys', 'Tremolieres', '0673 Grayhawk Drive', '779', '7898-998', 'Porto', 'Baguim do Monte', 'Portugal', '996755760', 21);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Colene', 'Szimon', '13 Troy Lane', '171', '6911-938', 'Braga', 'Telhado', 'Portugal', '976813872', 22);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Dotty', 'Ridwood', '6409 Mccormick Crossing', '8', '0015-936', 'Porto', 'Sardoal', 'Portugal', '951581293', 23);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Christi', 'Jellico', '9 Jay Way', '071', '1655-325', 'Coimbra', 'Vilarinho', 'Portugal', '978251649', 24);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Nikolia', 'Ossulton', '3605 Bunting Hill', '0529', '1144-044', 'Leiria', 'Trabulheira', 'Portugal', '918804130', 25);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Rutherford', 'Thompson', '68869 Oriole Way', '27944', '1256-209', 'Leiria', 'Souto do Meio', 'Portugal', '902064745', 26);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Melania', 'Ramsey', '958 Mcguire Plaza', '275', '2910-117', 'Lisboa', 'Camarate', 'Portugal', '957015595', 27);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Devinne', 'Rainger', '7797 Magdeline Road', '4', '7117-655', 'Lisboa', 'Antas', 'Portugal', '965823386', 28);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Lynn', 'Couling', '59 Anniversary Junction', '74903', '7842-125', 'Bragança', 'Poiares', 'Portugal', '935451450', 29);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Kingsly', 'Ledner', '568 Valley Edge Terrace', '3230', '2811-917', 'Braga', 'Abade de Vermoim', 'Portugal', '966126681', 30);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Bryon', 'Lehmann', '7 Nova Street', '90', '8407-082', 'Lisboa', 'Campelos', 'Portugal', '946100409', 31);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Torrance', 'Cason', '6 Golf Junction', '14844', '2007-318', 'Lisboa', 'São João das Lampas', 'Portugal', '953764610', 32);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Flynn', 'Ruddell', '54850 International Parkway', '354', '5403-612', 'Viana do Castelo', 'Eirado', 'Portugal', '924900987', 33);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Brooke', 'Moultrie', '8743 Oneill Avenue', '17', '7517-074', 'Viana do Castelo', 'Boucinha', 'Portugal', '928935964', 34);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Traci', 'Allicock', '15 Sage Place', '758', '2880-090', 'Faro', 'Martinlongo', 'Portugal', '900886795', 35);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Cissy', 'Oyley', '77965 Maryland Circle', '838', '4477-769', 'Braga', 'Arnoia', 'Portugal', '996170444', 36);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Dianne', 'Alessandrucci', '99 Brickson Park Avenue', '8729', '3854-599', 'Guarda', 'Fornos de Algodres', 'Portugal', '998177122', 37);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Ford', 'Theriot', '066 Graedel Junction', '48637', '1263-478', 'Guarda', 'Figueira Castelo Rodrigo', 'Portugal', '903740924', 38);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Lari', 'Soot', '16 Monica Trail', '71590', '5743-061', 'Porto', 'Boavista', 'Portugal', '921182466', 39);
insert into ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id) values ( 'Launce', 'Scotcher', '72953 Aberg Court', '259', '9584-221', 'Santarém', 'São Miguel do Rio Torto', 'Portugal', '975221498', 40);

insert into item_product (item_id, product_id, quantity) values (100, 7, 3);
insert into item_product (item_id, product_id, quantity) values (97, 8, 19);
insert into item_product (item_id, product_id, quantity) values (95, 10, 40);
insert into item_product (item_id, product_id, quantity) values (81, 8, 38);
insert into item_product (item_id, product_id, quantity) values (87, 1, 47);
insert into item_product (item_id, product_id, quantity) values (76, 1, 49);
insert into item_product (item_id, product_id, quantity) values (95, 5, 48);
insert into item_product (item_id, product_id, quantity) values (78, 12, 30);
insert into item_product (item_id, product_id, quantity) values (87, 8, 24);
insert into item_product (item_id, product_id, quantity) values (88, 3, 1);
insert into item_product (item_id, product_id, quantity) values (88, 13, 32);
insert into item_product (item_id, product_id, quantity) values (89, 3, 42);
insert into item_product (item_id, product_id, quantity) values (76, 4, 36);
insert into item_product (item_id, product_id, quantity) values (85, 4, 29);
insert into item_product (item_id, product_id, quantity) values (93, 12, 11);
insert into item_product (item_id, product_id, quantity) values (79, 12, 9);
insert into item_product (item_id, product_id, quantity) values (92, 5, 47);
insert into item_product (item_id, product_id, quantity) values (97, 2, 2);
insert into item_product (item_id, product_id, quantity) values (98, 16, 48);
insert into item_product (item_id, product_id, quantity) values (99, 12, 41);
insert into item_product (item_id, product_id, quantity) values (96, 13, 10);
insert into item_product (item_id, product_id, quantity) values (80, 4, 15);
insert into item_product (item_id, product_id, quantity) values (93, 10, 44);
insert into item_product (item_id, product_id, quantity) values (88, 1, 50);
insert into item_product (item_id, product_id, quantity) values (83, 6, 25);
insert into item_product (item_id, product_id, quantity) values (93, 6, 42);
insert into item_product (item_id, product_id, quantity) values (99, 11, 30);
insert into item_product (item_id, product_id, quantity) values (90, 2, 42);
insert into item_product (item_id, product_id, quantity) values (88, 4, 11);
insert into item_product (item_id, product_id, quantity) values (84, 15, 1);
insert into item_product (item_id, product_id, quantity) values (81, 1, 23);
insert into item_product (item_id, product_id, quantity) values (89, 12, 19);
insert into item_product (item_id, product_id, quantity) values (83, 9, 7);
insert into item_product (item_id, product_id, quantity) values (97, 1, 32);
insert into item_product (item_id, product_id, quantity) values (80, 14, 48);
insert into item_product (item_id, product_id, quantity) values (78, 6, 35);
insert into item_product (item_id, product_id, quantity) values (76, 13, 21);
insert into item_product (item_id, product_id, quantity) values (83, 10, 15);
insert into item_product (item_id, product_id, quantity) values (95, 1, 11);
insert into item_product (item_id, product_id, quantity) values (77, 4, 46);
insert into item_product (item_id, product_id, quantity) values (83, 3, 24);
insert into item_product (item_id, product_id, quantity) values (99, 7, 6);
insert into item_product (item_id, product_id, quantity) values (80, 10, 29);
insert into item_product (item_id, product_id, quantity) values (81, 17, 12);
insert into item_product (item_id, product_id, quantity) values (80, 6, 46);
insert into item_product (item_id, product_id, quantity) values (78, 3, 33);
insert into item_product (item_id, product_id, quantity) values (87, 12, 24);
insert into item_product (item_id, product_id, quantity) values (98, 3, 5);
insert into item_product (item_id, product_id, quantity) values (87, 3, 45);
insert into item_product (item_id, product_id, quantity) values (95, 11, 44);
insert into item_product (item_id, product_id, quantity) values (86, 3, 1);
insert into item_product (item_id, product_id, quantity) values (97, 7, 11);
insert into item_product (item_id, product_id, quantity) values (95, 8, 45);
insert into item_product (item_id, product_id, quantity) values (93, 16, 48);
insert into item_product (item_id, product_id, quantity) values (90, 11, 2);
insert into item_product (item_id, product_id, quantity) values (89, 2, 50);
insert into item_product (item_id, product_id, quantity) values (85, 17, 30);
insert into item_product (item_id, product_id, quantity) values (82, 17, 35);
insert into item_product (item_id, product_id, quantity) values (92, 14, 33);
insert into item_product (item_id, product_id, quantity) values (89, 17, 46);
insert into item_product (item_id, product_id, quantity) values (97, 15, 2);
insert into item_product (item_id, product_id, quantity) values (80, 1, 32);
insert into item_product (item_id, product_id, quantity) values (92, 12, 43);
insert into item_product (item_id, product_id, quantity) values (77, 11, 50);
insert into item_product (item_id, product_id, quantity) values (85, 3, 24);
insert into item_product (item_id, product_id, quantity) values (76, 6, 46);
insert into item_product (item_id, product_id, quantity) values (89, 13, 36);
insert into item_product (item_id, product_id, quantity) values (81, 16, 34);
insert into item_product (item_id, product_id, quantity) values (100, 3, 47);
insert into item_product (item_id, product_id, quantity) values (80, 9, 27);
insert into item_product (item_id, product_id, quantity) values (89, 4, 13);
insert into item_product (item_id, product_id, quantity) values (85, 12, 9);
insert into item_product (item_id, product_id, quantity) values (91, 1, 35);
insert into item_product (item_id, product_id, quantity) values (79, 10, 40);
insert into item_product (item_id, product_id, quantity) values (76, 11, 6);
insert into item_product (item_id, product_id, quantity) values (90, 10, 43);
insert into item_product (item_id, product_id, quantity) values (94, 9, 29);
insert into item_product (item_id, product_id, quantity) values (92, 2, 33);
insert into item_product (item_id, product_id, quantity) values (81, 11, 44);
insert into item_product (item_id, product_id, quantity) values (88, 10, 49);
insert into item_product (item_id, product_id, quantity) values (92, 11, 41);
insert into item_product (item_id, product_id, quantity) values (91, 9, 44);
insert into item_product (item_id, product_id, quantity) values (78, 4, 10);
insert into item_product (item_id, product_id, quantity) values (95, 14, 4);
insert into item_product (item_id, product_id, quantity) values (96, 9, 19);
insert into item_product (item_id, product_id, quantity) values (85, 11, 4);
insert into item_product (item_id, product_id, quantity) values (93, 1, 6);
insert into item_product (item_id, product_id, quantity) values (100, 4, 42);
insert into item_product (item_id, product_id, quantity) values (85, 8, 38);
insert into item_product (item_id, product_id, quantity) values (80, 16, 42);
insert into item_product (item_id, product_id, quantity) values (82, 9, 5);
insert into item_product (item_id, product_id, quantity) values (76, 8, 45);
insert into item_product (item_id, product_id, quantity) values (93, 8, 6);
insert into item_product (item_id, product_id, quantity) values (96, 4, 10);
insert into item_product (item_id, product_id, quantity) values (94, 16, 27);
insert into item_product (item_id, product_id, quantity) values (82, 15, 34);
insert into item_product (item_id, product_id, quantity) values (81, 7, 7);
insert into item_product (item_id, product_id, quantity) values (98, 8, 2);
insert into item_product (item_id, product_id, quantity) values (87, 6, 23);
insert into item_product (item_id, product_id, quantity) values (78, 1, 46);
insert into item_product (item_id, product_id, quantity) values (91, 12, 30);
insert into item_product (item_id, product_id, quantity) values (98, 11, 20);
insert into item_product (item_id, product_id, quantity) values (95, 7, 45);
insert into item_product (item_id, product_id, quantity) values (95, 9, 22);
insert into item_product (item_id, product_id, quantity) values (87, 11, 49);
insert into item_product (item_id, product_id, quantity) values (77, 5, 2);
insert into item_product (item_id, product_id, quantity) values (91, 17, 33);
insert into item_product (item_id, product_id, quantity) values (85, 9, 29);
insert into item_product (item_id, product_id, quantity) values (84, 2, 32);
insert into item_product (item_id, product_id, quantity) values (96, 15, 28);
insert into item_product (item_id, product_id, quantity) values (90, 1, 40);
insert into item_product (item_id, product_id, quantity) values (79, 17, 38);
insert into item_product (item_id, product_id, quantity) values (96, 5, 49);
insert into item_product (item_id, product_id, quantity) values (83, 2, 8);
insert into item_product (item_id, product_id, quantity) values (92, 7, 13);
insert into item_product (item_id, product_id, quantity) values (92, 9, 19);
insert into item_product (item_id, product_id, quantity) values (82, 5, 49);
insert into item_product (item_id, product_id, quantity) values (82, 4, 38);
insert into item_product (item_id, product_id, quantity) values (99, 8, 45);
insert into item_product (item_id, product_id, quantity) values (91, 4, 6);
insert into item_product (item_id, product_id, quantity) values (89, 15, 13);
insert into item_product (item_id, product_id, quantity) values (99, 10, 48);
insert into item_product (item_id, product_id, quantity) values (83, 8, 11);
insert into item_product (item_id, product_id, quantity) values (98, 9, 34);
insert into item_product (item_id, product_id, quantity) values (86, 2, 9);
insert into item_product (item_id, product_id, quantity) values (87, 13, 3);
insert into item_product (item_id, product_id, quantity) values (81, 10, 24);
insert into item_product (item_id, product_id, quantity) values (88, 7, 15);
insert into item_product (item_id, product_id, quantity) values (94, 4, 44);
insert into item_product (item_id, product_id, quantity) values (99, 3, 10);
insert into item_product (item_id, product_id, quantity) values (82, 2, 3);
insert into item_product (item_id, product_id, quantity) values (86, 11, 17);
insert into item_product (item_id, product_id, quantity) values (97, 13, 20);
insert into item_product (item_id, product_id, quantity) values (88, 8, 22);
insert into item_product (item_id, product_id, quantity) values (94, 14, 16);
insert into item_product (item_id, product_id, quantity) values (97, 11, 25);
insert into item_product (item_id, product_id, quantity) values (89, 8, 43);
insert into item_product (item_id, product_id, quantity) values (100, 10, 32);
insert into item_product (item_id, product_id, quantity) values (77, 7, 9);
insert into item_product (item_id, product_id, quantity) values (95, 17, 7);
insert into item_product (item_id, product_id, quantity) values (100, 15, 2);
insert into item_product (item_id, product_id, quantity) values (81, 5, 33);
insert into item_product (item_id, product_id, quantity) values (99, 1, 3);
insert into item_product (item_id, product_id, quantity) values (96, 14, 11);
insert into item_product (item_id, product_id, quantity) values (78, 14, 34);
insert into item_product (item_id, product_id, quantity) values (98, 12, 50);

insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ('0429 8595 0058 4305', '2022-06-30', '556', 'Philbert Lismore', 1);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ('6843 1070 8852 4478', '2021-03-10', '073', 'Silvester Paintain', 2);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ('8631 5740 5944 6226', '2022-10-14', '788', 'Mimi Wernham', 3);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ('8097 0603 4546 4807', '2021-12-20', '582', 'Deonne Mundwell', 4);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ('3488 8305 0435 2596', '2021-11-13', '852', 'Stearn Mulgrew', 5);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ('3086 3220 3921 2420', '2022-08-31', '113', 'Mendel Marran', 6);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ('5035 2738 6245 7578', '2022-10-31', '020', 'Merle Boatwright', 7);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ('4713 6329 2571 1371', '2021-11-05', '848', 'Garry Mantram', 8);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ('6681 7251 3968 9683', '2021-08-29', '163', 'Alix Beneyto', 9);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '6315 6024 1876 8474', '2021-09-08', '570', 'Simone Perrelli', 10);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '8256 6642 2280 8335', '2021-08-20', '249', 'Janice Sikorsky', 11);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '0388 8988 2527 0369', '2021-12-20', '303', 'Myranda Orchart', 12);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '5856 2739 1266 6342', '2022-11-12', '623', 'Herrick Tudgay', 13);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '9364 9941 3870 7807', '2022-03-26', '285', 'Lutero Thompkins', 14);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '6226 4896 5932 7086', '2022-12-07', '880', 'Ford Pearman', 15);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '3644 1786 3994 8511', '2022-06-18', '180', 'Alejoa Craigmyle', 16);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '2846 9288 0548 5463', '2021-11-14', '739', 'Cecilio Duberry', 17);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '8686 0069 0096 5460', '2022-05-10', '301', 'Othello Paniman', 18);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '5288 1563 4605 2297', '2022-04-24', '792', 'Adair Halling', 19);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '5271 2973 6888 1819', '2021-07-28', '209', 'Phelia Saer', 20);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '2509 5004 7475 1396', '2022-05-21', '684', 'Zara Elvish', 21);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '3132 2699 1375 7617', '2021-07-20', '177', 'Bel Losselyong', 22);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '0041 2335 4609 7594', '2023-02-18', '866', 'Liane Dahlbom', 23);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '3257 4941 7297 1609', '2021-03-13', '681', 'Livia Herculeson', 24);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '0010 5918 5476 8531', '2021-08-11', '118', 'Ulberto Miquelet', 25);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '1192 5967 4519 6982', '2022-09-28', '920', 'Esta Bento', 26);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '7008 2417 1877 7451', '2023-01-26', '517', 'Britteny Grigoroni', 27);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '9726 7193 2070 2920', '2021-06-14', '620', 'Jeramie Mullinder', 28);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '3280 6866 7409 4867', '2021-07-02', '787', 'Linn Griggs', 29);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '1678 3109 7509 7179', '2021-10-08', '320', 'Simone Callard', 30);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '3731 0785 6657 7549', '2022-08-12', '724', 'Phylis Gable', 31);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '3115 1778 1810 0952', '2022-06-02', '148', 'Marcelo Mapston', 32);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '8087 0855 8522 3183', '2022-08-03', '201', 'Brenda Jedrzaszkiewicz', 33);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '0248 3168 5863 7445', '2022-04-13', '479', 'Gwendolyn Davley', 34);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '2327 2919 8319 6840', '2021-04-29', '678', 'Hortensia Wands', 35);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '8188 5779 6796 1484', '2022-09-11', '786', 'Gabbi Matchett', 36);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '5422 6122 0805 6047', '2021-09-03', '197', 'Marv Spencelayh', 37);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '8237 7455 8098 6797', '2022-07-29', '461', 'Arney Bockh', 38);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '3453 3275 0458 3189', '2021-12-12', '145', 'Bili Blench', 39);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '3354 2451 5019 1085', '2022-08-04', '180', 'Bertram Hinnerk', 40);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '7873 6762 9644 4906', '2022-09-27', '927', 'Philippine Kippax', 41);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '0869 9624 3275 0323', '2021-07-28', '974', 'Mirelle Tschursch', 42);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '5637 5744 8787 0991', '2021-04-23', '133', 'Manuel Duxbarry', 43);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '4769 1873 8041 0937', '2021-04-06', '615', 'Shanan Kirsz', 44);
insert into credit_cards (card_n, expiration, cvv, holder, client_id) values ( '7612 4201 1143 6932', '2021-09-06', '143', 'Pincas Issard', 45);

insert into item_tag (tag_id, item_id) values (1, 5);
insert into item_tag (tag_id, item_id) values (1, 36);
insert into item_tag (tag_id, item_id) values (1, 75);
insert into item_tag (tag_id, item_id) values (2, 2);
insert into item_tag (tag_id, item_id) values (2, 6);
insert into item_tag (tag_id, item_id) values (2, 39);
insert into item_tag (tag_id, item_id) values (2, 45);
insert into item_tag (tag_id, item_id) values (2, 53);
insert into item_tag (tag_id, item_id) values (2, 64);
insert into item_tag (tag_id, item_id) values (2, 77);
insert into item_tag (tag_id, item_id) values (2, 87);
insert into item_tag (tag_id, item_id) values (3, 11);
insert into item_tag (tag_id, item_id) values (3, 88);
insert into item_tag (tag_id, item_id) values (4, 29);
insert into item_tag (tag_id, item_id) values (4, 45);
insert into item_tag (tag_id, item_id) values (4, 67);
insert into item_tag (tag_id, item_id) values (4, 87);
insert into item_tag (tag_id, item_id) values (4, 89);
insert into item_tag (tag_id, item_id) values (6, 31);
insert into item_tag (tag_id, item_id) values (6, 52);
insert into item_tag (tag_id, item_id) values (6, 69);
insert into item_tag (tag_id, item_id) values (6, 93);
insert into item_tag (tag_id, item_id) values (7, 9);
insert into item_tag (tag_id, item_id) values (7, 43);
insert into item_tag (tag_id, item_id) values (7, 68);
insert into item_tag (tag_id, item_id) values (7, 83);
insert into item_tag (tag_id, item_id) values (7, 88);
insert into item_tag (tag_id, item_id) values (7, 90);
insert into item_tag (tag_id, item_id) values (7, 95);
insert into item_tag (tag_id, item_id) values (8, 5);
insert into item_tag (tag_id, item_id) values (8, 17);
insert into item_tag (tag_id, item_id) values (8, 47);
insert into item_tag (tag_id, item_id) values (8, 55);
insert into item_tag (tag_id, item_id) values (9, 9);
insert into item_tag (tag_id, item_id) values (9, 84);
insert into item_tag (tag_id, item_id) values (10, 10);
insert into item_tag (tag_id, item_id) values (10, 21);
insert into item_tag (tag_id, item_id) values (10, 27);
insert into item_tag (tag_id, item_id) values (10, 51);
insert into item_tag (tag_id, item_id) values (11, 17);
insert into item_tag (tag_id, item_id) values (11, 61);
insert into item_tag (tag_id, item_id) values (11, 70);
insert into item_tag (tag_id, item_id) values (11, 90);
insert into item_tag (tag_id, item_id) values (11, 96);
insert into item_tag (tag_id, item_id) values (12, 7);
insert into item_tag (tag_id, item_id) values (12, 28);
insert into item_tag (tag_id, item_id) values (12, 34);
insert into item_tag (tag_id, item_id) values (12, 37);
insert into item_tag (tag_id, item_id) values (12, 42);
insert into item_tag (tag_id, item_id) values (12, 43);
insert into item_tag (tag_id, item_id) values (13, 1);
insert into item_tag (tag_id, item_id) values (13, 8);
insert into item_tag (tag_id, item_id) values (14, 74);
insert into item_tag (tag_id, item_id) values (14, 95);
insert into item_tag (tag_id, item_id) values (15, 13);
insert into item_tag (tag_id, item_id) values (15, 35);
insert into item_tag (tag_id, item_id) values (15, 44);
insert into item_tag (tag_id, item_id) values (15, 49);
insert into item_tag (tag_id, item_id) values (15, 65);
insert into item_tag (tag_id, item_id) values (15, 86);
insert into item_tag (tag_id, item_id) values (15, 100);
insert into item_tag (tag_id, item_id) values (16, 1);
insert into item_tag (tag_id, item_id) values (16, 42);
insert into item_tag (tag_id, item_id) values (16, 55);
insert into item_tag (tag_id, item_id) values (16, 90);
insert into item_tag (tag_id, item_id) values (17, 9);
insert into item_tag (tag_id, item_id) values (17, 13);
insert into item_tag (tag_id, item_id) values (17, 36);
insert into item_tag (tag_id, item_id) values (18, 12);
insert into item_tag (tag_id, item_id) values (18, 60);
insert into item_tag (tag_id, item_id) values (18, 72);
insert into item_tag (tag_id, item_id) values (19, 36);
insert into item_tag (tag_id, item_id) values (19, 71);
insert into item_tag (tag_id, item_id) values (19, 76);
insert into item_tag (tag_id, item_id) values (20, 49);
insert into item_tag (tag_id, item_id) values (20, 76);
insert into item_tag (tag_id, item_id) values (21, 46);
insert into item_tag (tag_id, item_id) values (22, 35);
insert into item_tag (tag_id, item_id) values (22, 67);
insert into item_tag (tag_id, item_id) values (22, 76);
insert into item_tag (tag_id, item_id) values (23, 9);
insert into item_tag (tag_id, item_id) values (23, 12);
insert into item_tag (tag_id, item_id) values (23, 57);
insert into item_tag (tag_id, item_id) values (24, 12);
insert into item_tag (tag_id, item_id) values (24, 26);
insert into item_tag (tag_id, item_id) values (24, 42);
insert into item_tag (tag_id, item_id) values (24, 63);
insert into item_tag (tag_id, item_id) values (24, 70);
insert into item_tag (tag_id, item_id) values (25, 12);
insert into item_tag (tag_id, item_id) values (25, 24);
insert into item_tag (tag_id, item_id) values (25, 26);
insert into item_tag (tag_id, item_id) values (25, 91);
insert into item_tag (tag_id, item_id) values (27, 23);
insert into item_tag (tag_id, item_id) values (27, 26);
insert into item_tag (tag_id, item_id) values (27, 28);
insert into item_tag (tag_id, item_id) values (27, 58);
insert into item_tag (tag_id, item_id) values (27, 73);
insert into item_tag (tag_id, item_id) values (27, 74);
insert into item_tag (tag_id, item_id) values (28, 1);
insert into item_tag (tag_id, item_id) values (28, 35);
insert into item_tag (tag_id, item_id) values (28, 54);
insert into item_tag (tag_id, item_id) values (29, 70);
insert into item_tag (tag_id, item_id) values (29, 84);
insert into item_tag (tag_id, item_id) values (30, 24);
insert into item_tag (tag_id, item_id) values (31, 26);
insert into item_tag (tag_id, item_id) values (31, 46);
insert into item_tag (tag_id, item_id) values (31, 64);
insert into item_tag (tag_id, item_id) values (31, 69);
insert into item_tag (tag_id, item_id) values (31, 74);
insert into item_tag (tag_id, item_id) values (31, 95);
insert into item_tag (tag_id, item_id) values (32, 92);
insert into item_tag (tag_id, item_id) values (32, 98);
insert into item_tag (tag_id, item_id) values (33, 33);
insert into item_tag (tag_id, item_id) values (33, 68);
insert into item_tag (tag_id, item_id) values (33, 77);
insert into item_tag (tag_id, item_id) values (33, 93);
insert into item_tag (tag_id, item_id) values (34, 26);
insert into item_tag (tag_id, item_id) values (34, 33);
insert into item_tag (tag_id, item_id) values (34, 55);
insert into item_tag (tag_id, item_id) values (35, 10);
insert into item_tag (tag_id, item_id) values (35, 54);
insert into item_tag (tag_id, item_id) values (36, 52);
insert into item_tag (tag_id, item_id) values (36, 78);
insert into item_tag (tag_id, item_id) values (37, 11);
insert into item_tag (tag_id, item_id) values (37, 34);
insert into item_tag (tag_id, item_id) values (37, 38);
insert into item_tag (tag_id, item_id) values (38, 8);
insert into item_tag (tag_id, item_id) values (38, 24);
insert into item_tag (tag_id, item_id) values (38, 61);
insert into item_tag (tag_id, item_id) values (38, 65);
insert into item_tag (tag_id, item_id) values (39, 64);
insert into item_tag (tag_id, item_id) values (40, 33);
insert into item_tag (tag_id, item_id) values (40, 69);
insert into item_tag (tag_id, item_id) values (40, 82);
insert into item_tag (tag_id, item_id) values (40, 98);
insert into item_tag (tag_id, item_id) values (41, 62);
insert into item_tag (tag_id, item_id) values (42, 36);
insert into item_tag (tag_id, item_id) values (42, 60);
insert into item_tag (tag_id, item_id) values (42, 78);
insert into item_tag (tag_id, item_id) values (42, 87);
insert into item_tag (tag_id, item_id) values (43, 13);
insert into item_tag (tag_id, item_id) values (43, 15);
insert into item_tag (tag_id, item_id) values (43, 74);
insert into item_tag (tag_id, item_id) values (43, 90);
insert into item_tag (tag_id, item_id) values (44, 42);
insert into item_tag (tag_id, item_id) values (44, 45);
insert into item_tag (tag_id, item_id) values (44, 63);
insert into item_tag (tag_id, item_id) values (44, 71);
insert into item_tag (tag_id, item_id) values (45, 25);
insert into item_tag (tag_id, item_id) values (45, 29);
insert into item_tag (tag_id, item_id) values (45, 56);
insert into item_tag (tag_id, item_id) values (45, 99);
insert into item_tag (tag_id, item_id) values (46, 8);
insert into item_tag (tag_id, item_id) values (46, 14);
insert into item_tag (tag_id, item_id) values (48, 5);
insert into item_tag (tag_id, item_id) values (48, 51);
insert into item_tag (tag_id, item_id) values (48, 53);
insert into item_tag (tag_id, item_id) values (49, 28);
insert into item_tag (tag_id, item_id) values (50, 44);
insert into item_tag (tag_id, item_id) values (50, 92);
insert into item_tag (tag_id, item_id) values (51, 12);
insert into item_tag (tag_id, item_id) values (52, 20);
insert into item_tag (tag_id, item_id) values (52, 45);
insert into item_tag (tag_id, item_id) values (52, 74);
insert into item_tag (tag_id, item_id) values (53, 55);
insert into item_tag (tag_id, item_id) values (54, 60);
insert into item_tag (tag_id, item_id) values (54, 70);
insert into item_tag (tag_id, item_id) values (55, 9);
insert into item_tag (tag_id, item_id) values (55, 28);
insert into item_tag (tag_id, item_id) values (55, 32);
insert into item_tag (tag_id, item_id) values (55, 46);
insert into item_tag (tag_id, item_id) values (56, 6);
insert into item_tag (tag_id, item_id) values (56, 41);
insert into item_tag (tag_id, item_id) values (56, 54);
insert into item_tag (tag_id, item_id) values (56, 95);
insert into item_tag (tag_id, item_id) values (57, 40);
insert into item_tag (tag_id, item_id) values (57, 61);
insert into item_tag (tag_id, item_id) values (57, 73);
insert into item_tag (tag_id, item_id) values (57, 90);
insert into item_tag (tag_id, item_id) values (58, 4);
insert into item_tag (tag_id, item_id) values (58, 20);
insert into item_tag (tag_id, item_id) values (58, 30);
insert into item_tag (tag_id, item_id) values (58, 49);
insert into item_tag (tag_id, item_id) values (58, 65);
insert into item_tag (tag_id, item_id) values (59, 23);
insert into item_tag (tag_id, item_id) values (59, 39);
insert into item_tag (tag_id, item_id) values (59, 44);
insert into item_tag (tag_id, item_id) values (61, 18);
insert into item_tag (tag_id, item_id) values (61, 39);
insert into item_tag (tag_id, item_id) values (61, 47);
insert into item_tag (tag_id, item_id) values (61, 91);
insert into item_tag (tag_id, item_id) values (61, 100);
insert into item_tag (tag_id, item_id) values (62, 3);
insert into item_tag (tag_id, item_id) values (62, 50);
insert into item_tag (tag_id, item_id) values (63, 99);
insert into item_tag (tag_id, item_id) values (64, 89);
insert into item_tag (tag_id, item_id) values (65, 21);
insert into item_tag (tag_id, item_id) values (65, 23);
insert into item_tag (tag_id, item_id) values (65, 44);
insert into item_tag (tag_id, item_id) values (65, 52);
insert into item_tag (tag_id, item_id) values (66, 15);
insert into item_tag (tag_id, item_id) values (66, 28);
insert into item_tag (tag_id, item_id) values (67, 83);
insert into item_tag (tag_id, item_id) values (67, 86);
insert into item_tag (tag_id, item_id) values (68, 20);
insert into item_tag (tag_id, item_id) values (68, 23);
insert into item_tag (tag_id, item_id) values (68, 26);
insert into item_tag (tag_id, item_id) values (68, 28);
insert into item_tag (tag_id, item_id) values (68, 86);
insert into item_tag (tag_id, item_id) values (69, 54);
insert into item_tag (tag_id, item_id) values (69, 67);
insert into item_tag (tag_id, item_id) values (69, 83);
insert into item_tag (tag_id, item_id) values (69, 86);
insert into item_tag (tag_id, item_id) values (70, 19);
insert into item_tag (tag_id, item_id) values (70, 25);
insert into item_tag (tag_id, item_id) values (70, 45);
insert into item_tag (tag_id, item_id) values (71, 21);
insert into item_tag (tag_id, item_id) values (71, 90);
insert into item_tag (tag_id, item_id) values (73, 44);
insert into item_tag (tag_id, item_id) values (73, 70);
insert into item_tag (tag_id, item_id) values (74, 36);
insert into item_tag (tag_id, item_id) values (74, 40);
insert into item_tag (tag_id, item_id) values (74, 42);
insert into item_tag (tag_id, item_id) values (74, 52);
insert into item_tag (tag_id, item_id) values (74, 99);
insert into item_tag (tag_id, item_id) values (75, 7);
insert into item_tag (tag_id, item_id) values (76, 7);
insert into item_tag (tag_id, item_id) values (76, 68);
insert into item_tag (tag_id, item_id) values (77, 43);
insert into item_tag (tag_id, item_id) values (78, 60);
insert into item_tag (tag_id, item_id) values (80, 2);
insert into item_tag (tag_id, item_id) values (80, 43);
insert into item_tag (tag_id, item_id) values (80, 71);
insert into item_tag (tag_id, item_id) values (81, 27);
insert into item_tag (tag_id, item_id) values (81, 29);
insert into item_tag (tag_id, item_id) values (81, 39);
insert into item_tag (tag_id, item_id) values (81, 48);
insert into item_tag (tag_id, item_id) values (81, 49);
insert into item_tag (tag_id, item_id) values (81, 81);
insert into item_tag (tag_id, item_id) values (82, 58);
insert into item_tag (tag_id, item_id) values (82, 68);
insert into item_tag (tag_id, item_id) values (82, 77);
insert into item_tag (tag_id, item_id) values (82, 87);
insert into item_tag (tag_id, item_id) values (83, 7);
insert into item_tag (tag_id, item_id) values (83, 40);
insert into item_tag (tag_id, item_id) values (83, 44);
insert into item_tag (tag_id, item_id) values (83, 99);
insert into item_tag (tag_id, item_id) values (84, 6);
insert into item_tag (tag_id, item_id) values (84, 56);
insert into item_tag (tag_id, item_id) values (84, 67);
insert into item_tag (tag_id, item_id) values (85, 22);
insert into item_tag (tag_id, item_id) values (85, 35);
insert into item_tag (tag_id, item_id) values (86, 20);
insert into item_tag (tag_id, item_id) values (86, 32);
insert into item_tag (tag_id, item_id) values (86, 44);
insert into item_tag (tag_id, item_id) values (87, 33);
insert into item_tag (tag_id, item_id) values (87, 80);
insert into item_tag (tag_id, item_id) values (88, 12);
insert into item_tag (tag_id, item_id) values (88, 52);
insert into item_tag (tag_id, item_id) values (88, 58);
insert into item_tag (tag_id, item_id) values (88, 82);
insert into item_tag (tag_id, item_id) values (89, 4);
insert into item_tag (tag_id, item_id) values (89, 91);
insert into item_tag (tag_id, item_id) values (90, 10);
insert into item_tag (tag_id, item_id) values (90, 15);
insert into item_tag (tag_id, item_id) values (90, 27);
insert into item_tag (tag_id, item_id) values (90, 65);
insert into item_tag (tag_id, item_id) values (91, 19);
insert into item_tag (tag_id, item_id) values (91, 21);
insert into item_tag (tag_id, item_id) values (92, 26);
insert into item_tag (tag_id, item_id) values (92, 56);
insert into item_tag (tag_id, item_id) values (93, 17);
insert into item_tag (tag_id, item_id) values (93, 38);
insert into item_tag (tag_id, item_id) values (93, 44);
insert into item_tag (tag_id, item_id) values (93, 71);
insert into item_tag (tag_id, item_id) values (94, 40);
insert into item_tag (tag_id, item_id) values (94, 84);
insert into item_tag (tag_id, item_id) values (95, 14);
insert into item_tag (tag_id, item_id) values (95, 23);
insert into item_tag (tag_id, item_id) values (95, 33);
insert into item_tag (tag_id, item_id) values (95, 76);
insert into item_tag (tag_id, item_id) values (96, 71);
insert into item_tag (tag_id, item_id) values (96, 100);
insert into item_tag (tag_id, item_id) values (97, 25);
insert into item_tag (tag_id, item_id) values (97, 45);
insert into item_tag (tag_id, item_id) values (97, 59);
insert into item_tag (tag_id, item_id) values (97, 80);
insert into item_tag (tag_id, item_id) values (98, 78);
insert into item_tag (tag_id, item_id) values (99, 60);
insert into item_tag (tag_id, item_id) values (100, 7);
insert into item_tag (tag_id, item_id) values (100, 20);
insert into item_tag (tag_id, item_id) values (100, 31);
insert into item_tag (tag_id, item_id) values (100, 57);
insert into item_tag (tag_id, item_id) values (100, 61);
insert into item_tag (tag_id, item_id) values (100, 73);

insert into client_item (client_id, item_id) values (1, 41);
insert into client_item (client_id, item_id) values (1, 78);
insert into client_item (client_id, item_id) values (2, 24);
insert into client_item (client_id, item_id) values (2, 61);
insert into client_item (client_id, item_id) values (3, 19);
insert into client_item (client_id, item_id) values (3, 35);
insert into client_item (client_id, item_id) values (3, 45);
insert into client_item (client_id, item_id) values (3, 66);
insert into client_item (client_id, item_id) values (3, 82);
insert into client_item (client_id, item_id) values (4, 23);
insert into client_item (client_id, item_id) values (4, 29);
insert into client_item (client_id, item_id) values (4, 44);
insert into client_item (client_id, item_id) values (4, 47);
insert into client_item (client_id, item_id) values (4, 48);
insert into client_item (client_id, item_id) values (4, 56);
insert into client_item (client_id, item_id) values (4, 77);
insert into client_item (client_id, item_id) values (4, 95);
insert into client_item (client_id, item_id) values (4, 98);
insert into client_item (client_id, item_id) values (5, 7);
insert into client_item (client_id, item_id) values (5, 20);
insert into client_item (client_id, item_id) values (5, 43);
insert into client_item (client_id, item_id) values (6, 6);
insert into client_item (client_id, item_id) values (6, 16);
insert into client_item (client_id, item_id) values (6, 17);
insert into client_item (client_id, item_id) values (6, 33);
insert into client_item (client_id, item_id) values (6, 42);
insert into client_item (client_id, item_id) values (6, 45);
insert into client_item (client_id, item_id) values (6, 82);
insert into client_item (client_id, item_id) values (6, 96);
insert into client_item (client_id, item_id) values (7, 61);
insert into client_item (client_id, item_id) values (7, 80);
insert into client_item (client_id, item_id) values (7, 92);
insert into client_item (client_id, item_id) values (8, 14);
insert into client_item (client_id, item_id) values (8, 15);
insert into client_item (client_id, item_id) values (8, 20);
insert into client_item (client_id, item_id) values (8, 30);
insert into client_item (client_id, item_id) values (8, 38);
insert into client_item (client_id, item_id) values (8, 41);
insert into client_item (client_id, item_id) values (8, 52);
insert into client_item (client_id, item_id) values (8, 60);
insert into client_item (client_id, item_id) values (8, 75);
insert into client_item (client_id, item_id) values (8, 91);
insert into client_item (client_id, item_id) values (9, 12);
insert into client_item (client_id, item_id) values (9, 18);
insert into client_item (client_id, item_id) values (9, 36);
insert into client_item (client_id, item_id) values (9, 47);
insert into client_item (client_id, item_id) values (9, 94);
insert into client_item (client_id, item_id) values (10, 17);
insert into client_item (client_id, item_id) values (10, 27);
insert into client_item (client_id, item_id) values (10, 28);
insert into client_item (client_id, item_id) values (10, 45);
insert into client_item (client_id, item_id) values (10, 60);
insert into client_item (client_id, item_id) values (10, 67);
insert into client_item (client_id, item_id) values (10, 70);
insert into client_item (client_id, item_id) values (10, 77);
insert into client_item (client_id, item_id) values (11, 38);
insert into client_item (client_id, item_id) values (11, 50);
insert into client_item (client_id, item_id) values (11, 65);
insert into client_item (client_id, item_id) values (11, 82);
insert into client_item (client_id, item_id) values (11, 83);
insert into client_item (client_id, item_id) values (11, 86);
insert into client_item (client_id, item_id) values (11, 93);
insert into client_item (client_id, item_id) values (12, 24);
insert into client_item (client_id, item_id) values (12, 34);
insert into client_item (client_id, item_id) values (12, 44);
insert into client_item (client_id, item_id) values (12, 54);
insert into client_item (client_id, item_id) values (12, 79);
insert into client_item (client_id, item_id) values (12, 82);
insert into client_item (client_id, item_id) values (12, 93);
insert into client_item (client_id, item_id) values (13, 49);
insert into client_item (client_id, item_id) values (14, 43);
insert into client_item (client_id, item_id) values (14, 61);
insert into client_item (client_id, item_id) values (14, 81);
insert into client_item (client_id, item_id) values (14, 90);
insert into client_item (client_id, item_id) values (14, 95);
insert into client_item (client_id, item_id) values (14, 99);
insert into client_item (client_id, item_id) values (15, 90);
insert into client_item (client_id, item_id) values (16, 41);
insert into client_item (client_id, item_id) values (16, 42);
insert into client_item (client_id, item_id) values (16, 75);
insert into client_item (client_id, item_id) values (17, 58);
insert into client_item (client_id, item_id) values (17, 69);
insert into client_item (client_id, item_id) values (17, 87);
insert into client_item (client_id, item_id) values (18, 9);
insert into client_item (client_id, item_id) values (18, 28);
insert into client_item (client_id, item_id) values (18, 46);
insert into client_item (client_id, item_id) values (18, 75);
insert into client_item (client_id, item_id) values (18, 99);
insert into client_item (client_id, item_id) values (19, 16);
insert into client_item (client_id, item_id) values (19, 25);
insert into client_item (client_id, item_id) values (19, 39);
insert into client_item (client_id, item_id) values (19, 42);
insert into client_item (client_id, item_id) values (19, 91);
insert into client_item (client_id, item_id) values (20, 12);
insert into client_item (client_id, item_id) values (20, 13);
insert into client_item (client_id, item_id) values (20, 25);
insert into client_item (client_id, item_id) values (20, 36);
insert into client_item (client_id, item_id) values (20, 50);
insert into client_item (client_id, item_id) values (20, 60);
insert into client_item (client_id, item_id) values (20, 74);
insert into client_item (client_id, item_id) values (20, 91);
insert into client_item (client_id, item_id) values (20, 92);
insert into client_item (client_id, item_id) values (21, 5);
insert into client_item (client_id, item_id) values (21, 10);
insert into client_item (client_id, item_id) values (21, 19);
insert into client_item (client_id, item_id) values (21, 32);
insert into client_item (client_id, item_id) values (21, 55);
insert into client_item (client_id, item_id) values (22, 12);
insert into client_item (client_id, item_id) values (22, 19);
insert into client_item (client_id, item_id) values (22, 55);
insert into client_item (client_id, item_id) values (22, 56);
insert into client_item (client_id, item_id) values (22, 87);
insert into client_item (client_id, item_id) values (23, 30);
insert into client_item (client_id, item_id) values (23, 51);
insert into client_item (client_id, item_id) values (23, 52);
insert into client_item (client_id, item_id) values (24, 30);
insert into client_item (client_id, item_id) values (24, 35);
insert into client_item (client_id, item_id) values (24, 84);
insert into client_item (client_id, item_id) values (25, 42);
insert into client_item (client_id, item_id) values (25, 44);
insert into client_item (client_id, item_id) values (25, 70);
insert into client_item (client_id, item_id) values (25, 98);
insert into client_item (client_id, item_id) values (26, 18);
insert into client_item (client_id, item_id) values (26, 53);
insert into client_item (client_id, item_id) values (26, 64);
insert into client_item (client_id, item_id) values (27, 36);
insert into client_item (client_id, item_id) values (27, 83);
insert into client_item (client_id, item_id) values (27, 86);
insert into client_item (client_id, item_id) values (28, 33);
insert into client_item (client_id, item_id) values (28, 52);
insert into client_item (client_id, item_id) values (28, 87);
insert into client_item (client_id, item_id) values (28, 91);
insert into client_item (client_id, item_id) values (28, 100);
insert into client_item (client_id, item_id) values (29, 34);
insert into client_item (client_id, item_id) values (29, 44);
insert into client_item (client_id, item_id) values (29, 71);
insert into client_item (client_id, item_id) values (29, 80);
insert into client_item (client_id, item_id) values (29, 82);
insert into client_item (client_id, item_id) values (29, 90);
insert into client_item (client_id, item_id) values (30, 8);
insert into client_item (client_id, item_id) values (30, 59);
insert into client_item (client_id, item_id) values (30, 85);
insert into client_item (client_id, item_id) values (30, 86);
insert into client_item (client_id, item_id) values (31, 31);
insert into client_item (client_id, item_id) values (31, 37);
insert into client_item (client_id, item_id) values (31, 77);
insert into client_item (client_id, item_id) values (31, 87);
insert into client_item (client_id, item_id) values (32, 14);
insert into client_item (client_id, item_id) values (32, 64);
insert into client_item (client_id, item_id) values (32, 70);
insert into client_item (client_id, item_id) values (32, 81);
insert into client_item (client_id, item_id) values (33, 42);
insert into client_item (client_id, item_id) values (33, 55);
insert into client_item (client_id, item_id) values (33, 60);
insert into client_item (client_id, item_id) values (33, 61);
insert into client_item (client_id, item_id) values (33, 64);
insert into client_item (client_id, item_id) values (33, 68);
insert into client_item (client_id, item_id) values (34, 14);
insert into client_item (client_id, item_id) values (34, 15);
insert into client_item (client_id, item_id) values (34, 86);
insert into client_item (client_id, item_id) values (35, 8);
insert into client_item (client_id, item_id) values (35, 15);
insert into client_item (client_id, item_id) values (35, 62);
insert into client_item (client_id, item_id) values (35, 65);
insert into client_item (client_id, item_id) values (35, 77);
insert into client_item (client_id, item_id) values (35, 80);
insert into client_item (client_id, item_id) values (36, 16);
insert into client_item (client_id, item_id) values (36, 18);
insert into client_item (client_id, item_id) values (36, 62);
insert into client_item (client_id, item_id) values (36, 80);
insert into client_item (client_id, item_id) values (36, 88);
insert into client_item (client_id, item_id) values (36, 97);
insert into client_item (client_id, item_id) values (37, 37);
insert into client_item (client_id, item_id) values (37, 97);
insert into client_item (client_id, item_id) values (38, 41);
insert into client_item (client_id, item_id) values (38, 67);
insert into client_item (client_id, item_id) values (38, 73);
insert into client_item (client_id, item_id) values (39, 36);
insert into client_item (client_id, item_id) values (39, 49);
insert into client_item (client_id, item_id) values (39, 58);
insert into client_item (client_id, item_id) values (39, 61);
insert into client_item (client_id, item_id) values (39, 62);
insert into client_item (client_id, item_id) values (39, 79);
insert into client_item (client_id, item_id) values (40, 13);
insert into client_item (client_id, item_id) values (40, 32);
insert into client_item (client_id, item_id) values (40, 52);
insert into client_item (client_id, item_id) values (40, 64);
insert into client_item (client_id, item_id) values (40, 82);
insert into client_item (client_id, item_id) values (40, 89);
insert into client_item (client_id, item_id) values (40, 90);
insert into client_item (client_id, item_id) values (41, 16);
insert into client_item (client_id, item_id) values (41, 44);
insert into client_item (client_id, item_id) values (41, 53);
insert into client_item (client_id, item_id) values (41, 75);
insert into client_item (client_id, item_id) values (41, 92);
insert into client_item (client_id, item_id) values (42, 16);
insert into client_item (client_id, item_id) values (42, 25);
insert into client_item (client_id, item_id) values (42, 26);
insert into client_item (client_id, item_id) values (42, 53);
insert into client_item (client_id, item_id) values (42, 80);
insert into client_item (client_id, item_id) values (42, 87);
insert into client_item (client_id, item_id) values (42, 88);
insert into client_item (client_id, item_id) values (42, 91);
insert into client_item (client_id, item_id) values (42, 95);
insert into client_item (client_id, item_id) values (43, 34);
insert into client_item (client_id, item_id) values (43, 43);
insert into client_item (client_id, item_id) values (43, 51);
insert into client_item (client_id, item_id) values (43, 66);
insert into client_item (client_id, item_id) values (43, 73);
insert into client_item (client_id, item_id) values (44, 4);
insert into client_item (client_id, item_id) values (44, 59);
insert into client_item (client_id, item_id) values (44, 64);
insert into client_item (client_id, item_id) values (44, 70);
insert into client_item (client_id, item_id) values (44, 76);
insert into client_item (client_id, item_id) values (44, 79);
insert into client_item (client_id, item_id) values (44, 89);
insert into client_item (client_id, item_id) values (44, 94);
insert into client_item (client_id, item_id) values (45, 9);
insert into client_item (client_id, item_id) values (45, 18);
insert into client_item (client_id, item_id) values (45, 57);
insert into client_item (client_id, item_id) values (46, 12);
insert into client_item (client_id, item_id) values (46, 15);
insert into client_item (client_id, item_id) values (46, 30);
insert into client_item (client_id, item_id) values (46, 69);
insert into client_item (client_id, item_id) values (46, 74);
insert into client_item (client_id, item_id) values (46, 94);
insert into client_item (client_id, item_id) values (47, 92);
insert into client_item (client_id, item_id) values (47, 99);
insert into client_item (client_id, item_id) values (48, 8);
insert into client_item (client_id, item_id) values (48, 27);
insert into client_item (client_id, item_id) values (48, 41);
insert into client_item (client_id, item_id) values (48, 46);
insert into client_item (client_id, item_id) values (48, 62);
insert into client_item (client_id, item_id) values (49, 5);
insert into client_item (client_id, item_id) values (49, 14);
insert into client_item (client_id, item_id) values (49, 15);
insert into client_item (client_id, item_id) values (49, 35);
insert into client_item (client_id, item_id) values (49, 95);
insert into client_item (client_id, item_id) values (50, 30);
insert into client_item (client_id, item_id) values (50, 61);
insert into client_item (client_id, item_id) values (50, 74);
insert into client_item (client_id, item_id) values (50, 94);

insert into carts (client_id, item_id, quantity) values (1, 2, 1);
insert into carts (client_id, item_id, quantity) values (1, 6, 1);
insert into carts (client_id, item_id, quantity) values (1, 9, 1);
insert into carts (client_id, item_id, quantity) values (1, 14, 1);
insert into carts (client_id, item_id, quantity) values (1, 24, 1);
insert into carts (client_id, item_id, quantity) values (1, 93, 1);
insert into carts (client_id, item_id, quantity) values (2, 9, 1);
insert into carts (client_id, item_id, quantity) values (2, 24, 1);
insert into carts (client_id, item_id, quantity) values (2, 57, 1);
insert into carts (client_id, item_id, quantity) values (2, 94, 1);
insert into carts (client_id, item_id, quantity) values (3, 3, 1);
insert into carts (client_id, item_id, quantity) values (3, 18, 1);
insert into carts (client_id, item_id, quantity) values (3, 32, 1);
insert into carts (client_id, item_id, quantity) values (3, 39, 1);
insert into carts (client_id, item_id, quantity) values (4, 3, 1);
insert into carts (client_id, item_id, quantity) values (4, 26, 1);
insert into carts (client_id, item_id, quantity) values (4, 61, 1);
insert into carts (client_id, item_id, quantity) values (4, 69, 1);
insert into carts (client_id, item_id, quantity) values (4, 81, 1);
insert into carts (client_id, item_id, quantity) values (4, 85, 1);
insert into carts (client_id, item_id, quantity) values (4, 98, 1);
insert into carts (client_id, item_id, quantity) values (5, 49, 1);
insert into carts (client_id, item_id, quantity) values (5, 78, 1);
insert into carts (client_id, item_id, quantity) values (5, 90, 1);
insert into carts (client_id, item_id, quantity) values (5, 94, 1);
insert into carts (client_id, item_id, quantity) values (6, 16, 1);
insert into carts (client_id, item_id, quantity) values (6, 32, 1);
insert into carts (client_id, item_id, quantity) values (6, 33, 1);
insert into carts (client_id, item_id, quantity) values (6, 41, 1);
insert into carts (client_id, item_id, quantity) values (6, 45, 1);
insert into carts (client_id, item_id, quantity) values (6, 83, 1);
insert into carts (client_id, item_id, quantity) values (7, 34, 1);
insert into carts (client_id, item_id, quantity) values (7, 64, 1);
insert into carts (client_id, item_id, quantity) values (7, 71, 1);
insert into carts (client_id, item_id, quantity) values (7, 77, 1);
insert into carts (client_id, item_id, quantity) values (8, 13, 1);
insert into carts (client_id, item_id, quantity) values (8, 23, 1);
insert into carts (client_id, item_id, quantity) values (8, 25, 1);
insert into carts (client_id, item_id, quantity) values (8, 38, 1);
insert into carts (client_id, item_id, quantity) values (8, 89, 1);
insert into carts (client_id, item_id, quantity) values (9, 30, 1);
insert into carts (client_id, item_id, quantity) values (9, 55, 1);
insert into carts (client_id, item_id, quantity) values (9, 56, 1);
insert into carts (client_id, item_id, quantity) values (9, 69, 1);
insert into carts (client_id, item_id, quantity) values (10, 25, 1);
insert into carts (client_id, item_id, quantity) values (10, 48, 1);
insert into carts (client_id, item_id, quantity) values (10, 51, 1);
insert into carts (client_id, item_id, quantity) values (10, 60, 1);
insert into carts (client_id, item_id, quantity) values (10, 87, 1);
insert into carts (client_id, item_id, quantity) values (11, 18, 1);
insert into carts (client_id, item_id, quantity) values (11, 84, 1);
insert into carts (client_id, item_id, quantity) values (11, 85, 1);
insert into carts (client_id, item_id, quantity) values (12, 13, 1);
insert into carts (client_id, item_id, quantity) values (12, 15, 1);
insert into carts (client_id, item_id, quantity) values (12, 27, 1);
insert into carts (client_id, item_id, quantity) values (12, 49, 1);
insert into carts (client_id, item_id, quantity) values (12, 86, 1);
insert into carts (client_id, item_id, quantity) values (13, 12, 1);
insert into carts (client_id, item_id, quantity) values (13, 13, 1);
insert into carts (client_id, item_id, quantity) values (13, 19, 1);
insert into carts (client_id, item_id, quantity) values (13, 35, 1);
insert into carts (client_id, item_id, quantity) values (13, 38, 1);
insert into carts (client_id, item_id, quantity) values (13, 39, 1);
insert into carts (client_id, item_id, quantity) values (13, 93, 1);
insert into carts (client_id, item_id, quantity) values (14, 8, 1);
insert into carts (client_id, item_id, quantity) values (14, 49, 1);
insert into carts (client_id, item_id, quantity) values (14, 95, 1);
insert into carts (client_id, item_id, quantity) values (15, 21, 1);
insert into carts (client_id, item_id, quantity) values (15, 24, 1);
insert into carts (client_id, item_id, quantity) values (15, 32, 1);
insert into carts (client_id, item_id, quantity) values (15, 57, 1);
insert into carts (client_id, item_id, quantity) values (15, 65, 1);
insert into carts (client_id, item_id, quantity) values (15, 75, 1);
insert into carts (client_id, item_id, quantity) values (15, 79, 1);
insert into carts (client_id, item_id, quantity) values (16, 75, 1);
insert into carts (client_id, item_id, quantity) values (16, 96, 1);
insert into carts (client_id, item_id, quantity) values (17, 21, 1);
insert into carts (client_id, item_id, quantity) values (17, 61, 1);
insert into carts (client_id, item_id, quantity) values (17, 73, 1);
insert into carts (client_id, item_id, quantity) values (18, 4, 1);
insert into carts (client_id, item_id, quantity) values (18, 16, 1);
insert into carts (client_id, item_id, quantity) values (18, 27, 1);
insert into carts (client_id, item_id, quantity) values (18, 40, 1);
insert into carts (client_id, item_id, quantity) values (18, 47, 1);
insert into carts (client_id, item_id, quantity) values (18, 77, 1);
insert into carts (client_id, item_id, quantity) values (19, 6, 1);
insert into carts (client_id, item_id, quantity) values (19, 17, 1);
insert into carts (client_id, item_id, quantity) values (19, 41, 1);
insert into carts (client_id, item_id, quantity) values (19, 54, 1);
insert into carts (client_id, item_id, quantity) values (19, 73, 1);
insert into carts (client_id, item_id, quantity) values (19, 78, 1);
insert into carts (client_id, item_id, quantity) values (19, 100, 1);
insert into carts (client_id, item_id, quantity) values (20, 84, 1);
insert into carts (client_id, item_id, quantity) values (20, 86, 1);
insert into carts (client_id, item_id, quantity) values (21, 2, 1);
insert into carts (client_id, item_id, quantity) values (21, 23, 1);
insert into carts (client_id, item_id, quantity) values (21, 30, 1);
insert into carts (client_id, item_id, quantity) values (21, 36, 1);
insert into carts (client_id, item_id, quantity) values (21, 60, 1);
insert into carts (client_id, item_id, quantity) values (21, 76, 1);
insert into carts (client_id, item_id, quantity) values (22, 15, 1);
insert into carts (client_id, item_id, quantity) values (22, 79, 1);
insert into carts (client_id, item_id, quantity) values (22, 90, 1);
insert into carts (client_id, item_id, quantity) values (23, 15, 1);
insert into carts (client_id, item_id, quantity) values (23, 17, 1);
insert into carts (client_id, item_id, quantity) values (23, 58, 1);
insert into carts (client_id, item_id, quantity) values (23, 92, 1);
insert into carts (client_id, item_id, quantity) values (24, 12, 1);
insert into carts (client_id, item_id, quantity) values (24, 23, 1);
insert into carts (client_id, item_id, quantity) values (24, 43, 1);
insert into carts (client_id, item_id, quantity) values (24, 50, 1);
insert into carts (client_id, item_id, quantity) values (24, 69, 1);
insert into carts (client_id, item_id, quantity) values (25, 25, 1);
insert into carts (client_id, item_id, quantity) values (25, 33, 1);
insert into carts (client_id, item_id, quantity) values (25, 36, 1);
insert into carts (client_id, item_id, quantity) values (25, 41, 1);
insert into carts (client_id, item_id, quantity) values (25, 53, 1);
insert into carts (client_id, item_id, quantity) values (25, 68, 1);
insert into carts (client_id, item_id, quantity) values (25, 73, 1);
insert into carts (client_id, item_id, quantity) values (25, 95, 1);
insert into carts (client_id, item_id, quantity) values (25, 99, 1);
insert into carts (client_id, item_id, quantity) values (26, 55, 1);
insert into carts (client_id, item_id, quantity) values (26, 94, 1);
insert into carts (client_id, item_id, quantity) values (26, 98, 1);
insert into carts (client_id, item_id, quantity) values (27, 6, 1);
insert into carts (client_id, item_id, quantity) values (27, 18, 1);
insert into carts (client_id, item_id, quantity) values (27, 79, 1);
insert into carts (client_id, item_id, quantity) values (27, 94, 1);
insert into carts (client_id, item_id, quantity) values (28, 2, 1);
insert into carts (client_id, item_id, quantity) values (28, 8, 1);
insert into carts (client_id, item_id, quantity) values (28, 9, 1);
insert into carts (client_id, item_id, quantity) values (28, 11, 1);
insert into carts (client_id, item_id, quantity) values (28, 25, 1);
insert into carts (client_id, item_id, quantity) values (28, 35, 1);
insert into carts (client_id, item_id, quantity) values (28, 46, 1);
insert into carts (client_id, item_id, quantity) values (28, 47, 1);
insert into carts (client_id, item_id, quantity) values (28, 55, 1);
insert into carts (client_id, item_id, quantity) values (28, 69, 1);
insert into carts (client_id, item_id, quantity) values (28, 72, 1);
insert into carts (client_id, item_id, quantity) values (29, 11, 1);
insert into carts (client_id, item_id, quantity) values (29, 12, 1);
insert into carts (client_id, item_id, quantity) values (29, 17, 1);
insert into carts (client_id, item_id, quantity) values (29, 81, 1);
insert into carts (client_id, item_id, quantity) values (29, 82, 1);
insert into carts (client_id, item_id, quantity) values (30, 16, 1);
insert into carts (client_id, item_id, quantity) values (30, 27, 1);
insert into carts (client_id, item_id, quantity) values (30, 35, 1);
insert into carts (client_id, item_id, quantity) values (30, 74, 1);
insert into carts (client_id, item_id, quantity) values (30, 98, 1);
insert into carts (client_id, item_id, quantity) values (30, 100, 1);
insert into carts (client_id, item_id, quantity) values (31, 63, 1);
insert into carts (client_id, item_id, quantity) values (31, 75, 1);
insert into carts (client_id, item_id, quantity) values (31, 80, 1);
insert into carts (client_id, item_id, quantity) values (32, 1, 1);
insert into carts (client_id, item_id, quantity) values (32, 6, 1);
insert into carts (client_id, item_id, quantity) values (32, 7, 1);
insert into carts (client_id, item_id, quantity) values (32, 20, 1);
insert into carts (client_id, item_id, quantity) values (32, 31, 1);
insert into carts (client_id, item_id, quantity) values (32, 50, 1);
insert into carts (client_id, item_id, quantity) values (32, 89, 1);
insert into carts (client_id, item_id, quantity) values (32, 90, 1);
insert into carts (client_id, item_id, quantity) values (32, 98, 1);
insert into carts (client_id, item_id, quantity) values (33, 6, 1);
insert into carts (client_id, item_id, quantity) values (33, 31, 1);
insert into carts (client_id, item_id, quantity) values (33, 80, 1);
insert into carts (client_id, item_id, quantity) values (33, 82, 1);
insert into carts (client_id, item_id, quantity) values (33, 93, 1);
insert into carts (client_id, item_id, quantity) values (34, 8, 1);
insert into carts (client_id, item_id, quantity) values (34, 21, 1);
insert into carts (client_id, item_id, quantity) values (34, 24, 1);
insert into carts (client_id, item_id, quantity) values (34, 52, 1);
insert into carts (client_id, item_id, quantity) values (34, 63, 1);
insert into carts (client_id, item_id, quantity) values (34, 81, 1);
insert into carts (client_id, item_id, quantity) values (35, 21, 1);
insert into carts (client_id, item_id, quantity) values (35, 29, 1);
insert into carts (client_id, item_id, quantity) values (35, 53, 1);
insert into carts (client_id, item_id, quantity) values (35, 68, 1);
insert into carts (client_id, item_id, quantity) values (35, 81, 1);
insert into carts (client_id, item_id, quantity) values (35, 98, 1);
insert into carts (client_id, item_id, quantity) values (36, 63, 1);
insert into carts (client_id, item_id, quantity) values (36, 82, 1);
insert into carts (client_id, item_id, quantity) values (36, 84, 1);
insert into carts (client_id, item_id, quantity) values (36, 93, 1);
insert into carts (client_id, item_id, quantity) values (37, 19, 1);
insert into carts (client_id, item_id, quantity) values (37, 28, 1);
insert into carts (client_id, item_id, quantity) values (37, 37, 1);
insert into carts (client_id, item_id, quantity) values (37, 40, 1);
insert into carts (client_id, item_id, quantity) values (37, 50, 1);
insert into carts (client_id, item_id, quantity) values (37, 52, 1);
insert into carts (client_id, item_id, quantity) values (37, 76, 1);
insert into carts (client_id, item_id, quantity) values (37, 93, 1);
insert into carts (client_id, item_id, quantity) values (38, 21, 1);
insert into carts (client_id, item_id, quantity) values (38, 29, 1);
insert into carts (client_id, item_id, quantity) values (38, 55, 1);
insert into carts (client_id, item_id, quantity) values (38, 69, 1);
insert into carts (client_id, item_id, quantity) values (39, 9, 1);
insert into carts (client_id, item_id, quantity) values (39, 25, 1);
insert into carts (client_id, item_id, quantity) values (39, 35, 1);
insert into carts (client_id, item_id, quantity) values (39, 80, 1);
insert into carts (client_id, item_id, quantity) values (40, 24, 1);
insert into carts (client_id, item_id, quantity) values (40, 31, 1);
insert into carts (client_id, item_id, quantity) values (40, 35, 1);
insert into carts (client_id, item_id, quantity) values (40, 65, 1);
insert into carts (client_id, item_id, quantity) values (40, 70, 1);
insert into carts (client_id, item_id, quantity) values (40, 74, 1);
insert into carts (client_id, item_id, quantity) values (40, 77, 1);
insert into carts (client_id, item_id, quantity) values (40, 89, 1);
insert into carts (client_id, item_id, quantity) values (41, 4, 1);
insert into carts (client_id, item_id, quantity) values (41, 11, 1);
insert into carts (client_id, item_id, quantity) values (41, 19, 1);
insert into carts (client_id, item_id, quantity) values (41, 35, 1);
insert into carts (client_id, item_id, quantity) values (41, 91, 1);
insert into carts (client_id, item_id, quantity) values (42, 20, 1);
insert into carts (client_id, item_id, quantity) values (42, 44, 1);
insert into carts (client_id, item_id, quantity) values (42, 78, 1);
insert into carts (client_id, item_id, quantity) values (42, 94, 1);
insert into carts (client_id, item_id, quantity) values (43, 15, 1);
insert into carts (client_id, item_id, quantity) values (43, 30, 1);
insert into carts (client_id, item_id, quantity) values (43, 39, 1);
insert into carts (client_id, item_id, quantity) values (43, 44, 1);
insert into carts (client_id, item_id, quantity) values (43, 65, 1);
insert into carts (client_id, item_id, quantity) values (43, 66, 1);
insert into carts (client_id, item_id, quantity) values (44, 20, 1);
insert into carts (client_id, item_id, quantity) values (44, 24, 1);
insert into carts (client_id, item_id, quantity) values (44, 29, 1);
insert into carts (client_id, item_id, quantity) values (44, 85, 1);
insert into carts (client_id, item_id, quantity) values (45, 14, 1);
insert into carts (client_id, item_id, quantity) values (45, 25, 1);
insert into carts (client_id, item_id, quantity) values (45, 31, 1);
insert into carts (client_id, item_id, quantity) values (45, 92, 1);
insert into carts (client_id, item_id, quantity) values (45, 94, 1);
insert into carts (client_id, item_id, quantity) values (46, 55, 1);
insert into carts (client_id, item_id, quantity) values (46, 83, 1);
insert into carts (client_id, item_id, quantity) values (46, 100, 1);
insert into carts (client_id, item_id, quantity) values (47, 11, 1);
insert into carts (client_id, item_id, quantity) values (48, 5, 1);
insert into carts (client_id, item_id, quantity) values (48, 19, 1);
insert into carts (client_id, item_id, quantity) values (48, 30, 1);
insert into carts (client_id, item_id, quantity) values (48, 44, 1);
insert into carts (client_id, item_id, quantity) values (48, 74, 1);
insert into carts (client_id, item_id, quantity) values (48, 86, 1);
insert into carts (client_id, item_id, quantity) values (49, 58, 1);
insert into carts (client_id, item_id, quantity) values (49, 68, 1);
insert into carts (client_id, item_id, quantity) values (50, 1, 1);
insert into carts (client_id, item_id, quantity) values (50, 98, 1);

insert into image_product (product_id, image_id) values (1, 3);
insert into image_product (product_id, image_id) values (2, 4);
insert into image_product (product_id, image_id) values (3, 5);
insert into image_product (product_id, image_id) values (4, 6);
insert into image_product (product_id, image_id) values (5, 7);
insert into image_product (product_id, image_id) values (6, 8);
insert into image_product (product_id, image_id) values (7, 9);
insert into image_product (product_id, image_id) values (8, 10);
insert into image_product (product_id, image_id) values (9, 11);
insert into image_product (product_id, image_id) values (10, 12);
insert into image_product (product_id, image_id) values (11, 13);
insert into image_product (product_id, image_id) values (12, 14);
insert into image_product (product_id, image_id) values (13, 15);
insert into image_product (product_id, image_id) values (14, 16);
insert into image_product (product_id, image_id) values (15, 17);
insert into image_product (product_id, image_id) values (16, 18);
insert into image_product (product_id, image_id) values (17, 19);
insert into image_product (product_id, image_id) values (18, 20);
insert into image_product (product_id, image_id) values (19, 21);
insert into image_product (product_id, image_id) values (20, 22);
insert into image_product (product_id, image_id) values (21, 23);
insert into image_product (product_id, image_id) values (22, 24);
insert into image_product (product_id, image_id) values (23, 25);
insert into image_product (product_id, image_id) values (24, 26);
insert into image_product (product_id, image_id) values (25, 27);
insert into image_product (product_id, image_id) values (26, 28);
insert into image_product (product_id, image_id) values (27, 29);
insert into image_product (product_id, image_id) values (28, 30);
insert into image_product (product_id, image_id) values (29, 31);
insert into image_product (product_id, image_id) values (30, 32);
insert into image_product (product_id, image_id) values (31, 33);
insert into image_product (product_id, image_id) values (32, 34);
insert into image_product (product_id, image_id) values (33, 35);
insert into image_product (product_id, image_id) values (34, 36);
insert into image_product (product_id, image_id) values (35, 37);
insert into image_product (product_id, image_id) values (36, 38);
insert into image_product (product_id, image_id) values (37, 39);
insert into image_product (product_id, image_id) values (38, 40);
insert into image_product (product_id, image_id) values (39, 41);
insert into image_product (product_id, image_id) values (40, 42);
insert into image_product (product_id, image_id) values (41, 43);
insert into image_product (product_id, image_id) values (42, 44);
insert into image_product (product_id, image_id) values (43, 45);
insert into image_product (product_id, image_id) values (44, 46);
insert into image_product (product_id, image_id) values (45, 47);
insert into image_product (product_id, image_id) values (46, 48);
insert into image_product (product_id, image_id) values (47, 49);
insert into image_product (product_id, image_id) values (48, 50);
insert into image_product (product_id, image_id) values (49, 51);
insert into image_product (product_id, image_id) values (50, 52);
insert into image_product (product_id, image_id) values (51, 53);
insert into image_product (product_id, image_id) values (52, 54);
insert into image_product (product_id, image_id) values (53, 55);
insert into image_product (product_id, image_id) values (54, 56);
insert into image_product (product_id, image_id) values (55, 57);
insert into image_product (product_id, image_id) values (56, 58);
insert into image_product (product_id, image_id) values (57, 59);
insert into image_product (product_id, image_id) values (58, 60);
insert into image_product (product_id, image_id) values (59, 61);
insert into image_product (product_id, image_id) values (60, 62);
insert into image_product (product_id, image_id) values (61, 63);
insert into image_product (product_id, image_id) values (62, 64);
insert into image_product (product_id, image_id) values (63, 65);
insert into image_product (product_id, image_id) values (64, 66);
insert into image_product (product_id, image_id) values (65, 67);
insert into image_product (product_id, image_id) values (66, 68);
insert into image_product (product_id, image_id) values (67, 69);
insert into image_product (product_id, image_id) values (68, 70);
insert into image_product (product_id, image_id) values (69, 71);
insert into image_product (product_id, image_id) values (70, 72);
insert into image_product (product_id, image_id) values (71, 73);
insert into image_product (product_id, image_id) values (72, 74);
insert into image_product (product_id, image_id) values (73, 75);
insert into image_product (product_id, image_id) values (74, 76);
insert into image_product (product_id, image_id) values (75, 77);


insert into purchases (client_id, paid, created_at, sd_id, cc_id, type, status) values (1, 21.4, '2020-08-14', 1, 1, 'SingleBuy', 'InProgress');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type, status) values (2, 39.2, '2020-08-02', 2, 2, 'Month', 'InProgress');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type, status) values (3, 47.4, '2020-07-26', 3, 3, 'Week', 'InProgress');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type, status) values (4, 27.3, '2020-09-24', 4, 4, 'Month', 'Canceled');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type, status) values (5, 38.9, '2020-09-17', 5, 5, 'Week', 'InProgress');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type, status) values (6, 46.1, '2020-05-31', 6, 6, 'Day', 'InProgress');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type, status) values (7, 15.1, '2020-08-16', 7, 7, 'Day', 'Canceled');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type, status) values (8, 14.9, '2020-04-26', 8, 8, 'Week', 'InProgress');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type, status) values (9, 8.1, '2020-05-10', 9, 9, 'SingleBuy', 'Canceled');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type, status) values (10, 5.6, '2020-04-06', 10, 10, 'Week', 'InProgress');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type, status) values (11, 25.7, '2021-02-15', 11, 11, 'Month', 'InProgress');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type, status) values (12, 32.2, '2020-11-13', 12, 12, 'Day', 'Canceled');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type, status) values (13, 17.8, '2020-07-16', 13, 13, 'Month', 'InProgress');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type, status) values (14, 21.3, '2020-07-10', 14, 14, 'Day', 'Canceled');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type, status) values (15, 39.4, '2020-11-26', 15, 15, 'Month', 'InProgress');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type, status) values (16, 6.8, '2020-06-04', 16, 16, 'Week', 'InProgress');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type, status) values (17, 50.0, '2020-10-16', 17, 17, 'Week', 'Canceled');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type, status) values (18, 22.4, '2020-09-05', 8, 8, 'Day', 'InProgress');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type, status) values (19, 17.2, '2021-01-10', 8, 8, 'Month', 'Canceled');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type, status) values (20, 28.0, '2020-04-14', 8, 8, 'Month', 'InProgress');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type, status) values (21, 41.6, '2020-06-13', 8, 8, 'Week', 'Canceled');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type, status) values (22, 13.6, '2020-08-05', 8, 8, 'Day', 'InProgress');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (23, 33.5, '2021-03-07', 8, 8, 'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (24, 23.0, '2020-10-07', 8, 8, 'Week');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (25, 29.1, '2020-08-12', 8, 8, 'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (26, 12.7, '2020-10-14', 8, 8, 'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (27, 9.3, '2020-08-12',  8, 8,'SingleBuy');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (28, 48.4, '2020-11-02', 8, 8, 'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (29, 11.4, '2020-04-10', 8, 8, 'Week');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (30, 17.5, '2020-06-20', 8, 8, 'Day');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (31, 23.8, '2020-10-01', 8, 8, 'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (32, 37.9, '2020-04-17', 8, 8, 'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (33, 12.6, '2021-02-07', 8, 8, 'SingleBuy');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (34, 36.8, '2020-11-06', 8, 8, 'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (35, 9.9, '2020-11-26',  8, 8,'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (36, 19.1, '2020-05-02', 8, 8, 'Week');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (37, 14.7, '2020-06-09', 8, 8, 'Day');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (38, 41.9, '2020-10-04', 8, 8, 'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (39, 25.4, '2020-10-05', 8, 8, 'Week');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (40, 15.2, '2020-11-11', 8, 8, 'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (41, 49.7, '2021-01-25', 8, 8, 'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (42, 22.4, '2020-04-13', 8, 8, 'Week');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (43, 18.1, '2020-12-23', 8, 8, 'Day');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (44, 16.4, '2020-04-29', 8, 8, 'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (45, 42.3, '2020-12-24', 8, 8, 'Week');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (46, 43.0, '2021-03-05', 8, 8, 'Week');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (47, 26.3, '2020-05-07', 8, 8, 'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (48, 47.3, '2020-07-16', 8, 8, 'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (49, 24.8, '2020-03-25', 8, 8, 'Week');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (50, 34.8, '2020-06-07', 8, 8, 'Day');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (1, 12.4, '2020-04-23',  8, 8,'SingleBuy');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (2, 35.4, '2020-04-19',  8, 8,'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (3, 37.1, '2020-07-31',  8, 8,'Week');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (4, 42.3, '2020-08-19',  8, 8,'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (5, 13.8, '2020-09-20',  8, 8,'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (6, 36.4, '2020-05-02',  8, 8,'Day');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (7, 34.3, '2021-02-08',  8, 8,'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (8, 18.8, '2020-10-27',  8, 8,'Day');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (9, 11.3, '2020-12-25',  8, 8,'Week');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (10, 29.3, '2020-05-11', 8, 8, 'Day');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (11, 35.8, '2020-10-17', 8, 8, 'SingleBuy');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (12, 28.5, '2021-02-20', 8, 8, 'Day');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (13, 22.6, '2020-08-26', 8, 8, 'Week');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (14, 34.0, '2020-05-15', 8, 8, 'Day');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (15, 43.6, '2020-07-19', 8, 8, 'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (16, 15.2, '2020-07-07', 8, 8, 'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (17, 43.1, '2020-04-30', 8, 8, 'SingleBuy');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (18, 15.0, '2020-10-14', 8, 8, 'SingleBuy');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (19, 6.1, '2021-03-02',  8, 8,'Day');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (20, 42.3, '2020-08-25', 8, 8, 'Day');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (21, 9.8, '2020-07-06',  8, 8,'Day');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (22, 48.6, '2020-07-13', 8, 8, 'Week');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (23, 23.5, '2020-12-27', 8, 8, 'Week');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (24, 26.1, '2020-12-23', 8, 8, 'Day');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (25, 8.3, '2020-04-25',  8, 8,'Week');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (26, 24.4, '2021-02-08', 8, 8, 'Day');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (27, 29.3, '2020-09-19', 8, 8, 'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (28, 37.4, '2020-12-23', 8, 8, 'Week');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (29, 49.9, '2020-12-25', 8, 8, 'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (30, 40.5, '2020-07-21', 8, 8, 'Week');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (31, 44.9, '2020-06-18', 8, 8, 'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (32, 17.2, '2020-06-13', 8, 8, 'SingleBuy');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (33, 24.5, '2020-12-07', 8, 8, 'Day');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (34, 40.9, '2020-03-23', 8, 8, 'Week');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (35, 45.6, '2021-02-17', 8, 8, 'Week');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (36, 25.8, '2020-07-22', 8, 8, 'SingleBuy');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (37, 47.1, '2021-01-29', 8, 8, 'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (38, 18.4, '2020-05-13', 8, 8, 'SingleBuy');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (39, 40.9, '2021-03-19', 8, 8, 'Day');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (40, 45.9, '2021-01-10', 8, 8, 'SingleBuy');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (41, 49.8, '2020-04-27', 8, 8, 'Day');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (42, 26.3, '2021-03-05', 8, 8, 'Day');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (43, 17.7, '2021-01-17', 8, 8, 'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (44, 49.2, '2020-12-25', 8, 8, 'SingleBuy');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (45, 39.8, '2020-11-08', 8, 8, 'Week');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (46, 35.6, '2020-10-06', 8, 8, 'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (47, 34.5, '2020-06-10', 8, 8, 'Month');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (48, 42.9, '2020-06-29', 8, 8, 'Week');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values (49, 37.7, '2021-03-04', 8, 8, 'SingleBuy');
insert into purchases (client_id, paid, created_at, sd_id, cc_id, type) values ( 50, 18.7, '2020-08-18', 8, 8, 'Month');

insert into item_purchase (purchase_id, item_id, price, amount) values (1, 1, 12, 10);
insert into item_purchase (purchase_id, item_id, price, amount) values (1, 31, 79.91, 67);
insert into item_purchase (purchase_id, item_id, price, amount) values (1, 85, 69.42, 87);
insert into item_purchase (purchase_id, item_id, price, amount) values (1, 99, 34.38, 67);
insert into item_purchase (purchase_id, item_id, price, amount) values (2, 24, 27.99, 64);
insert into item_purchase (purchase_id, item_id, price, amount) values (2, 56, 65.89, 20);
insert into item_purchase (purchase_id, item_id, price, amount) values (2, 88, 58.42, 14);
insert into item_purchase (purchase_id, item_id, price, amount) values (3, 16, 11.51, 90);
insert into item_purchase (purchase_id, item_id, price, amount) values (3, 17, 1.07, 36);
insert into item_purchase (purchase_id, item_id, price, amount) values (3, 37, 51.18, 60);
insert into item_purchase (purchase_id, item_id, price, amount) values (4, 36, 85.91, 42);
insert into item_purchase (purchase_id, item_id, price, amount) values (4, 80, 63.88, 48);
insert into item_purchase (purchase_id, item_id, price, amount) values (4, 90, 83.67, 100);
insert into item_purchase (purchase_id, item_id, price, amount) values (5, 42, 84.14, 2);
insert into item_purchase (purchase_id, item_id, price, amount) values (5, 65, 34.19, 64);
insert into item_purchase (purchase_id, item_id, price, amount) values (5, 72, 65.1, 94);
insert into item_purchase (purchase_id, item_id, price, amount) values (6, 40, 3.03, 27);
insert into item_purchase (purchase_id, item_id, price, amount) values (6, 91, 83.57, 87);
insert into item_purchase (purchase_id, item_id, price, amount) values (6, 92, 70.93, 77);
insert into item_purchase (purchase_id, item_id, price, amount) values (7, 2, 53.34, 83);
insert into item_purchase (purchase_id, item_id, price, amount) values (7, 63, 22.77, 53);
insert into item_purchase (purchase_id, item_id, price, amount) values (7, 88, 3.09, 86);
insert into item_purchase (purchase_id, item_id, price, amount) values (8, 28, 8.32, 53);
insert into item_purchase (purchase_id, item_id, price, amount) values (8, 50, 10.52, 25);
insert into item_purchase (purchase_id, item_id, price, amount) values (8, 84, 57.18, 91);
insert into item_purchase (purchase_id, item_id, price, amount) values (9, 18, 92.47, 77);
insert into item_purchase (purchase_id, item_id, price, amount) values (9, 43, 23.76, 65);
insert into item_purchase (purchase_id, item_id, price, amount) values (9, 81, 46.78, 11);
insert into item_purchase (purchase_id, item_id, price, amount) values (10, 58, 73.1, 42);
insert into item_purchase (purchase_id, item_id, price, amount) values (10, 75, 84.87, 5);
insert into item_purchase (purchase_id, item_id, price, amount) values (10, 86, 14.16, 87);
insert into item_purchase (purchase_id, item_id, price, amount) values (11, 52, 44.95, 8);
insert into item_purchase (purchase_id, item_id, price, amount) values (11, 63, 56.86, 55);
insert into item_purchase (purchase_id, item_id, price, amount) values (11, 99, 30.99, 64);
insert into item_purchase (purchase_id, item_id, price, amount) values (12, 2, 99.72, 11);
insert into item_purchase (purchase_id, item_id, price, amount) values (12, 30, 34.12, 69);
insert into item_purchase (purchase_id, item_id, price, amount) values (12, 82, 16.54, 26);
insert into item_purchase (purchase_id, item_id, price, amount) values (13, 11, 19.86, 28);
insert into item_purchase (purchase_id, item_id, price, amount) values (13, 60, 70.28, 73);
insert into item_purchase (purchase_id, item_id, price, amount) values (13, 96, 46.93, 71);
insert into item_purchase (purchase_id, item_id, price, amount) values (14, 26, 58.36, 80);
insert into item_purchase (purchase_id, item_id, price, amount) values (14, 29, 11.3, 26);
insert into item_purchase (purchase_id, item_id, price, amount) values (14, 44, 95.77, 16);
insert into item_purchase (purchase_id, item_id, price, amount) values (15, 36, 95.55, 4);
insert into item_purchase (purchase_id, item_id, price, amount) values (15, 81, 41.74, 86);
insert into item_purchase (purchase_id, item_id, price, amount) values (15, 97, 24.45, 51);
insert into item_purchase (purchase_id, item_id, price, amount) values (16, 26, 87.64, 30);
insert into item_purchase (purchase_id, item_id, price, amount) values (16, 43, 81.81, 36);
insert into item_purchase (purchase_id, item_id, price, amount) values (16, 63, 47.65, 90);
insert into item_purchase (purchase_id, item_id, price, amount) values (17, 52, 20.18, 57);
insert into item_purchase (purchase_id, item_id, price, amount) values (17, 88, 85.24, 26);
insert into item_purchase (purchase_id, item_id, price, amount) values (17, 98, 59.06, 30);
insert into item_purchase (purchase_id, item_id, price, amount) values (18, 19, 15.99, 67);
insert into item_purchase (purchase_id, item_id, price, amount) values (18, 25, 30.12, 31);
insert into item_purchase (purchase_id, item_id, price, amount) values (18, 75, 88.87, 4);
insert into item_purchase (purchase_id, item_id, price, amount) values (19, 10, 5.23, 75);
insert into item_purchase (purchase_id, item_id, price, amount) values (19, 92, 43.3, 20);
insert into item_purchase (purchase_id, item_id, price, amount) values (19, 100, 5.67, 59);
insert into item_purchase (purchase_id, item_id, price, amount) values (20, 37, 69.67, 77);
insert into item_purchase (purchase_id, item_id, price, amount) values (20, 52, 65.45, 51);
insert into item_purchase (purchase_id, item_id, price, amount) values (20, 80, 6.43, 9);
insert into item_purchase (purchase_id, item_id, price, amount) values (21, 14, 37.55, 43);
insert into item_purchase (purchase_id, item_id, price, amount) values (21, 68, 49.66, 38);
insert into item_purchase (purchase_id, item_id, price, amount) values (21, 88, 81.73, 45);
insert into item_purchase (purchase_id, item_id, price, amount) values (22, 44, 96.18, 60);
insert into item_purchase (purchase_id, item_id, price, amount) values (22, 58, 55.96, 15);
insert into item_purchase (purchase_id, item_id, price, amount) values (23, 29, 48.11, 38);
insert into item_purchase (purchase_id, item_id, price, amount) values (23, 42, 65.07, 69);
insert into item_purchase (purchase_id, item_id, price, amount) values (23, 99, 52.85, 71);
insert into item_purchase (purchase_id, item_id, price, amount) values (24, 81, 29.46, 29);
insert into item_purchase (purchase_id, item_id, price, amount) values (24, 82, 49.65, 73);
insert into item_purchase (purchase_id, item_id, price, amount) values (24, 91, 96.75, 11);
insert into item_purchase (purchase_id, item_id, price, amount) values (25, 11, 11.23, 75);
insert into item_purchase (purchase_id, item_id, price, amount) values (25, 20, 20.5, 13);
insert into item_purchase (purchase_id, item_id, price, amount) values (25, 66, 57.24, 52);
insert into item_purchase (purchase_id, item_id, price, amount) values (26, 11, 47.58, 44);
insert into item_purchase (purchase_id, item_id, price, amount) values (26, 35, 46.59, 65);
insert into item_purchase (purchase_id, item_id, price, amount) values (26, 61, 69.46, 61);
insert into item_purchase (purchase_id, item_id, price, amount) values (27, 17, 13.05, 5);
insert into item_purchase (purchase_id, item_id, price, amount) values (27, 50, 14.41, 21);
insert into item_purchase (purchase_id, item_id, price, amount) values (27, 78, 47.62, 54);
insert into item_purchase (purchase_id, item_id, price, amount) values (28, 13, 55.63, 50);
insert into item_purchase (purchase_id, item_id, price, amount) values (28, 37, 58.92, 100);
insert into item_purchase (purchase_id, item_id, price, amount) values (28, 54, 34.26, 5);
insert into item_purchase (purchase_id, item_id, price, amount) values (29, 77, 10.72, 57);
insert into item_purchase (purchase_id, item_id, price, amount) values (29, 88, 18.37, 38);
insert into item_purchase (purchase_id, item_id, price, amount) values (29, 91, 93.33, 88);
insert into item_purchase (purchase_id, item_id, price, amount) values (30, 64, 8.34, 31);
insert into item_purchase (purchase_id, item_id, price, amount) values (30, 76, 64.41, 51);
insert into item_purchase (purchase_id, item_id, price, amount) values (30, 96, 75.48, 65);
insert into item_purchase (purchase_id, item_id, price, amount) values (31, 2, 2.3, 15);
insert into item_purchase (purchase_id, item_id, price, amount) values (31, 14, 29.37, 100);
insert into item_purchase (purchase_id, item_id, price, amount) values (32, 8, 35.47, 16);
insert into item_purchase (purchase_id, item_id, price, amount) values (32, 22, 74.75, 28);
insert into item_purchase (purchase_id, item_id, price, amount) values (32, 82, 39.05, 32);
insert into item_purchase (purchase_id, item_id, price, amount) values (33, 9, 63.58, 15);
insert into item_purchase (purchase_id, item_id, price, amount) values (33, 71, 33.66, 8);
insert into item_purchase (purchase_id, item_id, price, amount) values (33, 91, 15.37, 6);
insert into item_purchase (purchase_id, item_id, price, amount) values (34, 27, 46.34, 73);
insert into item_purchase (purchase_id, item_id, price, amount) values (34, 32, 40.92, 72);
insert into item_purchase (purchase_id, item_id, price, amount) values (34, 89, 55.28, 49);
insert into item_purchase (purchase_id, item_id, price, amount) values (35, 9, 89.54, 25);
insert into item_purchase (purchase_id, item_id, price, amount) values (35, 52, 11.83, 24);
insert into item_purchase (purchase_id, item_id, price, amount) values (35, 96, 13.95, 53);
insert into item_purchase (purchase_id, item_id, price, amount) values (36, 65, 25.9, 86);
insert into item_purchase (purchase_id, item_id, price, amount) values (36, 69, 34.06, 5);
insert into item_purchase (purchase_id, item_id, price, amount) values (36, 96, 88.38, 19);
insert into item_purchase (purchase_id, item_id, price, amount) values (37, 1, 73.59, 51);
insert into item_purchase (purchase_id, item_id, price, amount) values (37, 64, 76.64, 2);
insert into item_purchase (purchase_id, item_id, price, amount) values (37, 88, 43.56, 11);
insert into item_purchase (purchase_id, item_id, price, amount) values (38, 30, 74.88, 59);
insert into item_purchase (purchase_id, item_id, price, amount) values (38, 64, 85.48, 20);
insert into item_purchase (purchase_id, item_id, price, amount) values (38, 73, 87.41, 33);
insert into item_purchase (purchase_id, item_id, price, amount) values (39, 22, 68.87, 41);
insert into item_purchase (purchase_id, item_id, price, amount) values (39, 43, 54.33, 20);
insert into item_purchase (purchase_id, item_id, price, amount) values (39, 46, 96.49, 43);
insert into item_purchase (purchase_id, item_id, price, amount) values (40, 8, 92.36, 7);
insert into item_purchase (purchase_id, item_id, price, amount) values (40, 31, 21.47, 16);
insert into item_purchase (purchase_id, item_id, price, amount) values (40, 40, 90.93, 21);
insert into item_purchase (purchase_id, item_id, price, amount) values (41, 14, 15.73, 57);
insert into item_purchase (purchase_id, item_id, price, amount) values (41, 72, 46.35, 79);
insert into item_purchase (purchase_id, item_id, price, amount) values (41, 78, 78.19, 93);
insert into item_purchase (purchase_id, item_id, price, amount) values (42, 26, 53.84, 13);
insert into item_purchase (purchase_id, item_id, price, amount) values (42, 76, 98.68, 65);
insert into item_purchase (purchase_id, item_id, price, amount) values (42, 83, 87.93, 80);
insert into item_purchase (purchase_id, item_id, price, amount) values (43, 46, 60.72, 94);
insert into item_purchase (purchase_id, item_id, price, amount) values (43, 54, 46.07, 95);
insert into item_purchase (purchase_id, item_id, price, amount) values (43, 99, 77.39, 47);
insert into item_purchase (purchase_id, item_id, price, amount) values (44, 19, 41.79, 65);
insert into item_purchase (purchase_id, item_id, price, amount) values (44, 94, 12.81, 76);
insert into item_purchase (purchase_id, item_id, price, amount) values (44, 98, 35.31, 51);
insert into item_purchase (purchase_id, item_id, price, amount) values (45, 6, 64.53, 11);
insert into item_purchase (purchase_id, item_id, price, amount) values (45, 14, 24.8, 98);
insert into item_purchase (purchase_id, item_id, price, amount) values (45, 38, 65.85, 40);
insert into item_purchase (purchase_id, item_id, price, amount) values (46, 40, 11.17, 59);
insert into item_purchase (purchase_id, item_id, price, amount) values (46, 54, 28.17, 17);
insert into item_purchase (purchase_id, item_id, price, amount) values (46, 76, 81.4, 12);
insert into item_purchase (purchase_id, item_id, price, amount) values (47, 27, 59.34, 32);
insert into item_purchase (purchase_id, item_id, price, amount) values (47, 67, 54.0, 14);
insert into item_purchase (purchase_id, item_id, price, amount) values (47, 76, 63.02, 6);
insert into item_purchase (purchase_id, item_id, price, amount) values (48, 11, 16.91, 78);
insert into item_purchase (purchase_id, item_id, price, amount) values (48, 29, 67.6, 13);
insert into item_purchase (purchase_id, item_id, price, amount) values (48, 34, 80.15, 31);
insert into item_purchase (purchase_id, item_id, price, amount) values (49, 41, 37.08, 2);
insert into item_purchase (purchase_id, item_id, price, amount) values (49, 48, 27.88, 98);
insert into item_purchase (purchase_id, item_id, price, amount) values (49, 86, 32.37, 7);
insert into item_purchase (purchase_id, item_id, price, amount) values (50, 12, 96.61, 14);
insert into item_purchase (purchase_id, item_id, price, amount) values (50, 98, 66.03, 57);
insert into item_purchase (purchase_id, item_id, price, amount) values (50, 99, 36.66, 52);
insert into item_purchase (purchase_id, item_id, price, amount) values (51, 21, 22.46, 89);
insert into item_purchase (purchase_id, item_id, price, amount) values (51, 76, 97.62, 21);
insert into item_purchase (purchase_id, item_id, price, amount) values (51, 97, 98.36, 74);
insert into item_purchase (purchase_id, item_id, price, amount) values (52, 3, 23.61, 42);
insert into item_purchase (purchase_id, item_id, price, amount) values (52, 25, 32.75, 63);
insert into item_purchase (purchase_id, item_id, price, amount) values (52, 39, 37.13, 95);
insert into item_purchase (purchase_id, item_id, price, amount) values (53, 14, 14.22, 24);
insert into item_purchase (purchase_id, item_id, price, amount) values (53, 62, 61.62, 8);
insert into item_purchase (purchase_id, item_id, price, amount) values (53, 90, 68.81, 68);
insert into item_purchase (purchase_id, item_id, price, amount) values (54, 7, 86.13, 62);
insert into item_purchase (purchase_id, item_id, price, amount) values (54, 48, 40.2, 97);
insert into item_purchase (purchase_id, item_id, price, amount) values (54, 57, 75.23, 58);
insert into item_purchase (purchase_id, item_id, price, amount) values (55, 47, 80.13, 92);
insert into item_purchase (purchase_id, item_id, price, amount) values (55, 58, 92.01, 49);
insert into item_purchase (purchase_id, item_id, price, amount) values (55, 82, 59.68, 57);
insert into item_purchase (purchase_id, item_id, price, amount) values (56, 14, 8.03, 46);
insert into item_purchase (purchase_id, item_id, price, amount) values (56, 74, 87.74, 19);
insert into item_purchase (purchase_id, item_id, price, amount) values (56, 88, 12.71, 18);
insert into item_purchase (purchase_id, item_id, price, amount) values (57, 50, 37.95, 20);
insert into item_purchase (purchase_id, item_id, price, amount) values (57, 61, 61.95, 67);
insert into item_purchase (purchase_id, item_id, price, amount) values (57, 94, 61.74, 64);
insert into item_purchase (purchase_id, item_id, price, amount) values (58, 26, 23.63, 81);
insert into item_purchase (purchase_id, item_id, price, amount) values (58, 95, 53.13, 37);
insert into item_purchase (purchase_id, item_id, price, amount) values (58, 99, 82.35, 43);
insert into item_purchase (purchase_id, item_id, price, amount) values (59, 13, 30.37, 28);
insert into item_purchase (purchase_id, item_id, price, amount) values (59, 62, 54.27, 31);
insert into item_purchase (purchase_id, item_id, price, amount) values (59, 83, 98.47, 1);
insert into item_purchase (purchase_id, item_id, price, amount) values (60, 1, 29.71, 81);
insert into item_purchase (purchase_id, item_id, price, amount) values (60, 34, 71.14, 15);
insert into item_purchase (purchase_id, item_id, price, amount) values (60, 63, 16.89, 99);
insert into item_purchase (purchase_id, item_id, price, amount) values (61, 3, 66.22, 43);
insert into item_purchase (purchase_id, item_id, price, amount) values (61, 14, 48.76, 68);
insert into item_purchase (purchase_id, item_id, price, amount) values (61, 78, 54.9, 5);
insert into item_purchase (purchase_id, item_id, price, amount) values (62, 11, 37.15, 41);
insert into item_purchase (purchase_id, item_id, price, amount) values (62, 54, 41.99, 86);
insert into item_purchase (purchase_id, item_id, price, amount) values (62, 80, 86.59, 33);
insert into item_purchase (purchase_id, item_id, price, amount) values (63, 38, 9.46, 45);
insert into item_purchase (purchase_id, item_id, price, amount) values (63, 52, 50.44, 26);
insert into item_purchase (purchase_id, item_id, price, amount) values (63, 93, 77.69, 41);
insert into item_purchase (purchase_id, item_id, price, amount) values (64, 9, 36.37, 40);
insert into item_purchase (purchase_id, item_id, price, amount) values (64, 38, 38.62, 59);
insert into item_purchase (purchase_id, item_id, price, amount) values (64, 51, 65.89, 38);
insert into item_purchase (purchase_id, item_id, price, amount) values (65, 41, 8.5, 91);
insert into item_purchase (purchase_id, item_id, price, amount) values (65, 47, 6.07, 65);
insert into item_purchase (purchase_id, item_id, price, amount) values (65, 92, 87.87, 3);
insert into item_purchase (purchase_id, item_id, price, amount) values (66, 20, 17.69, 75);
insert into item_purchase (purchase_id, item_id, price, amount) values (66, 71, 77.03, 62);
insert into item_purchase (purchase_id, item_id, price, amount) values (66, 82, 23.47, 35);
insert into item_purchase (purchase_id, item_id, price, amount) values (67, 5, 51.26, 81);
insert into item_purchase (purchase_id, item_id, price, amount) values (67, 53, 66.49, 10);
insert into item_purchase (purchase_id, item_id, price, amount) values (67, 79, 84.85, 62);
insert into item_purchase (purchase_id, item_id, price, amount) values (68, 36, 77.05, 19);
insert into item_purchase (purchase_id, item_id, price, amount) values (68, 79, 82.69, 78);
insert into item_purchase (purchase_id, item_id, price, amount) values (68, 87, 35.25, 72);
insert into item_purchase (purchase_id, item_id, price, amount) values (69, 37, 53.98, 76);
insert into item_purchase (purchase_id, item_id, price, amount) values (69, 44, 75.03, 96);
insert into item_purchase (purchase_id, item_id, price, amount) values (69, 45, 49.8, 81);
insert into item_purchase (purchase_id, item_id, price, amount) values (70, 8, 34.26, 65);
insert into item_purchase (purchase_id, item_id, price, amount) values (70, 60, 29.44, 95);
insert into item_purchase (purchase_id, item_id, price, amount) values (70, 78, 8.54, 16);
insert into item_purchase (purchase_id, item_id, price, amount) values (71, 49, 77.56, 93);
insert into item_purchase (purchase_id, item_id, price, amount) values (71, 69, 31.08, 19);
insert into item_purchase (purchase_id, item_id, price, amount) values (71, 84, 78.42, 81);
insert into item_purchase (purchase_id, item_id, price, amount) values (72, 25, 29.27, 41);
insert into item_purchase (purchase_id, item_id, price, amount) values (72, 45, 30.95, 79);
insert into item_purchase (purchase_id, item_id, price, amount) values (72, 92, 59.05, 91);
insert into item_purchase (purchase_id, item_id, price, amount) values (73, 6, 53.96, 83);
insert into item_purchase (purchase_id, item_id, price, amount) values (73, 44, 21.72, 32);
insert into item_purchase (purchase_id, item_id, price, amount) values (73, 65, 60.87, 50);
insert into item_purchase (purchase_id, item_id, price, amount) values (74, 32, 24.67, 74);
insert into item_purchase (purchase_id, item_id, price, amount) values (74, 35, 73.09, 43);
insert into item_purchase (purchase_id, item_id, price, amount) values (74, 37, 75.6, 51);
insert into item_purchase (purchase_id, item_id, price, amount) values (75, 3, 69.22, 98);
insert into item_purchase (purchase_id, item_id, price, amount) values (75, 19, 37.71, 40);
insert into item_purchase (purchase_id, item_id, price, amount) values (76, 4, 71.58, 99);
insert into item_purchase (purchase_id, item_id, price, amount) values (76, 51, 7.63, 18);
insert into item_purchase (purchase_id, item_id, price, amount) values (76, 77, 68.53, 96);
insert into item_purchase (purchase_id, item_id, price, amount) values (77, 11, 68.64, 1);
insert into item_purchase (purchase_id, item_id, price, amount) values (77, 38, 69.75, 35);
insert into item_purchase (purchase_id, item_id, price, amount) values (77, 97, 8.07, 41);
insert into item_purchase (purchase_id, item_id, price, amount) values (78, 37, 10.72, 71);
insert into item_purchase (purchase_id, item_id, price, amount) values (78, 60, 69.3, 76);
insert into item_purchase (purchase_id, item_id, price, amount) values (78, 64, 92.98, 1);
insert into item_purchase (purchase_id, item_id, price, amount) values (79, 49, 14.68, 53);
insert into item_purchase (purchase_id, item_id, price, amount) values (79, 61, 37.86, 13);
insert into item_purchase (purchase_id, item_id, price, amount) values (79, 70, 28.24, 99);
insert into item_purchase (purchase_id, item_id, price, amount) values (80, 19, 75.05, 11);
insert into item_purchase (purchase_id, item_id, price, amount) values (80, 23, 47.92, 94);
insert into item_purchase (purchase_id, item_id, price, amount) values (80, 24, 77.3, 84);
insert into item_purchase (purchase_id, item_id, price, amount) values (81, 75, 95.23, 97);
insert into item_purchase (purchase_id, item_id, price, amount) values (81, 76, 40.09, 77);
insert into item_purchase (purchase_id, item_id, price, amount) values (81, 80, 21.64, 53);
insert into item_purchase (purchase_id, item_id, price, amount) values (82, 12, 24.43, 44);
insert into item_purchase (purchase_id, item_id, price, amount) values (82, 48, 53.93, 14);
insert into item_purchase (purchase_id, item_id, price, amount) values (82, 62, 5.65, 60);
insert into item_purchase (purchase_id, item_id, price, amount) values (83, 22, 35.99, 33);
insert into item_purchase (purchase_id, item_id, price, amount) values (83, 67, 58.48, 39);
insert into item_purchase (purchase_id, item_id, price, amount) values (83, 70, 69.38, 49);
insert into item_purchase (purchase_id, item_id, price, amount) values (84, 61, 14.23, 39);
insert into item_purchase (purchase_id, item_id, price, amount) values (84, 62, 16.78, 81);
insert into item_purchase (purchase_id, item_id, price, amount) values (84, 74, 46.58, 13);
insert into item_purchase (purchase_id, item_id, price, amount) values (85, 11, 25.62, 99);
insert into item_purchase (purchase_id, item_id, price, amount) values (85, 74, 31.82, 81);
insert into item_purchase (purchase_id, item_id, price, amount) values (85, 93, 49.38, 48);
insert into item_purchase (purchase_id, item_id, price, amount) values (86, 51, 92.4, 84);
insert into item_purchase (purchase_id, item_id, price, amount) values (86, 64, 91.1, 4);
insert into item_purchase (purchase_id, item_id, price, amount) values (86, 99, 69.96, 63);
insert into item_purchase (purchase_id, item_id, price, amount) values (87, 13, 36.81, 10);
insert into item_purchase (purchase_id, item_id, price, amount) values (87, 67, 17.48, 24);
insert into item_purchase (purchase_id, item_id, price, amount) values (87, 87, 11.24, 92);
insert into item_purchase (purchase_id, item_id, price, amount) values (88, 14, 54.58, 30);
insert into item_purchase (purchase_id, item_id, price, amount) values (88, 19, 63.7, 1);
insert into item_purchase (purchase_id, item_id, price, amount) values (88, 44, 19.95, 35);
insert into item_purchase (purchase_id, item_id, price, amount) values (89, 10, 11.42, 70);
insert into item_purchase (purchase_id, item_id, price, amount) values (89, 60, 89.93, 62);
insert into item_purchase (purchase_id, item_id, price, amount) values (89, 90, 42.39, 62);
insert into item_purchase (purchase_id, item_id, price, amount) values (90, 78, 30.67, 17);
insert into item_purchase (purchase_id, item_id, price, amount) values (90, 93, 13.35, 27);
insert into item_purchase (purchase_id, item_id, price, amount) values (90, 100, 84.72, 55);
insert into item_purchase (purchase_id, item_id, price, amount) values (91, 7, 72.76, 60);
insert into item_purchase (purchase_id, item_id, price, amount) values (91, 16, 26.02, 89);
insert into item_purchase (purchase_id, item_id, price, amount) values (91, 71, 26.49, 61);
insert into item_purchase (purchase_id, item_id, price, amount) values (92, 69, 65.44, 53);
insert into item_purchase (purchase_id, item_id, price, amount) values (92, 70, 14.13, 64);
insert into item_purchase (purchase_id, item_id, price, amount) values (92, 88, 27.61, 7);
insert into item_purchase (purchase_id, item_id, price, amount) values (93, 4, 27.48, 2);
insert into item_purchase (purchase_id, item_id, price, amount) values (93, 33, 93.64, 65);
insert into item_purchase (purchase_id, item_id, price, amount) values (93, 89, 28.0, 17);
insert into item_purchase (purchase_id, item_id, price, amount) values (94, 42, 93.98, 54);
insert into item_purchase (purchase_id, item_id, price, amount) values (94, 55, 22.54, 69);
insert into item_purchase (purchase_id, item_id, price, amount) values (94, 69, 23.15, 67);
insert into item_purchase (purchase_id, item_id, price, amount) values (95, 42, 43.54, 78);
insert into item_purchase (purchase_id, item_id, price, amount) values (95, 57, 44.86, 2);
insert into item_purchase (purchase_id, item_id, price, amount) values (95, 80, 62.33, 52);
insert into item_purchase (purchase_id, item_id, price, amount) values (96, 23, 69.22, 47);
insert into item_purchase (purchase_id, item_id, price, amount) values (96, 56, 51.09, 46);
insert into item_purchase (purchase_id, item_id, price, amount) values (96, 80, 57.42, 58);
insert into item_purchase (purchase_id, item_id, price, amount) values (97, 15, 11.11, 93);
insert into item_purchase (purchase_id, item_id, price, amount) values (97, 63, 49.06, 41);
insert into item_purchase (purchase_id, item_id, price, amount) values (97, 90, 24.06, 59);
insert into item_purchase (purchase_id, item_id, price, amount) values (98, 22, 39.95, 67);
insert into item_purchase (purchase_id, item_id, price, amount) values (98, 24, 55.93, 40);
insert into item_purchase (purchase_id, item_id, price, amount) values (98, 32, 69.34, 29);
insert into item_purchase (purchase_id, item_id, price, amount) values (99, 26, 36.34, 60);
insert into item_purchase (purchase_id, item_id, price, amount) values (99, 62, 88.05, 63);
insert into item_purchase (purchase_id, item_id, price, amount) values (99, 93, 14.92, 60);
insert into item_purchase (purchase_id, item_id, price, amount) values (100, 48, 57.83, 59);
insert into item_purchase (purchase_id, item_id, price, amount) values (100, 70, 41.17, 21);
insert into item_purchase (purchase_id, item_id, price, amount) values (100, 71, 59.01, 79);

insert into reviews (client_id, item_id, rating, description) values (1, 1, 5, 'Nullam porttitor lacus at turpis. Donec posuere metus vitae ipsum. Aliquam non mauris.');
insert into reviews (client_id, item_id, rating, description) values (1, 31, 1, 'Nullam porttitor lacus at turpis. Donec posuere metus vitae ipsum. Aliquam non mauris.');
insert into reviews (client_id, item_id, rating, description) values (1, 85, 3, 'Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus.  In sagittis dui vel nisl. Duis ac nibh. Fusce lacus purus, aliquet at, feugiat non, pretium quis, lectus.');
insert into reviews (client_id, item_id, rating, description) values (1, 99, 3, 'Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.  Aenean lectus. Pellentesque eget nunc. Donec quis orci eget orci vehicula condimentum.');
insert into reviews (client_id, item_id, rating, description) values (2, 24, 4, 'Fusce consequat. Nulla nisl. Nunc nisl.');
insert into reviews (client_id, item_id, rating, description) values (2, 56, 1, 'Duis aliquam convallis nunc. Proin at turpis a pede posuere nonummy. Integer non velit.  Donec diam neque, vestibulum eget, vulputate ut, ultrices vel, augue. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec pharetra, magna vestibulum aliquet ultrices, erat tortor sollicitudin mi, sit amet lobortis sapien sapien non mi. Integer ac neque.');
insert into reviews (client_id, item_id, rating, description) values (2, 88, 5, 'Integer tincidunt ante vel ipsum. Praesent blandit lacinia erat. Vestibulum sed magna at nunc commodo placerat.');
insert into reviews (client_id, item_id, rating, description) values (3, 16, 1, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Proin risus. Praesent lectus.');
insert into reviews (client_id, item_id, rating, description) values (3, 17, 2, 'Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.  Phasellus sit amet erat. Nulla tempus. Vivamus in felis eu sapien cursus vestibulum.');
insert into reviews (client_id, item_id, rating, description) values (3, 37, 3, 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus vestibulum sagittis sapien. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.');
insert into reviews (client_id, item_id, rating, description) values (4, 36, 2, 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus vestibulum sagittis sapien. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.  Etiam vel augue. Vestibulum rutrum rutrum neque. Aenean auctor gravida sem.');
insert into reviews (client_id, item_id, rating, description) values (4, 80, 5, 'Morbi porttitor lorem id ligula. Suspendisse ornare consequat lectus. In est risus, auctor sed, tristique in, tempus sit amet, sem.');
insert into reviews (client_id, item_id, rating, description) values (4, 90, 2, 'Integer ac leo. Pellentesque ultrices mattis odio. Donec vitae nisi.');
insert into reviews (client_id, item_id, rating, description) values (5, 42, 2, 'Nullam porttitor lacus at turpis. Donec posuere metus vitae ipsum. Aliquam non mauris.  Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis.');
insert into reviews (client_id, item_id, rating, description) values (5, 65, 3, 'Mauris enim leo, rhoncus sed, vestibulum sit amet, cursus id, turpis. Integer aliquet, massa id lobortis convallis, tortor risus dapibus augue, vel accumsan tellus nisi eu orci. Mauris lacinia sapien quis libero.  Nullam sit amet turpis elementum ligula vehicula consequat. Morbi a ipsum. Integer a nibh.');
insert into reviews (client_id, item_id, rating, description) values (5, 72, 2, 'Quisque porta volutpat erat. Quisque erat eros, viverra eget, congue eget, semper rutrum, nulla. Nunc purus.');
insert into reviews (client_id, item_id, rating, description) values (6, 40, 2, 'Donec diam neque, vestibulum eget, vulputate ut, ultrices vel, augue. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec pharetra, magna vestibulum aliquet ultrices, erat tortor sollicitudin mi, sit amet lobortis sapien sapien non mi. Integer ac neque.');
insert into reviews (client_id, item_id, rating, description) values (6, 91, 2, 'Nullam sit amet turpis elementum ligula vehicula consequat. Morbi a ipsum. Integer a nibh.');
insert into reviews (client_id, item_id, rating, description) values (6, 92, 4, 'Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis.  Fusce posuere felis sed lacus. Morbi sem mauris, laoreet ut, rhoncus aliquet, pulvinar sed, nisl. Nunc rhoncus dui vel sem.');
insert into reviews (client_id, item_id, rating, description) values (7, 2, 4, 'In sagittis dui vel nisl. Duis ac nibh. Fusce lacus purus, aliquet at, feugiat non, pretium quis, lectus.  Suspendisse potenti. In eleifend quam a odio. In hac habitasse platea dictumst.');
insert into reviews (client_id, item_id, rating, description) values (7, 63, 1, 'Quisque id justo sit amet sapien dignissim vestibulum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla dapibus dolor vel est. Donec odio justo, sollicitudin ut, suscipit a, feugiat et, eros.  Vestibulum ac est lacinia nisi venenatis tristique. Fusce congue, diam id ornare imperdiet, sapien urna pretium nisl, ut volutpat sapien arcu sed augue. Aliquam erat volutpat.');
insert into reviews (client_id, item_id, rating, description) values (7, 88, 2, 'Cras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.  Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.');
insert into reviews (client_id, item_id, rating, description) values (8, 28, 3, 'Morbi porttitor lorem id ligula. Suspendisse ornare consequat lectus. In est risus, auctor sed, tristique in, tempus sit amet, sem.  Fusce consequat. Nulla nisl. Nunc nisl.');
insert into reviews (client_id, item_id, rating, description) values (8, 50, 5, 'Etiam vel augue. Vestibulum rutrum rutrum neque. Aenean auctor gravida sem.');
insert into reviews (client_id, item_id, rating, description) values (8, 84, 2, 'Aenean fermentum. Donec ut mauris eget massa tempor convallis. Nulla neque libero, convallis eget, eleifend luctus, ultricies eu, nibh.');
insert into reviews (client_id, item_id, rating, description) values (9, 18, 3, 'Nulla ut erat id mauris vulputate elementum. Nullam varius. Nulla facilisi.  Cras non velit nec nisi vulputate nonummy. Maecenas tincidunt lacus at velit. Vivamus vel nulla eget eros elementum pellentesque.');
insert into reviews (client_id, item_id, rating, description) values (9, 43, 3, 'Praesent blandit. Nam nulla. Integer pede justo, lacinia eget, tincidunt eget, tempus vel, pede.  Morbi porttitor lorem id ligula. Suspendisse ornare consequat lectus. In est risus, auctor sed, tristique in, tempus sit amet, sem.');
insert into reviews (client_id, item_id, rating, description) values (9, 81, 1, 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus vestibulum sagittis sapien. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.');
insert into reviews (client_id, item_id, rating, description) values (10, 58, 2, 'Nulla ut erat id mauris vulputate elementum. Nullam varius. Nulla facilisi.');
insert into reviews (client_id, item_id, rating, description) values (10, 75, 4, 'Nullam porttitor lacus at turpis. Donec posuere metus vitae ipsum. Aliquam non mauris.');
insert into reviews (client_id, item_id, rating, description) values (10, 86, 2, 'Morbi porttitor lorem id ligula. Suspendisse ornare consequat lectus. In est risus, auctor sed, tristique in, tempus sit amet, sem.');
insert into reviews (client_id, item_id, rating, description) values (11, 52, 5, 'Mauris enim leo, rhoncus sed, vestibulum sit amet, cursus id, turpis. Integer aliquet, massa id lobortis convallis, tortor risus dapibus augue, vel accumsan tellus nisi eu orci. Mauris lacinia sapien quis libero.  Nullam sit amet turpis elementum ligula vehicula consequat. Morbi a ipsum. Integer a nibh.');
insert into reviews (client_id, item_id, rating, description) values (11, 63, 3, 'In sagittis dui vel nisl. Duis ac nibh. Fusce lacus purus, aliquet at, feugiat non, pretium quis, lectus.  Suspendisse potenti. In eleifend quam a odio. In hac habitasse platea dictumst.');
insert into reviews (client_id, item_id, rating, description) values (11, 99, 1, 'Nullam porttitor lacus at turpis. Donec posuere metus vitae ipsum. Aliquam non mauris.  Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis.');
insert into reviews (client_id, item_id, rating, description) values (12, 2, 4, 'Phasellus in felis. Donec semper sapien a libero. Nam dui.');
insert into reviews (client_id, item_id, rating, description) values (12, 30, 3, 'Maecenas ut massa quis augue luctus tincidunt. Nulla mollis molestie lorem. Quisque ut erat.');
insert into reviews (client_id, item_id, rating, description) values (12, 82, 4, 'Cras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.');
insert into reviews (client_id, item_id, rating, description) values (13, 11, 3, 'Duis bibendum, felis sed interdum venenatis, turpis enim blandit mi, in porttitor pede justo eu massa. Donec dapibus. Duis at velit eu est congue elementum.');
insert into reviews (client_id, item_id, rating, description) values (13, 60, 3, 'Nullam porttitor lacus at turpis. Donec posuere metus vitae ipsum. Aliquam non mauris.  Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis.');
insert into reviews (client_id, item_id, rating, description) values (13, 96, 4, 'Nullam porttitor lacus at turpis. Donec posuere metus vitae ipsum. Aliquam non mauris.  Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis.');
insert into reviews (client_id, item_id, rating, description) values (14, 26, 5, 'Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus.');
insert into reviews (client_id, item_id, rating, description) values (14, 29, 2, 'In quis justo. Maecenas rhoncus aliquam lacus. Morbi quis tortor id nulla ultrices aliquet.  Maecenas leo odio, condimentum id, luctus nec, molestie sed, justo. Pellentesque viverra pede ac diam. Cras pellentesque volutpat dui.');
insert into reviews (client_id, item_id, rating, description) values (14, 44, 5, 'Fusce posuere felis sed lacus. Morbi sem mauris, laoreet ut, rhoncus aliquet, pulvinar sed, nisl. Nunc rhoncus dui vel sem.  Sed sagittis. Nam congue, risus semper porta volutpat, quam pede lobortis ligula, sit amet eleifend pede libero quis orci. Nullam molestie nibh in lectus.');
insert into reviews (client_id, item_id, rating, description) values (15, 36, 2, 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus vestibulum sagittis sapien. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.');
insert into reviews (client_id, item_id, rating, description) values (15, 81, 4, 'Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis.  Fusce posuere felis sed lacus. Morbi sem mauris, laoreet ut, rhoncus aliquet, pulvinar sed, nisl. Nunc rhoncus dui vel sem.');
insert into reviews (client_id, item_id, rating, description) values (15, 97, 3, 'Phasellus sit amet erat. Nulla tempus. Vivamus in felis eu sapien cursus vestibulum.  Proin eu mi. Nulla ac enim. In tempor, turpis nec euismod scelerisque, quam turpis adipiscing lorem, vitae mattis nibh ligula nec sem.');
insert into reviews (client_id, item_id, rating, description) values (16, 26, 4, 'Phasellus sit amet erat. Nulla tempus. Vivamus in felis eu sapien cursus vestibulum.  Proin eu mi. Nulla ac enim. In tempor, turpis nec euismod scelerisque, quam turpis adipiscing lorem, vitae mattis nibh ligula nec sem.');
insert into reviews (client_id, item_id, rating, description) values (16, 43, 4, 'Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.  Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus vestibulum sagittis sapien. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.');
insert into reviews (client_id, item_id, rating, description) values (16, 63, 5, 'Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.  Phasellus sit amet erat. Nulla tempus. Vivamus in felis eu sapien cursus vestibulum.');
insert into reviews (client_id, item_id, rating, description) values (17, 52, 3, 'Praesent id massa id nisl venenatis lacinia. Aenean sit amet justo. Morbi ut odio.');
insert into reviews (client_id, item_id, rating, description) values (17, 88, 1, 'Mauris enim leo, rhoncus sed, vestibulum sit amet, cursus id, turpis. Integer aliquet, massa id lobortis convallis, tortor risus dapibus augue, vel accumsan tellus nisi eu orci. Mauris lacinia sapien quis libero.  Nullam sit amet turpis elementum ligula vehicula consequat. Morbi a ipsum. Integer a nibh.');
insert into reviews (client_id, item_id, rating, description) values (17, 98, 2, 'In hac habitasse platea dictumst. Etiam faucibus cursus urna. Ut tellus.');
insert into reviews (client_id, item_id, rating, description) values (18, 19, 2, 'Maecenas tristique, est et tempus semper, est quam pharetra magna, ac consequat metus sapien ut nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra diam vitae quam. Suspendisse potenti.');
insert into reviews (client_id, item_id, rating, description) values (18, 25, 1, 'Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.');
insert into reviews (client_id, item_id, rating, description) values (18, 75, 5, 'Vestibulum quam sapien, varius ut, blandit non, interdum in, ante. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Duis faucibus accumsan odio. Curabitur convallis.  Duis consequat dui nec nisi volutpat eleifend. Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus.');
insert into reviews (client_id, item_id, rating, description) values (19, 10, 4, 'Phasellus in felis. Donec semper sapien a libero. Nam dui.  Proin leo odio, porttitor id, consequat in, consequat ut, nulla. Sed accumsan felis. Ut at dolor quis odio consequat varius.');
insert into reviews (client_id, item_id, rating, description) values (19, 92, 2, 'Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus.  In sagittis dui vel nisl. Duis ac nibh. Fusce lacus purus, aliquet at, feugiat non, pretium quis, lectus.');
insert into reviews (client_id, item_id, rating, description) values (19, 100, 4, 'Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.');
insert into reviews (client_id, item_id, rating, description) values (20, 37, 3, 'Fusce consequat. Nulla nisl. Nunc nisl.  Duis bibendum, felis sed interdum venenatis, turpis enim blandit mi, in porttitor pede justo eu massa. Donec dapibus. Duis at velit eu est congue elementum.');
insert into reviews (client_id, item_id, rating, description) values (20, 52, 4, 'Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.  Aenean lectus. Pellentesque eget nunc. Donec quis orci eget orci vehicula condimentum.');
insert into reviews (client_id, item_id, rating, description) values (20, 80, 1, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Proin risus. Praesent lectus.  Vestibulum quam sapien, varius ut, blandit non, interdum in, ante. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Duis faucibus accumsan odio. Curabitur convallis.');
insert into reviews (client_id, item_id, rating, description) values (21, 14, 3, 'Mauris enim leo, rhoncus sed, vestibulum sit amet, cursus id, turpis. Integer aliquet, massa id lobortis convallis, tortor risus dapibus augue, vel accumsan tellus nisi eu orci. Mauris lacinia sapien quis libero.  Nullam sit amet turpis elementum ligula vehicula consequat. Morbi a ipsum. Integer a nibh.');
insert into reviews (client_id, item_id, rating, description) values (21, 68, 2, 'In hac habitasse platea dictumst. Etiam faucibus cursus urna. Ut tellus.  Nulla ut erat id mauris vulputate elementum. Nullam varius. Nulla facilisi.');
insert into reviews (client_id, item_id, rating, description) values (21, 88, 5, 'Maecenas tristique, est et tempus semper, est quam pharetra magna, ac consequat metus sapien ut nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra diam vitae quam. Suspendisse potenti.  Nullam porttitor lacus at turpis. Donec posuere metus vitae ipsum. Aliquam non mauris.');
insert into reviews (client_id, item_id, rating, description) values (22, 44, 3, 'Maecenas ut massa quis augue luctus tincidunt. Nulla mollis molestie lorem. Quisque ut erat.');
insert into reviews (client_id, item_id, rating, description) values (22, 58, 1, 'Phasellus in felis. Donec semper sapien a libero. Nam dui.');
insert into reviews (client_id, item_id, rating, description) values (23, 29, 4, 'Nam ultrices, libero non mattis pulvinar, nulla pede ullamcorper augue, a suscipit nulla elit ac nulla. Sed vel enim sit amet nunc viverra dapibus. Nulla suscipit ligula in lacus.');
insert into reviews (client_id, item_id, rating, description) values (23, 42, 5, 'Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis.');
insert into reviews (client_id, item_id, rating, description) values (23, 99, 2, 'Praesent id massa id nisl venenatis lacinia. Aenean sit amet justo. Morbi ut odio.  Cras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.');
insert into reviews (client_id, item_id, rating, description) values (24, 81, 2, 'Maecenas leo odio, condimentum id, luctus nec, molestie sed, justo. Pellentesque viverra pede ac diam. Cras pellentesque volutpat dui.  Maecenas tristique, est et tempus semper, est quam pharetra magna, ac consequat metus sapien ut nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra diam vitae quam. Suspendisse potenti.');
insert into reviews (client_id, item_id, rating, description) values (24, 82, 5, 'Maecenas leo odio, condimentum id, luctus nec, molestie sed, justo. Pellentesque viverra pede ac diam. Cras pellentesque volutpat dui.');
insert into reviews (client_id, item_id, rating, description) values (24, 91, 5, 'Suspendisse potenti. In eleifend quam a odio. In hac habitasse platea dictumst.');
insert into reviews (client_id, item_id, rating, description) values (25, 11, 5, 'Duis consequat dui nec nisi volutpat eleifend. Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus.  Mauris enim leo, rhoncus sed, vestibulum sit amet, cursus id, turpis. Integer aliquet, massa id lobortis convallis, tortor risus dapibus augue, vel accumsan tellus nisi eu orci. Mauris lacinia sapien quis libero.');
insert into reviews (client_id, item_id, rating, description) values (25, 20, 5, 'Praesent id massa id nisl venenatis lacinia. Aenean sit amet justo. Morbi ut odio.  Cras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.');
insert into reviews (client_id, item_id, rating, description) values (25, 66, 1, 'Nullam porttitor lacus at turpis. Donec posuere metus vitae ipsum. Aliquam non mauris.  Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis.');
insert into reviews (client_id, item_id, rating, description) values (26, 11, 4, 'Etiam vel augue. Vestibulum rutrum rutrum neque. Aenean auctor gravida sem.  Praesent id massa id nisl venenatis lacinia. Aenean sit amet justo. Morbi ut odio.');
insert into reviews (client_id, item_id, rating, description) values (26, 35, 3, 'Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.  Aenean lectus. Pellentesque eget nunc. Donec quis orci eget orci vehicula condimentum.');
insert into reviews (client_id, item_id, rating, description) values (26, 61, 5, 'Sed ante. Vivamus tortor. Duis mattis egestas metus.  Aenean fermentum. Donec ut mauris eget massa tempor convallis. Nulla neque libero, convallis eget, eleifend luctus, ultricies eu, nibh.');
insert into reviews (client_id, item_id, rating, description) values (27, 17, 3, 'Aenean lectus. Pellentesque eget nunc. Donec quis orci eget orci vehicula condimentum.  Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.');
insert into reviews (client_id, item_id, rating, description) values (27, 50, 1, 'In sagittis dui vel nisl. Duis ac nibh. Fusce lacus purus, aliquet at, feugiat non, pretium quis, lectus.  Suspendisse potenti. In eleifend quam a odio. In hac habitasse platea dictumst.');
insert into reviews (client_id, item_id, rating, description) values (27, 78, 5, 'Aliquam quis turpis eget elit sodales scelerisque. Mauris sit amet eros. Suspendisse accumsan tortor quis turpis.  Sed ante. Vivamus tortor. Duis mattis egestas metus.');
insert into reviews (client_id, item_id, rating, description) values (28, 13, 1, 'In congue. Etiam justo. Etiam pretium iaculis justo.  In hac habitasse platea dictumst. Etiam faucibus cursus urna. Ut tellus.');
insert into reviews (client_id, item_id, rating, description) values (28, 37, 3, 'Duis consequat dui nec nisi volutpat eleifend. Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus.  Mauris enim leo, rhoncus sed, vestibulum sit amet, cursus id, turpis. Integer aliquet, massa id lobortis convallis, tortor risus dapibus augue, vel accumsan tellus nisi eu orci. Mauris lacinia sapien quis libero.');
insert into reviews (client_id, item_id, rating, description) values (28, 54, 5, 'Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.');
insert into reviews (client_id, item_id, rating, description) values (29, 77, 4, 'Etiam vel augue. Vestibulum rutrum rutrum neque. Aenean auctor gravida sem.');
insert into reviews (client_id, item_id, rating, description) values (29, 88, 3, 'Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.');
insert into reviews (client_id, item_id, rating, description) values (29, 91, 1, 'Duis bibendum, felis sed interdum venenatis, turpis enim blandit mi, in porttitor pede justo eu massa. Donec dapibus. Duis at velit eu est congue elementum.  In hac habitasse platea dictumst. Morbi vestibulum, velit id pretium iaculis, diam erat fermentum justo, nec condimentum neque sapien placerat ante. Nulla justo.');
insert into reviews (client_id, item_id, rating, description) values (30, 64, 2, 'Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.  Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus vestibulum sagittis sapien. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.');
insert into reviews (client_id, item_id, rating, description) values (30, 76, 1, 'Praesent blandit. Nam nulla. Integer pede justo, lacinia eget, tincidunt eget, tempus vel, pede.  Morbi porttitor lorem id ligula. Suspendisse ornare consequat lectus. In est risus, auctor sed, tristique in, tempus sit amet, sem.');
insert into reviews (client_id, item_id, rating, description) values (30, 96, 1, 'Integer ac leo. Pellentesque ultrices mattis odio. Donec vitae nisi.  Nam ultrices, libero non mattis pulvinar, nulla pede ullamcorper augue, a suscipit nulla elit ac nulla. Sed vel enim sit amet nunc viverra dapibus. Nulla suscipit ligula in lacus.');
insert into reviews (client_id, item_id, rating, description) values (31, 2, 4, 'Morbi non lectus. Aliquam sit amet diam in magna bibendum imperdiet. Nullam orci pede, venenatis non, sodales sed, tincidunt eu, felis.  Fusce posuere felis sed lacus. Morbi sem mauris, laoreet ut, rhoncus aliquet, pulvinar sed, nisl. Nunc rhoncus dui vel sem.');
insert into reviews (client_id, item_id, rating, description) values (31, 14, 1, 'Praesent blandit. Nam nulla. Integer pede justo, lacinia eget, tincidunt eget, tempus vel, pede.  Morbi porttitor lorem id ligula. Suspendisse ornare consequat lectus. In est risus, auctor sed, tristique in, tempus sit amet, sem.');
insert into reviews (client_id, item_id, rating, description) values (32, 8, 4, 'Cras non velit nec nisi vulputate nonummy. Maecenas tincidunt lacus at velit. Vivamus vel nulla eget eros elementum pellentesque.');
insert into reviews (client_id, item_id, rating, description) values (32, 22, 2, 'Nullam sit amet turpis elementum ligula vehicula consequat. Morbi a ipsum. Integer a nibh.');
insert into reviews (client_id, item_id, rating, description) values (32, 82, 4, 'Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.  Aenean lectus. Pellentesque eget nunc. Donec quis orci eget orci vehicula condimentum.');
insert into reviews (client_id, item_id, rating, description) values (33, 9, 4, 'Cras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.');
insert into reviews (client_id, item_id, rating, description) values (33, 71, 4, 'Phasellus sit amet erat. Nulla tempus. Vivamus in felis eu sapien cursus vestibulum.  Proin eu mi. Nulla ac enim. In tempor, turpis nec euismod scelerisque, quam turpis adipiscing lorem, vitae mattis nibh ligula nec sem.');
insert into reviews (client_id, item_id, rating, description) values (33, 91, 2, 'Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.');
insert into reviews (client_id, item_id, rating, description) values (34, 27, 5, 'Aliquam quis turpis eget elit sodales scelerisque. Mauris sit amet eros. Suspendisse accumsan tortor quis turpis.');
insert into reviews (client_id, item_id, rating, description) values (34, 32, 2, 'Nulla ut erat id mauris vulputate elementum. Nullam varius. Nulla facilisi.  Cras non velit nec nisi vulputate nonummy. Maecenas tincidunt lacus at velit. Vivamus vel nulla eget eros elementum pellentesque.');
insert into reviews (client_id, item_id, rating, description) values (34, 89, 4, 'Cras mi pede, malesuada in, imperdiet et, commodo vulputate, justo. In blandit ultrices enim. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.  Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.');
insert into reviews (client_id, item_id, rating, description) values (35, 9, 4, 'Duis aliquam convallis nunc. Proin at turpis a pede posuere nonummy. Integer non velit.');
insert into reviews (client_id, item_id, rating, description) values (35, 52, 4, 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus vestibulum sagittis sapien. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.');
insert into reviews (client_id, item_id, rating, description) values (35, 96, 5, 'In quis justo. Maecenas rhoncus aliquam lacus. Morbi quis tortor id nulla ultrices aliquet.  Maecenas leo odio, condimentum id, luctus nec, molestie sed, justo. Pellentesque viverra pede ac diam. Cras pellentesque volutpat dui.');
insert into reviews (client_id, item_id, rating, description) values (36, 65, 3, 'Sed ante. Vivamus tortor. Duis mattis egestas metus.  Aenean fermentum. Donec ut mauris eget massa tempor convallis. Nulla neque libero, convallis eget, eleifend luctus, ultricies eu, nibh.');
insert into reviews (client_id, item_id, rating, description) values (36, 69, 5, 'Suspendisse potenti. In eleifend quam a odio. In hac habitasse platea dictumst.  Maecenas ut massa quis augue luctus tincidunt. Nulla mollis molestie lorem. Quisque ut erat.');
insert into reviews (client_id, item_id, rating, description) values (36, 96, 1, 'Proin eu mi. Nulla ac enim. In tempor, turpis nec euismod scelerisque, quam turpis adipiscing lorem, vitae mattis nibh ligula nec sem.  Duis aliquam convallis nunc. Proin at turpis a pede posuere nonummy. Integer non velit.');
insert into reviews (client_id, item_id, rating, description) values (37, 1, 2, 'Curabitur gravida nisi at nibh. In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem.');
insert into reviews (client_id, item_id, rating, description) values (37, 64, 4, 'Vestibulum ac est lacinia nisi venenatis tristique. Fusce congue, diam id ornare imperdiet, sapien urna pretium nisl, ut volutpat sapien arcu sed augue. Aliquam erat volutpat.');
insert into reviews (client_id, item_id, rating, description) values (37, 88, 4, 'In hac habitasse platea dictumst. Etiam faucibus cursus urna. Ut tellus.  Nulla ut erat id mauris vulputate elementum. Nullam varius. Nulla facilisi.');
insert into reviews (client_id, item_id, rating, description) values (38, 30, 4, 'In congue. Etiam justo. Etiam pretium iaculis justo.  In hac habitasse platea dictumst. Etiam faucibus cursus urna. Ut tellus.');
insert into reviews (client_id, item_id, rating, description) values (38, 64, 1, 'In hac habitasse platea dictumst. Etiam faucibus cursus urna. Ut tellus.');
insert into reviews (client_id, item_id, rating, description) values (38, 73, 2, 'In hac habitasse platea dictumst. Morbi vestibulum, velit id pretium iaculis, diam erat fermentum justo, nec condimentum neque sapien placerat ante. Nulla justo.');
insert into reviews (client_id, item_id, rating, description) values (39, 22, 5, 'Aenean lectus. Pellentesque eget nunc. Donec quis orci eget orci vehicula condimentum.  Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.');
insert into reviews (client_id, item_id, rating, description) values (39, 43, 5, 'Morbi porttitor lorem id ligula. Suspendisse ornare consequat lectus. In est risus, auctor sed, tristique in, tempus sit amet, sem.');
insert into reviews (client_id, item_id, rating, description) values (39, 46, 1, 'Morbi porttitor lorem id ligula. Suspendisse ornare consequat lectus. In est risus, auctor sed, tristique in, tempus sit amet, sem.');
insert into reviews (client_id, item_id, rating, description) values (40, 8, 4, 'Sed ante. Vivamus tortor. Duis mattis egestas metus.  Aenean fermentum. Donec ut mauris eget massa tempor convallis. Nulla neque libero, convallis eget, eleifend luctus, ultricies eu, nibh.');
insert into reviews (client_id, item_id, rating, description) values (40, 31, 3, 'Duis consequat dui nec nisi volutpat eleifend. Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus.  Mauris enim leo, rhoncus sed, vestibulum sit amet, cursus id, turpis. Integer aliquet, massa id lobortis convallis, tortor risus dapibus augue, vel accumsan tellus nisi eu orci. Mauris lacinia sapien quis libero.');
insert into reviews (client_id, item_id, rating, description) values (40, 40, 4, 'Maecenas tristique, est et tempus semper, est quam pharetra magna, ac consequat metus sapien ut nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Mauris viverra diam vitae quam. Suspendisse potenti.');
insert into reviews (client_id, item_id, rating, description) values (41, 14, 1, 'Proin interdum mauris non ligula pellentesque ultrices. Phasellus id sapien in sapien iaculis congue. Vivamus metus arcu, adipiscing molestie, hendrerit at, vulputate vitae, nisl.');
insert into reviews (client_id, item_id, rating, description) values (41, 72, 3, 'Phasellus sit amet erat. Nulla tempus. Vivamus in felis eu sapien cursus vestibulum.');
insert into reviews (client_id, item_id, rating, description) values (41, 78, 2, 'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus vestibulum sagittis sapien. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.  Etiam vel augue. Vestibulum rutrum rutrum neque. Aenean auctor gravida sem.');
insert into reviews (client_id, item_id, rating, description) values (42, 26, 5, 'Sed sagittis. Nam congue, risus semper porta volutpat, quam pede lobortis ligula, sit amet eleifend pede libero quis orci. Nullam molestie nibh in lectus.  Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.');
insert into reviews (client_id, item_id, rating, description) values (42, 76, 3, 'Maecenas ut massa quis augue luctus tincidunt. Nulla mollis molestie lorem. Quisque ut erat.  Curabitur gravida nisi at nibh. In hac habitasse platea dictumst. Aliquam augue quam, sollicitudin vitae, consectetuer eget, rutrum at, lorem.');
insert into reviews (client_id, item_id, rating, description) values (42, 83, 4, 'Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus.  In sagittis dui vel nisl. Duis ac nibh. Fusce lacus purus, aliquet at, feugiat non, pretium quis, lectus.');
insert into reviews (client_id, item_id, rating, description) values (43, 46, 3, 'In hac habitasse platea dictumst. Morbi vestibulum, velit id pretium iaculis, diam erat fermentum justo, nec condimentum neque sapien placerat ante. Nulla justo.');
insert into reviews (client_id, item_id, rating, description) values (43, 54, 1, 'Duis bibendum, felis sed interdum venenatis, turpis enim blandit mi, in porttitor pede justo eu massa. Donec dapibus. Duis at velit eu est congue elementum.  In hac habitasse platea dictumst. Morbi vestibulum, velit id pretium iaculis, diam erat fermentum justo, nec condimentum neque sapien placerat ante. Nulla justo.');
insert into reviews (client_id, item_id, rating, description) values (43, 99, 4, 'Quisque id justo sit amet sapien dignissim vestibulum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla dapibus dolor vel est. Donec odio justo, sollicitudin ut, suscipit a, feugiat et, eros.');
insert into reviews (client_id, item_id, rating, description) values (44, 19, 3, 'Aenean lectus. Pellentesque eget nunc. Donec quis orci eget orci vehicula condimentum.  Curabitur in libero ut massa volutpat convallis. Morbi odio odio, elementum eu, interdum eu, tincidunt in, leo. Maecenas pulvinar lobortis est.');
insert into reviews (client_id, item_id, rating, description) values (44, 94, 4, 'Cras non velit nec nisi vulputate nonummy. Maecenas tincidunt lacus at velit. Vivamus vel nulla eget eros elementum pellentesque.');
insert into reviews (client_id, item_id, rating, description) values (44, 98, 2, 'Vestibulum ac est lacinia nisi venenatis tristique. Fusce congue, diam id ornare imperdiet, sapien urna pretium nisl, ut volutpat sapien arcu sed augue. Aliquam erat volutpat.  In congue. Etiam justo. Etiam pretium iaculis justo.');
insert into reviews (client_id, item_id, rating, description) values (45, 6, 4, 'Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus.');
insert into reviews (client_id, item_id, rating, description) values (45, 14, 1, 'Nam ultrices, libero non mattis pulvinar, nulla pede ullamcorper augue, a suscipit nulla elit ac nulla. Sed vel enim sit amet nunc viverra dapibus. Nulla suscipit ligula in lacus.');
insert into reviews (client_id, item_id, rating, description) values (45, 38, 3, 'Duis aliquam convallis nunc. Proin at turpis a pede posuere nonummy. Integer non velit.  Donec diam neque, vestibulum eget, vulputate ut, ultrices vel, augue. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec pharetra, magna vestibulum aliquet ultrices, erat tortor sollicitudin mi, sit amet lobortis sapien sapien non mi. Integer ac neque.');
insert into reviews (client_id, item_id, rating, description) values (46, 40, 3, 'Fusce posuere felis sed lacus. Morbi sem mauris, laoreet ut, rhoncus aliquet, pulvinar sed, nisl. Nunc rhoncus dui vel sem.');
insert into reviews (client_id, item_id, rating, description) values (46, 54, 5, 'Aenean lectus. Pellentesque eget nunc. Donec quis orci eget orci vehicula condimentum.');
insert into reviews (client_id, item_id, rating, description) values (46, 76, 2, 'Cras non velit nec nisi vulputate nonummy. Maecenas tincidunt lacus at velit. Vivamus vel nulla eget eros elementum pellentesque.  Quisque porta volutpat erat. Quisque erat eros, viverra eget, congue eget, semper rutrum, nulla. Nunc purus.');
insert into reviews (client_id, item_id, rating, description) values (47, 27, 5, 'Etiam vel augue. Vestibulum rutrum rutrum neque. Aenean auctor gravida sem.');
insert into reviews (client_id, item_id, rating, description) values (47, 67, 4, 'Duis consequat dui nec nisi volutpat eleifend. Donec ut dolor. Morbi vel lectus in quam fringilla rhoncus.');
insert into reviews (client_id, item_id, rating, description) values (47, 76, 2, 'Sed ante. Vivamus tortor. Duis mattis egestas metus.  Aenean fermentum. Donec ut mauris eget massa tempor convallis. Nulla neque libero, convallis eget, eleifend luctus, ultricies eu, nibh.');
insert into reviews (client_id, item_id, rating, description) values (48, 11, 3, 'Donec diam neque, vestibulum eget, vulputate ut, ultrices vel, augue. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec pharetra, magna vestibulum aliquet ultrices, erat tortor sollicitudin mi, sit amet lobortis sapien sapien non mi. Integer ac neque.  Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus.');
insert into reviews (client_id, item_id, rating, description) values (48, 29, 3, 'Nullam sit amet turpis elementum ligula vehicula consequat. Morbi a ipsum. Integer a nibh.  In quis justo. Maecenas rhoncus aliquam lacus. Morbi quis tortor id nulla ultrices aliquet.');
insert into reviews (client_id, item_id, rating, description) values (48, 34, 2, 'Sed sagittis. Nam congue, risus semper porta volutpat, quam pede lobortis ligula, sit amet eleifend pede libero quis orci. Nullam molestie nibh in lectus.  Pellentesque at nulla. Suspendisse potenti. Cras in purus eu magna vulputate luctus.');
insert into reviews (client_id, item_id, rating, description) values (49, 41, 2, 'Duis bibendum. Morbi non quam nec dui luctus rutrum. Nulla tellus.  In sagittis dui vel nisl. Duis ac nibh. Fusce lacus purus, aliquet at, feugiat non, pretium quis, lectus.');
insert into reviews (client_id, item_id, rating, description) values (49, 48, 1, 'Fusce consequat. Nulla nisl. Nunc nisl.  Duis bibendum, felis sed interdum venenatis, turpis enim blandit mi, in porttitor pede justo eu massa. Donec dapibus. Duis at velit eu est congue elementum.');
