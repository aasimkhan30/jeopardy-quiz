<?php
/**
 * Created by PhpStorm.
 * User: aasimkhan30
 * Date: 11/6/17
 * Time: 2:28 PM
 */
ob_start();
include "../include/db.php";
$res = array();
$params = (array) json_decode(file_get_contents('php://input'), TRUE);
//$_POST = $params;


session_start();
$user = $_SESSION["user_id"];
//$user = $_POST["user_id"];
if($_POST['quiz_id'] != null){
    $quiz = $_POST['quiz_id'];
    $sql = "select q.points,q.category,a.points as p from questions as q INNER JOIN  quiz_answers as a ON q.id = a.questions_id WHERE a.quiz_id = ".$quiz;
    $result = $conn->query($sql);
    $questions = array();
    while($row = $result->fetch_assoc()){
        array_push($questions,$row);
    }
    $res["success"] =1;
    $res["questions"] = $questions;
    $sql = "select * from quiz WHERE id = ".$quiz;
    $result = $conn->query($sql);
    if($row = $result->fetch_assoc()){

    }
    $res["qd"] = $row;
    echo json_encode($res);
}
else{
    $res["success"] = 0;
    echo json_encode($res);
}
?>