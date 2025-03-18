#!/bin/bash
npm run build
npm run docs:build
php artisan l5-swagger:generate
$HOME/.config/composer/vendor/bin/dep deploy
rsync -pr public/* dh_7nbyjq@qaqatua.com:~/qaqatua.com/releases/current/public/

