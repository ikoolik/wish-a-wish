@servers(['web' => 'web@128.199.59.199'])

@task('deploy')
    cd /var/www/wish
    php artisan down
    git pull origin master
    composer install
    php artisan migrate --force
    npm install
    ./node_modules/.bin/bower install
    ./node_modules/.bin/gulp
    php artisan up
@endtask

@task('down')
    cd /var/www/wish
    php artisan down
@endtask

@task('pull')
    cd /var/www/wish
    git pull origin master
@endtask

@task('composer')
    cd /var/www/wish
    composer install
@endtask

@task('migrate')
    cd /var/www/wish
    php artisan migrate --force
@endtask

@task('npm')
    cd /var/www/wish
    npm install
@endtask

@task('bower')
    cd /var/www/wish
    ./node_modules/.bin/bower install
@endtask

@task('gulp')
    cd /var/www/wish
    ./node_modules/.bin/gulp
@endtask

@task('up')
    cd /var/www/wish
    php artisan up
@endtask