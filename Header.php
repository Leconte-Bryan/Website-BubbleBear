<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preload" as="image" href="BubbleBeartitle.png">
</head>

<body>
    <!-- Container -->
    <div class="HeaderMainMenu">

        <!-- nav base -->
        <!-- image container -->
        <div class="Logo-Header">
            <a href="index.php">
                <img class="MainTitle" src="BubbleBeartitle.png" alt=""></a>
            <img class="Logo-Img" src="OURS.png">

        </div>
        <a class="Play-Hyperlink" target="_blank" href="BuildBB/GamePage.php"> <img src="Start_ui.png" alt=""></a>
        <nav class="NavMainMenu">

            <ul>
                <?php if (isset($_SESSION['username'])): ?>
                    <li><a href="LogOut.php"> <button class="ButtonRegisterMainMenu"> Logout </button> </a></li>

                <?php else: ?>
                    <li><a href="login.php"> <button class="ButtonLoginMainMenu"> Login </button> </a></li>
                    <li><a href="register.php"> <button class="ButtonRegisterMainMenu"> Register </button> </a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</body>

</html>