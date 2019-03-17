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
    <link rel="stylesheet" type="text/css" href="../stylesheets/alerts.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">
    <script src="../js/forAll.js"></script>
    <script src="../js/supportJS.js"></script>

    <meta charset="UTF-8">
    <title>Feedback</title>

</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">


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
    <h1>Feedback from the Doctor <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>

<br>

<div class="box">Doctors may respond to any information or symptoms you have logged. They will appear on this page!</div>

<?php
$sql  = "SELECT * FROM `supportSubmit` WHERE `username`= '$username' AND `seenInfo` = 'true' OR `seenSymp`='true'";
$result=$conn->query($sql);
$counter=0;
if($result->num_rows>0){
    while($rowname=$result->fetch_assoc()){
        $symptom = $rowname["symptom"];
        $additional = $rowname["additional"];
        $resInfo = $rowname["resInfo"];
        $resSymp = $rowname["resSymp"];

        if($additional!="") {
            ?>
            <br>
            <div class="box">
                <p>
                    The doctor has responded to your query: <?php echo $additional ?> <br>
                    Response: <?php echo $resInfo ?>
                    <button class="btn" id="button" onclick="markAndDeleteInfo('<?php echo $resInfo ?>')">Mark as Read and
                        Delete
                    </button>
                </p>
            </div>
            <?php
        }
        if($symptom!="") {
            ?>
            <br>
            <div class="box">
                <p>
                    The doctor has responded to your query: <?php echo $symptom ?> <br>
                    Response: <?php echo $resSymp ?>
                    <button class="btn" id="button" onclick="markAndDeleteSymp('<?php echo $resSymp ?>')">Mark as Read and
                        Delete
                    </button>
                </p>
            </div>
            <?php
        }
    }
}

?>

<br>
<div id="deleted" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanNotify" onclick="document.getElementById('deleted').style.display='none';window.location.href='supportDocFeedback.php'" style="float:right">&times;</button>
        <p>Response successfully deleted</p>
    </div>
</div>
<div id="notDelete" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanNotify" onclick="document.getElementById('notDelete').style.display='none';window.location.href='supportDocFeedback.php'" style="float:right">&times;</button>
        <p>Survivors was unable to delete the response successfully. Please check your internet connection and try again</p>
    </div>
</div>
<div class="clear"></div>

</body>
<footer>
    <div class="footer">
        <button class="btn" onclick="goBack()" style="float:left"><b><</b> Back </button>
    </div>

</footer>
</html>