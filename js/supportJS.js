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

