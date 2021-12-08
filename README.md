# gumboShrimp

## About gumboShrimp

An eCommerce application from the ground up, as it goes. This is a dirty stew of a playground. Beware.

### How to Use (WIP?)

1. when you click 'add item', the 'addItem' method dispatches an action which commits a mutation to CHANGE STATE === adds item to cart.
2. item gets added to cart (like you have), no double lines/entries
3. the cart icon at the top (on the navbar?) should have a number next to it, that shows how many items are in the cart (like a normal website).
4. when user clicks on 'cart' the router takes the user to CartComponent, which displays the items in the cart, with the ability to increase or decrease amounts

### Developer Setup (WIP)

1. Pull this repository
    - `git clone git@github.com:git@github.com:baldmike/gumboShrimp.git`
2. Copy `.env.example` file to `.env` and fill in necessary environment variables
    - `cp .env.example .env`
    - Populate `HOST_UID` with your user ID via `id -u`
3. Build your local images
    - `docker compose build`
4. Fire it up
    - `docker compose up -d`
5. Do the Composer dance
    - `docker compose exec php composer update`
    - `docker compose exec php composer install`
    - `docker compose exec php composer upgrade`
6. Do some Laravel stuff
    - `docker compose exec php php artisan key:generate`
    - `docker compose exec php php artisan migrate`
    - `docker compose exec php php artisan db:seed`
7. Run tests
    - `docker compose exec php ./vendor/bin/phpunit`
8. You'll need to make a symbolic link for the uploaded images.
    - get into your container `docker compose exec -it php sh`
    - cd into the public folder `cd public`
    - remove the existing storage folder `rm storage`
    - get back to root `cd ..`
    - create the symlink `php artisan storage:link`
    - exit out `exit`
## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

The gumboShrimp software is currently inheriting the [MIT license](https://opensource.org/licenses/MIT).
