# Esports Tournament Database Interface

A PHP/MySQL prototype for managing teams, players, matches, tournaments, sponsors and results through a browser-based database interface.

## Features
- Insert, update, delete, search and table browsing workflows.
- Relational queries joining player/team and match/team information.
- Role-selection interface for manager and player workflows.
- HTML forms and PHP-generated tables.

## Technology
PHP · MySQL (mysqli) · SQL · HTML · CSS

## Local development
The PHP scripts reference a local MySQL database. To recreate the environment, use a local PHP/MySQL installation and provide the required database schema. A schema export is not currently included in the repository.

## Limitations
This is a database interface prototype, not a production authentication or authorization system. The role selection does not authenticate user identities. Database configuration, query construction and access controls require hardening before deployment. Do not expose the application to untrusted traffic.
