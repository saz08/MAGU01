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
    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">
    <link rel="stylesheet" type="text/css" href="../stylesheets/radio.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/navigation.css">
    <script src="../js/script.js"></script>
    <script src="../js/forAll.js"></script>
    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <meta charset="UTF-8">
    <title>Monitor Weight</title>

</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60" >
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
    <h1 style="left:10%;width:80%;text-align: center">Monitor your weight <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>
<button class="openbtn" onclick="openNavWeight()">Stones->Lbs</button>


<div class="box" id="x"><p>Monitoring your weight is very important after an operation. A sudden increase or decrease in weight can help detect if you need further treatment. </p>
    <p>Please weigh yourself once a week and input the results to keep track of your weight.</p>
</div>
<br>



<div id="stone" class="weightStyle">
<form method="post" >
    <h2>Values are recorded using LBS. Input value to see approximate conversion to Stones</h2>
    <input id="inputLBS" type="number" step="0.01" placeholder="Enter your weight in pounds (lbs)" name="lbs" oninput="weightConverter(this.value)" onchange="weightConverter(this.value)">
    <span id="outputStones"></span>
    <br>
    <input type="hidden" name="action" value="filled">
    <input type="submit" name="submit" value="Submit" class="btn" id="button"/>
    </form>
</div>

<div class="weightNav" id="mySidebar">
    <br>
    <a class="closebtn" onclick="closeNavWeight()" style="color: white;background-color: mediumpurple" >  <</a>
    <br>
        <table id="table">
            <tr>
                <th>Stone</th>
                <th>Pounds(lbs)</th>
            </tr>
            <tr>
                <td>1</td>
                <td>14</td>
            </tr>
            <tr>
                <td>8</td>
                <td>112</td>
            </tr>
            <tr>
                <td>9</td>
                <td>126</td>
            </tr>
            <tr>
                <td>10</td>
                <td>140</td>
            </tr>
            <tr>
                <td>11</td>
                <td>154</td>
            </tr>
            <tr>
                <td>12</td>
                <td>168</td>
            </tr>
            <tr>
                <td>13</td>
                <td>182</td>
            </tr>
        </table>
    <br>
</div>
<div class="clear"></div>

<div class="clear"></div>





<?php
if($action === "filled") {
    $lbs = (safePost($conn,"lbs"));
    $sql1 = "SELECT `id` FROM `account` WHERE username = '$username'";
    $resultID=$conn->query($sql1);
    if($resultID->num_rows>0) {
        while ($rowname = $resultID->fetch_assoc()) {
            $id = $rowname["id"];

        }
    }

    $sql  = "INSERT INTO `weight` (`id`, `username`, `lbs`,`timeStamp`) VALUES ('$id', '$username', '$lbs',CURRENT_TIMESTAMP)";
    if ($conn->query($sql) === TRUE) {
        ?>
        <script>
            window.location.href = "weightChart.php";
        </script>
        <?php
    }
}

?>


<script>
    function next(){
        window.location.href="physical.php";
    }
</script>
<div>
    <button class="btn" onclick="goBack()" style="left:50%"><b><</b> Back </button>
    <button class="btn" style="float:right" onclick="next()"> Next <b> > </b></button>
</div>
</body>


</html>