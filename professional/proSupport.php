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
$action2 = safePOST($conn, "action2");


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
    <script src="../js/forAll.js"></script>
    <script src="../js/docJS.js"></script>

    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">
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
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">PATIENT INFORMATION <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="patient.php?id=<?php echo +$id ?>">CONTACT</a></li>
                        <li><a href="patientInfo.php?id=<?php echo +$id ?>">RECORDS</a></li>
                        <li><a href="progress.php?id=<?php echo +$id ?>">STATUS CHARTS</a></li>
                        <li><a href="weightChartDoc.php?id=<?php echo +$id ?>">WEIGHT CHART</a></li>
                        <?php
                        $sqlUser = "SELECT * FROM `account` WHERE `id` = '$id'";
                        $userResult = $conn->query($sqlUser);
                        if($userResult->num_rows>0) {
                            while ($rowname = $userResult->fetch_assoc()) {
                                $usernameSurvivor = $rowname["username"];
                                $sqlInfo = "SELECT * FROM `supportSubmit` WHERE `survivor` = '$usernameSurvivor'";
                                $supportInfo = $conn->query($sqlInfo);
                                if ($supportInfo->num_rows > 0) {
                                    while ($rowname = $supportInfo->fetch_assoc()) {
                                        $symptom = $rowname["symptom"];
                                        $additional = $rowname["additional"];
                                        $seen = $rowname["seen"];
                                        if ($seen === "false") {
                                            if ($symptom != "" || $additional != "") {
                                                $important="true";
                                            }
                                        }
                                        else{
                                            $important="false";
                                        }
                                    }
                                }
                                else {
                                    $important="false";
                                }
                            }
                        }
                        else{
                            $important="false";
                        }
                        if($important==="true"){
                            echo "<li><a href='proSupport.php?id=+$id'>SUPPORT CIRCLE <span class=\"glyphicon glyphicon-exclamation-sign\"></span></a></li>";

                        }
                        else{
                            echo"<li><a href='proSupport.php?id=+$id'>SUPPORT CIRCLE</a></li>";

                        }
                        ?>
                    </ul>
                </li>
            </ul>
            <ul class = "nav navbar-nav navbar-right">
                <li><a href="../patient/logout.php">LOGOUT</a></li>
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
            echo "<table class='table table-hover row-clickable' id='doctorTable' >";
            echo"<tr>";
            echo"<th>Support Circle</th>";
            echo "<th>Relation</th>";
            echo "</tr>";
            echo "<tr>";
            while($rowname=$support->fetch_assoc()){
               // echo "<div style='overflow-x: scroll'>";


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
<!--//</div>-->

<h2>Patient's friends or family may add symptoms they are noticing or any other additional notes they'd like to log. They will appear here if there are any.</h2>
<div class="box" style="height: inherit">
    <?php
    $sqlPatient="SELECT * FROM `account` WHERE id='$id'";
    $patient=$conn->query($sqlPatient);
    if($patient->num_rows>0) {
        while ($rowname = $patient->fetch_assoc()) {
            $usernamePatient = $rowname["username"];
            $sql1 = "SELECT * FROM `supportSubmit` WHERE `survivor`= '$usernamePatient'";
            $result1 = $conn->query($sql1);
            $counter = 0;
            if ($result1->num_rows > 0) {
                while ($rowname = $result1->fetch_assoc()) {
                    $counter++;
                    $symptom = $rowname["symptom"];
                    $info = $rowname["additional"];
                    $seen = $rowname["seen"];
                    if ($info != "") {
                        if ($seen == "false") {
                            echo "<p>" . $info . " <button class='btn' onclick='showCommentOption($counter)' value='hide/show'>Respond</button></p>
                       <div id='content_$counter' class='comments' style='display:none'>
                       <form method='post' name='commentsSection'>
                       <input type='text' name='comment' placeholder='Respond to patient...'><br>
                       <input type='hidden' name='action' value='filled'>
                       <input type='hidden' name='divID' value='$info'>
                       <input type='submit' value='Respond' class='btn'>
</form>

<br>
</div>";
                        } else {
                            echo "<p>" . $info . " <button class='btn' style='background-color: grey'>Seen</button></p>";
                        }
                    }
                    if ($symptom != "") {
                        $counter++;
                        if ($seen == "false") {
                            echo "<p>" . $symptom . " <button class='btn' onclick='showCommentOption($counter)' value='hide/show'>Respond</button></p>
                       <div id='content_$counter' class='comments' style='display:none'>
                       <form method='post' name='commentsSection2'>
                       <input type='text' name='comment2' placeholder='Respond to patient...'><br>
                       <input type='hidden' name='action2' value='filled'>
                       <input type='hidden' name='divID2' value='$symptom'>
                       <input type='submit' value='Respond' class='btn'></form><br></div>";

                        } else {
                            echo "<p>" . $symptom . " <button class='btn' style='background-color: grey'>Seen</button></p>";

                        }
                    }
                }
            }
        }
    }
    ?>
</div>
<?php
if($action==="filled"){
    $info = safePOST($conn, "divID");
    $response = (safePost($conn,"comment"));
        $sql = "UPDATE `supportSubmit` SET `seen`='true',`response`='$response' WHERE `additional`='$info'";
        if ($conn->query($sql) === TRUE) {
            echo "<p class='center'>Response has been sent!</p>";
            ?>
            <script>
                window.location.href = "proSupport.php?id=+<?php echo $id ?>";
            </script>
            <?php
        }
}

if($action2==="filled"){
    $symptom = safePOST($conn, "divID2");
    $response = (safePost($conn,"comment2"));
    $sql2 = "UPDATE `supportSubmit` SET `seen`='true',`response`='$response' WHERE `symptom`='$symptom'";
    if ($conn->query($sql2) === TRUE) {
        echo "<p class='center'>Response has been sent!</p>";
        ?>
        <script>
            window.location.href = "proSupport.php?id=+<?php echo $id ?>";
        </script>
        <?php
    }
}





?>
<br>
<script>

    function showCommentOption(divID) {
        var x = document.getElementById("content_"+divID);
        console.log("div id " + divID );
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }


</script>

</body>
<div class="clear"></div>

<footer>
    <div class="footer">
        <div class="navbarBottom">
            <a onclick="goBack()">BACK</a>
        </div>
    </div></footer>
</html>