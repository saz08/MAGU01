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
$action2 = safePOST($conn, "action2");


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
    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">

    <script src="../js/script.js"></script>
    <script src="../js/forAll.js"></script>

    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/radio.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/alerts.css">

    <meta charset="UTF-8">
    <title>Add Info</title>
</head>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">



<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class = "nav navbar-nav navbar-left">
                <?php
                if($_SESSION["userName"]!=null) {
                    $username = $_SESSION["userName"];
                }
                else{
                    ?><script>
                        localStorage.setItem("username","unknownUser");
                        localStorage.setItem("loginOK","no");
                        alert("Session has expired, please log in again");

                        window.location.href="signUp.php";
                    </script><?php
                }

                $sqlInfo = "SELECT * FROM `scale` WHERE `username` = '$username'";
                $supportInfo = $conn->query($sqlInfo);
                if ($supportInfo->num_rows > 0) {
                    while ($rowname = $supportInfo->fetch_assoc()) {
                        $seenInfo = $rowname["seenInfo"];
                        $resInfo = $rowname["resInfo"];
                        $seenSymp = $rowname["seenSymp"];
                        $resSymp = $rowname["resSymp"];
                        $importantInfo="false";
                        $importantSymp="false";

                        if ($seenInfo === "true" && $resInfo != "") {
                            $importantInfo = "true";
                        }
                        else {
                            $importantInfo = "false";
                        }
                        if ($seenSymp === "true" && $resSymp != "") {
                            $importantSymp = "true";
                        }
                        else {
                            $importantSymp = "false";
                        }

                    }
                }
                else{
                    $importantInfo="false";
                    $importantSymp = "false";

                }

                if($importantInfo==="true"||$importantSymp==="true"){
                    echo "<li><a href='index.php'>HOME <span class=\"glyphicon glyphicon-exclamation-sign\"></span></a></li>";
                }
                else{
                    echo"<li><a href='index.php'>HOME</a></li>";
                }
                ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" onclick="openRecord()">RECORD <span class="caret"></span></a>
                    <ul class="dropdown-menu" id="record">
                        <li><a href="scale.php">HEALTH MONITORING</a></li>
                        <li><a href="weight.php">WEIGHT MONITORING</a></li>
                        <li><a href="physical.php">PHYSICAL ACTIVITY MONITORING</a></li>
                    </ul>
                </li>

                <li><a href="talk.php">TALK</a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" onclick="openHelp()">HELP <span class="caret"></span></a>
                    <ul class="dropdown-menu" id="help">
                        <li><a href="helpInfo.php">INFO</a></li>
                        <li><a href="helpFinancial.php">FINANCIAL</a></li>
                        <li><a href="helpEmotional.php">EMOTIONAL</a></li>
                        <li><a href="helpPhysical.php">PHYSICAL</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" onclick="openProfile()">PROFILE <span class="caret"></span></a>
                    <ul class="dropdown-menu" id="profile">
                        <li><a href="statusChart.php">STATUS CHARTS</a></li>
                        <li><a href="weightChart.php">WEIGHT CHART</a></li>
                        <li><a href="physicalChart.php">PHYSICAL ACTIVITY CHART</a></li>
                        <li><a href="questions.php">QUESTIONS</a></li>
                        <li><a href="supportCircle.php">SUPPORT CIRCLE</a></li>
                    </ul>
                </li>
            </ul>
            <ul class = "nav navbar-nav navbar-right">
                <li><a> <button class="btn" id="checkLogOut" onclick="logOutCheck()"  style="background-color: #E9969F;color:black;top:0 " >LOGOUT</button></a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="jumbotron text-center">
    <h1>Additional Info <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>
<div id="logOutCheck" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to log out?</p>
        <button id="spanSubmitCheck" class="btn" onclick="window.location.href='logout.php' ;document.getElementById('logOutCheck').style.display='none';">Yes</button>
        <button id="spanSubmitCheck" class="btn" onclick="document.getElementById('logOutCheck').style.display='none';">No</button>
    </div>
</div>
<div class="box">Here is a small list of common symptoms. If you feel you apply to one, please choose one then press <b>submit</b></div>

<form name="symptom" method="post" class="box-transparent" >
    Symptoms:
    <select id="select" name="select">
        <option></option>
        <option value="Anxiety">Anxiety</option>
        <option value="Loss Of Appetite">Loss of Appetite</option>
        <option value="Bleeding">Bleeding</option>
        <option value="Constipation">Constipation</option>
        <option value="Depressed">Depressed</option>
        <option value="Diarrhoea">Diarrhoea</option>
        <option value="Fatigue">Fatigue</option>
        <option value="Insomnia">Insomnia</option>
        <option value="Sickness">Sickness</option>
    </select>
    <input type="hidden" name="action2" value="filled">
</form>

<div class="box">You can also enter anything you have noticed about yourself or any worries. If you don't have anything you'd like to add, please leave blank and press <b>submit</b>.</div>

    <form name="additional" method="post" class="box-transparent" >
        <input type="text" name="additional"  id="additional"/>
        <input type="hidden" name="action" value="filled">
    </form>


<div id="savedModal" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanSave" onclick="document.getElementById('savedModal').style.display='none'; window.location.href='index.php';" style="float:right" >&times;</button>
        <p>Records have been successfully saved</p>
    </div>
</div>

<div id="notSavedModal" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanNotSave" onclick="document.getElementById('notSavedModal').style.display='none';"style="float:right" >&times;</button>
        <p>Your records were not submitted successfully. Please check your internet connection and try again.</p>
    </div>
</div>

<div id="docNotify" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanNotify" onclick="document.getElementById('docNotify').style.display='none'"style="float:right" >&times;</button>
        <p>Your doctor has been notified</p>
    </div>
</div>

<div id="notNotify" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanNotNotify" onclick="document.getElementById('notNotify').style.display='none';" style="float:right">&times;</button>
        <p>Survivors was unable to notify your doctor. Please check your internet connection and try again. If you feel your symptoms are serious please contact your doctor immediately.</p>
    </div>
</div>

<div id="submitCheck" class="modal">
    <div class="modal-content">
        <p>Survivors will now save your records and send to your doctor. Are you sure you want to submit?</p>
        <button id="spanSubmitCheck" class="btn" onclick="submitRecord();document.getElementById('submitCheck').style.display='none';">Yes</button>
        <button id="spanSubmitCheck" class="btn" onclick="document.getElementById('submitCheck').style.display='none';">No</button>
    </div>
</div>

<div id="painFill" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanNotNotify" onclick="document.getElementById('painFill').style.display='none';" style="float:right">&times;</button>
        <p>Sorry! You have not entered your pain rating. Please go back and enter before submitting</p>
    </div>
</div>

<div id="breathFill" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanNotNotify" onclick="document.getElementById('breathFill').style.display='none';" style="float:right">&times;</button>
        <p>Sorry! You have not entered your breathlessness rating. Please go back and enter before submitting</p>
    </div>
</div>

<div id="performanceFill" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanNotNotify" onclick="document.getElementById('performanceFill').style.display='none';" style="float:right">&times;</button>
        <p>Sorry! You have not entered your performance rating. Please go back and enter before submitting</p>
    </div>
</div>

<div class="divSpace"></div>

<script>
    // Get the modal
    var savedModal = document.getElementById('savedModal');
    var notSavedModal = document.getElementById('notSavedModal');
    var docNotify = document.getElementById('docNotify');
    var notNotify = document.getElementById('notNotify');

    function submitRecord(){
        var pain = localStorage.getItem("Pain");
        var breathlessness= localStorage.getItem("Breathlessness");
        var performance = localStorage.getItem("Performance");
        var additionalInfo = document.getElementById('additional').value;
        var symptom = document.getElementById('select').value;
        jQuery.post("scaleInput.php", {"Pain": pain, "Breathlessness": breathlessness, "Performance": performance,"Additional": additionalInfo,"Symptom": symptom}, function(data){
            savedModal.style.display="block";
        }).fail(function()
        {
            notSavedModal.style.display="block";
        });

        var painTxt = localStorage.getItem("Pain");
        var breathlessnessTxt= localStorage.getItem("Breathlessness");
        var performanceTxt = localStorage.getItem("Performance");
        jQuery.post("textMsg.php", {"Pain": painTxt, "Breathlessness": breathlessnessTxt, "Performance": performanceTxt}, function(data){
            docNotify.style.display="block";
        }).fail(function()
        {
            notNotify.style.display="block";

        });
    }


    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target === savedModal) {
            savedModal.style.display = "none";
        }
        if (event.target === notSavedModal) {
            notSavedModal.style.display = "none";
        }
        if (event.target === docNotify) {
            docNotify.style.display = "none";
        }
        if (event.target === notNotify) {
            notNotify.style.display = "none";
        }
    };

    function submitCheck(){
        var pain = localStorage.getItem("Pain");
        var breathlessness= localStorage.getItem("Breathlessness");
        var performance = localStorage.getItem("Performance");
        if(pain===""||breathlessness===""||performance==="") {
            if (pain === "") {
                document.getElementById("painFill").style.display = "block";
            }
            if (breathlessness === "") {
                document.getElementById("breathFill").style.display = "block";
            }
            if (performance === "") {
                document.getElementById("performanceFill").style.display = "block";
            }
        }
        else {
            var check = document.getElementById("submitCheck");
            check.style.display = "block";
        }
    }
</script>
<div class="divSpace"></div>
<div class="footer">
    <button class="btn" onclick="goBack()" style="float:left"><b><</b> Back </button>
        <button class="btn" style="float:right" onclick="submitCheck()"> Submit <b> > </b></button>
</div>
</body>
</html>