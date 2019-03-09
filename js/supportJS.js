if(localStorage.getItem("loginOKSupport")===null){
    localStorage.setItem("loginOKSupport", "no");
    window.location.href="supportSignUp.php";
}

if(localStorage.getItem("loginOKSupport")==="no"){
    window.location.href="supportSignUp.php";
}


if(localStorage.getItem("username")==="unknownUser"){
    alert("You must be logged in to continue");
    window.location.href="supportSignUp.php"
}




function markAndDelete(response){
    jQuery.post("supportMarkAsSeen.php", {"Response": response}, function(data){
        alert("Read and Deleted");
        window.location.href="supportDocFeedback.php";
    }).fail(function()
    {
        alert("something broke in submitting your records");
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

