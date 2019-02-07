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
    <link rel="stylesheet" type="text/css" href="../stylesheets/donut.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <script src="../js/script.js"></script>

    <meta charset="UTF-8">
    <title>Adapt To You</title>
    <script>

        if(localStorage.getItem("loginOK")===null){
            localStorage.setItem("loginOK", "no");
        }
        function checkLogIn(){
            return localStorage.getItem("loginOK")==="yes" && localStorage.getItem('username')!=='unknownUser';

        }


        var localUser = localStorage.getItem("username");
        // window.location.href = window.location.href+'?localUser='+localUser;

        if(localStorage.getItem("loginOK")===null){
            localStorage.setItem("loginOK", "no");
        }

        if(localStorage.getItem("loginOK")==="no"){
            window.location.href="signUp.php";
        }


        function checkLogIn(){
            return localStorage.getItem("loginOK")==="yes";
        }

        function checkUser(){
            localUser = localStorage.getItem("username");
            console.log("username in local storage" + localStorage.getItem("username"));
            return localStorage.getItem("username");
        }

    </script>
<style>
    input {
        display: table-cell;
        vertical-align: middle
    }

    .caroBox{
        display:inline-block;
        width: 100%;
        height: 50%;
    }

    .box{
        display:inline-block;
        margin: 0 10px;
        width: 100%;
        height:20%;
        border: 1px solid #B132E8;
        background:#DDA8FF ;

    }
    @media screen and (max-width:800px){
        display: block;
    }

    label{
        display:block;
        padding-left:15px;
        text-indent: -15px;
    }
    .choices{
        width:13px;
        height:13px;
        padding:0;
        margin:0;
        vertical-align:bottom;
        position:relative;
        top:-1px;
        *overflow:hidden;
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
                <li><a href="index.php">HOME</a></li>
                <li><a href="recordOptions.php">RECORD</a></li>
                <li><a href="talk.php">TALK</a></li>
                <li><a href="links.html">HELP</a></li>
                <li><a href="results.php">PROFILE</a></li>
            </ul>
            <ul class = "nav navbar-nav navbar-right">
                <li><a href="logout.php">LOGOUT</a></li>
            </ul>
        </div>
    </div>
</nav>


<?php


    $sql  = "SELECT * FROM `scale` WHERE `pain`<=3 AND `username` = '$username'";
    $result= $conn->query($sql);
    if($result->num_rows>0){
        $greenPain = $result->num_rows;
    }
    else{
        $greenPain=0;
    }

    $sqlAMBER  = "SELECT * FROM `scale` WHERE `pain`>=4 AND `pain`<=7 AND `username` = '$username'";
    $resultAMBER= $conn->query($sqlAMBER);
    if($resultAMBER->num_rows>0){
        $amberPAIN = $resultAMBER->num_rows;
    }
    else{
        $amberPAIN=0;
    }

    $sqlRED  = "SELECT * FROM `scale` WHERE `pain`>=8  AND `username` = '$username'";
    $resultRED= $conn->query($sqlRED);
    if($resultRED->num_rows>0){
        $redPAIN = $resultRED->num_rows;
    }
    else{
        $redPAIN=0;
    }

    $painTotal = $greenPain+$amberPAIN+$redPAIN;

    $sqlBG  = "SELECT * FROM `scale` WHERE `breathlessness`<=1  AND `username` = '$username'";
    $resultBG= $conn->query($sqlBG);
    if($resultBG->num_rows>0){
        $greenBreath = $resultBG->num_rows;
    }
    else{
        $greenBreath=0;
    }

    $sqlBA  = "SELECT * FROM `scale` WHERE `breathlessness`>=2 AND `breathlessness` <=4  AND `username` = '$username'";
    $resultBA= $conn->query($sqlBA);
    if($resultBA->num_rows>0){
        $amberBreath = $resultBA->num_rows;
    }
    else{
        $amberBreath=0;
    }

    $sqlBR  = "SELECT * FROM `scale` WHERE `breathlessness`>=5  AND `username` = '$username'";
    $resultBR= $conn->query($sqlBR);
    if($resultBR->num_rows>0){
        $redBreath = $resultBR->num_rows;
    }
    else{
        $redBreath=0;
    }

    $breathlessnessTotal = $greenBreath+$amberBreath+$redBreath;

    $sqlPG  = "SELECT * FROM `scale` WHERE `performance`<=1  AND `username` = '$username'";
    $resultPG= $conn->query($sqlPG);
    if($resultPG->num_rows>0){
        $greenPerformance = $resultPG->num_rows;
    }
    else{
        $greenPerformance=0;
    }

    $sqlPA  = "SELECT * FROM `scale` WHERE `performance`=2 AND `breathlessness` <=4  AND `username` = '$username'";
    $resultPA= $conn->query($sqlPA);
    if($resultPA->num_rows>0){
        $amberPerformance = $resultPA->num_rows;
    }
    else{
        $amberPerformance=0;
    }

    $sqlBP  = "SELECT * FROM `scale` WHERE `performance`>=3  AND `username` = '$username'";
    $resultBP= $conn->query($sqlBP);
    if($resultBP->num_rows>0){
        $redPerformance = $resultBP->num_rows;
    }
    else{
        $redPerformance=0;
    }

    $sqlEntries  = "SELECT * FROM `scale` WHERE `username` = '$username'";
    $resultEntries= $conn->query($sqlEntries);
    if($resultEntries->num_rows>0){
        $entries = $resultEntries->num_rows;
    }
    else{
        $entries=0;
    }



    $performanceTotal = $greenPerformance+$amberPerformance+$redPerformance;

if($entries!=0) {
    //PAIN DONUT BARS
    $greenPainBar = $greenPain / ($entries) * 210;
    $amberPainBar = $amberPAIN / ($entries) * 210;
    $redPainBar = $redPAIN / ($entries) * 210;

    //BREATHING DONUT BARS
    $greenBBar = $greenBreath / ($entries) * 210;
    $amberBBar = $amberBreath / ($entries) * 210;
    $redBBar = $redBreath / ($entries) * 210;

    //PERFORMANCE DONUT BARS
    $greenPBar = $greenPerformance / ($entries) * 210;
    $amberPBar = $amberPerformance / ($entries) * 210;
    $redPBar = $redPerformance / ($entries) * 210;
}
    ?>
<?php
if($entries!=0){
?>
    <div class="container-fluid bg-1 text-center">

    <div class="container" id="allTime">
        <div class="jumbotron text-center">
            <h1>My Progress of All Time</h1>
        </div>
        <br>
        <div class="caroBox">

        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <div class="container">
                        <div class="donut-chart-block block">
                            <div class="donut-chart">
                                <div id="part1Pain" class="portion-block">
                                    <div class="circle" id="c1Pain"></div>
                                </div>
                                <div id="part2Pain" class="portion-block">
                                    <div class="circle" id="c2Pain"></div>
                                </div>
                                <div id="part3Pain" class="portion-block">
                                    <div class="circle" id="c3Pain"></div>
                                </div>
                                <p class="center" style="color:black">Pain</p>
                            </div>
                            <div>
                                <br>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="container">
                        <div class="donut-chart-block block">
                            <div class="donut-chart">
                                <div id="part1Breath" class="portion-block">
                                    <div class="circle" id="c1Breath"></div>
                                </div>
                                <div id="part2Breath" class="portion-block">
                                    <div class="circle" id="c2Breath"></div>
                                </div>
                                <div id="part3Breath" class="portion-block">
                                    <div class="circle" id="c3Breath"></div>
                                </div>
                                <p class="center" style="color:black">Breathing</p>
                            </div>
                            <div>
                                <br>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="container">
                        <div class="donut-chart-block block">
                            <div class="donut-chart">
                                <div id="part1Performance" class="portion-block">
                                    <div class="circle" id="c1Perform"></div>
                                </div>
                                <div id="part2Performance" class="portion-block">
                                    <div class="circle" id="c2Perform"></div>
                                </div>
                                <div id="part3Performance" class="portion-block">
                                    <div class="circle" id="c3Perform"></div>
                                </div>
                                <p class="center" style="color:black">Performance</p>
                            </div>
                            <div>
                                <br>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>

        </div>
    </div>
    </div>



    <?php
    }
else{
        echo "<div class='jumbotron text-center'>
            <h2>No progress recorded</h2>
        </div>";
    }


$sqlGPM  = "SELECT * FROM `scale` WHERE `pain`<=3 AND `username` = '$username' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$greenPM= $conn->query($sqlGPM);
if($greenPM->num_rows>0){
    $greenPainM = $greenPM->num_rows;
}
else{
    $greenPainM=0;
}

$sqlAPM  = "SELECT * FROM `scale` WHERE `pain`>=4 AND `pain`<=7 AND `username` = '$username' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$amberPM= $conn->query($sqlAPM);
if($amberPM->num_rows>0){
    $amberPainM = $amberPM->num_rows;
}
else{
    $amberPainM=0;
}

$sqlRPM  = "SELECT * FROM `scale` WHERE `pain`>=8  AND `username` = '$username' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$redPM= $conn->query($sqlRPM);
if($redPM->num_rows>0){
    $redPainM = $redPM->num_rows;
}
else{
    $redPainM=0;
}

$painTotalMonth = $greenPainM+$amberPainM+$redPainM;

$sqlGBM  = "SELECT * FROM `scale` WHERE `breathlessness`<=1  AND `username` = '$username' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultBGM= $conn->query($sqlGBM);
if($resultBGM->num_rows>0){
    $greenBreathM = $resultBGM->num_rows;
}
else{
    $greenBreathM=0;
}

$sqlBAM  = "SELECT * FROM `scale` WHERE `breathlessness`>=2 AND `breathlessness` <=4  AND `username` = '$username' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultBAM= $conn->query($sqlBAM);
if($resultBAM->num_rows>0){
    $amberBreathM = $resultBAM->num_rows;
}
else{
    $amberBreathM=0;
}

$sqlBRM  = "SELECT * FROM `scale` WHERE `breathlessness`>=5  AND `username` = '$username' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultBRM= $conn->query($sqlBRM);
if($resultBRM->num_rows>0){
    $redBreathM = $resultBRM->num_rows;
}
else{
    $redBreathM=0;
}

$breathlessnessTotalM = $greenBreathM+$amberBreathM+$redBreathM;

$sqlPGM  = "SELECT * FROM `scale` WHERE `performance`<=1  AND `username` = '$username' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultPGM= $conn->query($sqlPGM);
if($resultPGM->num_rows>0){
    $greenPerformanceM = $resultPGM->num_rows;
}
else{
    $greenPerformanceM=0;
}

$sqlPAM  = "SELECT * FROM `scale` WHERE `performance`=2 AND `breathlessness` <=4  AND `username` = '$username' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultPAM= $conn->query($sqlPAM);
if($resultPAM->num_rows>0){
    $amberPerformanceM = $resultPAM->num_rows;
}
else{
    $amberPerformanceM=0;
}

$sqlBPM  = "SELECT * FROM `scale` WHERE `performance`>=3  AND `username` = '$username' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultBPM= $conn->query($sqlBPM);
if($resultBPM->num_rows>0){
    $redPerformanceM = $resultBPM->num_rows;
}
else{
    $redPerformanceM=0;
}

$sqlEntriesM  = "SELECT * FROM `scale` WHERE `username` = '$username' AND MONTH(timeStamp)='$month' AND YEAR(timestamp)='$year'";
$resultEntriesM= $conn->query($sqlEntriesM);
if($resultEntriesM->num_rows>0){
    $entriesM = $resultEntriesM->num_rows;
}
else{
    $entriesM=0;
}



$performanceTotalM = $greenPerformanceM+$amberPerformanceM+$redPerformanceM;

    if($entriesM!=0) {
//PAIN DONUT BARS
        $greenPainBarM = $greenPainM / ($entriesM) * 210;
        $amberPainBarM = $amberPainM / ($entriesM) * 210;
        $redPainBarM = $redPainM / ($entriesM) * 210;

//BREATHING DONUT BARS
        $greenBBarM = $greenBreathM / ($entriesM) * 210;
        $amberBBarM = $amberBreathM / ($entriesM) * 210;
        $redBBarM = $redBreathM / ($entriesM) * 210;

//PERFORMANCE DONUT BARS
        $greenPBarM = $greenPerformanceM / ($entriesM) * 210;
        $amberPBarM = $amberPerformanceM / ($entriesM) * 210;
        $redPBarM = $redPerformanceM / ($entriesM) * 210;
    }



    ?>
    <?php if($entriesM!=0){ ?>

            <div class="container" id="prevMonth">
        <div class="jumbotron text-center">
            <h1>My Progress over the past month</h1>
        </div>
        <br>
                <div class="caroBox">
        <div id="myCarousel2" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel2" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel2" data-slide-to="1"></li>
                <li data-target="#myCarousel2" data-slide-to="2"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                <div class="item active">
                    <div class="container">
                        <div class="donut-chart-block block">
                            <div class="donut-chart">
                                <div id="part1PainMonth" class="portion-block">
                                    <div class="circle" id="c1PainMonth"></div>
                                </div>
                                <div id="part2PainMonth" class="portion-block">
                                    <div class="circle" id="c2PainMonth"></div>
                                </div>
                                <div id="part3PainMonth" class="portion-block">
                                    <div class="circle" id="c3PainMonth"></div>
                                </div>
                                <p class="center" style="color:black">Pain</p>
                            </div>
                            <div>
                                <br>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="container">
                        <div class="donut-chart-block block">
                            <div class="donut-chart">
                                <div id="part1BreathMonth" class="portion-block">
                                    <div class="circle" id="c1BreathMonth"></div>
                                </div>
                                <div id="part2BreathMonth" class="portion-block">
                                    <div class="circle" id="c2BreathMonth"></div>
                                </div>
                                <div id="part3BreathMonth" class="portion-block">
                                    <div class="circle" id="c3BreathMonth"></div>
                                </div>
                                <p class="center" style="color:black">Breathing</p>
                            </div>
                            <div>
                                <br>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="item">
                    <div class="container">
                        <div class="donut-chart-block block">
                            <div class="donut-chart">
                                <div id="part1PerformanceMonth" class="portion-block">
                                    <div class="circle" id="c1PerformMonth"></div>
                                </div>
                                <div id="part2PerformanceMonth" class="portion-block">
                                    <div class="circle" id="c2PerformMonth"></div>
                                </div>
                                <div id="part3PerformanceMonth" class="portion-block">
                                    <div class="circle" id="c3PerformMonth"></div>
                                </div>
                                <p class="center" style="color:black">Performance</p>
                            </div>
                            <div>
                                <br>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel2" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel2" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>

        </div>
    </div>
</div>
    </div>



        <div class="box">
    <form method="get" class="radiostyle">
        <label class="container" style="font-family: Montserrat, sans-serif">Show chart based on all records
            <span class="checkmark"></span>
            <input type="radio" class="choices" name="radio" value="1" id="1" onclick="submitAll()">
        </label>
        <br>
        <label class="container" style="font-family: Montserrat, sans-serif">Show chart based on the records from this month
            <span class="checkmark"></span>
            <input type="radio" class="choices" name="radio" value="2" id="2" onclick="submitMonth()">

        </label>
    </form>

        </div>
<br>
<?php
}
else{
    echo "<div class='jumbotron text-center'>
            <h2>No progress recorded over the past month</h2>
        </div>";
}
?>

<button onclick="goToChart()" class="btn">Weight Chart</button>
<button onclick="goToQuestions()" class="btn">Questions</button>
<button onclick="window.location.href='supportTxt.php'" class="btn">Support Circle</button>










<script>
    function deleteQ(questionNo){
        var qNo = questionNo;
        jQuery.post("deleteQ.php", {"questionNo": qNo}, function(data){
            alert("deleted Question");
            window.location.href="results.php";
            console.log("question no is "+ qNo);
        }).fail(function()
        {
            alert("something broke in sending support");
        });

    }

    function goToChart(){
        window.location.href="weightChart.php";
    }

    function goToQuestions(){
        window.location.href="questions.php";
    }
</script>


    <script>
        //    let val1=90;
        //    let val2=180;
        //    let val3 = 90;
        var greenPain =<?php echo $greenPainBar?>;
        var amberPain =<?php echo $amberPainBar?>;
        var redPain = <?php echo $redPainBar ?>;
        var greenPainMonth =<?php echo $greenPainBarM?>;
        var amberPainMonth =<?php echo $amberPainBarM?>;
        var redPainMonth = <?php echo $redPainBarM ?>;
        console.log("Green pain month"+ greenPainMonth);
        console.log("Amber pain month"+ amberPainMonth);
        console.log("Red pain month"+ redPainMonth);


        var greenBreath = <?php echo $greenBBar?>;
        var amberBreath = <?php echo $amberBBar?>;
        var redBreath = <?php echo $redBBar?>;
        var greenBreathMonth = <?php echo $greenBBarM?>;
        var amberBreathMonth = <?php echo $amberBBarM?>;
        var redBreathMonth = <?php echo $redBBarM?>;
        console.log("Green breath month"+ greenBreathMonth);
        console.log("Amber breath month"+ amberBreathMonth);
        console.log("Red breath month"+ redBreathMonth);

        var greenPerformance = <?php echo $greenPBar?>;
        var amberPerformance = <?php echo $amberPBar?>;
        var redPerformance = <?php echo $redPBar ?>;
        var greenPerformanceMonth = <?php echo $greenPBarM?>;
        var amberPerformanceMonth = <?php echo $amberPBarM?>;
        var redPerformanceMonth = <?php echo $redPBarM ?>;
        console.log("Green performance month"+ greenPerformanceMonth);
        console.log("Amber performance month"+ amberPerformanceMonth);
        console.log("Red performance month  "+ redPerformanceMonth);



        document.getElementById("part1Pain").style.transform = "rotate(0deg)";
        document.getElementById("c1Pain").style.transform =  "rotate("+greenPain+"deg)";
        document.getElementById("part2Pain").style.transform = "rotate("+greenPain+"deg)";
        document.getElementById("c2Pain").style.transform = "rotate("+amberPain+"deg)";
        document.getElementById("part3Pain").style.transform = "rotate("+(greenPain+amberPain)+"deg)";
        document.getElementById("c3Pain").style.transform = "rotate("+redPain+"deg)";

        document.getElementById("part1Breath").style.transform = "rotate(0deg)";
        document.getElementById("c1Breath").style.transform =  "rotate("+greenBreath+"deg)";
        document.getElementById("part2Breath").style.transform = "rotate("+greenBreath+"deg)";
        document.getElementById("c2Breath").style.transform = "rotate("+amberBreath+"deg)";
        document.getElementById("part3Breath").style.transform = "rotate("+(greenBreath+amberBreath)+"deg)";
        document.getElementById("c3Breath").style.transform = "rotate("+redBreath+"deg)";

        document.getElementById("part1Performance").style.transform = "rotate(0deg)";
        document.getElementById("c1Perform").style.transform =  "rotate("+greenPerformance+"deg)";
        document.getElementById("part2Performance").style.transform = "rotate("+greenPerformance+"deg)";
        document.getElementById("c2Perform").style.transform = "rotate("+amberPerformance+"deg)";
        document.getElementById("part3Performance").style.transform = "rotate("+(greenPerformance+amberPerformance)+"deg)";
        document.getElementById("c3Perform").style.transform = "rotate("+redPerformance+"deg)";

        document.getElementById("part1PainMonth").style.transform = "rotate(0deg)";
        document.getElementById("c1PainMonth").style.transform =  "rotate("+greenPainMonth+"deg)";
        document.getElementById("part2PainMonth").style.transform = "rotate("+greenPainMonth+"deg)";
        document.getElementById("c2PainMonth").style.transform = "rotate("+amberPainMonth+"deg)";
        document.getElementById("part3PainMonth").style.transform = "rotate("+(greenPainMonth+amberPainMonth)+"deg)";
        document.getElementById("c3PainMonth").style.transform = "rotate("+redPainMonth+"deg)";

        document.getElementById("part1BreathMonth").style.transform = "rotate(0deg)";
        document.getElementById("c1BreathMonth").style.transform =  "rotate("+greenBreathMonth+"deg)";
        document.getElementById("part2BreathMonth").style.transform = "rotate("+greenBreathMonth+"deg)";
        document.getElementById("c2BreathMonth").style.transform = "rotate("+amberBreathMonth+"deg)";
        document.getElementById("part3BreathMonth").style.transform = "rotate("+(greenBreathMonth+amberBreathMonth)+"deg)";
        document.getElementById("c3BreathMonth").style.transform = "rotate("+redBreathMonth+"deg)";

        document.getElementById("part1PerformanceMonth").style.transform = "rotate(0deg)";
        document.getElementById("c1PerformMonth").style.transform =  "rotate("+greenPerformanceMonth+"deg)";
        document.getElementById("part2PerformanceMonth").style.transform = "rotate("+greenPerformanceMonth+"deg)";
        document.getElementById("c2PerformMonth").style.transform = "rotate("+amberPerformanceMonth+"deg)";
        document.getElementById("part3PerformanceMonth").style.transform = "rotate("+(greenPerformanceMonth+amberPerformanceMonth)+"deg)";
        document.getElementById("c3PerformMonth").style.transform = "rotate("+redPerformanceMonth+"deg)";

    </script>




    <script>

        var x = document.getElementById("allTime");
        var y = document.getElementById("prevMonth");
        x.style.display="none";
        y.style.display="block";
        function logoutFunction(){
            window.location.href="logout.php";

        }

        function submitAll(){
                var x = document.getElementById("allTime");

                if (x.style.display === "none") {
                    x.style.display = "block";
                    y.style.display="none";
                } else {
                    x.style.display = "block";
                }

        }

        function submitMonth(){
            var y = document.getElementById("prevMonth");
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





    <div class="clear"></div>
</body>
<footer>
    <div class="footer">
        <p style="text-align: center;">&copy; Sara Reid Final Year Project 2019</p>
    </div>
</footer>
</html>