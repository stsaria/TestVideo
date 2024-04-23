#!/usr/bin/bash
php -S 0.0.0.0:8000 -t ./html/ -d upload_max_filesize=2048M -d post_max_size=1024M -d memory_limit=1024M 2>> logs/php.log