<?php
session_start();
if (isset($_SESSION["admin_loggedin"])) { // this means the user session is set
    header("Location:admin_home.php");
}
?>
<html>
<head>
    <title>Admin Login</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.min.js"></script>

</head>
<body class="indigo ">

<div class="row " style="margin-top:75px">
    <div class="col s12  m8 offset-m2  l4  offset-l7">
        <div class="card-panel center-align">

            <h4 style="width:100%;  text-align: center;"> Login</h4>

            <?php
            if (isset($_SESSION["session_error"])) {
                ?>
                <div class=" red center-align" style="padding: 5px"><span
                            class="white-text"><?php echo $_SESSION["session_error"]; ?></span></div>
                <?php
                unset($_SESSION["session_error"]);
            }
            ?>
            <div class="row">
                <br>
                <form action="apis/admin_login.php" method="POST">
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">account_circle</i>
                            <input type="text" name="username" value="" placeholder="Enter Your Email" class="validate">
                            <label for="email">Username</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <i class="material-icons prefix">lock</i>
                            <input type="password" name="password" value="" placeholder="Enter Your Password">
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <button type="submit" class="waves-effect waves-light btn indigo"> Login</button>
            </div>
        </div>
    </div>
</div>
