<?php
/**
 * Created by PhpStorm.
 * User: aasimkhan30
 * Date: 12/6/17
 * Time: 12:37 PM
 */
include 'include/db.php';
session_start();
if (!isset($_SESSION["username"]) || !isset($_SESSION["user_id"]) || !isset($_SESSION["emailid"])) { // this means the user session is set
    header("Location: login.php");
}
$username = $_SESSION["username"];
$id = $_SESSION["user_id"];
$email = $_SESSION["emailid"];
//echo "Current userid = $id and username = $username and email = $email";
$count_of_quiz = 1;   //keeps count of quiz for the while loop

// indiviual quiz ranking

/// /////////  overall quiz ranking///////
// echo "<h3>Overall quiz ranking";
$sql_overall_quiz = "select u.username as username,a.user_id as user_id,a.questions_id as questions_id,a.quiz_id as quiz_id,sum(a.points) as points from quiz_answers as a inner JOIN  users as u on u.id= a.user_id  group by user_id order by sum(points) DESC";
$result = $conn->query($sql_overall_quiz);
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
        <a href="home.php" class="brand-logo" style="margin-left:10px;">Church</a>
        <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
            <li><a href="home.php" class="waves-effect waves-light  indigo">Home</a></li>
            <li><a href="leaderboard.php" class="waves-effect waves-light  indigo">Leaderboard</a></li>
            <li><a href="apis/logout.php" class="waves-effect waves-light btn">Logout</a></li>
        </ul>
        <ul class="side-nav indigo" id="mobile-demo">
            <li><a href="home.php" class="waves-effect waves-light btn indigo">Home</a></li>
            <li><a href="leaderboard.php" class="waves-effect waves-light btn indigo">Leaderboard</a></li>
            <li><a href="apis/logout.php" class="waves-effect waves-light btn">Logout</a></li>
        </ul>
    </div>
</nav>
<script>
    (function ($) {
        $(function () {
            $(".button-collapse").sideNav();

            //initialize all modals
            $('.modal').modal();

            //or by click on trigger
            $('.trigger-modal').modal();

            $('.datepicker').pickadate({
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 15 // Creates a dropdown of 15 years to control year
            });

        }); // end of document ready
    })(jQuery)
</script>

<div class="container">
    <div class="row" style="margin-top:40px;">
        <div class="col s12">
            <div class="card-panel" style="max-height:700px;">
                <h4 style="width:100%;  text-align: center;">Overall Quiz Ranking</h4>

                <table class="centered striped">
                    <thead>
                    <tr>

                        <th>Rank</th>
                        <th>User ID</th>
                        <th>Points</th>
                    </tr>
                    </thead>

                    <tbody>

                    <?php

                    if ($result->num_rows > 0) {
                        $rank_quiz_indivisual = 1;
                        // output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr><td>' . $rank_quiz_indivisual . "</td><td>" . $row["username"] . "</td><td>" . $row["points"] . "</td></tr>";
                            $rank_quiz_indivisual++;
                        }
                    } else {
                        echo "<tr><td> - </td> <td> - </td><td>-</td></tr>";
                    }
                    echo "</table><br>";

                    ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
</body>
</html>

