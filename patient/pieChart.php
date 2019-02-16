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

$sumVig  = "SELECT SUM(`vigorous`) FROM `physical` WHERE `username` = '$username'";
$vigResult= $conn->query($sumVig);
if($vigResult->num_rows>0) {
while ($rowname = $vigResult->fetch_assoc()) {
    $vigorous = $rowname["SUM(`vigorous`)"];
    }
}

$sumMod  = "SELECT SUM(`moderate`) FROM `physical` WHERE `username` = '$username'";
$modResult= $conn->query($sumMod);
if($modResult->num_rows>0) {
    while ($rowname = $modResult->fetch_assoc()) {
        $moderate = $rowname["SUM(`moderate`)"];
    }
}

$sumWalk  = "SELECT SUM(`walking`) FROM `physical` WHERE `username` = '$username'";
$walkResult= $conn->query($sumWalk);
if($walkResult->num_rows>0) {
    while ($rowname = $walkResult->fetch_assoc()) {
        $walking = $rowname["SUM(`walking`)"];
    }
}

$sumSit  = "SELECT SUM(`sitting`) FROM `physical` WHERE `username` = '$username'";
$sitResult= $conn->query($sumSit);
if($sitResult->num_rows>0) {
    while ($rowname = $sitResult->fetch_assoc()) {
        $sitting = $rowname["SUM(`sitting`)"];
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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">
    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <script src="../js/script.js"></script>

    <meta charset="UTF-8">
    <title>Project</title>
    <script type="text/javascript">
        window.onload = function() {
            CanvasJS.addColorSet("greenShades",
                [//colorSet Array

                    "#2F4F4F",
                    "#008080",
                    "#2E8B57",
                    "#3CB371",
                    "#90EE90"
                ]);
            var options = {
                backgroundColor: "#DDA8FF",
                colorSet: "greenShades",
                data: [{
                    type: "pie",
                    startAngle: 45,
                    showInLegend: "true",
                    legendText: "{label}",
                    indexLabel: "{label} ({y} Days)",
                    indexLabelPlacement: "outside",
                    indexLabelBackgroundColor: "white",
                    indexLabelFontSize: 20,
                    indexLabelWrap: true,
                    yValueFormatString:"#,##0.#"%"",
                    dataPoints: [
                        <?php
                        echo "{label: 'Vigorous', y: $vigorous}, ";
                        echo "{label: 'Moderate', y: $moderate}, ";
                        echo "{label: 'Walking', y: $walking}, ";
                        echo "{label: 'Sitting', y: $sitting}, ";
                        ?>

                    ]
                }]
            };
            $("#chartContainer").CanvasJSChart(options);

        }
    </script>
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
                <li><a href="recordOptions.php">RECORD</a></li>
                <li><a href="talk.php">TALK</a></li>
                <li><a href="links.html">HELP</a></li>
                <li><a href="results.php">PROFILE</a></li>


            </ul>
            <ul class = "nav navbar-nav navbar-right">
                <li><a href="logout.php">LOGOUT</a></li>
            </ul>
        </div>
    </div>
</nav>


<div class="jumbotron text-center">
    <h1>My Physical Activity Chart</h1>
</div>
<div id="chartContainer" style="height: 300px; width: 100%;"></div>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>


</body>
<footer>
    <div class="footer">
        <div class="glyphicon glyphicon-arrow-left" style="float:left" id="arrows" onclick="goBack()"></div>
        <p style="text-align: center;">&copy; Sara Reid Final Year Project 2019</p>
    </div></footer>
</html>

