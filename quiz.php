<?php

session_start();
if (!isset($_SESSION["username"]) || !isset($_SESSION["user_id"]) || !isset($_SESSION["emailid"])) { // this means the user session is set
    header("Location: login.php");
}

if (!isset($_GET["id"])) {
    header("Location: home.php");
}

include "include/db.php";
$id = $_GET["id"];
$current_date = date("Y-m-d");   // current date

$sql = "select curr_chance from quiz where id  = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$curr = $row["curr_chance"];
$sql = "select * from quiz_participants where id = $curr";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$team = $row["team_name"];
$_SESSION["team_id"] = $row["id"];
$sql = "select * from quiz where id= $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$qtitle = $row["title"];
$sql = "select * from doubletable where userid = $curr";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$dd = $row["dd_flag"];
$dj = $row["dj_flag"];
$_SESSION["quiz_id"] = $id;

?>
<!DOCTYPE html>
<html>
<head>
    <link href="css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="css/uikit.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

    <link type="text/css" rel="stylesheet" href="css/customgrid.css"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body onload="formgrid(<?php echo $_GET["id"] ?>)">
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/uikit.min.js"></script>
<script type="text/javascript" src="js/uikit-icons.min.js"></script>
<script type="text/javascript" src="js/question.js"></script>

<script type="text/javascript" src="js/materialize.min.js"></script>
<script src="js/soundmanager2.js"></script>

<script>
    var mainid = <?php echo $_GET["id"]?>;

    function insertans(q, p) {
        var sdata = {quest_id: q, points: p, qid: mainid};
        $.ajax({
            url: 'apis/submit_answer.php',
            type: 'POST',
            data: sdata,
            dataType: 'json',
            success: function (data, status) {
                console.log(data);
                $('#your_points').text("Your Points:" + data.points);
                refresh();
            },
            error: function (xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
    }

    function insertans2(q, p, tid, quest) {
        var sdata = {quest_id: q, points: p, qid: mainid, tid: tid, quest: quest};
        $.ajax({
            url: 'apis/submit_answer2.php',
            type: 'POST',
            data: sdata,
            dataType: 'json',
            success: function (data, status) {
                console.log(data);
                $('#your_points').text("Your Points:" + data.points);
                refresh();
            },
            error: function (xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
    }


    $(document).ready(function () {
        // the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
        refresh();

    });

    function submit3(uid, qid) {
        $("#s3qtxt").val(qid);
        $("#s3utxt").val(uid);
        UIkit.modal("#submit3modal").show();
    }


    function refresh() {
        id =<?php echo $_GET["id"];?>;
        myuser = "<?php echo $team;?>";
        console.log(myuser);
        data = {
            "id": id
        };
        $.ajax({
            url: 'apis/quiz_leaderboard.php',
            type: 'GET',
            data: data,
            success: function (data, status) {
                console.log(data);

                $("#leaderboard tbody >tr").remove();
                $("#leaderboard tbody").append(
                    "<tr >"
                    + "<th> Rank </th>"
                    + "<th>  Team Name </th>"
                    + "<th>  Points </th>"
                    + "</tr>");
                var iterations = Math.min(data.leaderboard.length, 5);
                for (var i = 0; i < iterations; i++) {

                    if (data.leaderboard[i].team_name == myuser) {
                        markup = "<div class=\"uk-card uk-card-default uk-card-primary uk-padding-small uk-card-body \">\n" +
                            "<h3 class=\"uk-card-title uk-margin-remove\">" + data.leaderboard[i].team_name + "</h3>\n" +
                            "<h3 class='uk-margin-remove'>" + data.leaderboard[i].points + "</h3>\n" +
                            "<a class='uk-button uk-button-default' onclick='submit3(" +
                            data.leaderboard[i].uid +
                            "," + data.leaderboard[i].qid +
                            ")'>Add/Remove Points</a>" +
                            "</div>";

                    }
                    else {
                        markup = "<div class=\"uk-card uk-card-default uk-card-body uk-padding-small \">\n" +
                            "<h3 class=\"uk-card-title uk-margin-remove\">" + data.leaderboard[i].team_name + "</h3>\n" +
                            "<h3 class='uk-margin-remove'>" + data.leaderboard[i].points + "</h3>\n" +
                            "<a class='uk-button uk-button-default' onclick='submit3(" +
                            data.leaderboard[i].uid +
                            "," + data.leaderboard[i].qid +
                            ")'>Add/Remove Points</a>" +
                            "</div>";
                    }
                    $("#leaderboard").append(markup);

                }
                if (data.leaderboard.length < 5) {
                    $("#5500").hide();
                }

            },
            error: function (xhr, desc, err) {
                console.log(xhr);
                console.log("Details: " + desc + "\nError:" + err);
            }
        });
    }

    var onModalHide = function () {
        console.log("modal hide");
        //location.reload();
    };


</script>

<div uk-sticky="media: 960" class="uk-navbar-container tm-navbar-container uk-sticky" style="">
    <div class="uk-container uk-container-expand">
        <nav class="uk-navbar-container " uk-navbar>
            <div class="uk-navbar-left">
                <a href="home.php" style="color: #ffffff;">
                    <span class="uk-icon uk-margin-small-right" uk-icon="icon: chevron-left"
                          style="color: #ffffff;"></span>
                </a>
                <a class="uk-navbar-item uk-logo" href="index.php">Church</a>
            </div>
            <div class="uk-navbar-right">
                <a href="apis/logout.php" class=" uk-button uk-button-default navbar-button">Logout</a>
            </div>
        </nav>
    </div>
</div>
<?php
/*
<div class=" orange white-text center-align" style="padding: 10px">
    <div class="col s12">
        <h5>Current Team : <?php echo $team; ?></h5>
    </div>
</div>
*/
?>
<br>
<div class="uk-container ">
    <div class="uk-margin-remove-bottom" uk-grid>
        <div class="uk-width-1-2 uk-margin-remove-bottom"><h4
                    class="uk-text-lead uk-margin-remove-bottom"><?php echo $qtitle; ?></h4></div>
        <div class="uk-width-1-2 uk-margin-remove-bottom">
            <?php
            if ($dd != 0) {
                ?>
                <button class="uk-button uk-button-default uk-margin-remove-bottom uk-disabled uk-align-right doublered"
                        id="dailydoublebtn">Use Daily Double
                </button>

                <?php
            } else { ?>
                <button class="uk-button uk-button-default uk-margin-remove-bottom uk-align-right doublegreen"
                        id="dailydoublebtn" onclick="dailyteam(<?php echo $curr; ?>)">Use Daily Double
                </button>
                <?php
            }
            if ($dj != 0) {
                ?>
                <button class="uk-button uk-button-default uk-margin-remove-bottom uk-disabled uk-align-right doublered"
                        id="dailydoublebtn">Use Double Jeopardy
                </button>
            <?php } else { ?>
                <button class="uk-button uk-button-default uk-margin-remove-bottom uk-align-right doublegreen"
                        id="doublejeopardybtn" onclick="jeopardyteam(<?php echo $curr; ?>)">Use Double Jeopardy
                </button>
            <?php } ?>
        </div>
    </div>
    <div class="uk-grid-small uk-child-width-expand@s uk-text-center " uk-grid
         uk-height-match="target: > div > .uk-card">
        <div>
            <div class="uk-card uk-card-default uk-card-body  uk-card-secondary uk-padding-remove">
                <h3 class="uk-card-title uk-margin-small uk-text-break" id="cn1">Cat 1</h3>
            </div>
        </div>
        <div>
            <div class="uk-card uk-card-default uk-card-body  uk-card-secondary uk-padding-remove">
                <h3 class="uk-card-title uk-margin-small uk-text-break" id="cn2">Cat 2</h3>
            </div>
        </div>
        <div>
            <div class="uk-card uk-card-default uk-card-body uk-card-secondary uk-padding-remove">
                <h3 class="uk-card-title uk-margin-small uk-text-break" id="cn3">Cat 3</h3></div>
        </div>
        <div>
            <div class="uk-card uk-card-default uk-card-body uk-card-secondary uk-padding-remove">
                <h3 class="uk-card-title uk-margin-small uk-text-break" id="cn4">Cat 4</h3></div>
        </div>
        <div>
            <div class="uk-card uk-card-default uk-card-body uk-card-secondary uk-padding-remove">
                <h3 class="uk-card-title uk-margin-small uk-text-break" id="cn5">Cat 5</h3></div>
        </div>
    </div>

    <div class="uk-grid-small uk-child-width-expand@s uk-text-center uk-margin-remove-top" uk-grid
         uk-height-match="target: > div > .uk-card">
        <div>
            <div class="uk-card uk-card-default uk-card-body   uk-padding-remove">
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,1,100);" id="1100">
                    <span class="uk-text-lead"><?php echo getpoints(1,100); ?></span>
                </div>
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,1,200);" id="1200">
                    <span class="uk-text-lead"><?php echo getpoints(1,200); ?></span>
                </div>
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,1,300);" id="1300">
                    <span class="uk-text-lead"><?php echo getpoints(1,300); ?></span>
                </div>
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,1,400);" id="1400">
                    <span class="uk-text-lead"><?php echo getpoints(1,400); ?></span>
                </div>
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,1,500);" id="1500">
                    <span class="uk-text-lead"><?php echo getpoints(1,500); ?></span>
                </div>
            </div>
        </div>
        <div>
            <div class="uk-card uk-card-default uk-card-body uk-padding-remove ">
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,2,100);" id="2100">
                    <span class="uk-text-lead"><?php echo getpoints(2,100); ?></span>
                </div>
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,2,200);" id="2200">
                    <span class="uk-text-lead"><?php echo getpoints(2,200); ?></span>
                </div>
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,2,300);" id="2300">
                    <span class="uk-text-lead"><?php echo getpoints(2,300); ?></span>
                </div>
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,2,400);" id="2400">
                    <span class="uk-text-lead"><?php echo getpoints(2,400); ?></span>
                </div>
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,2,500);" id="2500">
                    <span class="uk-text-lead"><?php echo getpoints(2,500); ?></span>
                </div>
            </div>
        </div>
        <div>
            <div class="uk-card uk-card-default uk-card-body uk-padding-remove">
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,3,100);" id="3100">
                    <span class="uk-text-lead"><?php echo getpoints(3,100); ?></span>
                </div>
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,3,200);" id="3200">
                    <span class="uk-text-lead"><?php echo getpoints(3,200); ?></span>
                </div>
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,3,300);" id="3300">
                    <span class="uk-text-lead"><?php echo getpoints(3,300); ?></span>
                </div>
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,3,400);" id="3400">
                    <span class="uk-text-lead"><?php echo getpoints(3,400); ?></span>
                </div>
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,3,500);" id="3500">
                    <span class="uk-text-lead"><?php echo getpoints(3,500); ?></span>
                </div>
            </div>
        </div>
        <div>
            <div class="uk-card uk-card-default uk-card-body  uk-padding-remove">
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,4,100);" id="4100">
                    <span class="uk-text-lead"><?php echo getpoints(4,100); ?></span>
                </div>
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,4,200);" id="4200">
                    <span class="uk-text-lead"><?php echo getpoints(4,200); ?></span>
                </div>
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,4,300);" id="4300">
                    <span class="uk-text-lead"><?php echo getpoints(4,300); ?></span>
                </div>
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,4,400);" id="4400">
                    <span class="uk-text-lead"><?php echo getpoints(4,400); ?></span>
                </div>
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,4,500);" id="4500">
                    <span class="uk-text-lead"><?php echo getpoints(4,500); ?></span>
                </div>
            </div>
        </div>
        <div>
            <div class="uk-card uk-card-default uk-card-body y uk-padding-remove">
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,5,100);" id="5100">
                    <span class="uk-text-lead"><?php echo getpoints(5,100); ?></span>
                </div>
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,5,200);" id="5200">
                    <span class="uk-text-lead"><?php echo getpoints(5,200); ?></span>
                </div>
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,5,300);" id="5300">
                    <span class="uk-text-lead"><?php echo getpoints(5,300); ?></span>
                </div>
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,5,400);" id="5400">
                    <span class="uk-text-lead"><?php echo getpoints(5,400); ?></span>
                </div>
                <div class="uk-card uk-card-default uk-card-body uk-padding-remove gridcell"
                     onclick="loadquestions(<?php echo $_GET["id"] ?>,5,500);" id="5500">
                    <span class="uk-text-lead"><?php echo getpoints(5,500); ?></span>
                </div>
            </div>
        </div>
    </div>

    <h4 class="uk-text-lead uk-margin-small">Scores</h4>

    <div class="uk-grid-small uk-child-width-expand@s uk-text-center" id="leaderboard" uk-grid>
    </div>
</div>

<div id="modal1" class="uk-modal-full" uk-modal>
    <div class="uk-modal-dialog" style="height: 100%">
        <button class="uk-modal-close-full uk-close-large" type="button" onclick="cleartimer()" uk-close></button>
        <div class="uk-card uk-card-default uk-card-primary uk-card-body ">
            <p class="uk-text-large infotxt" id="question_info"></p>
            <p class="uk-text-lead questiontxt" id="question_en">Loading</p>
            <p class="uk-text-lead questiontxt" id="question_ml">Loading</p>
        </div>
        <div id="opbutton">
            <a class="uk-width-1-1 uk-button uk-button-default" id="showoptionbtn" onclick="showoptions()">Show
                Options</a>
        </div>
        <div class="uk-alert-success" id="correctalert" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p id="salertext">Congratulations! you have selected the correct answer.</p>
        </div>
        <div class="uk-alert-danger" id="incorrectalert" uk-alert>
            <a class="uk-alert-close" uk-close></a>
            <p id="ealertext">Sorry Wrong answer selected.</p>
        </div>
        <div class="uk-container uk-margin">
            <form id="optionform">
                <ul class="uk-list uk-list-divider" id="option">
                    <li id="ol0"><input name="group1" type="radio" id="test1" value="0"/>
                        <label id="op0" class="options" for="test1">Loading</label>
                        <i id="oc0" class="material-icons">close</i>
                    </li>
                    <li id="ol1"><input name="group1" type="radio" id="test2" value="1"/>
                        <label id="op1" class="options" for="test2">Loading</label>
                        <i id="oc1" class="material-icons">close</i>
                    </li>
                    <li id="ol2"><input name="group1" type="radio" id="test3" value="2"/>
                        <label id="op2" class="options" for="test3">Loading</label>
                        <i id="oc2" class="material-icons">close</i>
                    </li>
                    <li id="ol3">
                        <input name="group1" type="radio" id="test4" value="3"/>
                        <label id="op3" class="options" for="test4">Loading</label>
                        <i id="oc3" class="material-icons">close</i>
                    </li>
                </ul>
            </form>
            <div id="multiselect">
                <p>Select teams which gave correct answers</p>
                <div class="uk-flex uk-flex-center uk-margin" id="passonusers" uk-grid>

                </div>
                <a class="uk-button uk-button-default uk-width-1-1" id="finish2" onclick="submitandfinish()">Finish
                    Round</a>
            </div>

            <a class="uk-button uk-button-default uk-width-1-1" id="passon_btn" onclick="passonround()">Start Passon
                Round</a>
            <a class="uk-button uk-button-default uk-width-1-1" id="passonsubmitbtn" onclick="passsubmit()">End Timer
                and submit</a>
            <a class="uk-button uk-button-default uk-width-1-1" id="finish_btn" onclick="reloadpage()">Finish</a>
            <div class="uk-align-right">
                <a class="uk-button uk-button-default" id="submit_btn" onclick="submitbtn1()">Submit Answer</a>
            </div>
        </div>


        <!--
        <div class="modal1-content">
            <div class="row">
                <div class="col s6">

                </div>
                <div class="col s6 right-align">
                </div>
            </div>
            <div id="passtest" class="  orange white-text center-align " style="padding: 10px;">
                <h5>Pass On Round</h5>
            </div>
            <div class="  indigo white-text" style="padding: 5px;">
            </div>

            <div>
                <form id="myForm">

                </form>
            </div>
            <div id="passonbtn">
                <button class="btn" onclick="showsecondoptions()">Start Pass On Round</button>
            </div>

        </div>
        <div id="pteams" class="center-align">
            <div class="row">
                <p>Select The teams which gave the correct answer</p>
                <div class="col s3">
                    <input type="checkbox" id="cteam1"/>
                    <label id="cteam1l" for="cteam1">Team 1</label>
                </div>
                <div class="col s3">
                    <input type="checkbox" id="cteam2"/>
                    <label id="cteam2l" for="cteam2">Team 1</label>
                </div>
                <div class="col s3">
                    <input type="checkbox" id="cteam3"/>
                    <label id="cteam3l" for="cteam3">Team 1</label>
                </div>
                <div class="col s3">
                    <input type="checkbox" id="cteam4"/>
                    <label id="cteam4l" for="cteam4">Team 1</label>
                </div>
            </div>
        </div>-->
        <div class="uk-container">
            <progress id="qtimerbar" class="uk-progress"></progress>
            <p><span id="qtimer"></span></p>
        </div>
    </div>
</div>


<div id="modaldd" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

        <button class="uk-modal-close-default" type="button" uk-close></button>

        <h2 class="uk-modal-title">Enter Wager</h2>
        <p>The wager should not exceed <span id="ddmax"></span></p>
        <p>
        <div class="uk-margin">
            <input class="uk-input" type="number" placeholder="Wager" id="dd_wagertxt">
        </div>
        </p>
        <p>
            <a class="uk-button uk-button-default uk-width-1-1" type="button" onclick="ddsubmit()">Submit</a>
        </p>

    </div>
</div>

<div id="modaldj" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

        <button class="uk-modal-close-default" type="button" uk-close></button>

        <h2 class="uk-modal-title">Enter Wager</h2>
        <p>The wager should not exceed <span id="djmax"></span></p>
        <p>
        <div class="uk-margin">
            <input class="uk-input" type="number " placeholder="Wager" id="dj_wagertxt">
        </div>
        </p>
        <p>
            <a class="uk-button uk-button-default uk-width-1-1" type="button" onclick="djsubmit()">Submit</a>
        </p>
    </div>
</div>

<div id="submit3modal" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

        <button class="uk-modal-close-default" type="button" uk-close></button>

        <h2 class="uk-modal-title">Enter points to add or remove (for removing enter negative points)</h2>
        <p>
        <div class="uk-margin">
            <form method="POST" action="apis/submitanswer3.php">
                <input type="hidden" name="s3qtxt" id="s3qtxt">
                <input type="hidden" name="s3utxt" id="s3utxt">
                <input class="uk-input" type="number " placeholder="Points" name="s3ptxt">
                <input class="uk-button uk-margin uk-button-default uk-width-1-1" value="Submit" type="submit">
            </form>
        </div>
        </p>
        <p>
        </p>
    </div>
</div>
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