<?php defined('SYSPATH') or die('No direct script access.');

class DB_Tax_Shop_Worker {
    const TABLE_NAME = 'tax_shop_attorneys';
    const TABLE_ID = 61;
    const NAME = 'DB_Tax_Shop_Worker';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."tax_shop_attorneys";',
            'create' => '
                -- ----------------------------
                -- Table structure for tax_shop_workers
                -- ----------------------------
                CREATE TABLE "public"."tax_shop_workers" (
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
                  "iin" varchar(12) COLLATE "pg_catalog"."default",
                  "date_of_birth" date DEFAULT NULL::timestamp without time zone,
                  "date_from" date DEFAULT NULL::timestamp without time zone,
                  "number" varchar(12) COLLATE "pg_catalog"."default",
                  "name_d" varchar(250) COLLATE "pg_catalog"."default",
                  "issued_by" varchar(250) COLLATE "pg_catalog"."default",
                  "position" varchar(250) COLLATE "pg_catalog"."default",
                  "date_work_from" date DEFAULT NULL::timestamp without time zone,
                  "date_work_to" date DEFAULT NULL::timestamp without time zone,
                  "wage_basic" numeric(12,2) NOT NULL DEFAULT 0,
                  "worker_status_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."tax_shop_workers"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."tax_shop_workers"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."iin" IS \'ИИН\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."date_of_birth" IS \'Дата рождения\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."date_from" IS \'Дата выдачи удостоверения личности\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."number" IS \'Номер удостоверения личности\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."name_d" IS \'ФИО в дательном падеже\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."issued_by" IS \'Кем выдано\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."position" IS \'Должность\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."date_work_from" IS \'Дата начала работы\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."date_work_to" IS \'Дата окончания работы\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."wage_basic" IS \'Базовая заработная плата\';
                COMMENT ON COLUMN "public"."tax_shop_workers"."worker_status_id" IS \'ID статуса работника\';
                
                -- ----------------------------
                -- Indexes structure for table tax_shop_workers
                -- ----------------------------
                CREATE INDEX "ab_shop_car_index_id_copy5" ON "public"."tax_shop_workers" USING btree (
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
        'iin' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 12,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ИИН',
        ),
        'date_of_birth' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата рождения',
        ),
        'date_from' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата выдачи удостоверения личности',
        ),
        'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 12,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер удостоверения личности',
        ),
        'name_d' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ФИО в дательном падеже',
        ),
        'issued_by' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Кем выдано',
        ),
        'position' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Должность',
        ),
        'date_work_from' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата начала работы',
        ),
        'date_work_to' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата окончания работы',
        ),
        'wage_basic' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Базовая заработная плата',
        ),
        'worker_status_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID статуса работника',
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
