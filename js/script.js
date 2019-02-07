if(localStorage.getItem("loginOK")===null){
    localStorage.setItem("loginOK", "no");
}

if(localStorage.getItem("loginOK")==="no"){
    window.location.href="signUp.php";
}




function goBack(){
    window.history.back();
}

function weightConverter(valNum) {
    document.getElementById("outputStones").innerHTML="Converted value: "+valNum*0.1574+" LBS";
}
function weightConverterKG(valNum) {
    document.getElementById("outputKilograms").innerHTML="Converted value: "+valNum/0.15747+"KG";
}

