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
- For code structure and development conventions, see [AGENTS.md](./AGENTS.md).

## 🖇️ API ROUTES 
- `PUT http://localhost:33000/api/products/{productId}` (create a product with a client-provided UUID)
- `GET http://localhost:33000/api/products/10000000-0000-4000-8000-000000000001` (product by UUID)
- `GET http://localhost:33000/api/products-with-discounts` (All products)
- `GET http://localhost:33000/api/products-with-discounts?filterByCategory=boots` (filter by category)

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


Create a product with `PUT /api/products/{productId}` and JSON body
`{"sku":"new-sku","name":"Product","category":"boots","price":12345}`.
Price is a positive integer in the smallest currency unit. Success returns `201` and a
`Location` header; invalid input returns `400`, and a duplicate UUID or SKU returns `409`.
The in-memory repository does not persist changes between requests.


