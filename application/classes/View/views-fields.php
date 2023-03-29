<?php defined('SYSPATH') or die('No direct script access.');
global $_fields;
$_fields = array(
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
    'price' => array(
        'name' => 'price',
        'type' => 'float',
        'title' => array(
            'ru' => 'Цена',
        ),
    ),
    'price_old' => array(
        'name' => 'price_old',
        'type' => 'float',
        'title' => array(
            'ru' => 'Старая цена',
        ),
    ),
    'text' => array(
        'name' => 'text',
        'type' => 'string',
        'title' => array(
            'ru' => 'Текст',
        ),
    ),
    'image_path' => array(
        'name' => 'image_path',
        'type' => 'image',
        'title' => array(
            'ru' => 'Картинка (путь)',
        ),
    ),
    'options' => array(
        'name' => 'options',
        'type' => 'array',
        'title' => array(
            'ru' => 'Дополнительные поля',
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
    'shop_table_catalog_id' => array(
        'name' => 'shop_table_catalog_id',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Каталог (id)',
        ),
    ),
    'files' => array(
        'name' => 'files',
        'type' => 'files',
        'title' => array(
            'ru' => 'Файлы',
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
    'updated_at' => array(
        'name' => 'updated_at',
        'type' => 'date',
        'title' => array(
            'ru' => 'Дата обновления',
        ),
    ),
    'create_user_id' => array(
        'name' => 'create_user_id',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Кто создал?',
        ),
    ),
    'created_at' => array(
        'name' => 'created_at',
        'type' => 'date',
        'title' => array(
            'ru' => 'Дата создания',
        ),
    ),
    'root_id' => array(
        'name' => 'root_id',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Родитель (id)',
        ),
    ),
    'answer_user_name' => array(
        'name' => 'answer_user_name',
        'type' => 'string',
        'title' => array(
            'ru' => 'Пользователь ответивший',
        ),
    ),
    'email' => array(
        'name' => 'email',
        'type' => 'string',
        'title' => array(
            'ru' => 'E-mail спросившего',
        ),
    ),
    'is_answer' => array(
        'name' => 'is_answer',
        'type' => 'boolean',
        'title' => array(
            'ru' => 'Есть ли ответ?',
        ),
    ),
    'answer_text' => array(
        'name' => 'answer_text',
        'type' => 'string',
        'title' => array(
            'ru' => 'Ответ',
        ),
    ),
    'answer_at' => array(
        'name' => 'answer_at',
        'type' => 'date',
        'title' => array(
            'ru' => 'Время ответа',
        ),
    ),
    'answer_user_id' => array(
        'name' => 'answer_user_id',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Кто спросил? (id)',
        ),
    ),
    'shop_operator_id' => array(
        'name' => 'shop_operator_id',
        'type' => 'integer',
        'title' => array(
            'ru' => 'Кто ответил? (id)',
        ),
    ),
    'is_operation' => array(
        'name' => 'is_operation',
        'type' => 'boolean',
        'title' => array(
            'ru' => 'Вопрос создан оператором?',
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
);

/**
 * Получаем массив переменных
 * @param array $fields
 * @return array
 */
function getFields(array $fields){
    $result = array();
    foreach($fields as $field){
        if(key_exists($field, $GLOBALS['_fields'])){
            $result[] = $GLOBALS['_fields'][$field];
        }else{
            switch ($field){
                case 'shop_table_param_id':
                    for ($i = 1; $i <= Model_Shop_Table_Param::PARAMS_COUNT; $i++) {
                        $result[] = array(
                            'name' => 'shop_table_param_' . $i . '_id',
                            'type' => 'integer',
                            'title' => array(
                                'ru' => 'Параметр ' . $i . ' (id)',
                            ),
                        );
                    }
                    break;
                case 'param_int':
                    for ($i = 1; $i <= Model_Shop_Table_Param::PARAMS_COUNT; $i++) {
                        $result[] = array(
                            'name' => 'param_' . $i . '_int',
                            'type' => 'integer',
                            'title' => array(
                                'ru' => 'Параметр ' . $i . ' (целочисленный)',
                            ),
                        );
                    }
                    break;
                case 'param_float':
                    for ($i = 1; $i <= Model_Shop_Table_Param::PARAMS_COUNT; $i++) {
                        $result[] = array(
                            'name' => 'param_' . $i . '_float',
                            'type' => 'integer',
                            'title' => array(
                                'ru' => 'Параметр ' . $i . ' (вещественный)',
                            ),
                        );
                    }
                    break;
                case 'param_str':
                    for ($i = 1; $i <= Model_Shop_Table_Param::PARAMS_COUNT; $i++) {
                        $result[] = array(
                            'name' => 'param_' . $i . '_str',
                            'type' => 'integer',
                            'title' => array(
                                'ru' => 'Параметр ' . $i . ' (строковы)',
                            ),
                        );
                    }
                    break;
            }
        }
    }

    return $result;
}

/**
 * Получаем массив переменных для объекта таблицы
 * @param array $fields
 * @return array
 */
function getTableObjectFields(array $fields = array()){
    return array_merge(
        getFields(array('id', 'name', 'article', 'text', 'image_path',  'options', 'shop_table_rubric_id',
            'shop_table_select_id', 'shop_table_brand_id', 'shop_table_unit_id', 'shop_table_catalog_id', 'files',
            'is_group', 'is_public', 'shop_id', 'update_user_id', 'updated_at', 'create_user_id', 'created_at')),
        getFields($fields)
    );
}

/**
 * Получаем массив переменных для товаров
 * @param array $fields
 * @return array
 */
function getGoodFields(array $fields = array()){
    return array_merge(
        getFields(array('id', 'name', 'article', 'price', 'price_old', 'text', 'image_path',  'options', 'shop_table_rubric_id',
            'shop_table_select_id', 'shop_table_brand_id', 'shop_table_unit_id', 'shop_table_catalog_id', 'files',
            'is_group', 'is_public', 'shop_id', 'update_user_id', 'updated_at', 'create_user_id', 'created_at')),
        getFields($fields)
    );
}

/**
 * Получаем массив переменных для машин
 * @param array $fields
 * @return array
 */
function getCarFields(array $fields = array()){
    return array_merge(
        getFields(
            array('id', 'name', 'article', 'price', 'price_old', 'text', 'image_path',  'options', 'shop_table_rubric_id'),
            array(
                'production_land_id' => array(
                    'name' => 'production_land_id',
                    'type' => 'integer',
                    'title' => array(
                        'ru' => 'Страна производства (id)',
                    ),
                ),
                'location_land_id' => array(
                    'name' => 'location_land_id',
                    'type' => 'integer',
                    'title' => array(
                        'ru' => 'Страна нахождения (id)',
                    ),
                ),
                'location_city_id' => array(
                    'name' => 'location_city_id',
                    'type' => 'integer',
                    'title' => array(
                        'ru' => 'Город нахождения (id)',
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
            ),
            getFields(
                array(
                    'param_int', 'param_float', 'param_str',
                    'shop_table_param_id', 'shop_table_catalog_id', 'files', 'is_public', 'shop_id',
                    'update_user_id', 'updated_at', 'create_user_id', 'created_at'
                )
            ),
            getFields($fields)
        )
    );
}

/**
 * Получаем массив переменных для объекта таблицы
 * @param array $fields
 * @return array
 */
function getTableRubricFields(array $fields = array()){
    return array_merge(
        getFields(array('id', 'name', 'text', 'image_path',  'options', 'shop_table_select_id',
            'root_id', 'shop_table_select_id',  'shop_table_unit_id',  'shop_table_brand_id', 'shop_table_catalog_id',
            'files', 'is_public', 'shop_id', 'update_user_id',
            'updated_at', 'create_user_id', 'created_at')),
        getFields($fields)
    );
}

/**
 * Получаем массив переменных для объекта таблицы
 * @param array $fields
 * @return array
 */
function getObjectFields(array $fields = array()){
    return array_merge(
        getFields(array('id', 'name', 'text', 'image_path',  'options', 'shop_table_rubric_id',
            'shop_table_catalog_id', 'files', 'is_public', 'shop_id', 'update_user_id',
            'updated_at', 'create_user_id', 'created_at')),
        getFields($fields)
    );
}

/**
 * Получаем массив переменных для объекта таблицы
 * @param array $fields
 * @return array
 */
function getQuestionFields(array $fields = array()){
    return array_merge(
        array(
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
                    'ru' => 'Пользователь',
                ),
            ),
            'text' => array(
                'name' => 'text',
                'type' => 'string',
                'title' => array(
                    'ru' => 'Вопрос',
                ),
            ),
        ),
        getFields(array('email', 'is_answer', 'answer_user_name', 'answer_text', 'answer_at', 'is_operation',
            'answer_user_id', 'shop_operator_id', 'image_path',  'options', 'shop_table_rubric_id',
            'shop_table_catalog_id', 'files', 'is_public', 'shop_id', 'update_user_id',
            'updated_at', 'create_user_id', 'created_at')),
        getFields($fields)
    );
}

/**
 * Получаем массив переменных для объекта таблицы
 * @param array $fields
 * @return array
 */
function getShopAddressContactFields(array $fields = array()){
    return array_merge(
        getFields(array('id', 'shop_address_id')),
        array(
            'name' => array(
                'name' => 'name',
                'type' => 'string',
                'title' => array(
                    'ru' => 'Контакт',
                ),
            ),
        ),
        getFields(array('text', 'contact_type_id', 'city_id', 'land_id', 'image_path',  'options',
            'shop_table_rubric_id', 'shop_table_catalog_id', 'files', 'is_public', 'shop_id', 'update_user_id',
            'updated_at', 'create_user_id', 'created_at')),
        getFields($fields)
    );
}

/**
 * Получаем массив переменных для объекта таблицы
 * @param array $fields
 * @return array
 */
function getShopAddressFields(array $fields = array()){
    return array_merge(
        getFields(array('id', 'name')),
        array(
            'street' => array(
                'name' => 'street',
                'type' => 'string',
                'title' => array(
                    'ru' => 'Улица',
                ),
            ),
            'street_conv' => array(
                'name' => 'street_conv',
                'type' => 'string',
                'title' => array(
                    'ru' => 'Угол улицы',
                ),
            ),
            'house' => array(
                'name' => 'house',
                'type' => 'string',
                'title' => array(
                    'ru' => 'Адрес',
                ),
            ),
            'office' => array(
                'name' => 'office',
                'type' => 'string',
                'title' => array(
                    'ru' => 'Офис',
                ),
            ),
            'map_data' => array(
                'name' => 'map_data',
                'type' => 'string',
                'title' => array(
                    'ru' => 'Данные карты',
                ),
            ),
            'map_type_id' => array(
                'name' => 'map_type_id',
                'type' => 'integer',
                'title' => array(
                    'ru' => 'Тип карты (id)',
                ),
            ),
            'comment' => array(
                'name' => 'comment',
                'type' => 'string',
                'title' => array(
                    'ru' => 'Примечание',
                ),
            ),
        ),
        getFields(array('text', 'city_id', 'land_id', 'image_path',  'options',
            'shop_table_rubric_id', 'shop_table_catalog_id', 'files', 'is_public', 'shop_id', 'update_user_id',
            'updated_at', 'create_user_id', 'created_at')),
        getFields($fields)
    );
}

/**
 * Получаем массив переменных для объекта языка
 * @param array $fields
 * @return array
 */
function getLanguageObjectFields(array $fields = array()){
    return array_merge(
        getFields(array('id', 'name', 'code', 'image_path',  'is_public')),
        getFields($fields)
    );
}
/**
 * Получаем массив переменных для объекта таблицы
 * @param array $fields
 * @return array
 */
function getShopCalendarFields(array $fields = array()){
    return array_merge(
        getFields(array('id', 'name', 'article')),
        array(
            'date_from' => array(
                'name' => 'date_from',
                'type' => 'date',
                'title' => array(
                    'ru' => 'Дата начала',
                ),
            ),
            'date_to' => array(
                'name' => 'date_to',
                'type' => 'date',
                'title' => array(
                    'ru' => 'Дата окончания',
                ),
            ),
            'time_from' => array(
                'name' => 'time_from',
                'type' => 'time',
                'title' => array(
                    'ru' => 'Время начала',
                ),
            ),
            'time_to' => array(
                'name' => 'time_to',
                'type' => 'time',
                'title' => array(
                    'ru' => 'Время окончания',
                ),
            ),
        ),
        getFields(array('text', 'image_path',  'options', 'shop_table_rubric_id',
            'shop_table_select_id', 'shop_table_brand_id', 'shop_table_unit_id', 'shop_table_catalog_id', 'files',
            'is_group', 'is_public', 'shop_id', 'update_user_id', 'updated_at', 'create_user_id', 'created_at')),
        getFields($fields)
    );
}





