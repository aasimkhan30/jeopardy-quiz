
<?php
    include '../include/config.php';
    include '../include/db.php';
    $sql = "select * from quiz ORDER BY start_time";
    $result = $conn->query($sql);
    $reply = array();
    while($row = $result->fetch_assoc()){
        $id = $row["id"];
        $sql= "select * from questions where quiz_id=$id";
        $tres = $conn->query($sql);
        $row["total"] = $tres->num_rows;
        array_push($reply,$row);
    }
    //$reply = mysqli_fetch_all($result,MYSQLI_ASSOC);
    echo json_encode($reply);

?>