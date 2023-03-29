<?php defined('SYSPATH') or die('No direct script access.');

class DB_Shop_Operation_Stock {
    const TABLE_NAME = 'ct_shop_operation_stocks';
    const TABLE_ID = 61;
    const NAME = 'DB_Shop_Operation_Stock';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_shop_operation_stocks";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_shop_operation_stocks
                -- ----------------------------
                CREATE TABLE "public"."ct_shop_operation_stocks" (
                  "id" int8 NOT NULL,
                  "shop_id" int8 NOT NULL,
                  "shop_table_catalog_id" int8 NOT NULL DEFAULT 0,
                  "amount" numeric(12,2) NOT NULL,
                  "options" text COLLATE "pg_catalog"."default",
                  "name" varchar(100) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "create_user_id" int8 DEFAULT 0,
                  "update_user_id" int8 NOT NULL,
                  "delete_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "is_close" numeric(1) NOT NULL DEFAULT 0,
                  "shop_operation_id" int8 NOT NULL,
                  "amount_first" numeric(12,2) NOT NULL
                )
                ;
                COMMENT ON COLUMN "public"."ct_shop_operation_stocks"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ct_shop_operation_stocks"."amount" IS \'Стоимость заказа\';
                COMMENT ON COLUMN "public"."ct_shop_operation_stocks"."options" IS \'Данные JSON\';
                COMMENT ON COLUMN "public"."ct_shop_operation_stocks"."name" IS \'Название (ФИО)\';
                COMMENT ON COLUMN "public"."ct_shop_operation_stocks"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_operation_stocks"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_operation_stocks"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_shop_operation_stocks"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ct_shop_operation_stocks"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_shop_operation_stocks"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_operation_stocks"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ct_shop_operation_stocks"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_shop_operation_stocks"."is_close" IS \'Товар сдан\';
                COMMENT ON COLUMN "public"."ct_shop_operation_stocks"."shop_operation_id" IS \'ID оператора\';
                COMMENT ON COLUMN "public"."ct_shop_operation_stocks"."amount_first" IS \'Стоимость первоначальная\';
                COMMENT ON TABLE "public"."ct_shop_operation_stocks" IS \'Таблица заказов магазинов\';
                
                -- ----------------------------
                -- Indexes structure for table ct_shop_operation_stocks
                -- ----------------------------
                CREATE INDEX "shop_operation_stock_first" ON "public"."ct_shop_operation_stocks" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_operation_stock_index_id" ON "public"."ct_shop_operation_stocks" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_operation_stock_is_close" ON "public"."ct_shop_operation_stocks" USING btree (
                  "is_close" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_operation_stock_shop_operation_id" ON "public"."ct_shop_operation_stocks" USING btree (
                  "shop_operation_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_operation_stock_shop_table_catalog_id" ON "public"."ct_shop_operation_stocks" USING btree (
                  "shop_table_catalog_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ct_shop_operation_stocks
                -- ----------------------------
                ALTER TABLE "public"."ct_shop_operation_stocks" ADD CONSTRAINT "ct_shop_bills_copy_pkey2" PRIMARY KEY ("global_id");
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
        'shop_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID магазина',
            'table' => 'DB_Shop',
        ),
        'shop_table_catalog_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => 'DB_Shop_Table_Catalog',
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Стоимость заказа',
        ),
        'options' => array(
            'type' => DB_FieldType::FIELD_TYPE_JSON,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Данные JSON',
        ),
        'name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 100,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название (ФИО)',
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
        'is_close' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Товар сдан',
        ),
        'shop_operation_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID оператора',
            'table' => 'DB_Shop_Operation',
        ),
        'amount_first' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Стоимость первоначальная',
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
