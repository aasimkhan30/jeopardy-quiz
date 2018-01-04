<?php
/**
 * Created by PhpStorm.
 * User: aasimkhan
 * Date: 7/11/17
 * Time: 1:01 AM
 */

include "../include/db.php";
$qid = $_POST["qid"];
$reply = array();
$sql = "select * from quiz_participants where quiz_id NOT IN (select curr_chance from quiz where id = $qid)";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()){
    array_push($reply,$row);
}
echo json_encode($reply);
?>