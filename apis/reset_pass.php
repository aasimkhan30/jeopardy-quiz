<?php
 session_start();


 if(!isset($_POST["password"]) && !isset($_POST["token"])){
     $_SESSION["session_error"] = "Missing Token or Fields";
     header("Location: ../login.php");
 }
 
 if(!verifycap){
     $_SESSION["session_error"] = "Failed Human Verification";
     header("Location: ../resetpassword.php?token=$token");
 }
 $token = $_POST["token"];
 $password = $_POST["password"];

 if(!verifytoken($token)){
    $_SESSION["session_error"] = "Bad Token,Check Your Email for the correct link again";
     header("Location: ../login.php");
 }

 include "../include/db.php";
// echo $token;
 $sql = "select * from reset_password where token = '$token'";
 //echo $sql;
 $result =  $conn->query($sql);
 $row = $result->fetch_assoc();
 $id = $row["user_id"];
 $password = password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 12]);
 $sql = "update users set password = '$password' where id = $id";
 $result=$conn->query($sql);
 $sql = "delete from reset_password where token = '$token'";
 $result=$conn->query($sql);
 $_SESSION["session_error"] = "Password Resetted Successfully, Login With Your New Password";
 header("Location: ../login.php");


 

 function verifytoken($token){
     include "../include/db.php";

     $sql = "select * from reset_password where token = '$token'";
     $result =  $conn->query($sql);

     if($result->num_rows == 1)
        return true;
     else
       return false;


 }

 function verifycap (){

		$url = 'https://www.google.com/recaptcha/api/siteverify';
		$data = array(
		'secret' => '6LedJSAUAAAAAPTuso3JVwKV2qKWiYPGnpQItwLz',
		'response' => $_POST["g-recaptcha-response"]
		);
		$options = array(
		'http' => array (
			'method' => 'POST',
			'content' => http_build_query($data)
		)
		);
		$context  = stream_context_create($options);
		$verify = file_get_contents($url, false, $context);
		$captcha_success=json_decode($verify);
		return $captcha_success->success;
		
	}
?>