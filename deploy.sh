#!/bin/bash
npm run build
$HOME/.config/composer/vendor/bin/dep deploy
rsync -pr public/* dh_7nbyjq@qaqatua.com:~/qaqatua.com/releases/current/public/

