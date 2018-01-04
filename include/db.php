<?php

$servername="localhost";
$username="id1974269_root";
$password="aasimkhan";
$db="id1974269_church";


$conn=new mysqli($servername,$username,$password,$db);
if($conn->connect_error)
    die ("Connection Failed ".$conn->connect_error);



?>

