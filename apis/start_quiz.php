<?php
ob_start();
 include "../include/db.php";

 if(!isset($_POST["qid"]) && !isset($_POST["team"]) && !isset($_POST["first"])){
     header("Location: home.php");
 }


 $qid = $_POST["qid"];
 $teams = $_POST["team"];
 $first = $_POST["first"];
$firstt = $_POST["firstt"];
 for($i = 0; $i < sizeof($_POST["team"]);$i++){
     $sql = "insert into quiz_participants (quiz_id,team_name) VALUES ($qid,'$teams[$i]')";
     echo $sql;
     $result = $conn -> query($sql);
     $tid = mysqli_insert_id($conn);
     if($i+1 == $firstt){
        $sql = "update quiz set ongoing_flag = 1,curr_chance=$tid where id = $qid";
        echo $sql;
        $result = $conn -> query($sql);
     }
     $sql = "insert into doubletable (quiz_id,userid,dd_flag,dd_wager,dj_flag,dj_wager) VALUES ($qid,$tid,0,0,0,0)";
     $result = $conn ->query($sql);
     echo $sql;
 }
 header("Location: ../quiz.php?id=$qid");
?>