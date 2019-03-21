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



$additional = $_POST['Additional'];
$symptom = $_POST['Symptom'];
$resInfo = $_POST['resInfo'];
$resSymp = $_POST['resSymp'];
$username = $_SESSION["userName"];


if($additional!=""){
    $seenInfo='false';
}
else{
    $seenInfo = '';
    $additional='';
}

if($symptom!=""){
    $seenSymp='false';
}
else{
    $seenSymp = '';
    $symptom='';
}

$sqlUser = "SELECT `survivor` FROM `supportAcc` WHERE `username` = '$username'";
$resultUser=$conn->query($sqlUser);
if($resultUser->num_rows>0) {
    while ($rowname = $resultUser->fetch_assoc()) {
        $survivor = $rowname["survivor"];

    }
}

    $sql = "INSERT INTO `supportSubmit` (`username`,`survivor`, `symptom`, `additional`, `seenInfo`, `seenSymp`, `resInfo`, `resSymp`,`timeStamp`) VALUES ('$username','$survivor', '$symptom', '$additional','$seenInfo','$seenSymp','','', CURRENT_TIMESTAMP )";
    $conn->query($sql);
?>