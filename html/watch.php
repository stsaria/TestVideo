<?php
    include "../cgi-bin/etc.php";
    date_default_timezone_set('Asia/Tokyo');
    if(!isset($_GET["videoId"])){redirectBackPage();}
    else if (!file_exists("videos/hls/".$_GET["videoId"].".m3u8")){redirectBackPage();}
    include "../cgi-bin/watch.php";
?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?=$row[1]?></title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head>
    <body>
        <?php include "header.html" ?>
        <div class="container-fluid">
            <?php echo "<h1>".$row[1]."</h1>\n<pre>".$row[4]."</pre>" ?>
            <hr>
            <video controls id="hlsVideo" style="width: 50%;"></video>
            <script>
                if(Hls.isSupported()) {
                    var video = document.getElementById('hlsVideo');
                    var hls = new Hls();
                    hls.loadSource("videos/hls/<?=$_GET["videoId"]?>.m3u8");
                    hls.attachMedia(video);
                }
            </script>
            <hr>
            <h2>コメント</h2>
            <?php
                $commentFile = "../comments/".$_GET['videoId'].".csv";
                include "comment.php";
            ?>
            <form action="comment.php" method="GET", name="post-response">
            <input type="text" name="videoId" value="<?=$_GET['videoId']?>" readonly hidden required/>
            <span>名前 : </span><input type="text" name="name" id="name" maxlength="10"></br></br>
            <span>内容(五行まで)</span></br>
            <textarea name="contents" rows="8" cols="40" value="" maxlength="70"></textarea></br>
            <input type="submit" id="sbm_btn" oneclick="saveName();" value="投稿">
            </form>
            
            <script>
                var name = localStorage.getItem("name");
                if (name != "null"){document.getElementById("name").value = name;}
                $(document).ready(function(){
                    $('#sbm_btn').click(function(){
                        var name = $('#name').val();
                        localStorage.setItem("name", name);
                    });
                });
            </script>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</html>