INSERT INTO clients (clientFirstname, clientLastname, clientEmail, clientPassword, comment)
VALUES ("Tony", "Stark", "tony@starknet.com", "Iam1ronM@n", "I am the real Ironman");

UPDATE clients
SET clientLevel = 3
WHERE clientFirstname = "Tony" AND clientLastname = "Stark";

UPDATE inventory
SET invDescription = REPLACE(invDescription, "small", "spacious")
WHERE invMake = "GM" AND invModel = "Hummer";

SELECT i.invModel, cc.classificationName
FROM inventory i
	INNER JOIN carclassification cc
    ON i.classificationId = cc.classificationId
WHERE cc.classificationName = "SUV";

DELETE FROM inventory
WHERE invMake = "Jeep" AND invModel = "Wrangler";

UPDATE inventory
SET invImage = CONCAT("/phpmotors", invImage),
	invThumbnail = CONCAT("/phpmotors", invThumbnail);