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

if($_SESSION['userName']==null){
    $_SESSION['userName'] = "unknownUser";
    ?> <script>
        localStorage.setItem('username', "unknownUser");
        localStorage.setItem('loginOK', "no");
    </script><?php
}

$username = $_SESSION["userName"];
$loginOK = false; //TODO make this work with database values

$id = $_POST['id'];

$sql = "DELETE FROM `account` WHERE `id` = '$id'";
$conn->query($sql);

$sql = "DELETE FROM `chi` WHERE `id` = '$id'";
$conn->query($sql);

$sql = "DELETE FROM `comments` WHERE `id` = '$id'";
$conn->query($sql);

$sql = "DELETE FROM `forum` WHERE `id` = '$id'";
$conn->query($sql);

$sql = "DELETE FROM `physical` WHERE `id` = '$id'";
$conn->query($sql);

$sql = "DELETE FROM `questions` WHERE `id` = '$id'";
$conn->query($sql);

$sql = "DELETE FROM `scale` WHERE `id` = '$id'";
$conn->query($sql);


$sql = "DELETE FROM `supportAcc` WHERE `id` = '$id'";
$conn->query($sql);

$sql = "DELETE FROM `supportSubmit` WHERE `id` = '$id'";
$conn->query($sql);

$sql = "DELETE FROM `weight` WHERE `id` = '$id'";
$conn->query($sql);

