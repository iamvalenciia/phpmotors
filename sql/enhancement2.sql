/*
    Insert a client into the clients table
*/
INSERT INTO clients (clientFirstname, clientLasname, clientEmail, clientPassword, comment) 
Values ('Tony','Stark','tony@starkent.com','Iam1ronM@n','I am the real Ironman');


/*
    Modify the Tony Stark record to change the clientLevel to 3
*/
UPDATE clients SET clientLevel = 3 WHERE clientEmail = 'tony@starkent.com';


/*
    Modify the "GM Hummer" record to read "spacious interior" rather than "small interior"
*/
UPDATE inventory SET invDescription = REPLACE(invDescription, 'small interior', 'spacious interior') 
WHERE invId = 12;


/*
    Use an inner join to select the invModel field from the inventory table and the classificationName field
    from the carclassification table for inventory items that belong to the "SUV" category.
*/
SELECT inventory.invModel, carclassification.classificationName
FROM inventory
INNER JOIN carclassification ON inventory.classificationId = carclassification.classificationId
WHERE carclassification.classificationName = 'SUV';


/*
    Delete the Jeep Wrangler from the database.
*/
DELETE FROM inventory WHERE invId = 1;


/*
    Update all records in the Inventory table to add "/phpmotors" to the beginning of the file path in the invImage and invThumbnail columns
*/
UPDATE inventory SET invImage = CONCAT('/phpmotors', invImage), invThumbnail = CONCAT('/phpmotors', invThumbnail);






