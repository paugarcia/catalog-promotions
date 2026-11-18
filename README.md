# Pau Garcia -> Catalog promotions

## 📚 Made with
- PHP 8.4
- DDD
- Hexagonal Architecture (Ports and Adapters)
- CQRS
- Docker
- Testing with PHPUnit

## 🚀 Main Instructions 
- Install and start Docker Desktop (or another Docker Engine with Compose v2). PHP and Composer run inside the container; no host installation is required.
- Build and start the project: `make up`
- Stop the project: `make down`
- See all available commands: `make help`

## 🖇️ API ROUTES 
- http://localhost:33000/api/products-with-discounts (All products)
- http://localhost:33000/api/products-with-discounts?filterByCategory=boots (filter by category)

## TESTS
- Run the complete suite: `make test`
- Generate an HTML coverage report in `build/test/phpunit/`: `make coverage-html`

## EXPLANATIONS ON DECISIONS
- I had used Symfony for developing a simple API product/discounts, and the response from them is a list of product with discounts applied.
- I use a simple Docker environment (Nginx and PHP-FPM) to run the project.
- The application currently uses in-memory repositories for persistence.
- I had created all structure with Hexagonal Architecture and DDD, with this technic separate our business rules with the rest of the code.
- One bounder context "Catalog" inside this have 3 entities (Product, ProductDiscount and ProductPriceSummary).
- I had used the CQRS pattern in our use cases (Commands and Queries), this helps us in test them.

