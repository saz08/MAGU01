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

$id = $_GET["id"];

$sql = "SELECT `forename` FROM `chi` WHERE `id` = '$id'";
$result = $conn->query($sql);
if($result->num_rows>0) {
while ($rowname = $result->fetch_assoc()) {
    $patientname = $rowname["forename"];
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
    <script src="../js/forAll.js"></script>
    <script src="../js/docJS.js"></script>

    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">
    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/navigation.css">


    <meta charset="UTF-8">
    <title>Project</title>
    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title:{
                    text: "Weight Monitoring"
                },
                axisY:{
                    includeZero: false
                },
                data: [{
                    type: "line",
                    dataPoints: [
                        <?php
                        $sql = "SELECT * FROM `weight` WHERE `id` = '$id'";
                        $result= $conn->query($sql);
                        if($result->num_rows>0) {
                            while ($rowname = $result->fetch_assoc()) {
                                $y = $rowname["lbs"];
                                $timestamp = $rowname["timeStamp"];
                                $date2 = (new DateTime($timestamp))->format('d m Y');
                                echo "{y: $y},";
                            }
                        }
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
                <li><a href="dashboard.php">DASHBOARD</a></li>
                <li><a href="createID.php">ADD PATIENT</a></li>
                <li><a href="../patient/talk.php">FORUM</a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" onclick="openInfo()">PATIENT INFORMATION <span class="caret"></span></a>
                    <ul class="dropdown-menu" id="info">
                        <li><a href="patient.php?id=<?php echo +$id ?>">CONTACT</a></li>
                        <?php
                        $sqlRecords = "SELECT * FROM `scale` WHERE `id` = '$id'";
                        $resultRecords = $conn->query($sqlRecords);
                        if ($resultRecords->num_rows > 0) {
                            while ($rowname = $resultRecords->fetch_assoc()) {
                                $symptom = $rowname["symptom"];
                                $additional = $rowname["additionalInfo"];
                                $seenInfo = $rowname["seenInfo"];
                                $resInfo = $rowname["resInfo"];
                                $seenSymp = $rowname["seenSymp"];
                                $resSymp = $rowname["resSymp"];
                                $importantInfo = "false";
                                $importantSymp = "false";
                                if ($seenInfo === "false") {
                                    if ($additional != "") {
                                        $importantInfo = "true";
                                    }
                                } else {
                                    $importantInfo = "false";
                                }
                                if ($seenSymp === "false") {
                                    if ($symptom != "") {
                                        $importantSymp = "true";
                                    }
                                } else {
                                    $importantSymp = "false";
                                }
                            }
                        }
                        else{
                            $importantInfo="false";
                            $importantSymp="false";}
                        if($importantInfo==="true"||$importantSymp==="true"){
                            echo "<li><a href='patientInfo.php?id=+$id'>RECORDS <span class=\"glyphicon glyphicon-exclamation-sign\"></span></a></li>";}
                        else{
                            echo"<li><a href='patientInfo.php?id=+$id'>RECORDS</a></li>";}
                        ?>                        <li><a href="progress.php?id=<?php echo +$id ?>">STATUS CHARTS</a></li>
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


<div class="jumbotron text-center">
    <h1><?php echo $patientname ?>'s Weight Chart<img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>
<button class="openbtn" onclick="openNavWChart()">☰ View as a table</button>

<?php
$sql = "SELECT * FROM `weight` WHERE `id` = '$id'";
$result= $conn->query($sql);
if($result->num_rows<1) {
    echo"<div class='box'><p>No weight records yet</p></div>";
}
else{
    ?>
    <div id="chartContainer" style="height: 300px; width: 100%;"></div>
<?php }?>
<br>

<div class="weightNav" id="mySidebar">
    <br>
    <a class="closebtn" onclick="closeNavWChart()"  > <b>< CLOSE</b> </a>
    <br>
    <br>
    <br>
    <?php
    $sql = "SELECT * FROM `weight` WHERE `id` = '$id'";
    $result= $conn->query($sql);
    if($result->num_rows>0) {
        echo"<table id='table-weight'>
        <tr>
        <th>Date Entered</th>
        <th>Weight (lbs)</th>
        <th>Approximate Stones</th>

</tr>";
        while ($rowname = $result->fetch_assoc()) {
            $y = $rowname["lbs"];
            $timestamp = $rowname["timeStamp"];
            $date2 = (new DateTime($timestamp))->format('d m Y');
            $stones = round($y*0.071429,1,PHP_ROUND_HALF_UP);
            echo"<tr>
        <td>".$date2."</td>
        <td>".$y."</td>
        <td>".$stones."</td>";


        }
        echo"</table>";
    }

    ?>
    <br>
</div>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<script>
    function next(){
        window.location.href="proSupport.php?id=+<?php echo $id ?>";
    }
</script>
</body>
<div class="clear"> </div>

<footer>
    <div class="footer">
        <div class="footer">
            <button class="btn" onclick="goBack()" style="float:left"><b><</b> Back </button>
            <button class="btn" style="float:right" onclick="next()"> Next <b> > </b></button>
        </div>
    </div></footer>
</html>