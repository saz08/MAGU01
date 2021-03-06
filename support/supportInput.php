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

//Connect to Database
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
    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/alerts.css">
    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">
    <script src="../js/forAll.js"></script>
    <script src="../js/supportJS.js"></script>
    <meta charset="UTF-8">
    <title>Record Info</title>
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

<?php
//Detect if session is still running. If not, direct user to login
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
                //Show notification icon if the supporter has feedback from a health professional
                $sqlInfo = "SELECT * FROM `supportSubmit` WHERE `username` = '$username'";
                $supportInfo = $conn->query($sqlInfo);
                if ($supportInfo->num_rows > 0) {
                    $importantInfo=0;
                    $importantSymp=0;
                    while ($rowname = $supportInfo->fetch_assoc()) {
                        $seenInfo = $rowname["seenInfo"];
                        $resInfo = $rowname["resInfo"];
                        $seenSymp = $rowname["seenSymp"];
                        $resSymp = $rowname["resSymp"];


                        if ($seenInfo === "true" && $resInfo != "") {
                            $importantInfo++;
                        }

                        if ($seenSymp === "true" && $resSymp != "") {
                            $importantSymp++;
                        }

                    }
                }
                else{
                    $importantInfo=0;
                    $importantSymp=0;
                }

                if($importantInfo>0||$importantSymp>0){
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
                <li><a> <button class="btn" id="checkLogOut" onclick="logOutCheck()"  style="background-color: #E9969F;color:black;top:0 " >LOGOUT</button></a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="jumbotron text-center">
    <h1>Record any information about your survivor <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>

<!--Modal: Logout Check-->
<div id="logOutCheck" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to log out?</p>
        <button id="spanSubmitCheck" class="btn" onclick="window.location.href='../patient/logout.php' ;document.getElementById('logOutCheck').style.display='none';">Yes</button>
        <button id="spanSubmitCheck" class="btn" onclick="document.getElementById('logOutCheck').style.display='none';">No</button>
    </div>
</div>
<br>
<br>
<br>

<div class="box">Here is a small list of common symptoms. If you feel your survivor applies to one, please choose one </div>
<!--Dropdown list of common symptoms-->
<form name="symptom" method="post" class="box-transparent" >
    Symptoms:
    <select id="select" name="select">
        <option></option>
        <option value="Anxiety">Anxiety</option>
        <option value="Loss Of Appetite">Loss of Appetite</option>
        <option value="Bleeding">Bleeding</option>
        <option value="Constipation">Constipation</option>
        <option value="Depressed">Depressed</option>
        <option value="Diarrhoea">Diarrhoea</option>
        <option value="Fatigue">Fatigue</option>
        <option value="Insomnia">Insomnia</option>
        <option value="Sickness">Sickness</option>
    </select>
    <input type="hidden" name="action" value="filled">
</form>
<div class="box">You can enter any additional information you want to record about your survivor. If you don't have anything you'd like to add, please leave blank</div>
<!--Input for additional information-->
<form name="additional" method="post" class="box-transparent" >
    <input type="text" name="additional"  id="additional" placeholder="Additional Information..."/>
    <input type="hidden" name="action2" value="filled">
</form>


<!--Modal: Records saved-->
<div id="save" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanSave" onclick="document.getElementById('save').style.display='none';window.location.href='supportInput.php'" style="float:right">&times;</button>
        <p>Your records were successfully saved.</p>
    </div>
</div>

<!--Modal: Records not saved-->
<div id="notSave" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanNotSave" onclick="document.getElementById('notSave').style.display='none';" style="float:right">&times;</button>
        <p>Sorry, Survivors was unable to save your records. Please check your internet connection and try again</p>
    </div>
</div>

<!--Modal: Empty-->
<div id="empty" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanNotSave" onclick="document.getElementById('empty').style.display='none';" style="float:right">&times;</button>
        <p>You have not entered any symptom or information to submit</p>
    </div>
</div>

<!--Modal: Submit check-->
<div id="submitCheck" class="modal">
    <div class="modal-content">
        <p>Survivors will now save your records and send to the assigned health professional. Are you sure you want to submit?</p>
        <button id="spanSubmitCheck" class="btn" onclick="submitSupport();document.getElementById('submitCheck').style.display='none';">Yes</button>
        <button id="spanSubmitCheck" class="btn" onclick="document.getElementById('submitCheck').style.display='none';">No</button>

    </div>
</div>
<div class="clear"></div>
<script>
    //Get modals
    var save = document.getElementById("save");
    var notSave = document.getElementById("notSave");
    var check = document.getElementById("submitCheck");
    var empty = document.getElementById("empty");


    //Check user is ready to submit their values
    function checkSubmit(){
        var additionalInfo = document.getElementById('additional').value;
        var symptom = document.getElementById('select').value;
        if(additionalInfo!==""||symptom!=="") {
            check.style.display = "block";
        }
        else{
            empty.style.display="block";
        }
    }

    //Submit values
    function submitSupport(){
        var additionalInfo = document.getElementById('additional').value.replace(/'/g,'');
        console.log("additional "+ additionalInfo);
        var symptom = document.getElementById('select').value;
        console.log("symptom "+ symptom);
        // var additionalInfo = localStorage.getItem("Additional");
        jQuery.post("infoSubmit.php", {"Additional": additionalInfo,"Symptom": symptom}, function(data){
            save.style.display="block";
        }).fail(function()
        {
            notSave.style.display="block";
        });
    }
</script>
</body>

<footer>
    <div class="footer">
        <button class="btn" onclick="goBack()" style="float:left"><b><</b> Back </button>
        <button class="btn" style="float:right" onclick="checkSubmit()"> Submit <b> > </b></button>
    </div>

</footer>
</html>