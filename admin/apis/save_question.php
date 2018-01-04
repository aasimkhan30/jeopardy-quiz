<?php
header("Content-Type: text/html; charset=UTF-8");
include '../include/db.php';
$reply = array();
$params = (array) json_decode(file_get_contents('php://input'), TRUE);
#$_POST = $params;

if(!isset($_POST["qid"]) || !isset($_POST["points"])
    || !isset($_POST["category"]) || !isset($_POST["question_en"])
    || !isset($_POST["question_ml"]) || !isset($_POST["option1_en"])
    || !isset($_POST["option1_ml"]) || !isset($_POST["option2_en"])
    || !isset($_POST["option2_ml"]) || !isset($_POST["option3_en"])
    || !isset($_POST["option3_ml"]) || !isset($_POST["option4_en"])
    || !isset($_POST["option4_ml"]) || !isset($_POST["correct"])){
    $reply["success"]=0;
    echo json_encode($reply);
    exit();
}


$qid = $_POST["qid"];
$points = $_POST["points"] ;
$category = $_POST["category"];



$sql = "select * from questions where quiz_id = $qid and category =$category and points = $points";
$result = $conn->query($sql);
if($result->num_rows == 1){
    $row=$result->fetch_assoc();
    updatequestion($_POST,$row["id"]);
}
else{
    createquestion($_POST);
}



function updatequestion($data,$id){

    include '../include/db.php';
    $qid = $data["qid"];
    $points = $data["points"] ;
    $category = $data["category"];
    $quesen = mysqli_real_escape_string($conn,$data["question_en"]);
    $quenml = mysqli_real_escape_string($conn,$data["question_ml"]);
    $op1en = mysqli_real_escape_string($conn,$data["option1_en"]) ;
    $op1ml = mysqli_real_escape_string($conn,$data["option1_ml"]);
    $op2en = mysqli_real_escape_string($conn,$data["option2_en"] );
    $op2ml = mysqli_real_escape_string($conn,$data["option2_ml"]);
    $op3en = mysqli_real_escape_string($conn,$data["option3_en"]) ;
    $op3ml = mysqli_real_escape_string($conn,$data["option3_ml"]);
    $op4en = mysqli_real_escape_string($conn,$data["option4_en"] );
    $op4ml = mysqli_real_escape_string($conn,$data["option4_ml"]);
    $custom_points = mysqli_real_escape_string($conn,$data["custom_points"]);
    $correct = $data["correct"];
    $sql = "update questions SET english = '$quesen',malyalam = '$quenml', custom_points = $custom_points where quiz_id = $qid and category =$category and points = $points ";
    //echo $sql;
    $result = $conn->query($sql);
    $sql = "select * from options where question_id = $id ORDER BY id";
    $result = $conn->query($sql);
    $i = 1;
    while($row = $result->fetch_assoc()){
        if($correct == $i)
            $c = 1;
        else
            $c = 0;
        $sql = "UPDATE options SET option_text = '".$_POST["option".$i."_en"]."' ,option_text_ml = '".$_POST["option".$i."_ml"]."' , correct = $c where id = ".$row["id"];
        $result1 = $conn->query($sql);
        $i++;
    }
    $reply["success"]=1;
    echo json_encode($reply);
    exit();

}


function createquestion($data){
    include '../include/db.php';

    $qid = $data["qid"];
    $points = $data["points"] ;
    $category = $data["category"];
    $quesen = $data["question_en"];
    $quenml = $data["question_ml"] ;
    $op1en = $data["option1_en"] ;
    $op1ml = $data["option1_ml"];
    $op2en = $data["option2_en"] ;
    $op2ml = $data["option2_ml"];
    $op3en = $data["option3_en"] ;
    $op3ml = $data["option3_ml"];
    $op4en = $data["option4_en"] ;
    $op4ml = $data["option4_ml"];
    $correct = $data["correct"];
    $custom_points = $data["custom_points"];
    $sql = "insert into questions (quiz_id,english,malyalam,points,category,custom_points) VALUES ($qid,'$quesen','$quenml',$points,$category,$custom_points)";
    $result = $conn->query($sql);
    $id = mysqli_insert_id($conn);

    for($i =1 ;$i<5;$i++){
        if($correct == $i)
            $c = 1;
        else
            $c = 0;
        $sql = "INSERT into options(question_id,option_text,option_text_ml,correct) VALUES ( $id,'".$_POST["option".$i."_en"]."', '".$_POST["option".$i."_ml"]."',$c)";
        $result = $conn ->query($sql);
    }

    $reply["success"]=1;
    echo json_encode($reply);
    exit();

}

?>