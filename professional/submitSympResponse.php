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

$symptom = $_POST['Symptom'];
$resSymp = $_POST['resSymp'];
$username = $_SESSION["userName"];

$sql2 = "SELECT `symptom` FROM `supportSubmit` WHERE `seenSymp`!='true'";
$result=$conn->query($sql2);
if($result->num_rows>0) {
    while ($rowname = $result->fetch_assoc()) {
        if($resSymp!="") {
            $sql = "UPDATE `supportSubmit` SET `seenSymp`='true',`resSymp`='$resSymp' WHERE `symptom`='$symptom' AND `seenSymp`='false'";
            $conn->query($sql);
        }
    }
}

?>