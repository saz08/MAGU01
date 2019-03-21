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
<!doctype html>
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
    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">
    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/alerts.css">


    <meta charset="UTF-8">
    <title>Survivors</title>
    <script>
        function checkAlreadyLoggedIn(){
            if(localStorage.getItem("loginOKDoc")==="yes"){
                if(localStorage.getItem("username")==="unknownUser")
                    localStorage.setItem("loginOKDoc","no");
            }
            if(localStorage.getItem("loginOKDoc")==="yes"){
                alert("You are already logged in!");
                window.location.href="dashboard.php";
            }
        }
    </script>
</head>
<title>Project</title>
<body onload="checkAlreadyLoggedIn()" id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#myPage"> </a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="../patient/signUp.php">SURVIVORS</a></li>
                <li><a href="../support/supportSignUp.php">SUPPORTERS</a></li>
                <li><a href="docSignUp.php">PROFESSIONALS</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="jumbotron text-center">
    <h1>PROFESSIONAL <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50"></h1>
</div>


<div id="notUsername" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanSave" onclick="document.getElementById('notUsername').style.display='none'" style="float:right">&times;</button>
        <p>Username or Password is not recognised</p>
    </div>
</div>

<div id="errs" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanSave" onclick="document.getElementById('errs').style.display='none'" style="float:right">&times;</button>
        <p>Please fix any boxes highlighted pink</p>
    </div>
</div>
<div id="email" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanSave" onclick="document.getElementById('email').style.display='none'" style="float:right">&times;</button>
        <p>Must be a valid NHS email </p>
    </div>
</div>
<div id="user" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanSave" onclick="document.getElementById('user').style.display='none'" style="float:right">&times;</button>
        <p>Username is already registered</p>
    </div>
</div>
<div id="emailAlready" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanSave" onclick="document.getElementById('emailAlready').style.display='none'" style="float:right">&times;</button>
        <p>Email is already registered</p>
    </div>
</div>

<div class="container-fluid" id="mainCont">
    <div class="row" id="mainContRow">
        <div class="col-md-6" id="logincol" >
            <form name="login" method="post">
                <h2 style="color:black">Login</h2>
                <p class="lead"style="color:#f7f7f7;">
                    <form name="login" method="post">
                <p>Username:<br> <input type="text" name="username"/></p>
                <p>Password: <br><input type="password" name="password"/></p>
                <input type="hidden" name="action" value="filled">
                <p><input type="submit" name="submitLogon" id="loginButton" class="btn" style="font-size: 2rem;" value="Login"></p>
            </form>
            </p>
            <?php
            if(isset($_POST["submitLogon"])) {
                if(trim($_POST["username"])== ""){
                    echo "<p><font color='red'>Please enter a valid username***</font><br></p>";
                }
                if(trim($_POST["password"]) == "") {
                    echo"<p> * Please enter a valid password * ";
                }
            }
            if($action === "filled") {
                ?>
                <script>
                    console.log("action is filled");
                </script>
            <?php
            $username = (safePost($conn, "username"));
            $password = (safePost($conn, "password"));
            $_SESSION['userName'] = $username;
            $query = "SELECT `username` FROM `docAcc` WHERE `username` = '$username'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result)){
            $query2 = "SELECT `password` FROM `docAcc` WHERE `username` = '$username'";
            $result2 = $conn->query($query2);
            if ($result2->num_rows > 0) {
                while ($rowname = $result2->fetch_assoc()) {
                    $DBpassword = $rowname["password"];
                }
            }
            if (password_verify("$password", $DBpassword)){
            if (mysqli_num_rows($result2)){
            echo "<p class='center'>Log in was successful!</p>";
            $loginOK = true;
            ?>
                <script>localStorage.setItem("loginOKDoc", "yes")</script>
                <script type="text/javascript">
                    var user = "<?php echo $username; ?>";
                </script>
                <script>localStorage.setItem("username", user);
                    window.location.href = "dashboard.php";
                </script>
            <?php
            }
            }
            else {
            ?>
                <script>
                    var notPass = document.getElementById("notUsername");
                    notPass.style.display="block";
                   </script><?php
            }

            }
            else {
            ?><script>
                    var notUser = document.getElementById("notUsername");
                    notUser.style.display="block";</script><?php
            }
            }
            ?>
        </div>

        <div class="col-md-6" id="registercol">
            <form name="register" method="post" onsubmit="return checkForm()" >
                <h2 style="color:black">Register</h2>
                <p class="lead" style="color:#f7f7f7;">
                <p>Enter Valid NHS Email: <br><input type="email" name="email"  id="email"/></p>
                <p>Create Username:<br> <input type="text" name="username"  id="username"/></p>
                <p>Create Password: <br><input type="password" name="password"  id="password"/></p>
                <input type="hidden" name="action2" value="filled">
                <p><input type="submit" name="submitReg" id="signUpButton" class="btn" style="font-size: 2rem;" value="Register"></p>
                </p>
            </form>
        </div>

        <script>
            function checkForm(){
                var email = document.getElementById("email");
                var username = document.getElementById("username");
                var password = document.getElementById("password");
                var errs = "";

                username.style.background = "white";
                password.style.background = "white";
                email.style.background="white";

                if(username.value === null || username.value === ""){
                    errs += " Please enter your email address\n";
                    username.style.background = "pink";
                }

                if(password.value === null || password.value === ""){
                    errs += " Please enter your email address\n";
                    password.style.background = "pink";
                }

                if(email.value===null||email.value===""){
                    errs+= "Please enter a valid email address\n";
                    email.style.background="pink";
                }

                if(errs !== ""){
                    var error = document.getElementById("errs");
                    error.style.display="block";
                }
                return (errs === "");
            }
        </script>

        <?php
        if($action2 === "filled") {
            $username = (safePost($conn,"username"));
            $password = (safePost($conn,"password"));
            $email = (safePost($conn,"email"));
            $reject = "false";


            if(strpos($email,"nhs")==false){
                $reject="true";
                ?>
                <script>
                    var email = document.getElementById("email");
                    email.style.display="block";
                    </script>
                <?php
            }

            $query = "SELECT `email` FROM `docAcc` WHERE `email` = '$email'";
            $result = $conn->query($query);
            if($result->num_rows>=1){
                $reject = "true";
                ?><script>var emailAlready = document.getElementById("emailAlready");
                    emailAlready.style.display="block";</script> <?php
                echo "<p> * Email is already registered * ";
            }

            $query2 = "SELECT `username` FROM `docAcc` WHERE `username` = '$username'";
            $result2 = $conn->query($query2);
            if($result2->num_rows>=1){
                $reject="true";
                ?><script>var user = document.getElementById("user");
                user.style.display="block";</script> <?php
                echo "<p> * Username is already registered * ";
            }

        if($reject==="false"){
        $passwordNew = password_hash("$password", PASSWORD_DEFAULT);
        $sqlInsert = "INSERT INTO `docAcc` (`email`,`username`, `password`) VALUES ('$email', '$username', '$passwordNew')";
        if ($conn->query($sqlInsert) === TRUE) {
        echo "<p class='center'>Registration was successful!</p>";
        $loginOK = true;
        $_SESSION['userName'] = $username;

        ?>
            <script>localStorage.setItem("loginOKDoc", "yes");
                var user = "<?php echo $username; ?>";
                localStorage.setItem("username", user);
                window.location.href = "dashboard.php";
            </script>
            <?php
        }
        }
        }
        ?>

    </div>
</div>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
</body>
<div class="clear"></div>
<footer>
    <div class="footer">
        <p style="text-align: center;">&copy; Sara Reid Final Year Project 2019</p>
    </div>
</footer>
</html>
<?php
$conn->close();?>


