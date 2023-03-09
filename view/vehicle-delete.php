<?php
if (!$_SESSION['loggedin'] || $_SESSION['clientData']['clientLevel'] == 1) {
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
    <title>
        <?php
        if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
            echo "Delete $invInfo[invMake] $invInfo[invModel]";
        }
        ?> | PHP Motors
    </title>
</head>

<body>
    <header>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php' ?>
    </header>
    <nav>
        <?php echo $navList; ?>
    </nav>
    <main>
        <h1>
            <?php
            if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
                echo "Delete $invInfo[invMake] $invInfo[invModel]";
            }
            ?>
        </h1>
        <form method="post" action="/phpmotors/vehicles/">
            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>
            <p class="form-warning red">Confirm Vehicle Deletion. The delete is permanent.<p>
            <label for="invMake">Make</label>
            <input type="text" name="invMake" id="invMake" readonly <?php
                                                            if (isset($invInfo['invMake'])) {
                                                                echo "value='$invInfo[invMake]'";
                                                            }
                                                            ?>>

            <label for="invModel">Model</label>
            <input type="text" name="invModel" id="invModel" readonly <?php
                                                                if (isset($invInfo['invModel'])) {
                                                                    echo "value='$invInfo[invModel]'";
                                                                }
                                                                ?>>

            <label for="invDescription">Description</label>
            <textarea name="invDescription" id="invDescription"readonly><?php
                                                                            if (isset($invInfo['invDescription'])) {
                                                                                echo "$invInfo[invDescription]";
                                                                            }
                                                                            ?></textarea>

            <input type="submit" name="submit" class="form-button" id="delete-vehicle" value="Delete Vehicle">

            <!-- Add the action name - value pair -->
            <input type="hidden" name="action" value="delete-vehicle">
            <input type="hidden" name="invId" value="
            <?php
            if (isset($invInfo['invId'])) {
                echo $invInfo['invId'];
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