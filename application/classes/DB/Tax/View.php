<?php defined('SYSPATH') or die('No direct script access.');

class DB_Tax_View {
    const TABLE_NAME = 'tax_views';
    const TABLE_ID = 61;
    const NAME = 'DB_Tax_View';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."tax_views";',
            'create' => '
                -- ----------------------------
                -- Table structure for tax_views
                -- ----------------------------
                CREATE TABLE "public"."tax_views" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "name" varchar(250) COLLATE "pg_catalog"."default" NOT NULL,
                  "update_user_id" int8 NOT NULL,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6),
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "delete_user_id" int8 DEFAULT 0,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "options" text COLLATE "pg_catalog"."default",
                  "fields_options" text COLLATE "pg_catalog"."default"
                )
                ;
                COMMENT ON COLUMN "public"."tax_views"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."tax_views"."name" IS \'Название типа оплаты\';
                COMMENT ON COLUMN "public"."tax_views"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."tax_views"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."tax_views"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."tax_views"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."tax_views"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."tax_views"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."tax_views"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."tax_views"."options" IS \'Дополнительные поля для оплаты\';
                COMMENT ON COLUMN "public"."tax_views"."fields_options" IS \'Дополнительные поля\';
                COMMENT ON TABLE "public"."tax_views" IS \'Таблица типов оплаты\';
                
                -- ----------------------------
                -- Indexes structure for table tax_views
                -- ----------------------------
                CREATE INDEX "paid_type_first_copy4" ON "public"."tax_views" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "paid_type_index_id_copy4" ON "public"."tax_views" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table tax_views
                -- ----------------------------
                ALTER TABLE "public"."tax_views" ADD CONSTRAINT "tax_paid_types_copy1_pkey3" PRIMARY KEY ("global_id");
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
