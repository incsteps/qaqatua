#!/bin/bash
sh build.sh
$HOME/.config/composer/vendor/bin/dep deploy
rsync -pr public/* dh_7nbyjq@qaqatua.com:~/qaqatua.com/releases/current/public/

