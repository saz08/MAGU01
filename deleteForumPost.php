<?php
/**
 * Created by IntelliJ IDEA.
 * User: User
 * Date: 28/01/2019
 * Time: 11:01 AM
 */
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


//$username = $_POST['Username'];
$position = $_POST['Position'];

$sql  = "DELETE FROM `forum` WHERE `pos`='$position'";
$sql2 = "DELETE FROM `comments` WHERE `pos` = '$position'";

$conn->query($sql);
$conn->query($sql2);

