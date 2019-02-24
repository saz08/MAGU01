if(localStorage.getItem("loginOKDoc")===null){
    localStorage.setItem("loginOKDoc", "no");
}

if(localStorage.getItem("loginOKDoc")==="no"){
    window.location.href="docSignUp.php";
}


if(localStorage.getItem("username")==="unknownUser"){
    alert("You must be logged in to continue");
    window.location.href="docSignUp.php"
}