<?php
return array(
    array(
        'db_object' => 'DB_Shop_Table_Rubric',
        'function' => 'find',
        'url' => '/catalogs#name_url#',
        'priority' => 0.9,
        'params' => array(
            'shop_table_catalog_id' => array(
                'value' => '3983', ),
        ),
    ),
    array(
        'db_object' => 'DB_Shop_Good',
        'function' => 'find',
        'url' => '/catalogs#name_url#',
        'priority' => 0.9,
        'params' => array(
            'shop_table_catalog_id' => array(
                'value' => '3983', ),
        ),
    ),
    array(
        'url' => '/',
        'priority' => 1,
    ),
    array(
        'url' => '/about',
        'priority' => 1,
    ),
    array(
        'url' => '/catalogs',
        'priority' => 1,
    ),
    array(
        'url' => '/contacts',
        'priority' => 1,
    ),
);