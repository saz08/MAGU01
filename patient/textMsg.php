<?php
session_start();

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

$pain = $_POST['Pain'];
$breathlessness = $_POST['Breathlessness'];
$performance = $_POST['Performance'];
$id = "";

$username = $_SESSION["userName"];

$sql1 = "SELECT `id` FROM `scale` WHERE username = '$username'";
$resultID=$conn->query($sql1);
if($resultID->num_rows>0) {
    while ($rowname = $resultID->fetch_assoc()) {
        $id = $rowname["id"];
    }
}

//Create red warnings
if($pain>=7){
    $redPainWarning = "Red Pain Rating greater than 6";
    $redPain = "true";
}
else{
    $redPain = "false";
}
if($breathlessness>=4){
    $redBreathWarning = "Red Breathlessness Score greater than 3";
    $redBreath= "true";
}
else{
    $redBreath = "false";
}
if($performance>=3){
    $redPerformanceWarning="Red Performance score greater than 2";
    $redPerformance = "true";
}
else{
    $redPerformance = "false";
}

//Create amber warnings
if($pain>=4&&$pain<7){
    $amberPainWarning = "Amber Pain Rating between 4 and 6";
    $amberPain = "true";
}
else{
    $amberPain = "false";
}
if($breathlessness>=2&&$breathlessness<4){
    $amberBreathWarning = "Amber Breathlessness Score between 2 and 3";
    $amberBreath = "true";
}
else{
    $amberBreath = "false";
}
if($performance==2){
    $amberPerformanceWarning="Amber Performance Score of 2";
    $amberPerformance="true";
}
else{
    $amberPerformance = "false";
}



//Get associated doctor's email from the CHI
$txtSQL  = "SELECT `docEmail` FROM `chi` WHERE `id`='$id'";
$resultTXT=$conn->query($txtSQL);
if($resultTXT->num_rows>0) {
    while ($rowname = $resultTXT->fetch_assoc()) {
        $to = $rowname["docEmail"];
    }
}

//Get full name of patient from the CHI
$chiName  = "SELECT `forename`,`surname` FROM `chi` WHERE `id`='$id'";
$resultName=$conn->query($chiName);
if($resultName->num_rows>0) {
    while ($rowname = $resultName->fetch_assoc()) {
        $patientForename = $rowname["forename"];
        $patientSurname = $rowname["surname"];
    }
}

//Send an email regarding amber warnings
if($amberPain==="true"||$amberBreath==="true"||$amberPerformance==="true"){
    $from = "Survivors";
    $message = $amberPainWarning."\n".$amberBreathWarning."\n".$amberPerformanceWarning." \nPlease contact within 2 hours ";
    $headers="From: $from\n";
    $subject="Amber Warning for Patient ". $patientForename." ".$patientSurname;
    mail($to,$subject,$message,$headers);
}

//Send an email regarding red warnings
if($redPain==="true"||$redBreath==="true"||$redPerformance==="true"){
    $from = "Survivors";
    $message = $redPainWarning."\n".$redBreathWarning."\n".$redPerformanceWarning."\nPlease contact immediately!";
    $headers="From: $from\n";
    $subject="Red Warning for Patient ". $patientForename." ".$patientSurname;
    mail($to,$subject,$message,$headers);
}

?>

