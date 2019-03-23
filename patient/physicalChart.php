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

//Connect to Database
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
    <link rel="stylesheet" type="text/css" href="../stylesheets/alerts.css">

    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">
    <script src="../js/script.js"></script>
    <script src="../js/forAll.js"></script>
    <meta charset="UTF-8">
    <title>Physical Activity Chart</title>
</head>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">


<?php
//Detect if session is still running. If not, direct user to login
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

//PERFORM CALCULATIONS FOR STATUS CHARTS: ALL TIME AND PREVIOUS WEEK

//All Time Vigorous
$sumVig  = "SELECT SUM(`vigorous`) FROM `physical` WHERE `username` = '$username'";
$vigResult= $conn->query($sumVig);
if($vigResult->num_rows>0) {
while ($rowname = $vigResult->fetch_assoc()) {
    $vigorous = $rowname["SUM(`vigorous`)"];
    }
}
else{
    $vigorous=0;
}

//All Time Moderate
$sumMod  = "SELECT SUM(`moderate`) FROM `physical` WHERE `username` = '$username'";
$modResult= $conn->query($sumMod);
if($modResult->num_rows>0) {
    while ($rowname = $modResult->fetch_assoc()) {
        $moderate = $rowname["SUM(`moderate`)"];
    }
}
else{
    $moderate=0;
}

//All Time Walking
$sumWalk  = "SELECT SUM(`walking`) FROM `physical` WHERE `username` = '$username'";
$walkResult= $conn->query($sumWalk);
if($walkResult->num_rows>0) {
    while ($rowname = $walkResult->fetch_assoc()) {
        $walking = $rowname["SUM(`walking`)"];
    }
}
else{
    $walking=0;
}

//All Time Sitting
$sumSit  = "SELECT SUM(`sitting`) FROM `physical` WHERE `username` = '$username'";
$sitResult= $conn->query($sumSit);
if($sitResult->num_rows>0) {
    while ($rowname = $sitResult->fetch_assoc()) {
        $sitting = $rowname["SUM(`sitting`)"];
    }
}
else{
    $sitting=0;
}

//Most recent Vigorous
$weekVig  = "SELECT `vigorous` FROM `physical` WHERE `username` = '$username' ORDER BY `timeStamp` DESC LIMIT 1";
$weekVigResult= $conn->query($weekVig);
if($weekVigResult->num_rows>0) {
    while ($rowname = $weekVigResult->fetch_assoc()) {
        $vigWeek = $rowname["vigorous"];
    }
}
else{
    $vigWeek=0;
}

//Most recent moderate
$weekMod  = "SELECT `moderate` FROM `physical` WHERE `username` = '$username' ORDER BY `timeStamp` DESC LIMIT 1";
$weekModResult= $conn->query($weekMod);
if($weekModResult->num_rows>0) {
    while ($rowname = $weekModResult->fetch_assoc()) {
        $modWeek = $rowname["moderate"];
    }
}
else{
    $modWeek=0;
}

//Most recent walking
$weekWalk  = "SELECT `walking` FROM `physical` WHERE `username` = '$username' ORDER BY `timeStamp` DESC LIMIT 1";
$weekWalkResult= $conn->query($weekWalk);
if($weekWalkResult->num_rows>0) {
    while ($rowname = $weekWalkResult->fetch_assoc()) {
        $walkWeek = $rowname["walking"];
    }
}
else{
    $walkWeek=0;
}

//Most recent sitting
$weekSitting  = "SELECT `sitting` FROM `physical` WHERE `username` = '$username' ORDER BY `timeStamp` DESC LIMIT 1";
$weekSittingResult= $conn->query($weekSitting);
if($weekSittingResult->num_rows>0) {
    while ($rowname = $weekSittingResult->fetch_assoc()) {
        $sittingWeek = $rowname["sitting"];
    }
}
else{
    $sittingWeek=0;
}

//Calculate if there is an "all time" value
if(($vigorous+$moderate+$walking+$sitting)==0){
    $entries = 0;
}
else{
    $entries=1;
}

//Calculate if there is a "previous week" value
if(($vigWeek+$modWeek+$walkWeek+$sittingWeek)==0){
    $entriesW = 0;
}
else{
    $entriesW=1;
}

?>
    <script type="text/javascript">
        window.onload = function() {
            CanvasJS.addColorSet("greenShades",
                [//colorSet Array

                    "#FF9400",
                    "#E8001E",
                    "#5000FF",
                    "#00BDE8"
                ]);
            var options = {
                //Chart for all time
                width: window.innerWidth,
                height: 400,

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
            var week = {
                //Chart for previous week
                width: window.innerWidth,
                height: 400,
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
                        echo "{label: 'Vigorous', y: $vigWeek}, ";
                        echo "{label: 'Moderate', y: $modWeek}, ";
                        echo "{label: 'Walking', y: $walkWeek}, ";
                        echo "{label: 'Sitting', y: $sittingWeek}, ";
                        ?>

                    ]
                }]
            };


            $("#chartContainer").CanvasJSChart(options);
            $("#chartContainerWeek").CanvasJSChart(week);
        };

    </script>


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
                //Detect if session is still running. If not, direct user to login
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

                //Show info alert when patient has a response from doctor
                $sqlInfo = "SELECT * FROM `scale` WHERE `username` = '$username'";
                $supportInfo = $conn->query($sqlInfo);
                if ($supportInfo->num_rows > 0) {
                    $importantInfo=0;
                    $importantSymp=0;
                    while ($rowname = $supportInfo->fetch_assoc()) {
                        $seenInfo = $rowname["seenInfo"];
                        $resInfo = $rowname["resInfo"];
                        $seenSymp = $rowname["seenSymp"];
                        $resSymp = $rowname["resSymp"];

                        if ($seenInfo === "true" && $resInfo != "") {
                            $importantInfo++;
                        }

                        if ($seenSymp === "true" && $resSymp != "") {
                            $importantSymp++;
                        }
                    }
                }
                $importantInfo=0;
                $importantSymp=0;
                if($importantInfo>0||$importantSymp>0){
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
    <h1>My Physical Activity Chart <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>

<!--Modal: Logout Check-->
<div id="logOutCheck" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to log out?</p>
        <button id="spanSubmitCheck" class="btn" onclick="window.location.href='logout.php' ;document.getElementById('logOutCheck').style.display='none';">Yes</button>
        <button id="spanSubmitCheck" class="btn" onclick="document.getElementById('logOutCheck').style.display='none';">No</button>
    </div>
</div>

<?php
//If there are no records yet, notify the user
$sql = "SELECT * FROM `physical` WHERE `username` = '$username'";
$result= $conn->query($sql);
if($result->num_rows<1) {
 echo"<div class='box'><p>No physical records yet</p></div>";
}
?>
<br>
<button class="btn" id="button" onclick="window.location.href='physical.php'">Make an entry</button>
<br>
<?php
//if there are values for all time and previous week, show the options for the chart
if(($entries&&$entriesW)!=0){ ?>

<div class="box">
    <form method="get" class="radiostyle">
        <label class="radioContainer" style="font-family: Montserrat, sans-serif">Show chart based on all records
            <input type="radio" class="choices" name="radio" value="1" id="1" onclick="submitAll()">
            <span class="checkmark"></span>
        </label>
        <br>
        <label class="radioContainer" style="font-family: Montserrat, sans-serif">Show chart based on most recent record
            <input type="radio" class="choices" name="radio" value="2" id="2" onclick="submitMonth()" checked>
            <span class="checkmark"></span>
        </label>
    </form>
</div>
<?php }?>
<br>
<?php if($entries!=0){ ?>
    <h2 id="allTime">All Records</h2>
<div id="chartContainer" style="position:absolute" class="center-div">
<div id="allTime" style="height: 40rem; width: 100%;"></div>
</div>
<?php } ?>
<br>

<?php if($entriesW!=0){ ?>
    <h2 id="week">Most recent record</h2>
<div id="chartContainerWeek" style="position:absolute" class="center-div">
<div id="prevWeek" style="height: 40rem; width: 100%;"></div>
</div>
<?php } ?>


<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
<script>
    //Functions for the radio buttons to toggle divs
    var x = document.getElementById("chartContainer");
    var y = document.getElementById("chartContainerWeek");

    var alltime = document.getElementById("allTime");
    var week = document.getElementById("week");

    x.style.display="none";
    alltime.style.display="none";
    y.style.display="block";
    week.style.display="block";

    function submitAll(){
        if (x.style.display === "none") {
            y.style.display="none";
            week.style.display="none";
            x.style.display = "block";
            alltime.style.display="block";

        } else {
            x.style.display = "block";
            alltime.style.display="block";
            week.style.display="none";
        }
    }

    function submitMonth(){
        if (y.style.display === "none") {
            x.style.display="none";
            alltime.style.display="none";
            y.style.display = "block";
            week.style.display="block";

        } else {
            y.style.display = "block";
            week.style.display="block";
            alltime.style.display="none";

        }

    }

    function next(){
        window.location.href="questions.php";
    }
</script>

</body>
<div class="footer">
    <button class="btn" onclick="goBack()" style="float:left"><b><</b> Back </button>
    <button class="btn" style="float:right" onclick="next()"> Next <b> > </b></button>
</div>
</html>

