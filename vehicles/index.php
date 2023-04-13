<?php

// this is the Vehicles Controller for the site

// Create or access a Session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the vehicles model
require_once '../model/vehicles-model.php';
// Get the functions library
require_once '../library/functions.php';
// Get the images model
require_once '../model/uploads-model.php';
// Get the reviews model
require_once '../model/reviews-model.php';

// // Get the array of classifications
$classifications = getClassifications();

// Build a navigation bar using the $classifications array
$navList = buildNavigation($classifications);

// Controller for handling user actions and displaying views
$action = filter_input(INPUT_GET, 'action');
if ($action == null) {
    $action = filter_input(INPUT_POST, 'action');
}
switch ($action) {
    case 'vehicle':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        $invThumbnailImages = getVehicleThumbnailImages($invId);

        if (count($invInfo) < 1) {
            $message = 'Sorry, no vehicle information could be found.';
        } else {
            $vehicleInfoDisplay = buildVehicleInfoDisplay($invInfo, $invThumbnailImages);
            $reviews = "Customer Reviews";
        }

        //Dsiplay the reviews for a specific inventory item
        $vehicleReviews = getReviewsByInvId($invId);
        $reviewsDisplay = builReviewsDisplay($vehicleReviews);

        include '../view/vehicle-detail.php';
        break;

    case 'classification':
        $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vehicles = getVehiclesByClassification($classificationName);
        if (!count($vehicles)) {
            $message = "<p class='notice'>Sorry, no $classificationName could be found.</p>";
        } else {
            $vehicleDisplay = buildVehiclesDisplay($vehicles);
        }
        include '../view/classification.php';
        break;

    case 'add-vehicle-form':
        // Filter and store the data
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_URL));
        $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_URL));
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);

        // Check for missing data
        if (
            empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage)
            || empty($invThumbnail) || empty($invPrice) || empty($invStock)
            || empty($invColor) || empty($classificationId)
        ) {
            $message = "<p class='alert-failure'>Please provide information for all empty form fields .</p>";
            include '../view/add-vehicle.php';
            exit;
        }

        // Send the data to the model
        $regOutcome = regVehicle(
            $invMake,
            $invModel,
            $invDescription,
            $invImage,
            $invThumbnail,
            $invPrice,
            $invStock,
            $invColor,
            $classificationId
        );

        // Check and report the result
        if ($regOutcome === 1) {
            $message = "<p class='alert-successfully-added'>You successfully add the vehicle $invMake - $invModel.</p>";
            include '../view/add-vehicle.php';
            exit;
        } else {
            $message = "<p class='vehicle-alert-failure'>Sorry but the registration failed. Please try again.</p>";
            include '../view/add-vehicle.php';
            exit;
        }

        // no break
    case 'add-classification-form':
        // Filter and store the data
        $classificationName = filter_input(INPUT_POST, 'classificationName');

        // Check for missing data
        if (empty($classificationName)) {
            $message = "<p class='vehicle-alert-failure'>Please provide a name for the new car classification.</p>";
            include '../view/add-classification.php';
            exit;
        }

        // Send the data to the model
        $addOutcome = addClassification($classificationName);

        // Check and report the result
        if ($addOutcome === 1) {
            $message = "<p class='vehicle-alert-successfully-added'>You successfully add a car classification called $classificationName.</p>";
            include '../view/add-classification.php';
            exit;
        } else {
            $message = "<p class='vehicle-alert-failure'>You were not able to add a car classification called $classificationName.</p>";
            include '../view/add-classification.php';
            exit;
        }
        // no break
    case 'add-vehicle':
        include '../view/add-vehicle.php';
        break;
    case 'add-classification':
        include '../view/add-classification.php';
        break;
    case 'getInventoryItems':
        /* * **********************************
        * Get vehicles by classificationId
        * Used for starting Update & Delete process
        * ********************************** */
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
    case 'updateVehicle':
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        if (
            empty($classificationId) || empty($invMake) || empty($invModel)
            || empty($invDescription) || empty($invImage) || empty($invThumbnail)
            || empty($invPrice) || empty($invStock) || empty($invColor)
        ) {
            $message = "<p class='alert-failure' >Please complete all information for the item! Double check the classification of the item.</p>";
            include '../view/vehicle-update.php';
            exit;
        }

        $updateResult = updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId);

        if ($updateResult) {
            $message = "<p class='alert-successfully-added'>Congratulations, the $invMake $invModel was successfully updated.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p class='alert-failure'>Error. the $invMake $invModel was not updated.</p>";
            include '../view/vehicle-update.php';
            exit;
        }
        break;
    case 'del':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if (count($invInfo) < 1) {
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-delete.php';
        exit;
        break;
    case 'deleteVehicle':
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

        $deleteResult = deleteVehicle($invId);
        if ($deleteResult) {
            $message = "<p class='alert-successfully-added'>Congratulations the, $invMake $invModel was	successfully deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p class='alert-failure'>Error: $invMake $invModel was not
        deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        }
        break;
    default:
        $classificationList = buildClassificationList($classifications);
        include '../view/vehicle-man.php';
        exit;
}
