<?php
ob_start();
include '../include/db.php';
$reply = array();
//$params = (array) json_decode(file_get_contents('php://input'), TRUE);
//$_POST = $params;

if(!isset($_POST["start_time"]) && !isset($_POST["end_time"]) && !isset($_POST["title"])){
    $reply["success"]=0;
    echo json_encode($reply);
    exit();
}

///$reply["success"]=1;

$start = $_POST["start_time"];
$end = $_POST["end_time"];
$title = $_POST["title"];

//echo $start;
//$myeDateTime = DateTime::createFromFormat('m-d-Y', $start);
//$mysDateTime = DateTime::createFromFormat('m-d-Y', $end);


//$start = $mysDateTime->format('Y-m-d');
//$end = $myeDateTime->format('Y-m-d');


$sql="insert into quiz (start_time,end_time,title,c1,c2,c3,c4,c5) VALUES ('$start','$end','$title','Category 1','Category 2','Category 3','Category 4','Category 5')";
//echo $sql;
$result = $conn->query($sql);
$id = mysqli_insert_id($conn);
//$reply["id"]=$id;
//echo json_encode($reply);
header("Location: ../editquiz.php?id=$id");

?>