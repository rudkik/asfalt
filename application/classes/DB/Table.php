<?php defined('SYSPATH') or die('No direct script access.');

class DB_Table {
    const TABLE_NAME = 'ct_tables';
    const TABLE_ID = 61;
    const NAME = 'DB_Table';
    const TITLE = 'Таблицы';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_tables";',
            'create' => '
                -- ----------------------------
            -- Table structure for ct_tables
            -- ----------------------------
            CREATE TABLE "public"."ct_tables" (
              "id" int8 NOT NULL,
              "name" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
              "update_user_id" int8 NOT NULL,
              "updated_at" timestamp(6) NOT NULL,
              "deleted_at" timestamp(6),
              "is_delete" numeric(1) NOT NULL DEFAULT 0,
              "delete_user_id" int8 DEFAULT 0,
              "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
              "language_id" int8 NOT NULL DEFAULT 35,
              "is_public" numeric(1) NOT NULL DEFAULT 1
            )
            ;
            COMMENT ON COLUMN "public"."ct_tables"."name" IS \'Название таблицы\';
            COMMENT ON COLUMN "public"."ct_tables"."update_user_id" IS \'Кто отредактировал эту запись\';
            COMMENT ON COLUMN "public"."ct_tables"."updated_at" IS \'Дата обновления записи\';
            COMMENT ON COLUMN "public"."ct_tables"."deleted_at" IS \'Дата удаления записи\';
            COMMENT ON COLUMN "public"."ct_tables"."is_delete" IS \'Удалена ли запись\';
            COMMENT ON COLUMN "public"."ct_tables"."delete_user_id" IS \'Кто удалил запись\';
            COMMENT ON COLUMN "public"."ct_tables"."global_id" IS \'Глобальный ID\';
            COMMENT ON COLUMN "public"."ct_tables"."language_id" IS \'ID языка\';
            COMMENT ON COLUMN "public"."ct_tables"."is_public" IS \'Опубликована ли запись\';
            COMMENT ON TABLE "public"."ct_tables" IS \'Список таблиц\';
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
        'name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Название таблицы',
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
        'is_public' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Опубликована ли запись',
        ),
        'title' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Название таблицы',
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
