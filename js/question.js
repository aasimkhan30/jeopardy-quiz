/*Some documentation


Use Jquery AJAX only

Demo call
This sends a post request to load_quiz.php

 $.ajax({
        url: 'apis/load_quiz.php',
        type: 'POST',
        data: {quiz_id: q},
        dataType: 'json',
        success: function (data, status) {
        },
        error: function (xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });



*/





var over;
var correct;
var timer;
var counter;
var category;
var maxpoints;
var question_id;
var user_id;
var totalpoint;
var round = 0;
var bar;
var players;
var current;


function formgrid(q) {
    bar = document.getElementById('qtimerbar');
    console.log("Form Grid Called " + q);
    backgroundsound();
    $.ajax({
        url: 'apis/load_quiz.php',
        type: 'POST',
        data: {quiz_id: q},
        dataType: 'json',
        success: function (data, status) {
            console.log(data);
            $("#cn1").text(data.qd.c1);
            $("#cn2").text(data.qd.c2);
            $("#cn3").text(data.qd.c3);
            $("#cn4").text(data.qd.c4);
            $("#cn5").text(data.qd.c5);
            for (i = 0; i < data.questions.length; i++) {
                cat = data.questions[i].category;
                poi = data.questions[i].points;
                $('#' + (parseInt(cat * 1000) + parseInt(poi))).addClass('uk-card-primary');
            }
        },
        error: function (xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });

}


function dailyteam() {
    $.ajax({
        url: 'apis/load_daily.php',
        type: 'POST',
        data:  null,
        dataType: 'json',
        success: function (data, status) {
            console.log(data);
            $("#dd_wagertxt").attr({
                "max" : data.total,        // substitute your own
                "min" : 1         // values (or variables) here
            });
            $("#ddmax").text(data.total);
            UIkit.modal("#modaldd").show();
        },
        error: function (xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });

}

function jeopardyteam() {
    $.ajax({
        url: 'apis/load_djeopardy.php',
        type: 'POST',
        data:  null,
        dataType: 'json',
        success: function (data, status) {
            console.log(data);
            $("#dj_wagertxt").attr({
                "max" : data.total,        // substitute your own
                "min" : 1         // values (or variables) here
            });
            $("#djmax").text(data.total);
            UIkit.modal("#modaldj").show();
        },
        error: function (xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });

}

function ddsubmit() {
    dwager = $("#dd_wagertxt").val();
    $.ajax({
        url: 'apis/submit_ddouble.php',
        type: 'POST',
        data:  {wager: dwager},
        dataType: 'json',
        success: function (data, status) {
            console.log(data);
            UIkit.modal("#modaldd").hide();
            $("#dailydoublebtn").attr("disabled", "disabled");
            $("#dailydoublebtn").removeClass("doublegreen").addClass("doublered");
        },
        error: function (xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });
}


function djsubmit() {
    dwager = $("#dj_wagertxt").val();
    $.ajax({
        url: 'apis/submit_jeopardy.php',
        type: 'POST',
        data:  {wager: dwager},
        dataType: 'json',
        success: function (data, status) {
            console.log(data);
            UIkit.modal("#modaldj").hide();
            $("#doublejeopardybtn").attr("disabled", "disabled");
            $("#doublejeopardybtn").removeClass("doublegreen").addClass("doublered");
        },
        error: function (xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });
}

function loadquestions(quiz,cat,points){
    $("#submit_btn").hide();
    $("#correctalert").hide();
    $("#incorrectalert").hide();
    $("#passon_btn").hide();
    $("#qtimerbar").hide();
    $("#qtimer").hide();
    $("#finish_btn").hide();
    $("#passonsubmitbtn").hide();
    $("#multiselect").hide();
    $("#passonusers").empty();
    loadplayers();
    var qdata = {"category": cat, "point": points, "quiz_id": quiz};
    $.ajax({
        url: 'apis/get_question.php',
        type: 'GET',
        data: qdata,
        dataType: 'json',
        success: function (data, status) {
            question_id = data.question.id;
            console.log("Displaying Question information");
            console.log(data);
            $("#question_en").text(data.question.english + " ?");
            $("#question_ml").text(data.question.malyalam + " ?");
            $('#question_info').html("Cateogry: " + cat + "&nbsp;&nbsp;&nbsp; Points: " + data.question.custom_points);// setting question information from the parameters passed
            maxpoints = data.question.custom_points;
            if (data.answers == null) { // no one has answered the question;

                $("#showoptionbtn").show(); // hiding showoptions then and directly showing options
                $("#option").hide();

                for (i = 0; i < 4; i++) {
                    $("#op" + i).html(data.options[i].eng + " ( " + data.options[i].ml + " )");
                    $("#oc" + i).hide();
                    $("#op" + i).css('color', 'black');
                    if (data.options[i].corr == "1") {
                        correct = i;
                        console.log("Correct = "+correct);
                        $("#oc" + i).text("done");


                    }
                }


            }
            else {                 // someone did answer the question
                for (i = 0; i < 4; i++) {

                    $("#showoptionbtn").hide(); // hiding showoptions then and directly showing options
                    $("#option").show();
                    $("#op" + i).html(data.options[i].eng + " ( " + data.options[i].ml + " )");
                    $("#op" + i).css('color', 'black');
                    // $("#oc" + i).hide();
                    if (data.options[i].corr == "1") {
                        $("#oc" + i).text("done");
                    }
                }

            }
            UIkit.modal("#modal1").show();
        }
    });
}


function showoptions() {

    $("#option").show();
    $("#submit_btn").show();
    $("#showoptionbtn").hide();
    round = 1;
    starttimer(60);
}

function passonround() {
    $("#passon_btn").hide();
    round = 2;
    starttimer(20);
    $("#passonsubmitbtn").show();
}



function questTimer()
{
    $("#qtimer").text(timer);
    bar.value--;
    timer--;
    if(timer<0)
    {
        cleartimer();
        if(round == 1)
        {
            showerroralert("Sorry, Timeout");
            preparesecondround(1);
        }
        if(round == 2)
        {
            passsubmit();
        }
    }
}

function passsubmit() {
    cleartimer();
    $("#qtimer").hide();
    $("#qtimerbar").hide();
    $("#passonsubmitbtn").hide();
    $("#incorrectalert").hide();
    $("#multiselect").show();
    for(i = 0 ; i < 4; i++){
        if(i!=correct){
            $("#op" + i).hide();
            $("#oc" + i).hide();
            $("#ol" + i).hide();
        }

    }
    $("#op" + correct).css('color', 'green');
    $("#oc" + correct).show();
}

function preparesecondround(src)
{
    wrongsound();
    $("#submit_btn").hide();
    $("#qtimer").hide();
    $("#qtimerbar").hide();
    $("#passon_btn").show();
    console.log("Reducing Points by half")
    maxpoints = maxpoints/2;
    submit_answer(current,0,question_id);
    if(src == 1)
    {


    }
    if(src == 2)
    {

    }
}

function starttimer(time) {
    timer = time;
    counter = setInterval(questTimer, 1000);
    $("#qtimerbar").show();
    $("#qtimer").show();
    bar.value = time;
    bar.max = time;
    $("#qtimer").text(timer);
}


function cleartimer() {
    if(counter != null)
    {
        clearInterval(counter);
    }
}

function showerroralert(str) {
    $("#ealertext").text(str);
    $("#incorrectalert").show();
}

function showsrroralert(str) {
    $("#salertext").text(str);
    $("#correctalert").show();
}


function loadplayers(){
    $.ajax({
        url: 'apis/load_players.php',
        type: 'POST',
        data: null,
        dataType: 'json',
        success: function (data, status) {
            players = data;
            for(i = 0 ; i < players.length ; i++){
                if(players[i].curr == 1){
                    current = players[i].id;
                }
                else{
                    markup = "<div class=\"uk-card uk-card-default uk-margin-left uk-card-primary uk-padding-small uk-card-body \">\n" +
                        "<h3 class=\"uk-card-title uk-margin-remove\">"  + "</h3>\n" +
                        " <label style='font-size: 30px; font-weight: 100; color:#fff'><input class=\"uk-checkbox\" type=\"checkbox\" teamid='"+players[i].id+"'> "
                        +players[i].team_name+" </label>\n"+
                        "</div>";
                    $("#passonusers").append(markup);
                }


            }
            console.log(players);

        },
        error: function (xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });

}


function submitandfinish() {
    var selected = [];
    $('#multiselect input:checked').each(function() {
        selected.push($(this).attr('teamid'));
    });

    for(i = 0 ;i < selected.length ;i++)
    {
        submitanswer(selected[i],maxpoints,question_id);
    }
    submitanswer(current,0,question_id);
}


function wrongsound() {
    soundManager.setup({
        preferFlash: false,
        onready: function () {
            // Ready to use; soundManager.createSound() etc. can now be called.
        }
    });
    soundManager.createSound({
        id: 'mySound',
        url: 'resources/fail.mp3',
        autoLoad: true,
        autoPlay: true,
        onload: function () {
        },
        volume: 50
    });
}

function corresctsound() {
    soundManager.setup({
        preferFlash: false,
        onready: function () {
            // Ready to use; soundManager.createSound() etc. can now be called.
        }
    });
    soundManager.createSound({
        id: 'mySound',
        url: 'resources/tada.mp3',
        autoLoad: true,
        autoPlay: true,
        onload: function () {
        },
        volume: 50
    });
}

function backgroundsound(){
    soundManager.setup({
        preferFlash: false,
        onready: function () {
            // Ready to use; soundManager.createSound() etc. can now be called.
        }
    });
    soundManager.createSound({
        id: 'backsound',
        url: 'resources/back.mp3',
        autoLoad: true,
        autoPlay: false,
        onload: function () {
        },
        volume: 50
    });
    soundManager.play('backsound', { loops: Infinity });
}

function submitbtn1() {
    console.log("Submit button Clicked");
    var userans = $('input[name="group1"]:checked', '#optionform').val();
    console.log("User answer is" + userans);
    cleartimer();
    $("#qtimerbar").hide();
    $("#qtimer").hide();
    $("#submit_btn").hide();
    if(userans == correct)
    {
        submitanswer(current,maxpoints,question_id);
        $("#finish_btn").show();
        showsrroralert("Congratulations! you have selected the correct answer.");
        corresctsound();
        $("#op" + userans).css('color', 'green');
        $("#oc" + userans).show();
        $("op" + userans).attr('disabled', true);
    }
    else{
        showerroralert("Sorry, wrong answer");
        $("#op" + userans).css('color', 'red');
        $("#oc" + userans).show();
        $("op" + userans).attr('disabled', true);
        preparesecondround(2);

    }
}

function submitanswer(tida,pointsa,questa) {
    console.log(current);
    qdata = {tid: tida, points: pointsa, quest:questa};
    console.log(qdata);
    $.ajax({
        url: 'apis/submit_answer2.php',
        type: 'POST',
        data: qdata,
        dataType: 'json',
        success: function (data, status) {
            console.log(data);
            if(tida == current && round == 2){
                setTimeout(function() { reloadpage(); }, 2000);
            }
        },
        error: function (xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });
}

function reloadpage() {
    window.location.reload();
}
/*

function loadquestions(quiz, cat, points) {




}


function showoptions() {
    $("#opbutton").hide();
    $('#submit_btn').show();
    $("#option").show();
    $("#qtimer").show();
    $("#qtimerbar").show();
    timer = 60;
    bar.max = 60;
    bar.value = 60;
    $('#qtimer').text(timer);
    counter = setInterval(myTimer, 10000);
}

function submitanswer() {
    var useran = $('input[name="group1"]:checked', '#myForm').val(); //getting selected answer
    if (useran != null) {
        if (useran == correct) {
            clearInterval(counter);
            $("#op" + useran).css('color', 'green');
            $("#oc0").show();
            $("#oc1").show();
            $("#oc2").show();
            $("#oc3").show();


            correctans();
        }
        else {
            $("op" + useran).attr('disabled', true);
            $("#oc" + useran).show();
            maxpoints = 0.5 * maxpoints;
            $("#modal_btn").html("CLOSE");
            timer = 0;
            clearInterval(counter);
            soundManager.setup({
                preferFlash: false,
                onready: function () {
                    // Ready to use; soundManager.createSound() etc. can now be called.
                }
            });
            soundManager.createSound({
                id: 'mySound',
                url: 'resources/fail.mp3',
                autoLoad: true,
                autoPlay: true,
                onload: function () {
                },
                volume: 50
            });

            showpassonbutton();

            $("#op" + useran).css('color', 'red');
            $('#qtimer').text(timer);
            $('input[type=radio][name="group1"][value=' + useran + ']').prop('disabled', true);
            $('input[type=radio][name="group1"][value=' + useran + ']').prop('checked', false);
            showpassonbutton("#op" + useran);

        }
        console.log($('input[name="group1"]:checked', '#myForm').val());
    }
    else {
        console.log("No ans selected");
    }
}




function myTimer() {
    timer--;
    $('#qtimer').text(timer);
    bar.value--;
    if (timer <= 0) {
        if (passon == 0) {  //Timeout has occured with passon not started
            wrongsound();
            endfirstround(1);
            $('#qtimer').text(timer);
            showpassonbutton("#op" + useran);
        }
        else {
            endpassonround();
            over = 1;
            $("#oc0").show();
            $("#oc1").show();
            $("#oc2").show();
            $("#oc3").show();
            clearInterval(counter);
            endtimer();
            $("#submit_btn").html("Submit And Close");
        }

    }
}

function endfirstround(i) {

    maxpoints = 0.5 * maxpoints;//reducing points by half
    timer = 0; //reseting timer
    clearInterval(counter); //clearing interval
    if (i == 1) { //timeout occured

    }
    if (i == 2) { //user gave wrong answer

    }
}


function correctanswer(){
    $('#your_points').text("Your Points:" + maxpoints);
    over = 1;
    $('input[type=radio][name="group1"]').prop('disabled', true);
    console.log(category + "" + totalpoint);
    console.log(parseInt(category) * 1000 + parseInt(totalpoint));
    $('#' + (category * 1000 + totalpoint)).removeClass('blue-grey').addClass('green');
    insertans(question_id, maxpoints)

}





/*


function loadquestions(quiz, cat, points) {

    maxpoints = points;
    over = 0;
    category = cat;
    totalpoint = points;
    //console.log("CALLED THE FUNCTION");

    //$('#modal1').modal('open');
    $('#submit_btn').text('SUBMIT');
    $('input[type=radio][name="group1"]').prop('disabled', true);

    for (i = 0; i < 4; i++) {
        $("#op" + i).css('color', ' black');
        $("#op" + i).text('Loading');
        $('input[type=radio][name="group1"][value=' + i + ']').prop('checked', false);


    }
    $('#your_points').text("Your Points: Loading");

    $("#question_en").text('Loading');
    $("#question_ml").text('Loading');

    var qdata = {"category": cat, "point": points, "quiz_id": quiz};
    over = 0;
    $.ajax({
        url: 'apis/get_question.php',
        type: 'GET',
        data: qdata,
        dataType: 'json',
        success: function (data, status) {
            console.log(data);
            loadpteam(quiz);
            if (data.success == 1) {
                question_id = data.question.id;
                $('input[type=radio][name="group1"]').prop('disabled', false);
                $("#question_en").text(data.question.english + " ?");
                $("#question_ml").text(data.question.malyalam + " ?");
                for (i = 0; i < data.options.length; i++) {
                    $("#op" + i).html(data.options[i].eng + " ( " + data.options[i].ml + " )");
                    var theDiv = $("#op" + i).data('op_no', i);
                    $("#op" + i).css('color', ' black');
                    if (data.options[i].corr == "1") {
                        correct = i;
                        $("#oc" + i).text("done");
                    }

                }

                if (data.answers != null) {

                    if (data.multiple == 0) {
                        $('#your_points').text("Your Points:" + data.answers.points);
                        $('#qtimer').text("Correct Answer :" + data.team.team_name);
                    }
                    else {
                        $('#your_points').text("Your Points:" + (parseInt(data.answers.points) / 2));
                        $('#qtimer').text("Correct Answer :" + " Passed to Other Teams");

                    }
                    $("#qtimer").css("font-size", "20px");
                    $("#op" + correct).css('color', 'green');
                    $('#submit_btn').text('CLOSE');
                    $('input[type=radio][name="group1"]').prop('disabled', true);
                    over = 1;
                    console.log("Trying to hide to buttons");
                    $('input[type=radio][name="group1"][value=' + correct + ']').prop('checked', true);
                    $("#opbutton").hide();
                    $("#passonbtn").hide();
                    $("#passtest").hide();
                    $("#pteams").hide();

                }
                else {
                    $("#qtimer").css("font-size", "75px");

                    $("#oc0").hide();
                    $("#oc1").hide();
                    $("#oc2").hide();
                    $("#oc3").hide();
                    console.log("This Called");
                    $("#opbutton").show();
                    $("#option").hide();
                    $("#passonbtn").hide();
                    $("#passtest").hide();
                    $("#pteams").hide();


                }


            }
            else {

                timer = 10;
                $('#qtimer').text(timer);
                $('#submit_btn').text('CLOSE');
                $('#submit_btn').insertans2click(function () {
                    location.reload();
                });
                $('input[type=radio][name="group1"]').prop('disabled', true);
                over = 1;
            }
        },
        error: function (xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });


}



function passonsubmit() {
    console.log("passon called");
    for (i = 1; i < 5; i++) {
        if ($("#cteam" + i).is(':checked')) {
            console.log("Team" + i + "selected")
            tid = $("#cteam" + i).attr("tid");
            insertans2(question_id, maxpoints / 2, tid, question_id);
        }
    }
    //location.reload();
}


function loadpteam(quiz) {
    qdata = {qid: quiz};
    $.ajax({
        url: 'apis/getnoncurrent.php',
        type: 'POST',
        data: qdata,
        dataType: 'json',
        success: function (data, status) {
            console.log(data)
            for (i = 0; i < data.length; i++) {
                $("#cteam" + (i + 1) + "l").html(data[i].team_name);
                $("#cteam" + (i + 1)).attr("tid", data[i].id);
            }
        },
        error: function (xhr, desc, err) {
            console.log(xhr);
            console.log("Details: " + desc + "\nError:" + err);
        }
    });
}


/*
function submitanswer() {
    if (over == 0) {
        var useran = $('input[name="group1"]:checked', '#myForm').val();
        if (useran != null) {
            if (useran == correct) {
                clearInterval(counter);
                $("#op" + useran).css('color', 'green');
                $("#oc0").show();
                $("#oc1").show();
                $("#oc2").show();
                $("#oc3").show();


                correctans();
            }
            else {
                $("op" + useran).attr('disabled', true);
                $("#oc" + useran).show();
                maxpoints = 0.5 * maxpoints;
                $("#modal_btn").html("CLOSE");
                timer = 0;
                clearInterval(counter);
                soundManager.setup({
                    preferFlash: false,
                    onready: function () {
                        // Ready to use; soundManager.createSound() etc. can now be called.
                    }
                });
                soundManager.createSound({
                    id: 'mySound',
                    url: 'resources/fail.mp3',
                    autoLoad: true,
                    autoPlay: true,
                    onload: function () {
                    },
                    volume: 50
                });

                showpassonbutton();

                $("#op" + useran).css('color', 'red');
                $('#qtimer').text(timer);
                $('input[type=radio][name="group1"][value=' + useran + ']').prop('disabled', true);
                $('input[type=radio][name="group1"][value=' + useran + ']').prop('checked', false);
                showpassonbutton("#op" + useran);

            }
            console.log($('input[name="group1"]:checked', '#myForm').val());
        }
        else {
            console.log("No ans selected");
        }
    }
    else {
        //insertans(1,question_id,maxpoints)
        $('.modal1').modal('close');
    }
}

function showpassonbutton() {
    $("#passonbtn").show();
    $("#qtimer").hide();
    $("#submit_btn").hide();

}

function showsecondoptions() {
    $("#qtimer").show();
    $("#passonbtn").hide();
    $("#passtest").show();
    $("#pteams").show();
    $('#submit_btn').click(function () {
        passonsubmit();
    });
    passon = 1;
    timer = 20;
    counter = setInterval(myTimer, 1000);
    $('#question_info').html("Cat: " + category + "<br> Points: " + totalpoint / 2);
}

function endtimer() {
    $('#submit_btn').show();
    $("#submit_btn").text("Submit And Close");
    $('#your_points').text("Your Points:" + 0);
    $('input[name=group1]').attr("disabled", true);
    $('#submit_btn').text('CLOSE');
    $("#op" + correct).css('color', 'green');
    over = 1;

    $('#' + (category * 1000 + totalpoint)).removeClass('blue-grey').addClass('red');

    insertans(question_id, 0)
}

function correctans() {


}


*/