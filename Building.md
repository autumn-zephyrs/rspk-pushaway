npm run build
docker compose up --build -d
attach shell to the server image
    - php artisan migrate
    - php artisan get:tournaments
                  get:decks
                  get:set-names
                  get:images
docker compose down (-v will kill the database volume)