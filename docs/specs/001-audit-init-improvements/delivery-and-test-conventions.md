# Delivery and Test Conventions

## Context

After strict types are added in the initial phase, the audit found a small set of convention fixes in controllers, the entrypoint, and tests:

- Three controllers use `$e` for exception variables; two tests use short identifiers such as `$id`.
- Two test methods have no explicit return type (`testProductShouldBeSaved()` is assigned to the domain workstream; `CatalogTest::__construct()` belongs to this one).
- The closure in `app/public/index.php` has a typed parameter but no explicit return type.
- One PHP file under `tests/` does not end in LF: `tests/Shared/TestInfrastructure/CatalogTest.php`.

## Expected Behavior

HTTP adapters continue translating use cases into the same responses, and tests retain their existing scope and results. Signatures and identifiers are explicit and descriptive.

## Out of Scope

- Changing domain rules, repository state, or API responses.
- Modifying files under `src/**` or tests assigned to the domain workstream.
- Configuring PHPStan; configuration and remediation of findings happen in the final phase.
- Restructuring controllers or introducing new layers.

## Acceptance Criteria

- Given an exception caught as `$e` in an included controller, when it is renamed, then it becomes `$exception` in the declaration and every usage without changing the HTTP response.
- Given a short identifier in an included test, when it is renamed, then it describes the value (for example, `$id` becomes `$productId`) and all test references are updated.
- Given `CatalogTest::__construct()`, when its signature is completed, then it declares `: void` and Faker generator initialization continues to work.
- Given the closure in `app/public/index.php`, when its signature is completed, then it declares the correct return type (`Kernel`) and Symfony Runtime still creates the kernel without changing startup behavior.
- Given `tests/Shared/TestInfrastructure/CatalogTest.php`, when the change is complete, then the file ends in LF.
- Given the Docker test environment, when `make test` is run, then all existing tests pass without changes to routes or HTTP responses.

## File Ownership

This workstream can run in parallel with `catalog-domain-conventions.md`, but only after `php-strict-types.md` is integrated.

Owner of `app/**` and these tests; do not modify other tests:

- `tests/Product/Infrastructure/Http/CreateProductTest.php`
- `tests/Product/Infrastructure/Http/GetProductByIdTest.php`
- `tests/Product/Infrastructure/Http/GetProductsWithDiscountsTest.php`
- `tests/Product/Application/Queries/GetProductsWithDiscountsBehaviourTest.php`
- `tests/Product/Application/Queries/GetProductsWithDiscountsQueryTest.php`
- `tests/Product/Infrastructure/Persistence/Memory/ProductInMemoryRepositoryTest.php`
- `tests/Shared/TestInfrastructure/CatalogTest.php`
- `tests/bootstrap.php`

Short identifiers in this workstream appear in:

- `app/src/Controller/Catalog/Product/CreateProductController.php`
- `app/src/Controller/Catalog/Product/GetProductByIdController.php`
- `app/src/Controller/Catalog/Product/GetProductsWithDiscountsController.php`
- `tests/Product/Infrastructure/Http/CreateProductTest.php`
- `tests/Product/Infrastructure/Http/GetProductByIdTest.php`

The entrypoint closure is in `app/public/index.php`. `CatalogTest.php` is the only test file without a final LF; the three HTTP tests are listed because they contain the short identifiers found in the audit.
