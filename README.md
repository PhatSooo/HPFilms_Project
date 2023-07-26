# Installation

1. Install the library by running `composer install`.
2. Install Voyager by running `composer require tcg/voyager`.
3. Install Voyager with dummy data by running `php artisan voyager:install --with-dummy`.
4. Download the model file from [bit.ly/mrs_phatsoo](https://bit.ly/mrs_phatsoo) and save it to the `\storage` directory.
5. Access to TMDB and get API key, after that add it into `.env` file in `TMDB_API_KEY`
6. Get the Movies API data by running the following commands in sequence:
    - `php artisan get:genres`
    - `php artisan get:movies`
    - `php artisan get:actors`
    - `php artisan get:countries`
    - `php artisan get:crews`
    - `php artisan get:keywords`
    - `php artisan get:reviews`
    - `php artisan get:trailers`
    - `php artisan fake:histories`
    - `php artisan fake:rates`
    - `php artisan fake:wishlist`

# Model Recommendation System

1. Install the required Python libraries by running:
    - `pip install numpy`
    - `pip install scikit-learn`
    - `pip install "pandas<2.0.0"`
