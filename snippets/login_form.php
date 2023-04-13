<?php
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
    }
?>

<div id="container_register_login_form">
    <form class="form_grid" action="/phpmotors/accounts/index.php" method="post">
        <label for="email" class="form-label">Email Address:</label>
        <input type="email" id="email" name="clientEmail" required class="form-input" required
        <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?>>

        <label for="password" class="form-label">Password:</label>
        <input type="password" name="clientPassword" id="password" class="form-input"
        pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>

        <span class="text-help">Make sure the password is at least 8 characters and has at least
            1 uppercase character, 1 number and 1 special character.</span>
        <input type="submit" value="Sign-in" class="form-button">
        <input type="hidden" name="action" value="Login">
        <div class="form-register-link">
            <a id="register_text_link" href="/phpmotors/accounts?action=register-page">Create new account</a>
        </div>
    </form>
    <div class="login_grid_image_car">
        <img id="hero" src="/phpmotors/uploads/images/delorean.jpg" alt="image of car">
    </div>
</div>

