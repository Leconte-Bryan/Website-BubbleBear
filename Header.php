<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Styling/Header_Footer.css">
</head>

<body>
    <header>
        <!--<div class="container"> -->
        <!-- <nav class="NavMainMenu"> -->
        <img src="BubbleBearImg\Scaled_OURS.png" style="height:10vh;" alt="">

        <div class="NavMainMenu">
            <span><a href="index.php"> <button class="ButtonLoginMainMenu"> Main Page</button></a></span>

            <?php if (isset($_SESSION['username'])): ?>
                <a href="LogOut.php"> <button class="ButtonRegisterMainMenu"> Logout </button> </a>

            <?php else: ?>
                <span><a href="login.php"> <button class="ButtonLoginMainMenu"> Login </button> </a></span>
                <span><a href="register.php"> <button class="ButtonRegisterMainMenu"> Register </button> </a></span>

            <?php endif; ?>
        </div>
        <!-- </div> -->
        <!-- </nav> -->
    </header>
</body>

</html>