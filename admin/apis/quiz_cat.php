<?php
/**
 * Created by PhpStorm.
 * User: aasimkhan
 * Date: 8/29/17
 * Time: 1:54 AM
 */
include '../include/db.php';
$c1 = $_POST["c1"];
$c2 = $_POST["c2"];
$c3 = $_POST["c3"];
$c4 = $_POST["c4"];
$c5 = $_POST["c5"];
$id = $_POST["id"];
$sql = "update quiz set c1 = '$c1',c2 = '$c2',c3 = '$c3',c4 = '$c4',c5 = '$c5'  where id = $id";
echo $sql;
$result = $conn->query($sql);

header("Location: ../editquiz.php?id=$id");

?>