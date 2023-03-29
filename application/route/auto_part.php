<?php
Route::set('part-write', 'part_write(/<controller>(/<action>(/<id>)))')
    ->defaults(array(
        'directory' => 'AutoPart/Write',
        'controller' => 'Shopuser',
        'action'     => 'auth',
    ));