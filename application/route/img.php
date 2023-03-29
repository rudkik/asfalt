<?php

// картинки
Route::set('img', 'img/<table_id>(/<year>/<month>/<day>/<tmp_id>)/<id>.<ext>')
    ->defaults(array(
        'controller' => 'Images',
        'action'     => 'process',
    ));
Route::set('img-addition', 'img/<table_id>/<year>/<month>/<day>/<tmp_id>/<files>/<id>.<ext>')
    ->defaults(array(
        'controller' => 'Images',
        'action'     => 'process',
    ));
Route::set('img-addition_1', 'img(/<table_id>(/<year>(/<month>(/<day>(/<tmp_id>(/<files>(/<index>)))))))/<id>.<ext>')
    ->defaults(array(
        'controller' => 'Images',
        'action'     => 'process',
    ));
Route::set('tmp_files', 'tmp_files(/<table_id>(/<year>(/<month>(/<day>(/<tmp_id>(/<files>(/<index>)))))))/<id>.<ext>')
    ->defaults(array(
        'controller' => 'Images',
        'action'     => 'process',
    ));
Route::set('files', 'files(/<table_id>(/<year>(/<month>(/<day>(/<tmp_id>(/<files>(/<index>)))))))/<id>.<ext>')
    ->defaults(array(
        'controller' => 'Images',
        'action'     => 'process',
    ));