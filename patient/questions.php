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
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">

    <script src="../js/script.js"></script>
    <script src="../js/forAll.js"></script>

    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/radio.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/alerts.css">

    <meta charset="UTF-8">
    <title>Questions</title>

</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">



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
    <h1>Questions <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>

<!--Modal: Logout Check-->
<div id="logOutCheck" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to log out?</p>
        <button id="spanSubmitCheck" class="btn" onclick="window.location.href='logout.php' ;document.getElementById('logOutCheck').style.display='none';">Yes</button>
        <button id="spanSubmitCheck" class="btn" onclick="document.getElementById('logOutCheck').style.display='none';">No</button>
    </div>
</div>

<div class="box">
    <p>This page can be used to store questions for any upcoming appointments or as a diary. Anything entered will NOT be sent to your doctor so you will not recieve a response for anything entered here.</p>
    <p>If you want a response, please use the additional info page when recording your weekly scales</p>
</div>

<br>
<!--Input box for questions to be entered-->
    <div class="box-transparent">
        <p>Note down any questions you have</p>
        <form method="post" name="questions">
            <input type="text" name="question" placeholder="Type a question here..."><br>
            <input type="hidden" name="action" value="filled">
            <br>
            <input type="submit" value="Save Question" class="btn" id="button"><br>
        </form>
    </div>
<br>
<?php

$question= (safePost($conn,"question"));

if($action==="filled"){
    $sql  = "INSERT INTO `questions` (`question`, `username`) VALUES ('$question', '$username')";
    $conn->query($sql);?>
    <script>window.location.href="questions.php";</script>
    <?php
}
?>
<?php
//Take questions from database and show them in a table
$sqlJournal = "SELECT * FROM `questions` WHERE `username` = '$username'";
$resultJournal = $conn->query($sqlJournal);
if($resultJournal->num_rows>0) {


?>
    <div class="box-transparent">
        <table class="table table-striped" id="questionTable">
            <tr>
                <th>Questions</th>
                <th>Delete</th>
            </tr>
            <?php

            //Each row has the option to delete a question
            $sqlJournal = "SELECT * FROM `questions` WHERE `username` = '$username'";
            $resultJournal = $conn->query($sqlJournal);
            if ($resultJournal->num_rows > 0) {
                $questionNo = 1;
                while ($rowname = $resultJournal->fetch_assoc()) {
                    $pos = $rowname["pos"];
                    $question = $rowname["question"];
                    echo "<tr>";
                    echo "<td style='float:left'>" . $question . "</td>";
                    echo "<td><form><input type='button' value='Delete' onclick='deleteQ($pos)' class='btn' id='button'/></form></td>";
                    echo "</tr>";
                    $questionNo++;
                }
            }
            }

            ?>
        </table>
    </div>

<!--Modal: Question deleted-->
<div id="deleteQ" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanDelete" onclick="document.getElementById('deleteQ').style.display='none';window.location.href='questions.php'" style="float:right">&times;</button>
        <p>Question was deleted successfully!</p>
    </div>
</div>

<!--Modal: Question not deleted-->
<div id="nodeleteQ" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanDelete" onclick="document.getElementById('nodeleteQ').style.display='none';window.location.href='questions.php'" style="float:right">&times;</button>
        <p>Sorry, Survivors was unable to delete your question. Please check your internet connection then try again</p>
    </div>
</div>

<script>
    function next(){
        window.location.href="supportCircle.php";
    }
</script>

<div class="clear"></div>

<div class="footer">
    <button class="btn" onclick="goBack()" style="float:left"><b><</b> Back </button>
    <button class="btn" style="float:right" onclick="next()"> Next <b> > </b></button>
</div>
</body>
</html>