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


$username = $_SESSION["userName"];
$position = $_POST['Position'];

$sql  = "DELETE FROM `forum` WHERE `pos`='$position'";
$sql2 = "DELETE FROM `comments` WHERE `pos` = '$position'";

$conn->query($sql);
$conn->query($sql2);

$sqlCheck = "SELECT * FROM `forum`";
$result = $conn->query($sqlCheck);
if($result->num_rows<1) {
    $sqlAlter = "ALTER TABLE `forum` AUTO_INCREMENT=1";
    $conn->query($sqlAlter);

}
