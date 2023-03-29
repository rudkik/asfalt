<?php defined('SYSPATH') or die('No direct script access.');

class DB_Shop_Address {
    const TABLE_NAME = 'ct_shop_addresses';
    const TABLE_ID = 61;
    const NAME = 'DB_Shop_Address';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_shop_addresses";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_shop_addresses
                -- ----------------------------
                CREATE TABLE "public"."ct_shop_addresses" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "is_main_shop" numeric(1) NOT NULL DEFAULT 0,
                  "shop_id" int8 NOT NULL,
                  "city_id" int8 NOT NULL DEFAULT 12,
                  "land_id" int8 NOT NULL DEFAULT 3161,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "street" varchar(500) COLLATE "pg_catalog"."default",
                  "street_conv" varchar(100) COLLATE "pg_catalog"."default",
                  "house" varchar(100) COLLATE "pg_catalog"."default",
                  "office" varchar(100) COLLATE "pg_catalog"."default",
                  "work_time" text COLLATE "pg_catalog"."default",
                  "comment" text COLLATE "pg_catalog"."default",
                  "map_data" text COLLATE "pg_catalog"."default",
                  "map_type_id" int8 NOT NULL DEFAULT 37,
                  "create_user_id" int8 DEFAULT 0,
                  "update_user_id" int8 NOT NULL,
                  "delete_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "order" int4 NOT NULL DEFAULT 0,
                  "shop_table_rubric_id" int8 DEFAULT 0,
                  "image_path" varchar(100) COLLATE "pg_catalog"."default",
                  "files" text COLLATE "pg_catalog"."default",
                  "is_translates" json,
                  "land_ids" json
                )
                ;
                COMMENT ON COLUMN "public"."ct_shop_addresses"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."is_main_shop" IS \'Адрес основного магазина\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."city_id" IS \'ID города\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."land_id" IS \'ID страна\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."name" IS \'Название филиала\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."street" IS \'Название улицы\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."street_conv" IS \'Угол улицы\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."house" IS \'Номер дома\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."office" IS \'Номер офиса\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."work_time" IS \'JSON времени работы магазина\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."comment" IS \'Комментарии к адресу\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."map_data" IS \'Данные для отображения карты\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."map_type_id" IS \'ID типа карты для отображения\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."order" IS \'Позиция для сортировки\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."shop_table_rubric_id" IS \'ID рубрики\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."is_translates" IS \'JSON если ли перевод по языкам\';
                COMMENT ON COLUMN "public"."ct_shop_addresses"."land_ids" IS \'ID стран\';
                COMMENT ON TABLE "public"."ct_shop_addresses" IS \'Таблица адресов магазинов\';
                
                -- ----------------------------
                -- Indexes structure for table ct_shop_addresses
                -- ----------------------------
                CREATE INDEX "shop_address_city_id" ON "public"."ct_shop_addresses" USING btree (
                  "city_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_address_index_id" ON "public"."ct_shop_addresses" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_address_is_main_shop" ON "public"."ct_shop_addresses" USING btree (
                  "is_main_shop" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_address_land_id" ON "public"."ct_shop_addresses" USING btree (
                  "land_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_address_order" ON "public"."ct_shop_addresses" USING btree (
                  "order" "pg_catalog"."int4_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ct_shop_addresses
                -- ----------------------------
                ALTER TABLE "public"."ct_shop_addresses" ADD CONSTRAINT "ct_shop_addresses_pkey" PRIMARY KEY ("global_id");
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
        'is_main_shop' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Адрес основного магазина',
        ),
        'shop_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID магазина',
            'table' => 'DB_Shop',
        ),
        'city_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID города',
            'table' => 'DB_City',
        ),
        'land_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID страна',
            'table' => 'DB_Land',
        ),
        'name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название филиала',
        ),
        'street' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 500,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название улицы',
        ),
        'street_conv' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 100,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Угол улицы',
        ),
        'house' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 100,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер дома',
        ),
        'office' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 100,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер офиса',
        ),
        'work_time' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON времени работы магазина',
        ),
        'comment' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Комментарии к адресу',
        ),
        'map_data' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Данные для отображения карты',
        ),
        'map_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID типа карты для отображения',
            'table' => 'DB_MapType',
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
        'order' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 9,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Позиция для сортировки',
        ),
        'shop_table_rubric_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID рубрики',
            'table' => 'DB_Shop_Table_Rubric',
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
        'is_translates' => array(
            'type' => DB_FieldType::FIELD_TYPE_JSON,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON если ли перевод по языкам',
        ),
        'land_ids' => array(
            'type' => DB_FieldType::FIELD_TYPE_JSON,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID стран',
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
