# Chope Technical Assessment

### Framework & tools

- Lumen 6.0 (PHP framework)
- MySQL for data storage
- Redis for caching
- Composer (for installing dependencies)
- npm (for installing js dependencies - frontend)
- react js & redux (for client side rendering - frontend)
- Docker


### Installation
This is a dockerized application.

Make sure: 
* `docker` & `docker-compose` installed in your PC.

To do:

- Checkout and `cd project_directory/` to go to the project root directory.
- `sh ./start.sh` (will do installation)

- `docker-compose run --rm php vendor/bin/phpunit` for PHPUnit test
 
##### API url `http://localhost:8000`
##### Database manager(Adminer) `http://localhost:8080`
##### Frontend url `http://localhost:3000`

 
 ### CheckList
 
 - [x] Register API
 - [x] Login API
 - [x] Logout API
 - [x] Actions/Activity log API
 - [x] Frontend
 - [x] API doc
 - [x] Architecture diagram
 - [x] Class diagram
