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
    <link rel="stylesheet" type="text/css" href="../stylesheets/alerts.css">

    <meta charset="UTF-8">
    <title>Monitor Physical Activity</title>


</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

<div id="session" class="modal">
    <div class="modal-content">
        <span class="close" id="spanSave" onclick="document.getElementById('session').style.display='none'; window.location.href='signUp.php';">&times;</span>
        <p>Session has expired, please log in again!</p>
    </div>
</div>

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
                            window.location.href="signUp.php";
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
    <h1>Monitor your physical activity <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>

<br>

<div class="box">The following questions have been adapted from the YOUTHREX International Physical Acitivity Questionnaire.
    <p>
        <details> <summary>: This means there is more information: please click on the text to see more info about the option.</summary> </details>
    </p></div>

<br>

<div class="box">
<form method="post" class="WHOstyle">
    <label class="container" style="text-align: left;">1: During the last 7 days, how much time did you spend sitting on a week day?
        <select name="sitting" style="float:right">
            <option value=""></option>
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <div class="divSpace"></div>
    </label>

    <label class="container" style="text-align: left;">2: During the last 7 days, on how many days did you walk for at least 10 minutes at a time?
        <select name="walk" style="float:right">
            <option value=""></option>
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
        </select>
        <div class="divSpace"></div>

    </label>
    <label class="container" style="text-align: left;"><details><summary>3: During the last 7 days, on how many days did you do moderate physical activities?</summary>Such as: carrying light loads, bicyling at a regular pace, or doubles tennis? Do not include walking.</details>
        <select name="moderate" style="float:right">
            <option value=""></option>
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
        </select>
        <div class="divSpace"></div>

    </label>
    <label class="container" style="text-align: left;"><details><summary>4: During the last 7 days, on how many days did you do vigorous physical activities?</summary>Such as: heavy lifting, digging, aerobics or fast bicycling</details>
        <select name="vigorous" style="float:right">
            <option value=""></option>
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
        </select>
    </label>

    <input type="hidden" name="action" value="filled">
    <input type="submit" class="btn" id="button" name="submit" value="Submit"/>
    <div class="divSpace"></div>
</form>
</div>

<div class="clear"></div>
<?php
if($action === "filled") {
    $vig = (safePost($conn,"vigorous"));
    $mod = (safePost($conn,"moderate"));
    $walk = (safePost($conn,"walk"));
    $sit = (safePost($conn,"sitting"));
    $sql1 = "SELECT `id` FROM `account` WHERE username = '$username'";
    $resultID=$conn->query($sql1);
    if($resultID->num_rows>0) {
        while ($rowname = $resultID->fetch_assoc()) {
            $id = $rowname["id"];
        }
    }

    $sql  = "INSERT INTO `physical` (`id`,`username`,`vigorous`, `moderate`, `walking`, `sitting`) VALUES ('$id','$username','$vig', '$mod', '$walk', '$sit')";
    if ($conn->query($sql) === TRUE) {
        ?>
        <script>
            window.location.href = "physicalChart.php";
        </script>
        <?php
    }
}

?>
<div>
</div>
<footer>
    <div class="footer">
        <button class="btn" style=float:left; onclick="goBack()"><b><</b> Back </button>
    </div>
</footer>
</body>
</html>