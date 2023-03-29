<?php

Route::set('tax', 'tax(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Tax/Client',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('tax-admin', 'tax-admin(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Tax/Admin',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('client-tax', 'client-tax(/<action>(/<id>))')
    ->defaults(array(
        'directory' => 'Client',
        'controller' => 'Tax',
    ));