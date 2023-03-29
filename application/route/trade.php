<?php
Route::set('article', 'trade/<action>')
    ->defaults(array(
        'directory' => 'Smg/Trade',
        'controller' => 'Article',
    ));


Route::set('trade', 'trade(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Smg/Trade',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));

