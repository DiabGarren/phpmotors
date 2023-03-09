<img src="/phpmotors/images/site/logo.png" alt="PHPMotors Logo">
<div>
    <?php
    if (isset($_SESSION['clientData'])) {
        echo "<a href='/phpmotors/accounts/'>Welcome " . $_SESSION['clientData']['clientFirstname'] . "</a>" . 
        "<a href='/phpmotors/accounts/?action=logout'>Log out</a>";
        
    } else {
        echo "<a href='/phpmotors/accounts/?action=login-view' id='my-account'>My Account</a>";
    }
    // else if (isset($cookieFirstname)) {
    //     echo "<p>Welcome $cookieFirstname</p>";
    // }
    ?>
</div>