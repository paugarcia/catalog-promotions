# Development Specifications

An index of specification-driven initiatives. Each initiative has a stable ID, a status, and its own work plan.

## Initiatives

| ID | Initiative | Status | Summary |
|:---:|---|---|---|
| 001 | [Initial audit improvements](001-audit-init-improvements/README.md) | 📝 Specified | Split the work to meet `AGENTS.md` into incremental blocks. |

## Conventions

- **Numbering:** create each initiative in `NNN-short-feature-name/`, using the next available number (`001`, `002`, `003`, ...).
- **Structure:** include a `README.md` with the goal, status, and implementation order, plus one specification per work block.
- **Content:** each specification covers Context, Expected Behavior, Out of Scope, and Acceptance Criteria.
- **Parallel work:** define dependencies and file ownership; only mark tasks as parallel when they neither edit the same files nor depend on changes that have not yet been integrated.

### Statuses

| Status | Meaning |
|---|---|
| 💡 Proposed | An idea awaiting specification. |
| 📝 Specified | Scope and acceptance criteria are defined; implementation has not started. |
| 🚧 In Progress | Implementation has started. |
| ⛔ Blocked | Work cannot proceed; the reason is documented in the specification. |
| ✅ Completed | Acceptance criteria have been verified. |

Update the initiative status in this table as work progresses.
