<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'my_project');

// Project repository
set('repository', 'git@github.com:hieudt-2054/docker-deployer-laravel.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 
set('keep_releases', 5);
set('branch', 'master');
set('default_stage', 'production');

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', [
    'src/storage',
    'src/bootstrap/cache',
]);

// Writable dirs by web server
add('writable_dirs', [
    'src/bootstrap/cache',
    'src/storage',
    'src/storage/app',
    'src/storage/app/public',
    'src/storage/framework',
    'src/storage/framework/cache',
    'src/storage/framework/sessions',
    'src/storage/framework/views',
    'src/storage/logs',
]);

// Writable dirs by web server 
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts

host('18.141.240.173')
    ->user('deploy')
    ->set('deploy_path', '~/{{application}}');    
    
// Tasks

// task('build', function () {
//     run('cd {{release_path}} && build');
// });

task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    // 'build-assets',
    // 'build-vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    // 'cleanup',
]);
// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

// before('deploy:symlink', 'artisan:migrate');

