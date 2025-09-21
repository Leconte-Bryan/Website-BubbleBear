<?php
include("init.php");
include("Header.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="Styling/Header_Footer.css">

    <link rel="stylesheet" href="Styling/GameData.css">
    <title>Document</title>
</head>
<body style="min-height: 100vh; display: grid; place-items: center; margin: 0;">

    <div style="max-width: 600px; width: 90%; padding: 1.5rem; border: solid 1px; border-radius: 10px; background-color: rgb(116, 57, 118); box-sizing: border-box;">
        <p style="font-size: 1.1rem; line-height: 1.5; color: white; text-align: center; margin: 0;">
            <strong>Session Cookies</strong><br><br>
            We use essential session cookies to maintain the functionality and security of our website. 
            These cookies are created automatically when you log in and are required to keep your session active, 
            allowing you to navigate between pages without needing to re-enter your credentials. 
            Session cookies do not store personal information beyond what is necessary to identify your active session, 
            and they are automatically deleted once you log out or close your browser. 
            Because these cookies are strictly necessary for the operation of our services, they do not require your consent.
        </p>
    </div>
<?php
include("Footer.php");
?>
</body>

</html>