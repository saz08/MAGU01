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

$loginOK = false; //TODO make this work with database values

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
    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">
    <script src="../js/script.js"></script>
    <script src="../js/forAll.js"></script>

    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">

    <meta charset="UTF-8">
    <title>Forum Room</title>
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class = "nav navbar-nav navbar-left">
                <ul class = "nav navbar-nav navbar-left">
                    <?php
                    $sqlInfo = "SELECT * FROM `scale` WHERE `username` = '$username'";
                    $supportInfo = $conn->query($sqlInfo);
                    if ($supportInfo->num_rows > 0) {
                        while ($rowname = $supportInfo->fetch_assoc()) {
                            $seen = $rowname["seen"];
                            $responseDoc = $rowname["response"];
                            $important="false";
                            if ($seen === "true" && $responseDoc != "") {
                                $important = "true";
                            }
                            else {
                                $important = "false";
                            }
                        }
                    }
                    else{
                        $important="false";
                    }

                    if($important==="true"){
                        echo "<li><a href='index.php'>HOME <span class=\"glyphicon glyphicon-exclamation-sign\"></span></a></li>";
                    }
                    else{
                        echo"<li><a href='index.php'>HOME</a></li>";
                    }
                    ?>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" onclick="openRecord()">RECORD <span class="caret"></span></a>
                        <ul class="dropdown-menu" id="record">
                            <li><a href="scale.php">HEALTH MONITORING</a></li>
                            <li><a href="weight.php">WEIGHT MONITORING</a></li>
                            <li><a href="physical.php">PHYSICAL ACTIVITY MONITORING</a></li>
                        </ul>
                    </li>


                    <li><a href="talk.php">TALK</a></li>
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" onclick="openHelp()">HELP <span class="caret"></span></a>
                        <ul class="dropdown-menu" id="help">
                            <li><a href="helpInfo.php">INFO</a></li>
                            <li><a href="helpFinancial.php">FINANCIAL</a></li>
                            <li><a href="helpEmotional.php">EMOTIONAL</a></li>
                            <li><a href="helpPhysical.php">PHYSICAL</a></li>
                        </ul>
                    </li>
                    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" onclick="openProfile()">PROFILE <span class="caret"></span></a>
                        <ul class="dropdown-menu" id="profile">
                            <li><a href="statusChart.php">STATUS CHARTS</a></li>
                            <li><a href="weightChart.php">WEIGHT CHART</a></li>
                            <li><a href="physicalChart.php">PHYSICAL ACTIVITY CHART</a></li>
                            <li><a href="questions.php">QUESTIONS</a></li>
                            <li><a href="supportCircle.php">SUPPORT CIRCLE</a></li>
                        </ul>
                    </li>
                </ul>
            <ul class = "nav navbar-nav navbar-right">
                <li><a href="logout.php">LOGOUT</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="jumbotron text-center">
    <h1>Patient Forum Room <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>

<form method="post" name="createForumPost" >
    Create a post: <input type="text" name="createPost" placeholder="Type in here!"><br>
    <input type="hidden" name="action" value="filled">
    <input type="submit" value="Submit" class="btn" id="button">
</form><br>
<input type="text" style="left:20%;width:80%" id="myInput" onkeyup="searchForum()" placeholder="Search for a post" title="Start typing">
<br>

<?php
$sql  = "SELECT * FROM `forum`";
$result = $conn->query($sql);
if($result->num_rows>0){
    $divID=1;
    while($rowname=$result->fetch_assoc()){
        $posDB = $rowname["pos"];
        $usernameDB= $rowname["username"];
        $post = $rowname["post"];

        echo"<br><div class='forum' id='forumPost'><br><br><p>".$usernameDB." :".$post." </p></div>";

        $sql2  = "SELECT * FROM `comments`";
        $result2 = $conn->query($sql2);
        if($result2->num_rows>0) {
            while ($rowname = $result2->fetch_assoc()) {
                $posID = $rowname["pos"];
                $usernameC = $rowname["username"];
                $comment = $rowname["patientComment"];
                if($posID==$posDB) {
                    echo "<div class='comment'><p>Comment from " . $usernameC . ": " . $comment  . "</p></div><br>";
                    if($username===$usernameC){
                        $comment = $rowname["patientComment"];
?><button class="btn" id="buttonDelComment" style="float:right" onclick="deleteComment('<?php echo $comment ?>')">Delete Your Comment</button><br>
                        <?php

                    }
                }

            }
        }


        ?>

        <button class="btn" id="buttonAdd" onclick="showCommentOption(<?php echo $posDB ?>)" value="hide/show" style="float:right">Add a comment</button>
        <br>
            <div id='content_<?php echo $posDB?>' class="comments" style="display: none">
                <form method="post" name="commentsSection">
                    <input type="text" name="comment" placeholder="Leave a comment here..."><br>
                    <input type="hidden" name="action2" value="filled">
                    <input type="hidden" name="divID" value="<?php echo $posDB?>">
                    <input type="submit" value="Comment" class="btn" id="button">
                </form></div>
<br>


        <?php

        if($usernameDB===$username){
            echo"<button class='btn' id='buttonDelPost' onclick='deletePost($posDB)' value='hide/show' style='float:right;font-size: 2rem'>Delete Your Post</button><br>";
        }

        $divID++;

    }
}
?>

<?php

if($action==="filled"){

    $post = (safePost($conn,"createPost"));
    $username = $_SESSION["userName"];


    $sql  = "INSERT INTO `forum` (`pos`,`username`, `post`) VALUES (NULL ,'$username', '$post')";
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
    $pos = safePOST($conn, "divID");

    $comment = (safePost($conn,"comment"));
    $username = $_SESSION["userName"];
    $sql2  = "INSERT INTO `comments` (`pos`, `username`, `patientComment`) VALUES ('$pos', '$username', '$comment')";
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

    function searchForum() {
            var input = document.getElementById("myInput");
            var filter = input.value.toLowerCase();
            var nodes = document.getElementsByClassName('forum');
             var btn = document.getElementsByClassName('btn');
        var comments = document.getElementsByClassName("comment");
        var buttonDelPost = document.getElementById("buttonDelPost");
        var addBtn = document.getElementById("buttonAdd");
        var buttonDelComment = document.getElementById("buttonDelComment");
        buttonDelPost.style.display="none";
        addBtn.style.display="none";
        buttonDelComment.style.display="none";




            for (i = 0; i < nodes.length; i++) {
                for(x=0;x<comments.length; x++){
                if (nodes[i].innerText.toLowerCase().includes(filter)) {
                    nodes[i].style.display = "block";
                    if(comments[x].innerText.toLowerCase().includes(filter)){
                        comments[i].style.display="block";
                        buttonDelPost.style.display="block";
                        addBtn.style.display="block";
                        buttonDelComment.style.display="block";
                    }

                } else {
                    nodes[i].style.display = "none";
                    btn[i].style.display = "none";
//                    comments[i].style.display="none";
                    buttonDelComment[i].style.display = "none";
                    addBtn[i].style.display = "none";
                    buttonDelPost.style.display = "none";

                }
                }
            }




    }
</script>
<br>
<div class="footer">
    <button class="btn" onclick="goBack()" style="float:left"><b><</b> Back </button>
</div>
</body>

<div class="clear"></div>
<br>

</html>