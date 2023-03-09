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
    <main class="grid">
        <h1>Welcome to PHP Motors!</h1>
        <div id="overview">
            <div id="details">
                <h2>DMC Delorean</h2>
                <p>3 Cup holders<br>
                    Superman doors<br>
                    Fuzzy dice!</p>
            </div>
            <a href="#">Own Today</a>
        </div>
        <div id="upgrades">
            <h3>Delorean Upgrades</h3>
            <div id="upgrades-grid">
                <div id="flux-cap-img">
                    <img src="./images/upgrades/flux-cap.png" alt="Flux Capacitor">
                </div>
                <a id="flux-cap" href="#">Flux Capacitor</a>
                <div id="flame-img">
                    <img src="./images/upgrades/flame.jpg" alt="Flame Decal">
                </div>
                <a id="flame" href="#">Flame Decals</a>
                <div id="sticker-img">
                    <img src="./images/upgrades/bumper_sticker.jpg" alt="Bumper Stickers">
                </div>
                <a id="sticker" href="#">Bumper Stickers</a>
                <div id="hub-cap-img">
                    <img src="./images/upgrades/hub-cap.jpg" alt="Hub Caps">
                </div>
                <a id="hub-cap" href="#">Hub Caps</a>
            </div>
        </div>
        <div id="reviews">
            <h3>DMC Delorean Reviews</h3>
            <ul>
                <li>"So fast its almost like traveling in time." (4/5)</li>
                <li>"Coolest reid on the road." (4/5)</li>
                <li>"I'm felling Marty McFly!" (5/5)</li>
                <li>"The most futureistic ride of our day." (4.5/5)</li>
                <li>"80's livin and I love it!" (5/5)</li>
            </ul>
        </div>
    </main>
    <footer>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php' ?>
    </footer>
</body>

</html>