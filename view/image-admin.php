<?php
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
    <title>Image Management</title>
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
            <h1>Image Management</h1>
            <p>Welcome to the image management page! We're here
            to help you organize and optimize your visual
            content. Please choose one of the
            options below to get started.</p>
            <h2>Add New Vehicle Image</h2>
            <?php
                if (isset($message)){
                echo $message;
            }?>
            <form class="form_grid"  action="/phpmotors/uploads/" method="post" enctype="multipart/form-data">
                <label class="form-label-modify"  for="invItem">Vehicle</label>
	            <?php echo $prodSelect; ?>
	            <fieldset class="form-input-modify">
		            <label>Is this the main image for the vehicle?</label>
		            <label for="priYes" class="pImage">Yes</label>
		            <input type="radio" name="imgPrimary" id="priYes" class="pImage" value="1">
		            <label for="priNo" class="pImage">No</label>
		            <input type="radio" name="imgPrimary" id="priNo" class="pImage" checked value="0">
	            </fieldset>
                <label>Upload Image:</label>
                <input class="form-label-modify" type="file" name="file1">
                <input type="submit" class="form-button-modify" value="Upload">
                <input type="hidden" name="action" value="upload">
            </form>
            <hr/>
            <h2>Existing Images</h2>
            <p class="notice">If deleting an image, delete the thumbnail too and vice versa.</p>
            <?php
                if (isset($imageDisplay)){
                    echo $imageDisplay;
                }
            ?>

        </main>
        <hr>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php'; ?>
        </footer>
    </div>
</body>
</html>
<?php unset($_SESSION['message']); ?>
