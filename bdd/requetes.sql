-- Chiffre d'affaires mois par mois pour une année sélectionnée
SELECT
    MONTH(order_date) AS mois,
    YEAR(order_date) AS annee,
    SUM(detail_quantity * detail_unit_price) AS chiffre_affaires
FROM
    `order`
    JOIN
    order_details ON `order`.id = order_details.detail_order_id
WHERE
    YEAR(order_date) = :annee_selectionnee
GROUP BY
    MONTH(order_date), YEAR(order_date)
ORDER BY
    YEAR(order_date), MONTH(order_date);

-- Chiffre d'affaire généré par fournisseur

SELECT
    supplier.supplier_name,
    SUM(order_details.detail_quantity * order_details.detail_unit_price) AS chiffre_affaires
FROM
    order_details
        JOIN
    product ON order_details.product_id = product.id
        JOIN
    supplier ON product.supplier_id = supplier.id
GROUP BY
    supplier.supplier_name
HAVING
        supplier.supplier_name = 'Nom du Fournisseur';

-- TOP 10 des produits les plus commandés pour une année sélectionnée

SELECT
    product.product_label AS nom_produit,
    product.id AS reference_produit,
    SUM(order_details.detail_quantity) AS quantite_commandee,
    supplier.supplier_name AS fournisseur
FROM
    order_details
        JOIN
    product ON order_details.product_id = product.id
        JOIN
    supplier ON product.supplier_id = supplier.id
        JOIN
    `order` ON order_details.detail_order_id = `order`.id
WHERE
    YEAR(`order`.order_date) = :annee -- Remplacez 2023 par l'année souhaitée
GROUP BY
    product.id
ORDER BY
    quantite_commandee DESC
    LIMIT 10;

-- TOP 10 des produits les plus rémunérateurs pour une année sélectionnée

SELECT
    product.product_label AS nom_produit,
    product.id AS reference_produit,
    (SUM(order_details.detail_unit_price) - SUM(order_details.detail_reduction)) * SUM(order_details.detail_quantity) AS marge,
    supplier.supplier_name AS fournisseur
FROM
    order_details
        JOIN
    product ON order_details.product_id = product.id
        JOIN
    supplier ON product.supplier_id = supplier.id
        JOIN
    `order` ON order_details.detail_order_id = `order`.id
WHERE
    YEAR(`order`.order_date) = :annee -- Remplacez 2023 par l'année souhaitée
GROUP BY
    product.id
ORDER BY
    marge DESC
    LIMIT 10;

-- Top 10 des clients en nombre de commandes

SELECT
    user.user_name AS nom_client,
    COUNT(`order`.id) AS nombre_de_commandes
FROM
    `order`
        JOIN
    user ON `order`.user_id = user.id
GROUP BY
    user.id
ORDER BY
    nombre_de_commandes DESC
    LIMIT 10;

-- Top 10 des clients en nombre de chiffre d'affaires

SELECT
    user.user_name AS nom_client,
    SUM(order_details.detail_unit_price * order_details.detail_quantity) AS chiffre_affaires
FROM
    order_details
        JOIN
    `order` ON order_details.detail_order_id = `order`.id
        JOIN
    user ON `order`.user_id = user.id
GROUP BY
    user.id
ORDER BY
    chiffre_affaires DESC
    LIMIT 10;

-- Répartition du chiffre d'affaires par type de client

SELECT
    user.user_type AS type_client,
    SUM(order_details.detail_unit_price * order_details.detail_quantity) AS chiffre_affaires
FROM
    order_details
        JOIN
    `order` ON order_details.detail_order_id = `order`.id
        JOIN
    user ON `order`.user_id = user.id
GROUP BY
    user.user_type;

-- Nombre de commandes en cours de livraison

SELECT COUNT(*) AS nombre_commandes_en_cours_de_livraison
FROM `order`
WHERE order_status = 'En cours';

