# commify-homework

## Setup
    The project was made to use Docker Desktop on WSL2. It should work on any docker setup, but was only tested on WSL2.
    After starting the containers using docker-compose up, you need can use the http://localhost/salary-calculator.htm page.

### Tax brakets setup
    Either run php bin/console doctrine:fixtures:load or go to http://localhost/admin to manually add/edit the tax brakets.

## Notes
    The project is overengineered, and has some features that are useless. This is on purpose, to suggest solutions for a more complex application. 