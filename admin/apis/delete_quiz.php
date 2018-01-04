<?php
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
$sql ="DELETE FROM quiz where id = $id";
$result = $conn->query($sql);

$sql = "DELETE FROM quiz_answers where quiz_id = $id";
$result = $conn -> query($sql);

$sql = "select * from questions where quiz_id=$id ";

$result = $conn -> query($sql);

while($row = $result->fetch_assoc()){
    $qid = $row["id"];
    $sql = "delete from options where question_id = $qid";
    $result1 = $conn->query($sql);
}

$sql= "DELETE from questions where quiz_id = $id";
$result = $conn ->query($sql);

$sql= "DELETE from quiz_participants where quiz_id". $id;
$result = $conn ->query($sql);

$sql= "DELETE from quiz_participants where quiz_id =". $id;
$result = $conn ->query($sql);

$sql= "DELETE from doubletable where quiz_id =". $id;
$result = $conn ->query($sql);

$reply["success"] = 1;

echo json_encode($reply);

?>