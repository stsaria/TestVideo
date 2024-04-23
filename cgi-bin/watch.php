<?php
    $rows = [];
    $videoid = "";
    $fp = fopen("../videos/videos.csv", 'rb');
    if ($fp){
        if (flock($fp, LOCK_SH)){
            while ($row = fgetcsv($fp)) {
                $rows[] = $row;
            }
            foreach ($rows as $row){
                if ($row[0] == $_GET["videoId"]){
                    $videoid = $row[0];
                    break;
                }
            }
            if($videoid == "") {redirectBackPage();}
            flock($fp, LOCK_UN);
        } else {
            echo '<script>alert("File lock failed.");</script>';
        }
    } else {exit;}