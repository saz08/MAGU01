<?php
session_start();
?>
<?php


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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css" href="stylesheet.css">

    <meta charset="UTF-8">
    <title>Project</title>
    <script>

        if(localStorage.getItem("loginOK")===null){
            localStorage.setItem("loginOK", "no");
        }
        function checkLogIn(){
            return localStorage.getItem("loginOK")==="yes" && localStorage.getItem('username')!=='unknownUser';

        }

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
    <style>
        .fa {
            font-size: 4rem;
            cursor: pointer;
            user-select: none;
        }


    </style>
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
            <ul class = "nav navbar-nav navbar-right">
                <li><a href="logout.php">LOGOUT</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="jumbotron text-center">
    <h1>PATIENT FORUM ROOM</h1>
</div>

<form method="post" name="createForumPost" >
    Create a post: <input type="text" name="createPost" value="Type in here!"><br>
    <input type="hidden" name="action" value="filled">
    <input type="submit" value="Submit" class="btn">
</form><br>

<?php
$sql  = "SELECT * FROM `forum`";
$result = $conn->query($sql);
if($result->num_rows>0){
    $divID=1;
    while($rowname=$result->fetch_assoc()){
        $username= $rowname["username"];
        $post = $rowname["post"];
        echo"<br><div class='forum'><br><p>".$username." :".$post." </p></div>"?>
        <p style="float:right">Tap Twice to Show Support:
            <?php
            $sqlHEART = "SELECT `heart` FROM `forum` WHERE `pos` = '$divID'";
            $resultHEART = $conn->query($sqlHEART);
            if($resultHEART->num_rows>0){
                while($rowname=$resultHEART->fetch_assoc()){
                    $heartCounter = $rowname["heart"];
                }
            }
            else{
                $heartCounter=0;
            }
            if($heartCounter>0){
                echo "<i class='heart fa fa-heart'  id='support' onclick='heartClick($divID)'>$heartCounter</i></p>";

            }
            else{
                echo "<i class='heart fa fa-heart-o' id='support' onclick='heartClick($divID)'></i></p>";

            }


        $sql2  = "SELECT * FROM `comments`";
        $result2 = $conn->query($sql2);
        if($result2->num_rows>0) {
            while ($rowname = $result2->fetch_assoc()) {
                $posID = $rowname["pos"];
                $username = $rowname["username"];
                $comment = $rowname["patientComment"];
                if($posID==$divID) {
                    echo "<div class='forum'><p>Comment from " . $username . ": ." . $comment  . "</p></div>";

                }
            }
        }


        ?>

        <button class="btn" onclick="showCommentOption(<?php echo $divID ?>)" value="hide/show">Add a comment</button><br>
            <div id='content_<?php echo $divID?>' class="comments" style="display: none">
                <form method="post" name="commentsSection">
                    <input type="text" name="comment" value="Leave a comment here..."><br>
                    <input type="hidden" name="action2" value="filled">
                    <input type="hidden" name="divID" value="<?php echo $divID?>">
                    <input type="submit" value="Comment" class="btn">
                </form><br></div>

        <?php
        $divID++;
    }
}
?>

<?php

if($action==="filled"){

    $post = (safePost($conn,"createPost"));
    $username = $_SESSION["userName"];

    $sql  = "INSERT INTO `forum` (`pos`,`username`, `post`,`heart`) VALUES (NULL ,'$username', '$post','0')";
    if ($conn->query($sql) === TRUE) {
        echo "<p class='center'>Forum Post was successful!</p>";
        ?>
        <script>
            window.location.href = "talk.php";
        </script>
        <?php
    }
}

if($action2==="filled"){
    $newDiv = safePOST($conn, "divID");

    $comment = (safePost($conn,"comment"));
    $username = $_SESSION["userName"];
    $sql2  = "INSERT INTO `comments` (`pos`, `username`, `patientComment`) VALUES ('$newDiv', '$username', '$comment')";
    if ($conn->query($sql2) === TRUE) {
        echo "<p class='center'>Comment Post was successful!</p>";
        ?>
        <script>
            window.location.href = "talk.php";
        </script>
        <?php
    }
}

?>


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


    function heartClick(divID){
        var heartDiv = divID;
        $(".heart.fa").click(function() {
            $(this).toggleClass("fa-heart fa-heart-o");
            if(this.className==="heart fa fa-heart-o"){
//                jQuery.post("heartMinus.php", {"HeartDiv": heartDiv}, function(data){
//                    alert("oops! taken away support");
//                    window.location.href="talk.php";
//                    console.log("heart div is " + heartDiv);
//
//                }).fail(function()
//                {
//                    alert("something broke");
//                });
            }
            else{
                jQuery.post("heart.php", {"HeartDiv": heartDiv}, function(data){
                    alert("sent support");
                    window.location.href="talk.php";
                    console.log("heart div is " + heartDiv);

                }).fail(function()
                {
                    alert("something broke in sending support");
                });
            }

        });
    }

</script>

</body>

<div class="clear"></div>

<footer>
    <div class="footer">
        <p style="text-align: center;">&copy; Sara Reid Final Year Project 2019</p>
    </div></footer>
</html>