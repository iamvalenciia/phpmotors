<?php
  if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /phpmotors/');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Classification | PHP Motors</title>
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
            <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/car-classification.php'; ?>
        </main>
        <hr>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php'; ?>
        </footer>
    </div>
</body>
</html>