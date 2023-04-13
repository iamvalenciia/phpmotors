<?php
if (!isset($_SESSION['clientData'])) {
    header('Location: /phpmotors/index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Motors</title>
    <link rel="stylesheet" href="/phpmotors/css/small.css" type="text/css" media="screen">
    <link rel="stylesheet" href="/phpmotors/css/large.css" media="screen" type="text/css">
</head>

<body>
    <div id="wrapper">
        <header>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>
        </header>
        <nav>
            <?php echo $navList; ?>
        </nav>
        <main>
            <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
                $_SESSION['message'] = '';
            }
            ?>
            <div class="container-user-information">
                <h1 class="h1name-admin-view"><?php echo $_SESSION['clientData']['clientFirstname'] . ' ' . $_SESSION['clientData']['clientLastname']; ?> </h1>
                <p class="pname-admin-view"><em>you are logged in</em></p>
                <div>
                    <p>First name: <em><?php echo $_SESSION['clientData']['clientFirstname']; ?></em></p>
                    <p>Last name:  <em><?php echo $_SESSION['clientData']['clientLastname']; ?></em></p>
                    <p>Email address:  <em><?php echo $_SESSION['clientData']['clientEmail']; ?></em></p>
                </div>
            </div>
            <div class="container-manage-information">
                <?php
                if ($_SESSION['clientData']['clientLevel'] >= 1) {
                    echo "<p>📖 Account Management</p>";
                    echo "<p>Use this <a href='/phpmotors/accounts/?action=update-account' class='style-link'>link</a> to manage the Account</p>";
                }
                ?>
                <?php
                if ($_SESSION['clientData']['clientLevel'] > 1) {
                    echo "<p>📖 Inventory Management</p>";
                    echo "<p>Use this <a href='/phpmotors/vehicles/?action=vehicle-man' class='style-link'>link</a> to manage the inventory</p>";
                }
                ?>
            </div>
            <div class="container-user-information">
                <?php
                // Get the reviews model
                require_once '../model/reviews-model.php';
                // Get the vehicles model
                require_once '../model/vehicles-model.php';

                if ($_SESSION['clientData']['clientLevel'] >= 1) {
                    $displayReviews = getReviewsByclientId($_SESSION['clientData']['clientId']);
                    $reversedReviews = array_reverse($displayReviews);
                    echo "<h2>Manage Your Product Reviews</h2>";
                    echo '<ul class="reviews-admin-view">';
                    foreach ($reversedReviews as $displayReview) {
                        $edit = "<a href='/phpmotors/reviews/?action=edit-review&reviewId=$displayReview[reviewId]&invId=$displayReview[invId]' class='style-link'>Edit</a>";
                        $remove = "<a href='/phpmotors/reviews/?action=confirm-remove&reviewId=$displayReview[reviewId]&invId=$displayReview[invId]' class='style-link'>Remove</a>";
                        $vehicleinfo = getInvItemInfo($displayReview['invId']);

                        $timestamp = strtotime($displayReview['reviewDate']);
                        $timeFormatted = date("j F, Y", $timestamp);

                        $reviews = '<li>';
                        $reviews .= "<P class='style-review-remove-view'>$displayReview[reviewText]</P>";
                        $reviews .= "<p><strong>$vehicleinfo[invMake] $vehicleinfo[invModel]</strong> (Reviewed on $timeFormatted) $edit | $remove</p>";
                        $reviews .= '</li>';
                        echo $reviews;
                    }
                    echo '</ul>';
                }
                ?>
            </div>
        </main>
        <hr>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
        </footer>
    </div>
</body>

</html>