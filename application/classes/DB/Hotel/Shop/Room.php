<?php defined('SYSPATH') or die('No direct script access.');

class DB_Hotel_Shop_Room {
    const TABLE_NAME = 'hc_shop_rooms';
    const TABLE_ID = 61;
    const NAME = 'DB_Hotel_Shop_Room';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."hc_shop_rooms";',
            'create' => '
                -- ----------------------------
                -- Table structure for hc_shop_rooms
                -- ----------------------------
                CREATE TABLE "public"."hc_shop_rooms" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "shop_table_catalog_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_rubric_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_select_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_brand_id" int8 NOT NULL DEFAULT 0,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "text" text COLLATE "pg_catalog"."default",
                  "image_path" varchar(100) COLLATE "pg_catalog"."default",
                  "files" text COLLATE "pg_catalog"."default",
                  "options" text COLLATE "pg_catalog"."default",
                  "seo" text COLLATE "pg_catalog"."default",
                  "remarketing" text COLLATE "pg_catalog"."default",
                  "collations" text COLLATE "pg_catalog"."default",
                  "order" int8 NOT NULL DEFAULT 0,
                  "old_id" varchar(64) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 0,
                  "create_user_id" int8 DEFAULT 0,
                  "update_user_id" int8 NOT NULL,
                  "delete_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "shop_table_object_ids" text COLLATE "pg_catalog"."default",
                  "shop_table_unit_id" int8 NOT NULL DEFAULT 0,
                  "shop_building_id" int8 NOT NULL DEFAULT 0,
                  "shop_floor_id" int8 NOT NULL DEFAULT 0,
                  "human" int4 NOT NULL DEFAULT 0,
                  "human_extra" int4 NOT NULL DEFAULT 0,
                  "price" numeric(12,2) NOT NULL DEFAULT 0,
                  "price_extra" numeric(12,2) NOT NULL DEFAULT 0,
                  "shop_room_type_id" int8 NOT NULL DEFAULT 0,
                  "price_child" numeric(12,2) DEFAULT 0,
                  "price_feast" numeric(12,2) NOT NULL DEFAULT 0,
                  "two_bedroom" int4 NOT NULL DEFAULT 0,
                  "bedroom" int4 NOT NULL DEFAULT 0,
                  "sofa" int4 NOT NULL DEFAULT 0,
                  "is_close" numeric(1) NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."hc_shop_rooms"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."shop_table_catalog_id" IS \'Тип товара\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."shop_table_rubric_id" IS \'ID рубрики\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."shop_table_select_id" IS \'Тип выделения \';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."shop_table_brand_id" IS \'ID бренда \';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."seo" IS \'JSON массива настройки SEO\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."remarketing" IS \'Код ремаркетинга\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."collations" IS \'JSON список значений для сопоставления\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."shop_table_object_ids" IS \'JSON данные списком\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."shop_table_unit_id" IS \'Тип единицы измерения\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."shop_building_id" IS \'ID здания\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."shop_floor_id" IS \'ID этажа\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."human" IS \'Кол-во человек\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."human_extra" IS \'Кол-во дополнительных человек\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."price" IS \'Цена всего номера\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."price_extra" IS \'Цена одного дополнительного человека\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."shop_room_type_id" IS \'ID типа номера\';
                COMMENT ON COLUMN "public"."hc_shop_rooms"."is_close" IS \'Запретить бронировать на сайте\';
                
                -- ----------------------------
                -- Indexes structure for table hc_shop_rooms
                -- ----------------------------
                CREATE INDEX "ab_shop_car_first_copy1_copy1_copy1" ON "public"."hc_shop_rooms" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_table_catalog_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_index_id_copy1_copy1_copy1" ON "public"."hc_shop_rooms" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                ',
            'data' => '',
        ),
    );

    const FIELDS = array(
        'id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
        ),
        'is_public' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Опубликована ли запись',
        ),
        'shop_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID магазина',
            'table' => 'DB_Shop',
        ),
        'shop_table_catalog_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип товара',
            'table' => 'DB_Shop_Table_Catalog',
        ),
        'shop_table_rubric_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID рубрики',
            'table' => 'DB_Shop_Table_Rubric',
        ),
        'shop_table_select_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип выделения',
            'table' => 'DB_Shop_Table_Select',
        ),
        'shop_table_brand_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID бренда',
            'table' => 'DB_Shop_Table_Brand',
        ),
        'name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер авто',
        ),
        'text' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Описание ',
        ),
        'image_path' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 100,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Картинка',
        ),
        'files' => array(
            'type' => DB_FieldType::FIELD_TYPE_FILES,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дополнительные файлы',
        ),
        'options' => array(
            'type' => DB_FieldType::FIELD_TYPE_JSON,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дополнительные поля',
        ),
        'seo' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON массива настройки SEO',
        ),
        'remarketing' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Код ремаркетинга',
        ),
        'collations' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON список значений для сопоставления',
        ),
        'order' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
        ),
        'old_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
        ),
        'create_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Кто отредактировал эту запись',
            'table' => 'DB_User',
        ),
        'update_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Кто отредактировал эту запись',
            'table' => 'DB_User',
        ),
        'delete_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Кто удалил запись',
            'table' => 'DB_User',
        ),
        'created_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => '',
        ),
        'updated_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Дата обновления записи',
        ),
        'deleted_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата удаления записи',
        ),
        'is_delete' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Удалена ли запись',
        ),
        'language_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID языка',
            'table' => 'DB_Language',
        ),
        'global_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Глобальный ID',
        ),
        'shop_table_object_ids' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON данные списком',
        ),
        'shop_table_unit_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип единицы измерения',
            'table' => 'DB_Shop_Table_Unit',
        ),
        'shop_building_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID здания',
            'table' => 'DB_Hotel_Shop_Building',
        ),
        'shop_floor_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID этажа',
            'table' => 'DB_Hotel_Shop_Floor',
        ),
        'human' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 9,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Кол-во человек',
        ),
        'human_extra' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 9,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Кол-во дополнительных человек',
        ),
        'price' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена всего номера',
        ),
        'price_extra' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена одного дополнительного человека',
        ),
        'shop_room_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID типа номера',
            'table' => 'DB_Hotel_Shop_Room_Type',
        ),
        'price_child' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => false,
            'title' => '',
        ),
        'price_feast' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => '',
        ),
        'two_bedroom' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 9,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
        ),
        'bedroom' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 9,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
        ),
        'sofa' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 9,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
        ),
        'is_close' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Запретить бронировать на сайте',
        ),
    );

    // список связанных таблиц 1коМногим
    const ITEMS = array(

    );

    /**
     * Получение
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
