<?php
include '../include/db.php';
$reply = array();
$reply = array();
$params = (array) json_decode(file_get_contents('php://input'), TRUE);
if(!isset($_POST["id"])){
    $reply["success"]=0;
}
$reply["success"]=1;
$id = $_POST["id"];

$sql = "select * from quiz where id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$myeDateTime = DateTime::createFromFormat('Y-m-d', $row["start_time"]);
$mysDateTime = DateTime::createFromFormat('Y-m-d', $row["end_time"]);
//$row["start_time"] = $mysDateTime->format('m-d-Y');
//$row["end_time"] = $myeDateTime->format('m-d-Y');

$reply["quiz"]=$row;
$questions = array();
$sql = "select * from questions where quiz_id = $id ";
$result = $conn ->query($sql);
while($row = $result->fetch_assoc()){
    array_push($questions,$row);
}
$reply["questions"]=$questions;
echo json_encode($reply);
?>