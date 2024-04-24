<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="styles/style.css" rel="stylesheet" />
        <title>TestVideo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head>

    <?php include "header.html" ?>
    
    <body>
        <div class="container-fluid">
            <h2>どーがさいと</h2>
            <hr>
            <div style="text-align: center;">
                <h2>投稿</h2>
                <form action="post.php" method="post" enctype="multipart/form-data">
                    動画名 : <input type="text" name="upload_title" maxlength="20" required/><br>
                    動画ファイル : <input type="file" name="upload_video" required/></br>
                    概要欄(5行まで)</br>
                    <textarea name="upload_description" rows="8" cols="40" value="" maxlength="70" required></textarea></br>
                    <input type="submit" value="投稿"></br>
                </form>
                <h2 class="pt-2">動画リスト</h2>
            </div>
            <ul style="display: flex;">
                <?php include "../cgi-bin/videoList.php" ?>
            </ul>
        </div>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</html>