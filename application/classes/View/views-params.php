<?php defined('SYSPATH') or die('No direct script access.');
global $_params;
$_params = array(
    'limit' => array(
        'name' => 'limit',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Лимит',
        ),
    ),
    'limit_page' => array(
        'name' => 'limit_page',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Лимит записей на одной странице',
        ),
    ),
    Request_RequestParams::IS_NOT_READ_REQUEST_NAME => array(
        'name' => Request_RequestParams::IS_NOT_READ_REQUEST_NAME,
        'type' => 'boolean',
        'title' => array(
            'ru' => 'Не считывать параметры в URL (0 или 1)',
        ),
    ),
    'type' => array(
        'name' => 'type',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Категория (id)',
        ),
    ),
    'shop_table_rubric_id' => array(
        'name' => 'shop_table_rubric_id',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Рубрика (id)',
        ),
    ),
    'shop_table_select_id'  => array(
        'name' => 'shop_table_select_id',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Выделение (id)',
        ),
    ),
    'shop_table_brand_id' => array(
        'name' => 'shop_table_brand_id',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Бренд (id)',
        ),
    ),
    'shop_table_unit_id' => array(
        'name' => 'shop_table_unit_id',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Единица измерения (id)',
        ),
    ),
    'created_at_year' => array(
        'name' => 'created_at_year',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Год создания',
        ),
    ),
    'created_at_month' => array(
        'name' => 'created_at_month',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Месяц создания',
        ),
    ),
    'is_branch' => array(
        'name' => 'is_branch',
        'type' => 'boolean',
        'title' => array(
            'ru' => 'Считывать данные филиала (0 или 1)',
        ),
    ),
    'shop_branch_id' => array(
        'name' => 'shop_branch_id',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Филиал (id)',
        ),
    ),
    'id' => array(
        'name' => 'id',
        'type' => 'integer',
        'title' => array(
            'ru' => 'id',
        ),
    ),
    'name' => array(
        'name' => 'name',
        'type' => 'string',
        'title' => array(
            'ru' => 'Название',
        ),
    ),
    'article' => array(
        'name' => 'article',
        'type' => 'string',
        'title' => array(
            'ru' => 'Артикул',
        ),
    ),
    'text' => array(
        'name' => 'text',
        'type' => 'string',
        'title' => array(
            'ru' => 'Текст',
        ),
    ),
    'options' => array(
        'name' => 'options',
        'type' => 'array',
        'title' => array(
            'ru' => 'Дополнительные поля',
        ),
    ),
    'is_group' => array(
        'name' => 'is_group',
        'type' => 'boolean',
        'title' => array(
            'ru' => 'Группа?',
        ),
    ),
    'is_public' => array(
        'name' => 'is_public',
        'type' => 'boolean',
        'title' => array(
            'ru' => 'Опубликована?',
        ),
    ),
    'shop_id' => array(
        'name' => 'shop_id',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Магазин (id) ',
        ),
    ),
    'update_user_id' => array(
        'name' => 'update_user_id',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Кто отредактировал?',
        ),
    ),
    'create_user_id' => array(
        'name' => 'create_user_id',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Кто создал?',
        ),
    ),
    'is_error_404' => array(
        'name' => 'is_error_404',
        'type' => 'boolean',
        'title' => array(
            'ru' => 'Выводить 404 ошибку (0 или 1)',
        ),
    ),
    'root_id' => array(
        'name' => 'root_id',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Родитель (id)',
        ),
    ),
    'contact_type_id' => array(
        'name' => 'contact_type_id',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Вид контакта (id)',
        ),
    ),
    'shop_address_id' => array(
        'name' => 'shop_address_id',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Адрес (id)',
        ),
    ),
    'city_id' => array(
        'name' => 'city_id',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Город (id)',
        ),
    ),
    'land_id' => array(
        'name' => 'land_id',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Страна (id)',
        ),
    ),
    'shop_mark_id' => array(
        'name' => 'shop_mark_id',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Марка (id)',
        ),
    ),
    'shop_model_id' => array(
        'name' => 'shop_model_id',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Модель (id)',
        ),
    ),
    'location_land_id' => array(
        'name' => 'location_land_id',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Страна нахождения (id)',
        ),
    ),
    'period_from' => array(
        'name' => 'period_from',
        'type' => 'date',
        'title' => array(
            'ru' => 'Период от',
        ),
    ),
    'period_to' => array(
        'name' => 'period_to',
        'type' => 'date',
        'title' => array(
            'ru' => 'Период до',
        ),
    ),
);

/**
 * Получаем массив параметров
 * @param array $params
 * @return array
 */
function getParams(array $params){
    $result = array();
    foreach($params as $param){
        if(key_exists($param, $GLOBALS['_params'])){
            $result[] = $GLOBALS['_params'][$param];
        }
    }

    return $result;
}

/**
 * Получаем массив переменных для объектов таблицы
 * @param array $params
 * @return array
 */
function getTableObjectParams(array $params = array()){
    return array_merge(
        array(
            'param_index' => array(
                'name' => 'param_index',
                'type' => 'int',
                'title' => array(
                    'ru' => 'Номер параметра',
                ),
            ),
        ),
        getParams(array('limit', 'limit_page', Request_RequestParams::IS_NOT_READ_REQUEST_NAME, 'type',
            'shop_table_rubric_id', 'shop_table_select_id', 'shop_table_brand_id', 'shop_table_unit_id',
            'created_at_year', 'created_at_month', 'is_branch', 'shop_branch_id', 'id', 'name', 'article', 'text',
            'options', 'is_group', 'is_public', 'shop_id', 'update_user_id', 'create_user_id')),
        getParams($params)
    );
}

/**
 * Получаем массив переменных для машин
 * @param array $params
 * @return array
 */
function getCarParams(array $params = array()){
    return array_merge(
        getParams(
            array(
                'limit', 'limit_page', Request_RequestParams::IS_NOT_READ_REQUEST_NAME, 'type',
                'shop_table_rubric_id', 'shop_mark_id', 'shop_model_id', 'location_land_id',
                'created_at_year', 'created_at_month', 'is_branch', 'shop_branch_id', 'id', 'name', 'text',
                'options', 'is_public', 'shop_id', 'update_user_id', 'create_user_id'
            )
        ),
        getParams($params)
    );
}

/**
 * Получаем массив переменных для параметров
 * @param array $params
 * @return array
 */
function getTableParams(array $params = array()){
    return array_merge(

        getParams(
            array(
                'limit', 'limit_page', Request_RequestParams::IS_NOT_READ_REQUEST_NAME, 'type',
                'shop_table_rubric_id', 'created_at_year', 'created_at_month', 'is_branch', 'shop_branch_id', 'id', 'name', 'text',
                'options', 'is_public', 'shop_id', 'update_user_id', 'create_user_id'
            )
        ),
        getParams($params)
    );
}

/**
 * Получаем массив переменных для объекта таблицы
 * @param array $params
 * @return array
 */
function getTableObjectParam(array $params = array()){
    return array_merge(
        getParams(array('id', Request_RequestParams::IS_NOT_READ_REQUEST_NAME, 'is_branch', 'shop_branch_id',
            'is_error_404')),
        getParams($params)
    );
}

/**
 * Получаем массив переменных для объектов таблицы
 * @param array $params
 * @return array
 */
function getTableRubricParams(array $params = array()){
    return array_merge(
        getParams(array('limit', 'limit_page', Request_RequestParams::IS_NOT_READ_REQUEST_NAME, 'type',
            'root_id', 'shop_table_select_id',  'shop_table_unit_id',  'shop_table_brand_id',
            'created_at_year', 'created_at_month', 'is_branch', 'shop_branch_id', 'id', 'name', 'text',
            'options', 'is_group', 'is_public', 'shop_id', 'update_user_id', 'create_user_id')),
        getParams($params)
    );
}

/**
 * Получаем массив переменных для объектов хэштеги
 * @param array $params
 * @return array
 */
function getTableHashtagParams(array $params = array()){
    return array_merge(
        getParams(array('limit', 'limit_page', Request_RequestParams::IS_NOT_READ_REQUEST_NAME, 'type',
            'shop_rubric_id', 'created_at_year', 'created_at_month', 'is_branch', 'shop_branch_id', 'id', 'name', 'text',
            'options', 'is_group', 'is_public', 'shop_id', 'update_user_id', 'create_user_id')),
        getParams($params)
    );
}

/**
 * Получаем массив переменных для объектов таблицы
 * @param array $params
 * @return array
 */
function getObjectParams(array $params = array()){
    return array_merge(
        getParams(array('limit', 'limit_page', Request_RequestParams::IS_NOT_READ_REQUEST_NAME, 'type',
            'created_at_year', 'created_at_month', 'is_branch', 'shop_branch_id', 'id', 'name', 'text',
            'options', 'is_group', 'is_public', 'shop_id', 'update_user_id', 'create_user_id')),
        getParams($params)
    );
}

/**
 * Получаем массив переменных для объектов таблицы
 * @param array $params
 * @return array
 */
function getShopAddressContactParams(array $params = array()){
    return array_merge(
        getParams(array('limit', 'limit_page', Request_RequestParams::IS_NOT_READ_REQUEST_NAME, 'type')),
        array(
            'name' => array(
                'name' => 'name',
                'type' => 'string',
                'title' => array(
                    'ru' => 'Контакт',
                ),
            ),
        ),
        getParams(array('shop_address_id', 'contact_type_id', 'city_id', 'land_id', 'is_branch', 'shop_branch_id', 'id', 'name', 'text',
            'options', 'is_public', 'shop_id', 'update_user_id', 'create_user_id')),
        getParams($params)
    );
}

/**
 * Получаем массив переменных для объектов таблицы
 * @param array $params
 * @return array
 */
function getShopAddressParams(array $params = array()){
    return array_merge(
        getParams(array('limit', 'limit_page', Request_RequestParams::IS_NOT_READ_REQUEST_NAME, 'type')),
        getParams(array('name', 'city_id', 'land_id', 'is_branch', 'shop_branch_id', 'id', 'name', 'text',
            'options', 'is_public', 'shop_id', 'update_user_id', 'create_user_id')),
        getParams($params)
    );
}

/**
 * Получаем массив переменных для объектов таблицы
 * @param array $params
 * @return array
 */
function getShopCalendarParams(array $params = array()){
    return array_merge(
        getParams(array('limit', 'limit_page', Request_RequestParams::IS_NOT_READ_REQUEST_NAME, 'type',
            'period_from', 'period_to',
            'shop_table_rubric_id', 'shop_table_select_id', 'shop_table_brand_id', 'shop_table_unit_id',
            'created_at_year', 'created_at_month', 'is_branch', 'shop_branch_id', 'id', 'name', 'article', 'text',
            'options', 'is_group', 'is_public', 'shop_id', 'update_user_id', 'create_user_id')),
        getParams($params)
    );
}



