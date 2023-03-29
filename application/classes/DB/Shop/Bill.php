<?php defined('SYSPATH') or die('No direct script access.');

class DB_Shop_Bill {
    const TABLE_NAME = 'ct_shop_bills';
    const TABLE_ID = 61;
    const NAME = 'DB_Shop_Bill';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_shop_bills";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_shop_bills
                -- ----------------------------
                CREATE TABLE "public"."ct_shop_bills" (
                  "id" int8 NOT NULL,
                  "shop_id" int8 NOT NULL,
                  "shop_table_catalog_id" int8 NOT NULL DEFAULT 0,
                  "shop_bill_status_id" int8 NOT NULL DEFAULT 5,
                  "bill_status_id" int8 NOT NULL DEFAULT 0,
                  "shop_paid_type_id" int8 NOT NULL DEFAULT 0,
                  "shop_delivery_type_id" int8 NOT NULL DEFAULT 0,
                  "shop_coupon_id" int8 NOT NULL DEFAULT 0,
                  "shop_root_id" int8 NOT NULL DEFAULT 0,
                  "country_id" int8 DEFAULT 0,
                  "city_id" int8 DEFAULT 0,
                  "shop_bill_root_id" int8 DEFAULT 0,
                  "currency_id" int8 NOT NULL DEFAULT 18,
                  "is_paid" numeric(1) NOT NULL DEFAULT 0,
                  "paid_at" timestamp(6),
                  "is_delivery" numeric(1) NOT NULL DEFAULT 0,
                  "delivery_at" timestamp(6),
                  "delivery_amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "amount" numeric(12,2) NOT NULL,
                  "discount" numeric(5,2) NOT NULL DEFAULT 0,
                  "is_percent" numeric(1) NOT NULL DEFAULT 0,
                  "shop_comment" text COLLATE "pg_catalog"."default",
                  "client_comment" text COLLATE "pg_catalog"."default",
                  "cancel_comment" text COLLATE "pg_catalog"."default",
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
                  "paid_amount" numeric(12,2) NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ct_shop_bills"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."shop_bill_status_id" IS \'ID статус заказа\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."bill_status_id" IS \'ID статус заказа\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."shop_paid_type_id" IS \'Тип оплаты заказа\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."shop_delivery_type_id" IS \'Тип доставки заказа\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."shop_coupon_id" IS \'ID купона\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."shop_root_id" IS \'ID родителя магазина создавшего заказ\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."country_id" IS \'Страна\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."city_id" IS \'Город\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."shop_bill_root_id" IS \'Связать заказы\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."currency_id" IS \'ID валюты заказа\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."is_paid" IS \'Оплачен ли заказ\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."paid_at" IS \'Дата оплаты клиентом\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."is_delivery" IS \'Доставлен ли заказ\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."delivery_at" IS \'Фактическое время доставки заказа\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."delivery_amount" IS \'Стоимость доставки\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."amount" IS \'Стоимость заказа\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."discount" IS \'Скидка на заказ\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."is_percent" IS \'Скидка в процентах или в деньгах (0 - процент, 1 - в деньгах )\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."shop_comment" IS \'Комментарий магазина\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."client_comment" IS \'Комментарий клиента\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."cancel_comment" IS \'Причина отказа от заказа\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."options" IS \'Данные JSON\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."name" IS \'Название (ФИО)\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_shop_bills"."paid_amount" IS \'Оплаченная сумма\';
                COMMENT ON TABLE "public"."ct_shop_bills" IS \'Таблица заказов магазинов\';
                
                -- ----------------------------
                -- Indexes structure for table ct_shop_bills
                -- ----------------------------
                CREATE INDEX "shop_bill_bill_status_id" ON "public"."ct_shop_bills" USING btree (
                  "bill_status_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_bill_city_id" ON "public"."ct_shop_bills" USING btree (
                  "city_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_bill_country_id" ON "public"."ct_shop_bills" USING btree (
                  "country_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_bill_first" ON "public"."ct_shop_bills" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_bill_index_id" ON "public"."ct_shop_bills" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_bill_name_like" ON "public"."ct_shop_bills" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_bill_shop_bill_root_id" ON "public"."ct_shop_bills" USING btree (
                  "shop_bill_root_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_bill_shop_bill_status_id" ON "public"."ct_shop_bills" USING btree (
                  "shop_bill_status_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_bill_shop_coupon_id" ON "public"."ct_shop_bills" USING btree (
                  "shop_coupon_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_bill_shop_delivery_type_id" ON "public"."ct_shop_bills" USING btree (
                  "shop_delivery_type_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_bill_shop_paid_type_id" ON "public"."ct_shop_bills" USING btree (
                  "shop_paid_type_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_bill_shop_root_id" ON "public"."ct_shop_bills" USING btree (
                  "shop_root_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_bill_shop_table_catalog_id" ON "public"."ct_shop_bills" USING btree (
                  "shop_table_catalog_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ct_shop_bills
                -- ----------------------------
                ALTER TABLE "public"."ct_shop_bills" ADD CONSTRAINT "ct_shop_bills__copy_pkey" PRIMARY KEY ("global_id");
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
        'shop_bill_status_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID статус заказа',
            'table' => 'DB_Shop_Bill_Status',
        ),
        'bill_status_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID статус заказа',
            'table' => 'DB_BillStatus',
        ),
        'shop_paid_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип оплаты заказа',
            'table' => 'DB_Shop_PaidType',
        ),
        'shop_delivery_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип доставки заказа',
            'table' => 'DB_Shop_DeliveryType',
        ),
        'shop_coupon_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID купона',
            'table' => 'DB_Shop_Coupon',
        ),
        'shop_root_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID родителя магазина создавшего заказ',
        ),
        'country_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Страна',
            'table' => 'DB_Land',
        ),
        'city_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Город',
            'table' => 'DB_City',
        ),
        'shop_bill_root_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Связать заказы',
        ),
        'currency_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID валюты заказа',
            'table' => 'DB_Currency',
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
        'is_delivery' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Доставлен ли заказ',
        ),
        'delivery_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Фактическое время доставки заказа',
        ),
        'delivery_amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Стоимость доставки',
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Стоимость заказа',
        ),
        'discount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 5,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Скидка на заказ',
        ),
        'is_percent' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Скидка в процентах или в деньгах (0 - процент, 1 - в деньгах )',
        ),
        'shop_comment' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Комментарий магазина',
        ),
        'client_comment' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Комментарий клиента',
        ),
        'cancel_comment' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Причина отказа от заказа',
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
        'paid_amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Оплаченная сумма',
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
