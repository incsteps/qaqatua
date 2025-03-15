<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'ssh://dh_7nbyjq@qaqatua.com/~/qaqatua.com/git');


add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('qaqatua.com')
    ->set('http_user', 'dh_7nbyjq')
    ->set('http_group', 'pg2551540')
    ->set('remote_user', 'dh_7nbyjq')
    ->set('deploy_path', '~/qaqatua.com/releases');

// Hooks

after('deploy:failed', 'deploy:unlock');
