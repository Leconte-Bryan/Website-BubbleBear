<?php
include("init.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="Style.css">
	<title>Document</title>
</head>

<body>

	<div id="general-login-box">
		<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">

			<input type="text" name="username" id="login-text-box" placeholder="username0123"><br>
			<input type="password" name="password" id="login-text-box" placeholder="password"><br>
			<input type="password" name="password_check" id="login-text-box" placeholder="confirm password"><br>
			<input type="email" name="email" id="login-text-box" placeholder="myemail@.com"><br>
			<input type="submit" name="register" value="register" id="register-button-2">

		</form>

		<!--
		<label>username:</label><br>
		<input type="text" name="username"><br>
		<label>password</label><br>
		<input type="password" name="password"><br>
		<label>email</label><br>
		<input type="password_check" name="password_check"><br>
		<label>email</label><br>
		<input type="email" name="email"><br>
		<input type="submit" name="register" value="register">

	</form>
		-->

		<a href="login.php"> This goes to the login page</a>
	</div>
</body>

</html>

<?php


/*
if (isset($_SESSION["username"])) {
	Debug
	echo "the user of the sessions is : " . $_SESSION["username"];
} else {
	echo "no username in this session has been found" . "<br>";
}
*/
//echo "{$_POST["username"]}  <br>";
//echo "{$_POST["password"]} <br>";

// problem with that is : can submit the form with clicking on the submit button
//if (isset($_POST["register"])) {

// More reliable
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//Stop the user from using special character
	//Prevent people from using script or sql injection 
	//Keep the char who are not filtered
	$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
	$password = filter_input(INPUT_POST, "password",  FILTER_SANITIZE_SPECIAL_CHARS);
	$password_check = filter_input(INPUT_POST, "password_check", FILTER_SANITIZE_SPECIAL_CHARS);
	//If not an email return nothing
	$email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);

	// Check if field empty
	if (empty($username)) {
		echo "username is missing";
		       exit(0);
	} else if (empty($password)) {
		echo "password is missing";
		       exit(0);
	} else if ($password != $password_check) {
		echo "not the same password !";
		       exit(0);
	} else if (empty($email)) {
		echo "That email is invalid";
		       exit(0);
	} else {


		$hash = password_hash($password, PASSWORD_DEFAULT);
		$hash_mail = password_hash($email, PASSWORD_DEFAULT);
		// Old and not safe insertion method (no preparation, vulnerable to sql injection)
		/*$sql = "INSERT INTO users (username, password_hash, email) 
				VALUES('$username', '$hash', '$email')";*/
		try {

			
			// Template of the request
			$sql = "INSERT INTO users (username, password_hash, email) 
				VALUES(?, ?, ?)";
			// Prepare this specific request
			$stmt = $conn->prepare($sql);
			// first argument : data type (s = string), second = the value
			$stmt->bind_param("sss", $username, $hash, $hash_mail);
			// Execute the query
			$stmt->execute();
		} 
		catch (mysqli_sql_exception $e)
		{
			// Constraint unique baffouée
			if($e->getCode() == 1062){
				//stripos argument : String to search in, then the string we search
				// The exception contain the field username or email, so we check inside the exception
				if(stripos($e->getMessage(), "username")){
				echo "This username is already taken" ."<br>";
				}
				if(stripos($e->getMessage(), "email")){
				echo "This email is already taken" ."<br>";
				}
			}
			// Constraint chk_username_lenght
			if($e->getCode() == 4025){
				echo "username must be between 7 and 15 characters" ."<br>";
			}
			
			//Display the error
			 echo "". $e->getMessage() ."" ."<br>";
			 echo "". $e->getCode() ."" ."<br>";
			 echo "failed register attempt" ."<br>";
			 exit(0);
		}
		// Debug purpose
		echo "hello {$username} <br>";
		echo "your password is: {$password} <br>";
		echo "your email is: {$email} <br>";

		// Attribute to the session the value;
		$_SESSION["username"] = $username;
		// debug
		/*
		$_SESSION["password"] = $password;
		$_SESSION["email"] = $email;
		*/

	}
	// Close statement and bdd connexion
	$stmt->close();
	mysqli_close($conn);
	// Then, redirect to main page
	header("location: index.php");
	exit(0);
}

?>