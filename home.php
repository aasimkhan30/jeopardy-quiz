<?php
session_start();
if (!isset($_SESSION["username"]) || !isset($_SESSION["user_id"]) || !isset($_SESSION["emailid"])) { // this means the user session is set
    header("Location: login.php");
}
$username = $_SESSION["username"];
$id = $_SESSION["user_id"];
$email = $_SESSION["emailid"];
//echo "Current userid = $id and username = $username and email = $email";
?>
<!DOCTYPE html>
<html>
<head>
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
            <div class="uk-navbar-right">
                <a href="apis/logout.php" class=" uk-button uk-button-default navbar-button">Logout</a>
            </div>
        </nav>
    </div>
</div>
<?php
require "include/db.php";
$current_date = date("Y-m-d");   // current date
?>
<br>

<div class="uk-container">
    <h1> Active Quiz</h1>
    <table class="uk-table uk-table-middle uk-table-divider uk-table-small">
        <thead>
        <tr>

            <th class>Title</th>
            <th class="uk-table-shrink">Continue</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql_current_quiz = "select * from quiz where ongoing_flag  =  1";
        $result = $conn->query($sql_current_quiz);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr><td>' . $row["title"] . "</td><td><a href='quiz.php?id=" . $row["id"] . "'class='uk-button uk-button-default uk-width-medium'>Continue</a></td></tr>";

            }
        }
        ?>


        </tbody>
    </table>
    <h1> Archived Quiz</h1>
    <table class="uk-table uk-table-middle uk-table-divider">
        <thead>
        <tr>

            <th>Title</th>
            <th class="uk-table-shrink">Start</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sql_current_quiz = "select * from quiz where ongoing_flag  =  0";
        $result = $conn->query($sql_current_quiz);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr><td>' . $row["title"] . "</td><td><a href='start_quiz.php?id=" . $row["id"] . "'class='uk-button uk-button-default uk-width-medium'>Start</a></td></tr>";

            }
        }
        ?>


        </tbody>
    </table>
    </table>
</div>
</body>
</html>
