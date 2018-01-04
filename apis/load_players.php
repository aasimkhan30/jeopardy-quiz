<?php
/**
 * Created by PhpStorm.
 * User: aasimkhan
 * Date: 12/6/17
 * Time: 1:43 AM
 */

session_start();

include '../include/db.php';

$qid = $_SESSION["quiz_id"];
$tid = $_SESSION["team_id"];

$sql = "select * from quiz_participants where quiz_id =". $qid;
$result = $conn->query($sql);

$response = [];

while($row = $result->fetch_assoc()){
    if($row["id"] == $tid){

        $row["curr"] = 1;
    }
    else
    {
        $row["curr"] = 0;
    }
    array_push($response,$row);
}

echo json_encode($response);

?>