<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_TableUpdateDate {
    const TABLE_NAME = 'ab_table_update_dates';
    const TABLE_ID = 369;
    const NAME = 'DB_Ab1_TableUpdateDate';
    const TITLE = 'Дата последнего обновления';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_table_update_dates";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_table_update_dates
                -- ----------------------------
                CREATE TABLE "public"."ab_table_update_dates" (
                  "id" int8 NOT NULL,
                  "name" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
                  "update_user_id" int8 NOT NULL,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6),
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "delete_user_id" int8 DEFAULT 0,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "sql" text COLLATE "pg_catalog"."default",
                  "create_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone
                )
                ;
                COMMENT ON COLUMN "public"."ab_table_update_dates"."name" IS \'Название таблицы\';
                COMMENT ON COLUMN "public"."ab_table_update_dates"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_table_update_dates"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_table_update_dates"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_table_update_dates"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_table_update_dates"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_table_update_dates"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_table_update_dates"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_table_update_dates"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_table_update_dates"."create_user_id" IS \'Кто создал эту запись\';
                COMMENT ON TABLE "public"."ab_table_update_dates" IS \'Запросы на обновления \';
                
                -- ----------------------------
                -- Indexes structure for table ab_table_update_dates
                -- ----------------------------
                CREATE INDEX "ab_table_update_date_created_at" ON "public"."ab_table_update_dates" USING btree (
                  "created_at" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_table_update_date_first" ON "public"."ab_table_update_dates" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_table_update_date_index_id" ON "public"."ab_table_update_dates" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ab_table_update_dates
                -- ----------------------------
                ALTER TABLE "public"."ab_table_update_dates" ADD CONSTRAINT "ct_tables_copy1_pkey" PRIMARY KEY ("global_id");    
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
        'create_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Кто создал эту запись',
            'table' => 'DB_User',
        ),
        'created_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => '',
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
