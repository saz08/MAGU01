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

    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">

    <meta charset="UTF-8">
    <title>Project</title>
</head>
<?php
$id = $_GET['id'];

$sqlD="SELECT * FROM `chi` WHERE id='$id'";
$details=$conn->query($sqlD);
if($details->num_rows>0){
    while($rowname=$details->fetch_assoc()){
        $forename= $rowname["forename"];
        $surname = $rowname["surname"];
        $birthday = $rowname["birthday"];
        $gender = $rowname["gender"];
        $address = $rowname["address"];
        $contact = $rowname["contactNo"];
    }
}
else{
    $forename= "";
    $surname = "";
    $birthday = "";
    $gender = "";
    $address = "";
    $contact ="";
    $usernamePatient="";
}

$sqlPatient="SELECT * FROM `account` WHERE id='$id'";
$patient=$conn->query($sqlPatient);
if($patient->num_rows>0){
    while($rowname=$patient->fetch_assoc()){
        $usernamePatient= $rowname["username"];
    }
}


?>
<script>
    localStorage.setItem("id", <?php echo $id?>);
</script>

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
                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">MORE INFO <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="progress.php?id=<?php echo +$id ?>">PROGRESS CHARTS</a></li>
                        <li><a href="weightChartDoc.php?id=<?php echo +$id ?>">WEIGHT CHART</a></li>
                        <li><a href="proSupport.php?id=<?php echo +$id ?>">SUPPORT CIRCLE</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
<div class="jumbotron text-center">
    <h1>Profile for Patient: <?php  echo $forename ." ". $surname ?></h1>
</div>



        <?php

        $sql  = "SELECT * FROM `account` WHERE `id` = '$id'";
        $result = $conn->query($sql);
        if($result->num_rows>0) {
            while ($rowname = $result->fetch_assoc()) {
                echo"<div style='overflow-x: scroll'>";
    echo"<table class='table table-hover row-clickable' id='doctorTable' >";
                echo"<tr>";
                echo "<th>Forename</th>";
            echo "<th>Surname</th>";
           echo "<th>Birthday</th>";
           echo "<th>Gender</th>";
           echo "<th>Smoking Status</th>";
           echo "<th>Address</th>";
           echo "<th>Contact No.</th>";

        echo"</tr>";
                echo "<tr>";
                echo "<td>" . $forename . "</td>";
                echo "<td>" . $surname . "</td>";
                echo "<td>" . $birthday . "</td>";
                echo "<td>" . $gender . "</td>";
                echo "<td>" . $rowname["smokingStatus"] . "</td>";
                echo "<td>" . $address . "</td>";
                echo "<td>" . $contact . "</td>";

                echo "</tr>";
            }
        }
        else{
            echo"<h2>Patient has not registered yet.</h2>";
        }

        ?>
    </table>
</div>

        <?php

        $sqlScale  = "SELECT * FROM `scale`WHERE id = '$id' ORDER BY `timeStamp` DESC LIMIT 1";

        $resultScale = $conn->query($sqlScale);
        if($resultScale->num_rows>0) {
            while ($rowname = $resultScale->fetch_assoc()) {
                echo"<div style=\"overflow-x: scroll\">";
                echo"<table class='table table-hover row-clickable' id='doctorTable' >";
        echo"<tr>";
          echo"<th>Most Recent Pain Rate</th>";
           echo"<th>Most Recent Breathlessness Rate</th>";
            echo"<th>Most Recent Performance Score</th>";

        echo"</tr>";
                echo "<tr>";
                if($rowname["pain"]>=8){
                    echo "<td style='background-color: red;color: black'>" . $rowname["pain"] . "</a></td>";
                }

                else if($rowname["pain"]>=4&&$rowname["pain"]<=7){
                    echo "<td style='background-color: orange;color: black'>" . $rowname["pain"] . "</a></td>";
                }
                else{
                    echo "<td style='background-color: limegreen;color: black'>" . $rowname["pain"] . "</a></td>";
                }
                if($rowname["breathlessness"]=5){
                    echo "<td style='background-color: red;color: black'>" . $rowname["breathlessness"] . "</a></td>";
                }

                else if($rowname["breathlessness"]>=2&&$rowname["breathlessness"]<=4){
                    echo "<td style='background-color: orange;color: black'>" . $rowname["breathlessness"] . "</a></td>";
                }
                else{
                    echo "<td style='background-color: limegreen;color: black'>" . $rowname["breathlessness"] . "</a></td>";
                }
                if($rowname["performance"]>=3){
                    echo "<td style='background-color: red;color: black'>" . $rowname["performance"] . "</a></td>";
                }

                else if($rowname["performance"]>=1&&$rowname["performance"]<=2){
                    echo "<td style='background-color: orange;color: black'>" . $rowname["performance"] . "</a></td>";
                }
                else{
                    echo "<td style='background-color: limegreen;color: black'>" . $rowname["performance"] . "</a></td>";
                }

                echo "</tr>";
            }
        }
        else{
            echo"<h2>Patient has not recorded any pain, breathlessness or performance issues</h2>";
        }
       echo" </table>";
        echo "</div>";
        ?>

<h2>Patients may send additional notes that they are concerned about. They will appear here if there are any.</h2>
<div class="box" style="height: inherit">
    <?php
    $sql  = "SELECT * FROM `scale` WHERE `id`= '$id'";
    $result=$conn->query($sql);
    $counter=0;
    if($result->num_rows>0){
        while($rowname=$result->fetch_assoc()){
            $counter++;
            $info = $rowname["additionalInfo"];
            $seen = $rowname["seen"];
            if($info!=""){
                if($seen=="false"){
                    echo"<p>".$info." <button class='btn' onclick='showCommentOption($counter)' value='hide/show'>Respond</button></p>
                       <div id='content_$counter' class='comments' style='display:none'>
                       <form method='post' name='commentsSection'>
                       <input type='text' name='comment' placeholder='Respond to patient...'><br>
                       <input type='hidden' name='action' value='filled'>
                       <input type='hidden' name='divID' value='$info'>
                       <input type='submit' value='Respond' class='btn'>
</form>
<br>
</div>";

                }
                else{
                    echo"<p>".$info." <button class='btn' style='background-color: grey'>Seen</button></p>";

                }

            }
        }
    }
    ?>
</div>


<?php
if($action==="filled"){
    $info = safePOST($conn, "divID");
    $comment = (safePost($conn,"comment"));
    $sql  = "UPDATE `scale` SET `seen`='true',`response`='$comment' WHERE `additionalInfo`='$info'";
    if ($conn->query($sql) === TRUE) {
        echo "<p class='center'>Response has been sent!</p>";
        ?>
        <script>
            window.location.href = "patient.php?id=+<?php echo $id ?>";
        </script>
        <?php
    }
}
?>




<br>
<script>

    function markAsSeen(counter){
        jQuery.post("markAsSeen.php", {"Counter": counter}, function(data){
            alert("Marked as Seen");
        }).fail(function()
        {
            alert("something broke in submitting your records");
        });
    }

    function showCommentOption(counter) {
        var x = document.getElementById("content_"+counter);
        console.log("div id " + counter );
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
        <div class="glyphicon glyphicon-arrow-left" style="float:left" id="arrows" onclick="goBack()"></div>

        <p style="text-align: center;">&copy; Sara Reid Final Year Project 2019</p>
    </div></footer>
</html>