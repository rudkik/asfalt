<?php

Route::set('telegram', 'telegram(/<action>(/<id>))')
    ->defaults(array(
        'controller' => 'Telegram',
        'action'     => 'index',
    ));