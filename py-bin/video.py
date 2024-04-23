from os import chdir
from os.path import abspath, dirname

chdir(abspath(dirname(__file__)))

import ffmpeg, subprocess, sys, os

VIDEOID = sys.argv[1]

def ffmpegMp4ToHls(videoId : str):
    if os.path.isfile(f"../videos/{videoId}.mp4"):
        try:
            stream = ffmpeg.output(ffmpeg.input(f"../videos/{videoId}.mp4"), f'../html/videos/hls/{videoId}.m3u8', hls_time=10)
            ffmpeg.run(stream)
        except:
            return 1
    else:
        return 2
    return 0

def main(videoId : str):
    return ffmpegMp4ToHls(videoId)

if __name__ == "__main__":
    sys.exit(main(VIDEOID))