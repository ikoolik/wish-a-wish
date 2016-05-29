@servers(['web' => 'web@128.199.59.199'])

@task('deploy')
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
