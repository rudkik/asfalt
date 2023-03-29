<?php

Route::set('hotel', 'hotel(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Hotel',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('client-hotel', 'client-hotel(/<action>(/<id>))')
    ->defaults(array(
        'directory' => 'Client',
        'controller' => 'Hotel',
    ));