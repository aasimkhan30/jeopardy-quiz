<?php
/**
 * Created by PhpStorm.
 * User: aasimkhan30
 * Date: 10/6/17
 * Time: 10:10 PM
 */
session_start();
if (!isset($_SESSION["admin_loggedin"])) { // this means the user session is set
    header("Location:admin_login.php");
}

?>
<!DOCTYPE html>
<html>
<head>
    <link href="css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/uikit.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/uikit.js"></script>
    <script type="text/javascript" src="js/uikit-icons.js"></script>
    <script>

        function vedit() {
            console.log("vcall");
            var sd = new Date($("#sdate").val());
            var ed = new Date($("#edate").val());
            if (sd >= ed) {
                Materialize.toast('Start date cannot be greater than end date', 4000, 'red');// 4000 is the duration of the toast
                $("#upsubmit").attr("disabled", true);
            }
            else {
                $("#upsubmit").attr("disabled", false);

            }
        }
    </script>
    <style type="text/css">
        .createquiz {
            background-color: #008CBA;
        }
    </style>
</head>

<body>
<div uk-sticky="media: 960" class="uk-navbar-container tm-navbar-container uk-sticky" style="">
    <div class="uk-container uk-container-expand">
        <nav class="uk-navbar-container " uk-navbar>
            <div class="uk-navbar-left">
                <a class="uk-navbar-item uk-logo" href="index.php">Church</a>
            </div>
            <div class="uk-navbar-right">
                <a href="apis/admin_logout.php" class=" uk-button uk-button-default navbar-button">Logout</a>
            </div>
        </nav>
    </div>
</div>
<div class="uk-container">
    <br>
    <h1>Admin Home</h1>
    <!-- Modal Trigger -->
    <a class="uk-button uk-button-default" uk-toggle="target: #modal1">Create Quiz</a>

    <!-- Modal Structure -->
    <div id="modal1" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <h2 class="uk-modal-title">Create New Quiz</h2>
            <form method="POST" action="apis/new_quiz.php">
                <div class="uk-margin">
                    <input id="quizname" name="title" type="text" class="uk-input uk-form-width-large"
                           placeholder="Title"
                           required>
                </div>
                <input type="hidden" name="start_time" id="sdate" value="22-07-2017" required>
                <input type="hidden" name="end_time" id="edate" value="23-07-2017" required>
                <p class="uk-text-right">
                    <!-- <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>-->
                    <input type="submit" value="Create" class="uk-button uk-button-default" type="button">
                </p>
            </form>
        </div>
    </div>

    <table class="uk-table uk-table-middle uk-table-divider uk-table-small">
        <thead>
        <tr>
            <th>Quiz Name</th>
            <th>Edit</th>
            <th>Reset</th>
            <th>Delete</th>
        </tr>
        </thead>

        <tbody>

        <?php
        include "include/db.php";
        $sql = "select * from quiz order by start_time DESC ";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo $row["title"]; ?></td>

                <td>
                    <a class="uk-button uk-button-default" href="editquiz.php?id=<?php echo $row["id"]; ?>">Edit</a>
                </td>
                <td>
                    <a class="uk-button uk-button-default"
                       onclick="resetmodal(<?php echo $row["id"]; ?>)">Reset</a>
                </td>

                <td>
                    <a class="uk-button uk-button-default" onclick="deletemodal(<?php echo $row["id"]; ?>)">Delete</a>
                </td>
            </tr>
        <?php } ?>


        </tbody>
    </table>
</div>

<div id="modal2" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h2 class="uk-modal-title">Deletion Confirmation</h2>
        <p>Are you sure you want to delete this quiz?</p>
        <p class="uk-text-right">
            <!-- <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>-->
            <a href="#!" id="deletequiz" class="uk-button uk-button-default">Delete</a>
        </p>
    </div>
</div>

<div id="modal3" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h2 class="uk-modal-title">Reset Confirmation</h2>
        <p>Are you sure you want to reset this quiz ?</p>
        <p class="uk-text-right">
            <!-- <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>-->
            <a href="#!" id="resetquiz" class="uk-button uk-button-default">Reset</a>
        </p>
    </div>
</div>


<script>

    function deletemodal(id) {
        UIkit.modal("#modal2").show();
        document.getElementById("deletequiz").onclick = function () {
            delete_quiz(id);
        }
        /* $('#modal2').modal('open');
         document.getElementById("deletequiz").onclick = function () {
             delete_quiz(id);
         }*/
    }

    function delete_quiz(id) {
        var data = {
            qid: id
        };
        $.ajax({
            url: 'apis/delete_quiz.php',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function (data, status) {
                console.log(data);
                window.location.reload();

            },
            error: function (xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
    }


    function resetmodal(id) {
        UIkit.modal("#modal3").show();
        document.getElementById("resetquiz").onclick = function () {
            reset_quiz(id);
        }
    }

    function reset_quiz(id) {
        var data = {
            qid: id
        };
        $.ajax({
            url: 'apis/reset_quiz.php',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function (data, status) {
                console.log(data);
                window.location.reload();
            },
            error: function (xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
    }
</script>
</body>

</html>