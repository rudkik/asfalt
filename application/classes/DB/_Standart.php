<?php defined('SYSPATH') or die('No direct script access.');

class DB_Standart {
    const TABLE_NAME = 'название таблицы';
    const TABLE_ID = 'порядковый номер таблицы';
    const NAME = 'DB_Bank';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_banks";',
            'create' => 'запрос на создание таблицы',
            'data' => '',
        ),
    );

    // список полей таблицы
    const FIELDS = array(
        'update_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER, // *тип поля
            'length' => 18, // максимальная длина поля
            'decimal' => 0, // количество цифр после запятой
            'is_not_null' => true, // не должно быть NULL
            'title' => 'Кто отредактировал эту запись', // комментарий
            'table' => 'DB_User', // связь с другой таблицой связь 1к1
            'is_not_automatic_save' => true, // запрет на автотамическое изменение поля
            'is_sequence' => true, // если нужно создать нумерацию, как в 1С М000001...М999999 исходя из настроек DB_Ab1_Shop_Sequence
            'sequence' => array( // если нужно создать нумерацию, как в 1С М000001...М999999
                'name' => '', // *название счетчика
                'symbol' => '', // префикс нумерации
                'is_shop' => true, // нужно ли добавлять ID филиала (название_счетчика_sID_филиала)
                'is_cashbox' => true, // нужно ли добавлять ID кассового регистратора (название_счетчика_oID_кассового_регистратора)
                'length' => 0, // максимальная длина с нумерации для добавления нулей, префикс не учитывается
            ),
            'is_common_items' => true, // если поле общее со связанными записями 1коМногим
            'is_total_items' => true, // если поле итоговое значение со связанными записями 1коМногим (общая сумма или общее количество)
            'total_item' => array( // считать итоговые значения
                'db_name' => '', // DB table из ITEMS
                'field' => '', // название поля с которого считать
            )
        ),
    );

    // список связанных таблиц 1коМногим
    const ITEMS = array(
        'shop_piece_items' => array( // название переменной переданной из формы (например shop_piece_items)
            'table' => 'DB_Ab1_Shop_Piece_Item', // *связь с другой таблицой
            'field_id' => 'shop_piece_id', // *по какому полю будет идти связть id = shop_piece_id
            'is_view' => true, // отображать при добавлении и редактировании по view
        ),
    );

    /**
     * Создание таблицы
     * @param string $db
     * @param bool $isDropTable
     * @return string
     */
    public static function getCreateTableSQL($db = 'postgres', $isDropTable = FALSE)
    {
        if (!key_exists($db, self::SQL)){
            return '';
        }

        $sql = '';
        if ($isDropTable){
            $sql .= self::SQL[$db]['drop'];
        }
        $sql .= self::SQL[$db]['create'];

        return $sql.self::SQL[$db]['data'];
    }
}
