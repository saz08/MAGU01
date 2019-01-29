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
//$username= "<script>localStorage.getItem('username')</script>";






?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content ="width=device-width, initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta name="mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <link rel="stylesheet" type="text/css" href="donut.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="stylesheet.css">

    <meta charset="UTF-8">
    <title>Adapt To You</title>
    <script>

        if(localStorage.getItem("loginOK")===null){
            localStorage.setItem("loginOK", "no");
        }
        function checkLogIn(){
            return localStorage.getItem("loginOK")==="yes" && localStorage.getItem('username')!=='unknownUser';

        }

    </script>
    <script>
        var localUser = localStorage.getItem("username");
        // window.location.href = window.location.href+'?localUser='+localUser;

        if(localStorage.getItem("loginOK")===null){
            localStorage.setItem("loginOK", "no");
        }

        if(localStorage.getItem("loginOK")==="no"){
            window.location.href="signUp.php";
        }


        function checkLogIn(){
            return localStorage.getItem("loginOK")==="yes";
        }

        function checkUser(){
            localUser = localStorage.getItem("username");
            console.log("username in local storage" + localStorage.getItem("username"));
            return localStorage.getItem("username");
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
                <li><a href="scale.php">RECORD</a></li>
                <li><a href="talk.php">TALK</a></li>
                <li><a href="links.html">HELP</a></li>
                <li><a href="profile.php">PROFILE</a></li>

            </ul>
        </div>
    </div>
</nav>
<div class="jumbotron text-center">
    <h1>My Progress</h1>
</div>

<div id="body">
    <?php
    $sql2 = "SELECT * FROM `account` WHERE `username`= '$username'";
    $result= $conn->query($sql2);
    if($result->num_rows>0){
        while ($row = $result->fetch_assoc()) {
            echo "<option value = 'username'>Username: ".$row["username"]."</option>";
            echo "<option value = 'gender'>Gender: ".$row["gender"]."</option>";
            echo "<option value = 'age'>Age: ".$row["age"]."</option>";
            if($row["smoker"]=="smoker"){
                echo "<option value = 'smoker?'>Smoker Status: Never</option>";
            }
            else {
                echo "<option value = 'smoker?'>Smoker Status: Current</option>";
            }


        }
    }
    ?>
    <button onclick="logoutFunction()">
        Logout
    </button>



<?php


$sql  = "SELECT * FROM `scale` WHERE `pain`<=3 AND `username` = '$username'";
$result= $conn->query($sql);
if($result->num_rows>0){
    $greenPain = $result->num_rows;
    echo "<option value = 'pain'>GREEN PAIN: ".$greenPain."</option>";
}
else{
    $greenPain=0;
}

$sqlAMBER  = "SELECT * FROM `scale` WHERE `pain`>=4 AND `pain`<=7 AND `username` = '$username'";
$resultAMBER= $conn->query($sqlAMBER);
if($resultAMBER->num_rows>0){
    $amberPAIN = $resultAMBER->num_rows;
    echo "<option value = 'pain'>AMBER PAIN: ".$amberPAIN."</option>";
}
else{
    $amberPAIN=0;
}

$sqlRED  = "SELECT * FROM `scale` WHERE `pain`>=8  AND `username` = '$username'";
$resultRED= $conn->query($sqlRED);
if($resultRED->num_rows>0){
    $redPAIN = $resultRED->num_rows;
    echo "<option value = 'pain'>RED PAIN: ".$redPAIN."</option>";
}
else{
    $redPAIN=0;
}

$painTotal = $greenPain+$amberPAIN+$redPAIN;

$sqlBG  = "SELECT * FROM `scale` WHERE `breathlessness`<=1  AND `username` = '$username'";
$resultBG= $conn->query($sqlBG);
if($resultBG->num_rows>0){
    $greenBreath = $resultBG->num_rows;
    echo "<option value = 'pain'>GREEN BREATHLESSNESS: ".$greenBreath."</option>";
}
else{
    $greenBreath=0;
}

$sqlBA  = "SELECT * FROM `scale` WHERE `breathlessness`>=2 AND `breathlessness` <=4  AND `username` = '$username'";
$resultBA= $conn->query($sqlBA);
if($resultBA->num_rows>0){
    $amberBreath = $resultBA->num_rows;
    echo "<option value = 'pain'>AMBER BREATHLESSNESS: ".$amberBreath."</option>";
}
else{
    $amberBreath=0;
}

$sqlBR  = "SELECT * FROM `scale` WHERE `breathlessness`>=5  AND `username` = '$username'";
$resultBR= $conn->query($sqlBR);
if($resultBR->num_rows>0){
    $redBreath = $resultBR->num_rows;
    echo "<option value = 'pain'>RED BREATHLESSNESS: ".$redBreath."</option>";
}
else{
    $redBreath=0;
}

$breathlessnessTotal = $greenBreath+$amberBreath+$redBreath;

$sqlPG  = "SELECT * FROM `scale` WHERE `performance`<=1  AND `username` = '$username'";
$resultPG= $conn->query($sqlPG);
if($resultPG->num_rows>0){
    $greenPerformance = $resultPG->num_rows;
    echo "<option value = 'pain'>GREEN PERFORMANCE: ".$greenPerformance."</option>";
}
else{
    $greenPerformance=0;
}

$sqlPA  = "SELECT * FROM `scale` WHERE `performance`=2 AND `breathlessness` <=4  AND `username` = '$username'";
$resultPA= $conn->query($sqlPA);
if($resultPA->num_rows>0){
    $amberPerformance = $resultPA->num_rows;
    echo "<option value = 'pain'>AMBER PERFORMANCE: ".$amberPerformance."</option>";
}
else{
    $amberPerformance=0;
}

$sqlBP  = "SELECT * FROM `scale` WHERE `performance`>=3  AND `username` = '$username'";
$resultBP= $conn->query($sqlBP);
if($resultBP->num_rows>0){
    $redPerformance = $resultBP->num_rows;
    echo "<option value = 'pain'>RED PERFORMANCE: ".$redPerformance."</option>";
}
else{
    $redPerformance=0;
}

$sqlEntries  = "SELECT * FROM `scale` WHERE `username` = '$username'";
$resultEntries= $conn->query($sqlEntries);
if($resultEntries->num_rows>0){
    $entries = $resultEntries->num_rows;
    echo "<option value = 'pain'>ENTRIES TOTAL: ".$entries."</option>";
}



$performanceTotal = $greenPerformance+$amberPerformance+$redPerformance;

$overallPain = 10;
$overallBreath = 5;
$overallPerformance = 5;


//PAIN DONUT BARS
$greenPainBar = $greenPain/($entries)*210;
$amberPainBar = $amberPAIN/($entries)*210;
$redPainBar = $redPAIN/($entries)*210;

//BREATHING DONUT BARS
$greenBBar = $greenBreath/($entries)*360;
$amberBBar = $amberBreath/($entries)*360;
$redBBar = $redBreath/($entries)*360;

//PERFORMANCE DONUT BARS
$greenPBar = $greenPerformance/($entries)*360;
$amberPBar = $amberPerformance/($entries)*360;
$amberPBar = $redPerformance/($entries)*360;




?>


    <?php echo date("j m Y") . "<br>";
    $month = date("m");
    $year = date("Y");
    echo $month;
    echo $year;
 ?>







    <p>Green Pain Average = <?php echo $greenPainBar ?> </p>
    <p>Breathlessness Average = <?php echo $greenBBar?></p>
    <p>Performance Average = <?php echo $greenPBar?></p>
    <p>total entries = <?php echo $entries?></p>




    <div class="container">
        <div class="donut-chart-block block">
            <div class="donut-chart">
                <div id="part1" class="portion-block"><div class="circle" id="c1"></div></div>
                <div id="part2" class="portion-block"><div class="circle" id="c2"></div></div>
                <div id="part3" class="portion-block"><div class="circle" id="c3"></div></div>
                <p class="center" style="color:black">Pain</p>
            </div>
        </div>
    </div>


<script>
//    let val1=90;
//    let val2=180;
//    let val3 = 90;
var greenPain =<?php echo $greenPainBar?>;
var amberPain =<?php echo $amberPainBar?>;
var redPain = <?php echo $redPainBar ?>;
console.log("Green bar size" + greenPain);
console.log("Amber bar size" + amberPain);
console.log("Red bar size" + redPain);

    document.getElementById("part1").style.transform = "rotate(0deg)";
    document.getElementById("c1").style.transform =  "rotate("+greenPain+"deg)";

    document.getElementById("part2").style.transform = "rotate("+greenPain+"deg)";
    document.getElementById("c2").style.transform = "rotate("+amberPain+"deg)";


    document.getElementById("part3").style.transform = "rotate("+greenPain+amberPain+"deg)";
    document.getElementById("c3").style.transform = "rotate("+redPain+"deg)";



</script>




    <script>
    function logoutFunction(){
        window.location.href="logout.php";

    }

    //    function deleteEntry(){
    //            document.getElementById("questionTable").deleteRow(1);
    //    }
</script>





<div class="clear"></div>
</body>
<footer>
    <div class="footer">
        <p style="text-align: center;">&copy; Sara Reid Final Year Project 2019</p>
    </div>
</footer>
</html>