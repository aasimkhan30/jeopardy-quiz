<?php
/**
 * Created by PhpStorm.
 * User: aasimkhan
 * Date: 7/11/17
 * Time: 6:07 PM
 */
session_start();

include "../include/db.php";

$curr = $_SESSION["team_id"];
$tid = $_POST["tid"];
$qid = $_SESSION["quiz_id"];
$points = $_POST["points"];
$quest = $_POST["quest"];
if($tid == $curr)
{
    $sql = "select * from doubletable where userid = ". $tid;
    $result =  $conn->query($sql);
    $row = $result->fetch_assoc();
    if($row["dd_flag"] == 1)
    {
        if($points == 0){
            $points = -1 * $row["dd_wager"];
        }
        else{
            $points = $points + $row["dd_wager"];
        }
        $sql = "update doubletable set dd_flag = 2 where userid = ". $tid;
        $result =  $conn->query($sql);

    }
    if($row["dj_flag"] == 1)
    {
        if($points == 0){
            $points = -1 * $row["dj_wager"];
        }
        else{
            $points = $points + $row["dj_wager"];
        }

        $sql = "update doubletable set dj_flag = 2 where userid = ". $tid;
        $result =  $conn->query($sql);
    }

    $sql = "select id from quiz_participants where id > $tid and quiz_id = $qid ORDER BY id";
    $result= $conn->query($sql);
    if($result->num_rows > 0 ){
        $row = $result -> fetch_assoc();
        $ncurr = $row["id"];
        $sql = "update quiz set curr_chance = $ncurr where id = $qid";
        $result = $conn->query($sql);
    }
    else{
        $sql = "select min(id) as id from quiz_participants where quiz_id = $qid";
        $result= $conn->query($sql);
        $row= $result->fetch_assoc();
        $ncurr = $row["id"];
        $sql = "update quiz set curr_chance = $ncurr where id = $qid";
        $result = $conn->query($sql);
    }

}
$sql = "insert into quiz_answers (user_id,questions_id,quiz_id,points) VALUES ($tid,$quest,$qid,$points)";
$result = $conn->query($sql);

$reply["success"] = 1;

echo json_encode($reply);

?>