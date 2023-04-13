<?php
    if($_SESSION['clientData']['clientLevel'] < 2){
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
    <title><?php if(isset($invInfo['invMake'])){ 
	echo "Delete $invInfo[invMake] $invInfo[invModel]";} ?> | PHP Motors</title>
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
        <h1><?php if(isset($invInfo['invMake'])){ 
	        echo "Delete $invInfo[invMake] $invInfo[invModel]";} ?>
        </h1>
        <form method="post" action="/phpmotors/vehicles/">
        <fieldset class="form_grid">
            <label for="invMake" class="form-label-modify">Vehicle Make</label>
            <input type="text" readonly name="invMake" id="invMake" class="form-input-modify" <?php
        if(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?>>

            <label for="invModel" class="form-label-modify">Vehicle Model</label>
            <input type="text" readonly name="invModel" id="invModel" class="form-input-modify" <?php
        if(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?>>

            <label for="invDescription" class="form-label-modify">Vehicle Description</label>
            <textarea name="invDescription" readonly id="invDescription" class="form-input-modify"><?php
        if(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; }
        ?></textarea>

            <input type="submit" name="submit" value="Delete Vehicle" class="form-button-modify">
            <input type="hidden" name="action" value="deleteVehicle">
            <input type="hidden" name="invId" value="<?php if(isset($invInfo['invId'])){
        echo $invInfo['invId'];} ?>">
        </fieldset>
        </main>
        <hr>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php'; ?>
        </footer>
    </div>
    <script src="../js/inventory.js"></script>
</body>
</html>