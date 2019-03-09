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

$id = $_GET['id'];


$sql = "SELECT `forename` FROM `chi` WHERE `id` = '$id'";
$result = $conn->query($sql);
if($result->num_rows>0) {
    while ($rowname = $result->fetch_assoc()) {
        $patientname = $rowname["forename"];
    }
}




$sql  = "SELECT * FROM `scale` WHERE `pain`<=3 AND `id` = '$id'";
$result= $conn->query($sql);
if($result->num_rows>0){
    $greenPain = $result->num_rows;
}
else{
    $greenPain=0;
}

$sqlAMBER  = "SELECT * FROM `scale` WHERE `pain`>=4 AND `pain`<=7 AND `id` = '$id'";
$resultAMBER= $conn->query($sqlAMBER);
if($resultAMBER->num_rows>0){
    $amberPAIN = $resultAMBER->num_rows;
}
else{
    $amberPAIN=0;
}

$sqlRED  = "SELECT * FROM `scale` WHERE `pain`>=8  AND `id` = '$id'";
$resultRED= $conn->query($sqlRED);
if($resultRED->num_rows>0){
    $redPAIN = $resultRED->num_rows;
}
else{
    $redPAIN=0;
}

$painTotal = $greenPain+$amberPAIN+$redPAIN;

$sqlBG  = "SELECT * FROM `scale` WHERE `breathlessness`<=1  AND `id` = '$id'";
$resultBG= $conn->query($sqlBG);
if($resultBG->num_rows>0){
    $greenBreath = $resultBG->num_rows;
}
else{
    $greenBreath=0;
}

$sqlBA  = "SELECT * FROM `scale` WHERE `breathlessness`>=2 AND `breathlessness` <=4  AND `id` = '$id'";
$resultBA= $conn->query($sqlBA);
if($resultBA->num_rows>0){
    $amberBreath = $resultBA->num_rows;
}
else{
    $amberBreath=0;
}

$sqlBR  = "SELECT * FROM `scale` WHERE `breathlessness`>=5  AND `id` = '$id'";
$resultBR= $conn->query($sqlBR);
if($resultBR->num_rows>0){
    $redBreath = $resultBR->num_rows;
}
else{
    $redBreath=0;
}

$breathlessnessTotal = $greenBreath+$amberBreath+$redBreath;

$sqlPG  = "SELECT * FROM `scale` WHERE `performance`<=1  AND `id` = '$id'";
$resultPG= $conn->query($sqlPG);
if($resultPG->num_rows>0){
    $greenPerformance = $resultPG->num_rows;
}
else{
    $greenPerformance=0;
}

$sqlPA  = "SELECT * FROM `scale` WHERE `performance`=2 AND `breathlessness` <=4  AND `id` = '$id'";
$resultPA= $conn->query($sqlPA);
if($resultPA->num_rows>0){
    $amberPerformance = $resultPA->num_rows;
}
else{
    $amberPerformance=0;
}

$sqlBP  = "SELECT * FROM `scale` WHERE `performance`>=3  AND `id` = '$id'";
$resultBP= $conn->query($sqlBP);
if($resultBP->num_rows>0){
    $redPerformance = $resultBP->num_rows;
}
else{
    $redPerformance=0;
}

$sqlEntries  = "SELECT * FROM `scale` WHERE `id` = '$id'";
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


$sqlGPM  = "SELECT * FROM `scale` WHERE `pain`<=3 AND `id` = '$id' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$greenPM= $conn->query($sqlGPM);
if($greenPM->num_rows>0){
    $greenPainM = $greenPM->num_rows;
}
else{
    $greenPainM=0;
}

$sqlAPM  = "SELECT * FROM `scale` WHERE `pain`>=4 AND `pain`<=7 AND `id` = '$id' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$amberPM= $conn->query($sqlAPM);
if($amberPM->num_rows>0){
    $amberPainM = $amberPM->num_rows;
}
else{
    $amberPainM=0;
}

$sqlRPM  = "SELECT * FROM `scale` WHERE `pain`>=8  AND `id` = '$id' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$redPM= $conn->query($sqlRPM);
if($redPM->num_rows>0){
    $redPainM = $redPM->num_rows;
}
else{
    $redPainM=0;
}

$painTotalMonth = $greenPainM+$amberPainM+$redPainM;

$sqlGBM  = "SELECT * FROM `scale` WHERE `breathlessness`<=1  AND `id` = '$id' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultBGM= $conn->query($sqlGBM);
if($resultBGM->num_rows>0){
    $greenBreathM = $resultBGM->num_rows;
}
else{
    $greenBreathM=0;
}

$sqlBAM  = "SELECT * FROM `scale` WHERE `breathlessness`>=2 AND `breathlessness` <=4  AND `id` = '$id' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultBAM= $conn->query($sqlBAM);
if($resultBAM->num_rows>0){
    $amberBreathM = $resultBAM->num_rows;
}
else{
    $amberBreathM=0;
}

$sqlBRM  = "SELECT * FROM `scale` WHERE `breathlessness`>=5  AND `id` = '$id' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultBRM= $conn->query($sqlBRM);
if($resultBRM->num_rows>0){
    $redBreathM = $resultBRM->num_rows;
}
else{
    $redBreathM=0;
}

$breathlessnessTotalM = $greenBreathM+$amberBreathM+$redBreathM;

$sqlPGM  = "SELECT * FROM `scale` WHERE `performance`<=1  AND `id` = '$id' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultPGM= $conn->query($sqlPGM);
if($resultPGM->num_rows>0){
    $greenPerformanceM = $resultPGM->num_rows;
}
else{
    $greenPerformanceM=0;
}

$sqlPAM  = "SELECT * FROM `scale` WHERE `performance`=2 AND `breathlessness` <=4  AND `id` = '$id' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultPAM= $conn->query($sqlPAM);
if($resultPAM->num_rows>0){
    $amberPerformanceM = $resultPAM->num_rows;
}
else{
    $amberPerformanceM=0;
}

$sqlBPM  = "SELECT * FROM `scale` WHERE `performance`>=3  AND `id` = '$id' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultBPM= $conn->query($sqlBPM);
if($resultBPM->num_rows>0){
    $redPerformanceM = $resultBPM->num_rows;
}
else{
    $redPerformanceM=0;
}

$sqlEntriesM  = "SELECT * FROM `scale` WHERE `id` = '$id' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
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
    <script src="../js/forAll.js"></script>
    <script src="../js/docJS.js"></script>

    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">
    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/radio.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/navigation.css">

    <meta charset="UTF-8">
    <title>Project</title>
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

                    horizontalAlign: "center"
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
                    horizontalAlign: "center"
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
                    horizontalAlign: "center"
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
                    horizontalAlign: "center"
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
                    horizontalAlign: "center"
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
                    horizontalAlign: "center"
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
    <script>
        function openNav() {
            if(screen.width<500){
                document.getElementById("mySidebar").style.width = "90%";
            }
            if(screen.width>500){
                document.getElementById("mySidebar").style.width = "30%";

            }
        }

        function closeNav() {
            if(screen.width<500){
                document.getElementById("mySidebar").style.width = "0";

            }
            if(screen.width>500) {
                document.getElementById("mySidebar").style.width = "0";
            }
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
                <li><a href="dashboard.php">DASHBOARD</a></li>
                <li><a href="createID.php">ADD PATIENT</a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">PATIENT INFORMATION <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="patient.php?id=<?php echo +$id ?>">CONTACT</a></li>
                        <li><a href="patientInfo.php?id=<?php echo +$id ?>">RECORDS</a></li>
                        <li><a href="progress.php?id=<?php echo +$id ?>">STATUS CHARTS</a></li>
                        <li><a href="weightChartDoc.php?id=<?php echo +$id ?>">WEIGHT CHART</a></li>
                        <?php
                        $sqlUser = "SELECT * FROM `account` WHERE `id` = '$id'";
                        $userResult = $conn->query($sqlUser);
                        if($userResult->num_rows>0) {
                            while ($rowname = $userResult->fetch_assoc()) {
                                $usernameSurvivor = $rowname["username"];
                                $sqlInfo = "SELECT * FROM `supportSubmit` WHERE `survivor` = '$usernameSurvivor'";
                                $supportInfo = $conn->query($sqlInfo);
                                if ($supportInfo->num_rows > 0) {
                                    while ($rowname = $supportInfo->fetch_assoc()) {
                                        $symptom = $rowname["symptom"];
                                        $additional = $rowname["additional"];
                                        $seenInfo = $rowname["seenInfo"];
                                        $seenSymp = $rowname["seenSymp"];
                                        $importantInfo="false";
                                        $importantSymp="false";

                                        if ($seenInfo === "false") {
                                            if ($additional != "") {
                                                $importantInfo="true";
                                            }
                                        }
                                        else{
                                            $importantInfo="false";
                                        }
                                        if ($seenSymp === "false") {
                                            if ($symptom != "") {
                                                $importantSymp="true";
                                            }
                                        }
                                        else{
                                            $importantSymp="false";
                                        }
                                    }
                                }
                                else {
                                    $importantInfo="false";
                                    $importantSymp="false";
                                }
                            }
                        }
                        else{
                            $importantInfo="false";
                            $importantSymp="false";
                        }
                        if($importantInfo==="true"||$importantSymp==="true"){
                            echo "<li><a href='proSupport.php?id=+$id'>SUPPORT CIRCLE <span class=\"glyphicon glyphicon-exclamation-sign\"></span></a></li>";

                        }
                        else{
                            echo"<li><a href='proSupport.php?id=+$id'>SUPPORT CIRCLE</a></li>";

                        }
                        ?>
                    </ul>
                </li>

            </ul>
            <ul class = "nav navbar-nav navbar-right">
                <li><a href="../patient/logout.php">LOGOUT</a></li>
            </ul>
        </div>
    </div>
</nav>




<div class="jumbotron text-center" id="jumbo1">
    <h1><?php echo  $patientname?>'s Records Over the Past Month<img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
    <br>
</div>
<div class="jumbotron text-center" id="jumbo2" style="display:none">
    <h1><?php echo  $patientname?>'s Records from the Beginning<img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>
<br>
<?php
if($entries!=0&&$entriesM!=0) {
    ?>
    <div class="box">
        <form method="get" class="radiostyle">
            <label class="radioContainer" style="font-family: Montserrat, sans-serif">Show chart based on all records
                <input type="radio" class="choices" name="radio" value="1" id="1" onclick="submitAll()">
                <span class="checkmark"></span>

            </label>
            <br>
            <label class="radioContainer" style="font-family: Montserrat, sans-serif">Show chart based on the records
                from this month
                <input type="radio" class="choices" name="radio" value="2" id="2" onclick="submitMonth()" checked >
                <span class="checkmark" ></span>

            </label>
        </form>
    </div>
    <button class="openbtn" onclick="openNav()">☰ Show Colour Key</button>


    <div class="sideBar" id="mySidebar">
        <a class="closebtn" onclick="closeNav()" > <b>< CLOSE</b> </a>
        <div class="circleKey" style="background-color:#008D00 ;"></div>
        <p >Pain below 4. Breathlessness and Performance below 2</p>
        <div class="circleKey" style="background-color:#E8AE00;"></div>
        <p >Pain between 4 and 7. Breathlessness between 2 and 4 and Performance of 2</p>
        <div class="circleKey" style="background-color:#FF0000 ;"></div>
        <p >Pain greater than 7. Breathlessness greater than 4 and Performance greater than 3</p>

    </div>
    <?php
}
?>
<?php
if($entries!=0) {

?>
<div id="allTime" style="position:absolute" class="center-div">
    <div id="painAllTime" style="height: 40rem; width: 100%;"></div>
    <br>
    <br>
    <div id="breathAllTime" style="height: 40rem; width: 100%;"></div>
    <br>
    <br>
    <div id="performanceAllTime" style="height: 40rem; width: 100%;"></div>
    <br>
    <br>
    <?php }
    else{
        echo "<p>No records yet</p>";
    }
    ?>
</div>

<?php
if($entriesM!=0){?>
<div id="prevMonth" style="position:absolute" class="center-div">
    <div id="painMonth" style="height: 40rem; width: 100%;"></div>
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
        echo "<p>No records over the past month</p>";
    }
    ?>
</div>

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

function next(){
        window.location.href="weightChartDoc.php?id=+<?php echo $id ?>";
}
</script>



<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


<div class="clear"></div>
</body>
<footer>
    <div class="footer">
        <div class="footer">
            <button class="btn" onclick="goBack()" style="float:left"><b><</b> Back </button>
            <button class="btn" style="float:right" onclick="next()"> Next <b> > </b></button>
        </div>
    </div>
</footer>
</html>