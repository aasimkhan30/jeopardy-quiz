<?php
    require "../include/db.php";
    $token = $_GET["act_id"];
    $sql = "select * from email_verify where token='$token'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $userid = $row["user_id"];
    $sql = "UPDATE users SET verified = 1 WHERE id=".$userid;
    $result = $conn->query($sql);
    session_start();    
    $_SESSION["session_error"] = "Verified Successfully Now log in";
    header("Location: ../login.php");
?>