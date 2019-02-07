<?php
session_start();
?>
<?php


//connect to the database now that we know we have enough to submit
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
$loginOK = false; //TODO make this work with database values
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
                <li><a href="../dashboard.php">DASHBOARD</a></li>
                <li><a href="createID.php">ADD PATIENT</a></li>

            </ul>
        </div>
    </div>
</nav>
<div class="jumbotron text-center">
    <h1>Generate ID</h1>
</div>

<div class="col-md-6" id="newPatient">
    <form name="register" method="post" onsubmit="return checkForm()" >
        <h2 style="color:black">Create New Patient Details</h2>
        <p class="lead" style="color:#f7f7f7;">
        <p>Enter Full Name:<br> <input type="text" name="forename"  id="forename"/><input type="text" name="surname"  id="surname"/></p>
        <p>Date of Birth: <br><input type="date" name="DoB" id="DoB"></p>
        <p>Gender</p>
        <input type="radio" name="gender" value="male" id="male"> Male
        <input type="radio" name="gender" value="female" id="female">Female
        <p>Patient's Email Address:<br><input type="email" name="patientEmail"  id="patientEmail"/></p>
        <p>Address:<br><input type="text" name="address"  id="address"/></p>
        <p>Contact No:<br><input type="text" name="contact"  id="contact"/></p>
        <p>Doctor's Email Address:<br><input type="email" name="docEmail"  id="docEmail"/></p>
        <input type="hidden" name="action2" value="filled">
        <p><input type="submit" name="submitReg" id="signUpButton" class="btn" value="Register Patient"></p>
        </p>
    </form>

</div>
<script>
    function checkForm(){
        var forename = document.getElementById("forename");
        var surname = document.getElementById("surname");
        var dob = document.getElementById("DoB");
        var male = document.getElementById("male");
        var female = document.getElementById("female");
        var address = document.getElementById("address");
        var contact = document.getElementById("contact");
        var docEmail = document.getElementById("docEmail");



        var errs = "";

        forename.style.background = "white";
        surname.style.background = "white";
        dob.style.background = "white";
        male.style.background="white";
        female.style.background = "white";
        address.style.background = "white";
        contact.style.background = "white";
        docEmail.style.background = "white";




        if(forename.value === null || forename.value === ""){
            errs += " Please enter your email address\n";
            forename.style.background = "pink";
        }

        if(surname.value === null || surname.value === ""){
            errs += " Please enter your email address\n";
            surname.style.background = "pink";
        }

        if(address.value===null||address.value===""){
            errs+= "Please enter a valid survivor's username\n";
            address.style.background="pink";
        }

        if(contact.value===null||contact.value===""){
            errs+= "Please enter how you know the patient. EG: Partner, friend, parent...\n";
            contact.style.background="pink";
        }
        if(docEmail.value===null||docEmail.value===""){
            errs+= "Please enter how you know the patient. EG: Partner, friend, parent...\n";
            docEmail.style.background="pink";
        }


        if(errs !== ""){
            alert("The following need to be corrected: \n" + errs);
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
    $docEmail = (safePost($conn,"docEmail"));

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



    $from = "Remote Monitoring";
    $message = "Hi ".$forename."! Welcome to Survivors!\n Please follow the link to register\n https://devweb2017.cis.strath.ac.uk/~szb15123/Project/signUp.php \n. You will need to enter this ID to sign up: ".$id."\n Thanks!";
    $headers="From: $from\n";
    $subject="Welcome to Survivors ".$forename."!";
    mail($patientEmail,$subject,$message,$headers);


$insert = $sql  = "INSERT INTO `chi` (`forename`, `surname`, `id`, `birthday`, `gender`,`patientEmail`, `address`, `contactNo`, `docEmail`) VALUES ('$forename', '$surname', '$id', '$dob', '$genderFinal','', '$address', '$contactNo', '$docEmail')";

    if ($conn->query($insert) === TRUE) {
echo "<p class='center'>Registration was successful!</p>";


?>
    <script>window.location.href = "createID.php";
    </script>
    <?php
}


}
?>

</body>
<div class="clear"></div>

<footer>
    <div class="footer">
        <p style="text-align: center;">&copy; Sara Reid Final Year Project 2019</p>
    </div></footer>
</html>