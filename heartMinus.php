<?php
/**
 * Created by IntelliJ IDEA.
 * User: User
 * Date: 22/01/2019
 * Time: 01:10 PM
 */

session_start();

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

$heartDiv = $_POST['HeartDiv'];
$sql = "SELECT `heart` FROM `forum` WHERE `pos` = '$heartDiv'";
$result = $conn->query($sql);
if($result->num_rows>0){
    while($rowname=$result->fetch_assoc()){
        $heartCounter = $rowname["heart"];
    }
}

$heartCounter= $heartCounter-1;


$sqlUPDATE = "UPDATE `forum` SET `heart`='$heartCounter' WHERE `pos`= '$heartDiv'";
$conn->query($sqlUPDATE);

?>
