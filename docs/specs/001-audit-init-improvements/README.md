# AGENTS.md Compliance Improvements

These specifications break down the initial audit into small, verifiable tasks that agents can coordinate. Implement them on a new development branch based on `main`, without changing the API's public behavior.

## Work Order

1. **First, sequentially:** [`php-strict-types.md`](php-strict-types.md). This change touches all 61 tracked PHP files, so integrate it before starting parallel work.
2. **Then, in parallel and in separate branches/worktrees:**
   - [`catalog-domain-conventions.md`](catalog-domain-conventions.md), owning `src/**` and the domain tests listed in that specification.
   - [`delivery-and-test-conventions.md`](delivery-and-test-conventions.md), owning `app/**` and the remaining tests listed there.

   These tasks have disjoint file ownership. Do not expand into files owned by the other agent without coordinating first.
3. **Last, sequentially:** [`phpstan-level-9.md`](phpstan-level-9.md). This integration task may require changes across multiple areas, so start it only after both parallel workstreams are integrated.
4. Run final validation for all four specifications and review the complete diff before considering the feature done.

## Audit Baseline

- Inventory: 61 tracked PHP files (43 in `src/`, 7 in `app/`, 11 in `tests/`).
- No PHPStan configuration was found.
- Baseline Docker test suite: 25 tests and 49 assertions, passing.
- Host PHP is 7.3; use the Docker environment described in the README for validation.
- Dependencies, `var/`, `build/`, and ignored files are outside the inventory.

Each agent must follow the Context / Expected Behavior / Out of Scope / Acceptance Criteria template in its specification. If a rule or diagnostic requires an uncovered decision, update the specification and coordinate before editing shared files.
