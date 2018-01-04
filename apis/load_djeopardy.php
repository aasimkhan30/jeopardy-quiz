<?php
/**
 * Created by PhpStorm.
 * User: aasimkhan
 * Date: 12/5/17
 * Time: 8:34 PM
 */

// starting session
session_start();
ob_start();

// including database
include '../include/db.php';

// getting team ID from the session created on the quiz page
$teamid = $_SESSION["team_id"];

// now getting scores from database
$sql = 'select sum(points) as points from quiz_answers where user_id = '. $teamid;
$result = $conn->query($sql);
if($result == null)
{
    $total = 0;
}
else
{
    $row = $result->fetch_assoc();
    $total = $row["points"];
}

// implementing daily double logice
$total = max($total,1000);

// formulating reply
$reply = [];
$reply["total"] = $total;
echo json_encode($reply);
?>