## ​Laravel & Stisla Starter Kit

​Starter Kit (or some thing like boilerplate)

## Server Requirements
- PHP >= 7.0.
- BCMath PHP Extension.
- Ctype PHP Extension.
- Fileinfo PHP extension.
- JSON PHP Extension.
- Mbstring PHP Extension.
- OpenSSL PHP Extension.
- PDO PHP Extension.
- Tokenizer PHP Extension.
- XML PHP Extension.

## Installation
1. Clone
	- git clone https://github.com/ari-dwiputra/laravel-stisla.git
2. Install Depedency
	- composer install
3. Setup Environment Variable
	- cp .env.example .env
	- php artisan key:generate
4. Migrate & Seed
	- php artisan migrate --seed
5. Run Local Dev Server
	- php artisan serve