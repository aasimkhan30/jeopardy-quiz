<?php
session_start();
unset($_SESSION["admin_loggedin"]);
header("Location: ../index.php");
exit();
?>