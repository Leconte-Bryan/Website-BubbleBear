<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preload" as="image" href="BubbleBeartitle.png">
</head>

<body>
        <header>
        <nav class="NavMainMenu">
            Le nom du site
            <ul>
                <?php if (isset($_SESSION['username'])): ?>
                    <li><a href="LogOut.php"> <button class="ButtonRegisterMainMenu"> Logout </button> </a></li>

                <?php else: ?>
                    <li><a href="login.php"> <button class="ButtonLoginMainMenu"> Login </button> </a></li>
                    <li><a href="register.php"> <button class="ButtonRegisterMainMenu"> Register </button> </a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
</body>

</html>