<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["user_id"])) { // this means the user session is set
    header("Location: home.php");
}
if (isset($_SESSION["signup_username"])) {
    $username = $_SESSION["signup_username"];
    unset($_SESSION["signup_username"]);
} else {
    $username = "";
}
if (isset($_SESSION["signup_email"])) {
    $email = $_SESSION["signup_email"];
    unset($_SESSION["signup_email"]);
} else {
    $email = "";
}
?>
<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" href="css/bootstrap.min.css" crossorigin="anonymous">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body background="img/back2.jpg">


<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>


<nav class="indigo">
    <div class="nav-wrapper">
        <a href="index.php" class="brand-logo" style="margin-left:10px;">Church</a>
    </div>
</nav>

<div class="container">
    <div class="row " style="margin-top:30px">
        <div class="col s12  m8  offset-m2 l5  offset-l7">
            <div class="card-panel center-align">
                <h4 style="width:100%;  text-align: center;"> Register</h4>
                <?php
                if (isset($_SESSION["session_error"])) {
                    ?>
                    <div class=" red center-align" style="padding: 5px"><span
                                class="white-text"><?php echo $_SESSION["session_error"]; ?></span></div>
                    <?php
                    unset($_SESSION["session_error"]);
                }
                ?>
                <form action="apis/signup_user.php" method="POST">
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" name="username" value="<?php echo $username; ?>"
                                   placeholder="Enter Your Username" required>
                            <label for="email">Username</label>


                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="email" name="email" value="<?php echo $email; ?>"
                                   placeholder="Enter Your Email"
                                   class="validate" input pattern=".{8,}" required title="8 characters minimum"
                                   required>
                            <label for="email">Email</label>

                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">lock</i>
                            <input type="password" name="password" value="" placeholder="Enter Your Password"
                                   class="validate" input pattern=".{8,}" required title="8 characters minimum"
                                   required>
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">lock</i>
                            <input type="password" name="verify_password" value=""
                                   placeholder="Verify Your Password" class="validate" required>
                            <label for="password">Retype Password</label>
                        </div>
                    </div>
                    <div class="g-recaptcha" style="margin-top:10px;width:100%"
                         data-sitekey="6LedJSAUAAAAAJMJpxPu7nn08ibHBMAbeA11NTsw"></div>
                    <br>
                    <input type="submit" class="waves-effect waves-light btn indigo  " value="Register">

                    <a class="waves-effect waves-light btn indigo" href="login.php" style="margin-top: 10px;">Already a
                        member? Login</a>
                </form>
            </div>
        </div>
    </div>
</div>


</body>
</html>
