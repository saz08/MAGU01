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
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>

    <script src="../js/forum.js"></script>
    <script src="../js/forAll.js"></script>

    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/alerts.css">

    <meta charset="UTF-8">
    <title>Forum Room</title>
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">



<div id="docNav" style="display: none">
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbarDoc">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#myPage">    </a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbarDoc">
            <ul class = "nav navbar-nav navbar-left">
                <li><a href="../professional/dashboard.php">DASHBOARD</a></li>
                <li><a href="../professional/createID.php">ADD A PATIENT</a></li>
                <li><a href="../patient/talk.php">FORUM</a></li>
            </ul>
            <ul class = "nav navbar-nav navbar-right">
                <li><a> <button class="btn" id="checkLogOut" onclick="logOutCheck()"  style="background-color: #E9969F;color:black;top:0 " >LOGOUT</button></a></li>
            </ul>
        </div>
    </div>
</nav>
</div>

<div id="patientNav" style="display: none">
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
                    <?php
                    //Detect if session is still running. If not, direct user to login
                    if($_SESSION["userName"]!=null) {
                        $username = $_SESSION["userName"];
                    }
                    else{
                        ?><script>
                            localStorage.setItem("username","unknownUser");
                            localStorage.setItem("loginOK","no");
                            alert("Session has expired, please log in again");

                            window.location.href="signUp.php";
                        </script><?php
                    }
                    //Show info alert when patient has a response from doctor
                    $sqlInfo = "SELECT * FROM `scale` WHERE `username` = '$username'";
                    $supportInfo = $conn->query($sqlInfo);
                    if ($supportInfo->num_rows > 0) {
                        $importantInfo=0;
                        $importantSymp=0;
                        while ($rowname = $supportInfo->fetch_assoc()) {
                            $seenInfo = $rowname["seenInfo"];
                            $resInfo = $rowname["resInfo"];
                            $seenSymp = $rowname["seenSymp"];
                            $resSymp = $rowname["resSymp"];

                            if ($seenInfo === "true" && $resInfo != "") {
                                $importantInfo++;
                            }

                            if ($seenSymp === "true" && $resSymp != "") {
                                $importantSymp++;
                            }
                        }
                    }
                    $importantInfo=0;
                    $importantSymp=0;
                    if($importantInfo>0||$importantSymp>0){
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
                    <li><button class="btn" onclick="logOutCheck()" style="background-color: #E9969F;color:black" >LOGOUT</button></li>
                </ul>
            </div>
        </div>
    </nav>

</div>
<script>
    //This page can be accessed by patients or doctors
    //Determine who is accessing the page and what navigation bar to show
    var docNav= document.getElementById("docNav");
    var patientNav = document.getElementById("patientNav");

    if(localStorage.getItem("loginOKDoc")==="yes"){
        docNav.style.display="block";
        patientNav.style.display="none";
    }
    if(localStorage.getItem("loginOK")==="yes"){
        patientNav.style.display="block";
        docNav.style.display="none";
    }
</script>
<div class="jumbotron text-center">
    <h1>Patient Forum Room <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50" a href="https://www.clipartmax.com/middle/m2i8A0N4d3H7G6d3_lung-cancer-ribbon-color/"></h1>
</div>

<!--Modal: Logout Check-->
<div id="logOutCheck" class="modal">
    <div class="modal-content">
        <p>Are you sure you want to log out?</p>
        <button id="spanSubmitCheck" class="btn" onclick="window.location.href='logout.php' ;document.getElementById('logOutCheck').style.display='none';">Yes</button>
        <button id="spanSubmitCheck" class="btn" onclick="document.getElementById('logOutCheck').style.display='none';">No</button>
    </div>
</div>

<!--Create a forum post-->
<form method="post" name="createForumPost" >
    <h2>Create a post:</h2> <input type="text" name="createPost" placeholder="Type in here!"><br>
    <input type="hidden" name="action" value="filled">
    <input type="submit" value="Submit" class="btn" id="button">
</form><br>

<!--Filter through the forum on keyup-->
<div id="keyword" style="text-align:center">
    <h3>Filter through posts and comments</h3>
<input type="text"   id="myInput" onkeyup="searchForum()" placeholder="Search for a post or comment" title="Start typing">
</div>

<br>
<!--Modal: Couldn't delete-->
<div id="delete" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanNotify" onclick="document.getElementById('delete').style.display='none';" style="float:right">&times;</button>
        <p>Survivors was unable to successfully delete. Please check your internet connection and try again.</p>
    </div>
</div>
<?php
$sql  = "SELECT * FROM `forum`";
$result = $conn->query($sql);
if($result->num_rows>0){
    $divID=1;
    while($rowname=$result->fetch_assoc()){
        $posDB = $rowname["pos"];
        $usernameDB= $rowname["username"];
        $post = $rowname["post"];

        //Each post and associated comments have the same position ID
        //Show the forum post and the username of who posted it
        //A user can only delete their own post
        echo "<div id='$posDB'>";
        echo"<div class='divSpace'></div>
        <div class='forum' id='forumPost_".$posDB."'><br><br><p>".$usernameDB.": ".$post;
        if($usernameDB===$username) {
            echo "<button class='btn' id='buttonDelPost' onclick='deletePost($posDB)' value='hide/show' style='float:right;font-size:1.5rem'>Delete Post <i class='far fa-trash-alt'></i></button><br>";
        }
        echo"</p></div>";

        //Show the comment and the username of who posted it
        //A user can only delete their own comment
        $sql2  = "SELECT * FROM `comments`";
        $result2 = $conn->query($sql2);
        if($result2->num_rows>0) {
            while ($rowname = $result2->fetch_assoc()) {
                $posID = $rowname["pos"];
                $usernameC = $rowname["username"];
                $comment = $rowname["patientComment"];
                if($posID==$posDB) {
                    echo "<div class='comment' id='comment_".$posID."'><p>Comment from " . $usernameC . ": " . $comment;
                                        if($username===$usernameC){

                                            ?>
                                            <button class="btn" style="font-size:1.5rem;float:right" id="buttonDelComment"  onclick="deleteComment('<?php echo $comment ?>'); console.log('on click comment<?php echo $comment ?>')" >Delete Comment <i class='far fa-trash-alt'></i></button><br>

                                            <?php
                                        }
                    echo"</p></div><br>";
                }
            }
        }
        ?>

<!--        Add comment option under each post or recent comment-->
        <button class="btn"   id="buttonAdd" onclick="showCommentOption(<?php echo $posDB ?>)" style="float:right;font-size:1.5rem" value="hide/show" >Add a comment <i class='fas fa-plus'></i></button>
        <br>
            <div id='content_<?php echo $posDB?>' class="comments" style="display: none">
                <form method="post" name="commentsSection">
                    <input type="text" name="comment" placeholder="Leave a comment here..."><br>
                    <input type="hidden" name="action2" value="filled">
                    <input type="hidden" name="divID" value="<?php echo $posDB?>">
                    <input type="submit" value="Comment" class="btn" style="font-size:1.5rem" id="button">
                </form></div>
<br>
<?php
        $divID++;
        echo "</div>";
    }
    echo"<div class='divSpace'></div>";
}
//Display this when no results are found in searchbar
echo"<div class='box' id='noResults' style='display:none'><p>Sorry, no posts or comments were found containing that word</p></div>";
echo"<div class='divSpace'></div>";


if($action==="filled") {
    //Enter forum post
    $post = (safePost($conn, "createPost"));
    $username = $_SESSION["userName"];
    if ($post != "") {
        $sql = "INSERT INTO `forum` (`pos`,`username`, `post`) VALUES (NULL ,'$username', '$post')";
        if ($conn->query($sql) === TRUE) {
            echo "<p class='center'>Forum Post was successful!</p>";
            ?>
            <script>
                window.location.href = "talk.php";
            </script>
            <?php
        }
    }
}

if($action2==="filled") {
    $pos = safePOST($conn, "divID");
//Enter comments
    $comment = (safePost($conn, "comment"));
    $username = $_SESSION["userName"];
    if ($comment != "") {
        $sql2 = "INSERT INTO `comments` (`pos`, `username`, `patientComment`) VALUES ('$pos', '$username', '$comment')";
        if ($conn->query($sql2) === TRUE) {
            echo "<p class='center'>Comment Post was successful!</p>";
            ?>
            <script>

                window.location.href="talk.php";
            </script>
            <?php
        }
    }
}
?>
<script>
    //Search function
    function searchForum() {
        var input = document.getElementById("myInput");
        var filter = input.value.toLowerCase();
        var forumPost = document.getElementsByClassName('forum');
        var comments = document.getElementsByClassName("comment");
        var noResults = document.getElementById("noResults");

        //Initially make all posts and comments display none
        for (var x = 0; x < forumPost.length; x++) {
            var allPosts = forumPost[x].id.substr(10);
            document.getElementById(allPosts).style.display = "none";
            noResults.style.display="block";

        }

        //If a post contains the keyword, show that post
        for (var y = 0; y < forumPost.length; y++) {
            var showPost = forumPost[y].id.substr(10);
            if (forumPost[y].innerText.toLowerCase().includes(filter)) {
                document.getElementById(showPost).style.display = "block";
                noResults.style.display="none";
            }
        }
        //if the comment contains the keyword, show that comment
        for(var z = 0; z < comments.length; z++) {
            var showComment = comments[z].id.substr(8);
            if(comments[z].innerText.toLowerCase().includes(filter)){
                document.getElementById(showComment).style.display = "block";
                noResults.style.display="none";
            }
        }
    }
</script>
<br>
<div class="footer">
    <button class="btn" onclick="goBack()" style="float:left"><b><</b> Back </button>
</div>
</body>
</html>