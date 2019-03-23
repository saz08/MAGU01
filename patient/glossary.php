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

    <meta charset="UTF-8">
    <title>Glossary</title>
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

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
    <h1 style="left:10%;width:80%;text-align: center" >Lung Cancer Alliance Glossary <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
    </div>

    <!--Modal: Logout Check-->
    <div id="logOutCheck" class="modal">
        <div class="modal-content">
            <p>Are you sure you want to log out?</p>
            <button id="spanSubmitCheck" class="btn" onclick="window.location.href='logout.php' ;document.getElementById('logOutCheck').style.display='none';">Yes</button>
            <button id="spanSubmitCheck" class="btn" onclick="document.getElementById('logOutCheck').style.display='none';">No</button>
        </div>
    </div>

<br>
<!--    Search bar for keywords, searches on keyup-->
<input type="text" style="left:20%;width:80%" id="myInput" onkeyup="searchGlossary()" placeholder="Search a keyword.." title="Start typing">

<!--    Button for A-Z sidebar-->
    <button class="openbtn" onclick="openGlossaryNav()">☰ A-Z</button>

    <div class="sidenav" id="mySidebar">
    <br>
    <a class="closebtn" onclick="closeGlossaryNav()" > <</a>
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

<!--    Div for glossary to be held-->
<div id="x" class="box"></div>

<script>
    //Request to get glossary terms from html file
    var xhr= new XMLHttpRequest();
    xhr.open('GET', '../html/glossary.html', true);
    xhr.onreadystatechange= function() {
        if (this.readyState!==4) return;
        if (this.status!==200) return; // or whatever error handling you want
        document.getElementById('x').innerHTML= this.responseText;
    };
    xhr.send();


    //Search glossary for keyword
        function searchGlossary() {
        var input, filter, ul, li, a, i, txtValue,p;
        //the keyword that the user enters
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        ul=document.getElementById("myUL");
        li = ul.getElementsByTagName("li");
        p = document.getElementById("noResults");
        p.style.display="none";
        for (i = 0; i < li.length; i++) {
            a = li[i];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
        li[i].style.display = "";
        p.style.display="none";
    }
        else {
        li[i].style.display = "none";
            p.style.display="block";
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