# Pau Garcia -> Catalog promotions

## 📚 Made with
- PHP 8.1
- DDD
- Hexagonal Architecture (Ports & Adapters)
- CQRS
- Docker

## 🚀 Main Instructions 
- Launch docker containers: `docker-compose up -d`
- On the first run, install dependencies: `docker-compose exec php-fpm bash` and then `composer install`

## 🖇️ API ROUTES 
- http://localhost:33000/api/products-with-discounts (All products)
- http://localhost:33000/api/products-with-discounts?filterByCategory=boots (filter by category)

## TESTS
- For launch tests `docker-compose exec php-fpm bash` and then `vendor/bin/phpunit --testdox`

## EXPLANATIONS ON DECISIONS
- 
