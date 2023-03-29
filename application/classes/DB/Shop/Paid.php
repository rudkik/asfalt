<?php defined('SYSPATH') or die('No direct script access.');

class DB_Shop_Paid {
    const TABLE_NAME = 'ct_shop_paids';
    const TABLE_ID = 61;
    const NAME = 'DB_Shop_Paid';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_shop_paids";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_shop_paids
                -- ----------------------------
                CREATE TABLE "public"."ct_shop_paids" (
                  "id" int8 NOT NULL,
                  "shop_id" int8 NOT NULL,
                  "shop_table_catalog_id" int8 NOT NULL DEFAULT 0,
                  "shop_bill_id" int8 NOT NULL DEFAULT 5,
                  "shop_paid_type_id" int8 NOT NULL DEFAULT 0,
                  "paid_shop_id" int8 NOT NULL DEFAULT 0,
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
                  "text" text COLLATE "pg_catalog"."default",
                  "paid_type_id" int8 NOT NULL DEFAULT 902,
                  "shop_operation_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_rubric_id" int8 NOT NULL DEFAULT 0,
                  "amount" numeric(13,2) NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ct_shop_paids"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ct_shop_paids"."shop_bill_id" IS \'ID заказа\';
                COMMENT ON COLUMN "public"."ct_shop_paids"."shop_paid_type_id" IS \'Тип оплаты заказа\';
                COMMENT ON COLUMN "public"."ct_shop_paids"."paid_shop_id" IS \'ID магазина сделавший проплату\';
                COMMENT ON COLUMN "public"."ct_shop_paids"."options" IS \'Данные JSON\';
                COMMENT ON COLUMN "public"."ct_shop_paids"."name" IS \'Название (ФИО)\';
                COMMENT ON COLUMN "public"."ct_shop_paids"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_paids"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_paids"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_shop_paids"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ct_shop_paids"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_shop_paids"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_paids"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ct_shop_paids"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_shop_paids"."text" IS \'Описание каталога (HTML-код)\';
                COMMENT ON COLUMN "public"."ct_shop_paids"."paid_type_id" IS \'Способ оплаты\';
                COMMENT ON COLUMN "public"."ct_shop_paids"."shop_operation_id" IS \'Какой оператор внес оплату\';
                COMMENT ON COLUMN "public"."ct_shop_paids"."shop_table_rubric_id" IS \'ID рубрики\';
                COMMENT ON COLUMN "public"."ct_shop_paids"."amount" IS \'Сумма\';
                COMMENT ON TABLE "public"."ct_shop_paids" IS \'Таблица заказов магазинов\';
                
                -- ----------------------------
                -- Indexes structure for table ct_shop_paids
                -- ----------------------------
                CREATE INDEX "shop_paid_first" ON "public"."ct_shop_paids" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_paid_index_id_copy" ON "public"."ct_shop_paids" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_paid_name_like" ON "public"."ct_shop_paids" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_paid_shop_bill_id" ON "public"."ct_shop_paids" USING btree (
                  "shop_bill_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_paid_shop_branch_id_copy" ON "public"."ct_shop_paids" USING btree (
                  "paid_shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_paid_shop_paid_type_id" ON "public"."ct_shop_paids" USING btree (
                  "shop_paid_type_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_paid_shop_table_catalog_id" ON "public"."ct_shop_paids" USING btree (
                  "shop_table_catalog_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_paid_shop_table_rubric_id" ON "public"."ct_shop_paids" USING btree (
                  "shop_table_rubric_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ct_shop_paids
                -- ----------------------------
                ALTER TABLE "public"."ct_shop_paids" ADD CONSTRAINT "ct_shop_bills_copy_pkey" PRIMARY KEY ("global_id");
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
        'shop_bill_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID заказа',
            'table' => 'DB_Shop_Bill',
        ),
        'shop_paid_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип оплаты заказа',
            'table' => 'DB_Shop_PaidType',
        ),
        'paid_shop_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID магазина сделавший проплату',
            'table' => 'DB_Shop',
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
        'text' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Описание каталога (HTML-код)',
        ),
        'paid_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Способ оплаты',
            'table' => 'DB_PaidType',
        ),
        'shop_operation_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Какой оператор внес оплату',
            'table' => 'DB_Shop_Operation',
        ),
        'shop_table_rubric_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID рубрики',
            'table' => 'DB_Shop_Table_Rubric',
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 13,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма',
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
