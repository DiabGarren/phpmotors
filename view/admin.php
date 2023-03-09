<?php
if (!$_SESSION['loggedin']) {
    header('Location: /phpmotors/');
}
$welcome = "Welcome: " . $_SESSION['clientData']['clientFirstname'] . " " . $_SESSION['clientData']['clientLastname'];
$dataList = "<div id='user-info'><h2>Logged in as:</h2>
        <ul>
        <li>First name: " . $_SESSION['clientData']['clientFirstname'] . "</li>
        <li>Last name: " . $_SESSION['clientData']['clientLastname'] . "</li>
        <li>Email: " . $_SESSION['clientData']['clientEmail'] . "</li>
        <li><a id='update-acc' href='/phpmotors/accounts/?action=client-update'>Update Account</a></li>
        </ul></div>";
$vehicleLink = '<div id="vehicle-paragraph"><h2>Vehicle Inventory</h2>';
if ($_SESSION['clientData']['clientLevel'] > 1) {
    $vehicleLink .= "<p>The following link will take you to the vehicle management page. This page will allow you add a new vehicle classification or even add an additional vehicle to the database.<br>
    <a id='vehicle-link' href='/phpmotors/vehicles/'>Vehicle Management</a></p></div>";
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
    <main id="admin-view">
        <h1><?php echo $welcome; ?></h1>
        <?php if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
        } ?>
        <?php echo $dataList . $vehicleLink; ?>
    </main>
    <footer>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php' ?>
    </footer>
</body>

</html>
<?php unset($_SESSION['message']); ?>