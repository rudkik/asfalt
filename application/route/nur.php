<?php
Route::set('nur-bookkeeping', 'nur-bookkeeping(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Nur/Bookkeeping',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));
Route::set('nur-admin', 'nur-admin(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Nur/Admin',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));