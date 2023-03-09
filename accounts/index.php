<?php

/*
 * Accounts controller
 */

// Create or access a Session
session_start();

require_once '../library/connections.php';
require_once '../model/main-model.php';
require_once '../model/accounts-model.php';
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
    case 'register-view':
        include '../view/registration.php';
        break;

    case 'register':
        // Filter and store the data
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        // Check for existing email address
        $checkEmail = checkExistingEmail($clientEmail);

        if ($checkEmail) {
            $message = '<p class="form-warning red">Email already exists.</p>';
            include '../view/login.php';
            exit;
        }

        // Check for empty fields
        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)) {
            // Display message
            $message = '<p class="form-warning red">Please provide information for <b>all</b> empty form fields.</p>';
            include '../view/registration.php';
            exit;
        }

        // Hash the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        // Send the data to the model
        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

        // Check and report the result
        if ($regOutcome === 1) {
            setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
            $_SESSION['message'] = "<p class='form-warning green'>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
            header('Location: /phpmotors/accounts?action=login-view');
            exit;
        } else {
            $message = "<p class='form-warning red'>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            include '../view/registration.php';
            exit;
        }
        break;

    case 'login-view':
        include '../view/login.php';
        break;

    case 'login':
        // Filter and store the data
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        // Check for empty fields
        if (empty($clientEmail) || empty($checkPassword)) {
            // Display message
            $message = '<p class="form-warning red">Please provide a valid email address and password.</p>';
            include '../view/login.php';
            exit;
        }

        /*
         * A valid password exists, proceed with the login process
         * Query the client data based on the email address
         */
        $clientData = getClient($clientEmail);
        if (!$clientData) {
            $message = "<p class='form-warning red'>This email is not registered</p>";
            include '../view/login.php';
            exit;
        }
        /*
         * Compare the password just submitted against
         *  the hashed password for the matching client
         */
        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
        /*
         * If the hashes don't match create an error
         *  and return to the login view
         */
        if (!$hashCheck) {
            $message = "<p class='form-warning red'>Please check your password and try again.</p>";
            include '../view/login.php';
            exit;
        }

        // A valid user exists, log them in
        $_SESSION['loggedin'] = TRUE;
        /*
         * Remove the password from the array
         * The array_pop function removes the last
         *  element from an array 
         */
        array_pop($clientData);
        // Store the array into the session
        $_SESSION['clientData'] = $clientData;
        // Send them to the admin view
        include '../view/admin.php';
        exit;
        break;

    case 'logout':
        $_SESSION = null;
        session_destroy();
        header('Location: /phpmotors/');
        break;

    case 'client-update':
        include '../view/client-update.php';
        exit;

    case 'update-account':
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

        $clientEmail = checkEmail($clientEmail);

        if ($clientFirstname == $_SESSION['clientData']['clientFirstname'] && $clientLastname == $_SESSION['clientData']['clientLastname'] && $clientEmail == $_SESSION['clientData']['clientEmail']) {
            $updateMessage = "<p class='form-warning red'>No fields were changed.</p>";
            include '../view/client-update.php';
            exit;
        }

        if ($clientEmail != $_SESSION['clientData']['clientEmail']) {
            if (checkExistingEmail($clientEmail)) {
                $updateMessage = "<p class='form-warning red'>Email already exists.</p>";
                include '../view/client-update.php';
                exit;
            }
        }

        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)) {
            $updateMessage = "<p class='form-warning red'>Please ensure <b>all</b> form fields are filled out.</p>";
            include '../view/client-update.php';
            exit;
        }

        $updateResult = updateAccount($clientId, $clientFirstname, $clientLastname, $clientEmail);
        if ($updateResult) {
            $_SESSION['message'] = "<p class='outside form-warning green'>Congratulations, your account was successfully updated.";
            $clientData = getClientById($clientId);
            array_pop($clientData);
            $_SESSION['clientData'] = $clientData;
        } else {
            $_SESSION['message'] = "<p class='outside form-warning red'>Error. Your account was not updated.</p>";
        }

        // header('Location: /phpmotors/accounts/');
        include '../view/admin.php'; //*
        exit;
        break;

    case 'update-password':
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

        $checkPassword = checkPassword($clientPassword);

        if (empty($checkPassword)) {
            $passMessage = "<p class='form-warning red'>Please enter a valid password.</p>";
            include '../view/client-update.php';
            exit;
        }
        
        if (password_verify($clientPassword, $_SESSION['clientData']['clientPassword'])) {
            $passMessage = "<p class='form-warning red'>Your new password can't be the same as your old password.</p>";
            include '../view/client-update.php';
            exit;
        }
        
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
        
        $updateResult = updatePassword($clientId, $hashedPassword);
        if ($updateResult) {
            $_SESSION['message'] = "<p class='outside form-warning green'>Congratulations, your password was successfully updated.";
            $clientData = getClientById($clientId);
            array_pop($clientData);
            $_SESSION['clientData'] = $clientData;
        } else {
            $_SESSION['message'] = "<p class='ouside form-warning red'>Error. Your password was not updated.</p>";
        }

        // header('Location: /phpmotors/accounts/');
        include '../view/admin.php';
        exit;
        break;

    default:
        include '../view/admin.php';
        break;
}
