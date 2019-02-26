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
    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">
    <script src="../js/script.js"></script>
    <script src="../js/forAll.js"></script>

    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">

    <meta charset="UTF-8">
    <title>Support Circle</title>
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
                </li>
                <li><a href="talk.php">TALK</a></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">HELP <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="helpInfo.php">INFO</a></li>
                        <li><a href="helpFinancial.php">FINANCIAL</a></li>
                        <li><a href="helpEmotional.php">EMOTIONAL</a></li>
                        <li><a href="helpPhysical.php">PHYSICAL</a></li>
                    </ul>
                </li>
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">PROFILE <span class="caret"></span></a>
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
    <h1>Add to your Support Circle <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>
<br>
<div class="container-fluid bg-1 text-center">

<h4>Please enter the email address of the person you would like to be in your support circle.</h4>
    <h4>We will send them a link for them to sign up and join you.</h4>
    <p>Any supporters will appear below!</p>
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
    $message = $username." would like you to join their support circle on Survivors! Please follow the link to sign up and join them.\n https://devweb2017.cis.strath.ac.uk/~szb15123/Project/support/supportSignUp.php \n Please remember the username $username to sign up with! \nYou will be able to view their recovery and input any symptoms or concerns on their behalf.";
    $headers="From: $from\n";
    $subject="Join ".$username."'s Support Circle";
    mail($email,$subject,$message,$headers);
    ?>
    <script>alert("Email invitation has been sent!");</script>
<?php
}


?>
<br>


<?php
$sqlSupport="SELECT * FROM `supportAcc` WHERE `survivor`='$username'";
$support=$conn->query($sqlSupport);
if($support->num_rows>0){
    echo "<div class='container-fluid bg-1 text-center'><h2>Your Supporters</h2></div>";
    echo "<table class='table table-hover row-clickable' id='doctorTable' >";
    echo" <tr>";
    echo"<th>Support Circle</th>";
    echo "<th>Relation</th>";
    echo "</tr>";
    echo "<tr>";
    while($rowname=$support->fetch_assoc()){


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
        <div class="navbarBottom">
            <a onclick="goBack()" >BACK</a>
        </div>    </div></footer>
</html>