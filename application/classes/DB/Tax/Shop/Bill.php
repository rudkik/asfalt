<?php defined('SYSPATH') or die('No direct script access.');

class DB_Tax_Shop_Bill {
    const TABLE_NAME = 'tax_shop_bills';
    const TABLE_ID = 61;
    const NAME = 'DB_Tax_Shop_Bill';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."tax_shop_bills";',
            'create' => '
                -- ----------------------------
                -- Table structure for tax_shop_bills
                -- ----------------------------
                CREATE TABLE "public"."tax_shop_bills" (
                  "id" int8 NOT NULL,
                  "shop_id" int8 NOT NULL,
                  "shop_good_id" int8 NOT NULL DEFAULT 0,
                  "shop_paid_type_id" int8 NOT NULL DEFAULT 0,
                  "is_paid" numeric(1) NOT NULL DEFAULT 0,
                  "paid_at" timestamp(6),
                  "amount" numeric(12,2) NOT NULL,
                  "options" text COLLATE "pg_catalog"."default",
                  "create_user_id" int8 DEFAULT 0,
                  "update_user_id" int8 NOT NULL,
                  "delete_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "month" int4 NOT NULL DEFAULT 0,
                  "access_type_id" int4 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."tax_shop_bills"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."tax_shop_bills"."shop_good_id" IS \'ID товара\';
                COMMENT ON COLUMN "public"."tax_shop_bills"."shop_paid_type_id" IS \'Тип оплаты заказа\';
                COMMENT ON COLUMN "public"."tax_shop_bills"."is_paid" IS \'Оплачен ли заказ\';
                COMMENT ON COLUMN "public"."tax_shop_bills"."paid_at" IS \'Дата оплаты клиентом\';
                COMMENT ON COLUMN "public"."tax_shop_bills"."amount" IS \'Стоимость заказа\';
                COMMENT ON COLUMN "public"."tax_shop_bills"."options" IS \'Данные JSON\';
                COMMENT ON COLUMN "public"."tax_shop_bills"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."tax_shop_bills"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."tax_shop_bills"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."tax_shop_bills"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."tax_shop_bills"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."tax_shop_bills"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."tax_shop_bills"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."tax_shop_bills"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."tax_shop_bills"."month" IS \'Кол-во месяце\';
                COMMENT ON COLUMN "public"."tax_shop_bills"."access_type_id" IS \'Тип доступа\';
                COMMENT ON TABLE "public"."tax_shop_bills" IS \'Таблица заказов магазинов\';
                
                -- ----------------------------
                -- Indexes structure for table tax_shop_bills
                -- ----------------------------
                CREATE INDEX "tax_shop_bill_first" ON "public"."tax_shop_bills" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "tax_shop_bill_index_id" ON "public"."tax_shop_bills" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "tax_shop_bill_shop_good_id" ON "public"."tax_shop_bills" USING btree (
                  "shop_good_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "tax_shop_bill_shop_paid_type_id" ON "public"."tax_shop_bills" USING btree (
                  "shop_paid_type_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table tax_shop_bills
                -- ----------------------------
                ALTER TABLE "public"."tax_shop_bills" ADD CONSTRAINT "ct_shop_bills__copy_pkey" PRIMARY KEY ("global_id");
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
        'shop_good_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID товара',
            'table' => 'DB_Shop_Good',
        ),
        'shop_paid_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип оплаты заказа',
            'table' => 'DB_Shop_PaidType',
        ),
        'is_paid' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Оплачен ли заказ',
        ),
        'paid_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата оплаты клиентом',
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
        'month' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 9,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Кол-во месяце',
        ),
        'access_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 9,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип доступа',
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
