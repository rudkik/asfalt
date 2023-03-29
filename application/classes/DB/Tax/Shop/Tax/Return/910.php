<?php defined('SYSPATH') or die('No direct script access.');

class DB_Tax_Shop_Tax_Return_910 {
    const TABLE_NAME = 'tax_shop_tax_return_910s';
    const TABLE_ID = 61;
    const NAME = 'DB_Tax_Shop_Tax_Return_910';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."tax_shop_tax_return_910s";',
            'create' => '
                -- ----------------------------
                -- Table structure for tax_shop_tax_return_910s
                -- ----------------------------
                CREATE TABLE "public"."tax_shop_tax_return_910s" (
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
                  "revenue" numeric(12,2) NOT NULL DEFAULT 0,
                  "half_year" numeric(1) NOT NULL DEFAULT 0,
                  "year" numeric(4) NOT NULL DEFAULT 0,
                  "data" text COLLATE "pg_catalog"."default",
                  "opv" numeric(12,2) NOT NULL DEFAULT 0,
                  "so" numeric(12,2) NOT NULL DEFAULT 0,
                  "ipn" numeric(12,2) NOT NULL DEFAULT 0,
                  "osms" numeric(12,2) NOT NULL DEFAULT 0,
                  "ikpn" numeric(12,2) NOT NULL DEFAULT 0,
                  "sn" numeric(12,2) NOT NULL DEFAULT 0,
                  "tax_status_id" int8 NOT NULL DEFAULT 0,
                  "tax_view_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."revenue" IS \'Общий доход\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."half_year" IS \'Полугодие\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."year" IS \'Год\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."data" IS \'JSON Данные для просчета отчета\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."opv" IS \'Обязательная пенсионная выплата\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."so" IS \'Cоциальные отчисления\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."ipn" IS \'Индивидуальный подоходный налог\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."osms" IS \'Обязательное социальное медицинское страхование\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."ikpn" IS \'Индивидуальный корпоративный подоходный налог\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."sn" IS \'Cоциальный налог\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."tax_status_id" IS \'ID статуса сдачи отчета в налоговую\';
                COMMENT ON COLUMN "public"."tax_shop_tax_return_910s"."tax_view_id" IS \'Вид декларации\';
                
                -- ----------------------------
                -- Indexes structure for table tax_shop_tax_return_910s
                -- ----------------------------
                CREATE INDEX "ab_shop_car_index_id_copy3_copy3" ON "public"."tax_shop_tax_return_910s" USING btree (
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
        'revenue' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Общий доход',
        ),
        'half_year' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Полугодие',
        ),
        'year' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 4,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Год',
        ),
        'data' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON Данные для просчета отчета',
        ),
        'opv' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Обязательная пенсионная выплата',
        ),
        'so' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Cоциальные отчисления',
        ),
        'ipn' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Индивидуальный подоходный налог',
        ),
        'osms' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Обязательное социальное медицинское страхование',
        ),
        'ikpn' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Индивидуальный корпоративный подоходный налог',
        ),
        'sn' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Cоциальный налог',
        ),
        'tax_status_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID статуса сдачи отчета в налоговую',
            'table' => 'DB_Tax_Status',
        ),
        'tax_view_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Вид декларации',
            'table' => 'DB_Tax_View',
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
