<?php
session_start();
function safePOST($conn, $name)
{
    if (isset($_POST[$name])) {
        return $conn->real_escape_string(strip_tags($_POST[$name]));
    } else {
        return "";
    }
}

function safePOSTNonMySQL($name)
{
    if (isset($_POST[$name])) {
        return strip_tags($_POST[$name]);
    } else {
        return "";
    }
}

//Connect to Database
$host = "devweb2018.cis.strath.ac.uk";
$user = "szb15123";
$pass = "fadooCha4buh";
$dbname = "szb15123";
$conn = new mysqli($host, $user, $pass, $dbname);
$action = safePOST($conn, "action");
$month = date("m");
$year = date("Y");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
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
    <link rel="stylesheet" type="text/css" href="../stylesheets/alerts.css">

    <meta charset="UTF-8">
    <title>Status Charts</title>
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">


<?php
//Detect if session is still running. If not, direct user to login
if ($_SESSION["userName"] != null) {
    $username = $_SESSION["userName"];
} else {
    ?>
    <script>
        localStorage.setItem("username", "unknownUser");
        localStorage.setItem("loginOKDoc", "no");
        alert("Session has expired, please log in again");
        window.location.href = "docSignUp.php";
    </script>
    <?php
}
//Get the ID of the patient chosen from the URL
$id = $_GET['id'];
//Get all patient details
$sql = "SELECT * FROM `chi` WHERE `id` = '$id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($rowname = $result->fetch_assoc()) {
        $patientname = $rowname["forename"];
        $surname = $rowname["surname"];
    }
}
//All Time: Pain- Green
$sql = "SELECT * FROM `scale` WHERE `pain`<=3 AND `id` = '$id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $greenPain = $result->num_rows;
} else {
    $greenPain = 0;
}
//All Time: Pain- Amber
$sqlAMBER = "SELECT * FROM `scale` WHERE `pain`>=4 AND `pain`<=7 AND `id` = '$id'";
$resultAMBER = $conn->query($sqlAMBER);
if ($resultAMBER->num_rows > 0) {
    $amberPAIN = $resultAMBER->num_rows;
} else {
    $amberPAIN = 0;
}
//All Time: Pain- Red
$sqlRED = "SELECT * FROM `scale` WHERE `pain`>=8  AND `id` = '$id'";
$resultRED = $conn->query($sqlRED);
if ($resultRED->num_rows > 0) {
    $redPAIN = $resultRED->num_rows;
} else {
    $redPAIN = 0;
}
//All Time: Breathlessness- Green
$sqlBG = "SELECT * FROM `scale` WHERE `breathlessness`<=1  AND `id` = '$id'";
$resultBG = $conn->query($sqlBG);
if ($resultBG->num_rows > 0) {
    $greenBreath = $resultBG->num_rows;
} else {
    $greenBreath = 0;
}
//All Time: Breathlessness- Amber
$sqlBA = "SELECT * FROM `scale` WHERE `breathlessness`>=2 AND `breathlessness` <=4  AND `id` = '$id'";
$resultBA = $conn->query($sqlBA);
if ($resultBA->num_rows > 0) {
    $amberBreath = $resultBA->num_rows;
} else {
    $amberBreath = 0;
}
//All Time: Breathlessness- Red
$sqlBR = "SELECT * FROM `scale` WHERE `breathlessness`>=5  AND `id` = '$id'";
$resultBR = $conn->query($sqlBR);
if ($resultBR->num_rows > 0) {
    $redBreath = $resultBR->num_rows;
} else {
    $redBreath = 0;
}
//All Time: Performance- Green
$sqlPG = "SELECT * FROM `scale` WHERE `performance`<=1  AND `id` = '$id'";
$resultPG = $conn->query($sqlPG);
if ($resultPG->num_rows > 0) {
    $greenPerformance = $resultPG->num_rows;
} else {
    $greenPerformance = 0;
}
//All Time: Performance- Amber
$sqlPA = "SELECT * FROM `scale` WHERE `performance`=2 AND `performance` <=4  AND `id` = '$id'";
$resultPA = $conn->query($sqlPA);
if ($resultPA->num_rows > 0) {
    $amberPerformance = $resultPA->num_rows;
} else {
    $amberPerformance = 0;
}
//All Time: Performance- Performance
$sqlBP = "SELECT * FROM `scale` WHERE `performance`>=3  AND `id` = '$id'";
$resultBP = $conn->query($sqlBP);
if ($resultBP->num_rows > 0) {
    $redPerformance = $resultBP->num_rows;
} else {
    $redPerformance = 0;
}
//All Time: Total number of entries
$sqlEntries = "SELECT * FROM `scale` WHERE `id` = '$id'";
$resultEntries = $conn->query($sqlEntries);
if ($resultEntries->num_rows > 0) {
    $entries = $resultEntries->num_rows;
} else {
    $entries = 0;
}
if ($entries != 0) {
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
//Previous month: Pain- Green
$sqlGPM = "SELECT * FROM `scale` WHERE `pain`<=3 AND `id` = '$id' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$greenPM = $conn->query($sqlGPM);
if ($greenPM->num_rows > 0) {
    $greenPainM = $greenPM->num_rows;
} else {
    $greenPainM = 0;
}
//Previous month: Pain- Amber
$sqlAPM = "SELECT * FROM `scale` WHERE `pain`>=4 AND `pain`<=7 AND `id` = '$id' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$amberPM = $conn->query($sqlAPM);
if ($amberPM->num_rows > 0) {
    $amberPainM = $amberPM->num_rows;
} else {
    $amberPainM = 0;
}
//Previous month: Pain- Red
$sqlRPM = "SELECT * FROM `scale` WHERE `pain`>=8  AND `id` = '$id' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$redPM = $conn->query($sqlRPM);
if ($redPM->num_rows > 0) {
    $redPainM = $redPM->num_rows;
} else {
    $redPainM = 0;
}
//Previous month: Breathlessness- Green
$sqlGBM = "SELECT * FROM `scale` WHERE `breathlessness`<=1  AND `id` = '$id' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultBGM = $conn->query($sqlGBM);
if ($resultBGM->num_rows > 0) {
    $greenBreathM = $resultBGM->num_rows;
} else {
    $greenBreathM = 0;
}
//Previous month: Breathlessness- Amber
$sqlBAM = "SELECT * FROM `scale` WHERE `breathlessness`>=2 AND `breathlessness` <=4  AND `id` = '$id' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultBAM = $conn->query($sqlBAM);
if ($resultBAM->num_rows > 0) {
    $amberBreathM = $resultBAM->num_rows;
} else {
    $amberBreathM = 0;
}
//Previous month: Breathlessness- Red
$sqlBRM = "SELECT * FROM `scale` WHERE `breathlessness`>=5  AND `id` = '$id' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultBRM = $conn->query($sqlBRM);
if ($resultBRM->num_rows > 0) {
    $redBreathM = $resultBRM->num_rows;
} else {
    $redBreathM = 0;
}
//Previous month: Performance- Green
$sqlPGM = "SELECT * FROM `scale` WHERE `performance`<=1  AND `id` = '$id' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultPGM = $conn->query($sqlPGM);
if ($resultPGM->num_rows > 0) {
    $greenPerformanceM = $resultPGM->num_rows;
} else {
    $greenPerformanceM = 0;
}
//Previous month: Performance- Amber
$sqlPAM = "SELECT * FROM `scale` WHERE `performance`=2 AND `performance` <=4  AND `id` = '$id' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultPAM = $conn->query($sqlPAM);
if ($resultPAM->num_rows > 0) {
    $amberPerformanceM = $resultPAM->num_rows;
} else {
    $amberPerformanceM = 0;
}
//Previous month: Performance- Red
$sqlBPM = "SELECT * FROM `scale` WHERE `performance`>=3  AND `id` = '$id' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultBPM = $conn->query($sqlBPM);
if ($resultBPM->num_rows > 0) {
    $redPerformanceM = $resultBPM->num_rows;
} else {
    $redPerformanceM = 0;
}
//Previous month: total number of entries
$sqlEntriesM = "SELECT * FROM `scale` WHERE `id` = '$id' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultEntriesM = $conn->query($sqlEntriesM);
if ($resultEntriesM->num_rows > 0) {
    $entriesM = $resultEntriesM->num_rows;
} else {
    $entriesM = 0;
}
if ($entriesM != 0) {
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
    window.onload = function () {

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
            title: {
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
            width: window.innerWidth,
            title: {
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
            width: window.innerWidth,
            title: {
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
            //Prev Month: Pain
            animationEnabled: true,
            colorSet: "greenShades",
            backgroundColor: "#DDA8FF",
            width: window.innerWidth,
            title: {
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
            //Prev Month: Breathlessness
            animationEnabled: true,
            colorSet: "greenShades",
            backgroundColor: "#DDA8FF",
            width: window.innerWidth,
            title: {
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
            //Prev Month: Performance
            animationEnabled: true,
            colorSet: "greenShades",
            backgroundColor: "#DDA8FF",
            width: window.innerWidth,
            title: {
                fontFamily: "Montserrat, sans-serif",
                text: "Performance",
                horizontalAlign: "center"
            },
            data: [{
                type: "doughnut",
                startAngle: 60,
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
            <a class="navbar-brand" href="#myPage"> </a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="dashboard.php">DASHBOARD</a></li>
                <li><a href="createID.php">ADD PATIENT</a></li>
                <li><a href="../patient/talk.php">FORUM</a></li>

                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" onclick="openInfo()">PATIENT
                        INFORMATION <span class="caret"></span></a>
                    <ul class="dropdown-menu" id="info">
                        <li><a href="patient.php?id=<?php echo +$id ?>">CONTACT</a></li>
                        <?php
                        //Show an information notification if a user has sent additional information
                        $sqlRecords = "SELECT * FROM `scale` WHERE `id` = '$id'";
                        $resultRecords = $conn->query($sqlRecords);
                        if ($resultRecords->num_rows > 0) {
                            $counterInfo1 = 0;
                            $counterSymp1 = 0;
                            while ($rowname = $resultRecords->fetch_assoc()) {
                                $symptom = $rowname["symptom"];
                                $additional = $rowname["additionalInfo"];
                                $seenInfo = $rowname["seenInfo"];
                                $resInfo = $rowname["resInfo"];
                                $seenSymp = $rowname["seenSymp"];
                                $resSymp = $rowname["resSymp"];
                                if ($seenInfo === "false") {
                                    if ($additional != "") {
                                        $counterInfo1++;
                                    }
                                }
                                if ($seenSymp === "false") {
                                    if ($symptom != "") {
                                        $counterSymp1++;
                                    }
                                }
                            }
                        } else {
                            $counterInfo1 = 0;
                            $counterSymp1 = 0;
                        }
                        if ($counterInfo1 > 0 || $counterSymp1 > 0) {
                            echo "<li><a href='patientInfo.php?id=+$id'>PROFILE <span class=\"glyphicon glyphicon-exclamation-sign\"></span></a></li>";
                        } else {
                            echo "<li><a href='patientInfo.php?id=+$id'>PROFILE</a></li>";
                        }
                        ?>
                        <li><a href="progress.php?id=<?php echo +$id ?>">STATUS CHARTS</a></li>
                        <li><a href="weightChartDoc.php?id=<?php echo +$id ?>">WEIGHT CHART</a></li>
                        <?php
                        //Show an information notification if a supporter has sent additional information
                        $sqlUser = "SELECT * FROM `account` WHERE `id` = '$id'";
                        $userResult = $conn->query($sqlUser);
                        if ($userResult->num_rows > 0) {
                            while ($rowname = $userResult->fetch_assoc()) {
                                $usernameSurvivor = $rowname["username"];
                                $sqlInfo = "SELECT * FROM `supportSubmit` WHERE `survivor` = '$usernameSurvivor'";
                                $supportInfo = $conn->query($sqlInfo);
                                if ($supportInfo->num_rows > 0) {
                                    $counterInfo = 0;
                                    $counterSymp = 0;
                                    while ($rowname = $supportInfo->fetch_assoc()) {
                                        $symptom = $rowname["symptom"];
                                        $additional = $rowname["additional"];
                                        $seenInfo = $rowname["seenInfo"];
                                        $seenSymp = $rowname["seenSymp"];
                                        if ($seenInfo === "false") {
                                            if ($additional != "") {
                                                $counterInfo++;
                                            }
                                        }
                                        if ($seenSymp === "false") {
                                            if ($symptom != "") {
                                                $counterSymp++;
                                            }
                                        }
                                    }
                                } else {
                                    $counterInfo = 0;
                                    $counterSymp = 0;
                                }
                            }
                        } else {
                            $counterInfo = 0;
                            $counterSymp = 0;
                        }
                        if ($counterInfo > 0 || $counterSymp > 0) {
                            echo "<li><a href='proSupport.php?id=+$id'>SUPPORT CIRCLE <span class=\"glyphicon glyphicon-exclamation-sign\"></span></a></li>";
                        } else {
                            echo "<li><a href='proSupport.php?id=+$id'>SUPPORT CIRCLE</a></li>";
                        }
                        ?>
                    </ul>
                </li>

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a>
                        <button class="btn" id="checkLogOut" onclick="logOutCheck()"
                                style="background-color: #E9969F;color:black;top:0 ">LOGOUT
                        </button>
                    </a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="jumbotron text-center" id="jumbo1" style="display: block;">
    <h1><?php echo $patientname . " " . $surname ?>'s Records Over the Past Month<img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/">
    </h1>
    <br>
</div>

<div class="jumbotron text-center" id="jumbo2" style="display: none;" >
    <h1><?php echo $patientname . " " . $surname ?>'s Records from the Beginning<img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/">
    </h1>
</div>

<!--Modal: Logout Check-->
<div id="logOutCheck" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to log out?</p>
        <button id="spanSubmitCheck" class="btn"
                onclick="window.location.href='../patient/logout.php' ;document.getElementById('logOutCheck').style.display='none';">
            Yes
        </button>
        <button id="spanSubmitCheck" class="btn" onclick="document.getElementById('logOutCheck').style.display='none';">
            No
        </button>
    </div>
</div>




<?php
//If there are entries, show options for chart
if ($entries != 0 || $entriesM != 0) {
    ?>
    <!--Buttons to open Colour and Number Key Sidebar-->
    <button class="openbtn" onclick="openProgressNav()">☰ Show Colour Key</button>
    <button class="openbtn" onclick="openNumberNav()">☰ Show Number Key</button>
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

    <!--Colour Key Sidebar-->
    <div class="sideBar" id="mySidebar">
        <br>
        <button class="closebtn" onclick="closeProgressNav()"><b>< CLOSE</b></button>
        <div class="circleKey" style="background-color:#006700 ;"></div>
        <p>Pain below 4</p>
        <p>Breathlessness below 2</p>
        <p>Performance below 2</p>
        <div class="circleKey" style="background-color:#FE6C01;"></div>
        <p>Pain between 4 and 7</p>
        <p>Breathlessness between 2 and 4</p>
        <p>Performance score of 2</p>

        <div class="circleKey" style="background-color:#B30000 ;"></div>
        <p>Pain greater than 7 </p>
        <p>Breathlessness greater than 4</p>
        <p>Performance greater than 3</p>

    </div>

    <!--    Number Key Sidebar-->
    <div class="sideBar" id="mySidebar2">
        <br>
        <button class="closebtn" onclick="closeNumberNav()"><b>< CLOSE</b></button>
        <p><b>Pain</b> is scored between 0 to 10.</p>
        <p> 0 meaning no pain and 10 meaning extremely painful</p>
        <p><b>Breathlessness</b> is scored between 1 to 5. </p>
        <p>1 meaning not troubled by breathlessness, and 5 meaning too breathless to leave the house</p>
        <p><b>Performance</b> is scored between 0 to 4.</p>
        <p> 0 meaning fully active and 4 meaning completely disabled.</p>

    </div>
    <?php
}
?>
<?php
if ($entries != 0) {
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
    else {
        echo "<div class='box'><p>No records yet</p></div>";
    }
    ?>
</div>

<?php
if ($entriesM != 0){
?>
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
    else {
        ?><script>document.getElementById("noRecords").style.display="block";</script><?php
    }
    ?>
    <div class='box' id='noRecords' style="display:none"><p>No records over the past month</p></div><br><br>
</div>
<br>

<script>
    //Functions to toggle the divs that contain the charts
    var x = document.getElementById("allTime");
    var y = document.getElementById("prevMonth");
    var jumbo1 = document.getElementById("jumbo1");
    var jumbo2 = document.getElementById("jumbo2");
    var none = document.getElementById("noRecords");
    none.style.display="none";
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

    function next() {
        window.location.href = "weightChartDoc.php?id=+<?php echo $id ?>";
    }
</script>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<div class="clear"></div>
</body>
<footer>
    <div class="footer">
        <div class="footer">
            <button class="btn" onclick="goBack()" style="float:left"><b><</b> Back</button>
            <button class="btn" style="float:right" onclick="next()"> Next <b> > </b></button>
        </div>
    </div>
</footer>
</html>