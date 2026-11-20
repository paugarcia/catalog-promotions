# Working agreements

## Keep the design coherent

- Follow the existing Catalog structure: put business decisions with the domain, use application code to coordinate use cases, and keep delivery and persistence concerns in their adapters.
- Keep commands and queries on their separate paths. Extend the nearby project pattern before introducing a new abstraction or layer.
- Read the [README](./README.md) for setup, API behavior, and available commands instead of restating those details here.

## Write maintainable PHP

- Start every PHP file with `declare(strict_types=1);`.
- Give every method typed parameters and an explicit return type. The intended static-analysis bar is PHPStan level 9; it is not configured in this repository yet.
- Spell enum cases in PascalCase, reserving SCREAMING_SNAKE_CASE for class constants. For string-backed enums, use SCREAMING_SNAKE_CASE values and keep each value consistent with its case's meaning. Ensure code resolving external strings handles unsupported values, since `from()` raises `ValueError` when no case matches.
- Keep methods focused. When a method accumulates distinct steps, move them into small, semantically named methods; place each responsibility where it belongs rather than adding abstractions without a need.
- Use descriptive variable names longer than three characters; avoid abbreviations that hide what a value represents.
- Write code comments in English, and retain them only when they clarify something that the code cannot express well on its own.
- End PHP files with a blank line.
