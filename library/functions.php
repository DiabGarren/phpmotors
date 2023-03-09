<?php

/*
 * File for all custom functions
 */

function checkEmail($clientEmail)
{
    $validEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $validEmail;
}

function checkPassword($clientPassword)
{
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
    return preg_match($pattern, $clientPassword);
}

function checkClassification($classificationName, $classifications)
{
    foreach ($classifications as $classification) {
        if ($classificationName == $classification[0]) {
            return 0;
        }
    }

    if (strlen($classificationName) > 30) {
        return 0;
    }
    return $classificationName;
}

function buildNav($classifications)
{
    $navList = '<ul>';
    $navList .= "<li><a href='/phpmotors/' title='View the PHP Motors home page'>Home</a></li>";
    $navList .= '<li id="vehicle-list"><a href="#" title="View our list of vehicles">Vehicles</a><ul>';
    foreach ($classifications as $classification) {
        $navList .= "<li><a href='/phpmotors/?action=" . urlencode($classification['classificationName']) . "
            ' title='View our $classification[classificationName] product line'>$classification[classificationName]</a>
            </li>";
    }
    $navList .= '</ul></li></ul>';

    return $navList;
}

function buildClassificationList($classifications)
{
    $classificationList = '<select name="classificationId" id="classificationList">';
    $classificationList .= "<option>Choose a Classification</option>";
    foreach ($classifications as $classification) {
        $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>";
    }
    $classificationList .= '</select>';
    return $classificationList;
}

function getInventoryByClassification($classificationId)
{
    $db = phpmotorsConnect();
    $sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
    $stmt->execute();
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $inventory;
}
