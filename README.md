## Installation

1. Run `composer install` to install the library.
2. Run `composer require tcg/voyager` to install Voyager.
3. Run `php artisan voyager:install --with-dummy` to install Voyager with dummy data.

## Model Recommendation System

* Download the model file from [bit.ly/mrs_phatsoo](https://bit.ly/mrs_phatsoo) and save it to the `storage` directory.
* Run the following commands to get the Movies API data in sequence:
php artisan get:genres
php artisan get:movies
php artisan get:actors
php artisan get:countries
php artisan get:crews
php artisan get:keywords
php artisan get:reviews
php artisan get:trailers
php artisan fake:histories
php artisan fake:rates
php artisan fake:wishlist
