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
    <script src="../js/script.js"></script>

    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">

    <meta charset="UTF-8">
    <title>Project</title>
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
    <h1>Add to your Support Circle <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>
<br>
<div class="container-fluid bg-1 text-center">

<p>Please enter the email address of the person you would like to be in your support circle.</p>
    <p>We will send them a link for them to sign up and join you.</p>
    <form method="post">
    <input type="email" name="email"/>
<input type="hidden" name="action" value="filled">
<input type="submit" name="submit" class="btn" value="Add Supporter">
    </form>

</div>

<?php
if($action === "filled") {
    $email = (safePost($conn, "email"));

    $from = "Remote Monitoring";
    $message = $username." would like you to join their support circle on Survivors! Please follow the link to sign up and join them.\n You will be able to view their recovery and input any symptoms or concerns on their behalf.";
    $headers="From: $from\n";
    $subject="Join ".$username."'s Support Circle'";
    mail($email,$subject,$message,$headers);
}


?>
<br>

<?php
$sqlSupport="SELECT * FROM `supportAcc` WHERE `survivor`='$username'";
$support=$conn->query($sqlSupport);
if($support->num_rows>0){
    while($rowname=$support->fetch_assoc()){
        echo "<table class='table table-hover row-clickable' id='doctorTable' >";
        echo" <tr>";
        echo"<th>Support Circle</th>";
        echo "<th>Relation</th>";
        echo "</tr>";
        echo "<tr>";

        $supportUser= $rowname["username"];
        $relation = $rowname["relation"];
        echo "<td>" . $supportUser . "</td>";
        echo "<td>" . $relation . "</td>";

        echo "</tr>";


    }
}
?>
</table>

</body>
<div class="clear"></div>

<footer>
    <div class="footer">
        <div class="glyphicon glyphicon-arrow-left" style="float:left" id="arrows" onclick="goBack()"></div>
        <p style="text-align: center;">&copy; Sara Reid Final Year Project 2019</p>
    </div></footer>
</html>