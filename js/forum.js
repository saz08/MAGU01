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
    console.log("going to delete" + pos);
    jQuery.post("deleteForumPost.php", {"Position": pos}, function(data){
        window.location.href="talk.php";
    }).fail(function()
    {
        document.getElementById("delete").style.display="block";
    });
}


function deleteComment(comment){
    jQuery.post("deleteComment.php", {"Comment":comment}, function(data){
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