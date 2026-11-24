# Esports Tournament Database Interface

A PHP/MySQL prototype for managing teams, players, matches, tournaments, sponsors and results through a browser-based database interface.

## Features
- Insert, update, delete, search and table browsing workflows.
- Relational queries joining player/team and match/team information.
- Role-selection interface for manager and player workflows.
- HTML forms and PHP-generated tables.

## Technology
PHP · MySQL (mysqli) · SQL · HTML · CSS

## Local development and security

Provide the original MySQL database schema and set the environment variables described in [Security migration](SECURITY-MIGRATION.md). The revised demo requires password verification for the manager/player roles, validates table and column identifiers, uses parameterized SQL and checks authorization and CSRF on mutation routes. Update and deletion require all parts of the primary key.

This is shared-role demonstration authentication, not a production identity system. Integration testing requires the original database schema.
