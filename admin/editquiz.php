<?php
/**
 * Created by PhpStorm.
 * User: aasimkhan30
 * Date: 12/6/17
 * Time: 1:39 PM
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


    <script>
        $(document).ready(function () {
            // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
            $("#edit_error").hide();
            loaddata();

        });

        function loaddata() {
            id = <?php echo $_GET["id"];?>;
            data = {
                "id": id
            }
            $.ajax({
                url: 'apis/load_quiz.php',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function (data, status) {
                    console.log(data);
                    edata = new Date(data.quiz.end_time);
                    sdata = new Date(data.quiz.start_time);
                    $("#edate").val(data.quiz.end_time);
                    $("#sdate").val(data.quiz.start_time);
                    $("#quizname").val(data.quiz.title);
                    $("#c1").val(data.quiz.c1);
                    $("#c2").val(data.quiz.c2);
                    $("#c3").val(data.quiz.c3);
                    $("#c4").val(data.quiz.c4);
                    $("#c5").val(data.quiz.c5);

                    $("#ch1").text(data.quiz.c1);
                    $("#ch2").text(data.quiz.c2);
                    $("#ch3").text(data.quiz.c3);
                    $("#ch4").text(data.quiz.c4);
                    $("#ch5").text(data.quiz.c5);

                    for (var i = 0; i < data.questions.length; i++) {
                        cat = data.questions[i].category;
                        poi = data.questions[i].points;
                        var id = parseInt(cat * 1000) + parseInt(poi);
                        console.log(id);
                        $('#' + id).addClass('uk-card-primary');
                    }
                },
                error: function (xhr, desc, err) {
                    console.log(xhr);
                    console.log("Details: " + desc + "\nError:" + err);
                }
            });
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
                <a href="admin_home.php" style="color: #ffffff;">
                    <span class="uk-icon uk-margin-small-right" uk-icon="icon: chevron-left"
                          style="color: #ffffff;"></span>
                </a>
                <a class="uk-navbar-item uk-logo" href="index.php">Church</a>
            </div>
            <div class="uk-navbar-right">
                <a href="apis/admin_logout.php" class=" uk-button uk-button-default navbar-button">Logout</a>
            </div>
        </nav>
    </div>
</div>
<div class="uk-container">
    <h2 class="uk-margin-small">Title</h2>
    <?php
    if (isset($_SESSION["session_error"])) {
        ?>
        <div class=" red center-align" style="padding: 5px"><span class="white-text"
                                                                  id="edit_error"><?php echo $_SESSION["session_error"]; ?></span>
        </div>
        <?php
        unset($_SESSION["session_error"]);
    }
    ?>
    <form class="" id="quiz_info" method="POST" action="apis/update_quiz.php" uk-grid uk-height-match="target: > div">
        <div class="uk-width-2-3 uk-align-center uk-margin-remove-bottom">
            <input id="quizname" name="title" type="text" class="uk-input" required>
        </div>
        <input type="hidden" name="start_time" id="sdate" class="datepicker" onchange="vedit()" required>
        <input type="hidden" name="end_time" id="edate" class="datepicker" onchange="vedit()" required>
        <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>">
        <div class="uk-width-1-3">
            <input type="submit" value="Update" id="upsubmit" class="uk-button uk-button-default uk-width-1-1">
        </div>
    </form>
    <h2 class="uk-margin-remove">Category</h2>
    <form class="uk-margin-remove-bottom" method="POST" action="apis/quiz_cat.php" uk-grid>
        <div class="uk-width-1-5 uk-margin-remove-bottom ">
            <label class="uk-form-label" for="form-horizontal-text">Category 1</label>
            <input placeholder="cat1" id="c1" name="c1" type="text" class="uk-input" required>
        </div>
        <div class="uk-width-1-5 uk-margin-remove-bottom">
            <label class="uk-form-label" for="form-horizontal-text">Category 2</label>
            <input placeholder="cat2" id="c2" name="c2" type="text" class="uk-input" required>

        </div>
        <div class="uk-width-1-5 uk-margin-remove-bottom">
            <label class="uk-form-label" for="form-horizontal-text">Category 3</label>
            <input placeholder="cat3" id="c3" name="c3" type="text" class="uk-input" required>
        </div>
        <div class="uk-width-1-5 uk-margin-remove-bottom">
            <label class="uk-form-label" for="form-horizontal-text">Category 4</label>
            <input placeholder="cat4" id="c4" name="c4" type="text" class="uk-input" required>
        </div>
        <div class="uk-width-1-5 uk-margin-remove-bottom">
            <label class="uk-form-label" for="form-horizontal-text">Category 5</label>
            <input placeholder="cat5" id="c5" name="c5" type="text" class="uk-input" required>
        </div>
        <input type="hidden" name="id" value="<?php echo $_GET["id"]; ?>">
        <div class="uk-width-1-1 uk-margin-small-top">
            <input type="submit" value="Update" id="upsubmit"
                   class="uk-button uk-button-default uk-width-1-1 ">
        </div>
    </form>
    <h2 class="uk-margin-small"> Edit/Add Questions </h2>
    <div class="uk-container">
        <div class="uk-grid-small uk-child-width-expand@s uk-text-center uk-grid-margin-small" uk-grid
             uk-height-match="target: > div > .uk-card">
            <div>
                <div class="uk-card uk-card-default uk-card-body  uk-card-secondary uk-padding-remove">
                    <h3 class="uk-card-title uk-margin-small" id="ch1">Cat 1</h3>
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-default uk-card-body  uk-card-secondary uk-padding-remove ">
                    <h3 class="uk-card-title uk-margin-small" id="ch2">Cat 2</h3>
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-default uk-card-body uk-card-secondary uk-padding-remove">
                    <h3 class="uk-card-title uk-margin-small" id="ch3">Cat 3</h3></div>
            </div>
            <div>
                <div class="uk-card uk-card-default uk-card-body uk-card-secondary uk-padding-remove">
                    <h3 class="uk-card-title uk-margin-small" id="ch4">Cat 4</h3></div>
            </div>
            <div>
                <div class="uk-card uk-card-default uk-card-body uk-card-secondary uk-padding-remove">
                    <h3 class="uk-card-title uk-margin-small" id="ch5">Cat 5</h3></div>
            </div>
        </div>

        <div class="uk-grid-small uk-child-width-expand@s uk-text-center uk-margin-remove-top" uk-grid
             uk-height-match="target: > div > .uk-card">
            <div>
                <div class="uk-card uk-card-default uk-card-body   uk-padding-remove">
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(1,100);" id="1100">
                        <span class="uk-text-lead"><?php echo getpoints(1,100); ?></span>
                    </div>
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(1,200);" id="1200">
                        <span class="uk-text-lead"><?php echo getpoints(1,200); ?></span>
                    </div>
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(1,300);" id="1300">
                        <span class="uk-text-lead"><?php echo getpoints(1,300); ?></span>
                    </div>
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(1,400);" id="1400">
                        <span class="uk-text-lead"><?php echo getpoints(1,400); ?></span>
                    </div>
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(1,500);" id="1500">
                        <span class="uk-text-lead"><?php echo getpoints(1,500); ?></span>
                    </div>
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove ">
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(2,100);" id="2100">
                        <span class="uk-text-lead"><?php echo getpoints(2,100); ?></span>
                    </div>
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(2,200);" id="2200">
                        <span class="uk-text-lead"><?php echo getpoints(2,200); ?></span>
                    </div>
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(2,300);" id="2300">
                        <span class="uk-text-lead"><?php echo getpoints(2,300); ?></span>
                    </div>
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(2,400);" id="2400">
                        <span class="uk-text-lead"><?php echo getpoints(2,400); ?></span>
                    </div>
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(2,500);" id="2500">
                        <span class="uk-text-lead"><?php echo getpoints(2,500); ?></span>
                    </div>
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove">
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(3,100);" id="3100">
                        <span class="uk-text-lead"><?php echo getpoints(3,100); ?></span>
                    </div>
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(3,200);" id="3200">
                        <span class="uk-text-lead"><?php echo getpoints(3,200); ?></span>
                    </div>
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(3,300);" id="3300">
                        <span class="uk-text-lead"><?php echo getpoints(3,300); ?></span>
                    </div>
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(3,400);" id="3400">
                        <span class="uk-text-lead"><?php echo getpoints(3,400); ?></span>
                    </div>
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(3,500);" id="3500">
                        <span class="uk-text-lead"><?php echo getpoints(3,500); ?></span>
                    </div>
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-default uk-card-body  uk-padding-remove">
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(4,100);" id="4100">
                        <span class="uk-text-lead"><?php echo getpoints(4,100); ?></span>
                    </div>
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(4,200);" id="4200">
                        <span class="uk-text-lead"><?php echo getpoints(4,200); ?></span>
                    </div>
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(4,300);" id="4300">
                        <span class="uk-text-lead"><?php echo getpoints(4,300); ?></span>
                    </div>
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(4,400);" id="4400">
                        <span class="uk-text-lead"><?php echo getpoints(4,400); ?></span>
                    </div>
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(4,500);" id="4500">
                        <span class="uk-text-lead"><?php echo getpoints(4,500); ?></span>
                    </div>
                </div>
            </div>
            <div>
                <div class="uk-card uk-card-default uk-card-body y uk-padding-remove">
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(5,100);" id="5100">
                        <span class="uk-text-lead"><?php echo getpoints(5,100); ?></span>
                    </div>
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(5,200);" id="5200">
                        <span class="uk-text-lead"><?php echo getpoints(5,200); ?></span>
                    </div>
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(5,300);" id="5300">
                        <span class="uk-text-lead"><?php echo getpoints(5,300); ?></span>
                    </div>
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(5,400);" id="5400">
                        <span class="uk-text-lead"><?php echo getpoints(5,400); ?></span>
                    </div>
                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove"
                         onclick="loadquestion(5,500);" id="5500">
                        <span class="uk-text-lead"><?php echo getpoints(5,500); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modalquestionedit" class="uk-modal-container" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <h2 class="uk-modal-title">
            <span id="cat">Category:</span>
            <span id="points">Points:</span>
        </h2>
        <div class="uk-alert-danger" id="alertm" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p id="messageq"></p>
        </div>

        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">Custom Points</label>
            <div class="uk-form-controls">
                <input placeholder="Points" id="custompoints" type="text"
                       class="uk-input">
            </div>
            <label class="uk-form-label" for="form-stacked-text">Question(English)</label>
            <div class="uk-form-controls">
                <input placeholder="Sample Question in English" id="englis_quest" type="text"
                       class="uk-input">
            </div>
            <label class="uk-form-label" for="form-stacked-text">Question(Malayalam)</label>
            <div class="uk-form-controls">
                <input placeholder="Sample Question in Malayalam" id="mallu_quest" type="text"
                       class="uk-input">
            </div>
            <form class="uk-grid-small" uk-grid>
                <div class="uk-width-2-5">
                    <label class="uk-form-label" for="form-horizontal-text">Option 1 English:</label>
                    <input placeholder="Option 1 English" id="opt1" type="text" class="uk-input">
                </div>
                <div class="uk-width-2-5">
                    <label class="uk-form-label" for="form-horizontal-text">Option 1 Malayalam</label>
                    <input placeholder="Option 1 Malyalam" id="opt1_ml" type="text" class="uk-input">

                </div>
                <div class="uk-width-1-5">
                    <div class="uk-padding-small">
                        <label class="uk-form-label" for="form-horizontal-checkbox">Correct Option?</label>
                        <input type="checkbox" class="uk-checkbox" onchange="mycheck(1)" id="checkopt1"/>
                    </div>

                </div>
            </form>
            <form class="uk-grid-small" uk-grid>
                <div class="uk-width-2-5">
                    <label class="uk-form-label" for="form-horizontal-text">Option 2 English:</label>
                    <input placeholder="Option 1 English" id="opt2" type="text" class="uk-input">
                </div>
                <div class="uk-width-2-5">
                    <label class="uk-form-label" for="form-horizontal-text">Option 2 Malayalam</label>
                    <input placeholder="Option 1 Malyalam" id="opt2_ml" type="text" class="uk-input">

                </div>
                <div class="uk-width-1-5">
                    <div class="uk-padding-small">
                        <label class="uk-form-label" for="form-horizontal-checkbox">Correct Option?</label>
                        <input type="checkbox" class="uk-checkbox" onchange="mycheck(2)" id="checkopt2"/>
                    </div>

                </div>
            </form>
            <form class="uk-grid-small" uk-grid>
                <div class="uk-width-2-5">
                    <label class="uk-form-label" for="form-horizontal-text">Option 3 English:</label>
                    <input placeholder="Option 1 English" id="opt3" type="text" class="uk-input">
                </div>
                <div class="uk-width-2-5">
                    <label class="uk-form-label" for="form-horizontal-text">Option 3 Malayalam</label>
                    <input placeholder="Option 1 Malyalam" id="opt3_ml" type="text" class="uk-input">

                </div>
                <div class="uk-width-1-5">
                    <div class="uk-padding-small">
                        <label class="uk-form-label" for="form-horizontal-checkbox">Correct Option?</label>
                        <input type="checkbox" class="uk-checkbox" onchange="mycheck(3)" id="checkopt3"/>
                    </div>

                </div>
            </form>
            <form class="uk-grid-small" uk-grid>
                <div class="uk-width-2-5">
                    <label class="uk-form-label" for="form-horizontal-text">Option 4 English:</label>
                    <input placeholder="Option 1 English" id="opt4" type="text" class="uk-input">
                </div>
                <div class="uk-width-2-5">
                    <label class="uk-form-label" for="form-horizontal-text">Option 4 Malayalam</label>
                    <input placeholder="Option 1 Malyalam" id="opt4_ml" type="text" class="uk-input">

                </div>
                <div class="uk-width-1-5">
                    <div class="uk-padding-small">
                        <label class="uk-form-label" for="form-horizontal-checkbox">Correct Option?</label>
                        <input type="checkbox" class="uk-checkbox" onchange="mycheck(4)" id="checkopt4"/>
                    </div>

                </div>
            </form>
        </div>
        <p class="uk-text-right">
            <a class="uk-button uk-button-default" id="question_sub">Save</a>
        </p>

    </div>
</div>
<script>

    function mycheck(id) {
        for (var i = 0; i < 4; i++) {
            if (id != i + 1)
                $("#checkopt" + (i + 1)).prop('checked', false);
        }
    }

    function submit_question(id, cat, points) {
        var correct = 0;
        for (var i = 0; i < 4; i++) {
            if ($("#checkopt" + (i + 1)).is(':checked')) {
                correct = i + 1;
            }
        }

        var data = {
            qid: id,
            points: points,
            category: cat,
            question_en: $('#englis_quest').val(),
            question_ml: $('#mallu_quest').val(),
            option1_en: $('#opt1').val(),
            option2_en: $('#opt2').val(),
            option3_en: $('#opt3').val(),
            option4_en: $('#opt4').val(),
            option1_ml: $('#opt1_ml').val(),
            option2_ml: $('#opt2_ml').val(),
            option3_ml: $('#opt3_ml').val(),
            option4_ml: $('#opt4_ml').val(),
            custom_points: $('#custompoints').val(),
            correct: correct
        };

        /*
        if( $('#englis_quest').val() == "" || $('#mallu_quest').val() == "" || $('#opt1').val() ==""  || $('#opt2').val() =="" || $('#opt3').val() =="" || $('#opt4').val() =="" || $('#opt4_ml').val() =="" || $('#opt1_ml').val() =="" || $('#opt2_ml').val() =="" || $('#opt3_ml').val() ==""){
            Materialize.toast('Feilds cannot be empty', 4000);// 4000 is the duration of the toast
            return;
        }*/
        if (correct == 0) {
            $("#messageq").text("Select The Correct Answer");
            $("#alertm").removeClass("uk-hidden");
            return;

        }
        console.log(data);
        $.ajax({
            url: 'apis/save_question.php',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function (data, status) {
                console.log(data);
                UIkit.modal('#modalquestionedit').hide();
                //loaddata();
                window.location.reload();
            },
            error: function (xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
    }

    function loadquestion(cat, points) {
        clearmodal();
        $("#alertm").addClass("uk-hidden");
        var id = <?php echo $_GET["id"]; ?>;
        var data = {
            "qid": id,
            "cat": cat,
            "points": points
        }
        $.ajax({
            url: 'apis/load_question.php',
            type: 'POST',
            data: data,
            dataType: 'json',
            success: function (data, status) {
                console.log(data);

                UIkit.modal("#modalquestionedit").show();

                console.log(cat);
                $("#cat").text("Category:" + cat);
                $("#points").html("&nbsp;&nbsp; Original Points:" + points);

                if (data.new_question == null) {
                    $("#englis_quest").val(data.question.english);
                    $("#mallu_quest").val(data.question.malyalam);
                    $("#custompoints").val(data.question.custom_points);
                    for (var i = 0; i < data.options.length; i++) {
                        $("#opt" + (i + 1) + "_ml").val(data.options[i].option_text_ml);
                        $("#opt" + (i + 1)).val(data.options[i].option_text);
                        if (data.options[i].correct == 1) {
                            $("#checkopt" + (i + 1)).prop('checked', true);
                        }
                    }
                }
                else {
                    $("#custompoints").val(points);
                }

                document.getElementById("question_sub").onclick = function () {
                    submit_question(id, cat, points);
                }


            },
            error: function (xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
    }

    function clearmodal() {
        $("#englis_quest").val("");
        $("#mallu_quest").val("");
        for (var i = 0; i < 4; i++) {
            $("#opt" + (i + 1) + "_ml").val("");
            $("#opt" + (i + 1)).val("");
            $("#checkopt" + (i + 1)).prop('checked', false);
        }
    }
</script>

</body>
</html>


<?php

function getpoints($cat,$points){
    include "include/db.php";
    $quiz = $_GET["id"];
    $sql = "select custom_points from questions where category =". $cat ." and points = ". $points ." and quiz_id =". $quiz;
    $result = $conn->query($sql);
    if($row = $result->fetch_assoc()){
        return $row["custom_points"];
    }
    else{
        return $points;
    }

}

?>