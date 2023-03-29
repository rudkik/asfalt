<?php
Route::set('market', 'market(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Smg/Market',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('smg', 'smg(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Smg',
    ));