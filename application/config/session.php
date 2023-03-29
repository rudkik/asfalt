<?php
return array(
    'native' => array(
        'name' => 'session_user',
        'lifetime' => 0,
    ),
    'cookie' => array(
        'name' => 'cjsess',
        'encrypted' => TRUE,
        'lifetime' =>0,
    ),

    'database' => array(
        'name' => 'dbsess',
        'encrypted' => TRUE,
        'lifetime' => 0,
        'group' => 'default',
        'table' => 'sessions',
        'columns' => array(
            'session_id'  => 'session_id',
            'last_active' => 'last_active',
            'contents'    => 'contents'
        ),
        'gc' => 500,
    ),
);