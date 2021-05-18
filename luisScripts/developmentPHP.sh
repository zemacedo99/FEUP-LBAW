#!/bin/bash
php artisan optimize:clear
php artisan optimize
yes |php artisan db:seed
php artisan serve
