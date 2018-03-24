# Setup
## 1. Install postgres und postgis

With Debian as root:

    apt-get install postgresql postgis php-pgsql


## 2.  Create Database and User and install postgis

    su - postgres
    createuser dbuser
    createdb radschulwegplan

Open a SQL shell:

    psql -d radschulwegplan


and enter the following commands

    CREATE EXTENSION postgis;
    CREATE EXTENSION postgis_topology;
    ALTER USER dbuser with encrypted password 'secret1234';
    GRANT ALL privileges on database radschulwegplan to dbuser;

Press Strg-D to exit

##  3. Configure Symfony 

Checkout Git Repo


    composer install
    cp app/config/parameters.yml.dist app/config/parameters.yml

Edit  app/config/parameters.yml (DB Name, Password und User from step 2)

Create Schema:

    php bin/console doctrine:schema:create 

Create a user with role ROLE_ADMIN

    php bin/console fos:user:create testuser test@example.com p@ssword
    php bin/console fos:user:promote testuser ROLE_ADMIN


## 4.  Start Synmfony 

    php bin/console server:run


## 5. Api Documentation 

An Overview is visible at http://localhost:8000/api/v1/doc/

You have to fill in the login formular with the user data from step 3

## 6. Demo-Data

You can create deno data with:

    php bin/console doctrine:fixtures:load
