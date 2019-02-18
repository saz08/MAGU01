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
    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">
    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <script src="../js/forAll.js"></script>

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
                                $y = $rowname["kg"];
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


            </ul>
        </div>
    </div>
</nav>


<div class="jumbotron text-center">
    <h1><?php echo $patientname ?>'s Weight Chart</h1>
</div>

<div id="chartContainer" style="height: 300px; width: 100%;"></div>
<br>

<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

</body>


<footer>
    <div class="footer">
        <div class="glyphicon glyphicon-arrow-left" style="float:left" id="arrows" onclick="goBack()"></div>

        <p style="text-align: center;">&copy; Sara Reid Final Year Project 2019</p>
    </div></footer>
</html>