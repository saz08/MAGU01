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
    </script><?php
}

$username = $_SESSION["userName"];
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
    <script src="../js/forAll.js"></script>
    <script src="../js/supportJS.js"></script>
    <meta charset="UTF-8">
    <title>Supporter</title>
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
                <li><a href="supportHome.php">HOME</a></li>
                <li><a href="supportInput.php">RECORD</a></li>
                <?php
                $sqlInfo = "SELECT * FROM `supportSubmit` WHERE `username` = '$username'";
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
                    echo "<li><a href='supportDocFeedback.php'>FEEDBACK <span class=\"glyphicon glyphicon-exclamation-sign\"></span></a></li>";
                }
                else{
                    echo"<li><a href='supportDocFeedback.php'>FEEDBACK</a></li>";
                }
                ?>
                <li><a href="supportHelp.php">HELP</a></li>

            </ul>
            <ul class = "nav navbar-nav navbar-right">
                <li><a href="../patient/logout.php">LOGOUT</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="jumbotron text-center">
    <h1>Record any information about your survivor <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>

<br>
<br>
<br>


<div class="box">Please choose one symptom to enter, you can come back and enter more if you wish. If you don't have anything you'd like to add, please leave blank</div>
<form name="symptom" method="post" >
    Symptoms:
    <select id="select" name="select">
        <option></option>
        <option value="Anxiety">Anxiety</option>
        <option value="Loss Of Appetite">Loss of Appetite</option>
        <option value="Bleeding">Bleeding</option>
        <option value="Constipation">Constipation</option>
        <option value="Depressed">Depressed</option>
        <option value="Diarrhea">Diarrhea</option>
        <option value="Fatigue">Fatigue</option>
        <option value="Insomnia">Insomnia</option>
        <option value="Sickness">Sickness</option>
    </select>
    <input type="hidden" name="action" value="filled">
    <p><input type="submit" name="submit" id="submit" class="btn" value="Submit"></p>
</form>
<br>
<div class="box">Or... you can enter any additional information you want to record about your survivor. If you don't have anything you'd like to add, please leave blank</div>

<form name="additional" method="post">
    <input type="text" name="additional"  id="additional"/>
    <input type="hidden" name="action2" value="filled">
    <p><input type="submit" name="submit" id="submit" class="btn" value="Submit"></p>
</form>
<br>

<?php
$username = $_SESSION["userName"];
$sql1 = "SELECT * FROM `supportAcc` WHERE username = '$username'";
$result=$conn->query($sql1);
if($result->num_rows>0) {
    while ($rowname = $result->fetch_assoc()) {
        $survivor = $rowname["survivor"];
    }
}

if($action2==="filled"){
    $info = (safePost($conn,"additional"));
    $sql2 = "INSERT INTO `supportSubmit`(`username`,`survivor`, `symptom`, `additional`,`seen`,`response`) VALUES ('$username','$survivor', '', '$info','false','')";
    $conn->query($sql2);
    ?>
    <script>
        alert("Submitted successfully");
        window.location.href="supportInput.php";
    </script>
    <?php
}



if($action==="filled"){
    $symptoms= (safePost($conn,"select"));
    $sql  = "INSERT INTO `supportSubmit` (`username`,`survivor`, `symptom`, `additional`,`seen`,`response`) VALUES ('$username','$survivor', '$symptoms', '','false','')";
    $conn->query($sql);
    ?><script>
        alert("Submitted successfully");
        window.location.href="supportInput.php";
    </script>
<?php
}

?>
<div class="clear"></div>

</body>
<footer>
    <div class="footer">
        <div class="navbarBottom">
            <a onclick="goBack()" >BACK</a>
            <a href="supportDocFeedback.php" style="float:right">NEXT: FEEDBACK</a>
        </div>
    </div>
</footer>
</html>