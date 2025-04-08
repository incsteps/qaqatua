#!/bin/bash
npm run build
npm run docs:build
php artisan l5-swagger:generate

