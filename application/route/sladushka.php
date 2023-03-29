<?php

Route::set('sladushka', 'sladushka(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Sladushka/Main',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));

Route::set('sladushka_manager', 'manager(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Sladushka/Manager',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));