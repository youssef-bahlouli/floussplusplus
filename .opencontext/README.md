# .opencontext/ — AI Session Handoff System

**Purpose:** Give every AI that enters this project the full context of what happened before, so work continues seamlessly across sessions.

## For Humans

To start a new session, tell the AI:

> Read .opencontext/CONTEXT.md then the other .opencontext/ files in order, then continue based on tasks.md and bugs.md.

The AI will read its memory, understand the project state, and pick up where the last session left off.

## For AIs

This folder is your memory. Read `CONTEXT.md` first — it contains the full protocol. The short version:

1. **Read** all files to understand state
2. **Update** as you work (tasks, bugs, decisions)
3. **Write** a session log entry before leaving

The next AI after you will thank you.
