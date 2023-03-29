<?php

Route::set('calendar', 'calendar(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'Calendar',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));