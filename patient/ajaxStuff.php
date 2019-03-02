<?php
?>
<!DOCTYPE html>
<html>
<body>

<h1>The XMLHttpRequest Object</h1>

<h3>Start typing a name in the input field below:</h3>

<form action="">
<button class="btn"  onclick="go()">HELLO</button>
</form>



<!--<script>-->
<!--    const Http = new XMLHttpRequest();-->
<!--    var url = "https://www.cancerresearchuk.org/about-cancer/lung-cancer/living-with/coping";-->
<!--    -->
<!--    Http.open("GET", url);-->
<!--    Http.send();-->
<!--    Http.onreadystatechange = (e) =>-->
<!--    {-->
<!--        console.log(Http.responseText);-->
<!--        obj = JSON.parse(Http.responseText);-->
<!--        console.log(obj);-->
<!--    }-->

<!--</script>-->

<script>
    function go() {
        const request = new XMLHttpRequest();
        const url = "https://www.cancerresearchuk.org/about-cancer/lung-cancer/living-with/coping";

        if(request){
            request.open('GET', url, true);
//            request.onreadystatechange = handler;
            request.onreadystatechange = (e) =>
            {
                request.send();

            }
            console.log("data "+ request.responseText);
        }
//        request.open("GET", url,true);
//        request.send();
//        request.onreadystatechange = function () {
//                obj = JSON.parse(request.responseText);
//                console.log("data is"+ obj);

        };
        //    request.send();
    //}

</script>



<!--<script>-->
<!--    // Create the XHR object.-->
<!--    function createCORSRequest(method, url) {-->
<!--        var xhr = new XMLHttpRequest();-->
<!--        if ("withCredentials" in xhr) {-->
<!--            // XHR for Chrome/Firefox/Opera/Safari.-->
<!--            xhr.open(method, url, true);-->
<!--        } else if (typeof XDomainRequest != "undefined") {-->
<!--            // XDomainRequest for IE.-->
<!--            xhr = new XDomainRequest();-->
<!--            xhr.open(method, url);-->
<!--        } else {-->
<!--            // CORS not supported.-->
<!--            xhr = null;-->
<!--        }-->
<!--        return xhr;-->
<!--    }-->
<!---->
<!--    // Helper method to parse the title tag from the response.-->
<!--//    function getTitle(text) {-->
<!--//        return text.match('<title>(.*)?</title>')[1];-->
<!--//    }-->
<!---->
<!--    // Make the actual CORS request.-->
<!--    function makeCorsRequest() {-->
<!--        // This is a sample server that supports CORS.-->
<!--        var url = 'https://www.cancerresearchuk.org/about-cancer/lung-cancer/living-with/coping';-->
<!---->
<!--        var xhr = createCORSRequest('GET', url);-->
<!--        xhr.open("GET",url);-->
<!---->
<!--        if (!xhr) {-->
<!--            alert('CORS not supported');-->
<!--            return;-->
<!--        }-->
<!---->
<!--        // Response handlers.-->
<!--        xhr.onload = function() {-->
<!--            var text = xhr.responseText;-->
<!--         //   var title = getTitle(text);-->
<!--          //  alert('Response from CORS request to ' + url);-->
<!--            console.log("title is"+ text);-->
<!--        };-->
<!---->
<!--        xhr.send();-->
<!--        xhr.onreadystatechange=(e)=>-->
<!--        {-->
<!--            console.log(xhr.responseText);-->
<!--            obj = JSON.parse(xhr.responseText);-->
<!--            console.log(obj);-->
<!--        }-->
<!---->
<!--        xhr.onerror = function() {-->
<!--            alert('Woops, there was an error making the request.');-->
<!--        };-->
<!---->
<!--        xhr.send();-->
<!--    }-->
<!--</script>-->
</body>

</html