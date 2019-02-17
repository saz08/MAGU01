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


$id = $_GET['id'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content ="width=device-width, initial-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <meta name="mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">

    <meta charset="UTF-8">
    <title>Project</title>

</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#myPage">    </a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class = "nav navbar-nav navbar-left">
                <li><a href="dashboard.php">DASHBOARD</a></li>
                <li><a href="createID.php">ADD PATIENT</a></li>

            </ul>
        </div>
    </div>
</nav>
<div class="jumbotron text-center">
    <h1>Support Circle</h1>
</div>

<?php
$sqlPatient="SELECT * FROM `account` WHERE id='$id'";
$patient=$conn->query($sqlPatient);
if($patient->num_rows>0){
    while($rowname=$patient->fetch_assoc()){
        $usernamePatient= $rowname["username"];



        $sqlSupport="SELECT * FROM `supportAcc` WHERE `survivor`='$usernamePatient'";
        $support=$conn->query($sqlSupport);
        if($support->num_rows>0){
            while($rowname=$support->fetch_assoc()){
                echo "<div style='overflow-x: scroll'>";
                echo "<table class='table table-hover row-clickable' id='doctorTable' >";
                echo"<tr>";
                echo"<th>Support Circle</th>";
                echo "<th>Relation</th>";
                echo "</tr>";
                echo "<tr>";

                $supportUser= $rowname["username"];
                $relation = $rowname["relation"];
                echo "<td>" . $supportUser . "</td>";
                echo "<td>" . $relation . "</td>";

                echo "</tr>";


            }
        }
    }
}

?>
</table>
</div>

<h2>Patient's friends or family may add symptoms they are noticing or any other additional notes they'd like to log. They will appear here if there are any.</h2>
<div class="box" style="height: inherit">
    <?php
    $sql1  = "SELECT * FROM `supportSubmit` WHERE `survivor`= '$usernamePatient'";
    $result1=$conn->query($sql1);
    if($result1->num_rows>0){
        while($rowname=$result1->fetch_assoc()){
            $symptom = $rowname["symptom"];
            $info = $rowname["additional"];
            if($info!=""){
                echo"<p>".$info."</p>";
            }
            if($symptom!=""){
                echo"<p>Symptom:".$symptom."</p>";
            }
        }
    }
    ?>
</div>
<script>
    function goBack(){
        window.history.back();
    }
</script>

</body>
<div class="clear"></div>

<footer>
    <div class="footer">
        <div class="glyphicon glyphicon-arrow-left" style="float:left" id="arrows" onclick="goBack()"></div>

        <p style="text-align: center;">&copy; Sara Reid Final Year Project 2019</p>
    </div></footer>
</html>