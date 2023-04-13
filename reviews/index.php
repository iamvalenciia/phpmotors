<?php

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
// Get the vehicles model
require_once '../model/vehicles-model.php';
// Get the reviews model
require_once '../model/reviews-model.php';
// Get the images model
require_once '../model/uploads-model.php';

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
    case 'add-new-review':
        // Filter and store the data
        $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

        /************************************************/
        /* To load the images and information of the car /
        /************************************************/
        $invInfo = getInvItemInfo($invId);
        $invThumbnailImages = getVehicleThumbnailImages($invId);

        if (count($invInfo) < 1) {
            $message = 'Sorry, no vehicle information could be found.';
        } else {
            $vehicleInfoDisplay = buildVehicleInfoDisplay($invInfo, $invThumbnailImages);
        }

        // Check for missing data
        if (empty($reviewText) || empty($invId) || empty($clientId)) {
            $reviewMessage = "<p class='alert-failure'>The text field is empty.</p>";
            include '../view/vehicle-detail.php';
            exit;
        } 

        // Send the data to the model
        $dataBaseAnswer = addReview($reviewText, $invId, $clientId);

        if ($dataBaseAnswer === 1) {
            $_SESSION['reviewMessage'] = "<p class='alert-successfully-added'>Thanks for the review, it is displayed below.</p>";
            header("Location: /phpmotors/vehicles/?action=vehicle&invId=$invId");
            exit;
        } else {
            $_SESSION['reviewMessage'] = "<p class='vehicle-alert-failure'>Sorry but the registration failed. Please try again.</p>";
            header("Location: /phpmotors/vehicles/?action=vehicle&invId=$invId");
            exit;
        }

        break;

    case 'edit-review':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_VALIDATE_INT);
        $vehicleInfo = getInvItemInfo($invId);
        $reviewInfo = getSpecificReview($reviewId);

        include '../view/review-edit.php';
        exit;
        break;

    case 'update-review':
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        // Check for missing data
        if (empty($reviewId) || empty($reviewText)) {
            $_SESSION['message'] = "<p class='alert-failure'>The text field is empty.</p>";
            header("Location: /phpmotors/reviews/index.php");
            exit;
        } 

        // Send the update request to the model
        $updateReview = updateReview($reviewId, $reviewText);

        if ($updateReview) {
            $_SESSION['message']= "<p class='alert-successfully-added'>Congratulations, the review was successfully updated.</p>";
            header("Location: /phpmotors/reviews/index.php");
            exit;
        } else {
            $_SESSION['message'] = "<p class='alert-failure'>The review was not updated.</p>";
            header("Location: /phpmotors/reviews/index.php");
            exit;
        }

        break;

    case 'confirm-remove':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_VALIDATE_INT);
        $vehicleInfo = getInvItemInfo($invId);
        $reviewInfo = getSpecificReview($reviewId);


        include '../view/review-remove.php';
        exit;
        break;

    case 'remove-review':
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);

        // Send the remove request to the model
        $removeReview = deleteReview($reviewId);

        if ($removeReview) {
            $_SESSION['message']= "<p class='alert-successfully-added'>The review was deleted successfuly</p>";
            header("Location: /phpmotors/reviews/index.php");
            exit;
        } else {
            $_SESSION['message'] = "<p class='alert-failure'>The review was not deleted.</p>";
            header("Location: /phpmotors/reviews/index.php");
            exit;
        }
        break;

    default:
        if (isset($_SESSION['clientData'])) {
            include '../view/admin.php';
            exit;
        } else {
            header('Location: /phpmotors/index.php');
            exit;
        }
        exit;
}
