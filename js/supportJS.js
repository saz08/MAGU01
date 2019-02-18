

if(localStorage.getItem("loginOKSupport")===null){
    localStorage.setItem("loginOKSupport", "no");
    window.location.href="supportSignUp.php";

}

if(localStorage.getItem("loginOKSupport")==="no"){
    alert("You must be logged in to continue");
    window.location.href="supportSignUp.php";

}

if(localStorage.getItem("loginOK")==="yes"){
    localStorage.setItem("username","");
    localStorage.setItem("loginOK","no");
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

