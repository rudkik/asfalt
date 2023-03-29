<?php

Route::set('smmarket_customer', 'customer/<controller>/<action>(/<id>)')
    ->defaults(array(
        'directory' => 'SMMarket/Customer',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('smmarket_supplier', 'supplier/<controller>/<action>(/<id>)')
    ->defaults(array(
        'directory' => 'SMMarket/Supplier',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('smmarket_sadmin', 'sadmin/<controller>/<action>(/<id>)')
    ->defaults(array(
        'directory' => 'SMMarket/Sadmin',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));