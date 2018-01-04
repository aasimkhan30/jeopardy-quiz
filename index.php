<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["user_id"])) { // this means the user session is set
    header("Location: home.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title></title>

    <!-- CSS  -->
    <link href="css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/uikit.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>
<body>
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
        <h1>Jeopardy Quiz</h1>
        <h2>Play this challenging quiz to see how many questions you can answer in
            the race against time.</h2>
        <a href="login.php" id="download-button" class="uk-button uk-button-default uk-width-1-1">LOGIN</a>
</div>
        <!--  Scripts-->
        <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src="js/materialize.js"></script>
        <script src="js/init.js"></script>

</body>
</html>
