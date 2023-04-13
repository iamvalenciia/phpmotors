<?php
if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /phpmotors/');
}
    // Build the classifications option list
    $classifList = '<select name="classificationId" id="classificationId" class="form-input-modify">';
    $classifList .= "<option>Choose a Car Classification</option>";
        foreach ($classifications as $classification) {
            $classifList .= "<option value='$classification[classificationId]'";
            if(isset($classificationId)){
                if($classification['classificationId'] === $classificationId){
                    $classifList .= ' selected ';
                }
            } elseif(isset($invInfo['classificationId'])){
                if($classification['classificationId'] === $invInfo['classificationId']){
                    $classifList .= ' selected ';
                }
            }
        $classifList .= ">$classification[classificationName]</option>";
        }
    $classifList .= '</select>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php 
            if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
                echo "Modify $invInfo[invMake] $invInfo[invModel]";
            }elseif(isset($invMake) && isset($invModel)){ 
                echo "Modify $invMake $invModel"; 
            }
        ?> | PHP Motors</title>
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
            <h1>
                <?php 
                    if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
                        echo "Modify $invInfo[invMake] $invInfo[invModel]";} 
                    elseif(isset($invMake) && isset($invModel)) { 
                        echo "Modify$invMake $invModel";}
                ?>
            </h1>
            <?php if (isset($message)) {echo $message;}?>
            <p>*All the fields are required</p>
            <form action="/phpmotors/vehicles/" method="post" class="form_grid">
                <?php
                    echo $classifList
                ?>
                <br>
                <label for="invMake" class="form-label-modify">Make</label>
                <input type="text" name="invMake" id="invMake" class="form-input-modify" required
                    <?php 
                        if (isset($invMake)){
                            echo "value='$invMake'";
                        }elseif(isset($invInfo['invMake'])){
                            echo "value='$invInfo[invMake]'";
                        } 
                    ?>>
                <br>
                <label for="invModel" class="form-label-modify">Model</label>
                <input type="text" name="invModel" id="invModel" class="form-input-modify" required
                    <?php
                        if(isset($invModel)){
                            echo "value = '$invModel'";
                        } elseif(isset($invInfo['invModel'])){
                            echo "value='$invInfo[invModel]'";

                        }
                    ?>            
                >
                <br>
                <label for="invDescription" class="form-label-modify">Description</label>
                <textarea id="invDescription" name="invDescription" class="form-input-modify" required>
                    <?php
                        if(isset($invDescription)){
                            echo $invDescription;
                        }elseif (isset($invInfo['invDescription'])){
                            echo $invInfo['invDescription'];
                        }
                    ?>
                </textarea>
                <br>
                <label for="invImage" class="form-label-modify">Image Path</label>
                <input type="text" name="invImage" id="invImage" value="/php_motors/image/mo-image.png" class="form-input-modify" required
                    <?php
                        if(isset($invImage)){
                            echo "value='$invImage'";
                        }elseif (isset($invInfo['invImage'])){
                            echo "value='$invInfo[invImage]'";
                        }
                    ?>  
                >
                <br>
                <label for="invThumbnail" class="form-label-modify">Thumbnail Path</label>
                <input type="text" name="invThumbnail" id="invThumbnail" value="/php_motors/image/mo-image.png" class="form-input-modify" required
                    <?php
                        if(isset($invThumbnail)){
                            echo "value='$invThumbnail'";
                        }elseif (isset($invInfo['invThumbnail'])){
                            echo "value='$invInfo[invThumbnail]'";
                        }
                    ?> 
                >
                <br>
                <label for="invPrice" class="form-label-modify"> Price </label>
                <input type="text" name="invPrice" id="invPrice" class="form-input-modify" required
                    <?php
                        if(isset($invPrice)){
                            echo "value='$invPrice'";
                        }elseif (isset($invInfo['invPrice'])){
                            echo "value='$invInfo[invPrice]'";
                        }
                    ?>
                >
                <br>
                <label for="invStok" class="form-label-modify"># In Stock</label>
                <input type="text" name="invStock" id="invStock" class="form-input-modify" required
                    <?php
                        if(isset($invStock)){
                            echo "value='$invStock'";
                        }elseif (isset($invInfo['invStock'])){
                            echo "value='$invInfo[invStock]'";
                        }
                    ?>
                >
                <br>
                <label for="invColor" class="form-label-modify">Color</label>
                <input type="text" name="invColor" id="invColor" class="form-input-modify" required
                    <?php
                        if(isset($invColor)){
                            echo "value='$invColor'";
                        }elseif (isset($invInfo['invColor'])){
                            echo "value='$invInfo[invColor]'";
                        }
                    ?>
                >
                <br>
                <input type="submit" value="Update Vehicle" class="form-button-modify">
                <input type="hidden" name="action" value="updateVehicle">
                <input type="hidden" name="invId" 
                    value="
                        <?php 
                            if (isset($invInfo['invId'])){
                                echo $invInfo['invId'];
                            }elseif(isset($invId)){
                                echo $invId;
                            }
                        ?>
                    "
                >
            </form>
        </main>
        <hr>
        <footer>
            <?php require $_SERVER['DOCUMENT_ROOT'].'/phpmotors/snippets/footer.php'; ?>
        </footer>
    </div>
    <script src="../js/inventory.js"></script>
</body>
</html>