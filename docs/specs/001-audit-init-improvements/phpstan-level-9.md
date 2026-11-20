# PHPStan Level 9

## Context

`AGENTS.md` sets PHPStan level 9 as the target, but the project currently has no direct dependency, configuration, or analysis command. The audit cannot estimate the annotations or changes required until the tool is run.

This is an integration phase: begin only after the strict-types, domain, and delivery/test workstreams are integrated.

## Expected Behavior

The repository provides a repeatable static analysis at level 9 for maintained code. Analysis passes without lowering the level, hiding errors with broad exclusions, or changing application behavior.

## Out of Scope

- Switching to another PHPStan level or creating a baseline that silences the existing state.
- Analyzing `vendor/`, `var/`, or `build/`.
- Restructuring the domain or changing behavior to satisfy rules that are not actual defects.
- Running this phase in parallel with other specifications that may modify PHP files.

## Acceptance Criteria

- Given the project has no PHPStan configuration, when this phase is complete, then PHPStan is declared as a development dependency and locked in `composer.lock`.
- Given the maintained code in `src/`, `app/src/`, `app/public/`, and `tests/`, when analysis runs, then it uses level 9 and reports no diagnostics.
- Given a genuine diagnostic, when it is fixed, then the solution expresses the correct type/contract in the code; it does not lower the level or add broad exclusions or a baseline to hide it.
- Given the PHPStan configuration, when the documented command runs, then it analyzes the listed maintained paths and excludes dependencies and generated artifacts.
- Given `AGENTS.md`, when the tool is configured, then the temporary note that PHPStan is not yet configured is replaced with the exact analysis command, while retaining the level 9 standard.
- Given the completed integration, when `make test` and the PHPStan command run in Docker, then both succeed.
- Given the complete diff from the preceding specifications, when this phase is reviewed, then every additional PHP change is justified by specific PHPStan diagnostics and preserves existing behavior.

## File Ownership and Order

Run this phase alone at the end. Initial ownership:

- `composer.json`
- `composer.lock`
- New PHPStan configuration at the repository root
- `AGENTS.md`

If analysis requires PHP changes, document each affected file and the diagnostic that motivates it. Do not start until the preceding three specifications are integrated.
