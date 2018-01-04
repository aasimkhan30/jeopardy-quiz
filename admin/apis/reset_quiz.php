<?php
/**
 * Created by PhpStorm.
 * User: aasimkhan30
 * Date: 9/7/17
 * Time: 7:19 PM
 */
ob_start();
include "../include/db.php";
$reply = array();
$params = (array) json_decode(file_get_contents('php://input'), TRUE);
//$_POST = $params;

if(!isset($_POST["qid"])){
    $reply["success"] = 0;
    echo json_encode($reply);
    exit();
}

$id = $_POST["qid"];
$sql ="DELETE FROM quiz_participants where quiz_id = $id";
$result = $conn->query($sql);

$sql = "DELETE FROM quiz_answers where quiz_id = $id";
$result = $conn -> query($sql);

$sql = "DELETE FROM doube_table where quiz_id = $id";
$result = $conn -> query($sql);

$sql = "update quiz set ongoing_flag = 0 where id = $id";
$result = $conn -> query($sql);

$reply["success"] = 1;

echo json_encode($reply);



?>