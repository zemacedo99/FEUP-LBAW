-- This File is not meant to be run. It's only use is to have definitions and to test them

-----------------------------------------
-- Queries
-----------------------------------------

-- SELECT 01 T
SELECT shopper_id
FROM shopper
WHERE shopper.email = $email AND shopper.password = $password;

-- SELECT 02
-- Search items, suppliers and tags
SELECT *, ts_rank(text_search, to_tsquery('simple', $user_search)) as "rank"
FROM fts_view_weights
WHERE text_search @@ to_tsquery('simple', $user_search))
ORDER BY "rank" DESC;

-- Search only items by name
SELECT *, ts_rank(search, to_tsquery('simple', $user_search)) as "rank"
FROM item
WHERE search @@ to_tsquery('simple', $user_search)
ORDER BY "rank" DESC;

-- Search only items by name and tags
SELECT *, ts_rank(search_query.text_search, to_tsquery('simple', $user_search)) FROM
(SELECT item.item_id                                          as item_id,
       string_agg(value, ' ')                                 as tags,
       (setweight(to_tsvector('simple', item.name), 'A') ||
        setweight(to_tsvector('simple', string_agg(value, ' ')), 'B')
        ) as text_search
FROM item
         JOIN tag_item ON (item.item_id = tag_item.id_item)
         JOIN tag ON (tag_item.id_tag = tag.tag_id)
GROUP BY item_id) AS search_query
WHERE search_query.text_search @@ to_tsquery('simple', $user_search)
ORDER BY search_query.item_id;

-- SELECT 03 T
SELECT item.name, item.description, item.price
FROM favorite, client, item
WHERE client.client_id = favorite.id_client
  AND item.item_id = favorite.id_item
  AND client.client_id = $id_client;

-- SELECT 04 T
SELECT item.name, item.description, item.price
FROM cart, client, item
WHERE client.client_id = cart.id_client AND item.item_id = cart.id_item
  AND client.client_id = $id_client;

-- SELECT 05
-- supplier
SELECT name, address, post_code, city, description
FROM supplier
WHERE supplier.supplier_id = 51;

-- Client
SELECT client.name, image.path
FROM client, image
WHERE client.id_image = image.image_id AND client.client_id = $id_client;

-- SELECT 06
SELECT item.item_id, item.name, review.rating, review.description, client.name
FROM review, item, client
WHERE review.id_item = item.item_id AND review.id_client = client.client_id
  AND review.id_item = $item_id;


-- INSERT 01
INSERT INTO review (id_client, id_item, rating, description)
VALUES ($client_id, $id_item, $rating, $description);

-- INSERT 02
INSERT INTO image (path) VALUES ($path);

-- INSERT 03
INSERT INTO ship_detail (first_name, last_name, address, door_n, post_code, district, city, country, phone_n, id_client)
VALUES ($first_name, $last_name, $address, $door_n, $zip_code, $district, $city, $country, $phone_n, $id_client);

-- INSERT 04
INSERT INTO credit_card (card_n, expiration, cvv, holder, id_client)
VALUES ($card_n, $expiration, $cvv, $holder, $id_client);


-- UPDATE 01
UPDATE coupon
SET expiration = $new_date
WHERE coupon_id = $coupon_id;

-- UPDATE 02
-- Update email
UPDATE shopper
SET email = $email
WHERE shopper_id = $shopper_id;

-- Update password
UPDATE shopper
SET password = $password
WHERE shopper_id = $shopper_id;

-- UPDATE 03
UPDATE item
SET active = $active
WHERE item_id = $item_id;

-- UPDATE 04
UPDATE supplier
SET accepted = $accepted
WHERE supplier_id = $supplier_id;

-- DELETE 01
DELETE FROM review
WHERE id_client = $id_client AND id_item = $id_item;

-- DELETE 02
DELETE FROM image
WHERE image_id = $id;

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
        FROM cart, item, item_info
        WHERE cart.id_item = item.item_id AND cart.id_client = $client_id
          AND item.stock - item_info.amount < 0;

        IF out_of_stock > 0 THEN
            RAISE NOTICE 'Attempted to buy out of stock items';
        ELSE
            FOR itm IN SELECT item.item_id, item_info.amount
                       FROM cart, item, item_info
                       WHERE cart.id_item = item.item_id AND cart.id_client = $id_client
                LOOP
                    UPDATE item
                    SET item.stock = item.stock - itm.amount
                    WHERE item.item_id = itm.item_id;
                END LOOP;

            INSERT INTO purchase (id_client, paid, purchase_date, type)
            VALUES ($client_id, $paid, $purchase_date, $type);

            DELETE FROM cart
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
        INSERT INTO shopper (email, password, is_admin)
        VALUES ($email, $password, 'false') RETURNING shopper_id INTO new_id;


        INSERT INTO client (client_id, name, id_image)
        VALUES (new_id, $name, $id_image);
    END $$;


--Supplier
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;
DO $$
    DECLARE new_id integer;
    BEGIN
        INSERT INTO shopper (email, password, is_admin)
        VALUES ($email, $password, 'false') RETURNING shopper_id INTO new_id;


        INSERT INTO supplier (supplier_id, name, address, post_code, city, description, accepted, id_image)
        VALUES (new_id, $name, $address, $post_code, $city, $description, 'false', $id_image);
    END $$;

-- TRANSACTION 03
--Product
SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;
DO $$
    DECLARE new_id integer;
    BEGIN
        INSERT INTO item (id_supplier, name, price, stock, description, active, rating, is_bundle)
        VALUES ($id_supplier, $name, $price, $stock, $description, $active, $rating, $is_bundle) RETURNING item_id INTO new_id;

        INSERT INTO product(product_id, type)
        VALUES (new_id, 'Kg');
    END $$;