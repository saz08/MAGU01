<?php
session_start();
?>
<?php


//Connect to Database
$host = "devweb2018.cis.strath.ac.uk";
$user = "szb15123";
$pass = "fadooCha4buh";
$dbname = "szb15123";
$conn = new mysqli($host, $user, $pass , $dbname);
$action = safePOST($conn, "action");
$action2 = safePOST($conn, "action2");


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
    <script src="../js/forAll.js"></script>
    <script src="../js/docJS.js"></script>

    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">

    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/radio.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/alerts.css">

    <meta charset="UTF-8">
    <title>Create Patient ID</title>
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
                <li><a href="dashboard.php">DASHBOARD</a></li>
                <li><a href="createID.php">ADD PATIENT</a></li>
                <li><a href="../patient/talk.php">FORUM</a></li>

            </ul>
            <ul class = "nav navbar-nav navbar-right">
                <li><a> <button class="btn" id="checkLogOut" onclick="logOutCheck()"  style="background-color: #E9969F;color:black;top:0 " >LOGOUT</button></a></li>
            </ul>
        </div>
    </div>
</nav>

<?php
if($_SESSION["userName"]!=null) {
    $username = $_SESSION["userName"];
}
else{
    ?><script>
        localStorage.setItem("username","unknownUser");
        localStorage.setItem("loginOKDoc","no");
        alert("Session has expired, please log in again");

        window.location.href="docSignUp.php";
    </script><?php
}
?>
<div class="jumbotron text-center">
    <h1>Generate ID<img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>
<div id="logOutCheck" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to log out?</p>
        <button id="spanSubmitCheck" class="btn" onclick="window.location.href='../patient/logout.php' ;document.getElementById('logOutCheck').style.display='none';">Yes</button>
        <button id="spanSubmitCheck" class="btn" onclick="document.getElementById('logOutCheck').style.display='none';">No</button>
    </div>
</div>
<div class="radiostyle" id="newPatient" style="background-color: #E47C88">
    <form name="register" method="post" onsubmit="return checkForm()" >
        <h2 style="color:black">Create New Patient Details</h2>
        <p class="lead" style="color:#f7f7f7;">
        <p>Enter Full Name:<br> <input type="text" name="forename"  id="forename" placeholder="Forename"/>
            <input type="text" name="surname"  id="surname" placeholder="Surname"/></p>
        <p>Date of Birth: <br><input type="date" name="DoB" id="DoB"></p>
        <p>Gender</p>
        <label class="radioContainer" style="left:40%">Male
            <input type="radio" name="gender" value="male" id="male">
            <span class="checkmark" ></span>
        </label>
        <label class="radioContainer" style="left:40%">Female
            <input type="radio" name="gender" value="female" id="female">
            <span class="checkmark" ></span>
        </label>
        <p>Patient's Email Address:<br><input type="email" name="patientEmail"  id="patientEmail" placeholder="eg. johnsmith@gmail.com"/></p>
        <p>Address:<br><input type="text" name="address"  id="address"/></p>
        <p>Contact No:<br><input type="text" name="contact"  id="contact" /></p>
        <input type="hidden" name="action2" value="filled">
        <p><input type="submit" name="submitReg" id="signUpButton" class="btn" id="button" value="Register Patient"></p>
        </p>
        <br>
        <br>
    </form>

</div>
<div id="save" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanSave" onclick="document.getElementById('save').style.display='none';window.location.href='dashboard.php'" style="float:right">&times;</button>
        <p>Patient added!</p>
    </div>
</div>
<div id="notSave" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanNotSave" onclick="document.getElementById('notSave').style.display='none';" style="float:right">&times;</button>
        <p>Survivors was unable to add a new patient. Please check your internet connection and try again. </p>
    </div>
</div>
<div id="errs" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanErrs" onclick="document.getElementById('errs').style.display='none';" style="float:right">&times;</button>
        <p>Please correct any boxes highlighted pink</p>
    </div>
</div>
<script>
    function checkForm(){
        var forename = document.getElementById("forename");
        var surname = document.getElementById("surname");
        var dob = document.getElementById("DoB");
        var male = document.getElementById("male");
        var female = document.getElementById("female");
        var email = document.getElementById("patientEmail");
        var address = document.getElementById("address");
        var contact = document.getElementById("contact");
        var errorModal = document.getElementById("errs");

        var errs = "";

        forename.style.background = "white";
        surname.style.background = "white";
        dob.style.background = "white";
        male.style.background="white";
        female.style.background = "white";
        address.style.background = "white";
        contact.style.background = "white";
        email.style.background="white";

        if(forename.value === null || forename.value === ""){
            errs += " Please enter the patient's forename\n";
            forename.style.background = "pink";
        }

        if(surname.value === null || surname.value === ""){
            errs += " Please enter the patient's surname\n";
            surname.style.background = "pink";
        }
        if(dob.value === null || dob.value === ""){
            errs += " Please enter the patient's date of birth\n";
            dob.style.background = "pink";
        }
        if(male.value === null || male.value === "" && female.value === null || female.value === "" ){
            errs += " Please enter the patient's gender\n";
            male.style.background = "pink";
            female.style.background = "pink";
        }
        if(email.value===null||email.value===""){
            errs+= "Please enter the patient's email address\n";
            email.style.background="pink";
        }

        if(address.value===null||address.value===""){
            errs+= "Please enter the patient's address\n";
            address.style.background="pink";
        }

        if(contact.value===null||contact.value===""){
            errs+= "Please enter a contact number for the patient\n";
            contact.style.background="pink";
        }



        if(errs !== ""){
            errorModal.style.display="block";
        }
        return (errs === "");
    }
</script>
<?php
if($action2 === "filled") {
    $forename = (safePost($conn,"forename"));
    $surname = (safePost($conn,"surname"));
    $dob = (safePost($conn,"DoB"));
    $gender = (safePost($conn,"gender"));
    $patientEmail = (safePost($conn,"patientEmail"));
    $address = (safePost($conn,"address"));
    $contactNo = (safePost($conn,"contact"));

    $genderFinal = "";
    if($gender=="male"){
        $genderFinal="Male";
    }
    else{
        $genderFinal="Female";
    }

    $id = rand();

    $findID = "SELECT `id` FROM `chi` WHERE `id` = '$id'";
    $findIDResult = $conn->query($findID);
    if($findIDResult->num_rows>=1){
        $id=rand();
    }

    $username = $_SESSION["userName"];

    $docSql = "SELECT `email` FROM `docAcc` WHERE `username` = '$username'";
    $resultDoc = $conn->query($docSql);
    if($resultDoc->num_rows>0){
        while ($rowname = $resultDoc->fetch_assoc()) {
            $docEmail = $rowname["email"];
        }
    }

    $from = "Survivors";
    $message = "Hi ".$forename."! Welcome to Survivors!\n Please follow the link to register\n https://devweb2018.cis.strath.ac.uk/~szb15123/Survivors/patient/signUp.php \n You will need to enter this ID to sign up: ".$id."\n Thanks!";
    $headers="From: $from\n";
    $subject="Welcome to Survivors ".$forename."!";
    mail($patientEmail,$subject,$message,$headers);

$insert = $sql  = "INSERT INTO `chi` (`forename`, `surname`, `id`, `birthday`, `gender`,`patientEmail`, `address`, `contactNo`, `docEmail`) VALUES ('$forename', '$surname', '$id', '$dob', '$genderFinal','$patientEmail', '$address', '$contactNo', '$docEmail')";

    if ($conn->query($insert) === TRUE) {
        echo "<p class='center'>Registration was successful!</p>";
?>
    <script>
        var save=document.getElementById("save") ;
        save.style.display="block";
    </script>
    <?php
    }
    else{
        ?>
        <script>
            var notSave=document.getElementById("notSave") ;
            notSave.style.display="block";
        </script>
<?php
    }
}
?>
<div class="clear"></div>
</body>
<footer>
    <div class="footer">
        <button class="btn" onclick="goBack()" style="float:left"><b><</b> Back </button>
    </div>
</footer>
</html>