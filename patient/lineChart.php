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
    <link rel="stylesheet" type="text/css" href="../stylesheets/radio.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">
    <script src="../js/script.js"></script>
    <script src="../js/forAll.js"></script>
    <meta charset="UTF-8">
    <title>Physical Activity Chart</title>
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
   <script type="text/javascript">
        window.onload = function () {
           console.log("reached line chart");
           var chart = new CanvasJS.Chart("lineChart",
               {
                   title:{
                        text: "Multi-Series Line Chart"
                    },
                   data: [
                        {
                            type: "line",
                            dataPoints: [
                                    <?php
                                $sqlVig = "SELECT * FROM `physical` WHERE `username`='$username'";
                                $lineVig= $conn->query($sqlVig);
                                if($lineVig->num_rows>0) {
                                    $counter=0;
                                    while ($rowname = $lineVig->fetch_assoc()) {
                                        $counter++;
                                        $vigLine = $rowname["vigorous"];
                                        $date = $rowname["timeStamp"];
                                        $date2 = (new DateTime($date))->format('d/m/Y');

                                        echo"{x:$counter,y:$vigLine}";
                                    }
                                }
                                ?>

                            ]
                        },
                        {
                            type: "line",
                            dataPoints: [
                                <?php
                                $sqlMod = "SELECT * FROM `physical` WHERE `username`='$username'";
                                $lineMod= $conn->query($sqlMod);
                                if($lineMod->num_rows>0) {
                                    $counter=0;

                                    while ($rowname = $lineMod->fetch_assoc()) {
                                        $counter++;

                                        $modLine = $rowname["moderate"];
                                        $date = $rowname["timeStamp"];
                                        $date2 = (new DateTime($date))->format('d/m/Y');

                                        echo"{x:$counter,y:$modLine}";
                                    }
                                }
                                ?>

                            ]
                        },
                        {
                            type: "line",
                            dataPoints: [
                                <?php
                                $sqlWalk = "SELECT * FROM `physical` WHERE `username`='$username'";
                                $lineWalk= $conn->query($sqlWalk);
                                if($lineWalk->num_rows>0) {
                                    $counter=0;

                                    while ($rowname = $lineWalk->fetch_assoc()) {
                                        $counter++;

                                        $lineWalk = $rowname["walking"];
                                        $date = $rowname["timeStamp"];
                                        $date2 = (new DateTime($date))->format('d/m/Y');

                                        echo"{x:$counter,y:$lineWalk}";
                                    }
                                }
                                ?>

                            ]
                        },
                        {
                            type: "line",
                            dataPoints: [
                                <?php
                                $sqlSit = "SELECT * FROM `physical` WHERE `username`='$username'";
                                $lineSit= $conn->query($sqlSit);
                                if($lineSit->num_rows>0) {
                                    $counter=0;

                                    while ($rowname = $lineSit->fetch_assoc()) {
                                        $counter++;

                                        $lineSit = $rowname["sitting"];
                                        $date = $rowname["timeStamp"];
                                        $date2 = (new DateTime($date))->format('d/m/Y');

                                        echo"{x:$counter,y:$lineSit}";
                                    }
                                }
                                ?>

                            ]
                        }
                    ]
                });
            $("#lineChart").CanvasJSChart(chart);

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
</nav><div class="jumbotron text-center">
    <h1>My Physical Activity Chart <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>
<h2 id="lineChartH">Line Chart</h2>
<div id="lineChart" style="position:absolute;" class="center-div">

    <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
</body>
</html>
