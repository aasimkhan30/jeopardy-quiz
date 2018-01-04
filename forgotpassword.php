<!--
<html>
    <head>


        <title>Login Page</title>
    </head>
    <body >
        <h1>Reset Password</h1>
        <?php
if (isset($_SESSION["session_error"])) {
    ?>
        <h2><?php echo $_SESSION["session_error"]; ?></h2>
        <?php
    unset($_SESSION["session_error"]);
}
?>
        <form action="apis/reset_link.php" method="POST">
        <input type="email" name="email" value="" placeholder="Enter Your email">
        <input type="Submit"  value="Send Reset Link">
        </form>     
        <br>
        <a href="login.php">Remember Your Password ? Go Back</a>  
    </body>
</html> -->

<?php
session_start();
if (isset($_SESSION["username"]) && isset($_SESSION["user_id"])) { // this means the user session is set
    header("Location: home.php");
}
?>
<!DOCTYPE html>
<html>
<head>
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
        <a href="index.html" class="brand-logo" style="margin-left:10px;">Church</a>
    </div>
</nav>
<div class="row " style="margin-top:75px;margin-right:20px;">
    <div class="col s12  m8  offset-m2 l4  offset-l7">
        <div class="card-panel" style="max-height:700px;">
            <?php
            if (isset($_SESSION["session_error"])) {
                ?>
                <h4 style="color:red;"><?php echo $_SESSION["session_error"]; ?></h4>
                <?php
                unset($_SESSION["session_error"]);
            }
            ?>
            <h4 style="width:100%;  text-align: center;"> Reset your password</h4>


            <div class="row">
                <br>
                <form action="apis/reset_link.php" method="POST">
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="email" name="email" value="" placeholder="Enter Your Email" class="validate">
                            <label for="email">Email</label>

                        </div>
                    </div>
                    <br>


                    <input type="submit" value="send reset link" class="waves-effect waves-light btn indigo darken-4 "
                           style="width:100%">
                    <br><br>
                    <a href="login.php" align="center"><p align="center"> Remember your password?</p></a>
            </div>
        </div>
    </div>
</div>


</body>
</html>

