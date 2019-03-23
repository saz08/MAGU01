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
    <link rel="stylesheet" type="text/css" href="../stylesheets/donut.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/radio.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/navigation.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/alerts.css">

    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">

    <script src="../js/forAll.js"></script>
    <script src="../js/supportJS.js"></script>

    <meta charset="UTF-8">
    <title>Home</title>
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
        localStorage.setItem("loginOKSupport","no");
        alert("Session has expired, please log in again");

        window.location.href="supportSignUp.php";
    </script><?php
}

$getSurvivor = "SELECT `survivor` FROM `supportAcc` WHERE `username` = '$username'";
$result = $conn->query($getSurvivor);
if($result->num_rows>0){
    while($rowname=$result->fetch_assoc()){
        $survivor = $rowname["survivor"];
    }
}

//All Time: Pain- Green
$sql  = "SELECT * FROM `scale` WHERE `pain`<=3 AND `username` = '$survivor'";
$result= $conn->query($sql);
if($result->num_rows>0){
    $greenPain = $result->num_rows;
}
else{
    $greenPain=0;
}

//All Time: Pain- Amber
$sqlAMBER  = "SELECT * FROM `scale` WHERE `pain`>=4 AND `pain`<=7 AND `username` = '$survivor'";
$resultAMBER= $conn->query($sqlAMBER);
if($resultAMBER->num_rows>0){
    $amberPAIN = $resultAMBER->num_rows;
}
else{
    $amberPAIN=0;
}

//All Time: Pain- Red
$sqlRED  = "SELECT * FROM `scale` WHERE `pain`>=8  AND `username` = '$survivor'";
$resultRED= $conn->query($sqlRED);
if($resultRED->num_rows>0){
    $redPAIN = $resultRED->num_rows;
}
else{
    $redPAIN=0;
}

//All Time: Breathlessness- Green
$sqlBG  = "SELECT * FROM `scale` WHERE `breathlessness`<=1  AND `username` = '$survivor'";
$resultBG= $conn->query($sqlBG);
if($resultBG->num_rows>0){
    $greenBreath = $resultBG->num_rows;
}
else{
    $greenBreath=0;
}

//All Time: Breathlessness- Amber
$sqlBA  = "SELECT * FROM `scale` WHERE `breathlessness`>=2 AND `breathlessness` <=4  AND `username` = '$survivor'";
$resultBA= $conn->query($sqlBA);
if($resultBA->num_rows>0){
    $amberBreath = $resultBA->num_rows;
}
else{
    $amberBreath=0;
}

//All Time: Breathlessness- Red
$sqlBR  = "SELECT * FROM `scale` WHERE `breathlessness`>=5  AND `username` = '$survivor'";
$resultBR= $conn->query($sqlBR);
if($resultBR->num_rows>0){
    $redBreath = $resultBR->num_rows;
}
else{
    $redBreath=0;
}

//All Time: Performance- Green
$sqlPG  = "SELECT * FROM `scale` WHERE `performance`<=1  AND `username` = '$survivor'";
$resultPG= $conn->query($sqlPG);
if($resultPG->num_rows>0){
    $greenPerformance = $resultPG->num_rows;
}
else{
    $greenPerformance=0;
}

//All Time: Performance- Amber
$sqlPA  = "SELECT * FROM `scale` WHERE `performance`=2 AND `breathlessness` <=4  AND `username` = '$survivor'";
$resultPA= $conn->query($sqlPA);
if($resultPA->num_rows>0){
    $amberPerformance = $resultPA->num_rows;
}
else{
    $amberPerformance=0;
}

//All Time: Performance- Red
$sqlBP  = "SELECT * FROM `scale` WHERE `performance`>=3  AND `username` = '$survivor'";
$resultBP= $conn->query($sqlBP);
if($resultBP->num_rows>0){
    $redPerformance = $resultBP->num_rows;
}
else{
    $redPerformance=0;
}

//All Time: Total of all entries
$sqlEntries  = "SELECT * FROM `scale` WHERE `username` = '$survivor'";
$resultEntries= $conn->query($sqlEntries);
if($resultEntries->num_rows>0){
    $entries = $resultEntries->num_rows;
}
else{
    $entries=0;
}


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

//Previous Month: Pain- Green
    $sqlGPM  = "SELECT * FROM `scale` WHERE `pain`<=3 AND `username` = '$survivor' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
    $greenPM= $conn->query($sqlGPM);
    if($greenPM->num_rows>0){
        $greenPainM = $greenPM->num_rows;
    }
    else{
        $greenPainM=0;
    }

//Previous Month: Pain- Amber
$sqlAPM  = "SELECT * FROM `scale` WHERE `pain`>=4 AND `pain`<=7 AND `username` = '$survivor' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
    $amberPM= $conn->query($sqlAPM);
    if($amberPM->num_rows>0){
        $amberPainM = $amberPM->num_rows;
    }
    else{
        $amberPainM=0;
    }

//Previous Month: Pain- Red
$sqlRPM  = "SELECT * FROM `scale` WHERE `pain`>=8  AND `username` = '$survivor' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
    $redPM= $conn->query($sqlRPM);
    if($redPM->num_rows>0){
        $redPainM = $redPM->num_rows;
    }
    else{
        $redPainM=0;
    }

//Previous Month: Breathlessness- Green
    $sqlGBM  = "SELECT * FROM `scale` WHERE `breathlessness`<=1  AND `username` = '$survivor' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
    $resultBGM= $conn->query($sqlGBM);
    if($resultBGM->num_rows>0){
        $greenBreathM = $resultBGM->num_rows;
    }
    else{
        $greenBreathM=0;
    }

//Previous Month: Breathlessness- Amber
$sqlBAM  = "SELECT * FROM `scale` WHERE `breathlessness`>=2 AND `breathlessness` <=4  AND `username` = '$survivor' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
    $resultBAM= $conn->query($sqlBAM);
    if($resultBAM->num_rows>0){
        $amberBreathM = $resultBAM->num_rows;
    }
    else{
        $amberBreathM=0;
    }

//Previous Month: Breathlessness- Red
$sqlBRM  = "SELECT * FROM `scale` WHERE `breathlessness`>=5  AND `username` = '$survivor' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
    $resultBRM= $conn->query($sqlBRM);
    if($resultBRM->num_rows>0){
        $redBreathM = $resultBRM->num_rows;
    }
    else{
        $redBreathM=0;
    }

//Previous Month: Performance- Green
    $sqlPGM  = "SELECT * FROM `scale` WHERE `performance`<=1  AND `username` = '$survivor' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
    $resultPGM= $conn->query($sqlPGM);
    if($resultPGM->num_rows>0){
        $greenPerformanceM = $resultPGM->num_rows;
    }
    else{
        $greenPerformanceM=0;
    }

//Previous Month: Performance- Amber
$sqlPAM  = "SELECT * FROM `scale` WHERE `performance`=2 AND `breathlessness` <=4  AND `username` = '$survivor' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
    $resultPAM= $conn->query($sqlPAM);
    if($resultPAM->num_rows>0){
        $amberPerformanceM = $resultPAM->num_rows;
    }
    else{
        $amberPerformanceM=0;
    }

//Previous Month: Performance- Red
$sqlBPM  = "SELECT * FROM `scale` WHERE `performance`>=3  AND `username` = '$survivor' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
    $resultBPM= $conn->query($sqlBPM);
    if($resultBPM->num_rows>0){
        $redPerformanceM = $resultBPM->num_rows;
    }
    else{
        $redPerformanceM=0;
    }

//Previous Month: total number of entries
$sqlEntriesM  = "SELECT * FROM `scale` WHERE `username` = '$survivor' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
    $resultEntriesM= $conn->query($sqlEntriesM);
    if($resultEntriesM->num_rows>0){
        $entriesM = $resultEntriesM->num_rows;
    }
    else{
        $entriesM=0;
    }


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
else{
    $greenPainBarM = 0;
    $amberPainBarM = 0;
    $redPainBarM = 0;

    $greenBBarM = 0;
    $amberBBarM = 0;
    $redBBarM = 0;

    $greenPBarM = 0;
    $amberPBarM = 0;
    $redPBarM = 0;
}
?>

    <script>

        window.onload = function() {
            CanvasJS.addColorSet("greenShades",
                [
                    "#006700",
                    "#FE6C01",
                    "#B30000"
                ]);
            var painAllTime = new CanvasJS.Chart("painAllTime", {
//All Time: Pain
                animationEnabled: true,
                colorSet: "greenShades",
                backgroundColor: "#DDA8FF",
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
//All Time: Breathlessness
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
//All Time: Performance
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
//Prev month: Pain

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
//Prev month: Breathlessness
                animationEnabled: true,
                colorSet: "greenShades",
                backgroundColor: "#DDA8FF",
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
//Prev month: Performance
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
                <li><a href="supportHome.php">HOME</a></li>
                <li><a href="supportInput.php">RECORD</a></li>
                <?php
                //Show notification icon if the supporter has feedback from a health professional
                $sqlInfo = "SELECT * FROM `supportSubmit` WHERE `username` = '$username'";
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
                else{
                    $importantInfo=0;
                    $importantSymp=0;
                }

                if($importantInfo>0||$importantSymp>0){
                    echo "<li><a href='supportDocFeedback.php'>FEEDBACK <span class=\"glyphicon glyphicon-exclamation-sign\"></span></a></li>";
                }
                else{
                    echo"<li><a href='supportDocFeedback.php'>FEEDBACK</a></li>";
                }
                ?>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" onclick="openHelp()">HELP <span class="caret"></span></a>
                    <ul class="dropdown-menu" id="help">
                        <li><a href="healthInfo.php">INFO</a></li>
                        <li><a href="financialInfo.php">FINANCIAL</a></li>
                        <li><a href="emotionalInfo.php">EMOTIONAL</a></li>
                        <li><a href="physicalInfo.php">PHYSICAL</a></li>
                    </ul>
                </li>
            </ul>
            <ul class = "nav navbar-nav navbar-right">
                <li><a> <button class="btn" id="checkLogOut" onclick="logOutCheck()"  style="background-color: #E9969F;color:black;top:0 " >LOGOUT</button></a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="jumbotron text-center" id="jumbo1">
    <h1><?php echo  $survivor?>'s Records Over the Past Month<img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>
<div class="jumbotron text-center" id="jumbo2" style="display:none">
    <h1><?php echo  $survivor?>'s Records from the Beginning<img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>

<!--Modal: Logout Check-->
<div id="logOutCheck" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to log out?</p>
        <button id="spanSubmitCheck" class="btn" onclick="window.location.href='../patient/logout.php' ;document.getElementById('logOutCheck').style.display='none';">Yes</button>
        <button id="spanSubmitCheck" class="btn" onclick="document.getElementById('logOutCheck').style.display='none';">No</button>
    </div>
</div>
<br>
<br>
<!--Colour key sidebar-->
<div class="sideBar" id="mySidebar">
    <br>
    <button class="closebtn" onclick="closeColourNav()" > <b>< CLOSE</b></button>
    <div class="circleKey" style="background-color:#006700 ;"></div>
    <p >Pain below 4. Breathlessness and Performance below 2</p>
    <div class="circleKey" style="background-color:#FE6C01;"></div>
    <p >Pain between 4 and 7. Breathlessness between 2 and 4 and Performance of 2</p>
    <div class="circleKey" style="background-color:#B30000 ;"></div>
    <p >Pain greater than 7. Breathlessness greater than 4 and Performance greater than 3</p>
</div>

<!--Number key sidebar-->
<div class="sideBar" id="mySidebar2">
    <br>
    <button class="closebtn" onclick="closeNumberNav()" > <b>< CLOSE</b> </button>
    <p><b>Pain</b> is scored between 0 to 10.</p><p> 0 meaning no pain and 10 meaning extremely painful</p>
    <p><b>Breathlessness</b> is scored between 1 to 5. </p><p>1 meaning not troubled by breathlessness, and 5 meaning too breathless to leave the house</p>
    <p><b>Performance</b> is scored between 0 to 4.</p><p> 0 meaning fully active and 4 meaning completely disabled.</p>

</div>
<?php
if($entriesM!=0||$entries!=0) {
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
                <input type="radio" class="choices" name="radio" value="2" id="2" onclick="submitMonth()" checked>
                <span class="checkmark"></span>

            </label>
        </form>
    </div>
    <button class="openbtn" onclick="openColourNav()">☰ Show Colour Key</button>
    <button class="openbtn" onclick="openNumberNav()">☰ Show Number Key</button>
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
        echo "<div class='box'><p>No records yet</p></div>";
    }
    ?>
</div>
<br>

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
        ?><script>document.getElementById("noRecords").style.display="block";</script><?php
    }
    ?>
    <div class='box' id='noRecords' style="display:none"><p>No records over the past month</p></div><br><br>

</div>
<br>



<script>
//Functions to toggle between what div to display
var x = document.getElementById("allTime");
var y = document.getElementById("prevMonth");
var jumbo1 = document.getElementById("jumbo1");
var jumbo2 = document.getElementById("jumbo2");
var none = document.getElementById("noRecords");
none.style.display="block";
x.style.display = "none";
y.style.display = "block";
jumbo1.style.display = "block";
jumbo2.style.display = "none";



function submitAll() {
    if (x.style.display === "none") {
        x.style.display = "block";
        jumbo2.style.display = "block";
        jumbo1.style.display = "none";
        none.style.display="none";
        y.style.display = "none";
    } else {
        x.style.display = "block";
        jumbo2.style.display = "block";
        jumbo1.style.display = "none";
    }
    if(jumbo2.style.display="none"){
        jumbo2.style.display = "block";

    }
}

function submitMonth() {
    x.style.display = "none";
    none.style.display="block";
    jumbo1.style.display = "block";
    jumbo2.style.display = "none";
    if (y.style.display === "none") {
        x.style.display = "none";
        jumbo2.style.display = "none";
        y.style.display = "block";
        jumbo1.style.display = "block";
        none.style.display="none";
    } else {
        y.style.display = "block";
        jumbo1.style.display = "block";
    }
}
    function next(){
        window.location.href="supportInput.php";
    }
</script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>



<div class="clear"></div>
</body>
<footer>
    <div class="footer">
        <button class="btn" onclick="goBack()" style="float:left"><b><</b> Back </button>
        <button class="btn" style="float:right" onclick="next()"> Next <b> > </b></button>
    </div>

</footer>
</html>