<?php defined('SYSPATH') or die('No direct script access.');

class DB_Bank {
    const TABLE_NAME = 'ct_banks';
    const TABLE_ID = 61;
    const NAME = 'DB_Bank';
    const TITLE = 'Банки';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_banks";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_banks
                -- ----------------------------
                CREATE TABLE "public"."ct_banks" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "name" varchar(250) COLLATE "pg_catalog"."default" NOT NULL,
                  "bik" varchar(8) COLLATE "pg_catalog"."default",
                  "address" text COLLATE "pg_catalog"."default",
                  "update_user_id" int8 NOT NULL,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6),
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "delete_user_id" int8 DEFAULT 0,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "bin" varchar(12) COLLATE "pg_catalog"."default"
                )
                ;
                COMMENT ON COLUMN "public"."ct_banks"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ct_banks"."name" IS \'Название статуса\';
                COMMENT ON COLUMN "public"."ct_banks"."bik" IS \'БИК\';
                COMMENT ON COLUMN "public"."ct_banks"."address" IS \'Адрес\';
                COMMENT ON COLUMN "public"."ct_banks"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_banks"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ct_banks"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_banks"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_banks"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_banks"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_banks"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ct_banks"."bin" IS \'БИН\';
                COMMENT ON TABLE "public"."ct_banks" IS \'Таблица банков\';
                
                -- ----------------------------
                -- Indexes structure for table ct_banks
                -- ----------------------------
                CREATE INDEX "bank_first" ON "public"."ct_banks" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "bank_index_id" ON "public"."ct_banks" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ct_banks
                -- ----------------------------
                ALTER TABLE "public"."ct_banks" ADD CONSTRAINT "ct_banks_pkey" PRIMARY KEY ("global_id");
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
        'name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Название статуса',
        ),
        'bik' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 8,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'БИК',
        ),
        'address' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Адрес',
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
        'bin' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 12,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'БИН',
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
