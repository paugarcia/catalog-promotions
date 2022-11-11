# Pau Garcia -> Catalog promotions

## 📚 Made with
- PHP 8.1
- DDD
- Hexagonal Architecture (Ports and Adapters)
- CQRS
- Docker
- Testing with PHPUnit

## 🚀 Main Instructions 
- Launch docker containers: `docker-compose up -d`
- On the first run, install dependencies: `docker-compose exec php-fpm bash` and then `composer install`

## 🖇️ API ROUTES 
- http://localhost:33000/api/products-with-discounts (All products)
- http://localhost:33000/api/products-with-discounts?filterByCategory=boots (filter by category)

## TESTS
- For launch tests `docker-compose exec php-fpm bash` and then `vendor/bin/phpunit --testdox`

## EXPLANATIONS ON DECISIONS
- I had used Symfony for developing a simple API product/discounts, and the response from them is a list of product with discounts applied.
- I use a simple docker (webserver nginx / php-fpm / mongo) for run the project.
- I decide to use the "in memory" DB for simply the functionality of this exercise, but in the project I developed Mongo repositories, because in the exercise say "You must take into aI decide use the "in memory" DB for simply the functionality of this exercise, but in the project i developed mongo repositories, because in the exercise say "You must take into account that this list could grow to have 20.000 products." and mongoDB maybe will be good option in this posibiliry.ccount that this list could grow to have 20.000 products." and mongoDB maybe will be a good option in this possibility.
- I had created all structure with Hexagonal Architecture and DDD, with this technic separate our business rules with the rest of the code.
- One bounder context "Catalog" inside this have 3 entities (Product, ProductDiscount and ProductPriceSummary).
- I had used the CQRS pattern in our use cases (Commands and Queries), this helps us in test them.

