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
    <link rel="stylesheet" type="text/css" href="../stylesheets/alerts.css">

    <meta charset="UTF-8">
    <title>Contact</title>
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
        localStorage.setItem("loginOKDoc","no");
        alert("Session has expired, please log in again");

        window.location.href="docSignUp.php";
    </script><?php
}

//Get the ID of the patient chosen from the URL
$id = $_GET['id'];

//Get all patient details
$sqlD="SELECT * FROM `chi` WHERE id='$id'";
$details=$conn->query($sqlD);
if($details->num_rows>0){
    while($rowname=$details->fetch_assoc()){
        $forename= $rowname["forename"];
        $surname = $rowname["surname"];
        $birthday = $rowname["birthday"];
        $gender = $rowname["gender"];
        $address = $rowname["address"];
        $contact = $rowname["contactNo"];
    }
}
else{
    $forename= "";
    $surname = "";
    $birthday = "";
    $gender = "";
    $address = "";
    $contact ="";
    $usernamePatient="";
}

$sqlPatient="SELECT * FROM `account` WHERE id='$id'";
$patient=$conn->query($sqlPatient);
if($patient->num_rows>0){
    while($rowname=$patient->fetch_assoc()){
        $usernamePatient= $rowname["username"];
    }
}
?>
<script>
    localStorage.setItem("id", <?php echo $id?>);
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
                <li><a href="dashboard.php">DASHBOARD</a></li>
                <li><a href="createID.php">ADD PATIENT</a></li>
                <li><a href="../patient/talk.php">FORUM</a></li>

                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" onclick="openInfo()">PATIENT INFORMATION <span class="caret"></span></a>
                    <ul class="dropdown-menu" id="info">
                        <li><a href="patient.php?id=<?php echo +$id ?>">CONTACT</a></li>
                        <?php
                        //Show an information notification if a user has sent additional information
                        $sqlRecords = "SELECT * FROM `scale` WHERE `id` = '$id'";
                        $resultRecords = $conn->query($sqlRecords);
                        if ($resultRecords->num_rows > 0) {
                            $counterInfo1=0;
                            $counterSymp1=0;
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
                        }
                        else{
                            $counterInfo1=0;
                            $counterSymp1=0;}
                        if($counterInfo1>0||$counterSymp1>0){
                            echo "<li><a href='patientInfo.php?id=+$id'>PROFILE <span class=\"glyphicon glyphicon-exclamation-sign\"></span></a></li>";}
                        else{
                            echo"<li><a href='patientInfo.php?id=+$id'>PROFILE</a></li>";}
                        ?>                        <li><a href="progress.php?id=<?php echo +$id ?>">STATUS CHARTS</a></li>
                        <li><a href="weightChartDoc.php?id=<?php echo +$id ?>">WEIGHT CHART</a></li>
                        <?php
                        //Show an information notification if a supporter has sent additional information

                        $sqlUser = "SELECT * FROM `account` WHERE `id` = '$id'";
                        $userResult = $conn->query($sqlUser);
                        if($userResult->num_rows>0) {
                            while ($rowname = $userResult->fetch_assoc()) {
                                $usernameSurvivor = $rowname["username"];
                                $sqlInfo = "SELECT * FROM `supportSubmit` WHERE `survivor` = '$usernameSurvivor'";
                                $supportInfo = $conn->query($sqlInfo);
                                if ($supportInfo->num_rows > 0) {
                                    $counterInfo=0;
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
                                }
                                else {
                                    $counterInfo=0;
                                    $counterSymp = 0;
                                }
                            }
                        }
                        else{
                            $counterInfo=0;
                            $counterSymp = 0;
                        }
                        if($counterInfo>0||$counterSymp>0){
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
                <li><a> <button class="btn" id="checkLogOut" onclick="logOutCheck()"  style="background-color: #E9969F;color:black;top:0 " >LOGOUT</button></a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="jumbotron text-center">
    <h1>Contact Details for: <?php  echo $forename ." ". $surname ?><img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
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
        <?php
//Create table with patient contact details
        $sql  = "SELECT * FROM `account` WHERE `id` = '$id'";
        $result = $conn->query($sql);
        if($result->num_rows>0) {
            while ($rowname = $result->fetch_assoc()) {
                echo"<div style='overflow-x: scroll'>";
    echo"<table class='table table-hover row-clickable' id='doctorTable' >";
                echo"<tr>";
                echo "<th>Forename</th>";
                echo "<th>Surname</th>";
                echo "<th>Date of Birth</th>";
                echo "<th>Gender</th>";
                echo "<th>Smoking Status</th>";
                echo "<th>Address</th>";
                echo "<th>Contact No.</th>";
                echo"</tr>";

                echo "<tr>";
                echo "<td>" . $forename. "</a></td>";
                echo "<td>" . $surname . "</td>";
                echo "<td>" . $birthday . "</td>";
                echo "<td>" . $gender . "</td>";
                echo "<td>" . $rowname["smokingStatus"] . "</td>";
                echo "<td>" . $address . "</td>";
                echo "<td>" . $contact . "</td>";
                echo "</tr>";
            }
        }
        else{
            echo"<h2>Patient has not registered yet.</h2>";
        }
        ?>
    </table>
</div>
<br>

<script>
    function next(){
        window.location.href="patientInfo.php?id=+<?php echo $id?>";
    }
</script>
</body>
<div class="clear"></div>

<footer>
    <div class="footer">
            <button class="btn" onclick="goBack()" style="float:left"><b><</b> Back </button>
            <button class="btn" style="float:right" onclick="next()"> Next <b> > </b></button>
    </div>
</footer>
</html>