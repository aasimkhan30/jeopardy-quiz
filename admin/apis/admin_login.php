<?php
/**
 * Created by PhpStorm.
 * User: aasimkhan30
 * Date: 10/6/17
 * Time: 9:58 PM
 */
ob_start();
include "../include/db.php";
$reply = array();
session_start();
if(!isset($_POST["username"]) && !isset($_POST["password"])){
    $_SESSION["session_error"] = "Fields Empty";
    //header("Location: ../admin_home.php");
}
$username = $_POST["username"];
$password = $_POST["password"];
$sql = "select * from admin where username ='$username' and password = '$password'";
$result = $conn->query($sql);
if($result->num_rows == 0){
    $_SESSION["session_error"] = "Wrong username or password";
    header("Location: ../admin_login.php");
}
else{
    $_SESSION["admin_loggedin"]=1;
    header("Location: ../admin_home.php");
}
?>