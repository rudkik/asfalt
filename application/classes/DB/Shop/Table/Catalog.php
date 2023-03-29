<?php defined('SYSPATH') or die('No direct script access.');

class DB_Shop_Table_Catalog {
    const TABLE_NAME = 'ct_shop_table_catalogs';
    const TABLE_ID = 61;
    const NAME = 'DB_Shop_Table_Catalog';
    const TITLE = 'Категории объектов';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_shop_table_catalogs";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_shop_table_catalogs
                -- ----------------------------
                CREATE TABLE "public"."ct_shop_table_catalogs" (
                  "id" int8 NOT NULL,
                  "table_id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "text" text COLLATE "pg_catalog"."default",
                  "fields_options" text COLLATE "pg_catalog"."default",
                  "image_path" varchar(255) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "files" text COLLATE "pg_catalog"."default",
                  "seo" text COLLATE "pg_catalog"."default",
                  "form_data" text COLLATE "pg_catalog"."default",
                  "create_user_id" int8 DEFAULT 0,
                  "update_user_id" int8 NOT NULL,
                  "delete_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "root_shop_table_catalog_id" int8 NOT NULL DEFAULT 0,
                  "root_table_id" int8 NOT NULL DEFAULT 0,
                  "child_shop_table_catalog_ids" text COLLATE "pg_catalog"."default",
                  "good_price_type_id" int8 NOT NULL DEFAULT 700,
                  "image_types" text COLLATE "pg_catalog"."default",
                  "inset_sql_child" text COLLATE "pg_catalog"."default",
                  "fields_params" text COLLATE "pg_catalog"."default",
                  "param_index" int8 NOT NULL DEFAULT 1
                )
                ;
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."table_id" IS \'ID таблицы\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."name" IS \'Название каталога\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."text" IS \'Описание каталога (HTML-код)\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."image_path" IS \'Путь к изображению рубрики\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."seo" IS \'JSON массива настройки SEO\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."form_data" IS \'Данные формы JSON\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."root_shop_table_catalog_id" IS \'ID таблицы родителя\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."root_table_id" IS \'ID таблицы родителя\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."child_shop_table_catalog_ids" IS \'JSON массива подчиненных элементов\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."good_price_type_id" IS \'Тип цены поля\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."image_types" IS \'JSON списка типов файлов\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."inset_sql_child" IS \'SQL запросы для после добавления записи (заменяется #id#)\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."fields_params" IS \'JSON списка параметров участвующие в поиске (param_1_int, param_1_float, param_1_str)\';
                COMMENT ON COLUMN "public"."ct_shop_table_catalogs"."param_index" IS \'Порядковый номер поля (для shop_table_param_"значение поля"_id)\';
                
                -- ----------------------------
                -- Indexes structure for table ct_shop_table_catalogs
                -- ----------------------------
                CREATE INDEX "shop_table_catalog_first" ON "public"."ct_shop_table_catalogs" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_table_catalog_index_id" ON "public"."ct_shop_table_catalogs" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_table_catalog_index_shop_table_id" ON "public"."ct_shop_table_catalogs" USING btree (
                  "table_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_table_catalog_name_like" ON "public"."ct_shop_table_catalogs" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."varchar_pattern_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_table_catalog_root_shop_table_catalog_id" ON "public"."ct_shop_table_catalogs" USING btree (
                  "root_shop_table_catalog_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_table_catalog_root_shop_table_id" ON "public"."ct_shop_table_catalogs" USING btree (
                  "root_table_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ct_shop_table_catalogs
                -- ----------------------------
                ALTER TABLE "public"."ct_shop_table_catalogs" ADD CONSTRAINT "ct_shop_table_catalogs_pkey" PRIMARY KEY ("global_id");
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
        'table_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID таблицы',
            'table' => 'DB_Table',
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
            'title' => 'Название каталога',
        ),
        'text' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Описание каталога (HTML-код)',
        ),
        'fields_options' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => '',
        ),
        'image_path' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 255,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Путь к изображению рубрики',
        ),
        'files' => array(
            'type' => DB_FieldType::FIELD_TYPE_FILES,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дополнительные файлы',
        ),
        'seo' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON массива настройки SEO',
        ),
        'form_data' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Данные формы JSON',
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
        'root_shop_table_catalog_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID таблицы родителя',
            'table' => 'DB_Shop_Table_Catalog',
        ),
        'root_table_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID таблицы родителя',
            'table' => 'DB_Table',
        ),
        'child_shop_table_catalog_ids' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON массива подчиненных элементов',
        ),
        'good_price_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип цены поля',
            'table' => 'DB_GoodPriceType',
        ),
        'image_types' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON списка типов файлов',
        ),
        'inset_sql_child' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'SQL запросы для после добавления записи (заменяется #id#)',
        ),
        'fields_params' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON списка параметров участвующие в поиске (param_1_int, param_1_float, param_1_str)',
        ),
        'param_index' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Порядковый номер поля (для shop_table_param_значение поля_id)',
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
