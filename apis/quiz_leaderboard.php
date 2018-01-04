<?php

ob_start();
$reply = array();
session_start();
if(!isset($_GET['id'])) {
    $reply["failure"]=1;
    exit();
}

include "../include/db.php";
$qid = $_GET["id"];
$leaderboard = array();

$sql = "select * from quiz_participants where quiz_id = $qid";

$result = $conn->query($sql);
while($row = $result ->fetch_assoc()){
    $leader = array();
    $leader["team_name"] = $row["team_name"] ;
    $sql = "select sum(points) as points  from quiz_answers  where quiz_id = $qid and user_id = ".$row['id'];
    $result1 =  $conn->query($sql);
    $row1 = $result1->fetch_assoc();
    if($row1["points"]==null)
        $row1["points"]=0;
    $leader["points"]=(int)$row1["points"];
    $leader["uid"] = (int)$row["id"];
    $leader["qid"] = (int)$row["quiz_id"];
    array_push($leaderboard,$leader);
}
usort($leaderboard, function ($a, $b) { return $a["uid"]-$b["uid"]; });
$reply["leaderboard"]= $leaderboard;
header('Content-Type: application/json');
echo json_encode($reply);
exit();

?>




