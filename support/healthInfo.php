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
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content ="width=device-width, initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta name="mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <link rel="stylesheet" type="text/css" href="../stylesheets/donut.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/radio.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/navigation.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/collapsible.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">
    <script src="../js/forAll.js"></script>
    <script src="../js/supportJS.js"></script>
    <meta charset="UTF-8">
    <title>Health Information</title>




</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

<?php

?>
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
                <li><a href="supportHome.php">HOME</a></li>
                <li><a href="supportInput.php">RECORD</a></li>
                <?php
                if($_SESSION["userName"]!=null) {
                    $username = $_SESSION["userName"];
                }
                else{
                    ?><script>
                        localStorage.setItem("username","unknownUser");
                        localStorage.setItem("loginOKSupport","no");
                        alert("Session has expired, please log in again");
                        window.location.href="supportSignUp.php";
                    </script><?php
                }

                $sqlInfo = "SELECT * FROM `supportSubmit` WHERE `username` = '$username'";
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
                    echo "<li><a href='supportDocFeedback.php'>FEEDBACK <span class=\"glyphicon glyphicon-exclamation-sign\"></span></a></li>";
                }
                else{
                    echo"<li><a href='supportDocFeedback.php'>FEEDBACK</a></li>";
                }
                ?>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" onclick="openHelp()">HELP <span class="caret"></span></a>
                    <ul class="dropdown-menu" id="help">
                        <li><a href="healthInfo.php">INFO</a></li>
                        <li><a href="financialInfo.php">FINANCIAL</a></li>
                        <li><a href="emotionalInfo.php">EMOTIONAL</a></li>
                        <li><a href="physicalInfo.php">PHYSICAL</a></li>
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
    <h1>Health Information <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>
<div class="clear"></div>
<button class="collapsible" onclick="window.location.href='supportGlossary.php'">Complicated Terms</button>
<button class="collapsible">What Happens After Surgery?</button>
<div class="content">
    <div id="problems"></div>
</div>
<button class="collapsible">Recovering After Surgery</button>
<div class="content">
    <div id="recovery"></div>
</div>
<button class="collapsible">Helping your Survivor</button>
<div class="content">
    <div id="caring"></div>
</div>
<button class="collapsible">Support for You</button>
<div class="content">
    <div id="support"></div>
    <div id="groups"></div>
</div>




<script>

    var rec= new XMLHttpRequest();
    rec.open('GET', '../html/problemsCR.html', true);
    rec.onreadystatechange= function() {
        if (this.readyState!==4) return;
        if (this.status!==200) return; // or whatever error handling you want
        document.getElementById('problems').innerHTML= this.responseText;
    };
    rec.send();

    var rec= new XMLHttpRequest();
    rec.open('GET', '../html/recovery.html', true);
    rec.onreadystatechange= function() {
        if (this.readyState!==4) return;
        if (this.status!==200) return; // or whatever error handling you want
        document.getElementById('recovery').innerHTML= this.responseText;
    };
    rec.send();

    var spt= new XMLHttpRequest();
    spt.open('GET', '../html/forYou.html', true);
    spt.onreadystatechange= function() {
        if (this.readyState!==4) return;
        if (this.status!==200) return; // or whatever error handling you want
        document.getElementById('support').innerHTML= this.responseText;
    };
    spt.send();

    var grp= new XMLHttpRequest();
    grp.open('GET', '../html/support.html', true);
    grp.onreadystatechange= function() {
        if (this.readyState!==4) return;
        if (this.status!==200) return; // or whatever error handling you want
        document.getElementById('groups').innerHTML= this.responseText;
    };
    grp.send();

    var car= new XMLHttpRequest();
    car.open('GET', '../html/caring.html', true);
    car.onreadystatechange= function() {
        if (this.readyState!==4) return;
        if (this.status!==200) return; // or whatever error handling you want
        document.getElementById('caring').innerHTML= this.responseText;
    };
    car.send();



    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.maxHeight){
                content.style.maxHeight = null;
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    }

    function next(){
        window.location.href="financialInfo.php";
    }
</script>
<div class="footer">
    <button class="btn" onclick="goBack()" style="float:left"><b><</b> Back </button>
    <button class="btn" style="float:right" onclick="next()"> Next <b> > </b></button>
</div>
</body>
<div class="clear"></div>


</html>