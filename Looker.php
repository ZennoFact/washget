<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>Looker!!</title>
    <script src="./js/library/jquery-2.1.3.min.js"></script>
    <script src="https://skyway.io/dist/0.3/peer.js"></script>
  </head>
  <body>
    <video id="video_box" autoplay="autoplay" width="500px" height="250px">

    <script>
      navigator.getUserMedia = navigator.getUserMedia ||
                           navigator.webkitGetUserMedia ||
                           navigator.mozGetUserMedia ||
                           navigator.msGetUserMedia;
      var peer = new Peer({key: '876ca18a-846a-44e0-bd95-47f08084549e'});
      peer.on("error", function(e) {
        console.log(e);
      });

      navigator.getUserMedia({audio: true, video: true}, function (stream) {
        console.log(peer);
        console.log(stream);
        var call = peer.call("256", stream);
        console.log(call);

        call.on("stream", function (talk_stream) {
          $("#video_box").attr("src", URL.createObjectURL(talk_stream));
        });
      }, function(error){});
    </script>
  </body>
</html>
