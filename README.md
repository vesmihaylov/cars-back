# Used Car Deals Platform - BACK END

This is the backend side of the used car deals platform. It's built on top of **Api Platform 3.1** and **Symfony 6.2**. It only supports bulgarian localization for now. Dockerization is planned in the future for the backend side and also the frontend side.

# Project initialization

    1. Have composer and git installed locally.
    2. Git clone the project.
    3. Create a new settings file ".env.local" for your local environment.
    4. Run composer install to install dependencies.
    5. Run (bin/console doctrine:database:create) "d:d:c" to create a new database.
    6. Run (bin/console doctrine:migrations:migrate) "d:m:m" to run the existing migrations.
    7. Run "symfony serve" to start the project.

    # Project initialization

# TBD

* JWT Authentication
* Different roles access for routes
