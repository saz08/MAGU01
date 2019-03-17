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

?>
<!DOCTYPE html>
<script>
    if(localStorage.getItem("loginOK")===null){
        localStorage.setItem("loginOK", "no");
        localStorage.setItem("username", "unknownUser");
    }
</script>

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
    <link rel="apple-touch-icon" sizes="180x180" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../clipart2199929.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../clipart2199929.png">

    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/radio.css">
    <link rel="stylesheet" type="text/css" href="../stylesheets/alerts.css">

    <meta charset="UTF-8">
    <title>Survivors</title>
</head>
<title>Survivors</title>
<body onload="checkAlreadyLoggedIn()" id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-left">
                <li><a href="signUp.php">SURVIVORS</a></li>
                <li><a href="../support/supportSignUp.php">SUPPORTERS</a></li>
                <li><a href="../professional/docSignUp.php">PROFESSIONALS</a></li>

            </ul>
        </div>
    </div>
</nav>

<div class="jumbotron text-center">
    <h1>SURVIVORS <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50"></h1>
</div>

<div id="errs" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanErrs" onclick="document.getElementById('errs').style.display='none';" style="float:right">&times;</button>
        <p>Please correct any boxes highlighted pink</p>
    </div>
</div>

<div id="username" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanUser" onclick="document.getElementById('username').style.display='none';" style="float:right">&times;</button>
        <p>Username is already registered</p>
    </div>
</div>
<div id="id" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanId" onclick="document.getElementById('id').style.display='none';" style="float:right">&times;</button>
        <p>Incorrect ID: ID is not registered</p>
    </div>
</div>

<div id="notUsername" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanNotUser" onclick="document.getElementById('notUsername').style.display='none';" style="float:right">&times;</button>
        <p>Username or Password not recognised</p>
    </div>
</div>


<div class="container-fluid" id="mainCont">
    <div class="row" id="mainContRow">
        <div class="col-md-6" id="logincol" >
            <form name="login" method="post">
                <h2 style="color:black">Login</h2>
                <p class="lead"style="color:#f7f7f7;">
                    <form name="login" method="post" action="index.php">
                <p>Username:<br> <input type="text" name="username" value=""/></p>
                <p>Password: <br><input type="password" name="password" value=""/></p>
                <input type="hidden" name="action" value="filled">
                <p><input type="submit" name="submitLogon" id="loginButton" class="btn" style="font-size: 2rem;" value="Login"></p>
                </p>
            </form>

            <?php
            if(isset($_POST["submitLogon"])) {
                if(trim($_POST["username"])== ""){
                    echo "<p><font color='red'>Please enter a valid username***</font><br></p>";
                }
                if(trim($_POST["password"]) == "") { //TODO add in or for wrong password
                    echo"<p> * Please enter a valid password * ";
                }
            }
            if($action === "filled") {

            $username= (safePost($conn,"username"));
            $password = (safePost($conn,"password"));
            $query = "SELECT `username` FROM `account` WHERE `username` = '$username'";
            $result = mysqli_query($conn,$query);
            if(mysqli_num_rows($result)){
            $query2 = "SELECT `password` FROM `account` WHERE `username` = '$username'";
            $result2 = $conn->query($query2);
            if($result2->num_rows>0) {
            while ($rowname = $result2->fetch_assoc()) {
                $DBpassword = $rowname["password"];
                }
            }
            if(password_verify("$password",$DBpassword)){
            if(mysqli_num_rows($result2)){
            echo "<p class='center'>Log in was successful!</p>";
            $loginOK=true;
            $_SESSION['userName'] = $username;

                ?> <script>localStorage.setItem("loginOK", "yes");
                    var user = "<?php echo $username; ?>";
                localStorage.setItem("username", user);
                window.location.href = "index.php";
                </script>
            <?php
            }
            }
            else{
                ?><script>  var notPassword= document.getElementById("notUsername");
                    notPassword.style.display="block";</script><?php
                }

            }
            else{
                ?><script>
                    var notUsername= document.getElementById("notUsername");
                    notUsername.style.display="block";
                </script><?php
            }
 }
            ?>
        </div>

        <div class="col-md-6" id="registercol">
            <form name="register" method="post" onsubmit="return checkForm()" >
                <h2 style="color:black">Register</h2>
                <p class="lead" style="color:#f7f7f7;">
                <p>Create Username:<br> <input type="text" name="username" value="" id="username"/></p>
                <p>Create Password:<input type="password" name="password" id="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters"></p>
                <p>Enter ID: <br><input type="number" name="id" value="" id="id"/></p>
                <p>Smoker Status <i>*Optional*</i></p>
                <p>
                <label for="smoker">
                <input type="radio" name="smoker" value="smoker" id="smoker" class="radiostyle">
                    Current
                </label>
                </p>
                <label for="nonsmoker">
                <input type="radio" name="smoker" value="nonsmoker" id="nonsmoker" class="radiostyle">
                    Never
                </label>
                <input type="hidden" name="action2" value="filled">
                <p><input type="submit" name="submitReg" id="signUpButton" class="btn" style="font-size: 2rem;" value="Register"></p>
                </p>
                <br>
            </form>
        </div>


        <script>
            function checkForm(){
                var username = document.getElementById("username");
                var password = document.getElementById("password");
                var id = document.getElementById("id");
                var male = document.getElementById("male");
                var female = document.getElementById("female");
                var other = document.getElementById("other");
                var smoker = document.getElementById("smoker");
                var nonsmoker = document.getElementById("nonsmoker");
                var errorModal = document.getElementById("errs");

                var errs = "";

                username.style.background = "white";
                password.style.background = "white";
                id.style.background="white";
                male.style.background = "white";
                female.style.background="white";
                smoker.style.background = "white";
                nonsmoker.style.background="white";
                other.style.background="white";

                if(username.value === null || username.value === ""){
                    errs += " Please enter your email address\n";
                    username.style.background = "pink";
                }

                if(password.value === null || password.value === ""){
                    errs += " Please enter your email address\n";
                    password.style.background = "pink";
                }

                if(id.value===null||id.value===""){
                    errs+= "Please enter a valid ID\n";
                    id.style.background="pink";
                }


                if(errs !== ""){
                    errorModal.style.display="block";
                }
                return (errs === "");
            }
        </script>

        <?php
        if($action2 === "filled") {
            $username = (safePost($conn,"username"));
            $password = (safePost($conn,"password"));
            $id = (safePost($conn,"id"));
            $smoker = (safePost($conn,"smoker"));
            $nonsmoker=(safePost($conn,"nonsmoker"));

            $smoker1=" ";
            $_SESSION['userName'] = $username;

            if($smoker=="smoker"){
                $smoker1="Current";
            }
            else{
                $smoker1="Never";
            }

            $query = "SELECT `username` FROM `account` WHERE `username` = '$username'";
            $result = $conn->query($query);
            if($result->num_rows<1){
                    $checkID = "SELECT `id` FROM `chi` WHERE `id` = '$id'";
                    $resultID = $conn->query($checkID);
                    if($resultID->num_rows>0) {
                        $passwordNew = password_hash("$password",PASSWORD_DEFAULT);
                        $sql = "INSERT INTO `account` (`id`,`username`, `password`, `smokingStatus`) VALUES ('$id','$username', '$passwordNew', '$smoker1')";
                        if ($conn->query($sql) === TRUE) {
                            echo "<p class='center'>Registration was successful!</p>";
                            $loginOK = true;
                            ?>
                            <script>localStorage.setItem("loginOK", "yes");
                                var user = "<?php echo $username; ?>";
                                localStorage.setItem("username", user);
                                window.location.href = "index.php";
                            </script>
                            <?php
                        }
                    }
                    else if($resultID->num_rows<1){
                        ?><script>var id = document.getElementById("id");
                            id.style.display="block";</script><?php
                    }
                }
            else{
                ?><script>var username = document.getElementById("username");
                    username.style.display="block";</script> <?php
            }
        }
        ?>
    </div>
</div>

<div id="loggedIn" class="modal">
    <div class="modal-content">
        <button class="btn" id="spanDelete" onclick="document.getElementById('loggedIn').style.display='none';window.location.href='index.php'">&times;</button>
        <p>You are already logged in!</p>
    </div>
</div>

<br>

<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>

<script>
    function checkAlreadyLoggedIn(){
        var loggedIn = document.getElementById("loggedIn");
        if(localStorage.getItem("loginOK")==="yes"){
            if(localStorage.getItem("username")!=="unknownUser" || localStorage.getItem("username")!==""){
                loggedIn.style.display="block";
            }
        }
    }
</script>
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


