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
    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/alerts.css">


    <meta charset="UTF-8">
    <title>Survivors</title>
<script>
    function checkAlreadyLoggedIn(){
        if(localStorage.getItem("loginOKSupport")==="yes"){
            if(localStorage.getItem("username")==="unknownUser")
            localStorage.setItem("loginOKSupport","no");
        }
        if(localStorage.getItem("loginOKSupport")==="yes"){
            alert("You are already logged in!");
            window.location.href="supportHome.php";
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
                <li><a href="supportSignUp.php">SUPPORTERS</a></li>
                <li><a href="../professional/docSignUp.php">PROFESSIONALS</a></li>

            </ul>
        </div>
    </div>
</nav>

<div class="jumbotron text-center">
    <h1>SUPPORTERS <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50"></h1>
</div>

<!--Modal: Username or password not recognised-->
<div id="notUser" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanUser" onclick="document.getElementById('notUser').style.display='none'" style="float:right">&times;</button>
        <p>Username or password not recognised</p>
    </div>
</div>

<!--Modal: Fix errors-->
<div id="errs" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanPass" onclick="document.getElementById('errs').style.display='none'" style="float:right">&times;</button>
        <p>Please correct any boxes highlighted pink</p>
    </div>
</div>

<!--Username already registered-->
<div id="username" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanUserok" onclick="document.getElementById('username').style.display='none'" style="float:right">&times;</button>
        <p>Username is already registered</p>
    </div>
</div>


<!--Invalid survivor username-->
<div id="id" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanID" onclick="document.getElementById('id').style.display='none'" style="float:right">&times;</button>
        <p>Survivor username is not registered</p>
    </div>
</div>

<!--Login-->
<div class="container-fluid" id="mainCont">
    <div class="row" id="mainContRow">
        <div class="col-md-6" id="logincol" >
            <form name="login" method="post">
                <h2 style="color:black">Login</h2>
                <p class="lead"style="color:#f7f7f7;">
                    <form name="login" method="post">
                <p>Username:<br> <input type="text" name="username" value=""/></p>
                <p>Password: <br><input type="password" name="password" value=""/></p>
                <input type="hidden" name="action" value="filled">
                <p><input type="submit" name="submitLogon" id="loginButton" style="font-size: 2rem;" class="btn" value="Login"></p>
            </form>
            </p>
            <?php

            if($action === "filled") {
            $username = (safePost($conn, "username"));
            $password = (safePost($conn, "password"));
            $_SESSION['userName'] = $username;
            $query = "SELECT `username` FROM `supportAcc` WHERE `username` = '$username'";
            //if the username matches a username in the database, do this
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result)){
            $query2 = "SELECT `password` FROM `supportAcc` WHERE `username` = '$username'";
            //get password associated with that username
            $result2 = $conn->query($query2);
            if ($result2->num_rows > 0) {
                while ($rowname = $result2->fetch_assoc()) {
                    $DBpassword = $rowname["password"];
                }
            }
            //if the database password matches the password entered, the user is logged in
            if (password_verify("$password", $DBpassword)){
            if (mysqli_num_rows($result2)){
            echo "<p class='center'>Log in was successful!</p>";
            $loginOK = true;
            ?>
                <script>localStorage.setItem("loginOKSupport", "yes");
                    localStorage.setItem("loginOK", "no");
                    localStorage.setItem("loginOKDoc", "no");
                    var user = "<?php echo $username; ?>";
                    localStorage.setItem("username", user);
                    window.location.href = "supportHome.php";
                </script>
                <?php
                }
            }
            else {
                ?>
                <script>
                    var notPass = document.getElementById("notUser");
                    notPass.style.display="block";
                </script><?php
                }
            }
            else {
                ?>
                <script>var notUser = document.getElementById("notUser");
                    notUser.style.display="block";</script><?php
            }
            }
            ?>
        </div>

<!--        Register-->
        <div class="col-md-6" id="registercol">
            <form name="register" method="post" onsubmit="return checkForm()" >
                <h2 style="color:black">Register</h2>
                <p class="lead" style="color:#f7f7f7;">
                <p>Create Username:<br> <input type="text" name="username"  id="username"/></p>
                <p>Create Password: <br><input type="password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"></p>
                <p>Enter Username of Survivor: <br><input type="text" name="survivor"  id="survivor"/></p>
                <p>Relation to You:<br>
                 <select id="relation" name="relation">
                    <option></option>
                    <option value="Parent">Parent/Grandparent</option>
                    <option value="Child">Child/Grandchild</option>
                    <option value="Sibling">Sibling</option>
                    <option value="Friend">Friend</option>
                 </select></p>
                   <input type="hidden" name="action2" value="filled">
                <p><input type="submit" name="submitReg" id="signUpButton"  style="font-size: 2rem;" class="btn" value="Register"></p>
                </p>
            </form>

        </div>

        <script>
            //Error checking
            function checkForm(){
                var username = document.getElementById("username");
                var password = document.getElementById("password");
                var survivor = document.getElementById("survivor");
                var relation = document.getElementById("relation");
                var errorModal = document.getElementById("errs");


                var errs = "";

                username.style.background = "white";
                password.style.background = "white";
                survivor.style.background="white";
                relation.style.background = "white";

                if(username.value === null || username.value === ""){
                    errs += " Please enter your email address\n";
                    username.style.background = "pink";
                }

                if(password.value === null || password.value === ""){
                    errs += " Please enter your email address\n";
                    password.style.background = "pink";
                }

                if(survivor.value===null||survivor.value===""){
                    errs+= "Please enter a valid survivor's username\n";
                    survivor.style.background="pink";
                }

                if(relation.value===null||relation.value===""){
                    errs+= "Please enter how you know the patient. EG: Partner, friend, parent...\n";
                    relation.style.background="pink";
                }

                if(errs !== ""){
                    errorModal.style.display="block";
                }
                return (errs === "");
            }
        </script>

        <?php
        if($action2 === "filled") {
            $usernameSupport = (safePost($conn,"username"));
            $password = (safePost($conn,"password"));
            $survivor = (safePost($conn,"survivor"));
            $relation = (safePost($conn,"relation"));
            $reject = "false";

            //If the username already exists in the database, reject user
            $query = "SELECT `username` FROM `supportAcc` WHERE `username` = '$usernameSupport'";
            $result = $conn->query($query);
            if($result->num_rows>=1){
                ?><script>
                    var username=document.getElementById("username");
                    username.style.display="block";
                    </script> <?php
                $reject = "true";
            }

            //If the username already exists in the patient account, reject user
            $query2 = "SELECT `username` FROM `account` WHERE `username` = '$usernameSupport'";
            $result2 = $conn->query($query2);
            if($result2->num_rows>=1){
                ?><script>var username=document.getElementById("username");
                    username.style.display="block";</script> <?php
                $reject = "true";

            }

            //If the survivor username entered does not exist, reject user
            $checkID = "SELECT `username` FROM `account` WHERE `username` = '$survivor'";
            $resultID = $conn->query($checkID);
        if($resultID->num_rows<1) {
            ?><script>var id=document.getElementById("id");
                id.style.display="block";</script><?php
        $reject = "true";
            }

            //if the user has passed the previous checks, encrypt their password and register their details
        if($reject!="true"){
        $passwordNew = password_hash("$password", PASSWORD_DEFAULT);
        $sqlInsert = "INSERT INTO `supportAcc` (`username`, `password`, `survivor`, `relation`) VALUES ('$usernameSupport', '$passwordNew', '$survivor', '$relation')";
        if ($conn->query($sqlInsert) === TRUE) {
        echo "<p class='center'>Registration was successful!</p>";
        $loginOK = true;
        $_SESSION['userName'] = $usernameSupport;

        ?>
            <script>localStorage.setItem("loginOKSupport", "yes");
                var user = "<?php echo $usernameSupport; ?>";
                localStorage.setItem("username", user);
                window.location.href = "supportHome.php";
            </script>
            <?php
        }
        }
        }
        ?>

    </div>
    <hr>

</div>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
</body>
<div class="clear"></div>

<footer>
    <div class="footer">
        <p style="text-align: center;">&copy; Sara Reid Final Year Project 2019</p>
    </div></footer>
</html>

<?php
$conn->close();?>


