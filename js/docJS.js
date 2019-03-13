if(localStorage.getItem("loginOKDoc")===null){
    localStorage.setItem("loginOKDoc", "no");
    window.location.href="docSignUp.php";
}

if(localStorage.getItem("loginOKDoc")==="no"){
    window.location.href="docSignUp.php";
}


if(localStorage.getItem("username")==="unknownUser"){
    alert("You must be logged in to continue");
    window.location.href="docSignUp.php"
}
function openNavWChart() {
    if(screen.width<500){

        document.getElementById("mySidebar").style.width = "100%";

    }
    if(screen.width>500){
        document.getElementById("mySidebar").style.width = "50%";

    }
}

function closeNavWChart() {
    document.getElementById("mySidebar").style.width = "0";
}

function openInfo(){
    var info =document.getElementById("info");
    if(info.style.display==="none"){
        info.style.display="block";
    }
    else{
        info.style.display="none";
    }
}

//Alerts
window.onclick = function(event) {
    if (event.target === sent) {
        sent.style.display = "none";
    }
    if (event.target === notSent) {
        notSent.style.display = "none";
    }

};