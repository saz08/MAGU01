if(localStorage.getItem("loginOK")===null){
    localStorage.setItem("loginOK", "no");
}

if(localStorage.getItem("loginOKDoc")===null){
    localStorage.setItem("loginOKDoc","no");
}

if(localStorage.getItem("loginOK")==="no"&&localStorage.getItem("loginOKDoc")==="no"){
    localStorage.setItem("username","unknownUser");
    window.location.href="signUp.php";
}


if(localStorage.getItem("username")==="unknownUser"){
    window.location.href="signUp.php";
}

//TALK
function deletePost(posDB){
    // var user = username;
    var pos = posDB;
    jQuery.post("deleteForumPost.php", {"Position": pos}, function(data){
        window.location.href="talk.php";
    }).fail(function()
    {
        document.getElementById("delete").style.display="block";
    });
}


function deleteComment(comment){
    var com = comment;

    jQuery.post("deleteComment.php", {"Comment":com}, function(data){
        window.location.href="talk.php";
    }).fail(function()
    {
        document.getElementById("delete").style.display="block";
    });
}

function showCommentOption(divID) {
    var x = document.getElementById("content_"+divID);
    console.log("div id " + divID );
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}