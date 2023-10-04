-- Créez une procédure stockée qui sélectionne les commandes non soldées (en cours de livraison)

DELIMITER //

CREATE PROCEDURE SelectNonSoldesOrders()
BEGIN
    SELECT * FROM `order` WHERE order_status = 'En cours';
END //

DELIMITER ;

-- Pour l'appeler
CALL SelectNonSoldesOrders();


-- renvoie le délai moyen entre la date de commande et la date de facturation

DELIMITER //

CREATE PROCEDURE AverageBillingDelay()
BEGIN
    SELECT AVG(DATEDIFF(order_date, order_billing)) AS average_delay
    FROM `order`
    WHERE order_billing IS NOT NULL;
END //

DELIMITER ;

-- Pour l'appeler
CALL AverageBillingDelay();