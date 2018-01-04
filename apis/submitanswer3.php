<?php
/**
 * Created by PhpStorm.
 * User: aasimkhan
 * Date: 12/6/17
 * Time: 11:31 AM
 */

session_start();

include "../include/db.php";
$params = (array) json_decode(file_get_contents('php://input'), TRUE);
var_dump($_POST);
//$_POST = $params;
$tid = $_POST["s3utxt"];
$qid = $_POST["s3qtxt"];
$points = $_POST["s3ptxt"];
$quest = 0;

$sql = "insert into quiz_answers (user_id,questions_id,quiz_id,points) VALUES ($tid,$quest,$qid,$points)";
$result = $conn->query($sql);

header("Location: ../quiz.php?id=".$qid);



