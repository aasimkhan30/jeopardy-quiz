<?php
ob_start();
    require "../include/db.php";
    session_start();
	//do things
    $reply = array();
    if(!isset($_GET['uid']) && !isset($_SESSION['user_id'])) {
        $reply["success"]=1;
    }
	$user_id=$_GET['uid'];
	$quiz_id=$_SESSION["user_id"];

	$sql_leader_quiz = "select user_id,questions_id,quiz_id,sum(points) from quiz_answers where quiz_id='$quiz_id' group by user_id order by user_id";
	$result = $conn->query($sql_leader_quiz);
	//$sth = mysqli_query("SELECT ...");
	$leaderboard = array();  // to store the result from sql query
	$user_rank=1;  // keeping track of user rank
	$rows=array();	// json object variable
	$check=0;	// flag to flip once user_id and user_rank are noted
	$rank_quiz_indivisual=0; // to maintain rank for leaderboard
	$for_same_rank=99999;	// used for same rank purposes
    $user_points = 0;
    $user_rank = 0;
	while($r = $result->fetch_assoc()) {

		//same rank logic
		if(!($r['sum(points)']==$for_same_rank))
		{
			$rank_quiz_indivisual++;
			$for_same_rank=$r['sum(points)'];
		}

		// to gather user rank and points
		if($check==0 && $user_id==$r['user_id'])
		{
			$user_rank=$rank_quiz_indivisual;
			$user_points=$r['sum(points)'];
			$check=1;
		}
		$r['rank']=$rank_quiz_indivisual;
		$leaderboard[]=$r;

	}
	$rows[]=$leaderboard;
	$rows['user_points']=$user_points;
	$rows['user_rank']=$user_rank;
	header('Content-Type: application/json');
	echo json_encode($rows);
}
else
{
	echo("please send get request");
}
?>