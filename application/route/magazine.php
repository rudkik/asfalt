<?php

Route::set('bar', 'bar(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Magazine/Bar',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('accounting', 'accounting(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Magazine/Accounting',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('social', 'social(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Magazine/Social',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));