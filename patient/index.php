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
    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">

    <script src="../js/script.js"></script>
    <script src="../js/forAll.js"></script>

    <meta charset="UTF-8">
    <title>Project</title>

</head>

<body>
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
                ?>                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">RECORD <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="scale.php">HEALTH MONITORING</a></li>
                        <li><a href="weight.php">WEIGHT MONITORING</a></li>
                        <li><a href="physical.php">PHYSICAL ACTIVITY MONITORING</a></li>
                    </ul>
                </li>                 <li><a href="talk.php">TALK</a></li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">HELP <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="helpInfo.php">INFO</a></li>
                        <li><a href="helpFinancial.php">FINANCIAL</a></li>
                        <li><a href="helpEmotional.php">EMOTIONAL</a></li>
                        <li><a href="helpPhysical.php">PHYSICAL</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">PROFILE <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="progressChart.php">PROGRESS CHARTS</a></li>
                        <li><a href="weightChart.php">WEIGHT CHART</a></li>
                        <li><a href="pieChart.php">PHYSICAL ACTIVITY CHART</a></li>
                        <li><a href="questions.php">QUESTIONS</a></li>
                        <li><a href="supportTxt.php">SUPPORT CIRCLE</a></li>
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
    <h1>Homepage <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>
<h2 style="float:right">Today is <?php echo date('jS F Y')?></h2>
<br>
<br>
<?php
$sqlNew  = "SELECT * FROM `scale` WHERE `username` = '$username'";
$resultNew = $conn->query($sqlNew);
if($resultNew->num_rows<1) {
  echo"<div class='box'>
<h2>Welcome to Survivors!</h2>
<p>This is where you can 
<ul>
  <li>Record your pain, breathlessness, performance and any other queries you're unsure of!</li>
  <li>Monitor your weight, it is important that we don't see a sudden increase or decrease in your weight</li>
  <li>Monitor how much physical activity you do, we want you to improve!</li>
  <li>Get involved in our patient forum room</li>
  <li>Find helpful links regarding general info, financial, emotional and physical help</li>
  <li>View helpful charts showing your progress</li>
  <li>Log questions you'd like to remember for your next appointment</li>
  <li>Add friends or family members to a support circle, where they can view your progress and enter symptoms on your behalf</li>

</ul> </p>
</div>";
}
?>


<?php
$sqlInfo  = "SELECT * FROM `scale` WHERE `username` = '$username' AND `seen` = 'true'";
$resultInfo = $conn->query($sqlInfo);
if($resultInfo->num_rows>0) {
    while ($rowname = $resultInfo->fetch_assoc()) {
        $info = $rowname["additionalInfo"];
        $symptom = $rowname["symptom"];
        $seen = $rowname["seen"];
        $response = $rowname["response"];

?>
<br>
        <div class="box">
            <p>
                The doctor has responded to your query: <?php if($info!=""){echo $info;} if($symptom!=""){echo $symptom;} ?> <br>
                Response: <?php echo $response ?>
                <button class="btn" onclick="markAndDelete('<?php echo $response?>')">Mark as Read and Delete</button>
            </p>
        </div>
<?php
    }
}






$sqlScale  = "SELECT * FROM `scale` WHERE `username` = '$username' ORDER BY `timeStamp` DESC LIMIT 1";
$resultScale = $conn->query($sqlScale);
if($resultScale->num_rows>0) {
while ($rowname = $resultScale->fetch_assoc()) {
    $date = $rowname["timeStamp"];
    $date2 = (new DateTime($date))->format('jS F Y');

    echo "<br><div class='box'><p>The last time you recorded your pain, breathlessness and performance was " .$date2."</p>
<p>It is recommended that you log your symptoms every 7 days, next logging date should be: ".date('jS F Y', strtotime($date2. '+ 7 days'));
       if(date('jS F Y', strtotime($date2. '+ 7 days'))==date('jS F Y')){
           echo "     <button class='btn' onclick='goRecord()'>Record Now!</button>";
       }
       echo"</p></div>";

}
}

$sqlPhysical = "SELECT * FROM `physical` WHERE `username` = '$username' ORDER BY `timeStamp` DESC LIMIT 1";
$resultPhysical = $conn->query($sqlPhysical);
if($resultPhysical -> num_rows>0){
    while($rowname=$resultPhysical->fetch_assoc()){
        $vig = $rowname["vigorous"];
        $mod = $rowname["moderate"];
        $walk = $rowname["walking"];
        $sit = $rowname["sitting"];
        if($walk<=3){
            echo"<div class='box'>
                    <p>Your last physical recording shows you only walked less than 3 days out of 7 last week.<br> 
                    If you're having trouble finding physical activities, click <a href=helpPhysical.php>HERE</a> to see what's near you!!
                    </p>
                </div>";
        }
        if($sit>=5) {
            echo "<div class='box'>
                    <p>Your last physical recording shows you spent more than 4 days sitting down.\n 
                    Try walking around the house, garden or along the street.
                    </p>
                </div>";
        }
    }
}

?>
    <?php
    $sqlScale  = "SELECT * FROM `scale`WHERE `username` = '$username' ORDER BY `timeStamp` DESC LIMIT 1";
    $resultScale = $conn->query($sqlScale);
    if($resultScale->num_rows>0) {
        while ($rowname = $resultScale->fetch_assoc()) {
            echo"<div class='box'>";
            $pain = $rowname["pain"];
            $breath = $rowname["breathlessness"];
            $performance=$rowname["performance"];

            if($pain>=8){
                echo"<p>Your most recent pain score was $pain. <br> Common suggestions are: check you are still taking your antibiotics correctly</p>";
            }
            if($pain>=4 && $pain<=7){
                echo"<p>Your most recent pain score was $pain. <br> Common suggestions are: ensure you are ok</p>";
            }
            if($pain<4){
                echo"<p>Your most recent pain score was $pain. <br> You are progressing well!</p>";
            }
            if($breath=5){
                echo"<p>Your most recent breathlessness score was $breath. <br> Common suggestions are: take it easy for the next few days</p>";
            }
            if($breath>=2&&$breath<=4){
                echo"<p>Your most recent breathlessness score was $breath. <br> Suggestion:</p>";
            }
            if($breath<4){
                echo"<p>Your most recent breathlessness score was $breath. <br> You are progressing well!</p>";
            }
            if($performance>=3){
                echo"<p>Your most recent performance score was $performance. <br> Seek help</p>";
            }
            if($performance>=1&&$performance<=2){
                echo"<p>Your most recent performance score was $performance. <br> Suggestions</p>";
            }
            if($performance<1){
                echo"<p>Your most recent performance score was $performance. <br> You are progressing well!</p>";
            }
        }
    }
echo"</div>";
    ?>


<?php
//$sqlNew = "SELECT"
//?>


<script>
    function goRecord(){
        window.location.href="recordOptions.php";
    }

    function markAndDelete(response){
        jQuery.post("markAsSeen.php", {"Response": response}, function(data){
            alert("Read and Deleted");
            window.location.href="index.php";
        }).fail(function()
        {
            alert("something broke in submitting your records");
        });
    }

</script>
</body>
<div class="clear"></div>

<footer>
    <div class="footer">
        <p style="text-align: center;">&copy; Sara Reid Final Year Project 2019</p>
    </div></footer>
</html>