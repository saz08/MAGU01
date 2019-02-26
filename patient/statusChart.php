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


$sqlGPM  = "SELECT * FROM `scale` WHERE `pain`<=3 AND `username` = '$username' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$greenPM= $conn->query($sqlGPM);
if($greenPM->num_rows>0){
    $greenPainM = $greenPM->num_rows;
}
else{
    $greenPainM=0;
}

$sqlAPM  = "SELECT * FROM `scale` WHERE `pain`>=4 AND `pain`<=7 AND `username` = '$username' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$amberPM= $conn->query($sqlAPM);
if($amberPM->num_rows>0){
    $amberPainM = $amberPM->num_rows;
}
else{
    $amberPainM=0;
}

$sqlRPM  = "SELECT * FROM `scale` WHERE `pain`>=8  AND `username` = '$username' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$redPM= $conn->query($sqlRPM);
if($redPM->num_rows>0){
    $redPainM = $redPM->num_rows;
}
else{
    $redPainM=0;
}

$painTotalMonth = $greenPainM+$amberPainM+$redPainM;

$sqlGBM  = "SELECT * FROM `scale` WHERE `breathlessness`<=1  AND `username` = '$username' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultBGM= $conn->query($sqlGBM);
if($resultBGM->num_rows>0){
    $greenBreathM = $resultBGM->num_rows;
}
else{
    $greenBreathM=0;
}

$sqlBAM  = "SELECT * FROM `scale` WHERE `breathlessness`>=2 AND `breathlessness` <=4  AND `username` = '$username' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultBAM= $conn->query($sqlBAM);
if($resultBAM->num_rows>0){
    $amberBreathM = $resultBAM->num_rows;
}
else{
    $amberBreathM=0;
}

$sqlBRM  = "SELECT * FROM `scale` WHERE `breathlessness`>=5  AND `username` = '$username' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultBRM= $conn->query($sqlBRM);
if($resultBRM->num_rows>0){
    $redBreathM = $resultBRM->num_rows;
}
else{
    $redBreathM=0;
}

$breathlessnessTotalM = $greenBreathM+$amberBreathM+$redBreathM;

$sqlPGM  = "SELECT * FROM `scale` WHERE `performance`<=1  AND `username` = '$username' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultPGM= $conn->query($sqlPGM);
if($resultPGM->num_rows>0){
    $greenPerformanceM = $resultPGM->num_rows;
}
else{
    $greenPerformanceM=0;
}

$sqlPAM  = "SELECT * FROM `scale` WHERE `performance`=2 AND `breathlessness` <=4  AND `username` = '$username' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultPAM= $conn->query($sqlPAM);
if($resultPAM->num_rows>0){
    $amberPerformanceM = $resultPAM->num_rows;
}
else{
    $amberPerformanceM=0;
}

$sqlBPM  = "SELECT * FROM `scale` WHERE `performance`>=3  AND `username` = '$username' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultBPM= $conn->query($sqlBPM);
if($resultBPM->num_rows>0){
    $redPerformanceM = $resultBPM->num_rows;
}
else{
    $redPerformanceM=0;
}

$sqlEntriesM  = "SELECT * FROM `scale` WHERE `username` = '$username' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultEntriesM= $conn->query($sqlEntriesM);
if($resultEntriesM->num_rows>0){
    $entriesM = $resultEntriesM->num_rows;
}
else{
    $entriesM=0;
}



$performanceTotalM = $greenPerformanceM+$amberPerformanceM+$redPerformanceM;

if($entriesM!=0) {
//PAIN DONUT BARS
    $greenPainBarM = $greenPainM / ($entriesM) * 210;
    $amberPainBarM = $amberPainM / ($entriesM) * 210;
    $redPainBarM = $redPainM / ($entriesM) * 210;

//BREATHING DONUT BARS
    $greenBBarM = $greenBreathM / ($entriesM) * 210;
    $amberBBarM = $amberBreathM / ($entriesM) * 210;
    $redBBarM = $redBreathM / ($entriesM) * 210;

//PERFORMANCE DONUT BARS
    $greenPBarM = $greenPerformanceM / ($entriesM) * 210;
    $amberPBarM = $amberPerformanceM / ($entriesM) * 210;
    $redPBarM = $redPerformanceM / ($entriesM) * 210;
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

    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">
    <script src="../js/script.js"></script>
    <script src="../js/forAll.js"></script>

    <meta charset="UTF-8">
    <title>Record Chart</title>
    <script>

        window.onload = function() {
            CanvasJS.addColorSet("greenShades",
                [
                    "#008D00",
                    "#E8AE00",
                    "#FF0000"
                ]);
            var painAllTime = new CanvasJS.Chart("painAllTime", {

                animationEnabled: true,
                colorSet: "greenShades",
                backgroundColor: "#DDA8FF",
//                height: 400,
                width: window.innerWidth,
                title:{
                    text: "Pain",
                    fontFamily: "Montserrat, sans-serif",

                    horizontalAlign: "left"
                },
                data: [{
                    type: "doughnut",
                    startAngle: 60,
                    //innerRadius: 60,
                    radius: "80%",
                    indexLabelLineThickness: 5,
                    indexLabelFontSize: 17,
                    indexLabelFontFamily: "Montserrat, sans-serif",
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
            painAllTime.render();


            var breathAllTime = new CanvasJS.Chart("breathAllTime", {

                animationEnabled: true,
                colorSet: "greenShades",
                backgroundColor: "#DDA8FF",
//                height: 400,
                width: window.innerWidth,

                title:{
                    fontFamily: "Montserrat, sans-serif",

                    text: "Breathlessness",
                    horizontalAlign: "left"
                },
                data: [{
                    type: "doughnut",
                    startAngle: 60,
                    //innerRadius: 60,
                    radius: "80%",
                    indexLabelLineThickness: 5,
                    indexLabelFontFamily: "Montserrat, sans-serif",

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
            breathAllTime.render();


            var performanceAllTime = new CanvasJS.Chart("performanceAllTime", {

                animationEnabled: true,
                colorSet: "greenShades",
                backgroundColor: "#DDA8FF",
//                height: 400,
                width: window.innerWidth,

                title:{
                    fontFamily: "Montserrat, sans-serif",

                    text: "Performance",
                    horizontalAlign: "left"
                },
                data: [{
                    type: "doughnut",
                    startAngle: 60,
                    //innerRadius: 60,
                    radius: "80%",
                    indexLabelLineThickness: 5,
                    indexLabelFontFamily: "Montserrat, sans-serif",

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
            performanceAllTime.render();



            var painMonth = new CanvasJS.Chart("painMonth", {

                animationEnabled: true,
                colorSet: "greenShades",
                backgroundColor: "#DDA8FF",
//                height: 400,
                width: window.innerWidth,

                title:{
                    fontFamily: "Montserrat, sans-serif",

                    text: "Pain",
                    horizontalAlign: "left"
                },
                data: [{
                    type: "doughnut",
                    startAngle: 60,
                    //innerRadius: 60,
                    radius: "80%",
                    indexLabelLineThickness: 5,
                    indexLabelFontFamily: "Montserrat, sans-serif",

                    indexLabelFontSize: 17,
                    indexLabel: "{label} - #percent%",
                    toolTipContent: "<b>{label}:</b> {y} (#percent%)",
                    dataPoints: [
                        <?php
                        echo "{y: $greenPainBarM, label: 'Green'},";
                        echo "{y: $amberPainBarM, label: 'Amber'},";
                        echo "{y: $redPainBarM, label: 'Red'},";
                        ?>
                    ]
                }]
            });
            painMonth.render();



            var breathMonth = new CanvasJS.Chart("breathMonth", {

                animationEnabled: true,
                colorSet: "greenShades",
                backgroundColor: "#DDA8FF",
//                height: 400,
                width: window.innerWidth,

                title:{
                    fontFamily: "Montserrat, sans-serif",

                    text: "Breathlessness",
                    horizontalAlign: "left"
                },
                data: [{
                    type: "doughnut",
                    startAngle: 60,
                    //innerRadius: 60,
                    radius: "80%",
                    indexLabelLineThickness: 5,
                    indexLabelFontFamily: "Montserrat, sans-serif",

                    indexLabelFontSize: 17,
                    indexLabel: "{label} - #percent%",
                    toolTipContent: "<b>{label}:</b> {y} (#percent%)",
                    dataPoints: [
                        <?php
                        echo "{y: $greenBBarM, label: 'Green'},";
                        echo "{y: $amberBBarM, label: 'Amber'},";
                        echo "{y: $redBBarM, label: 'Red'},";
                        ?>
                    ]
                }]
            });
            breathMonth.render();

            var performanceMonth = new CanvasJS.Chart("performanceMonth", {

                animationEnabled: true,
                colorSet: "greenShades",
                backgroundColor: "#DDA8FF",
//                height: 400,
                width: window.innerWidth,

                title:{
                    fontFamily: "Montserrat, sans-serif",

                    text: "Performance",
                    horizontalAlign: "left"
                },
                data: [{
                    type: "doughnut",
                    startAngle: 60,
                    //innerRadius: 60,
                    radius: "80%",
                    indexLabelLineThickness: 5,
                    indexLabelFontFamily: "Montserrat, sans-serif",

                    indexLabelFontSize: 17,
                    indexLabel: "{label} - #percent%",
                    toolTipContent: "<b>{label}:</b> {y} (#percent%)",
                    dataPoints: [
                        <?php
                        echo "{y: $greenPBarM, label: 'Green'},";
                        echo "{y: $amberPBarM, label: 'Amber'},";
                        echo "{y: $redPBarM, label: 'Red'},";
                        ?>
                    ]
                }]
            });
            performanceMonth.render();
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


<div class="jumbotron text-center" id="jumbo1">
    <h1>My Records Over the Past Month <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>
<div class="jumbotron text-center" id="jumbo2" style="display:none">
    <h1>My Records from the Beginning <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>
<br>

<?php if($entries!=0&&$entriesM!=0) { ?>
    <div class="box">
        <form method="get" class="radiostyle">
            <label class="radioContainer" style="font-family: Montserrat, sans-serif">Show chart based on all records
                <input type="radio" class="choices" name="radio" value="1" id="1" onclick="submitAll()">
                <span class="checkmark"></span>
            </label>
            <br>
            <label class="radioContainer" style="font-family: Montserrat, sans-serif">Show chart based on the records from
                this month
                <input type="radio" class="choices" name="radio" value="2" id="2" onclick="submitMonth()">
                <span class="checkmark"></span>

            </label>
        </form>
    </div>

    <?php
}
if($entries!=0) {

?>
<div id="allTime" style="position:absolute" class="center-div">
<div id="painAllTime" style="height: 40rem; width: 100%;"></div>
    <br>
    <br>
<div id="breathAllTime" style="height: 40rem; width:100%;"></div>
    <br>
    <br>
<div id="performanceAllTime" style="height: 40rem; width:100%;"></div>
    <br>
    <br>
    <?php }
    else{
        echo "<div class='box'><p>No records yet</p></div>";
    }
    ?>
</div>


<?php
if($entriesM!=0){?>
<div id="prevMonth" style="position:absolute" class="center-div">
    <div id="painMonth" style="height: 40rem;width: 100%;"></div>
    <br>
    <br>
    <div id="breathMonth" style="height: 40rem; width: 100%;"></div>
    <br>
    <br>
    <div id="performanceMonth" style="height: 40rem; width: 100%;"></div>
    <br>
    <br>
    <?php }
    else{
        echo "<div class='box'><p>No records over the past month</p></div>";
    }
    ?>
</div>
<br>
<?php
if($entriesM=0&&$entries=0){
?>
    <button class="btn" onclick="window.location.href='scale.php'">Make an entry</button>

    <?php
}
?>


<script>
    var x = document.getElementById("allTime");
    var y = document.getElementById("prevMonth");
    var jumbo1 = document.getElementById("jumbo1");
    var jumbo2 = document.getElementById("jumbo2");

    x.style.display="none";
    y.style.display="block";
    jumbo1.style.display="block";
    jumbo2.style.display="none";
    function submitAll(){
        if (x.style.display === "none") {
            x.style.display = "block";
            y.style.display="none";
            jumbo1.style.display="none";
            jumbo2.style.display="block";

        } else {
            x.style.display = "block";
            jumbo2.style.display="block";
            jumbo1.style.display="none";
        }
    }

    function submitMonth(){
        if (y.style.display === "none") {
            x.style.display="none";
            jumbo2.style.display="none";
            y.style.display = "block";
            jumbo1.style.display="block";
        } else {
            y.style.display = "block";
            jumbo1.style.display="block";
        }

    }
</script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</body>

<footer>
    <div class="footer">
        <div class="navbarBottom">
            <a onclick="goBack()" >BACK</a>
            <a href="weightChart.php" style="float:right">NEXT: WEIGHT CHART</a>
        </div>
    </div></footer>
</html>

