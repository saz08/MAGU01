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

//WEIGHT
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

//NAVBAR
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

//PATIENT INFO

function showCommentOption(counter) {
    var x = document.getElementById("content_"+counter);
    console.log("div id " + counter );
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

//PROGRESS
function openProgressNav() {
    if(screen.width<500){
        document.getElementById("mySidebar").style.width = "90%";
    }
    if(screen.width>500){
        document.getElementById("mySidebar").style.width = "30%";

    }
}

function closeProgressNav() {
    if(screen.width<500){
        document.getElementById("mySidebar").style.width = "0";

    }
    if(screen.width>500) {
        document.getElementById("mySidebar").style.width = "0";
    }
}

function openNumberNav() {
    if(screen.width<500){
        document.getElementById("mySidebar2").style.width = "90%";
    }
    if(screen.width>500){
        document.getElementById("mySidebar2").style.width = "30%";

    }
}

function closeNumberNav() {
    if(screen.width<500){
        document.getElementById("mySidebar2").style.width = "0";

    }
    if(screen.width>500) {
        document.getElementById("mySidebar2").style.width = "0";
    }
}