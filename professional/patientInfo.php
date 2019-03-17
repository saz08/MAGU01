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
$action2 = safePOST($conn, "action2");


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
    <title>Records</title>
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

<?php
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


$id = $_GET['id'];

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
                            echo "<li><a href='patientInfo.php?id=+$id'>PROFILE <span class=\"glyphicon glyphicon-exclamation-sign\"></span></a></li>";}
                        else{
                            echo"<li><a href='patientInfo.php?id=+$id'>PROFILE</a></li>";}
                        ?>

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
                                        $resInfo = $rowname["resInfo"];
                                        $seenSymp = $rowname["seenSymp"];
                                        $resSymp = $rowname["resSymp"];
                                        $importantInfo="false";
                                        $importantSymp="false";
                                        if ($seenInfo === "false") {
                                            if ($additional != "") {
                                                $importantInfo="true";}}
                                        else{
                                            $importantInfo="false";
                                        }
                                        if ($seenSymp === "false") {
                                            if ($symptom != "") {
                                                $importantSymp="true";}}
                                        else{
                                            $importantSymp="false";}}}
                                else {
                                    $importantInfo="false";
                                    $importantSymp="false";}}}
                        else{
                            $importantInfo="false";
                            $importantSymp="false";}
                        if($importantInfo==="true"||$importantSymp==="true"){
                            echo "<li><a href='proSupport.php?id=+$id'>SUPPORT CIRCLE <span class=\"glyphicon glyphicon-exclamation-sign\"></span></a></li>";}
                        else{
                            echo"<li><a href='proSupport.php?id=+$id'>SUPPORT CIRCLE</a></li>";}
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
    <h1>Profile for Patient: <?php  echo $forename ." ". $surname ?><img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>
<div id="logOutCheck" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to log out?</p>
        <button id="spanSubmitCheck" class="btn" onclick="window.location.href='../patient/logout.php' ;document.getElementById('logOutCheck').style.display='none';">Yes</button>
        <button id="spanSubmitCheck" class="btn" onclick="document.getElementById('logOutCheck').style.display='none';">No</button>
    </div>
</div>
<br>

<?php

$sqlScale  = "SELECT * FROM `scale`WHERE id = '$id' ORDER BY `timeStamp` DESC LIMIT 1";

$resultScale = $conn->query($sqlScale);
if($resultScale->num_rows>0) {
    while ($rowname = $resultScale->fetch_assoc()) {
        echo"<div style=\"overflow-x: scroll\">";
        echo"<table class='table table-hover row-clickable' id='doctorTable' >";
        echo"<tr>";
        echo"<th>Date of Last Entry</th>";
        echo"<th>Most Recent Pain Rate</th>";
        echo"<th>Most Recent Breathlessness Rate</th>";
        echo"<th>Most Recent Performance Score</th>";
        echo"</tr>";
        echo "<tr>";
        $date = $rowname["timeStamp"];
        $date2 = (new DateTime($date))->format('d/m/Y');
        $pain = $rowname["pain"];
        $breath = $rowname["breathlessness"];
        $performance = $rowname["performance"];

        echo "<td style='background-color: white;color: black'>" . $date2 . "</a></td>";

        if($rowname["pain"]>=7){
            echo "<td style='background-color: #FF7070;color: black'>" . $pain . "/10</a></td>";
        }

        else if($rowname["pain"]>=4&&$rowname["pain"]<7){
            echo "<td style='background-color: orange;color: black'>" . $pain. "/10</a></td>";
        }
        else{
            echo "<td style='background-color: limegreen;color: black'>" . $pain . "/10</a></td>";
        }
        if($rowname["breathlessness"]>=4){
            echo "<td style='background-color: #FF7070;color: black'>" . $breath . "/5</a></td>";
        }

        else if($rowname["breathlessness"]>=2&&$rowname["breathlessness"]<4){
            echo "<td style='background-color: orange;color: black'>" .$breath . "/5</a></td>";
        }
        else{
            echo "<td style='background-color: limegreen;color: black'>" . $breath . "/5</a></td>";
        }
        if($rowname["performance"]>=3){
            echo "<td style='background-color: #FF7070;color: black'>" . $performance . "/4</a></td>";
        }

        else if($rowname["performance"]==2){
            echo "<td style='background-color: orange;color: black'>" .$performance . "/4</a></td>";
        }
        else{
            echo "<td style='background-color: limegreen;color: black'>" . $performance. "/4</a></td>";
        }

        echo "</tr>";
    }
}
else{
    echo"<h2>Patient has not recorded any pain, breathlessness or performance issues</h2>";
}
echo" </table>";
echo "</div>";
?>

<h2>Patients may send additional notes that they are concerned about. They will appear here if there are any.</h2>
<div class="box" style="height: inherit">
    <?php
    $sql  = "SELECT * FROM `scale` WHERE `id`= '$id'";
    $result=$conn->query($sql);
    $counter=0;
    if($result->num_rows>0) {
        while ($rowname = $result->fetch_assoc()) {
            $counter++;
            $info = $rowname["additionalInfo"];
            $symptom = $rowname["symptom"];
            $seenInfo = $rowname["seenInfo"];
            $seenSymp = $rowname["seenSymp"];
            $date = $rowname["timeStamp"];
            $date2 = (new DateTime($date))->format('d/m/Y');

            if ($info != "") {
                if ($seenInfo == "false") {
                    echo "<p><b>".$date2.": </b>" . $info . " <button class='btn' onclick='showCommentOption($counter)' value='hide/show'>Respond</button></p>
                       <div id='content_$counter' class='comments' style='display:none'>
                       <form method='post' name='commentsSection'>
                       <input type='text' name='comment' placeholder='Respond to patient...'><br>
                       <input type='hidden' name='action' value='filled'>
                       <input type='hidden' name='divID' value='$info'>
                       <input type='submit' value='Respond to Patient' class='btn'>
</form>
<br>
</div>";

                } else {
                    echo "<p><b>".$date2.": </b>" . $info . " <button class='btn' style='background-color: #644F62!important;color:white!important;'>Seen</button></p>";

                }

            }
            if ($symptom != "") {
                if ($seenSymp == "false") {
                    $counter++;
                    echo "<p><b>".$date2.": </b>" . $symptom . "<button class='btn' onclick='showCommentOption($counter)' value='hide/show'>Respond</button></p>
                       <div id='content_$counter' class='comments' style='display:none'>
                       <form method='post' name='commentsSymptom'>
                       <input type='text' name='comment' placeholder='Respond to patient...'><br>
                       <input type='hidden' name='action2' value='filled'>
                       <input type='hidden' name='divID2' value='$symptom'>
                       <input type='submit' value='Respond to Patient' class='btn'>
                    </form>
                    <br>
                    </div>";

                }
                else {
                    echo "<p><b>".$date2.": </b>" . $symptom . " <button class='btn' style='background-color: #644F62!important;color:white!important;'>Seen</button></p>";

                }

            }

        }
    }
    ?>
</div>


<?php
if($action==="filled") {
    $info = safePOST($conn, "divID");
    $comment = (safePost($conn, "comment"));
    $sqlPatient = "SELECT * FROM `account` WHERE id='$id'";
    $patient = $conn->query($sqlPatient);
    if ($patient->num_rows > 0) {
        while ($rowname = $patient->fetch_assoc()) {
            $usernamePatient = $rowname["username"];
        }
    }


    $getTime = "SELECT * FROM `scale` WHERE `id`='$id' AND `additionalInfo`='$info' ORDER BY `timeStamp` DESC LIMIT 1";
    $getTimeResult = $conn->query($getTime);
    if ($getTimeResult->num_rows > 0) {
        while ($rowname = $getTimeResult->fetch_assoc()) {
            $lastTime = $rowname["timeStamp"];
        }
    }

    if($comment != "") {
        $sql = "UPDATE `scale` SET `seenInfo`='true',`resInfo`='$comment',`timeStamp`='$lastTime' WHERE `additionalInfo`='$info' AND `username`='$usernamePatient'";
        if ($conn->query($sql) === TRUE) {
            echo "<p class='center'>Response has been sent!</p>";
            ?>
            <script>
                window.location.href = "patientInfo.php?id=+<?php echo $id ?>";
            </script>
            <?php
        }
    }
}
?>
<?php
if($action2==="filled") {
    $symptom = safePOST($conn, "divID2");
    $comment = (safePost($conn, "comment"));
    $sqlPatient = "SELECT * FROM `account` WHERE id='$id'";
    $patient = $conn->query($sqlPatient);
    if ($patient->num_rows > 0) {
        while ($rowname = $patient->fetch_assoc()) {
            $usernamePatient = $rowname["username"];
        }
    }
    $getTime = "SELECT * FROM `scale` WHERE `id`='$id' AND `symptom`='$symptom' ORDER BY `timeStamp` DESC LIMIT 1";
    $getTimeResult = $conn->query($getTime);
    if ($getTimeResult->num_rows > 0) {
        while ($rowname = $getTimeResult->fetch_assoc()) {
            $lastTime = $rowname["timeStamp"];
        }
    }

    if ($comment != "") {
        $sql = "UPDATE `scale` SET `seenSymp`='true',`resSymp`='$comment',`timeStamp`='$lastTime' WHERE `symptom`='$symptom' AND `username`='$usernamePatient'";
        if ($conn->query($sql) === TRUE) {
            echo "<p class='center'>Response has been sent!</p>";
            ?>
            <script>
                window.location.href = "patientInfo.php?id=+<?php echo $id ?>";
            </script>
            <?php
        }
    }
}
?>




<br>
<script>

    function markAsSeen(counter){
        jQuery.post("markAsSeen.php", {"Counter": counter}, function(data){
            alert("Marked as Seen");
        }).fail(function()
        {
            alert("something broke in submitting your records");
        });
    }

    function showCommentOption(counter) {
        var x = document.getElementById("content_"+counter);
        console.log("div id " + counter );
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function next(){
        window.location.href="progress.php?id=+<?php echo $id ?>";
    }
</script>

</body>
<div class="clear"></div>

<footer>
    <div class="footer">
        <div class="footer">
            <button class="btn" onclick="goBack()" style="float:left"><b><</b> Back </button>
            <button class="btn" style="float:right" onclick="next()"> Next <b> > </b></button>
        </div>
    </div></footer>
</html>