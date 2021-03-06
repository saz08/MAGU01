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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">

    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/alerts.css">
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>

    <script src="../js/script.js"></script>
    <script src="../js/forAll.js"></script>

    <meta charset="UTF-8">
    <title>Survivors</title>
<script>
    localStorage.setItem("Breathlessness","");
    localStorage.setItem("Pain","");
    localStorage.setItem("Performance","");
</script>
</head>

<body>



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
                    $importantInfo = 0;
                    $importantSymp = 0;
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
    <h1>Homepage <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>

<!--Modal: Logout Check-->
<div id="logOutCheck" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to log out?</p>
        <button id="spanSubmitCheck" class="btn" onclick="window.location.href='logout.php' ;document.getElementById('logOutCheck').style.display='none';">Yes</button>
        <button id="spanSubmitCheck" class="btn" onclick="document.getElementById('logOutCheck').style.display='none';">No</button>
    </div>
</div>

<!--Display today's date-->
<h2 style="float:right">Today is <?php echo date('jS F Y')?></h2>

<br>
<br>

<?php
//Only display this information when the user has not submitted any pain, breathlessness or performance values (a new user)
$sqlNew  = "SELECT * FROM `scale` WHERE `username` = '$username'";
$resultNew = $conn->query($sqlNew);
if($resultNew->num_rows<1) {
  echo"<div class='box'>
<h2>Welcome to Survivors!</h2>
<p>This is where you can 
<ul>
  <li>Record your pain, breathlessness, performance and any other queries you're unsure of! <button class='btn' onclick='goToScale()' style='font-size: 1.5rem'>Start now!</button></li>
 <br>
  <li>Monitor your weight, it is important that we don't see a sudden increase or decrease in your weight <button class='btn' onclick='goToWeight()' style='font-size: 1.5rem'>Enter Weight!</button></li>
 <br> 
  <li>Monitor how much physical activity you do, we want you to improve! <button class='btn' onclick='goToPhysical()' style='font-size: 1.5rem'>Record your activity!</button></li>
  <br>
  <li>Get involved in our patient forum room<button class='btn' onclick='goToForum()' style='font-size: 1.5rem'>Talk!</button></li>
  <br>
  <li>Find helpful links regarding general info, financial, emotional and physical help in <b>HELP</b></li>
  <br>
  <li>View helpful charts showing your status in <b>PROFILE</b></li>
  <br>
  <li>Log questions you'd like to remember for your next appointment<button class='btn' onclick='goToQuestion()' style='font-size: 1.5rem'>Add a question!</button></li>
  <br>
  <li>Add friends or family members to a support circle, where they can view your progress and enter symptoms on your behalf<button class='btn' onclick='goToSupport()' style='font-size: 1.5rem'>Support Circle</button></li>
<br>
</ul> </p>
</div>";
}
?>

<!--Modal: Response deleted-->
<div id="deleted" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanNotify" onclick="document.getElementById('deleted').style.display='none';window.location.href='index.php'" style="float:right">&times;</button>
        <p>Response successfully deleted</p>
    </div>
</div>

<!--Modal: Response not deleted-->
<div id="notDelete" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanNotify" onclick="document.getElementById('notDelete').style.display='none';window.location.href='index.php'" style="float: right;">&times;</button>
        <p>Survivors was unable to delete the response successfully. Please check your internet connection and try again</p>
    </div>
</div>

<?php
//Show the user a response from their doctor
$sqlInfo  = "SELECT * FROM `scale` WHERE `username` = '$username' AND `seenInfo` = 'true' OR `seenSymp` = 'true'";
$resultInfo = $conn->query($sqlInfo);
if($resultInfo->num_rows>0) {
    while ($rowname = $resultInfo->fetch_assoc()) {
        $info = $rowname["additionalInfo"];
        $symptom = $rowname["symptom"];
        $seenInfo = $rowname["seenInfo"];
        $seenSymp = $rowname["seenSymp"];
        $resInfo = $rowname["resInfo"];
        $resSymp = $rowname["resSymp"];

        //If the information was filled, and the doctor has seen and responded: show button with information response
        if($info!="") {
            if ($seenInfo != "false") {
                if($seenInfo!="") {
                    ?>
                    <br>
                    <div class="box">
                        <p>
                            <b>The doctor has responded to your additional info:</b> <?php echo $info; ?> <br>
                            <b>Response:</b> <?php
                            echo $resInfo; ?>
                            <br>
                            <button class="btn" id="button" onclick="markAndDelete('<?php echo $resInfo ?>')">Delete <i class='far fa-trash-alt'></i>
                            </button>
                        </p>
                    </div>
                    <?php
                }
            }
        }

        //If the symptom was filled, and the doctor has seen and responded: show button with symptom response
        if($symptom!="") {
            if($seenSymp!="false") {
                if($seenSymp!="") {
                    ?>
                    <br>
                    <div class="box">
                        <p>
                            <b>The doctor has responded to your symptom:</b> <?php echo $symptom; ?> <br>
                            <b>Response:</b> <?php
                            echo $resSymp; ?>
                            <br>
                            <button class="btn" id="button" onclick="markAndDelete('<?php echo $resSymp ?>')">Delete <i class='far fa-trash-alt'></i>
                            </button>
                        </p>
                    </div>
                    <?php
                }
            }
        }
    }
}
//Reminder to user of when to submit scales
$sqlScale  = "SELECT * FROM `scale` WHERE `username` = '$username' ORDER BY `timeStamp` DESC LIMIT 1";
$resultScale = $conn->query($sqlScale);
if($resultScale->num_rows>0) {
while ($rowname = $resultScale->fetch_assoc()) {
    $date = $rowname["timeStamp"];
    $date2 = (new DateTime($date))->format('jS F Y');

    echo "<br><div class='box'><p><b>Welcome Back ". $username ."!</b><br> Keeping a log of how you feel is very helpful to you and your health professional. Do not be scared to get in touch with your doctor if you feel it is serious!</p>
<p>The last time you recorded your pain, breathlessness and performance was " .$date2."</p>
<p>Try and make an entry once a week,so your next logging date should be: ".date('jS F Y', strtotime($date2. '+ 7 days'));
       if(date('jS F Y', strtotime($date2. '+ 7 days'))==date('jS F Y')){
           echo "     <button class='btn' onclick='goRecord()'>Record Now!</button>";
       }
       echo"</p></div>";
        }
    }

//Show the user their most recent pain, breathlessness and performance score if it was a "red" flag
    $sqlScale  = "SELECT * FROM `scale`WHERE `username` = '$username' ORDER BY `timeStamp` DESC LIMIT 1";
    $resultScale = $conn->query($sqlScale);
    if($resultScale->num_rows>0) {
        while ($rowname = $resultScale->fetch_assoc()) {
            $pain = $rowname["pain"];
            $breath = $rowname["breathlessness"];
            $performance=$rowname["performance"];

            if($pain>=7){
                echo"<div class='box'>";
                echo"<p>Your most recent pain score was $pain. <br> Your doctor has been notified and will contact you within 2 hours.<br> You can find suggestions on how to cope with your pain <b><a href='https://devweb2018.cis.strath.ac.uk/~szb15123/Survivors/patient/helpInfo.php' style='color: #3F1452'>HERE!</a></b> </p>";
                echo"</div>";

            }
            if($breath>=4){
                echo"<div class='box'>";
                echo"<p>Your most recent breathlessness score was $breath. <br> Your doctor has been notified and will contact you within 2 hours.<br> You can find suggestions on how to cope with breathlessness <b><a href='https://devweb2018.cis.strath.ac.uk/~szb15123/Survivors/patient/helpInfo.php' style='color: #3F1452'>HERE!</a></b></p>";
                echo"</div>";

            }
            if($performance>=3){
                echo"<div class='box'>";
                echo"<p>Your most recent performance score was $performance. <br> Your doctor has been notified and will contact you within 2 hours.<br>  </p>";
                echo"</div>";

            }
        }
    }
?>

</body>
<div class="clear"></div>
<footer>
    <div class="footer">
    </div></footer>
</html>