if(localStorage.getItem("loginOK")===null){
    localStorage.setItem("loginOK", "no");
}

if(localStorage.getItem("loginOK")==="no"){
    window.location.href="signUp.php";
}


if(localStorage.getItem("username")==="unknownUser"){
    alert("You must be logged in to continue");
    window.location.href="signUp.php"
}




//WEIGHT
function weightConverter(valNum) {
    document.getElementById("outputStones").innerHTML="<h2>Approximately "+(valNum*0.071429).toFixed(2)+" Stone</h2>";
}
// function weightConverter(valNum) {
//     document.getElementById("outputStones").innerHTML="<h2>Value in Stone: "+(valNum*0.1574).toFixed(2)+" Stone</h2>";
// }
// function weightConverterKG(valNum) {
//     document.getElementById("outputKilograms").innerHTML="<h2>Value in Kilogram: "+(valNum/0.15747).toFixed(2)+"Kilogram</h2>";
// }

//TALK
function deletePost(posDB){
    // var user = username;
    var pos = posDB;
    jQuery.post("deleteForumPost.php", {"Position": pos}, function(data){
        alert("Forum post deleted successfully");
        window.location.href="talk.php";
    }).fail(function()
    {
        alert("something broke in deleting your post");
    });
}


function deleteComment(comment){
    // var posComment = pos;
    var com = comment;

    jQuery.post("deleteComment.php", {"Comment":com}, function(data){
        alert("Comment deleted successfully");
        window.location.href="talk.php";
    }).fail(function()
    {
        alert("something broke in deleting your comment");
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

function markAndDelete(response){
    jQuery.post("markAsSeen.php", {"Response": response}, function(data){
        alert("Read and Deleted");
        window.location.href="index.php";
    }).fail(function()
    {
        alert("something broke in submitting your records");
    });
}

