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



//NAVBARS
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

//INDEX
function goToScale(){
    window.location.href="scale.php";
}
function goToWeight(){
    window.location.href="weight.php";
}
function goToPhysical(){
    window.location.href="physical.php";
}
function goToForum(){
    window.location.href="talk.php";
}
function goToQuestion(){
    window.location.href="questions.php";
}
function goToSupport(){
    window.location.href="supportCircle.php";
}

//PERFORMANCE
function submitPerformance(){
    if(document.getElementById('zero').checked){
        localStorage.setItem("Performance", "0");
    }
    if(document.getElementById('one').checked){
        localStorage.setItem("Performance", "1");
    }
    if(document.getElementById('two').checked){
        localStorage.setItem("Performance", "2");
    }
    if(document.getElementById('three').checked){
        localStorage.setItem("Performance", "3");
    }
    if(document.getElementById('four').checked){
        localStorage.setItem("Performance", "4");
    }

    window.location.href="additionalInfo.php";
}

//QUESTIONS
function deleteQ(questionNo){
    var qNo = questionNo;
    var del = document.getElementById("deleteQ");
    var noDel = document.getElementById("nodeleteQ");
    jQuery.post("deleteQ.php", {"questionNo": qNo}, function(data){
        del.style.display="block";
    }).fail(function()
    {
        noDel.style.display="block";
    });
}

//STATUS CHARTS
function openStatusNav() {
    if(screen.width<500){
        document.getElementById("mySidebar").style.width = "90%";
    }
    if(screen.width>500){
        document.getElementById("mySidebar").style.width = "30%";

    }
}

function closeStatusNav() {
    if(screen.width<500){
        document.getElementById("mySidebar").style.width = "0";

    }
    if(screen.width>500) {
        document.getElementById("mySidebar").style.width = "0";
    }
}

//FORUM
function searchForum() {
    var input = document.getElementById("myInput");
    var filter = input.value.toLowerCase();
    var forumPost = document.getElementsByClassName('forum');
    var comments = document.getElementsByClassName("comment");
    var noResults = document.getElementById("noResults");

    for (var x = 0; x < forumPost.length; x++) {
        var allPosts = forumPost[x].id.substr(10);
        document.getElementById(allPosts).style.display = "none";
        noResults.style.display="block";

    }

    for (var y = 0; y < forumPost.length; y++) {
        var showPost = forumPost[y].id.substr(10);
        if (forumPost[y].innerText.toLowerCase().includes(filter)) {
            document.getElementById(showPost).style.display = "block";
            noResults.style.display="none";
        }
    }
    for(var z = 0; z < comments.length; z++) {
        var showComment = comments[z].id.substr(8);
        if(comments[z].innerText.toLowerCase().includes(filter)){
            document.getElementById(showComment).style.display = "block";
            noResults.style.display="none";

        }
    }
}

// function checkPost() {
//     var post = document.getElementById("checkPost");
//     post.style.display = "block";
// }
// function checkComment(){
//     var comment = document.getElementById("checkComment");
//     comment.style.display="block";
// }


