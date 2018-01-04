

<?php
    session_start();
    if(isset($_SESSION["username"]) && isset($_SESSION["user_id"])){ // this means the user session is set
      header("Location: home.php");
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
      <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

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
            if(isset($_SESSION["session_error"])){
        ?>
        <h6 style="color:red;"><center><?php echo $_SESSION["session_error"]; ?></center></h6>
        <?php
            unset($_SESSION["session_error"]);
            }
        ?>
          <h4 style="width:100%;  text-align: center;"> Change password</h4>
            <div class="row">
             <br>
             <form action="apis/reset_pass.php" method="POST">
          <div class="row">
            <div class="input-field col s12">
            <i class="material-icons prefix">account_circle</i>
            <input type="password" name="password" value="" placeholder="New Password">
              <label for="password">New password</label>

            </div>
          </div>
          <br>
          <div class="row">
            <div class="input-field col s12">
            <i class="material-icons prefix">lock</i>
           <input type="password" name="password" value="" placeholder="confirm password">
              <label for="password">Confirm Password</label>
            </div>
          </div>
          <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>" placeholder="Enter Your email">
          <div class="g-recaptcha" data-sitekey="6LedJSAUAAAAAJMJpxPu7nn08ibHBMAbeA11NTsw"></div>
                 <br>
         <input type="submit"  value="reset password" class="waves-effect waves-light btn indigo darken-4 " style="width:100%" >
         <br><br>
        <a href="login.php" class="green-text" align="center">Remember your password?</a>
        </div>
        </div>
       </div>
     </div>
    </body>
</html>

