<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Transport_Sample_Fuel_Item {
    const TABLE_NAME = 'ab_shop_transport_sample_fuel_items';
    const TABLE_ID = 391;
    const NAME = 'DB_Ab1_Shop_Transport_Sample_Fuel_Item';
    const TITLE = 'Топливо в актах замеров в баках';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_transport_sample_fuel_items";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_transport_sample_fuel_items
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_transport_sample_fuel_items" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "text" text COLLATE "pg_catalog"."default",
                  "image_path" varchar(100) COLLATE "pg_catalog"."default",
                  "files" text COLLATE "pg_catalog"."default",
                  "options" text COLLATE "pg_catalog"."default",
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
                  "shop_transport_mark_id" int8 NOT NULL DEFAULT 0,
                  "quantity" numeric(12,3) NOT NULL DEFAULT 0,
                  "fuel_id" int8 NOT NULL DEFAULT 0,
                  "unit" varchar(50) COLLATE "pg_catalog"."default",
                  "shop_transport_sample_fuel_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_transport_sample_fuel_items"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_sample_fuel_items"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_transport_sample_fuel_items"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ab_shop_transport_sample_fuel_items"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_transport_sample_fuel_items"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_transport_sample_fuel_items"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_transport_sample_fuel_items"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_transport_sample_fuel_items"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_sample_fuel_items"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_sample_fuel_items"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_sample_fuel_items"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_transport_sample_fuel_items"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_transport_sample_fuel_items"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_sample_fuel_items"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_transport_sample_fuel_items"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_transport_sample_fuel_items"."shop_transport_mark_id" IS \'ID транспорта\';
                COMMENT ON COLUMN "public"."ab_shop_transport_sample_fuel_items"."quantity" IS \'Количество топлива\';
                COMMENT ON COLUMN "public"."ab_shop_transport_sample_fuel_items"."fuel_id" IS \'ID топлива\';
                COMMENT ON COLUMN "public"."ab_shop_transport_sample_fuel_items"."unit" IS \'Единица измерения\';
                COMMENT ON COLUMN "public"."ab_shop_transport_sample_fuel_items"."shop_transport_sample_fuel_id" IS \'ID акта замера топлива\';
                COMMENT ON TABLE "public"."ab_shop_transport_sample_fuel_items" IS \'Список топлива в актов замеров в баках\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_transport_sample_fuel_items
                -- ----------------------------
                CREATE INDEX "ab_shop_transport_sample_fuel_item_created_at" ON "public"."ab_shop_transport_sample_fuel_items" USING btree (
                  "created_at" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_sample_fuel_item_first" ON "public"."ab_shop_transport_sample_fuel_items" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_sample_fuel_item_index_id" ON "public"."ab_shop_transport_sample_fuel_items" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_sample_fuel_item_shop_transport_mark_id" ON "public"."ab_shop_transport_sample_fuel_items" USING btree (
                  "shop_transport_mark_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_sample_fuel_item_shop_transport_sample_fuel_i" ON "public"."ab_shop_transport_sample_fuel_items" USING btree (
                  "shop_transport_sample_fuel_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название',
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
        'shop_transport_mark_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID транспорта',
            'table' => 'DB_Ab1_Shop_Transport_Mark',
        ),
        'quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество топлива',
        ),
        'fuel_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID топлива',
            'table' => 'DB_Ab1_Fuel',
        ),
        'unit' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Единица измерения',
        ),
        'shop_transport_sample_fuel_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID акта замера топлива',
            'table' => 'DB_Ab1_Shop_Transport_Sample_Fuel',
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
