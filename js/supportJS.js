if(localStorage.getItem("loginOKSupport")===null){
    localStorage.setItem("loginOKSupport", "no");
    window.location.href="supportSignUp.php";
}

if(localStorage.getItem("loginOKSupport")==="no"){
    window.location.href="supportSignUp.php";
}


function markAndDeleteInfo(response){
    jQuery.post("supportMarkAsSeen.php", {"Response": response}, function(data){
        document.getElementById("deleted").style.display="block";
    }).fail(function()
    {
        document.getElementById("notDelete").style.display="block";
    });
}

function markAndDeleteSymp(response){
    jQuery.post("supportMarkSymp.php", {"Response": response}, function(data){
        document.getElementById("deleted").style.display="block";
    }).fail(function()
    {
        document.getElementById("notDelete").style.display="block";
    });
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

//GLOSSARY
function openGlossaryNav() {
    if(screen.width<500){
        document.getElementById("x").style.width = "80%";
        document.getElementById("x").style.left = "20%";
        document.getElementById("mySidebar").style.width = "5.5rem";

    }
    if(screen.width>500){
        document.getElementById("mySidebar").style.width = "7rem";

    }
}

function closeGlossaryNav() {
    if(screen.width<500){
        document.getElementById("x").style.left = "0";
        document.getElementById("x").style.width = "100%";
    }
    if(screen.width>500) {
        document.getElementById("x").style.left = "20%";
        document.getElementById("x").style.width = "50%";
    }
    document.getElementById("mySidebar").style.width = "0";
}

//SUPPORT HOME CHARTS
function openColourNav() {
    if(screen.width<500){
        document.getElementById("mySidebar").style.width = "90%";
    }
    if(screen.width>500){
        document.getElementById("mySidebar").style.width = "30%";

    }
}

function closeColourNav() {
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

