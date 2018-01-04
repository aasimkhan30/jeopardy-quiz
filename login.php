<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["user_id"])) { // this means the user session is set
    header("Location: home.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <!-- CSS  -->
    <link href="css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/uikit.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

</head>

<body>

<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/uikit.min.js"></script>
<script type="text/javascript" src="js/uikit-icons.min.js"></script>
<div uk-sticky="media: 960" class="uk-navbar-container tm-navbar-container uk-sticky" style="">
    <div class="uk-container uk-container-expand">
        <nav class="uk-navbar-container " uk-navbar>
            <div class="uk-navbar-left">
                <a class="uk-navbar-item uk-logo" href="index.php">Church</a>
            </div>
        </nav>
    </div>
</div>

<?php
if (isset($_SESSION["session_error"])) {
    ?>
    <div class="uk-alert" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p><?php echo $_SESSION["session_error"]; ?></p>


        </h6>
    </div>
    <?php
    unset($_SESSION["session_error"]);
}
?>
<br>
<div class="uk-container">
    <h1>Quiz Conductor Login</h1>
    <form action="apis/login_user.php" method="POST">
        <div class="uk-margin">
            <div class="uk-inline">
                <span class="uk-form-icon" uk-icon="icon: user"></span>
                <input type="text" name="email" class="uk-input uk-form-width-large"
                       placeholder="Enter Your Username" class="validate">
            </div>
        </div>
        <div class="uk-margin">
            <div class="uk-inline">
                <span class="uk-form-icon" uk-icon="icon: lock"></span>
                <input type="password" name="password" class="uk-input uk-form-width-large"
                       placeholder="Enter Your Password">
            </div>
        </div>
        <div class="uk-margin">
            <input type="submit" value="login" class="uk-button uk-button-default uk-form-width-large">
        </div>
        <div class="uk-margin">
            <a href="admin/index.php" class="uk-button uk-button-default uk-form-width-large">Go to Admin</a>
        </div>
    </form>
</div>
<!-- <a class="waves-effect waves-light btn indigo darken-4 "
    href="signup.php">Register</a>-->

</body>
</html>

