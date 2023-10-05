-- Vue Product/Supplier

CREATE VIEW produitFournisseur
AS
SELECT s.id as supplierID, p.id as productID, s.supplier_name, s.supplier_phone, s.supplier_city, s.supplier_adress, s.supplier_pc, s.supplier_country, category_id, p.product_label, p.product_description, p.product_stock, p.product_picture, p.product_price, p.is_active
FROM product p
JOIN supplier s on s.id = p.supplier_id;


-- Vue Product/Category

CREATE VIEW Product_Category_Subcategory AS
SELECT p.id AS product_id, p.product_label, p.product_description, p.product_stock, p.product_picture, p.product_price, p.is_active, c.category_name, c.category_picture, sc.category_name AS subcategory_name, sc.category_picture AS subcategory_picture
FROM product p
JOIN category c ON p.category_id = c.id
LEFT JOIN category sc ON p.category_id = sc.id;