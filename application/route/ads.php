<?php
Route::set('ads', 'ads(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Ads',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('adsgs', 'adsgs(/<action>(/<id>))')
    ->defaults(array(
        'directory' => 'Client',
        'controller' => 'Ads',
    ));