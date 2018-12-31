<!DOCTYPE HTML>
<html>
        <?php
session_start();
if (!$_SESSION['register']==1){
    header('Location: logout.php');

}
if ($_GET['q']==0){
    echo "Upload 10 pictures. (Click on Snap 10 times)";
}
if ($_GET['q']==2){
    $_SESSION['counter']=10;
    echo "Upload ".$_SESSION['counter']. " pictures then Click Submit.";
}
if ($_GET['q']==1){
    echo "Upload ".$_SESSION['counter']. " pictures then Click Submit.";
}

?>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Register</title>
    </head>
    <body>

        <video id="video" width="500" height="500" autoplay></video>
        <button id="snap">Snap Photo</button>

        <canvas width="500" height="500" id="canvas">canvas</canvas>
        <script type="text/javascript">
            window.onload = function() {

                var video = document.getElementById('video');

// Get access to the camera!
                if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    // Not adding `{ audio: true }` since we only want video now
                    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
        //video.src = window.URL.createObjectURL(stream);
                        video.srcObject = stream;
                        video.play();
                    });
                }

/* Legacy code below: getUserMedia 
else if(navigator.getUserMedia) { // Standard
    navigator.getUserMedia({ video: true }, function(stream) {
        video.src = stream;
        video.play();
    }, errBack);
} else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
    navigator.webkitGetUserMedia({ video: true }, function(stream){
        video.src = window.webkitURL.createObjectURL(stream);
        video.play();
    }, errBack);
} else if(navigator.mozGetUserMedia) { // Mozilla-prefixed
    navigator.mozGetUserMedia({ video: true }, function(stream){
        video.srcObject = stream;
        video.play();
    }, errBack);
}
*/
                // Elements for taking the snapshot
            var canvas = document.getElementById('canvas');
            var context = canvas.getContext('2d');
            var video = document.getElementById('video');

// Trigger photo take
            document.getElementById("snap").addEventListener("click", function() {
            context.drawImage(video, 0, 0, 640, 480);
            uploadEx();
            });

            video.srcObject = null;

        }
        </script>
 
    <!--     <div>
            <input type="button" onclick="uploadEx()" value="Upload" />
        </div>
 -->
 
        <form method="post" accept-charset="utf-8" name="form1">
            <input name="hidden_data" id='hidden_data' type="hidden"/>
        </form>

         <div>
            <a class="btn btn-primary" href="runner.php" role="button">Submit</a>
        </div>
 
        <script>
            function uploadEx() {
                var pathArray = window.location.search.split('=');
                var secondLevelLocation = pathArray[1];
                console.log(secondLevelLocation);
                var canvas = document.getElementById("canvas");
                var dataURL = canvas.toDataURL("image/png");
                document.getElementById('hidden_data').value = dataURL;
                var fd = new FormData(document.forms["form1"]);
 
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'upload_reg.php', true);
 
                xhr.upload.onprogress = function(e) {
                    if (e.lengthComputable) {
                        var percentComplete = (e.loaded / e.total) * 100;
                        console.log(percentComplete + '% uploaded');
                        if (this.responseText == '1')
                            alert('Succesfully uploaded');
                    }
                };
                xhr.send(fd);
            };
        </script>
    </body>
</html>