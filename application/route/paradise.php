<?php
Route::set('paradise', '(<action>(/<id>))')
    ->defaults(array(
        'directory' => 'Paradise',
        'controller' => 'Region',
        'action'     => 'index',
    ));
