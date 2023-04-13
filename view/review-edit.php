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
            <div>
                <?php
                echo "<h1>Edit $vehicleInfo[invMake] $vehicleInfo[invModel] Review</h1>";

                $timestamp = strtotime($reviewInfo['reviewDate']);
                $timeFormatted = date("j F, Y", $timestamp);
                echo "<p>Reviewed on $timeFormatted</p>";

                echo "
                <form id='containerEditPost' method='post' action='/phpmotors/reviews/index.php'>
                    <input type='hidden' name='reviewId' value='$reviewInfo[reviewId]'>
                    <input type='hidden' name='action' value='update-review'>

                    <label for='review'>Review:</label>
                    <textarea id='review' name='reviewText' class='form-input' required>$reviewInfo[reviewText]</textarea>
                    
                    <input type='submit' value='Update Review' class='form-button'>
                </form>";
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