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

if(isset($_SESSION["sessionuser"])){
    $user = $_SESSION["sessionuser"];
    $sessionuser = $_SESSION["sessionuser"];
}

else{
    $sessionuser ="";
    $user = safePOSTNonMySQL("username");
    $pass = safePOSTNonMySQL("password");
}



//$username= "<script>localStorage.getItem('username')</script>";




$loginOK = false; //TODO make this work with database values

if($loginOK) {
    if (!isset($_SESSION["sessionuser"])) {
        session_regenerate_id();
        $_SESSION["sessionuser"] = $user;
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">
    <script src="../js/script.js"></script>
    <script src="../js/forAll.js"></script>

    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/collapsible.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/navigation.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/alerts.css">

    <script>
        function openNav() {
            if(screen.width<500){
                document.getElementById("x").style.width = "80%";
                document.getElementById("x").style.left = "20%";
                document.getElementById("mySidebar").style.width = "5.5rem";

            }
            if(screen.width>500){
                document.getElementById("mySidebar").style.width = "7rem";

            }
        }

        function closeNav() {
            if(screen.width<500){
                document.getElementById("x").style.left = "0";
                document.getElementById("x").style.width = "100%";
            }
            if(screen.width>500) {
                document.getElementById("x").style.left = "20%";
                document.getElementById("x").style.width = "50%";
            }
            document.getElementById("mySidebar").style.width = "0";
        }
    </script>


    <meta charset="UTF-8">
    <title>Glossary</title>
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
<div id="session" class="modal">
    <div class="modal-content">
        <span class="close" id="spanSave" onclick="document.getElementById('session').style.display='none'; window.location.href='signUp.php';">&times;</span>
        <p>Session has expired, please log in again!</p>
    </div>
</div>
<div id="page-wrap">

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
                <ul class = "nav navbar-nav navbar-left">
                    <?php
                    if($_SESSION["userName"]!=null) {
                        $username = $_SESSION["userName"];
                    }
                    else{
                        ?><script>
                            localStorage.setItem("username","unknownUser");
                            localStorage.setItem("loginOK","no");
                            document.getElementById("session").style.display="block";
                        </script><?php
                    }

                    $sqlInfo = "SELECT * FROM `scale` WHERE `username` = '$username'";
                    $supportInfo = $conn->query($sqlInfo);
                    if ($supportInfo->num_rows > 0) {
                        while ($rowname = $supportInfo->fetch_assoc()) {
                            $seenInfo = $rowname["seenInfo"];
                            $resInfo = $rowname["resInfo"];
                            $seenSymp = $rowname["seenSymp"];
                            $resSymp = $rowname["resSymp"];
                            $importantInfo="false";
                            $importantSymp="false";

                            if ($seenInfo === "true" && $resInfo != "") {
                                $importantInfo = "true";
                            }
                            else {
                                $importantInfo = "false";
                            }
                            if ($seenSymp === "true" && $resSymp != "") {
                                $importantSymp = "true";
                            }
                            else {
                                $importantSymp = "false";
                            }

                        }
                    }
                    else{
                        $importantInfo="false";
                        $importantSymp = "false";

                    }

                    if($importantInfo==="true"||$importantSymp==="true"){
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
                <li><a href="logout.php">LOGOUT</a></li>
            </ul>
        </div>
    </div>
</nav>


    <div class="jumbotron text-center">
    <h1 style="left:10%;width:80%;text-align: center" >Lung Cancer Alliance Glossary <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>
<br>
<input type="text" style="left:20%;width:80%" id="myInput" onkeyup="searchGlossary()" placeholder="Search a keyword.." title="Start typing">
    <button class="openbtn" onclick="openNav()">☰ A-Z</button>

    <div class="sidenav" id="mySidebar">
    <br>
    <a class="closebtn" onclick="closeNav()" >  <</a>
<br>
    <a href="#a">A</a>
    <a href="#b">B</a>
    <a href="#c">C</a>
    <a href="#d">D</a>
    <a href="#e">E</a>
    <a href="#f">F</a>
    <a href="#g">G</a>
    <a href="#h">H</a>
    <a href="#i">I</a>
     <a href="#j">J</a>
     <a href="#k">K</a>
     <a href="#l">L</a>
     <a href="#m">M</a>
     <a href="#n">N</a>
     <a href="#o">O</a>
     <a href="#p">P</a>
     <a href="#q">Q</a>
     <a href="#r">R</a>
     <a href="#s">S</a>
     <a href="#t">T</a>
     <a href="#u">U</a>
     <a href="#v">V</a>
     <a href="#w">W</a>
     <a href="#x">X</a>
     <a href="#y">Y</a>
     <a href="#z">Z</a>
    <br>
</div>
    <br>

<div id="x" class="box">
</div>
<script>
    var xhr= new XMLHttpRequest();
    xhr.open('GET', '../html/glossary.html', true);
    xhr.onreadystatechange= function() {
        if (this.readyState!==4) return;
        if (this.status!==200) return; // or whatever error handling you want
        document.getElementById('x').innerHTML= this.responseText;
    };
    xhr.send();


        function searchGlossary() {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        console.log("input si + "+ filter);
        ul=document.getElementById("myUL");
        li = ul.getElementsByTagName("li");
        for (i = 0; i < li.length; i++) {
            a = li[i];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
        li[i].style.display = "";
    }
        else {
        li[i].style.display = "none";
    }
    }
    }

</script>





<div class="footer">
    <button class="btn" onclick="goBack()" style="left:10%"><b><</b> Back </button>
</div>
</div>
</body>
<div class="clear"></div>


</html>