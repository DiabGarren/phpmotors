<?php
/*
 * Accounts model
 */


/*
 * Function to handle site registrations
 */
function regClient($clientFirstname, $clientLastname, $clientEmail, $clientPassword)
{
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();

    // The SQL statement
    $sql = 'INSERT INTO clients (clientFirstname, clientLastname, clientEmail, clientPassword)
     VALUES (:clientFirstname, :clientLastname, :clientEmail, :clientPassword)';

    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);

    /*
     * The next four lines replace the placeholders in the SQL
     *  statement with the actual values in the variables
     *  and tells the database the type of data it is
     */
    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);

    // Insert the data
    $stmt->execute();

    // Adk how many rows changed as a result of our insert
    $rowsChanged = $stmt->rowCount();

    // Close the database interaction
    $stmt->closeCursor();

    // Return the indication of success (rows changed)
    return $rowsChanged;
}


/*
 * Check for an existing email address
 */
function checkExistingEmail($clientEmail)
{
    $db = phpmotorsConnect();
    $sql = 'SELECT clientEmail FROM clients WHERE clientEmail = :email';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $clientEmail, PDO::PARAM_STR);
    $stmt->execute();
    $matchEmail = $stmt->fetch(PDO::FETCH_NUM);
    $stmt->closeCursor();

    if (empty($matchEmail)) {
        return 0;
    } else {
        return 1;
    }
}

/*
 * Get client data based on an email address
 */
function getClient($clientEmail)
{
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM clients WHERE clientEmail = :clientEmail';
    $stmt = $db->prepare($sql);
    $stmt->bindvalue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->execute();
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $clientData;
}

/*
 * Get client data based on id
 */
function getClientById($clientId) 
{
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM clients WHERE clientId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindvalue(':clientId', $clientId, PDO::PARAM_STR);
    $stmt->execute();
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $clientData;
}

/*
 * Update account info
 */
function updateAccount($clientId, $clientFirstname, $clientLastname, $clientEmail)
{
    $db = phpmotorsConnect();
    $sql = 'UPDATE clients SET clientFirstname = :clientFirstname, 
    clientLastname = :clientLastname, clientEmail = :clientEmail
    WHERE clientId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindvalue(':clientFirstname', $clientFirstname, PDO::PARAM_STR);
    $stmt->bindvalue(':clientLastname', $clientLastname, PDO::PARAM_STR);
    $stmt->bindvalue(':clientEmail', $clientEmail, PDO::PARAM_STR);
    $stmt->bindvalue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

/*
 * Update client password 
 */
function updatePassword($clientId, $clientPassword)
{
    $db = phpmotorsConnect();
    $sql = 'UPDATE clients SET clientPassword = :clientPassword
    WHERE clientId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientPassword', $clientPassword, PDO::PARAM_STR);
    $stmt->bindvalue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}