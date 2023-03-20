# Getting started
This an API for a BookStore

# For implementation using Docker
N.B Make sure you have docker running on your system
1) Run git clone `link to repository` 
2) Run copy .env .env.example
3) Run ./vendor/bin/sail up -d 
4) Run ./vendor/bin/sail composer install
5) Run ./vendor/bin/sail artisan optimize:clear
6) Run ./vendor/bin/sail artisan migrate:fresh --seed
6) Run ./vendor/bin/sail artisan search:reindex

# For implementation on local machine
N.B Make sure you have an instance Elastic search client running on your system
1) Run git clone `link to repository` 
2) Run copy .env .env.example
3) Run composer install
4) Run php artisan optimize:clear
5) Run php artisan migrate:fresh --seed

# Notes
1) Set ELASTICSEARCH_ENABLED in .env to true to enable it and false to disable it
2) To perform unit tests, run php artisan test for local machine and ./vendor/bin/sail artisan test for docker
3) Go to http://localhost:8000/api/documentation to view the documentation.
4) If there is an error of "No alive nodes. All the %d nodes seem to be down." when implementing on docker, you can
    a) Disable elastic search by setting ELASTICSEARCH_ENABLED to false in .env
    b) Run the project without docker and make use of installed elastic search client
