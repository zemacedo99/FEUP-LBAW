-- This File is not meant to be run. It's only use is to have definitions and to test them

-----------------------------------------
-- Queries
-----------------------------------------

-- SELECT 01 T
SELECT "users".id
FROM "users"
WHERE "users".email = $email AND "users".password = $password;

-- SELECT 02
-- Search items, suppliers and tags
SELECT *, ts_rank(text_search, to_tsquery('simple', $user_search)) as "rank"
FROM fts_view_weights
WHERE text_search @@ to_tsquery('simple', $user_search))
ORDER BY "rank" DESC;

-- Search only items by name
SELECT *, ts_rank(search, to_tsquery('simple', $user_search)) as "rank"
FROM items
WHERE search @@ to_tsquery('simple', $user_search)
ORDER BY "rank" DESC;

-- Search only items by name and tags
SELECT *, ts_rank(search_query.text_search, to_tsquery('simple', $user_search)) FROM
(SELECT items.id                                          as item_id,
       string_agg(value, ' ')                             as tags,
       (setweight(to_tsvector('simple', items.name), 'A') ||
        setweight(to_tsvector('simple', string_agg(value, ' ')), 'B')
        ) as text_search
FROM items
         JOIN item_tag ON (items.id = item_tag.item_id)
         JOIN tags ON (item_tag.tag_id = tags.id)
GROUP BY item_id) AS search_query
WHERE search_query.text_search @@ to_tsquery('simple', $user_search)
ORDER BY search_query.item_id;

-- SELECT 03 T
SELECT items.name, items.description, items.price
FROM client_item, clients, items
WHERE clients.id = client_item.client_id
  AND items.id = client_item.item_id
  AND client.client_id = $id_client;

-- SELECT 04 T
SELECT items.name, items.description, items.price
FROM carts, clients, items
WHERE clients.id = carts.client_id
  AND items.id = carts.item_id
  AND clients.id = $id_client;

-- SELECT 05
-- Supplier
SELECT name, address, post_code, city, description, path
FROM suppliers, images
WHERE suppliers.image_id = images.id
  AND suppliers.id = $id_supplier;

-- Client
SELECT clients.name, images.path
FROM clients, images
WHERE clients.image_id = images.id
  AND clients.id = $id_client;

-- SELECT 06
SELECT items.id, items.name, reviews.rating, reviews.description, clients.name
FROM reviews, items, clients
WHERE reviews.item_id = items.id
  AND reviews.client_id = clients.id
  AND reviews.item_id = $item_id;


-- INSERT 01
INSERT INTO reviews (client_id, item_id, rating, description)
VALUES ($client_id, $id_item, $rating, $description);

-- INSERT 02
INSERT INTO images (path) VALUES ($path);

-- INSERT 03
INSERT INTO ship_details (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, client_id)
VALUES ($first_name, $last_name, $address, $door_n, $zip_code, $district, $city, $country, $phone_n, $id_client);

-- INSERT 04
INSERT INTO credit_cards (card_n, expiration, cvv, holder, client_id)
VALUES ($card_n, $expiration, $cvv, $holder, $id_client);


-- UPDATE 01
UPDATE coupons
SET expiration = $new_date
WHERE id = $coupon_id;

-- UPDATE 02
-- Update email
UPDATE "users"
SET email = $email
WHERE id = $shopper_id;

-- Update password
UPDATE "users"
SET password = $password
WHERE id = $shopper_id;

-- UPDATE 03
UPDATE items
SET active = $active
WHERE id = $item_id;

-- UPDATE 04
UPDATE suppliers
SET accepted = $accepted
WHERE id = $supplier_id;

-- DELETE 01
DELETE FROM reviews
WHERE client_id = $id_client
  AND item_id = $id_item;

-- DELETE 02
DELETE FROM images
WHERE id = $id;

-----------------------------------------
-- Transactions
-----------------------------------------

-- TRANSACTION 01
SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;
DO $$
    DECLARE
        out_of_stock int;
        itm record;
    BEGIN
        SELECT COUNT(*) INTO out_of_stock
        FROM carts, items, item_purchase
        WHERE carts.item_id = items.id AND cart.id_client = $client_id
          AND items.stock - item_info.amount < 0;

        IF out_of_stock > 0 THEN
            RAISE NOTICE 'Attempted to buy out of stock items';
        ELSE
            FOR itm IN SELECT items.id, item_purchase.amount
                       FROM carts, items, item_purchase
                       WHERE carts.item_id = items.id AND cart.id_client = $id_client
                LOOP
                    UPDATE items
                    SET items.stock = items.stock - itm.amount
                    WHERE items.id = itm.id;
                END LOOP;

            INSERT INTO purchases (client_id, paid, purchase_date, type)
            VALUES ($client_id, $paid, $purchase_date, $type);

            DELETE FROM carts
            WHERE id_client = $id_client;
            COMMIT;
        END IF;
    END$$;


-- TRANSACTION 02
--Client
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;
DO $$
    DECLARE new_id integer;
    BEGIN
        INSERT INTO "users" (email, password, is_admin)
        VALUES ($email, $password, 'false') RETURNING id INTO new_id;


        INSERT INTO clients (id, name, image_id)
        VALUES (new_id, $name, $id_image);
    END $$;


--Supplier
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;
DO $$
    DECLARE new_id integer;
    BEGIN
        INSERT INTO "users" (email, password, is_admin)
        VALUES ($email, $password, 'false') RETURNING id INTO new_id;


        INSERT INTO suppliers (id, name, address, post_code, city, description, accepted, image_id)
        VALUES (new_id, $name, $address, $post_code, $city, $description, 'false', $id_image);
    END $$;

-- TRANSACTION 03
--Product
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;
DO $$
    DECLARE new_id integer;
    BEGIN
        INSERT INTO items (supplier_id, name, price, stock, description, active, rating, is_bundle)
        VALUES ($id_supplier, $name, $price, $stock, $description, $active, $rating, $is_bundle) RETURNING id INTO new_id;

        INSERT INTO products(id, type)
        VALUES (new_id, 'Kg');
    END $$;
