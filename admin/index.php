<?php
session_start();
if (isset($_SESSION["admin_loggedin"])) { // this means the user session is set
    header("Location:admin_home.php");
}
?>
<html>
<head>
    <title>Admin Login</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/uikit.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/uikit.js"></script>
<script type="text/javascript" src="js/uikit-icons.js"></script>
<div uk-sticky="media: 960" class="uk-navbar-container tm-navbar-container uk-sticky" style="">
    <div class="uk-container uk-container-expand">
        <nav class="uk-navbar-container " uk-navbar>
            <div class="uk-navbar-left">
                <a class="uk-navbar-item uk-logo" href="index.php">Church</a>
            </div>
        </nav>
    </div>
</div>
<div class="uk-container">
    <br>
    <h1>Admin Login</h1>

    <?php
    if (isset($_SESSION["session_error"])) {
        ?>
        <div class=" red center-align" style="padding: 5px"><span
                    class="white-text"><?php echo $_SESSION["session_error"]; ?></span></div>
        <?php
        unset($_SESSION["session_error"]);
    }
    ?>

    <form action="apis/admin_login.php" method="POST">
        <div class="uk-margin">
            <div class="uk-inline">
                <span class="uk-form-icon" uk-icon="icon: user"></span>
                <input type="text" name="username" class="uk-input uk-form-width-large" placeholder="Username">
            </div>
        </div>
        <div class="uk-margin">
            <div class="uk-inline">
                <span class="uk-form-icon" uk-icon="icon: lock"></span>
                <input type="password" name="password" class="uk-input uk-form-width-large" placeholder="Password">
            </div>
        </div>
        <div class="uk-margin">
            <input type="submit" value="LOGIN" class="uk-button uk-button-default uk-form-width-large">
        </div>
        <div class="uk-margin">
            <a href="../login.php" class="uk-button uk-button-default uk-form-width-large">Go to Conductor</a>
        </div>
    </form>
</div>
</body>
</html>