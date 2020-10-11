# laravel-vue
### Setup
##### Prerequesities
npm version : 6.14.6 | php version: 7.2 | mysql version: 5.7.31
##### Clone the project
`git clone https://github.com/nikraz/laravel-vue.git`
##### Go to be/
`cd laravel-vue/be`
#### Setup .env file to connect to mysql.
##### To start the project run 
`composer install && php artisan migrate && php artisan db:seed && npm install && npm run dev && php artisan key:generate && php artisan serve`
###### Open browser at http://127.0.0.1:8000
