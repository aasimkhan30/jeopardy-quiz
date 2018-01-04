<?php
ob_start();
include '../include/db.php';
//$reply = array();
//$params = (array) json_decode(file_get_contents('php://input'), TRUE);
//$_POST = $params;
if(!isset($_POST["start_time"]) || !isset($_POST["end_time"]) || !isset($_POST["title"]) || !isset($_POST["id"])){
    session_start();
    $_SESSION["session_error"]="Feilds Cannot Be Empty";
    header("Location: ../editquiz.php?id=".$_POST["id"]);
    exit();
}
$reply["success"]=1;
$id = $_POST["id"];
$start = $_POST["start_time"];
$end = $_POST["end_time"];
$title = $_POST["title"];

//$myeDateTime = DateTime::createFromFormat('m-d-Y', $start);
//$mysDateTime = DateTime::createFromFormat('m-d-Y', $end);
//$start = $mysDateTime->format('Y-m-d');
//$end = $myeDateTime->format('Y-m-d');

$sql = "update quiz set start_time = '$start',end_time = '$end',title = '$title' where id = $id";
$result = $conn->query($sql);
//echo json_encode($reply);
header("Location: ../editquiz.php?id=$id");

?>