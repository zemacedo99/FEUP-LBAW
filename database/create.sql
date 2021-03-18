DROP TABLE IF EXISTS "user" CASCADE;
DROP TABLE IF EXISTS "admin" CASCADE;
DROP TABLE IF EXISTS "client" CASCADE;
DROP TABLE IF EXISTS "supplier" CASCADE;
DROP TABLE IF EXISTS "purchase" CASCADE;
DROP TABLE IF EXISTS "item" CASCADE;
DROP TABLE IF EXISTS "image" CASCADE;
DROP TABLE IF EXISTS "item_info" CASCADE;
DROP TABLE IF EXISTS "coupon" CASCADE;
DROP TABLE IF EXISTS "product" CASCADE;
DROP TABLE IF EXISTS "bundle" CASCADE;
DROP TABLE IF EXISTS "bundle_product" CASCADE;
DROP TABLE IF EXISTS "ship_detail" CASCADE;
DROP TABLE IF EXISTS "credit_card" CASCADE;
DROP TABLE IF EXISTS "tag" CASCADE;
DROP TABLE IF EXISTS "tag_item" CASCADE;
DROP TABLE IF EXISTS "review" CASCADE;
DROP TABLE IF EXISTS "client_credit_card" CASCADE;
DROP TABLE IF EXISTS "favorite" CASCADE;
DROP TABLE IF EXISTS "card" CASCADE;



DROP TYPE IF EXISTS "unit_type" CASCADE;
DROP TYPE IF EXISTS "coupon_type" CASCADE;
DROP TYPE IF EXISTS "purchase_type" CASCADE;


 
CREATE TYPE unit_type AS ENUM ('Kg', 'Un');
CREATE TYPE coupon_type AS ENUM ('%', '€');
CREATE TYPE purchase_type AS ENUM ('SingleBuy', 'Day', 'Week', 'Month');
 
 
CREATE TABLE image (
    id SERIAL PRIMARY KEY,
    image bytea NOT NULL
);


CREATE TABLE "user" (
    id SERIAL PRIMARY KEY,
    email TEXT NOT NULL CONSTRAINT user_email_uk UNIQUE,
    password TEXT NOT NULL
);

CREATE TABLE "admin" (
    id_user INTEGER NOT NULL REFERENCES "user" (id) ON UPDATE CASCADE,
    PRIMARY KEY (id_user)
);

CREATE TABLE client (
    id_user INTEGER NOT NULL REFERENCES "user" (id) ON UPDATE CASCADE,
    name TEXT NOT NULL,
    id_image INTEGER NOT NULL REFERENCES "image" (id) ON UPDATE CASCADE,
    PRIMARY KEY (id_user)
);

CREATE TABLE supplier (
    id_user INTEGER NOT NULL REFERENCES "user" (id) ON UPDATE CASCADE,
    name TEXT NOT NULL,
    address TEXT NOT NULL,
    post_code TEXT NOT NULL,
    city TEXT NOT NULL,
    description TEXT NOT NULL,
    accepted BOOLEAN NOT NULL,
    id_image INTEGER NOT NULL REFERENCES "image" (id) ON UPDATE CASCADE,
    PRIMARY KEY (id_user)
);



CREATE TABLE purchase (
    id SERIAL PRIMARY KEY,
    id_client INTEGER REFERENCES client (id_user),
    amount DECIMAL NOT NULL,
    "date" DATE NOT NULL,
    TYPE purchase_type NOT NULL,
    CONSTRAINT amount_positive_ck CHECK (amount > 0), 
    CONSTRAINT old_date_ck CHECK (date <= CURRENT_DATE)
);

CREATE TABLE item (
    id SERIAL PRIMARY KEY,
    id_supplier INTEGER REFERENCES supplier (id_user),
    name TEXT NOT NULL, 
    price DECIMAL NOT NULL,
    stock INTEGER NOT NULL, 
    description TEXT NOT NULL, 
    active BOOLEAN NOT NULL,
    CONSTRAINT price_positive_ck CHECK (price > 0),
    CONSTRAINT stock_not_negative_ck CHECK (stock >= 0)
);



CREATE TABLE item_info (
    id_purchase INTEGER NOT NULL REFERENCES purchase (id),
    id_item INTEGER NOT NULL REFERENCES item (id),
    price DECIMAL,
    amount INTEGER
);

CREATE TABLE tag (
    id SERIAL PRIMARY KEY,
    value text NOT NULL
);


CREATE TABLE tag_item (
    id_tag INTEGER NOT NULL REFERENCES tag (id) ON UPDATE CASCADE,
    id_item INTEGER NOT NULL REFERENCES item (id) ON UPDATE CASCADE,
    PRIMARY KEY (id_tag, id_item)
);


CREATE TABLE coupon (
    id SERIAL PRIMARY KEY,
    code text NOT NULL UNIQUE, 
    name text NOT NULL,
    amount real NOT NULL CHECK (amount > 0),
    description text NOT NULL,
    expiration TIMESTAMP WITH TIME zone NOT NULL CHECK (expiration > now()), 
    "coupon_type" coupon_type NOT NULL
);

CREATE TABLE product (
    item_id INTEGER PRIMARY KEY REFERENCES item (id) ON UPDATE CASCADE,
    "unit_type" unit_type NOT NULL

);



CREATE TABLE bundle(
    item_id INTEGER  NOT NULL REFERENCES item(id),
	PRIMARY KEY(item_id)
);


CREATE TABLE bundle_product(
    bundle_id INTEGER NOT NULL REFERENCES bundle(item_id),
    product_id INTEGER NOT NULL REFERENCES product(item_id),
    quantity INTEGER NOT NULL,
    constraint quantity_positive check (quantity >= 0),
    PRIMARY KEY (bundle_id, product_id)
);


CREATE TABLE ship_detail(
    id SERIAL PRIMARY KEY,
    first_name TEXT NOT NULL,
    last_name TEXT NOT NULL,
    address TEXT NOT NULL,
    door_n INTEGER NOT NULL,
    zip_code TEXT NOT NULL,
    district TEXT NOT NULL,
    city TEXT NOT NULL,
    country TEXT NOT NULL,
    phone_n TEXT NOT NULL,
    id_client INTEGER NOT NULL REFERENCES client(id_user)
);

CREATE TABLE credit_card(
    id SERIAL PRIMARY KEY,
    cardN text UNIQUE NOT NULL,
    expiration DATE NOT NULL,
    cvv INTEGER NOT NULL,
    holder TEXT NOT NULL    
);

CREATE TABLE review (
    id SERIAL,
    rating INTEGER,
    description TEXT NOT NULL,
    id_client INTEGER NOT NULL REFERENCES "client" (id_user) ON UPDATE CASCADE,
    id_item INTEGER NOT NULL REFERENCES "item" (id) ON UPDATE CASCADE,
    CONSTRAINT rating_ck CHECK (rating >= 1 AND rating <= 5),
    PRIMARY KEY (id)
);


CREATE TABLE client_credit_card (
    id SERIAL,
    id_client INTEGER NOT NULL REFERENCES "client" (id_user) ON UPDATE CASCADE,
    id_credit_card  INTEGER NOT NULL REFERENCES "credit_card" (id) ON UPDATE CASCADE,
    PRIMARY KEY (id)
);


CREATE TABLE favorite (
    id_client INTEGER NOT NULL REFERENCES "client" (id_user) ON UPDATE CASCADE,
    id_item  INTEGER NOT NULL REFERENCES "item" (id) ON UPDATE CASCADE,
    PRIMARY KEY (id_client, id_item)
);


CREATE TABLE card (
    id_client INTEGER NOT NULL REFERENCES "client" (id_user) ON UPDATE CASCADE,
    id_item  INTEGER NOT NULL REFERENCES "item" (id) ON UPDATE CASCADE,
    PRIMARY KEY (id_client, id_item)
);