# Catalog Domain Conventions

## Context

After strict types are added in the initial phase, convention cleanups remain in the Catalog domain and application:

- Variables up to three characters long appear in five PHP files under `src/`: product and discount commands, `ProductRepository`, `ProductSku`, and `ProductInMemoryRepository`.
- The duplicate-ID check is inline in `SaveProductApplicationService`, although an equivalent unused helper exists.
- The `Currency` enum uses the uppercase case `EUR`, contrary to the PascalCase rule; its external value `'EUR'` must remain unchanged.
- Nine files under `src/` do not end in LF: seven product exceptions, `ProductDiscount.php`, and `ProductDiscountRepository.php`. The four `src/Shared/Application/` contracts without LF are also owned by this workstream.

## Expected Behavior

Domain and application classes express the same business rules with descriptive names, no duplicate checks, and the required enum naming convention. Interfaces and entities retain their existing behavior.

## Out of Scope

- Changing routes, responses, or HTTP validation.
- Changing the string value `'EUR'` or adding currency resolution from external input.
- Installing/configuring PHPStan; that integration happens after this workstream.
- Modifying `app/**` or tests not explicitly assigned to this workstream.
- Restructuring layers or adding abstractions without a demonstrated need.

## Acceptance Criteria

- Given an identifier up to three characters long in the `src/` files listed below, when it is renamed, then the descriptive name is used consistently in its declaration and all usages; in particular, `$sku` becomes `$productSku`.
- Given the duplicate-ID check in `SaveProductApplicationService`, when the logic is consolidated, then the check runs only once and products with duplicate IDs or SKUs continue to be rejected.
- Given `Currency`, when its case is changed to PascalCase, then it becomes `Eur`, retains the string value `'EUR'`, and public comparisons/serialization continue to emit `'EUR'`.
- Given `tests/Shared/Domain/ValueObjects/CurrencyTest.php`, when the enum case is renamed, then its references are updated and expectations for the value and `tryFrom()` continue to pass.
- Given an affected PHP file under `src/`, when the change is complete, then the file ends in LF and contains no unrelated formatting changes.
- Given the suite running in Docker, when the existing domain and application tests are run, then they pass without observable behavior changes.

## File Ownership

This workstream can run in parallel with `delivery-and-test-conventions.md`, but only after `php-strict-types.md` is integrated.

Owner of all `src/**` files and these tests, if they need updates:

- `tests/Shared/Domain/ValueObjects/CurrencyTest.php`
- `tests/Product/Domain/ProductTest.php`
- `tests/Product/Application/Commands/SaveProductBehaviourTest.php`

Short identifiers in this workstream appear in:

- `src/Product/Application/Commands/SaveProduct/SaveProductCommand.php`
- `src/Product/Application/Commands/SaveProductDiscount/SaveProductDiscountCommand.php`
- `src/Product/Domain/Repository/ProductRepository.php`
- `src/Product/Domain/ValueObjects/ProductSku.php`
- `src/Product/Infrastructure/Persistence/Memory/ProductInMemoryRepository.php`

The `src/` files that need a final LF are:

- `src/Product/Domain/Exceptions/InvalidDiscountPercentageException.php`
- `src/Product/Domain/Exceptions/InvalidProductCategoryException.php`
- `src/Product/Domain/Exceptions/InvalidProductDiscountException.php`
- `src/Product/Domain/Exceptions/InvalidProductNameException.php`
- `src/Product/Domain/Exceptions/InvalidProductPriceDiscountPercentageException.php`
- `src/Product/Domain/Exceptions/InvalidProductPriceException.php`
- `src/Product/Domain/Exceptions/InvalidProductSkuException.php`
- `src/Product/Domain/ProductDiscount.php`
- `src/Product/Domain/Repository/ProductDiscountRepository.php`
- `src/Shared/Application/Command.php`
- `src/Shared/Application/CommandHandler.php`
- `src/Shared/Application/Query.php`
- `src/Shared/Application/QueryHandler.php`
