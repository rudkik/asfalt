<?php defined('SYSPATH') or die('No direct script access.');

class DB_SiteShablon {
    const TABLE_NAME = 'ct_site_shablons';
    const TABLE_ID = 61;
    const NAME = 'DB_SiteShablon';
    const TITLE = 'Шаблоны сайтов';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_site_shablons";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_site_shablons
                -- ----------------------------
                CREATE TABLE "public"."ct_site_shablons" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "image_path" varchar(100) COLLATE "pg_catalog"."default",
                  "shablon_path" varchar(100) COLLATE "pg_catalog"."default",
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "options" text COLLATE "pg_catalog"."default",
                  "update_user_id" int8 NOT NULL,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6),
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "delete_user_id" int8 DEFAULT 0,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "files" text COLLATE "pg_catalog"."default",
                  "create_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "text" text COLLATE "pg_catalog"."default"
                )
                ;
                COMMENT ON COLUMN "public"."ct_site_shablons"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ct_site_shablons"."image_path" IS \'Путь до картинки шаблона\';
                COMMENT ON COLUMN "public"."ct_site_shablons"."shablon_path" IS \'Путь до шаблона\';
                COMMENT ON COLUMN "public"."ct_site_shablons"."name" IS \'Название шаблона\';
                COMMENT ON COLUMN "public"."ct_site_shablons"."options" IS \'JSON настроек страницы\';
                COMMENT ON COLUMN "public"."ct_site_shablons"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_site_shablons"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ct_site_shablons"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_site_shablons"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_site_shablons"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_site_shablons"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_site_shablons"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ct_site_shablons"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ct_site_shablons"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_site_shablons"."text" IS \'Описание \';
                COMMENT ON TABLE "public"."ct_site_shablons" IS \'Таблица шаблонов сайтов\';
                
                -- ----------------------------
                -- Indexes structure for table ct_site_shablons
                -- ----------------------------
                CREATE INDEX "site_shablon_first" ON "public"."ct_site_shablons" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "site_shablon_index_id" ON "public"."ct_site_shablons" USING btree (
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
        'image_path' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 100,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Путь до картинки шаблона',
        ),
        'shablon_path' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 100,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Путь до шаблона',
        ),
        'name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название шаблона',
        ),
        'options' => array(
            'type' => DB_FieldType::FIELD_TYPE_JSON,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON настроек страницы',
        ),
        'update_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Кто отредактировал эту запись',
            'table' => 'DB_User',
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
        'delete_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Кто удалил запись',
            'table' => 'DB_User',
        ),
        'global_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Глобальный ID',
        ),
        'language_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID языка',
            'table' => 'DB_Language',
        ),
        'files' => array(
            'type' => DB_FieldType::FIELD_TYPE_FILES,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дополнительные файлы',
        ),
        'create_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Кто отредактировал эту запись',
            'table' => 'DB_User',
        ),
        'created_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => '',
        ),
        'text' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Описание ',
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
