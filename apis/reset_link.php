<?php
    include "../include/db.php";
    session_start();
    ob_start();
    if(!isset($_POST["email"])){
        $_SESSION["session_error"]="Email Id not found";
        header("Location: ../forgotpassword.php");
    }
    $email = $_POST["email"];
    $sql = " select * from users where email = '$email'";
    $result = $conn->query($sql);
    if($result->num_rows == 0){
        $_SESSION["session_error"]="Email Id not found";
        echo $_SESSION["session_error"];
        header("Location: ../forgotpassword.php");
    }

    $row = $result->fetch_assoc();
    $id = $row["id"];

    $sql = "delete from reset_password where user_id='$id'";
    $result = $conn->query($sql);

    $token = generateRandomString(100);
    $sql = "insert into reset_password (user_id,token) VALUES ($id,'$token')";
    $result = $conn->query($sql);
    $_SESSION["session_error"]="An email has been sent to your email id";
    //echo $_SESSION["session_error"];
    sendemail($email,$token);
    header("Location: ../login.php");





    function sendemail($email,$token){
		try{
		require "../include/db.php";
		require "../include/phpmailer/mail.php";
		require "../include/config.php";
		$mailsend = new Mail();
		//$bod = "To Verify Your Account Click <a href=''>".$URL."/verifyaccount?id=.".$id."</a>";
		//send email
		$to = $email;
		$subject = "Password Reset";
		$body = "<p>To reset your password, please click on this link: <a href='".$URL."/resetpassword.php?token=$token'>".$URL."/resetpassword.php?token=$token</a></p>
		<p>Regards Site Admin</p>";
		$mail = new Mail();
		$mail->setFrom(SITEEMAIL);
		$mail->addAddress($to);
		$mail->subject($subject);
		$mail->body($body);
		$mail->send();
		}
		catch(PDOException $e) {
		    $error[] = $e->getMessage();
			var_dump($e);
		}
	}


function generateRandomString($length = 10) {
		return uniqid();	
}
?>