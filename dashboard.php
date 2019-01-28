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

    <link rel="stylesheet" type="text/css" href="stylesheet.css">

    <meta charset="UTF-8">
    <title>Project</title>
<!--    <script>-->
<!---->
<!--        if(localStorage.getItem("loginOK")===null){-->
<!--            localStorage.setItem("loginOK", "no");-->
<!--        }-->
<!--        function checkLogIn(){-->
<!--            return localStorage.getItem("loginOK")==="yes" && localStorage.getItem('username')!=='unknownUser';-->
<!---->
<!--        }-->
<!---->
<!--    </script>-->
<!--    <script>-->
<!--        var localUser = localStorage.getItem("username");-->
<!--        // window.location.href = window.location.href+'?localUser='+localUser;-->
<!---->
<!--        if(localStorage.getItem("loginOK")===null){-->
<!--            localStorage.setItem("loginOK", "no");-->
<!--        }-->
<!---->
<!--        if(localStorage.getItem("loginOK")==="no"){-->
<!--            window.location.href="signUp.php";-->
<!--        }-->
<!---->
<!---->
<!--        function checkLogIn(){-->
<!--            return localStorage.getItem("loginOK")==="yes";-->
<!--        }-->
<!---->
<!--        function checkUser(){-->
<!--            localUser = localStorage.getItem("username");-->
<!--            console.log("username in local storage" + localStorage.getItem("username"));-->
<!--            return localStorage.getItem("username");-->
<!--        }-->
<!---->
<!--        var oldURL = document.referrer;-->
<!---->
<!---->
<!--    </script>-->
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
            </ul>
        </div>
    </div>
</nav>
<div class="jumbotron text-center">
    <h1>Dashboard</h1>
</div>
<h3>Click on a patient's ID to open their profile</h3>

<div style="overflow-x: scroll">
<table class="table table-hover row-clickable" id="doctorTable" >
    <tr>
        <th>Forename</th>
        <th>Surname</th>
        <th>ID</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Address</th>
        <th>Contact No</th>
    </tr>
    <?php

    $sql = "SELECT * FROM `chi`";
    $resultPatient = $conn->query($sql);
    if($resultPatient->num_rows>0) {
        while ($rowname = $resultPatient->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $rowname["forename"] . "</a></td>";
            echo "<td>" . $rowname["surname"] . "</td>";
            echo "<td><a href='patient.php?id=+".$rowname["id"]."'>" . $rowname["id"] . "</a></td>";
            echo "<td>" . $rowname["age"] . "</td>";
            echo "<td>" . $rowname["gender"] . "</td>";
            echo "<td>" . $rowname["address"] . "</td>";
            echo "<td>" . $rowname["contactNo"] . "</td>";

            echo "</tr>";
        }
    }

    ?>
</table>


<?php




?>


</body>
<div class="clear"></div>

<footer>
    <div class="footer">
        <p style="text-align: center;">&copy; Sara Reid Final Year Project 2019</p>
    </div></footer>
</html>