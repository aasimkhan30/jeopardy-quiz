<?php
session_start();
if (!isset($_SESSION["username"]) || !isset($_SESSION["user_id"]) || !isset($_SESSION["emailid"])) { // this means the user session is set
    header("Location: login.php");
}
include "include/db.php";
$username = $_SESSION["username"];
$id = $_SESSION["user_id"];
$email = $_SESSION["emailid"];
$qid = $_GET["id"];
$sql = "select * from quiz where id = $qid";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
if ($row["ongoing_flag"] == 1) {
    header("Location: quiz.php?id=qid");
}
//echo "Current userid = $id and username = $username and email = $email";
?>
<!DOCTYPE html>
<html>
<head>
    <link href="css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/uikit.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>

<body>
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/uikit.min.js"></script>
<script type="text/javascript" src="js/uikit-icons.min.js"></script>
<script type="text/javascript">
    function deleterow() {
        console.log("Delete Clicked");
        var rowCount = $('#team >tbody >tr').length;
        console.log("Number of Rows: " + rowCount);
        if (rowCount > 2) {
            $("#team tr:last").remove();
        }

    }

    function addrow() {
        console.log("Add Clicked");
        var rowCount = $('#team >tbody >tr').length;
        console.log("Number of Rows: " + rowCount);
        if (rowCount < 5) {
            no = rowCount + 1;
            markup =
                "<tr> <td>" +
                "<input placeholder='Team " + no + " Name' name='team[]' type='text' class='uk-input uk-form-width-large'required>"
                + "</td> <td>" +
                "<input type='checkbox' class='uk-checkbox' onchange='mycheck(" + no + ")' value='yes' name='first[]' id='checkopt" + no + "'>"
                + "</td> </tr>";
            console.log(markup);
            $("#team tbody").append(markup);
        }


    }
</script>
<nav class="uk-navbar-container " uk-navbar>
    <div class="uk-navbar-left">
        <a class="uk-navbar-item uk-logo" href="index.php">Church</a>
    </div>
    <div class="uk-navbar-right">
        <a href="apis/logout.php" class=" uk-button uk-button-default navbar-button">Logout</a>
    </div>
</nav>

<br>
<?php
require "include/db.php";
$current_date = date("Y-m-d");   // current date
?>
<div class="uk-container">
    <h1>Teams</h1>


    <form action="apis/start_quiz.php" method="post">
        <input type="hidden" name="qid" value="<?php echo $qid; ?>">
        <input type="hidden" id="firstt" name="firstt" value="1">

        <table class="uk-table" id="team">
            <thead>
            <td>Team Names</td>
            <td>First</td>
            </thead>
            <tbody>
            <tr>
                <td>
                    <input placeholder="Team 1 Name" name="team[]" type="text" class="uk-input uk-form-width-large"
                           required>
                </td>
                <td>
                    <input type="checkbox" class="uk-checkbox" onchange="mycheck(1)" value="yes" name="first[]"
                           id="checkopt1" checked>
                </td>
            </tr>
            <tr>
                <td>
                    <input placeholder="Team 2 Name" name="team[]" type="text" class="uk-input uk-form-width-large"
                           required>
                </td>
                <td>
                    <input type="checkbox" class="uk-checkbox" onchange="mycheck(2)" value="yes" name="first[]"
                           id="checkopt2"/>
                </td>
            </tr>

            </tbody>
        </table>

        <a class="uk-button uk-button-default" onclick="addrow()">Add</a>
        <a class="uk-button uk-button-default" onclick="deleterow()">Remove</a>
        <div class="uk-margin">
            <input type="submit" class="uk-button uk-button-default uk-width-1-1\@l" value="Start">
        </div>

    </form>
</div>

</body>
<script>
    function mycheck(id) {
        $("#firstt").val(id);
        for (var i = 0; i < 5; i++) {
            if (id != i + 1)
                $("#checkopt" + (i + 1)).prop('checked', false);
        }
    }
</script>
</html>
