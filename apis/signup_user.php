<?php
ob_start();
$flag = 0;
session_start();
if (!isset($_POST["username"])) {
    $_SESSION["session_error"] = "Username not filled";
    $flag == 1;
} else {
    $_SESSION["signup_username"] = $_POST["username"];
}
if (!isset($_POST["password"])) {
    $_SESSION["session_error"] = "Password not filled";
    $flag == 1;
}
if (!isset($_POST["email"])) {
    $_SESSION["session_error"] = "Email not filled";
    $flag == 1;
} else {
    $_SESSION["signup_email"] = $_POST["email"];
}
if (!isset($_POST["verify_password"])) {
    $_SESSION["session_error"] = "Please confirm password";
    $flag == 1;
}
if ($flag == 1) {
    header("Location: ../signup.php");
    exit();
}

if (!verifycap()) {
    $_SESSION["session_error"] = "Please complete Human Verification";
    header("Location: ../signup.php");
    exit();
}


if (!finduser($_POST["username"])) {
    $_SESSION["session_error"] = "Username taken try some other username";
    header("Location: ../signup.php");
    exit();
}

if (!findemail($_POST["email"])) {
    $_SESSION["session_error"] = "Email used, Do you already have an account?";
    header("Location: ../signup.php");
    exit();
}

if($_POST["verify_password"] != $_POST["password"]){
    $_SESSION["session_error"] = "Confirm password should match the original password";
    header("Location: ../signup.php");
    exit();
}

require "../include/db.php";
$username = $_POST["username"];
$password = $_POST["password"];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 12]);
$email = $_POST["email"];
$sql = "INSERT INTO users (username,password,email,verified) VALUES ('" . $username . "' , '" . $password . "' , '" . $email . "',1)";
$result = $conn->query($sql);
sendemail($email);
session_start();
$_SESSION["session_error"] = "Successfully registered check your email for account verificiation";
header("Location: ../login.php");
exit();
function finduser($user)
{
    require "../include/db.php";
    $sql = "SELECT username from users where username = '" . $user . "'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return false;
    }

    return true;
}

function findemail($email)
{
    require "../include/db.php";
    $sql = "SELECT username from users where email = '" . $email . "'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        return false;
    }

    return true;

}

function sendemail($email)
{
    try {
        require "../include/db.php";
        require "../include/phpmailer/mail.php";
        require "../include/config.php";
        $mailsend = new Mail();
        $sql = "SELECT * from users where email = '" . $email . "'";
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
		<p>To activate your account, please click on this link: <a href='" . $URL . "/apis/activate_user.php?act_id=$token'>" . $URL . "/apis/activate_user.php?act_id=$token</a></p>
		<p>Regards Site Admin</p>";
        $mail = new Mail();
        $mail->setFrom(SITEEMAIL);
        $mail->addAddress($to);
        $mail->subject($subject);
        $mail->body($body);
        $mail->send();
        $sql = "INSERT INTO email_verify (user_id,token) VALUE (" . $row['id'] . ",'$token')";
        echo $sql;
        //exit();
        $result = $conn->query($sql);
    } catch (PDOException $e) {
        $error[] = $e->getMessage();
        var_dump($e);
    }
}

function verifycap()
{

    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => '6LedJSAUAAAAAPTuso3JVwKV2qKWiYPGnpQItwLz',
        'response' => $_POST["g-recaptcha-response"]
    );
    $options = array(
        'http' => array(
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captcha_success = json_decode($verify);
    return $captcha_success->success;

}

function generateRandomString($length = 10)
{
    return uniqid();
}

?>