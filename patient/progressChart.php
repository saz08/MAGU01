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




    $sql  = "SELECT * FROM `scale` WHERE `pain`<=3 AND `username` = '$username'";
    $result= $conn->query($sql);
    if($result->num_rows>0){
        $greenPain = $result->num_rows;
    }
    else{
        $greenPain=0;
    }

    $sqlAMBER  = "SELECT * FROM `scale` WHERE `pain`>=4 AND `pain`<=7 AND `username` = '$username'";
    $resultAMBER= $conn->query($sqlAMBER);
    if($resultAMBER->num_rows>0){
        $amberPAIN = $resultAMBER->num_rows;
    }
    else{
        $amberPAIN=0;
    }

    $sqlRED  = "SELECT * FROM `scale` WHERE `pain`>=8  AND `username` = '$username'";
    $resultRED= $conn->query($sqlRED);
    if($resultRED->num_rows>0){
        $redPAIN = $resultRED->num_rows;
    }
    else{
        $redPAIN=0;
    }

    $painTotal = $greenPain+$amberPAIN+$redPAIN;

    $sqlBG  = "SELECT * FROM `scale` WHERE `breathlessness`<=1  AND `username` = '$username'";
    $resultBG= $conn->query($sqlBG);
    if($resultBG->num_rows>0){
        $greenBreath = $resultBG->num_rows;
    }
    else{
        $greenBreath=0;
    }

    $sqlBA  = "SELECT * FROM `scale` WHERE `breathlessness`>=2 AND `breathlessness` <=4  AND `username` = '$username'";
    $resultBA= $conn->query($sqlBA);
    if($resultBA->num_rows>0){
        $amberBreath = $resultBA->num_rows;
    }
    else{
        $amberBreath=0;
    }

    $sqlBR  = "SELECT * FROM `scale` WHERE `breathlessness`>=5  AND `username` = '$username'";
    $resultBR= $conn->query($sqlBR);
    if($resultBR->num_rows>0){
        $redBreath = $resultBR->num_rows;
    }
    else{
        $redBreath=0;
    }

    $breathlessnessTotal = $greenBreath+$amberBreath+$redBreath;

    $sqlPG  = "SELECT * FROM `scale` WHERE `performance`<=1  AND `username` = '$username'";
    $resultPG= $conn->query($sqlPG);
    if($resultPG->num_rows>0){
        $greenPerformance = $resultPG->num_rows;
    }
    else{
        $greenPerformance=0;
    }

    $sqlPA  = "SELECT * FROM `scale` WHERE `performance`=2 AND `breathlessness` <=4  AND `username` = '$username'";
    $resultPA= $conn->query($sqlPA);
    if($resultPA->num_rows>0){
        $amberPerformance = $resultPA->num_rows;
    }
    else{
        $amberPerformance=0;
    }

    $sqlBP  = "SELECT * FROM `scale` WHERE `performance`>=3  AND `username` = '$username'";
    $resultBP= $conn->query($sqlBP);
    if($resultBP->num_rows>0){
        $redPerformance = $resultBP->num_rows;
    }
    else{
        $redPerformance=0;
    }

    $sqlEntries  = "SELECT * FROM `scale` WHERE `username` = '$username'";
    $resultEntries= $conn->query($sqlEntries);
    if($resultEntries->num_rows>0){
        $entries = $resultEntries->num_rows;
    }
    else{
        $entries=0;
    }



    $performanceTotal = $greenPerformance+$amberPerformance+$redPerformance;

if($entries!=0) {
    //PAIN DONUT BARS
    $greenPainBar = $greenPain / ($entries) * 210;
    $amberPainBar = $amberPAIN / ($entries) * 210;
    $redPainBar = $redPAIN / ($entries) * 210;

    //BREATHING DONUT BARS
    $greenBBar = $greenBreath / ($entries) * 210;
    $amberBBar = $amberBreath / ($entries) * 210;
    $redBBar = $redBreath / ($entries) * 210;

    //PERFORMANCE DONUT BARS
    $greenPBar = $greenPerformance / ($entries) * 210;
    $amberPBar = $amberPerformance / ($entries) * 210;
    $redPBar = $redPerformance / ($entries) * 210;
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
    <script>

        function painAllTime() {
            CanvasJS.addColorSet("greenShades",
                [
                    "#008D00",
                    "#FFBF00",
                    "#FF0000"
                ]);
            var chart = new CanvasJS.Chart("painAllTime", {

                animationEnabled: true,
                colorSet: "greenShades",
                backgroundColor: "#DDA8FF",

                title:{
                    text: "Pain Scales",
                    horizontalAlign: "left"
                },
                data: [{
                    type: "doughnut",
                    startAngle: 60,
                    //innerRadius: 60,
                    indexLabelFontSize: 17,
                    indexLabel: "{label} - #percent%",
                    toolTipContent: "<b>{label}:</b> {y} (#percent%)",
                    dataPoints: [
                        <?php
                        echo "{y: $greenPainBar, label: 'Green'},";
                        echo "{y: $amberPainBar, label: 'Amber'},";
                        echo "{y: $redPainBar, label: 'Red'},";
                        ?>
                    ]
                }]
            });
            chart.render();
        }
        function breathAllTime() {
            CanvasJS.addColorSet("greenShades",
                [
                    "#008D00",
                    "#FFBF00",
                    "#FF0000"
                ]);
            var chart = new CanvasJS.Chart("breathAllTime", {

                animationEnabled: true,
                colorSet: "greenShades",
                backgroundColor: "#DDA8FF",

                title:{
                    text: "Pain Scales",
                    horizontalAlign: "left"
                },
                data: [{
                    type: "doughnut",
                    startAngle: 60,
                    //innerRadius: 60,
                    indexLabelFontSize: 17,
                    indexLabel: "{label} - #percent%",
                    toolTipContent: "<b>{label}:</b> {y} (#percent%)",
                    dataPoints: [
                        <?php
                        echo "{y: $greenBBar, label: 'Green'},";
                        echo "{y: $amberBBar, label: 'Amber'},";
                        echo "{y: $redBBar, label: 'Red'},";
                        ?>
                    ]
                }]
            });
            chart.render();
        }

        function performanceAllTime() {
            CanvasJS.addColorSet("greenShades",
                [
                    "#008D00",
                    "#FFBF00",
                    "#FF0000"
                ]);
            var chart = new CanvasJS.Chart("performanceAllTime", {

                animationEnabled: true,
                colorSet: "greenShades",
                backgroundColor: "#DDA8FF",

                title:{
                    text: "Pain Scales",
                    horizontalAlign: "left"
                },
                data: [{
                    type: "doughnut",
                    startAngle: 60,
                    //innerRadius: 60,
                    indexLabelFontSize: 17,
                    indexLabel: "{label} - #percent%",
                    toolTipContent: "<b>{label}:</b> {y} (#percent%)",
                    dataPoints: [
                        <?php
                        echo "{y: $greenPBar, label: 'Green'},";
                        echo "{y: $amberPBar, label: 'Amber'},";
                        echo "{y: $redPBar, label: 'Red'},";
                        ?>
                    ]
                }]
            });
            chart.render();
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
    <h1>My Progress</h1>
</div>


<div class="box">
    <form method="get" class="radiostyle">
        <label class="container" style="font-family: Montserrat, sans-serif">Show chart based on all records
            <span class="checkmark"></span>
            <input type="radio" class="choices" name="radio" value="1" id="1" onclick="submitAll()">
        </label>
        <br>
        <label class="container" style="font-family: Montserrat, sans-serif">Show chart based on the records from this month
            <span class="checkmark"></span>
            <input type="radio" class="choices" name="radio" value="2" id="2" onclick="submitMonth()">

        </label>
    </form>
</div>



<div class="container" id="allTime">
    <br>
    <div class="caroBox">
        <div id="myCarousel2" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel2" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel2" data-slide-to="1"></li>
                <li data-target="#myCarousel2" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <div class="container">
                        <div id="painAllTime" style="height: 30rem; width: 100%;"></div>

                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>
                </div>

                <div class="item">
                    <div class="container">
                        <div id="breathAllTime" style="height: 30rem; width: 100%;"></div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>
                </div>

                <div class="item">
                    <div class="container">
                        <div id="performanceAllTime" style="height:30rem; width: 100%;"></div>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    </div>
                </div>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel2" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel2" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>

        </div>
    </div>
</div>


<script>
    var x = document.getElementById("allTime");
    var y = document.getElementById("prevMonth");
    x.style.display="none";
    y.style.display="block";
    function submitAll(){
        var x = document.getElementById("allTime");

        if (x.style.display === "none") {
            x.style.display = "block";
            y.style.display="none";
        } else {
            x.style.display = "block";
        }


    }
</script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
<footer>
    <div class="footer">
        <div class="glyphicon glyphicon-arrow-left" style="float:left" id="arrows" onclick="goBack()"></div>
        <p style="text-align: center;">&copy; Sara Reid Final Year Project 2019</p>
    </div></footer>
</html>

