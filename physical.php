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
<script>
    if(localStorage.getItem("loginOK")===null){
        localStorage.setItem("loginOK", "no")
    }

    function checkAlreadyLoggedIn(){
        if(localStorage.getItem("loginOK")==="yes"){
            alert("You are already logged in!");
            window.location.href = "index.php";
        }
    }
</script>


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

    <link rel="stylesheet" type="text/css" href="stylesheet.css">

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
    <h1>Monitor your physical activity</h1>
</div>

<div class="box">The following questions have been adapted from the YOUTHREX International Physical Acitivity Questionnaire.</div>


<form method="post" class="WHOstyle">
    <label class="container">1: During the last 7 days, on how many days did you do vigorous physical activities, like heavy lifting, digging, aerobics or fast bicycling?
        <select name="vigorous">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
        </select>
    </label>

    <label class="container">2: During the last 7 days, on how many days did you do moderate physical activities like carrying light loads, bicyling at a regular pace, or doubles tennis? Do not include walking.
        <select name="moderate">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
        </select>
    </label>

    <label class="container">3: During the last 7 days, on how many days did you walk for at least 10 minutes at a time?
        <select name="walk">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
        </select>
    </label>

    <label class="container">4: During the last 7 days, how much time did you spend sitting on a week day?
        <select name="sitting">
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
    <input type="submit" name="submit" value="Submit"/>
</form>


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
            window.location.href = "index.php";
        </script>
        <?php
    }
}

?>

<script>

    var slider = document.getElementById("myRange");
    var value;


    function goBack(){
        window.history.back();
    }

    function submit(){
        console.log(this.value + "value");
        localStorage.setItem("Pain",slider.value);
        window.location.href="Breathlessness.php";
    }

    function outputUpdate(num) {
        document.querySelector('#output').value = num;
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