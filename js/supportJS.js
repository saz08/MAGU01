if(localStorage.getItem("loginOKSupport")===null){
    localStorage.setItem("loginOKSupport", "no");
    window.location.href="supportSignUp.php";

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

