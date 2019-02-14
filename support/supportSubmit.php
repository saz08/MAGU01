<?php
/**
 * Created by IntelliJ IDEA.
 * User: User
 * Date: 14/02/2019
 * Time: 04:59 PM
 */

$symptom = $_POST['Symptom'];
$additional = $_POST['Additional'];
$username = $_SESSION["userName"];
$sql1 = "SELECT * FROM `supportAcc` WHERE username = '$username'";
$result=$conn->query($sql1);
if($result->num_rows>0) {
    while ($rowname = $result->fetch_assoc()) {
        $survivor = $rowname["survivor"];
    }
}

$sql  = "INSERT INTO `supportSubmit` (`username`,`survivor`, `symptom`, `additional`) VALUES ('$username','$survivor', '$symptom', '$additional')";
$conn->query($sql);


