# DIM Symfony Project : Game Collection

This is a Symfony learning project made during DIM school year.

The website is a big game storage. User can collect register their game, sell them or just expose it colleciton. If you search a game search from offer or made a request.

## Installation

Launch the following command :
```shell script
composer install

# install database 
php bin/console d:d:c 
php bin/console d:m:m 

# init webpack
nmp install
npm run build # init assets
```

You can also populate the database with the IGDB Api. First create an account and get your own `user-key`. 
Create a `.env.local` file and paste your `user-key` in the <user-key> balise like below.
````.dotenv
IGDB_USER_KEY=<user-key>
````

Then launch in your shell the command
````shell script
php bin/console d:f:l
npm run prod # to build the new assets
````

If there is error check your credential key.
    
