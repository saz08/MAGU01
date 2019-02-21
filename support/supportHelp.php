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
    </script><?php
}

$username = $_SESSION["userName"];
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
    <script src="../js/forAll.js"></script>
    <script src="../js/supportJS.js"></script>

    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">

    <meta charset="UTF-8">
    <title>Project</title>
    <style>
        .collapsible {
            background-color: purple;
            color: white;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
        }

        .active, .collapsible:hover {
            background-color: #CF1AFF;
        }

        .collapsible:after {
            content: '\002B';
            color: white;
            font-weight: bold;
            float: right;
            margin-left: 5px;
        }

        .active:after {
            content: "\2212";
        }

        .content {
            padding: 0 18px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;
            background-color: #f1f1f1;
        }
    </style>
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
                <li><a href="supportHome.php">HOME</a></li>
                <li><a href="supportInput.php">RECORD</a></li>
                <?php
                $sqlInfo = "SELECT * FROM `supportSubmit` WHERE `username` = '$username'";
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
                    echo "<li><a href='supportDocFeedback.php'>FEEDBACK <span class=\"glyphicon glyphicon-exclamation-sign\"></span></a></li>";
                }
                else{
                    echo"<li><a href='supportDocFeedback.php'>FEEDBACK</a></li>";
                }
                ?>
                <li><a href="supportHelp.php">HELP</a></li>

            </ul>
            <ul class = "nav navbar-nav navbar-right">
                <li><a href="../patient/logout.php">LOGOUT</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="jumbotron text-center">
    <h1>Information <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>

<button class="collapsible">About Lung Cancer</button>
<div class="content">
    <p>This is the Cancer Research UK page about Lung Cancer</p>
    <p>About: <a href="https://www.cancerresearchuk.org/about-cancer/lung-cancer?ds_kids=p3731628530&adc=cpc&gclid=CjwKCAiA9qHhBRB2EiwA7poaeO1QKd-ItjNALPRFC1CFz_9Rh0TjlvZHd8DSRNSqDkl3UDlvFv_YoBoCMb0QAvD_BwE">Cancer Research UK: Lung Cancer</a></p>
</div>
<button class="collapsible">Complicated Terms</button>
<div class="content">
    <p>Complicated Terms: <a href="https://lungcanceralliance.org/resources-and-support/glossary/">Lung Cancer Alliance Glossary</a></p>
</div>
<button class="collapsible">What Happens After Surgery?</button>
<div class="content">
    <p>Problems after Surgery: <a href="https://www.cancerresearchuk.org/about-cancer/lung-cancer/treatment/surgery/possible-problems">Cancer Research UK</a></p>

    <p>Life after Treatment: <a href="https://www.macmillan.org.uk/information-and-support/lung-cancer/non-small-cell-lung-cancer/treating/after-treatment-for-lung-cancer">MacMillan</a></p>
</div>
<button class="collapsible">Helping your Survivor</button>
<div class="content">
    <p>Caring for your loved one: <a href="https://www.lungcancer.org/find_information/publications/156-caring_for_your_loved_one_with_lung_cancer">Lung Cancer.org</a></p>
    <p>Organisations: <a href="https://www.cancerresearchuk.org/about-cancer/lung-cancer/living-with/resources-books">Cancer Research</a></p>
</div>
<button class="collapsible">Support for You</button>
<div class="content">
    <p>Support for you and your family: <a href="https://www.cancerresearchuk.org/about-cancer/lung-cancer/advanced/living-with/support-at-home">Cancer Research</a></p>
    <p>Support Groups: <a href="https://www.roycastle.org/how-we-help/services-for-you/support-groups">Roy Castle Support Groups</a></p>
    <p>Balancing work and being a carer: <a href="https://www.macmillan.org.uk/information-and-support/organising/work-and-cancer/if-youre-a-carer#162557">MacMillan</a></p>

</div>


<br>



<script>


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
</script>
</body>
<div class="clear"></div>

<footer>
    <div class="footer">
        <div class="glyphicon glyphicon-arrow-left" style="float:left" id="arrows" onclick="goBack()"></div>
        <p style="text-align: center;">&copy; Sara Reid Final Year Project 2019</p>
    </div></footer>
</html>