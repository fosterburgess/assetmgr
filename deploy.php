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

task('npm:install-build', function () {
    writeln(run('pwd'));
    writeln(run('chmod a+x ~/.nvm/nvm.sh'));
    writeln(run('{{release_or_current_path}}/../../../.nvm/nvm.sh'));
    writeln(run('{{release_or_current_path}}/../../../.nvm/nvm.sh install v18.15.0'));
    writeln(run('{{release_or_current_path}}/../../../.nvm/nvm.sh use v18.15.0'));
    writeln(run("cd {{release_or_current_path}} && npm install "));
    writeln(run("cd {{release_or_current_path}} && /home/assets/.nvm/versions/node/v18.15.0/bin/node -v "));
    writeln(run("cd {{release_or_current_path}} && /home/assets/.nvm/versions/node/v18.15.0/bin/node ./node_modules/.bin/vite build "));
});

after('deploy', 'npm:install-build');


after('deploy:failed', 'deploy:unlock');
