<?php
/**
 * Created by PhpStorm.
 * User: aasimkhan30
 * Date: 11/6/17
 * Time: 2:31 PM
 */
session_start();
include "../include/db.php";
$response = array();
$params = (array) json_decode(file_get_contents('php://input'), TRUE);
//$_POST = $params;

$_POST['user_id'] = $_SESSION["team_id"];
$_POST["qid"] = $_SESSION["quiz_id"];

if(isset($_POST['user_id']) && isset($_POST['quest_id']) && isset($_POST['points']) && isset($_POST["qid"])) {
    $user = $_POST["user_id"];
    $question = $_POST["quest_id"];
    $points = $_POST["points"];
    $qid = $_POST["qid"];
    $sql = "select * from quiz_answers where user_id = ".$user." AND questions_id = ".$question;
    $result = $conn->query($sql);
//    var_dump($result);
    if($result->num_rows == 0){
        $sql = "select * from quiz_answers where questions_id = $question and points>0";
        $result = $conn->query($sql);
        if($result->num_rows == 0){
            $points = $points;
        }
        if($result->num_rows == 1){
            $points = $points*0.5;
        }
        if($result->num_rows >= 2){
            $points = $points*0.25;
        }

        $sql = "insert into quiz_answers (user_id,questions_id,points,quiz_id) VALUES (".$user.",".$question.",".$points.",$qid)";
        $result = $conn->query($sql);
        $response["points"] = $points;
        $response["success"] =  1;



    }
    else{

        $response["success"] =  0;
        $response["error"] = "Already Answered";
        echo json_encode($response);
        exit();

    }
    echo json_encode($response);

}
else{
    $response["error"] = "Invalid use of API";
    echo json_encode($response);
}
?>

