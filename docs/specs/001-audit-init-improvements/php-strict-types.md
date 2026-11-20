# Strict Types in PHP

## Context

The audit found that all 61 tracked PHP files lack `declare(strict_types=1);`. The rule is already documented in `AGENTS.md`, but is not yet applied in the code.

## Expected Behavior

Tracked PHP code consistently enables strict typing without changing logic, unrelated formatting, or application behavior.

## Out of Scope

- Changing method signatures, names, enums, or responsibilities.
- PHP files in `vendor/`, ignored local scripts, and generated artifacts.
- Configuring PHPStan; that work is specified in [`phpstan-level-9.md`](phpstan-level-9.md).

## Acceptance Criteria

- Given any of the 61 tracked PHP files, when this specification is implemented, then `declare(strict_types=1);` appears immediately after `<?php` and before any namespace or executable statement.
- Given a file with an opening comment or namespace declaration, when the declaration is added, then valid PHP syntax and the file's existing style are preserved.
- Given the diff for this task, when it is reviewed, then strict-types declarations are the only functional changes and no files outside the inventory are modified.
- Given the project's Docker environment, when `make test` is run, then the test suite still passes.

## File Ownership and Order

This is the initial, sequential phase. It covers all 61 tracked PHP files in `src/`, `app/`, and `tests/` and must be integrated before the two parallel cleanup tasks begin.
