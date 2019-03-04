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

if($_SESSION['userName']==null){
    $_SESSION['userName'] = "unknownUser";
    ?> <script>
        localStorage.setItem('username', "unknownUser");
        localStorage.setItem('loginOK', "no");
    </script><?php
}

$username = $_SESSION["userName"];
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
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">
    <script src="../js/script.js"></script>
    <script src="../js/forAll.js"></script>

    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/collapsible.css">
    <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js?ver=1.3.2'></script>
    <script type="text/javascript">
        if($(window).width>=500) {
            $(function () {
                var offset = $("#sidebar").offset();
                var topPadding = 15;
                $(window).scroll(function () {
                    if ($(window).scrollTop() > offset.top) {
                        $("#sidebar").stop().animate({
                            marginTop: $(window).scrollTop() - offset.top + topPadding
                        });
                    } else {
                        $("#sidebar").stop().animate({
                            marginTop: 0
                        });
                    }
                    ;
                });
            });
        }
    </script>
<style>
    @media screen and (max-width: 480px) {
        #sidebar {
            visibility: hidden;
            height:0;
            width:0;
        }
        #sidebar ul{
            visibility: hidden;
        }
        #sidebar li a{
            visibility: hidden;
            width:0;
            height:0;
        }
    }
    #sidebar ul {
        background: purple;
    }
    #sidebar li a{
        color:white;
        height:2rem;
    }
    li { margin: 0 0 0 20px; }
    #main { width: 390px; float: left; }
    #sidebar { width: 190px; float: right; }

</style>
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
            <a class="navbar-brand" href="#myPage">    </a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class = "nav navbar-nav navbar-left">
                <ul class = "nav navbar-nav navbar-left">
                    <?php
                    $sqlInfo = "SELECT * FROM `scale` WHERE `username` = '$username'";
                    $supportInfo = $conn->query($sqlInfo);
                    if ($supportInfo->num_rows > 0) {
                        while ($rowname = $supportInfo->fetch_assoc()) {
                            $seen = $rowname["seen"];
                            $responseDoc = $rowname["response"];
                            $important="false";
                            if ($seen === "true" && $responseDoc != "") {
                                $important = "true";
                            }
                            else {
                                $important = "false";
                            }
                        }
                    }
                    else{
                        $important="false";
                    }

                    if($important==="true"){
                        echo "<li><a href='index.php'>HOME <span class=\"glyphicon glyphicon-exclamation-sign\"></span></a></li>";
                    }
                    else{
                        echo"<li><a href='index.php'>HOME</a></li>";
                    }
                    ?>                 <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">RECORD <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="scale.php">HEALTH MONITORING</a></li>
                        <li><a href="weight.php">WEIGHT MONITORING</a></li>
                        <li><a href="physical.php">PHYSICAL ACTIVITY MONITORING</a></li>
                    </ul>
                </li>                  <li><a href="talk.php">TALK</a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">HELP <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="helpInfo.php">INFO</a></li>
                        <li><a href="helpFinancial.php">FINANCIAL</a></li>
                        <li><a href="helpEmotional.php">EMOTIONAL</a></li>
                        <li><a href="helpPhysical.php">PHYSICAL</a></li>
                    </ul>
                </li>                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">PROFILE <span class="caret"></span></a>
                    <ul class="dropdown-menu">
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
    <h1>Lung Cancer Alliance Glossary <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>
<br>
<input type="text"  id="myInput" onkeyup="myFunction()" placeholder="Search a keyword.." title="Start typing">
<div id="sidebar">
    <ul>
        <li  ><a href="#a">A</a></li>
        <li  ><a href="#b">B</a></li>
        <li  ><a href="#c">C</a></li>
        <li  ><a href="#d">D, E</a></li>
        <li  ><a href="#f">F, G, H</a></li>
        <li  ><a href="#i">I</a></li>
        <li  ><a href="#l">L</a></li>
        <li  ><a href="#m">M</a></li>
        <li  ><a href="#n">N</a></li>
        <li  ><a href="#o">O</a></li>
        <li  ><a href="#p">P</a></li>
        <li  ><a href="#q">Q</a></li>
        <li  ><a href="#r">R</a></li>
        <li  ><a href="#s">S</a></li>
        <li  ><a href="#t">T</a></li>
        <li  ><a href="#u">U</a></li>
        <li  ><a href="#v">V, W, X</a></li>


    </ul>

</div>

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


        function myFunction() {
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
    <button class="btn" onclick="goBack()" style="float:left"><b><</b> Back </button>
</div>
</div>
</body>
<div class="clear"></div>


</html>