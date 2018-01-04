<?php
/**
 * Created by PhpStorm.
 * User: aasimkhan
 * Date: 12/5/17
 * Time: 9:29 PM
 */

session_start();

include "../include/db.php";

$teamid = $_SESSION["team_id"];
$wager = $_POST["wager"];

$sql = "update doubletable set dj_flag = 1, dj_wager =". $wager ." where userid =". $teamid;
$result = $conn->query($sql);
$reply = [];
$reply["success"] = 1;
echo json_encode($reply);
?>