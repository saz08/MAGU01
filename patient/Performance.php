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
    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">
    <script src="../js/script.js"></script>
    <script src="../js/forAll.js"></script>

    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/radio.css">

    <meta charset="UTF-8">
    <title>Monitor Performance</title>

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
                <ul class = "nav navbar-nav navbar-left">
                    <?php
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
                <li><a href="logout.php">LOGOUT</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="jumbotron text-center">
    <h1>Monitor Performance <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>
<br>


<div class="box">The following is the ECOG/WHO (Eastern Cooperative Oncology Group/ World Health Organization) Performance Status scale.<p> Please tick the box that you feel you apply to</p>
<p>
   <details> <summary>: This means there is more information: please click on the text to see more info about the option.</summary> </details>
</p></div>
<form method="get" class="WHOstyle">
    <label class="radioContainer"><details><summary>0: Fully active, no restrictions on activities.</summary> A performance status of 0 means no restrictions in the sense that someone is able to do everything they were able to do prior to their diagnosis.</details>
        <input type="radio" name="radio" value="0" id="zero">
        <span class="checkmark"></span>
    </label>
    <label class="radioContainer"><details><summary>1: Unable to do strenuous activities, but able to carry out light housework and sedentary activities.</summary> This status basically means you can't do heavy work but can do anything else.</details>
        <input type="radio" name="radio" value="1" id="one">
        <span class="checkmark"></span>
    </label>
    <label class="radioContainer"><details><summary>2: Able to walk and manage self-care, but unable to work. Out of bed more than 50% of waking hours.</summary> In this category, people are usually unable to carry on any work activities, including light office work</details>
        <input type="radio" name="radio" value="2" id="two">
        <span class="checkmark"></span>
    </label>
    <label class="radioContainer">3: Confined to bed or a chair more than 50 percent of waking hours.Capable of limited self-care.
        <input type="radio" name="radio" value="3" id="three">
        <span class="checkmark"></span>
    </label>
    <label class="radioContainer">4: Completely disabled.Totally confined to a bed or chair. Unable to do any self-care.
        <input type="radio" name="radio" value="4" id="four">
        <span class="checkmark"></span>
    </label>
    <label class="radioContainer">5: Death
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

    }





</script>
<div>
    <button class="btn" onclick="goBack()"><b><</b> Back </button>
    <button class="btn" style="float:right" onclick="submit()"> Next <b> > </b></button>
</div>
</body>


</html>