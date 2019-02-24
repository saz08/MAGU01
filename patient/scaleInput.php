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

if($loginOK) {
    if (!isset($_SESSION["sessionuser"])) {
        session_regenerate_id();
        $_SESSION["sessionuser"] = $user;
    }
}

$amberWarning="";
$amberPainWarning="";
$amberBreathWarning="";
$amberPerformanceWarning="";
$redWarning="";
$redPainWarning="";
$redBreathWarning="";
$redPerformanceWarning="";
$pain = $_POST['Pain'];
$breathlessness = $_POST['Breathlessness'];
$performance = $_POST['Performance'];
$additional = $_POST['Additional'];
$symptom = $_POST['Symptom'];
$id = "";
$username = $_SESSION["userName"];
$sql1 = "SELECT `id` FROM `account` WHERE username = '$username'";
$resultID=$conn->query($sql1);
if($resultID->num_rows>0) {
    while ($rowname = $resultID->fetch_assoc()) {
        $id = $rowname["id"];

    }
}
$sql  = "INSERT INTO `scale` (`id`, `username`, `pain`, `breathlessness`, `performance`, `additionalInfo`,`symptom` ,`timeStamp`, `seen`, `response`) VALUES ('$id', '$username', '$pain', '$breathlessness', '$performance', '$additional','$symptom', CURRENT_TIMESTAMP, 'false', '')";
$conn->query($sql);





?>