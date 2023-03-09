<?php
if (!$_SESSION['loggedin'] || $_SESSION['clientData']['clientLevel'] == 1) {
    header('Location: /phpmotors/');
}
$classificationList = "<label for='classificationId'>Choose a car:</label>";
$classificationList .= "<select id='classificationId' name='classificationId'>";
$classificationList .= "<option value='0'>Select</option>";
foreach ($classifications as $classification) {
    $classificationList .= "<option value='$classification[classificationId]'";
    if (isset($classificationId)) {
        if ($classification['classificationId'] == $classificationId) {
            $classificationList .= ' selected ';
        }
    }

    $classificationList .= ">$classification[classificationName]</option>";
}
$classificationList .= '</select>';

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
    <main>
        <h1>Add Vehicle</h1>
        <form method="post" action="/phpmotors/vehicles/">
            <?php
            if (isset($message)) {
                echo $message;
            }
            ?>

            <?php
            echo $classificationList;
            ?>

            <label for="invMake">Make</label>
            <input type="text" name="invMake" id="invMake" <?php if (isset($invMake)) {
                                                                echo "value='$invMake'";
                                                            } ?> required>

            <label for="invModel">Model</label>
            <input type="text" name="invModel" id="invModel" <?php if (isset($invModel)) {
                                                                    echo "value='$invModel'";
                                                                } ?> required>

            <label for="invDescription">Description</label>
            <textarea name="invDescription" id="invDescription" required><?php if (isset($invDescription)) {
                                                                                echo "$invDescription";
                                                                            } ?></textarea>

            <!-- <label for="invImage">
                Image
                <input type="text" name="invImage" id="invImage">
            </label> -->
            <input type="hidden" name="invImage" value="/images/no-image.png">

            <!-- <label for="invThumbnail">
                Thumbnail
                <input type="text" name="invThumbnail" id="invThumbnail">
            </label> -->
            <input type="hidden" name="invThumbnail" value="/images/no-image.png">

            <label for="invPrice">Price</label>
            <input type="number" name="invPrice" id="invPrice" <?php if (isset($invPrice)) {
                                                                    echo "value='$invPrice'";
                                                                } ?> required>

            <label for="invStock">Stock</label>
            <input type="number" name="invStock" id="invStock" <?php if (isset($invStock)) {
                                                                    echo "value='$invStock'";
                                                                } ?> required>

            <label for="invColor">Color</label>
            <input type="text" name="invColor" id="invColor" <?php if (isset($invColor)) {
                                                                    echo "value='$invColor'";
                                                                } ?> required>

            <input type="submit" name="submit" class="form-button" id="add-vehicle" value="Add Vehicle">

            <!-- Add the action name - value pair -->
            <input type="hidden" name="action" value="add-vehicle">
        </form>
    </main>
    <footer>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php' ?>
    </footer>
</body>

</html>