
<div id="top-header">
    <img id="logo" src="/phpmotors/images/site/logo.png" alt="Motors Logo">
    <?php 
        if (!isset($_SESSION['clientData'])) {
            echo '<a class="account" href="/phpmotors/accounts?action=login-page" title="login php Motors">My Account</a>';
        } else {
            $firstName = $_SESSION['clientData']['clientFirstname'];
            echo "<a class='account' href='/phpmotors/accounts/index.php?action=Logout' title='Click to logout'>Log out</a>";
            echo "<a id='welcomeUser' href='/phpmotors/accounts/index.php'><span>Welcome $firstName</span></a>";
        }
    ?>
</div>
