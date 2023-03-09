<?php
if (!$_SESSION['loggedin']) {
    header('Location: /phpmotors/');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/phpmotors/css/main.css">
    <style media="screen"></style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">
    <title>Update account | PHP Motors</title>
</head>

<body>
    <header>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php' ?>
    </header>
    <nav>
        <?php echo $navList; ?>
    </nav>
    <main>
        <h1>Update Account</h1>
        <form method="post" action="/phpmotors/accounts/">
            <?php
            if (isset($updateMessage)) {
                echo $updateMessage;
            }
            ?>

            <label for="clientFirstname">First Name</label>
            <input type="text" name="clientFirstname" id="clientFirstname" required <?php
                                                                                    echo 'value="' . $_SESSION['clientData']['clientFirstname'] . '"';
                                                                                    ?>>

            <label for="clientLastname">Last Name</label>
            <input type="text" name="clientLastname" id="clientLastname" required <?php
                                                                                    echo 'value="' . $_SESSION['clientData']['clientLastname'] . '"';
                                                                                    ?>>

            <label for="clientEmail">Email</label>
            <input type="email" name="clientEmail" id="clientEmail" required <?php
                                                                                echo 'value="' . $_SESSION['clientData']['clientEmail'] . '"';
                                                                                ?>>

            <input type="submit" name="submit" class="form-button" id="update-account" value="Update Account">

            <!-- Add the action name - value pair -->
            <input type="hidden" name="action" value="update-account">
            <input type="hidden" name="clientId" value="
            <?php
            if (isset($_SESSION['clientData']['clientId'])) {
                echo $_SESSION['clientData']['clientId'];
            }
            ?>
            ">
        </form>

        <h1>Change Password</h1>
        <form method="post" action="/phpmotors/accounts/">
            <?php
            if (isset($passMessage)) {
                echo $passMessage;
            }
            ?>
            <p class="form-warning red"><b>This will change your Current Password.</b></p>
            <div class="form-warning red">Password requirements:
                <ul>
                    <li>at least 8 characters</li>
                    <li>at least 1 uppercase character
                    <li>at least 1 number</li>
                    <li>at least 1 special character</li>
                </ul>
            </div>
            <label for="clientPassword">New Password</label>
            <input type="password" name="clientPassword" id="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">

            <input type="submit" name="submit" class="form-button" id="update-password" value="Update Password">

            <!-- Add the action name - value pair -->
            <input type="hidden" name="action" value="update-password">
            <input type="hidden" name="clientId" value="
            <?php
            if (isset($_SESSION['clientData']['clientId'])) {
                echo $_SESSION['clientData']['clientId'];
            }
            ?>
            ">
        </form>
    </main>
    <footer>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php' ?>
    </footer>
</body>

</html>