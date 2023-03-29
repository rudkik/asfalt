<?php

Route::set('pyramid', 'pyramid(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Pyramid',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));