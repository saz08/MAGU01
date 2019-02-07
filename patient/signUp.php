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
$loginOK = false; //TODO make this work with database values



?>
<!doctype html>
<script>if(localStorage.getItem("loginOK")===null){
        localStorage.setItem("loginOK", "no")
    }</script>
<script>
    function checkAlreadyLoggedIn(){
        if(localStorage.getItem("loginOK")==="yes"){
            alert("You are already logged in!");
            window.location.href = "index.php";
        }
    }
</script>



<?php



if($loginOK) {
    if (!isset($_SESSION["sessionuser"])) {
        session_regenerate_id();
        $_SESSION["sessionuser"] = $user;
    }
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
    <script src="../js/script.js"></script>

    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">

    <meta charset="UTF-8">
    <title>Project</title>

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
                <li><a href="signUp.php">SURVIVORS</a></li>
                <li><a href="../support/supportSignUp.php">SUPPORTERS</a></li>

            </ul>
        </div>
    </div>
</nav>

<div class="jumbotron text-center">
    <h1>HOMEPAGE <img src="../clipart2199929.png" alt="Lung Cancer Ribbon" height="50" width="50"></h1>
</div>

<!-- 3 columns under Welcome Jumbotron -->
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
                <p><input type="submit" name="submitLogon" id="loginButton"class="btn" value="Login"></p>
            </form>
            </p>
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
                ?>
                <script>
                    console.log("action is filled");
                </script>
            <?php
            $username= (safePost($conn,"username"));
            $password = (safePost($conn,"password"));
            $_SESSION['userName'] = $username;
            $query = "SELECT `username` FROM `account` WHERE `username` = '$username'";
            $result = mysqli_query($conn,$query);
            if(mysqli_num_rows($result)){
            $query2 = "SELECT `password` FROM `account` WHERE `password` = '$password'";
            $result2 = mysqli_query($conn,$query2);
            if(mysqli_num_rows($result2)){
            echo "<p class='center'>Log in was successful!</p>";
            $loginOK=true;
            ?> <script>localStorage.setItem("loginOK", "yes")</script>
                <script type="text/javascript">
                    var user = "<?php echo $username; ?>";
                </script>
                <script>localStorage.setItem("username", user);
                    window.location.href = "index.php";
                </script>
                <?php
                echo "<p class='center'><a href = 'index.php' class='btn ' role='button' >Go to Home!</a></p>";
            }
            else{
                ?><script>alert("Password not recognised")</script><?php
            }
            }
            else{
                ?><script>alert("Username not recognised")</script><?php
            }

            }
            ?>
        </div>

        <div class="col-md-6" id="registercol">
            <form name="register" method="post" onsubmit="return checkForm()" >
                <h2 style="color:black">Register</h2>
                <p class="lead" style="color:#f7f7f7;">
                <p>Create Username:<br> <input type="text" name="username" value="" id="username"/></p>
                <p>Create Password: <br><input type="password" name="password" value="" id="password"/></p>
                <p>Enter ID: <br><input type="number" name="id" value="" id="id"/></p>
                <p>Smoker Status <i>*Optional*</i></p>
                <input type="radio" name="smoker" value="smoker" id="smoker"> Current
                <input type="radio" name="smoker" value="nonsmoker" id="nonsmoker">Never
                <input type="hidden" name="action2" value="filled">
                <p><input type="submit" name="submitReg" id="signUpButton" class="btn" value="Register"></p>
                </p>
            </form>

        </div>

        <?php

        ?>
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
                    alert("The following need to be corrected: \n" + errs);
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
            $result = mysqli_query($conn,$query);
        if(mysqli_num_rows($result)) {
            ?><script>alert("Username Already in Use");</script> <?php
        echo "<p> * Username is already registered * ";
        }

            $query2 = "SELECT `username` FROM `supportAcc` WHERE `username` = '$username'";
            $result2 = $conn->query($query2);
            if($result2->num_rows>=1){
                ?><script>alert("Username Already in Use");</script> <?php
                echo "<p> * Username is already registered * ";
            }



            $checkID = "SELECT `id` FROM `chi` WHERE `id` = '$id'";
            $resultID = $conn->query($checkID);

//            $resultID = mysqli_query($conn,$checkID);
        if($resultID->num_rows<1) {
        ?><script>alert("ID does not exist");</script><?php
            echo "<p> * ID is not registered * ";

            }
//        if(mysqli_num_rows($resultID)) {
//            ?><!--<script>alert("Username Already in Use");</script> --><?php
//        echo "<p> * Username is already registered * ";
//        }


        $sql = "INSERT INTO `account` (`id`,`username`, `password`, `smokingStatus`) VALUES ('$id','$username', '$password', '$smoker1')";

        if ($conn->query($sql) === TRUE) {
        echo "<p class='center'>Registration was successful!</p>";
        $loginOK = true;
        ?>
            <script>localStorage.setItem("loginOK", "yes");
                var user = "<?php echo $username; ?>";
                localStorage.setItem("username", user)
                window.location.href = "index.php";
            </script>
            <?php
            echo "<p class='center'><a href = 'index.php' class='btn btn-primary btn-lg' id='goToMapButton' role='button' >Go to home!</a></p>";
        }




        }
        ?>

    </div>
    <hr>
    <input type="hidden" name="action" value="index.html">

</div> <!-- / main container -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
</body>
<div class="clear"></div>

<footer>
    <div class="footer">
        <p style="text-align: center;">&copy; Sara Reid Final Year Project 2019</p>
    </div></footer>
</html>

<?php
$conn->close();?>


