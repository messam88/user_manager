#User Manager

demo application for user manager using admin area and simple restfull apis.


## install

    1 - git clone project_url(ssh or https)
    2 - cd user_manager
    3 - php composer.phar install
    4 - bin/console doctrine:schema:create
    5 - bin/console assets:install
    6 - from browser go to user_manager_url web/app_dev.php


####Database

    excute  /user_manager/docs/user_manager_data_base.sql with a test admin username: test & password: testtest.
    OR
    from browser go to user_manager_url/register to create new admin.


####API

    check /user_manager/docs/api.txt for full api map.
    to test and try all apis from browser go to user_manager_url web/app_dev.php then click on API whci will redirect to /api/doc.