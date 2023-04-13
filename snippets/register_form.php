<?php
    if(isset($message)) {
        echo $message;
    }
?>

<div id="container_register_login_form">
    <form method="post" action="/phpmotors/accounts/index.php" class="form_grid">
        <label for="first-name" class="form-label">First Name:</label>
        <input type="text" name="clientFirstname" id="first-name" class="form-input" required
        <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";}  ?>>
        <!-- // inside of this variable (name="") we set the same name of the data base. -->

        <label for="last-name" class="form-label">Last Name:</label>
        <input type="text" name="clientLastname" id="last-name" class="form-input" required
        <?php if(isset($clientLastname)){echo "value='$clientLastname'";}  ?>>

        <label for="email" class="form-label">Email Address:</label>
        <input type="email" name="clientEmail" id="email" class="form-input" required
        <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?>>

        <label for="password" class="form-label">Password:</label>
        <input type="password" name="clientPassword" id="password" class="form-input" 
        pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>
        
        <!-- <div>
            <label for="show-password">Show Password</label>
            <input type="checkbox" id="show-password" onclick="showPassword()">
        </div> -->

        <span class="text-help">Make sure the password is at least 8 characters and has at least 
            1 uppercase character, 1 number and 1 special character.</span>
        <input type="submit" name="submit" id="regbtn" value="Register" class="form-button">
        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="register">

    </form>
    <div class="login_grid_image_car">
        <img id="hero" src="/phpmotors/uploads/images/delorean.jpg" alt="image of car">
    </div>
</div>


<script>
    function showPassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
