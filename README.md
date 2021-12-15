# Configuration


# CQRS model


# Статусы:


# Тесты:

    composer install --dev
### run all tests
    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests --teamcity

### run personal test for example testPost
    /usr/bin/php vendor/phpunit/phpunit/phpunit --bootstrap src/Tests/bootstrap.php --configuration phpunit.xml.dist src/Tests/Functional/Controller/TypeApiControllerTest.php --filter "/::testPost( .*)?$/" 

