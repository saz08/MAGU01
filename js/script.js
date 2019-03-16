if(localStorage.getItem("loginOK")===null){
    localStorage.setItem("loginOK", "no");
    window.location.href="signUp.php";
}

if(localStorage.getItem("loginOK")==="no"){
    localStorage.setItem("username","unknownUser");
    window.location.href="signUp.php";
}


if(localStorage.getItem("username")==="unknownUser"){
   window.location.href="signUp.php";
}



//WEIGHT
function weightConverter(valNum) {
    document.getElementById("outputStones").innerHTML="<h2>Approximately "+(valNum*0.071429).toFixed(2)+" Stone</h2>";
}


//Alerts
window.onclick = function(event) {
    if (event.target === session) {
        session.style.display = "none";
        window.location.href="signUp.php";
    }

};

function openRecord(){
    var record =document.getElementById("record");
    if(record.style.display==="none"){
        record.style.display="block";
    }
    else{
        record.style.display="none";
    }
}
function openHelp(){
    var help =document.getElementById("help");
    if(help.style.display==="none"){
        help.style.display="block";
    }
    else{
        help.style.display="none";
    }
}
function openProfile(){
    var profile =document.getElementById("profile");
    if(profile.style.display==="none"){
        profile.style.display="block";
    }
    else{
        profile.style.display="none";
    }
}

function markAndDelete(response){
    jQuery.post("markAsSeen.php", {"Response": response}, function(data){
    document.getElementById("deleted").style.display="block";
    }).fail(function()
    {
        document.getElementById("notDelete").style.display="block";
    });
}


function openNavWeight() {
    if(screen.width<500){
        document.getElementById("x").style.width = "80%";
        document.getElementById("x").style.left = "20%";
        document.getElementById("stone").style.width = "80%";
        document.getElementById("stone").style.left = "20%";
        document.getElementById("mySidebar").style.width = "100%";

    }
    if(screen.width>500){
        document.getElementById("mySidebar").style.width = "20%";

    }
}

function closeNavWeight() {
    if(screen.width<500){
        document.getElementById("x").style.left = "0";
        document.getElementById("x").style.width = "100%";
        document.getElementById("stone").style.width = "100%";
        document.getElementById("stone").style.left = "0";
    }
    if(screen.width>500) {
        document.getElementById("x").style.left = "20%";
        document.getElementById("x").style.width = "50%";
        document.getElementById("stone").style.width = "50%";
        document.getElementById("stone").style.left = "20%";
    }
    document.getElementById("mySidebar").style.width = "0";
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



