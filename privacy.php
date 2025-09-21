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
        <div style="font-size: 1.1rem; line-height: 1.5; color: white; text-align: center; margin: 0;">

            <h1>Privacy Policy</h1>

            <h2>1. Introduction</h2>
            <p>We value your privacy and are committed to protecting your personal information. This Privacy Policy explains how we handle your data when you use our website and related services.</p>

            <h2>2. Data We Collect</h2>
            <p><strong>Account Information:</strong> When you register, we collect your chosen username, email address, and password.</p>
            <p><strong>Game Data:</strong> Information related to your activity in the game (such as progress, scores, or achievements) is stored in our database.</p>
            <p><strong>Cookies:</strong> We only use essential session cookies to keep you logged in while navigating our site.</p>

            <h2>3. How We Protect Your Data</h2>
            <p>Passwords are never stored in plain text. We use <strong>hashing techniques</strong> to protect them before storing them in the database.</p>
            <p>Session cookies are temporary and are deleted automatically when you log out or close your browser.</p>
            <p>We apply standard security measures to protect your account and game data from unauthorized access.</p>

            <h2>4. How We Use Your Data</h2>
            <p>We use your information to:</p>
            <ul>
                <li>Authenticate and manage your account (login, registration, session management).</li>
                <li>Save and maintain your game progress and related information.</li>
                <li>Ensure the proper functioning and security of our services.</li>
            </ul>

            <h2>5. Data Sharing</h2>
            <p>We do <strong>not</strong> sell, rent, or share your personal information with third parties, except where required by law.</p>

            <h2>6. Data Retention</h2>
            <p>Account information remains in our database until you request its deletion.</p>
            <p>Session cookies expire automatically when you log out or close your browser.</p>
            <p>Game data is stored as long as your account remains active.</p>

            <h2>7. Your Rights</h2>
            <p>Depending on your jurisdiction, you may have the right to access, modify, or request deletion of your personal data. To exercise these rights, please contact us at <strong>bubblebearwebsite@gmail.com</strong>.</p>

            <h2>8. Changes to this Policy</h2>
            <p>We may update this Privacy Policy from time to time. Updates will be published on this page, with the date of the last revision indicated.</p>
        </div>
    </div>
    <?php
    include("Footer.php");
    ?>
</body>

</html>