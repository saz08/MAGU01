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
        localStorage.setItem('loginOK', "no");
    </script><?php
}

$username = $_SESSION["userName"];
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
    <script src="../js/script.js"></script>

    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">

    <meta charset="UTF-8">
    <title>Project</title>
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
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">RECORD <span class="caret"></span></a>
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
                        <li><a href="progressChart.php">PROGRESS CHARTS</a></li>
                        <li><a href="weightChart.php">WEIGHT CHART</a></li>
                        <li><a href="pieChart.php">PHYSICAL ACTIVITY CHART</a></li>
                        <li><a href="questions.php">QUESTIONS</a></li>
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
    <h1>Monitor your weight</h1>
</div>

<div class="box"><p>Monitoring your weight is very important after an operation. A sudden increase or decrease in weight can help detect if you need further treatment. </p>
    <p>Please weigh yourself once a week and input the results to keep track of your weight.</p>
<p>You can input your weight in either KG or LBS</p></div>
<br>
<div class="box">
    <form method="get" class="radiostyle">
        <label class="container" style="font-family: Montserrat, sans-serif">Record Weight in Stone
            <span class="checkmark"></span>
            <input type="radio" class="choices" name="radio" value="1" id="1" onclick="submitStone()">
        </label>
        <br>
        <label class="container" style="font-family: Montserrat, sans-serif">Record Weight in Kilograms
            <span class="checkmark"></span>
            <input type="radio" class="choices" name="radio" value="2" id="2" onclick="submitKG()">
        </label>
    </form>

</div>
<div id="kilogram">
<form method="post" class="WHOstyle">
    Values are recorded using KG. Input value to see approximate conversion to LBS
    <input id="inputKilograms" type="number" step="0.01" placeholder="KG" name="KG" oninput="weightConverter(this.value)" onchange="weightConverter(this.value)">
    <span id="outputStones"></span>
    <input type="hidden" name="action" value="filled">
    <input type="submit" name="submit" value="Submit"/>
</form>
</div>

<div id="stone">
<form method="post" class="WHOstyle">
    Values are recorded using LBS. Input value to see approximate conversion to KG
    <input id="inputKilograms" type="number" step="0.01" placeholder="LBS" name="LBS" oninput="weightConverterKG(this.value)" onchange="weightConverterKG(this.value)">
    <span id="outputKilograms"></span>
    <input type="hidden" name="action2" value="filled">
    <input type="submit" name="submit" value="Submit"/>
</form>
</div>

<div class="clear"></div>


<?php
if($action === "filled") {
    $kg = (safePost($conn,"KG"));
    $sql1 = "SELECT `id` FROM `account` WHERE username = '$username'";
    $resultID=$conn->query($sql1);
    if($resultID->num_rows>0) {
        while ($rowname = $resultID->fetch_assoc()) {
            $id = $rowname["id"];

        }
    }

    $sql  = "INSERT INTO `weight` (`id`, `username`, `kg`,`timeStamp`) VALUES ('$id', '$username', '$kg',CURRENT_TIMESTAMP)";
    if ($conn->query($sql) === TRUE) {
        ?>
        <script>
            window.location.href = "index.php";
        </script>
        <?php
    }
}

if($action2==="filled"){
    $lbs = (safePost($conn,"LBS"));
    $sql2 = "SELECT `id` FROM `account` WHERE username = '$username'";
    $resultID2 = $conn->query($sql2);
    if($resultID2->num_rows>0) {
        while ($rowname = $resultID2->fetch_assoc()) {
            $id = $rowname["id"];
        }
    }
    $kiloDiv = 0.15747;
    $weight = $lbs/$kiloDiv;
    $sql  = "INSERT INTO `weight` (`id`, `username`, `kg`,`timeStamp`) VALUES ('$id', '$username', '$weight' ,CURRENT_TIMESTAMP)";
    if ($conn->query($sql) === TRUE) {
        ?>
        <script>
            window.location.href = "index.php";
        </script>
        <?php
    }
}
?>


<script>

    var x = document.getElementById("stone");
    var y = document.getElementById("kilogram");
    x.style.display="none";
    y.style.display="block";


    function submitStone(){
        var x = document.getElementById("stone");

        if (x.style.display === "none") {
            x.style.display = "block";
            y.style.display="none";
        } else {
            x.style.display = "block";
        }

    }

    function submitKG(){
        var y = document.getElementById("kilogram");
        if (y.style.display === "none") {
            y.style.display = "block";
            x.style.display="none";
        } else {
            y.style.display = "block";
        }

    }

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