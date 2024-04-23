mkdir videos comments ffmpeg videos/hls videos/mp4 logs
touch videos/videos.csv videos/index.html comments/index.html
sudo chmod -R 777 comments videos logs
sudo apt install unzip screen -y
wget https://github.com/ffbinaries/ffbinaries-prebuilt/releases/download/v6.1/ffmpeg-6.1-linux-64.zip
cd ffmpeg
unzip ../ffmpeg-6.1-linux-64.zip
rm ../ffmpeg-6.1-linux-64.zip