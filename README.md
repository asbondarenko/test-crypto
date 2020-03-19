 README #

* Trading bay.
* Version 0.0.0

### Environment details ###

#### Dependencies
    1. php >=7.2
    2. laravel >=6.2
    3. npm
    4. mysql (postgres) 
    
#### Database configuration
    - DB: tradingbay
    - User: root
    - Pass: root

### Preparing to work ###
        
#### Summary of set up.
   1. Run php composer:
        - composer install
   1. Copy env.example to .env
   1. Configure .env file
   1. Generate application key:
        - php artisan key:generate
   1. Run migrations:
        - php artisan migrate
   1. Install npm dependencies: 
        - npm install
   1. Install admin panel:
        - npm install -g bower
        - bower install
        - php artisan vendor:publish --tag=Modules
        - npm run dev
   1. Install passport:
        - php artisan passport:install
        
#### Deployment instructions.
   1. If files on server have some necessary changes run:
        - git stash
   1. Update server git repository:
        - git pull
   1. To install composer dependencies always run:
        - composer install (not update)
   1. Run db migrations:
        - php artisan migrate
   1. Apply stashed changes if necessary:
        - git stash apply
   1. Run webpack assets optimization:
        - npm run prod    

### Contribution guidelines ###

* Writing tests
* Code review
* Other guidelines