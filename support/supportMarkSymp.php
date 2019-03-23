<?php
/**
 * Created by IntelliJ IDEA.
 * User: User
 * Date: 14/03/2019
 * Time: 11:41 AM
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


$sqlSymp = "SELECT  `resSymp` FROM `supportSubmit` WHERE `resSymp` = '$response'";
$resultSymp = $conn->query($sqlSymp);
if($resultSymp->num_rows>0) {
    $sql2  = "UPDATE `supportSubmit` SET `seenSymp`='' WHERE `resSymp` = '$response'";
    $conn->query($sql2);
}
