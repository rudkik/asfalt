<?php
return array(
    'shop_good_rubrics' => array(
        'db_object' => 'DB_Shop_Good',
        'function' => 'find',
        'params' => array(
            'is_list' => array(
                'value' => '1', ),
            'type' => array(
                'value' => '3595', ),
        )
    ),
    'shop_goods' => array(
        'db_object' => 'DB_Shop_Good',
        'function' => 'find',
        'url' => '/catalogs#name_url#',
        'params' => array(
            'shop_table_catalog_id' => array(
                'value' => '3595', ),
        ),
        'elements' => array(
            'shop_table_catalog_id',
        )
    ),
);