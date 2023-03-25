<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:fosterburgess/assetmgr.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('assets.kimsal.com')
    ->set('remote_user', 'assets')
    ->set('public_path', 'public')
    ->set('php_version', '8.1')
//    ->set('become', 'root')
    ->set('sudo_password', 'assets#pa55')
    ->set('domain', 'assets.kimsal.com')
    ->set('db_type', 'mysql')
    ->set('db_user', 'assets')
    ->set('db_name', 'assets')
    ->set('db_password', 'assets#pa55')
    ->set('deploy_path', '~/public_html/');

// Hooks

after('deploy:failed', 'deploy:unlock');
