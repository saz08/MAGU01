<?php
/**
 * Created by IntelliJ IDEA.
 * User: User
 * Date: 18/02/2019
 * Time: 10:41 AM
 */
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

//Get value from post
$response = $_POST['Response'];

$sqlInfo  = "SELECT  `resInfo` FROM `supportSubmit` WHERE `resInfo` = '$response'";
$resultInfo = $conn->query($sqlInfo);
if($resultInfo->num_rows>0) {
    $sql1  = "UPDATE `supportSubmit` SET `seenInfo`='' WHERE `resInfo` = '$response'";
    $conn->query($sql1);
}

