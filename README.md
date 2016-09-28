# shiny-fiesta
Web Application Development Assignment 1

## bug-free-potato
Used [this](https://github.com/TimurKiyivinski/bug-free-potato) library for database operations.

## usage
Run `docker-compose up -d` to bring up Apache then `docker-compose exec apache docker-php-ext-install mysqli` to install mysqli extensions.
Restarting the server may be required after this, `docker-compose restart`.
