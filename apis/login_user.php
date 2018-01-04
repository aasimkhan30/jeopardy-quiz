<?php
ob_start();
        session_start();

//ob_start();
if($_POST["email"] && $_POST["password"]){
	require "../include/db.php";
	$email=$_POST["email"];
	$password =$_POST["password"];
	if($email == "conductor" && $password == "conductor"){
        $_SESSION["user_id"] = "10";
        $_SESSION["username"] = "conductor";
        $_SESSION["emailid"] = "a@g.com";
        header("Location: ../home.php");
    }
    else{
        $_SESSION["session_error"] = "Wrong Email or Password";
        header("Location: ../login.php");
        exit();
    }
}
else{
	$_SESSION["session_error"] = "Wrong Email or Password";
	header("Location: ../login.php");
	exit();
}


/*$sql = "select * from users  where email = '".$email."'";
	$result = $conn->query($sql);
	if($result->num_rows > 0){
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
		if($row["verified"]== 0){
			session_start();
			$_SESSION["session_error"] = "Please Verify Your Email Id";
			header("Location: ../login.php");
			exit();
		}
		else{
			$hash = $row["password"];
			$checked = password_verify($_POST['password'],$hash);
			if ($checked) {
				session_start();
				$_SESSION["user_id"] = $row["id"];
				$_SESSION["username"] = $row["username"];
				$_SESSION["emailid"] = $row["email"];

                session_commit();
				header("Location: ../home.php");
				exit();
			}
			else {
				session_start();
				$_SESSION["session_error"] = "Wrong Email or Password";
				header("Location: ../login.php");
				exit();
			}
		}
	}
	else{
		session_start();
		$_SESSION["session_error"] = "Wrong Email or Password";
		header("Location: ../login.php");
		exit();
	}*/
?>

