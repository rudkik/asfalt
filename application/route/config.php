<?php
Route::set('config', 'config(/<controller>(/<action>))')
    ->defaults(array(
        'directory' => 'Config',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));