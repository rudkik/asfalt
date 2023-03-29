<?php defined('SYSPATH') or die('No direct script access.');

class DB_Currency {
    const TABLE_NAME = 'ct_currencies';
    const TABLE_ID = 61;
    const NAME = 'DB_Currency';
    const TITLE = 'Валюты';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_currencies";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_currencies
                -- ----------------------------
                CREATE TABLE "public"."ct_currencies" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "name" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
                  "code" varchar(50) COLLATE "pg_catalog"."default",
                  "symbol" varchar(50) COLLATE "pg_catalog"."default",
                  "currency_rate" numeric(14,10) NOT NULL DEFAULT 0,
                  "is_round" numeric(1) NOT NULL DEFAULT 0,
                  "update_user_id" int8 NOT NULL,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6),
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "delete_user_id" int8 DEFAULT 0,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "language_id" int8 NOT NULL DEFAULT 35
                )
                ;
                COMMENT ON COLUMN "public"."ct_currencies"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ct_currencies"."name" IS \'Название валюты\';
                COMMENT ON COLUMN "public"."ct_currencies"."code" IS \'Код валюты (KZT)\';
                COMMENT ON COLUMN "public"."ct_currencies"."symbol" IS \'Шаблон для вывода данных ({amount} тг)\';
                COMMENT ON COLUMN "public"."ct_currencies"."currency_rate" IS \'Курс валюты\';
                COMMENT ON COLUMN "public"."ct_currencies"."is_round" IS \'Округлять значение до целого при скидках\';
                COMMENT ON COLUMN "public"."ct_currencies"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_currencies"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ct_currencies"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_currencies"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_currencies"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_currencies"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_currencies"."language_id" IS \'ID языка\';
                COMMENT ON TABLE "public"."ct_currencies" IS \'Таблица валют\';
                
                -- ----------------------------
                -- Indexes structure for table ct_currencies
                -- ----------------------------
                CREATE INDEX "currency_first" ON "public"."ct_currencies" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "currency_index_id" ON "public"."ct_currencies" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "currency_name_like" ON "public"."ct_currencies" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ct_currencies
                -- ----------------------------
                ALTER TABLE "public"."ct_currencies" ADD CONSTRAINT "ct_currencies_pkey" PRIMARY KEY ("global_id");
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
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Название валюты',
        ),
        'code' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Код валюты (KZT)',
        ),
        'symbol' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Шаблон для вывода данных ({amount} тг)',
        ),
        'currency_rate' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 14,
            'decimal' => 10,
            'is_not_null' => true,
            'title' => 'Курс валюты',
        ),
        'is_round' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Округлять значение до целого при скидках',
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
