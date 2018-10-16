#!/bin/sh
php artisan db:seed --class=ArticleSeeder
php artisan db:seed --class=TaxasSeeder
php artisan db:seed --class=SpeciesDetailSeeder
php artisan db:seed --class=ArticleSpecieSeeder
php artisan db:seed --class=AuthorSeeder
php artisan db:seed --class=MemberSeeder
php artisan db:seed --class=MerchandiseSeeder
php artisan db:seed --class=TagSeeder
php artisan db:seed --class=UsersSeeder
