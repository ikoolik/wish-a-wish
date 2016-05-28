@servers(['web' => 'web@128.199.59.199'])

@task('deploy')
    cd /var/www/wish
    git pull origin master
@endtask
