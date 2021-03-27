DROP TABLE IF EXISTS image CASCADE;
DROP TABLE IF EXISTS credit_card CASCADE;
DROP TABLE IF EXISTS tag CASCADE;
DROP TABLE IF EXISTS shopper CASCADE; -- previously user
DROP TABLE IF EXISTS client CASCADE;
DROP TABLE IF EXISTS supplier CASCADE;
DROP TABLE IF EXISTS purchase CASCADE;
DROP TABLE IF EXISTS item CASCADE;
DROP TABLE IF EXISTS coupon CASCADE;
DROP TABLE IF EXISTS product CASCADE;
DROP TABLE IF EXISTS ship_detail CASCADE;
DROP TABLE IF EXISTS review CASCADE;
DROP TABLE IF EXISTS item_info CASCADE;
DROP TABLE IF EXISTS bundle_product CASCADE;
DROP TABLE IF EXISTS tag_item CASCADE;
DROP TABLE IF EXISTS product_image CASCADE;
DROP TABLE IF EXISTS favorite CASCADE;
DROP TABLE IF EXISTS cart CASCADE;

DROP TYPE IF EXISTS unit_type CASCADE;
DROP TYPE IF EXISTS coupon_type CASCADE;
DROP TYPE IF EXISTS purchase_type CASCADE;

-- Types
CREATE TYPE unit_type AS ENUM ('Kg', 'Un');
CREATE TYPE coupon_type AS ENUM ('%', '€');
CREATE TYPE purchase_type AS ENUM ('SingleBuy', 'Day', 'Week', 'Month');

-- Tables
CREATE TABLE image (
    id SERIAL PRIMARY KEY,
    image bytea NOT NULL
);

CREATE TABLE tag (
    id SERIAL PRIMARY KEY,
    value text NOT NULL
);

CREATE TABLE shopper (
    id SERIAL PRIMARY KEY,
    email TEXT NOT NULL CONSTRAINT user_email_uk UNIQUE,
    password TEXT NOT NULL,
    is_admin boolean NOT NULL 
);

CREATE TABLE client (
    id_user INTEGER NOT NULL REFERENCES shopper (id) ON UPDATE CASCADE,
    name TEXT NOT NULL,
    id_image INTEGER NOT NULL DEFAULT 1 REFERENCES image (id) ON UPDATE CASCADE,
    PRIMARY KEY (id_user)
);

CREATE TABLE supplier (
    id_user INTEGER NOT NULL REFERENCES shopper (id) ON UPDATE CASCADE,
    name TEXT NOT NULL,
    address TEXT NOT NULL,
    post_code TEXT NOT NULL,
    city TEXT NOT NULL,
    description TEXT NOT NULL,
    accepted BOOLEAN NOT NULL,
    id_image INTEGER NOT NULL DEFAULT 1 REFERENCES image (id) ON UPDATE CASCADE,
    PRIMARY KEY (id_user)
);

CREATE TABLE purchase (
    id SERIAL PRIMARY KEY,
    id_client INTEGER NOT NULL REFERENCES client (id_user),
    amount DECIMAL NOT NULL,
    purchase_date DATE NOT NULL,
    type purchase_type NOT NULL,
    CONSTRAINT amount_positive_ck CHECK (amount > 0), 
    CONSTRAINT old_date_ck CHECK (purchase_date <= CURRENT_DATE)
);

-- BusinessRule: Item either is a bundle, or a product, can't have is_bundle true and be referenced in product
CREATE TABLE item (
    id SERIAL PRIMARY KEY,
    id_supplier INTEGER NOT NULL REFERENCES supplier (id_user),
    name TEXT NOT NULL, 
    price DECIMAL NOT NULL,
    stock INTEGER NOT NULL, 
    description TEXT NOT NULL, 
    active BOOLEAN NOT NULL,
    rating DECIMAL,
    is_bundle BOOLEAN NOT NULL,
    CONSTRAINT price_positive_ck CHECK (price > 0),
    CONSTRAINT stock_not_negative_ck CHECK (stock >= 0)
);

CREATE TABLE coupon (
    id SERIAL PRIMARY KEY,
    code text NOT NULL UNIQUE, 
    name text NOT NULL,
    description text NOT NULL,
    expiration DATE NOT NULL CHECK (expiration > now()), 
    type coupon_type NOT NULL,
    amount real NOT NULL CHECK (amount > 0),
    supplier INTEGER NOT NULL REFERENCES supplier(id_user)
);

CREATE TABLE product (
    item_id INTEGER PRIMARY KEY REFERENCES item (id) ON UPDATE CASCADE,
    type unit_type NOT NULL
);

CREATE TABLE ship_detail (
    id SERIAL PRIMARY KEY,
    first_name TEXT NOT NULL,
    last_name TEXT NOT NULL,
    address TEXT NOT NULL,
    door_n INTEGER NOT NULL,
    post_code TEXT NOT NULL,
    district TEXT NOT NULL,
    city TEXT NOT NULL,
    country TEXT NOT NULL,
    phone_n TEXT NOT NULL,
    id_client INTEGER NOT NULL REFERENCES client(id_user)
);

CREATE TABLE credit_card (
    id SERIAL PRIMARY KEY,
    card_n text NOT NULL,
    expiration DATE NOT NULL,
    cvv INTEGER NOT NULL,
    holder TEXT NOT NULL,
    id_client INTEGER NOT NULL REFERENCES client(id_user)
);

CREATE TABLE review (
    id_client INTEGER NOT NULL REFERENCES client (id_user) ON UPDATE CASCADE,
    id_item INTEGER NOT NULL REFERENCES item (id) ON UPDATE CASCADE,
    rating INTEGER NOT NULL,
    description TEXT NOT NULL,
    CONSTRAINT rating_ck CHECK (rating >= 1 AND rating <= 5),
    PRIMARY KEY (id_client, id_item)
);

CREATE TABLE item_info (
    id_purchase INTEGER NOT NULL REFERENCES purchase (id),
    id_item INTEGER NOT NULL REFERENCES item (id),
    price DECIMAL,
    amount DECIMAL,
    PRIMARY KEY (id_purchase, id_item)
);

CREATE TABLE bundle_product (
    bundle_id INTEGER NOT NULL REFERENCES item(id),
    product_id INTEGER NOT NULL REFERENCES product(item_id),
    quantity INTEGER NOT NULL,
    constraint quantity_positive check (quantity >= 0),
    PRIMARY KEY (bundle_id, product_id)
);


CREATE TABLE tag_item (
    id_tag INTEGER NOT NULL REFERENCES tag (id) ON UPDATE CASCADE,
    id_item INTEGER NOT NULL REFERENCES item (id) ON UPDATE CASCADE,
    PRIMARY KEY (id_tag, id_item)
);

CREATE TABLE product_image (
    id_product INTEGER REFERENCES product (item_id) ON UPDATE CASCADE,
    id_image INTEGER REFERENCES image (id) ON UPDATE CASCADE,
    PRIMARY KEY (id_product, id_image)
);

CREATE TABLE favorite (
    id_client INTEGER NOT NULL REFERENCES client (id_user) ON UPDATE CASCADE,
    id_item  INTEGER NOT NULL REFERENCES item (id) ON UPDATE CASCADE,
    PRIMARY KEY (id_client, id_item)
);

CREATE TABLE cart (
    id_client INTEGER NOT NULL REFERENCES client (id_user) ON UPDATE CASCADE,
    id_item  INTEGER NOT NULL REFERENCES item (id) ON UPDATE CASCADE,
    PRIMARY KEY (id_client, id_item)
);