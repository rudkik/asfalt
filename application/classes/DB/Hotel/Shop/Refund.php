<?php defined('SYSPATH') or die('No direct script access.');

class DB_Hotel_Shop_Refund {
    const TABLE_NAME = 'hc_shop_refunds';
    const TABLE_ID = 61;
    const NAME = 'DB_Hotel_Shop_Refund';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."hc_shop_refunds";',
            'create' => '
                -- ----------------------------
                -- Table structure for hc_shop_refunds
                -- ----------------------------
                CREATE TABLE "public"."hc_shop_refunds" (
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
                  "shop_client_id" int8 DEFAULT 0,
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "number" varchar(64) COLLATE "pg_catalog"."default" NOT NULL DEFAULT \'\'::character varying,
                  "date" date,
                  "refund_type_id" int8 DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."hc_shop_refunds"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."hc_shop_refunds"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."hc_shop_refunds"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."hc_shop_refunds"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."hc_shop_refunds"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."hc_shop_refunds"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."hc_shop_refunds"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."hc_shop_refunds"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."hc_shop_refunds"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."hc_shop_refunds"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."hc_shop_refunds"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."hc_shop_refunds"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."hc_shop_refunds"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."hc_shop_refunds"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."hc_shop_refunds"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."hc_shop_refunds"."shop_client_id" IS \'ID клиента\';
                COMMENT ON COLUMN "public"."hc_shop_refunds"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."hc_shop_refunds"."number" IS \'Номер возврата\';
                COMMENT ON COLUMN "public"."hc_shop_refunds"."date" IS \'Дата возврата\';
                COMMENT ON COLUMN "public"."hc_shop_refunds"."refund_type_id" IS \'Тип возврата\';
                
                -- ----------------------------
                -- Indexes structure for table hc_shop_refunds
                -- ----------------------------
                CREATE INDEX "ab_shop_car_index_id_copy3_copy2_copy1" ON "public"."hc_shop_refunds" USING btree (
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
        'shop_client_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID клиента',
            'table' => 'DB_Hotel_Shop_Client',
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма',
        ),
        'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Номер возврата',
        ),
        'date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата возврата',
        ),
        'refund_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Тип возврата',
            'table' => 'DB_Hotel_RefundType',
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
