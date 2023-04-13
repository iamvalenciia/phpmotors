<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $invInfo['invMake']; ?> vehicles | PHP Motors, Inc.</title>
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
            <?php if (isset($message)) {
                echo $message;
            }?>
            <?php if (isset($invInfo)) {
                echo $vehicleInfoDisplay;
            }?>
            <h2 id='h2customeReviews'>Customer Reviews</h2>
            <?php if (isset($_SESSION['reviewMessage'])) {
                echo $_SESSION['reviewMessage'];
                $_SESSION['reviewMessage'] = '';
            }?>
            <?php
            if (!isset($_SESSION['loggedin'])) {
                echo "<p>You must
                    <a href='/phpmotors/accounts?action=login-page' class='style-link' title='login php Motors'>
                    login</a>
                    to write a review</p>";
            } else {
                $nameValue = substr($_SESSION['clientData']['clientFirstname'], 0, 1) . $_SESSION['clientData']['clientLastname'];
                $clientId = $_SESSION['clientData']['clientId'];
                echo "
                <form id='containerReviewPost' method='post' action='/phpmotors/reviews/index.php'>
                    <input type='hidden' name='invId' value='$invId'>
                    <input type='hidden' name='clientId' value='$clientId'>
                    <input type='hidden' name='action' value='add-new-review'>

                    <label for='screen_name'>Screen Name:</label>
                    <input type='text' id='screen_name' name='screen_name' value='$nameValue' readonly class='form-input'>

                    <label for='review'>Review:</label>
                    <textarea id='review' name='reviewText' class='form-input' required></textarea>
                    
                    <input type='submit' value='Submit Review' class='form-button'>
              </form>";
            }?>
            <?php if (isset($reviewsDisplay)) {
                echo $reviewsDisplay;
            }?>
        </main>
        <hr>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
        </footer>
    </div>
</body>

</html>