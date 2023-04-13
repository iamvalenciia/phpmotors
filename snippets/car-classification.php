<h1 class='title-each-page'>Add Car Classification</h1>
<div>
    <?php
        if(isset($message)) {
            echo $message;
        }
    ?>
</div>
<div id="container_add_vehicle_main">
    <form method="post" action="/phpmotors/vehicles/index.php" class="form_grid">
        
        <label for="nameClassification" class="form-label">Classification Name</label>
        <span class="text-help">The field is limited to 30 characters</span>
        <input type="text" name="classificationName" id="nameClassification" class="form-input" 
        pattern = "^(.{0,30})$" maxlength="30" required>

        <input type="submit" name="submit" id="add-classification-btn" value="Add-classification-form" class="form-button">
        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="add-classification-form">
    </form>
</div>