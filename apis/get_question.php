<?php
/**
 * Created by PhpStorm.
 * User: aasimkhan30
 * Date: 11/6/17
 * Time: 3:02 PM
 */
ob_start();
include '../include/db.php';

session_start();
$userid = $_SESSION["team_id"];
if($_GET['category'] != null  && $_GET['point'] != null && $_GET['quiz_id'] != null ) {
    $cat = $_GET["category"];
    $points = $_GET["point"];
    $quiz = $_GET["quiz_id"];
    $res = new \stdClass();
    $sql = "select * from quiz_answers where quiz_id = " . $quiz .
        " AND questions_id IN (select id from questions where quiz_id = "
        . $quiz . " AND category = " . $cat . " AND points = " . $points . ")";
    // echo $sql."\n";
    $result = $conn->query($sql);
    if ($result->num_rows > 1)
        $res->multiple = 1;
    else
        $res->multiple = 0;
    $row = $result->fetch_assoc();
    $res->answers = $row;
    if ($result->num_rows != 0) {
    $sql = "select * from quiz_participants where id = " . $row["user_id"];
    // echo $sql;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $res->team = $row;
}
//    var_dump($result);
    $conn->set_charset("utf8");
    $sql = "select * from questions where quiz_id = " . $quiz . " AND category = " . $cat . " AND points = " . $points;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $res->success = 1;
        $row = $result->fetch_assoc();


        $res->question = $row;

        $sql = "select * from options where question_id = " . $row["id"];
        $conn->query("SET CHARACTER SET utf8");
        $result = $conn->query($sql);


        $options = array();


        while ($row = $result->fetch_assoc()) {
            $temp = new stdClass;
            $temp->eng = $row['option_text'];
            $temp->ml = $row['option_text_ml'];
            $temp->corr = $row['correct'];
            array_push($options, $temp);

        }

        $res->options = $options;
    } else {
        $res->success = 0;
    }
    echo json_encode($res);



}
else{
    echo "Invalid API use";
}
?>