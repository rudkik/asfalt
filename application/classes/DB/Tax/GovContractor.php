<?php defined('SYSPATH') or die('No direct script access.');

class DB_Tax_GovContractor {
    const TABLE_NAME = 'tax_gov_contractors';
    const TABLE_ID = 61;
    const NAME = 'DB_Tax_GovContractor';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."tax_gov_contractors";',
            'create' => '
                -- ----------------------------
                -- Table structure for tax_gov_contractors
                -- ----------------------------
                CREATE TABLE "public"."tax_gov_contractors" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "text" text COLLATE "pg_catalog"."default",
                  "options" text COLLATE "pg_catalog"."default",
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
                  "bank_id" int8 NOT NULL DEFAULT 0,
                  "bin" varchar(12) COLLATE "pg_catalog"."default",
                  "bik" varchar(8) COLLATE "pg_catalog"."default",
                  "iik" varchar(100) COLLATE "pg_catalog"."default"
                )
                ;
                COMMENT ON COLUMN "public"."tax_gov_contractors"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."tax_gov_contractors"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."tax_gov_contractors"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."tax_gov_contractors"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."tax_gov_contractors"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."tax_gov_contractors"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."tax_gov_contractors"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."tax_gov_contractors"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."tax_gov_contractors"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."tax_gov_contractors"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."tax_gov_contractors"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."tax_gov_contractors"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."tax_gov_contractors"."bank_id" IS \'ID банка\';
                COMMENT ON COLUMN "public"."tax_gov_contractors"."bin" IS \'БИН\';
                COMMENT ON COLUMN "public"."tax_gov_contractors"."bik" IS \'БИК\';
                COMMENT ON COLUMN "public"."tax_gov_contractors"."iik" IS \'ИИК\';
                
                -- ----------------------------
                -- Indexes structure for table tax_gov_contractors
                -- ----------------------------
                CREATE INDEX "ab_shop_car_index_id_copy6" ON "public"."tax_gov_contractors" USING btree (
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
        'options' => array(
            'type' => DB_FieldType::FIELD_TYPE_JSON,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дополнительные поля',
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
        'bank_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID банка',
            'table' => 'DB_Bank',
        ),
        'bin' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 12,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'БИН',
        ),
        'bik' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 8,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'БИК',
        ),
        'iik' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 100,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ИИК',
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
