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
//$username= "<script>localStorage.getItem('username')</script>";






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
    <title>Adapt To You</title>
    <script>

        if(localStorage.getItem("loginOK")===null){
            localStorage.setItem("loginOK", "no");
        }
        function checkLogIn(){
            return localStorage.getItem("loginOK")==="yes" && localStorage.getItem('username')!=='unknownUser';

        }

    </script>
    <script>
        var localUser = localStorage.getItem("username");
        // window.location.href = window.location.href+'?localUser='+localUser;

        if(localStorage.getItem("loginOK")===null){
            localStorage.setItem("loginOK", "no");
        }

        if(localStorage.getItem("loginOK")==="no"){
            window.location.href="signUp.php";
        }


        function checkLogIn(){
            return localStorage.getItem("loginOK")==="yes";
        }

        function checkUser(){
            localUser = localStorage.getItem("username");
            console.log("username in local storage" + localStorage.getItem("username"));
            return localStorage.getItem("username");
        }

    </script>
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
                <li><a href="index.html">HOME</a></li>
                <li><a href="scale.php">RECORD</a></li>
                <li><a href="talk.php">TALK</a></li>
                <li><a href="links.html">HELP</a></li>
                <li><a href="results.php">PROFILE</a></li>

            </ul>
        </div>
    </div>
</nav>
<div class="jumbotron text-center">
    <h1>My Progress</h1>
</div>

<div id="body">
<?php
$sql2 = "SELECT * FROM `account` WHERE `username`= '$username'";
$result= $conn->query($sql2);
if($result->num_rows>0){
    while ($row = $result->fetch_assoc()) {
        echo "<option value = 'username'>Username: ".$row["username"]."</option>";
        echo "<option value = 'gender'>Gender: ".$row["gender"]."</option>";
        echo "<option value = 'age'>Age: ".$row["age"]."</option>";
        if($row["smoker"]=="smoker"){
            echo "<option value = 'smoker?'>Smoker Status: Never</option>";
        }
        else {
            echo "<option value = 'smoker?'>Smoker Status: Current</option>";
        }


    }
}

?>
    <button onclick="logoutFunction()">
        Logout
    </button>
<table class="table table-striped" id="questionTable">
    <tr>
        <th>ID</th>
        <th>Questions</th>
    </tr>
    <?php

    $sqlJournal = "SELECT * FROM `questions` WHERE `username` = '$username'";
    $resultJournal = $conn->query($sqlJournal);
    if($resultJournal->num_rows>0) {
        while ($rowname = $resultJournal->fetch_assoc()) {
            $pos = $rowname["pos"];
            $question = $rowname["question"];
            echo "<tr>";
            echo "<td>" . $pos . "</td>";
            echo "<td>" . $question . "</td>";
            echo "</tr>";
        }
    }


    ?>
</table>

<table class="table table-striped">
<tr>
    <th>Diary Entries</th>
    <th>Time</th>
</tr>
<?php

$sqlJournal = "SELECT * FROM `journal` WHERE `username` = '$username'";
$resultJournal = $conn->query($sqlJournal);
if ($resultJournal->num_rows > 0) {
    while ($rowname = $resultJournal->fetch_assoc()) {
        $post = $rowname["entry"];
        $time = $rowname["timePosted"];
        echo "<tr>";
        echo "<td>" . $post . "</td>";
        echo "<td>" . $time . "</td>";
        echo "</tr>";
    }
    ?>
    </table>

    <h3>Delete a Question</h3>

    <?php
    $sql2 = "SELECT `pos` FROM `questions` WHERE `username` = '$username'";
    $result = $conn->query($sql2);
    echo "<form action = \"profile.php\" method =\"post\"><p style='color: slateblue'>Delete Question:<select name = \"deleteQ\" style='color: black'>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value = '".$row["pos"]."'>".$row["pos"]."</option>";
        }
    }

    echo "<input type=\"hidden\" name=\"action\" value=\"filled\"/>";
    echo"<input type=\"submit\" name='submit' value='Submit' style='color:slateblue'/>";
    echo "</form>";


    if($action==="filled"){
        $sql  = "DELETE FROM `questions` WHERE `question` = '$question' AND `username` = '$username'";
        if($conn->query($sql) === TRUE){
            echo"deleted";
            ?>
            <script>window.location.href="https://devweb2017.cis.strath.ac.uk/~szb15123/AdaptToYou/profile.php"</script>
            <?php

        }
        else{
            die("Error on insert"  .$conn-> error); //FIXME only use during debugging
        }
    }
    ?>
</div>
    <?php
}
?>

<script>
    function logoutFunction(){
        window.location.href="logout.php";

    }
</script>



<div class="clear"></div>
</body>
<footer>
    <div class="footer">
    <p style="text-align: center;">&copy; Sara Reid Final Year Project 2019</p>
    </div>
</footer>
</html>