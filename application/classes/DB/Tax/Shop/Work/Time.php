<?php defined('SYSPATH') or die('No direct script access.');

class DB_Tax_Shop_Work_Time {
    const TABLE_NAME = 'tax_shop_work_times';
    const TABLE_ID = 61;
    const NAME = 'DB_Tax_Shop_Work_Time';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."tax_shop_work_times";',
            'create' => '
                -- ----------------------------
                -- Table structure for tax_shop_work_times
                -- ----------------------------
                CREATE TABLE "public"."tax_shop_work_times" (
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
                  "shop_worker_id" int8 NOT NULL DEFAULT 0,
                  "wage" numeric(12,2) NOT NULL DEFAULT 0,
                  "date_from" date DEFAULT NULL::timestamp without time zone,
                  "date_to" date DEFAULT NULL::timestamp without time zone,
                  "work_time_type_id" int8 NOT NULL DEFAULT 0,
                  "days" int8 NOT NULL DEFAULT 0,
                  "work_days" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."tax_shop_work_times"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."tax_shop_work_times"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."tax_shop_work_times"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."tax_shop_work_times"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."tax_shop_work_times"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."tax_shop_work_times"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."tax_shop_work_times"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."tax_shop_work_times"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."tax_shop_work_times"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."tax_shop_work_times"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."tax_shop_work_times"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."tax_shop_work_times"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."tax_shop_work_times"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."tax_shop_work_times"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."tax_shop_work_times"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."tax_shop_work_times"."shop_worker_id" IS \'ID работника\';
                COMMENT ON COLUMN "public"."tax_shop_work_times"."wage" IS \'Оплата за время\';
                COMMENT ON COLUMN "public"."tax_shop_work_times"."date_from" IS \'Дата начала\';
                COMMENT ON COLUMN "public"."tax_shop_work_times"."date_to" IS \'Дата окончания\';
                COMMENT ON COLUMN "public"."tax_shop_work_times"."work_time_type_id" IS \'ID тип времени (прогул, отпуск, больничный и т.д.)\';
                COMMENT ON COLUMN "public"."tax_shop_work_times"."days" IS \'Кол-во дней\';
                COMMENT ON COLUMN "public"."tax_shop_work_times"."work_days" IS \'Кол-во рабочих дней\';
                
                -- ----------------------------
                -- Indexes structure for table tax_shop_work_times
                -- ----------------------------
                CREATE INDEX "tax_work_time_index_id" ON "public"."tax_shop_work_times" USING btree (
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
        'shop_worker_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID работника',
            'table' => 'DB_Tax_Shop_Worker',
        ),
        'wage' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Оплата за время',
        ),
        'date_from' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата начала',
        ),
        'date_to' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата окончания',
        ),
        'work_time_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID тип времени (прогул, отпуск, больничный и т.д.)',
            'table' => 'DB_Tax_WorkTimeType',
        ),
        'days' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Кол-во дней',
        ),
        'work_days' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Кол-во рабочих дней',
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
