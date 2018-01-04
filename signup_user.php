<?php
	ob_start();
	if($_POST["username"] && $_POST["password"] && $_POST["email"] ){

		if(verifycap()){
			
			require "../include/db.php";

			if(finduser($_POST["username"])){
				if(findemail($_POST["email"])){
					$username = $_POST["username"];
					$password = $_POST["password"];
					$password = password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 12]);
					$email = $_POST["email"];
					$sql = "INSERT INTO users (username,password,email,verified) VALUES ('".$username."' , '".$password."' , '".$email."',1)";
					$result = $conn->query($sql);
					sendemail($email);
					session_start();
					$_SESSION["session_error"] = "Successfully registered check your email for account verificiation";
					header("Location: ../login.php");
					exit();
				}
				else{
					session_start();
					$_SESSION["session_error"] = "Email taken";
					header("Location: ../signup.php");
					exit();
				}
			}
			else{
				session_start();
				$_SESSION["session_error"] = "Username taken";
				header("Location: ../signup.php");
				exit();
			}
		}else{
			session_start();
			$_SESSION["session_error"] = "Failed Human Verification";
			header("Location: ../signup.php");
			exit();
		}
		
	}
	else{
		session_start();
		$_SESSION["session_error"] = "Validation not done";
		header("Location: ../signup.php");
		exit();
	}

	function finduser($user){
			require "../include/db.php";
		$sql = "SELECT username from users where username = '".$user."'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			return false;
		}

		return true;
	}

	function findemail($email){
			require "../include/db.php";
		$sql = "SELECT username from users where email = '".$email."'";
		$result = $conn->query($sql);
		if($result->num_rows > 0){
			return false;
		}

		return true;

	}

	function sendemail($email){
		try{
		require "../include/db.php";
		require "../include/phpmailer/mail.php";
		require "../include/config.php";
		$mailsend = new Mail();
		$sql = "SELECT * from users where email = '".$email."'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$id = $row["id"];
		$token = generateRandomString(24);
		$result->close();
		//$bod = "To Verify Your Account Click <a href=''>".$URL."/verifyaccount?id=.".$id."</a>";
		//send email
		$to = $email;
		$subject = "Registration Confirmation";
		$body = "<p>Thank you for registering at demo site.</p>
		<p>To activate your account, please click on this link: <a href='".$URL."/apis/activate_user.php?act_id=$token'>".$URL."/apis/activate_user.php?act_id=$token</a></p>
		<p>Regards Site Admin</p>";
		$mail = new Mail();
		$mail->setFrom(SITEEMAIL);
		$mail->addAddress($to);
		$mail->subject($subject);
		$mail->body($body);
		$mail->send();
		$sql = "INSERT INTO email_verify (user_id,token) VALUE (".$row['id'].",'$token')";
		echo $sql;
		//exit();
	    $result = $conn->query($sql);
		}
		catch(PDOException $e) {
		    $error[] = $e->getMessage();
			var_dump($e);
		}
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
	function generateRandomString($length = 10) {
		return uniqid();	
}

?>