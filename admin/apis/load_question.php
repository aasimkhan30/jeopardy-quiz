<?php
include '../include/db.php';
$reply = array();
$params = (array) json_decode(file_get_contents('php://input'), TRUE);
//$_POST = $params;
if(!isset($_POST["qid"]) || !isset($_POST["cat"]) || !isset($_POST["points"])){
    $reply["success"] = "0";
    echo json_encode($reply);
    exit();
}
$reply["success"]=1;
$qid = $_POST["qid"];
$cat = $_POST["cat"];
$points =$_POST["points"];
$sql = "select * from questions where quiz_id = $qid and points= $points and category =$cat";
$result = $conn -> query($sql);
if($result->num_rows == 0){
    $reply["new_question"]= 1;
    echo json_encode($reply);
    exit();
}
$question = $result->fetch_assoc();
$sql = "select * from options where question_id =".$question["id"];
$result = $conn->query($sql);
$options = array();
while ($row = $result->fetch_assoc())
    array_push($options,$row);
$reply["question"]=$question;
$reply["options"]=$options;
echo json_encode($reply);
?>
