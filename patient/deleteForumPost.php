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

//Get username from the session
$username = $_SESSION["userName"];

//Receive position from post value
$position = $_POST['Position'];

//Delete the forum post, and delete all associated comments
$sql  = "DELETE FROM `forum` WHERE `pos`='$position'";
$sql2 = "DELETE FROM `comments` WHERE `pos` = '$position'";

$conn->query($sql);
$conn->query($sql2);

//If that was the last post in the forum, begin the counter at 1
$sqlCheck = "SELECT * FROM `forum`";
$result = $conn->query($sqlCheck);
if($result->num_rows<1) {
    $sqlAlter = "ALTER TABLE `forum` AUTO_INCREMENT=1";
    $conn->query($sqlAlter);

}
