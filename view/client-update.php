<?php
    if ($_SESSION['clientData']['clientLevel'] < 1) {
        header('location: /phpmotors/');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Account Management</title>
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
            <h1>Manage Account</h1>
            <?php if (isset($message)) {echo $message;}?>
            <form action="/phpmotors/accounts/" method="post" class="form_grid">
                <h2>Update Account</h2>
                <label for="clientFirstname" class="form-label-modify">First Name</label>
                <input type="text" name="clientFirstname" id="clientFirstname" class="form-input-modify" required 
                value="<?php if(isset($_SESSION['clientData']['clientFirstname'])){ echo $_SESSION['clientData']['clientFirstname']; } ?>"> 

                <label for="clientLastname" class="form-label-modify">Last Name</label>
                <input type="text" name="clientLastname" id="clientLastname" class="form-input-modify" required 
                value="<?php if(isset($_SESSION['clientData']['clientLastname'])){ echo $_SESSION['clientData']['clientLastname']; } ?>"> 

                <label for="clientEmail" class="form-label-modify">Email</label>
                <input type="email" name="clientEmail" id="clientEmail" class="form-input-modify" required 
                value="<?php if(isset($_SESSION['clientData']['clientEmail'])){ echo $_SESSION['clientData']['clientEmail']; } ?>"> 
                
                <input type="hidden" name="action" value="updateInfoAccount">
                <input type="hidden" name="clientId" id="clientId" class="form-input-modify"
                value="<?php if(isset($_SESSION['clientData']['clientId'])){ echo $_SESSION['clientData']['clientId']; } ?>"> 

                <input type="submit" value="Update Info" class="form-button-modify">

            </form>
            <?php if (isset($messagePassword)) {echo $messagePassword;}?>
            <form action="/phpmotors/accounts/" method="post" class="form_grid">
                <h3>Update Password</h3>
                <span class="text-help">Make sure the password is at least 8 characters and has at least 
                1 uppercase character, 1 number and 1 special character.</span>
                <p>*note your original password will be changed</p>

                <label for="clientPassword" class="form-label-modify">Password</label>
                <input type="password" name="clientPassword" id="clientPassword" class="form-input" 
                pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>

                <input type="hidden" name="action" value="updatePasswordAccount">
                <input type="hidden" name="clientId" id="clientIdpassword" class="form-input-modify"
                value="<?php if(isset($_SESSION['clientData']['clientId'])){ echo $_SESSION['clientData']['clientId']; } ?>">  

                <input type="submit" value="Update Password" class="form-button-modify">
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