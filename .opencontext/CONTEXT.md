# Context Handoff Protocol

This folder is this project's AI memory system. Any AI entering this project MUST follow this protocol.

## On Entry — Read these files in order:

1. `project.md` — Understand architecture, entry points, key files
2. `tasks.md` — See open issues, fixed bugs, remaining work
3. `bugs.md` — See all known bugs and their status
4. `sessions.md` — See what was done and what decisions were made
5. `README.md` — Folder overview

Then proceed based on `tasks.md` and `bugs.md`.

## During Session — You MUST update as you work:

| When | What to update |
|------|---------------|
| Fix a bug | Move it from `bugs.md` (Unfixed) to `bugs.md` (Fixed). Add to `tasks.md` (Fixed Bugs) |
| Complete a task | Mark it done in `tasks.md`. Add details of what was implemented |
| Make a decision | Log it in `sessions.md` (Decision Log) |
| Spot a new bug | Add it to `bugs.md` (Unfixed) |

## On Exit — Before the session ends, you MUST:

1. Write a new entry in `sessions.md` with what was done
2. Ensure `tasks.md` reflects all completed and remaining work
3. Ensure `bugs.md` is accurate (fixed vs unfixed)
4. Update `project.md` if architecture changed

## Why This Exists

Different AI sessions don't share memory. This folder bridges that gap. If you're an AI reading this, you are the continuation of previous work. Your job is to read, understand, then act — and leave the next AI a clear picture.
