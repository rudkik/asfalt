<?php defined('SYSPATH') or die('No direct script access.');

class DB_Shop_Table_Child {
    const TABLE_NAME = 'ct_shop_table_childs';
    const TABLE_ID = 61;
    const NAME = 'DB_Shop_Table_Child';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_shop_table_childs";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_shop_table_childs
                -- ----------------------------
                CREATE TABLE "public"."ct_shop_table_childs" (
                  "id" int8 NOT NULL,
                  "root_table_id" int8 NOT NULL,
                  "shop_table_catalog_id" int8 NOT NULL DEFAULT 0,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "shop_root_table_catalog_id" int8 NOT NULL DEFAULT 0,
                  "shop_root_table_object_id" int8 NOT NULL DEFAULT 0,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "text" text COLLATE "pg_catalog"."default",
                  "options" text COLLATE "pg_catalog"."default",
                  "image_path" varchar(255) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "files" text COLLATE "pg_catalog"."default",
                  "seo" text COLLATE "pg_catalog"."default",
                  "remarketing" text COLLATE "pg_catalog"."default",
                  "create_user_id" int8 DEFAULT 0,
                  "update_user_id" int8 NOT NULL,
                  "delete_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "order" int4 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ct_shop_table_childs"."root_table_id" IS \'ID таблицы\';
                COMMENT ON COLUMN "public"."ct_shop_table_childs"."shop_table_catalog_id" IS \'ID типа объекта\';
                COMMENT ON COLUMN "public"."ct_shop_table_childs"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_table_childs"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ct_shop_table_childs"."shop_root_table_catalog_id" IS \'ID родителя типа объекта\';
                COMMENT ON COLUMN "public"."ct_shop_table_childs"."shop_root_table_object_id" IS \'ID объекта\';
                COMMENT ON COLUMN "public"."ct_shop_table_childs"."name" IS \'Название каталога\';
                COMMENT ON COLUMN "public"."ct_shop_table_childs"."text" IS \'Описание каталога (HTML-код)\';
                COMMENT ON COLUMN "public"."ct_shop_table_childs"."image_path" IS \'Путь к изображению рубрики\';
                COMMENT ON COLUMN "public"."ct_shop_table_childs"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ct_shop_table_childs"."seo" IS \'JSON массива настройки SEO\';
                COMMENT ON COLUMN "public"."ct_shop_table_childs"."remarketing" IS \'Код ремаркетинга\';
                COMMENT ON COLUMN "public"."ct_shop_table_childs"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_table_childs"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_table_childs"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_shop_table_childs"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ct_shop_table_childs"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_shop_table_childs"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_table_childs"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ct_shop_table_childs"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_shop_table_childs"."order" IS \'Позиция для сортировки\';
                COMMENT ON TABLE "public"."ct_shop_table_childs" IS \'Таблица новостей магазинов\';
                
                -- ----------------------------
                -- Indexes structure for table ct_shop_table_childs
                -- ----------------------------
                CREATE INDEX "shop_table_child_index_id" ON "public"."ct_shop_table_childs" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_table_child_root_shop_table_catalog_id" ON "public"."ct_shop_table_childs" USING btree (
                  "shop_root_table_catalog_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_table_child_root_shop_table_rubric_id" ON "public"."ct_shop_table_childs" USING btree (
                  "shop_root_table_object_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ct_shop_table_childs
                -- ----------------------------
                ALTER TABLE "public"."ct_shop_table_childs" ADD CONSTRAINT "ct_shop_table_hashtags_copy_pkey1" PRIMARY KEY ("global_id");
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
        'root_table_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID таблицы',
            'table' => 'DB_Table',
        ),
        'shop_table_catalog_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID типа объекта',
            'table' => 'DB_Shop_Table_Catalog',
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
        'shop_root_table_catalog_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID родителя типа объекта',
            'table' => 'DB_Shop_Table_Catalog',
        ),
        'shop_root_table_object_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID объекта',
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
        'options' => array(
            'type' => DB_FieldType::FIELD_TYPE_JSON,
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
        'remarketing' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Код ремаркетинга',
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
