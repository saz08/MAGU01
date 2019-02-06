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

<script xmlns="http://www.w3.org/1999/html">if(localStorage.getItem("loginOK")===null){
        localStorage.setItem("loginOK", "no")
    }</script>
<script>
    function checkAlreadyLoggedIn(){
        if(localStorage.getItem("loginOK")==="yes"){
            alert("You are already logged in!");
            window.location.href = "index.php";
        }
    }
</script>
<?php
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

    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <link rel="stylesheet" type="text/css" href="radio.css">

    <meta charset="UTF-8">
    <title>Project</title>
    <script>

        if(localStorage.getItem("loginOK")===null){
            localStorage.setItem("loginOK", "no");
        }
        function checkLogIn(){
            return localStorage.getItem("loginOK")==="yes" && localStorage.getItem('username')!=='unknownUser';

        }

    </script>
    <script>
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
                <li><a href="scale.php">RECORD</a></li>
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
<div class="jumbotron text-center">
    <h1>Questions</h1>
</div>
<div class="box">
    <div class="container-fluid bg-2 text-center">

        <p>Note down any questions you have</p>
        <form method="post" name="questions">
            <input type="text" name="question"><br>
            <input type="hidden" name="action" value="filled">
            <br>
            <input type="submit" value="Save Question" class="btn"><br>
        </form>
    </div>
</div>
<?php

$question= (safePost($conn,"question"));

if($action==="filled"){
    $sql  = "INSERT INTO `questions` (`question`, `username`) VALUES ('$question', '$username')";
    $conn->query($sql);?>
    <script>window.location.href="results.php";</script>
    <?php
}
?>
<div class="box">
    <div class="container-fluid bg-3 text-center">
        <table class="table table-striped" id="questionTable">
            <tr>
                <th>Questions</th>
                <th>Delete</th>
            </tr>
            <?php

            $sqlJournal = "SELECT * FROM `questions` WHERE `username` = '$username'";
            $resultJournal = $conn->query($sqlJournal);
            if($resultJournal->num_rows>0) {
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


            ?>
        </table>
    </div>
</div>


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


    function goBack(){
        window.history.back();
    }
</script>
<div class="clear"></div>
</body>
<footer>
    <div class="footer">
        <div class="glyphicon glyphicon-arrow-left" style="float:left" id="arrows" onclick="goBack()"></div>

        <p style="text-align: center;">&copy; Sara Reid Final Year Project 2019</p>
    </div>
</footer>
</html>