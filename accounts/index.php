 <?php
// this is the Accounts Controller for the site
// Create or access a Session
session_start();
// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';
// Get the functions library
require_once '../library/functions.php';
// Get the reviews model
require_once '../model/reviews-model.php';
// Get the vehicles model
require_once '../model/vehicles-model.php';

// Get the array of classifications
$classifications = getClassifications();

// Build a navigation bar using the $classifications array
$navList = buildNavigation($classifications);

// Controller for handling user actions and displaying views
$action = filter_input(INPUT_GET, 'action');
if ($action == null) {
    $action = filter_input(INPUT_POST, 'action');
}

switch ($action) {
    case 'register':
        // Filter and store the data
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        // Check for existing email
        $existingEmail = checkExistingEmail($clientEmail);
        // Deal with existing email during registration
        if ($existingEmail) {
            $message = '<p class="alert-failure">That email address already exists. Do you want to login instead?</p>';
            include '../view/login.php';
            exit;
        }

        // Check for missing data
        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)) {
            $message = '<p class="alert-failure">Please provide information for all empty form fields.</p>';
            include '../view/register.php';
            exit;
        }
        // Hash the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        // Send the data to the model
        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

        // Check and report the result
        if ($regOutcome === 1) {
            setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
            $_SESSION['message'] = "<p class='alert-successfully-added'>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
            header('Location: /phpmotors/accounts/?action=login-page');
            exit;
        } else {
            $message = "<p class='alert-failure'>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            include '../view/registration.php';
            exit;
        }
        // no break
    case 'Login':
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientEmail = checkEmail($clientEmail);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $passwordCheck = checkPassword($clientPassword);

        // Run basic checks, return if errors
        if (empty($clientEmail) || empty($passwordCheck)) {
            $message = '<p class="notice">Please provide a valid email address and password.</p>';
            include '../view/login.php';
            exit;
        }

        // Check if email exists in database
        $clientData = getClient($clientEmail);
        if (!$clientData) {
            $message = '<p class="notice">Email address not found.</p>';
            include '../view/login.php';
            exit;
        }

        // Compare the password just submitted against
        // the hashed password for the matching client
        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);

        // If the hashes don't match create an error
        // and return to the login view
        if (!$hashCheck) {
            $message = '<p class="notice">Please check your password and try again.</p>';
            include '../view/login.php';
            exit;
        }

        // A valid user exists, log them in
        $_SESSION['loggedin'] = true;

        // Remove the password from the array
        // the array_pop function removes the last
        // element from an array
        array_pop($clientData);

        // Store the array into the session
        $_SESSION['clientData'] = $clientData;

        //Reviews form the client
        // echo $_SESSION['clientData']['clientId'];
        // $displayReviews = getReviewsByclientId($_SESSION['clientData']['clientId']);
        // echo $displayReviews;

        // Send them to the admin view
        include '../view/admin.php';
        exit;
    case 'update-account':
        include '../view/client-update.php';
        break;
    case 'updateInfoAccount':

        // Get the client data from the session
        $clientData = $_SESSION['clientData'];

        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        $clientEmail = checkEmail($clientEmail);

        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($clientId)) {
            $message = "<p class='alert-failure'>Please provide information for all empty form fields. {$clientFirstname}
            {$clientLastname} {$clientEmail} {$clientId}</p>";
            include '../view/client-update.php';
            exit;
        }

        $updateResult = updateClient($clientId, $clientFirstname, $clientLastname, $clientEmail);

        // Update the client data with the new information
        $clientData['clientFirstname'] = $clientFirstname;
        $clientData['clientLastname'] = $clientLastname;
        $clientData['clientEmail'] = $clientEmail;

        if ($updateResult) {
            $message = "<p class='alert-successfully-added'>Congratulations, your account was successfully updated.</p>";
            $_SESSION['clientData'] = $clientData;
            $_SESSION['message'] = $message;
            include '../view/admin.php';
            exit;
        } else {
            $message = "<p class='alert-failure'>Error. your account was not updated.</p>";
            $_SESSION['message'] = $message;
            include '../view/admin.php';
            exit;
        }

        break;
    case 'updatePasswordAccount':
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $checkPassword = checkPassword($clientPassword);

        if (empty($clientPassword)) {
            $message = "<p class='alert-failure'>Please provide information for the empty form field.</p>";
            include '../view/client-update.php';
            exit;
        }

        // Hash the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        $updateResult = updatePassword($clientId, $hashedPassword);

        if ($updateResult) {
            $message = "<p class='alert-successfully-added'>Congratulations, your password was successfully updated.</p>";
            $_SESSION['message'] = $message;
            include '../view/admin.php';
            exit;
        } else {
            $message = "<p class='alert-failure'>Error. your password was not updated.</p>";
            $_SESSION['message'] = $message;
            include '../view/admin.php';
            exit;
        }
        break;
    case 'Logout':
        session_destroy();
        $_SESSION['loggedin'] = false;
        header('Location: /phpmotors/index.php');
        exit;
    case 'login-page':
        include '../view/login.php';
        break;
    case 'register-page':
        include '../view/register.php';
        break;
    default:
        include '../view/admin.php';
        break;
}
