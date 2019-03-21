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

if($additional!=""){
    $seenInfo='false';
}
else{
    $seenInfo = '';
}

if($symptom!=""){
    $seenSymp='false';
}
else{
    $seenSymp = '';
}

$sql  = "INSERT INTO `scale` (`id`, `username`, `pain`, `breathlessness`, `performance`, `additionalInfo`,`symptom` ,`timeStamp`, `seenInfo`,`seenSymp`, `resInfo`, `resSymp`) VALUES ('$id', '$username', '$pain', '$breathlessness', '$performance', '$additional','$symptom', CURRENT_TIMESTAMP, '$seenInfo', '$seenSymp','','')";

$conn->query($sql);





?>