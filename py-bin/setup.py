import getpass, os

mkdir = ["logs/", "comments/", "videos/", "html/videos/", "html/videos/hls"]
mkfile = ["videos/videos.csv", "logs/php.log", "logs/python.log"]

systemdBase = """[Unit]
Description=TestVideo
After=network.target

[Service]

User={0}
Group={0}

WorkingDirectory={1}

Restart=always

ExecStart=bash start.sh

[Install]
WantedBy=multi-user.target""".format(getpass.getuser(), os.path.abspath("./"))

commands = """sudo apt update && sudo apt upgrade -y
sudo apt install php screen ffmpeg -y
pip install ffmpeg-python
sudo cp ./TestVideo.service /etc/systemd/system/TestVideo.service
systemctl daemon-reload"""

def main():
    for i in mkdir:
        os.makedirs(i, exist_ok=True)
    
    for i in mkfile:
        with open(i, mode="w"): pass
        
    with open("./TestVideo.service", mode="w") as fp:
        fp.write(systemdBase)
    
    for command in commands.split("\n"):
        os.system(command)
    
    print("""----- TestVideo Systemd -----
TestVideo Daemon : systemctl start/stop/enable TestVideo.service""")
    
    os.remove("TestVideo.service")

if __name__ == "__main__":
    main()