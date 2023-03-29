<?php
Route::set('finance', 'market(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Finance/Admin',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
