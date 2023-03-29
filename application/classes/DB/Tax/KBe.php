<?php defined('SYSPATH') or die('No direct script access.');

class DB_Tax_KBe {
    const TABLE_NAME = 'tax_kbes';
    const TABLE_ID = 61;
    const NAME = 'DB_Tax_KBe';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."tax_kbes";',
            'create' => '
                -- ----------------------------
                -- Table structure for tax_kbes
                -- ----------------------------
                CREATE TABLE "public"."tax_kbes" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "name" text COLLATE "pg_catalog"."default" NOT NULL,
                  "update_user_id" int8 NOT NULL,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6),
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "delete_user_id" int8 DEFAULT 0,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "options" text COLLATE "pg_catalog"."default",
                  "fields_options" text COLLATE "pg_catalog"."default",
                  "code" int4 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."tax_kbes"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."tax_kbes"."name" IS \'Название типа оплаты\';
                COMMENT ON COLUMN "public"."tax_kbes"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."tax_kbes"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."tax_kbes"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."tax_kbes"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."tax_kbes"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."tax_kbes"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."tax_kbes"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."tax_kbes"."options" IS \'Дополнительные поля для оплаты\';
                COMMENT ON COLUMN "public"."tax_kbes"."fields_options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."tax_kbes"."code" IS \'Код\';
                COMMENT ON TABLE "public"."tax_kbes" IS \'Таблица типов оплаты\';
                
                -- ----------------------------
                -- Indexes structure for table tax_kbes
                -- ----------------------------
                CREATE INDEX "paid_type_first_copy2_copy2_copy2" ON "public"."tax_kbes" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "paid_type_index_id_copy2_copy2_copy2" ON "public"."tax_kbes" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table tax_kbes
                -- ----------------------------
                ALTER TABLE "public"."tax_kbes" ADD CONSTRAINT "tax_kbks_copy1_pkey1" PRIMARY KEY ("global_id");
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
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Название типа оплаты',
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
        'options' => array(
            'type' => DB_FieldType::FIELD_TYPE_JSON,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дополнительные поля для оплаты',
        ),
        'fields_options' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дополнительные поля',
        ),
        'code' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 9,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Код',
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
