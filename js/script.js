if(localStorage.getItem("loginOK")===null){
    localStorage.setItem("loginOK", "no");
}

if(localStorage.getItem("loginOK")==="no"){
    window.location.href="signUp.php";
}




function goBack(){
    window.history.back();
}

//WEIGHT
function weightConverter(valNum) {
    document.getElementById("outputStones").innerHTML="Value in Stone: "+valNum*0.1574+" Stone";
}
function weightConverterKG(valNum) {
    document.getElementById("outputKilograms").innerHTML="Value in Kilogram: "+valNum/0.15747+"Kilogram";
}

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


function deleteComment(posID){
    var posComment = posID;
    jQuery.post("deleteComment.php", {"Position": posComment}, function(data){
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
