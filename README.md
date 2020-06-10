Monopoly
========

Installation
------------

1. Install Composer dependencies.
    ```bash
    $ composer install
    ```
2. Set up database connection in `bootstrap.php`.
3. Create database schema
    ```bash
   $ vendor/bin/doctrine orm:schema-tool:update --force 
   ```