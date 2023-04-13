
<?php
    // Build a dynamic drop-down select list using the array of classifications.
    $classificationList = '<select name="classificationId" class="form-input" id="classificationlist">';
    foreach ($classifications as $classification) {
        
        $classificationList .= "<option value='$classification[classificationId]'";
        if (isset($classificationId)){
            if ($classification['classificationId'] == $classificationId){
                        $classificationList .= 'selected';
            }
        }
        $classificationList .= ">$classification[classificationName]</option>";
    }
     $classificationList .= "</select>";
?>

<h1 class="title-each-page">Add Vehicle</h1>
<div>
    <?php
        if(isset($message)) {
            echo $message;
        }
    ?>
</div>
<div id="container_add_vehicle_main">
    <form method="post" action="/phpmotors/vehicles/index.php" class="form_grid">
        
        <label for="make" class="form-label">Make</label>
        <input type="text" name="invMake" id="make" class="form-input" required
        <?php if(isset($invMake)){echo "value='$invMake'";}  ?>>

        <label for="model" class="form-label">Model</label>
        <input type="text" name="invModel" id="model" class="form-input" required
        <?php if(isset($invModel)){echo "value='$invModel'";}  ?>>

        <label for="description" class="form-label">Description</label>
        <input type="text" name="invDescription" id="description" class="form-input" required
        <?php if(isset($invDescription)){echo "value='$invDescription'";}  ?>>

        <label for="imagePath" class="form-label">Image Path</label>
        <input type="text" name="invImage" id="imagePath" class="form-input" required
        <?php if(isset($invImage)){echo "value='$invImage'";}  ?>>

        <label for="thumbnailPath" class="form-label">Thumbnail Path</label>
        <input type="text" name="invThumbnail" id="thumbnailPath" class="form-input" required
        <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";}  ?>>

        <label for="price" class="form-label">Price</label>
        <input type="number" name="invPrice" id="price" class="form-input" required
        <?php if(isset($invPrice)){echo "value='$invPrice'";}  ?>>

        <label for="numberInStock" class="form-label">Number in stock</label>
        <input type="number" name="invStock" id="numberInStock" class="form-input" required
        <?php if(isset($invStock)){echo "value='$invStock'";}  ?>>

        <label for="color" class="form-label">Color</label>
        <input type="text" name="invColor" id="color" class="form-input" required
        <?php if(isset($invColor)){echo "value='$invColor'";}  ?>>

        <label for="classificationlist" class="form-label">Car classification</label>
        <?php echo $classificationList; ?>

        

        <input type="submit" name="submit" id="add-vehicle-btn" value="Add vehicle" class="form-button">
        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="add-vehicle-form">
    </form>
</div>
