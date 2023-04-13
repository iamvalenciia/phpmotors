<?php
    if ($_SESSION['clientData']['clientLevel'] < 2) {
        header('location: /phpmotors/');
        exit;
    }
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Managment | PHP Motors</title>
    <link rel="stylesheet" href="/phpmotors/css/small.css" type="text/css" media="screen">
    <link rel="stylesheet" href="/phpmotors/css/large.css" media="screen" type="text/css">
</head>
<body>
    <div id="wrapper">
        <header>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/header.php'; ?>
        </header>
        <nav>
            <?php echo $navList; ?>
        </nav>
        <main>
            <h1>Vehicle Management</h1>
            <ul>
                <li><a id="link-add-classification" href="/phpmotors/vehicles?action=add-classification" 
                title="add an car clasification to database table">Add Classification</a></li>
                <li><a id="link-add-vehicle" href="/phpmotors/vehicles?action=add-vehicle" 
                title="add an car to database table">Add Vehicle</a></li>
            </ul>
            <?php
                if (isset($message)) { 
                    echo $message; 
                } 
                if (isset($classificationList)) { 
                    echo '<h2>Vehicles By Classification</h2>'; 
                    echo '<p>Choose a classification to see those vehicles</p>'; 
                    echo $classificationList; 
                }
            ?>
            <noscript>
                <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
            </noscript>
            <table id="inventoryDisplay"></table>
        </main>
        <hr>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php'; ?>
        </footer>
    </div>
    <script src="../js/inventory.js"></script>
</body>
</html>
<?php unset($_SESSION['message']); ?>