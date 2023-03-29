<?php defined('SYSPATH') or die('No direct script access.');

class DB_Hotel_Shop_Bill {
    const TABLE_NAME = 'hc_shop_bills';
    const TABLE_ID = 61;
    const NAME = 'DB_Hotel_Shop_Bill';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."hc_shop_bills";',
            'create' => '
                -- ----------------------------
                -- Table structure for hc_shop_bills
                -- ----------------------------
                CREATE TABLE "public"."hc_shop_bills" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "text" text COLLATE "pg_catalog"."default",
                  "image_path" varchar(100) COLLATE "pg_catalog"."default",
                  "files" text COLLATE "pg_catalog"."default",
                  "options" text COLLATE "pg_catalog"."default",
                  "collations" text COLLATE "pg_catalog"."default",
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
                  "shop_client_id" int8 DEFAULT 0,
                  "paid_type_id" int8 DEFAULT 0,
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "paid_amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "date_from" date DEFAULT NULL::timestamp without time zone,
                  "date_to" date DEFAULT NULL::timestamp without time zone,
                  "limit_time" timestamp(6),
                  "amount_items" numeric(12,2) NOT NULL DEFAULT 0,
                  "amount_services" numeric(12,2) NOT NULL DEFAULT 0,
                  "number" varchar(64) COLLATE "pg_catalog"."default",
                  "shop_paid_type_id" int8 DEFAULT 0,
                  "discount" numeric(12,9) NOT NULL DEFAULT 0,
                  "is_finish" numeric(1) NOT NULL DEFAULT 1,
                  "finish_date" timestamp(0) DEFAULT NULL::timestamp without time zone,
                  "bill_cancel_status_id" int8 NOT NULL DEFAULT 0,
                  "bill_cancel_date" timestamp(0) DEFAULT NULL::timestamp without time zone
                )
                ;
                COMMENT ON COLUMN "public"."hc_shop_bills"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."hc_shop_bills"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."collations" IS \'JSON список значений для сопоставления\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."shop_client_id" IS \'ID контрагента\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."paid_type_id" IS \'ID способа оплаты\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."paid_amount" IS \'Оплаченная сумма\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."date_from" IS \'Дата заселения\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."date_to" IS \'Дата выселения\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."limit_time" IS \'До какого времени существует бронь\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."discount" IS \'Скидка\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."is_finish" IS \'Заказ выполнен\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."finish_date" IS \'Дата выполнения заказа\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."bill_cancel_status_id" IS \'Статус отмены заказа\';
                COMMENT ON COLUMN "public"."hc_shop_bills"."bill_cancel_date" IS \'Дата отмена заказа\';
                
                -- ----------------------------
                -- Indexes structure for table hc_shop_bills
                -- ----------------------------
                CREATE INDEX "ab_shop_car_index_id_copy3" ON "public"."hc_shop_bills" USING btree (
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
        'collations' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON список значений для сопоставления',
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
        'shop_client_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID контрагента',
            'table' => 'DB_Hotel_Shop_Client',
        ),
        'paid_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID способа оплаты',
            'table' => 'DB_PaidType',
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма',
        ),
        'paid_amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Оплаченная сумма',
        ),
        'date_from' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата заселения',
        ),
        'date_to' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата выселения',
        ),
        'limit_time' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'До какого времени существует бронь',
        ),
        'amount_items' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => '',
        ),
        'amount_services' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => '',
        ),
        'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => '',
        ),
        'shop_paid_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => '',
            'table' => 'DB_Shop_PaidType',
        ),
        'discount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 9,
            'is_not_null' => true,
            'title' => 'Скидка',
        ),
        'is_finish' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Заказ выполнен',
        ),
        'finish_date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата выполнения заказа',
        ),
        'bill_cancel_status_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Статус отмены заказа',
            'table' => 'DB_Hotel_BillCancelStatus',
        ),
        'bill_cancel_date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата отмена заказа',
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
