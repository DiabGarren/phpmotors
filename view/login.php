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
    <title>PHP Motors</title>
</head>

<body>
    <header>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php' ?>
    </header>
    <nav>
        <?php echo $navList; ?>
    </nav>
    <main>
        <h1>Log In</h1>
        <form method="post" action="/phpmotors/accounts/">
            <?php
            // if (isset($_SESSION['message'])) {
            //     echo $_SESSION['message'];
            // }
            if (isset($message)) {
                echo $message;
            }
            ?>
            <label for="clientEmail">Email address</label>
            <input type="email" name="clientEmail" id="clientEmail" <?php if (isset($clientEmail)) {
                                                                        echo "value='$clientEmail'";
                                                                    } ?> required>

            <div class="form-warning red">Password requirements:
                <ul>
                    <li>at least 8 characters</li>
                    <li>at least 1 uppercase character
                    <li>at least 1 number</li>
                    <li>at least 1 special character</li>
                </ul>
            </div>
            <label for="clientPassword">Password</label>
            <input type="password" name="clientPassword" id="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$">

            <input type="submit" id="login" class="form-button" name="login" value="Log In">

            <!-- Add the action name - value pair -->
            <input type="hidden" name="action" value="login">

            <div id="sign-up">
                <h2>No Account?</h2>
                <a href="/phpmotors/accounts/?action=register-view">Sign-up</a>
            </div>
        </form>
    </main>
    <footer>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php' ?>
    </footer>
</body>

</html>
<?php unset($_SESSION['message']) ?>