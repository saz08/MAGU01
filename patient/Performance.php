<?php

session_start();
function safePOST($conn,$name){
    if (isset($_POST[$name])) {
        return $conn->real_escape_string(strip_tags($_POST[$name]));
    } else {
        return "";
    }
}
function safePOSTNonMySQL($name){
    if(isset($_POST[$name])){
        return strip_tags($_POST[$name]);
    }
    else{
        return "";
    }
}

//connect to the database now that we know we have enough to submit
$host = "devweb2018.cis.strath.ac.uk";
$user = "szb15123";
$pass = "fadooCha4buh";
$dbname = "szb15123";
$conn = new mysqli($host, $user, $pass , $dbname);
$action = safePOST($conn, "action");

$month = date("m");
$year = date("Y");

if(isset($_SESSION["sessionuser"])){
    $user = $_SESSION["sessionuser"];
    $sessionuser = $_SESSION["sessionuser"];
}

else{
    $sessionuser ="";
    $user = safePOSTNonMySQL("username");
    $pass = safePOSTNonMySQL("password");
}

if($_SESSION['userName']==null){
    $_SESSION['userName'] = "unknownUser";
    ?> <script>
        localStorage.setItem('username', "unknownUser");
        localStorage.setItem('loginOK', "no");
    </script><?php
}

$username = $_SESSION["userName"];
$loginOK = false; //TODO make this work with database values

if($loginOK) {
    if (!isset($_SESSION["sessionuser"])) {
        session_regenerate_id();
        $_SESSION["sessionuser"] = $user;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content ="width=device-width, initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta name="mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="../js/script.js"></script>

    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/radio.css">

    <meta charset="UTF-8">
    <title>Project</title>

</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#myPage">    </a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class = "nav navbar-nav navbar-left">
                <li><a href="index.php">HOME</a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">RECORD <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="scale.php">HEALTH MONITORING</a></li>
                        <li><a href="weight.php">WEIGHT MONITORING</a></li>
                        <li><a href="physical.php">PHYSICAL ACTIVITY MONITORING</a></li>
                    </ul>
                </li>                  <li><a href="talk.php">TALK</a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">HELP <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="helpInfo.php">INFO</a></li>
                        <li><a href="helpFinancial.php">FINANCIAL</a></li>
                        <li><a href="helpEmotional.php">EMOTIONAL</a></li>
                        <li><a href="helpPhysical.php">PHYSICAL</a></li>
                    </ul>
                </li>                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">PROFILE <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="progressChart.php">PROGRESS CHARTS</a></li>
                        <li><a href="weightChart.php">WEIGHT CHART</a></li>
                        <li><a href="pieChart.php">PHYSICAL ACTIVITY CHART</a></li>
                        <li><a href="questions.php">QUESTIONS</a></li>
                    </ul>
                </li>
            </ul>
            <ul class = "nav navbar-nav navbar-right">
                <li><a href="logout.php">LOGOUT</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="jumbotron text-center">
    <h1>Monitor Performance <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>

<div class="box">The following is the ECOG/WHO Performance Status scale. Please tick the box that you feel you apply to
<p>
   <details> <summary>: This means there is more information: please click on the text to see more info about the option.</summary> </details>
</p></div>
<form method="get" class="WHOstyle">
    <label class="container"><details><summary>0: Fully active, no restrictions on activities.</summary> A performance status of 0 means no restrictions in the sense that someone is able to do everything they were able to do prior to their diagnosis.</details>
        <input type="radio" name="radio" value="0" id="zero">
        <span class="checkmark"></span>
    </label>
    <label class="container"><details><summary>1: Unable to do strenuous activities, but able to carry out light housework and sedentary activities.</summary> This status basically means you can't do heavy work but can do anything else.</details>
        <input type="radio" name="radio" value="1" id="one">
        <span class="checkmark"></span>
    </label>
    <label class="container"><details><summary>2: Able to walk and manage self-care, but unable to work. Out of bed more than 50% of waking hours.</summary> In this category, people are usually unable to carry on any work activities, including light office work</details>
        <input type="radio" name="radio" value="2" id="two">
        <span class="checkmark"></span>
    </label>
    <label class="container">3: Confined to bed or a chair more than 50 percent of waking hours.Capable of limited self-care.
        <input type="radio" name="radio" value="3" id="three">
        <span class="checkmark"></span>
    </label>
    <label class="container">4: Completely disabled.Totally confined to a bed or chair. Unable to do any self-care.
        <input type="radio" name="radio" value="4" id="four">
        <span class="checkmark"></span>
    </label>
    <label class="container">5: Death
        <input type="radio" name="radio" value="5" id="five">
        <span class="checkmark"></span>
    </label>
</form>





<script>


    function submit(){
        if(document.getElementById('zero').checked){
            localStorage.setItem("Performance", "0");
        }
        if(document.getElementById('one').checked){
            localStorage.setItem("Performance", "1");
        }
        if(document.getElementById('two').checked){
            localStorage.setItem("Performance", "2");
        }
        if(document.getElementById('three').checked){
            localStorage.setItem("Performance", "3");
        }
        if(document.getElementById('four').checked){
            localStorage.setItem("Performance", "4");
        }
        if(document.getElementById('five').checked){
            localStorage.setItem("Performance", "5");
        }

        window.location.href="additionalInfo.php";
      //  submitRecord();

    }
//    function submitRecord(){
//        var pain = localStorage.getItem("Pain");
//        var breathlessness= localStorage.getItem("Breathlessness");
//        var performance = localStorage.getItem("Performance");
//        jQuery.post("scaleInput.php", {"Pain": pain, "Breathlessness": breathlessness, "Performance": performance}, function(data){
//            alert("Records successfully saved");
//        }).fail(function()
//        {
//            alert("something broke in submitting your records");
//        });
//        var painTxt = localStorage.getItem("Pain");
//        var breathlessnessTxt= localStorage.getItem("Breathlessness");
//        var performanceTxt = localStorage.getItem("Performance");
//        jQuery.post("textMsg.php", {"Pain": painTxt, "Breathlessness": breathlessnessTxt, "Performance": performanceTxt}, function(data){
//            alert("Doctor notified of how you feel");
//            window.location.href="index.html";
//        }).fail(function()
//        {
//            alert("something broke in emailing your doctor");
//        });
//
//    }

    function outputUpdate(num) {
        document.querySelector('#output').value = num;
    }
</script>
</body>
<div class="clear"></div>

<footer>
    <div class="footer">
        <div class="glyphicon glyphicon-arrow-left" style="float:left" id="arrows" onclick="goBack()"></div>
        <div class="glyphicon glyphicon-arrow-right" style="float:right" id="arrows" onclick="submit()"></div>

        <p style="text-align: center;">&copy; Sara Reid Final Year Project 2019</p>
    </div></footer>
</html>