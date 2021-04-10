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
WHERE client.id_user = favorite.id_client AND item.id = favorite.id_item
  AND client.id_user = $id_shopper
