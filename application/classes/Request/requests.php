<?php

return array(
    'Request_Shop_Gallery_findShopGalleries' => array(
        'title' => array(
            'ru' => 'Галерея (поиск)'
        ),
        'class' => 'Request_Shop_Gallery',
        'function' => 'findShopGalleryIDs',
    ),

    'Request_Shop_New_findShopNews' => array(
        'title' => array(
            'ru' => 'Статьи (поиск)'
        ),
        'class' => 'Request_Shop_New',
        'function' => 'findShopNewIDs',
    ),

    'Request_ShopQuestion_findShopQuestions' => array(
        'title' => array(
            'ru' => 'Вопросы/ответы (поиск)'
        ),
        'class' => 'Request_ShopQuestion',
        'function' => 'findShopQuestionIDs',
    ),

    'Request_Shop_GoodCatalog_getShopTableRubrics' => array(
        'title' => array(
            'ru' => 'Рубрики товаров (все)'
        ),
        'class' => 'Request_Shop_GoodCatalog',
        'function' => 'getShopTableRubricIDs',
    ),

    'Request_Shop_GoodCatalog_findShopGoodRubrics' => array(
        'title' => array(
            'ru' => 'Рубрики товаров (поиск)'
        ),
        'class' => 'Request_Shop_GoodCatalog',
        'function' => 'findShopGoodCatalogIDs',
    ),

    'Request_Shop_Good_find' => array(
        'title' => array(
            'ru' => 'Товары (поиск)'
        ),
        'class' => 'Request_Shop_Good',
        'function' => 'find',
    ),

    'Request_Shop_DeliveryType_getShopDeliveryTypes' => array(
        'title' => array(
            'ru' => 'Доставка (все)'
        ),
        'class' => 'Request_Shop_DeliveryType',
        'function' => 'getShopDeliveryTypeIDAll',
    ),

    'Request_Shop_Comment_findShopComments' => array(
        'title' => array(
            'ru' => 'Комментарии (поиск)'
        ),
        'class' => 'Request_Shop_Comment',
        'function' => 'findShopCommentIDs',
    ),

    'Request_Shop_Action_findShopActions' => array(
        'title' => array(
            'ru' => 'Акции (поиск)'
        ),
        'class' => 'Request_Request',
        'table' => 'DB_Shop_Action',
        'function' => 'find',
    ),

    'Request_Shop_Action_getShopActions' => array(
        'title' => array(
            'ru' => 'Акции (все)'
        ),
        'class' => 'Request_Request',
        'table' => 'DB_Shop_Action',
        'function' => 'findAll',
    ),

    'Request_Shop_Table_Catalog_getShopTableCatalogIDAll' => array(
        'title' => array(
            'ru' => 'Категории товаров (все)'
        ),
        'class' => 'Request_Shop_Table_Catalog',
        'function' => 'getShopTableCatalogIDAll',
    ),

    'Request_Shop_GalleryCatalog_getShopGalleryCatalogs' => array(
        'title' => array(
            'ru' => 'Категории галерей (все)'
        ),
        'class' => 'Request_Shop_GalleryCatalog',
        'function' => 'getShopGalleryCatalogIDAll',
    ),

    'Request_Shop_NewRubric_getShopNewRubrics' => array(
        'title' => array(
            'ru' => 'Рубрики новостей (все)'
        ),
        'class' => 'Request_Shop_NewRubric',
        'function' => 'getShopNewRubricIDAll',
    ),

    'Request_Shop_NewRubric_findShopNewRubrics' => array(
        'title' => array(
            'ru' => 'Рубрики новостей (поиск)'
        ),
        'class' => 'Request_Shop_NewRubric',
        'function' => 'findShopNewRubricIDs',
    ),
);