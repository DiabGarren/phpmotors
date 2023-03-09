<?php
if (!$_SESSION['loggedin'] || $_SESSION['clientData']['clientLevel'] < 2) {
    header('Location: /phpmotors/');
    exit;
}
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
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
    <title>PHP Motors</title>
</head>

<body>
    <header>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php' ?>
    </header>
    <nav>
        <?php echo $navList; ?>
    </nav>
    <main id="vehicle-management">
        <h1>Vehicle Management</h1>
        <a href="/phpmotors/vehicles/index.php?action=add-classification-view" id="add-class" class="button">Add classification</a>
        <a href="/phpmotors/vehicles/index.php?action=add-vehicle-view" id="add-vehicle" class="button">Add vehicle</a>

        <?php
        if (isset($classificationList)) {
            echo '<h2>Vehicles by Classification</h2>';
            if (isset($message)) {
                echo $message;
            }
            echo '<p>Choose a classification to see those vehicles.</p>';
            echo $classificationList;
        }
        ?>
        <noscript>
            <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
        </noscript>
        <table id="inventoryDisplay" cellspacing="0" cellpadding="8"></table>
    </main>
    <footer>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php' ?>
    </footer>
    <script src="../js/inventory.js"></script>
</body>

</html>
<?php unset($_SESSION['message']); ?>