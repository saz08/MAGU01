<?php
/**
 * Created by IntelliJ IDEA.
 * User: Jessica
 * Date: 04/04/2018
 * Time: 16:39
 */
session_start();
//Unset session variables.
$_SESSION = array();
if(ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), "", time() - 42000, $params["path"],$params["domain"],
        $params["secure"], $params["httponly"]);

}
session_destroy();
?>
<!doctype html>
<script>
    localStorage.setItem("loginOK", "no");
    localStorage.setItem("loginOKSupport", "no");
    localStorage.setItem("loginOKDoc","no");
    localStorage.setItem("username", "");
    localStorage.setItem("Breathlessness","");
    localStorage.setItem("Pain","");
    localStorage.setItem("Performance","");


</script>
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

    <link rel="stylesheet" type="text/css" href="../stylesheets/stylesheet.css">

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
<title>Log Out </title>

<div class="jumbotron" id="welcomeScreenJumbo" style="height: 100vh;">
    <div class="container" id="welcomeHeader">
        <h1 class="display-3" style="color:#f7f7f7;">Logout!</h1>
        <h3 style="margin-top: 20%">You are now logged out.</h3>
        <p><a href = "index.php" class="btn btn-primary btn-lg" id="signUpButton" role="button" >Back to Home Page</a></p>
    </div>
</div>
</div> <!-- / main container -->

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="../../dist/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
<script>
    document.cookie="calorieCookie="+0;
    document.cookie="distanceCookie="+0;
    document.cookie="scoreCookie="+0;
</script>
</body>
<div class="clear"></div>

<footer>

    <div class="footer">
        <p style="text-align: center;">&copy; Sara Reid Final Year Project 2019</p>
    </div></footer>
</html>

