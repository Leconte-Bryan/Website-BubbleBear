<?php
include("init.php");
session_start();
session_unset(); // Supprime toutes les variables de session
session_destroy();

header("Location: index.php");

?>