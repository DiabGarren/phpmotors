<?php

/*
 * Vechiles Controller
 */

// Create or access a Session
session_start();

require_once '../library/connections.php';
require_once '../model/main-model.php';
require_once '../model/vehicles-model.php';
require_once '../library/functions.php';

$classifications = getClassifications();

$navList = buildNav($classifications);

$action = trim(filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
if ($action == NULL) {
    $action = trim(filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
}

if (isset($_COOKIE['firstname'])) {
    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

switch ($action) {
        // From Vehicle Management View
    case 'add-classification-view':
        include '../view/add-classification.php';
        break;

        // From Add Classification View
    case 'add-classification':
        // Filter and store the data
        $classificationName = trim(filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        // Check if classificationName
        $classificationName = checkClassification($classificationName, $classifications);

        // Check for empty fields
        if (empty($classificationName)) {
            // Set error message
            $message = '<p class="form-warning red">Please provide information for <b>all</b> empty form fields.</p>';
            // Display page with the error message
            include '../view/add-classification.php';
            exit;
        } elseif ($exists) {
            // Set error message
            $message = "<p class='form-warning red'>$classificationName already exists.</p>";
            // Display page with the error message
            include '../view/add-classification.php';
            exit;
        }

        // Send the data to the model
        $classOutcome = addClassification($classificationName);

        // Check and report the result
        if ($classOutcome == 1) {
            header('Location: /phpmotors/vehicles/index.php');
            exit;
        } else {
            $message = "<p class='form-warning red'>Sorry, but the addition of this classification failed. Please try again.</p>";
            include '../view/add-classification.php';
            exit;
        }
        break;

        // From Vehicle Management View
    case 'add-vehicle-view':
        include '../view/add-vehicle.php';
        break;

        // From Add Vehicle View
    case 'add-vehicle':
        // Filter and store the data
        $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        // Check for empty fields
        if (empty($classificationId) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor) || empty($invMake)) {
            // Display message
            $message = '<p class="form-warning red">Please provide information for <b>all</b> empty form fields.</p>';
            include '../view/add-vehicle.php';
            exit;
        }

        // Send the data to the model
        $vehicleOutcome = addVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);

        // Check and report the result
        if ($vehicleOutcome == 1) {
            $message = "<p class='form-warning green'>The $invMake $invModel was added successfully.</p>";
            include '../view/add-vehicle.php';
            exit;
        } else {
            $message = "<p class='form-warning red'>Sorry, but the addition of this vehicle failed. Please try again.</p>";
            include '../view/add-vehicle.php';
            exit;
        }
        break;

        /*
         * Get vehicles by classificationId
         * Used for satrting Update & Delete process
         */
    case 'getInventoryItems':
        // Get the classificationId 
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        // Fetch the vehicles by classificationId from the DB 
        $inventoryArray = getInventoryByClassification($classificationId);
        // Convert the array to a JSON object and send it back 
        echo json_encode($inventoryArray);
        break;

    case 'mod':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if (count($invInfo) < 1) {
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-update.php';
        exit;
        break;

    case 'update-vehicle':
        $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        if (empty($classificationId) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor) || empty($invMake)) {
            $message = '<p class=" form-warning red">Please complete all information for the updated item! Double check the classification of the item.</p>';
            include '../view/vehicle-update.php';
            exit;
        }
        $insertResult = updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId);
        if ($insertResult) {
            $_SESSION['message'] = "<p class='outside form-warning green'>Congratulations, the $invMake $invModel was successfully updated.</p>";
            header('Location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = '<p class="outside form-warning red">Error. The vehicle was not updated.</p>';
            include '../view/vehicle-update.php';
            exit;
        }
        break;

    case 'del':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if (count($invInfo) < 1) {
            $message = '<p class="form-warning red">Sorry, no vehicle information could be found.</p>';
        }
        include '../view/vehicle-delete.php';
        exit;
        break;

    case 'delete-vehicle':
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        $deleteResult = deleteVehicle($invId);
        if ($deleteResult) {
            $_SESSION['message'] = "<p class='outside form-warning green'>The $invMake $invModel was successfully deleted.</p>";
            header('Location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p class='outside form-warning red'>Error. $invMake $invModel was not deleted.</p>";
            $_SESSION['message'] = $message;
            header('Location: /phpmotors/vehicles/');
            exit;
        }
        break;

    default:
        $classificationList = buildClassificationList($classifications);


        include '../view/vehicle-management.php';
        break;
}
