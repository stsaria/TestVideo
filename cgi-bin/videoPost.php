<?php
    function guidv4($data = null) {
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    function postVideo(string $title, string $description, $file) {
        if (strlen($description) > 70){echo "Error : description > 70"; exit;}
        else if (strlen($title) > 14) {echo "Error : title > 14"; exit;}

        $description = str_replace("<br>", "", $description);
        
        if (count(explode("/",$description)) > 5){echo "Error : description lines > 5"; exit;}

        $videoId = guidv4();

        $fp = fopen("../videos/videos.csv", 'ab');
        if ($fp){
            if (flock($fp, LOCK_EX)){
                if (fputcsv($fp, [$videoId,
                    str_replace("'", "\"", $title), date("Y/m/d H:i"),
                    hash("fnv1a32", $_SERVER['REMOTE_ADDR']),
                    $description]
                ) === FALSE){   
                    echo '<script>alert("File write failed.");</script>';
                    exit;
                }
                flock($fp, LOCK_UN);
            }else{
                echo '<script>alert("File lock failed.");</script>';
                exit;
            }
        } else {exit;}
        fclose($fp);

        $result = move_uploaded_file($file['tmp_name'], "../videos/".$videoId.".mp4");
        if(!$result){
            echo "Upload Error : ".$file['upload_video']['error'];
            exit;
        }

        touch("../comments/".$videoId.".csv");

        exec("screen -DmS TestVideo-".$videoId." python3 ../py-bin/video.py ".$videoId." 2> ../logs/".$videoId.".log &");
    }