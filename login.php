<?php
include("init.php");
include("Header.php");
//echo 'Nom de la session : ' . session_name();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--To Use css style-->
    <link rel="stylesheet" href="Styling/Style.css">
    <link rel="stylesheet" href="Styling/Header_Footer.css">
    <title>Login</title>
</head>

<body>
    <div style="display:grid; place-items: center;">
        <div id="general-login-box">
            <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
                <!--authentification-->

                <input type="text" name="username" id="login-text-box" placeholder="username0123"><br>
                <input type="password" name="password" id="login-text-box" placeholder="password"><br>
                <input type="email" name="email" id="login-text-box" placeholder="myemail@.com"><br>

                <input type="submit" name="login" value="log in" id="login-button">
                <a href="">
                    <h3 style="text-align: center;">Forgotten password ?</h3>
                </a>
                <hr />
            </form>
            <a href="register.php">
                <button onclick="" id="register-button">REGISTER</button>
            </a>
            <a href="index.php"> This goes to the main page Page</a>
        </div>
        <div id="error-box">
        </div>
    </div>
    <?php
    include("Footer.php");
    ?>
</body>


</html>

<?php

function displayError($errorMessage)
{
    echo '<script>
    const errorBox = document.getElementById("error-box");
    errorBox.style.visibility = "visible";
    errorBox.innerText = "' . $errorMessage . '";
    </script>';
}

//echo "{$_POST["username"]}  <br>";
//echo "{$_POST["password"]} <br>";

// problem with that is : can only submit the form with clicking on the submit button
//if (isset($_POST["login"])) {

// More reliable
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //Stop the user from using special character
    //Prevent people from using script or sql injection 
    //Keep the char who are not filtered
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password",  FILTER_SANITIZE_SPECIAL_CHARS);

    //If not an email return nothing
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);

    if (empty($username)) {
        displayError("username is missing");
        //echo "username is missing";
        exit(0);
    } else if (empty($password)) {
        displayError("password is missing");
        //echo "password is missing";
        exit(0);
    } else if (empty($email)) {
        displayError("email is missing");
        //echo "email is missing";
        exit(0);
    } else {
        try {
            // Template of the request
            $sql = "SELECT * FROM users WHERE username = ?";

            // Prepare this specific request
            $stmt = $conn->prepare($sql);
            // first argument : data type (s = string), second = the value
            $stmt->bind_param("s", $username);
            // Execute the query
            $stmt->execute();
            // Get the result
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            /*
            if ($email === $user["email"]) {
                echo "true";
            } else {
                echo "false";
            }
            */
            if (isset($user) && password_verify($password, $user["password_hash"]) &&  mb_strtolower($email) === $user["email"]) {
                //echo "user $username is now logged" . "<br>";
                // Lors de la connection récupère l'user id de l'utilisateur et l'attribue à la session
                // la session = sessionID
                $_SESSION["user_id"] = $user["user_id"];

                // Attribute to the session the value;
                $_SESSION["username"] = $username;
                // debugging tools
                $_SESSION["password"] = $password;
                $_SESSION["email"] = $email;
                header("Location: index.php");
            } else {
                displayError("username or password or email is invalid");
                //echo "username or password or email is invalid" . "<br>";
                exit;
            }
        } catch (mysqli_sql_exception $e) {
            echo "" . $e->getMessage() . "<br>";
            echo "" . $e->getCode() . "" . "<br>";
            echo "failed register attempt";
        }
    }

    // debug log
    /*
    if (isset($_SESSION["user_id"])) {
        echo "the user of the sessions is : " . $_SESSION["username"] . "<br>";
        echo "the user of the sessions is : " . $_SESSION["password"] . "<br>";
        echo "the user id is " . $_SESSION["user_id"] . "<br>";
        echo "" . $_SESSION["email"];
    } else {
        echo "no username in this session has been found" . "<br>";
    }
    */

    // Close statement and bdd connexion
    $stmt->close();
    mysqli_close($conn);
}

?>