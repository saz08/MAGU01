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
    <script src="../js/script.js"></script>

    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/radio.css">

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
<div class="jumbotron text-center">
    <h1>Additional Info</h1>
</div>

<div class="box">Please enter any additional information you want to record. If you don't have anything you'd like to add, please leave blank and press the bottom right arrow.</div>
    <form name="additional" method="post" >
        <input type="text" name="additional"  id="additional"/>
        <input type="hidden" name="action" value="filled">

        </p>
    </form>


<?php
if($action==="filled"){
    $info = (safePost($conn,"additional"));
}
else{
    $info="not filled";
}



?>


<script>

    function submit(){
        var info = document.getElementById('additional').value;
    //  localStorage.setItem("Additional", "<?php echo $info?>");
        localStorage.setItem("Additional", info);


        // window.location.href="additionalInfo.php";
        submitRecord();

    }
    function submitRecord(){
        var pain = localStorage.getItem("Pain");
        var breathlessness= localStorage.getItem("Breathlessness");
        var performance = localStorage.getItem("Performance");
        var additionalInfo = localStorage.getItem("Additional");
        jQuery.post("scaleInput.php", {"Pain": pain, "Breathlessness": breathlessness, "Performance": performance,"Additional": additionalInfo}, function(data){
            alert("Records successfully saved");
        }).fail(function()
        {
            alert("something broke in submitting your records");
        });
        var painTxt = localStorage.getItem("Pain");
        var breathlessnessTxt= localStorage.getItem("Breathlessness");
        var performanceTxt = localStorage.getItem("Performance");
        jQuery.post("textMsg.php", {"Pain": painTxt, "Breathlessness": breathlessnessTxt, "Performance": performanceTxt}, function(data){
            alert("Doctor notified of how you feel");
            window.location.href="index.php";
        }).fail(function()
        {
            alert("something broke in emailing your doctor");
        });

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
        <div class="glyphicon glyphicon-arrow-right" style="float:right" id="arrows" onclick="submit()"></div>

        <p style="text-align: center;">&copy; Sara Reid Final Year Project 2019</p>
    </div></footer>
</html>