<?php
session_start();
if(!isset($_POST["admin_loggedin"])){
    echo "Access Denied";
    exit();
}
?>