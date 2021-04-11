-- This File is not meant to be run. It's only use is to have definitions and to test them

-----------------------------------------
-- Queries
-----------------------------------------

-- SELECT 01
SELECT shopper_id
FROM shopper
WHERE shopper.email = $email AND shopper.password = $password

-- SELECT 02
-- TODO ver melhor com a aula do Cajó
SELECT supplier.name, item.name, price, item.description
FROM item, supplier
WHERE item.search @@ plainto_tsquery('english', $user_search)
ORDER BY ts_rank(item.search, plainto_tsquery('english', $user_search)) DESC

-- SELECT 03
SELECT item.name, item.description, item.price
FROM favorite, client, item
WHERE client.client_id = favorite.id_client AND item.item_id = favorite.id_item
  AND client.id_user = $id_shopper

-- SELECT 04
SELECT item.name, item.description, item.price
FROM cart, client, item
WHERE client.client_id = cart.id_client AND item.item_id = cart.id_item
  AND client.id_user = $id_shopper

-- SELECT 05
-- supplier
SELECT name, address, post_code, city, description
FROM supplier
WHERE supplier.id_user = $id

-- Client
SELECT client.name, image.path
FROM client, image
WHERE client.id_image = image.image_id AND client.client_id = $id

-- SELECT 06
SELECT review.rating, review.description, client.name
FROM review, item, client
WHERE review.id_item = item.item_id AND review.id_client = client.client_id
  AND review.id_item = $id_item


-- INSERT 01
INSERT INTO review (rating, description, id_client, id_item)
VALUES ($rating, $description, $id_client, $id_item);

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
SET expiration = $expirationDate
WHERE id = $id;

-- UPDATE 02
-- Update email
UPDATE shopper
SET email = $email
WHERE id = $id;

-- Update password
UPDATE shopper
SET password = $password
WHERE id = $id;

-- UPDATE 03
UPDATE item
SET active = $active
WHERE id = $id;

-- UPDATE 04
UPDATE supplier
SET accepted = 'true'
WHERE id_user = $id;

-- DELETE 01
DELETE FROM review
WHERE id_client = $id_client AND id_item = $id_item;

-- DELETE 02
DELETE FROM image
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
        FROM cart, item, item_info
        WHERE cart.id_item = item.item_id AND cart.id_client = $id_client
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

            INSERT INTO purchase (id_client, amount, purchase_date, type)
            VALUES ($id_client, $amount, $purchase_date, $type);

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
        INSERT INTO item (name, price, stock, description, active, rating, is_bundle)
        VALUES ($name, $price, $stock, $description, 'true', null, 'false') RETURNING id INTO new_id;


        INSERT INTO product(product_id, type)
        VALUES (new_id, $unit_type);
    END $$;