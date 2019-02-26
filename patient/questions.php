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
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

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
    <link rel="stylesheet" type="text/css" href="../stylesheets/radio.css">

    <meta charset="UTF-8">
    <title>Questions</title>
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
    <h1>Questions <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>
    <div class="container-fluid bg-2 text-center">

        <p>Note down any questions you have</p>
        <form method="post" name="questions">
            <input type="text" name="question" placeholder="Type a question here..."><br>
            <input type="hidden" name="action" value="filled">
            <br>
            <input type="submit" value="Save Question" class="btn"><br>
        </form>
    </div>
<br>
<?php

$question= (safePost($conn,"question"));

if($action==="filled"){
    $sql  = "INSERT INTO `questions` (`question`, `username`) VALUES ('$question', '$username')";
    $conn->query($sql);?>
    <script>window.location.href="questions.php";</script>
    <?php
}
?>
<?php
$sqlJournal = "SELECT * FROM `questions` WHERE `username` = '$username'";
$resultJournal = $conn->query($sqlJournal);
if($resultJournal->num_rows>0) {


?>
    <div class="container-fluid bg-3 text-center">
        <table class="table table-striped" id="questionTable">
            <tr>
                <th>Questions</th>
                <th>Delete</th>
            </tr>
            <?php

            $sqlJournal = "SELECT * FROM `questions` WHERE `username` = '$username'";
            $resultJournal = $conn->query($sqlJournal);
            if ($resultJournal->num_rows > 0) {
                $questionNo = 1;
                while ($rowname = $resultJournal->fetch_assoc()) {
                    $pos = $rowname["pos"];
                    $question = $rowname["question"];
                    echo "<tr>";
                    echo "<td style='float:left'>" . $question . "</td>";
                    echo "<td><form><input type='button' value='Delete' onclick='deleteQ($pos)' class='btn'/></form></td>";
                    echo "</tr>";
                    $questionNo++;
                }
            }
            }

            ?>
        </table>
    </div>


<script>
    function deleteQ(questionNo){
        var qNo = questionNo;
        jQuery.post("deleteQ.php", {"questionNo": qNo}, function(data){
            alert("Question was deleted successfully");
            window.location.href="questions.php";
        }).fail(function()
        {
            alert("Couldn't delete question. Please check internet connection then try again");
        });

    }
</script>
<div class="clear"></div>
</body>
<footer>
    <div class="footer">
        <div class="navbarBottom">
            <a onclick="goBack()" class="active">BACK</a>
            <a href="supportCircle.php" style="float:right">NEXT: SUPPORT CIRCLE</a>
        </div>
    </div>
</footer>
</html>