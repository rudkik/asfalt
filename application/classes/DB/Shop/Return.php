<?php defined('SYSPATH') or die('No direct script access.');

class DB_Shop_Return {
    const TABLE_NAME = 'ct_shop_returns';
    const TABLE_ID = 61;
    const NAME = 'DB_Shop_Return';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_shop_returns";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_shop_returns
                -- ----------------------------
                CREATE TABLE "public"."ct_shop_returns" (
                  "id" int8 NOT NULL,
                  "shop_id" int8 NOT NULL,
                  "shop_table_catalog_id" int8 NOT NULL DEFAULT 0,
                  "shop_bill_id" int8 NOT NULL DEFAULT 0,
                  "shop_root_id" int8 NOT NULL DEFAULT 0,
                  "country_id" int8 DEFAULT 0,
                  "city_id" int8 DEFAULT 0,
                  "shop_return_root_id" int8 DEFAULT 0,
                  "currency_id" int8 NOT NULL DEFAULT 18,
                  "amount" numeric(12,2) NOT NULL,
                  "shop_comment" text COLLATE "pg_catalog"."default",
                  "client_comment" text COLLATE "pg_catalog"."default",
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
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass)
                )
                ;
                COMMENT ON COLUMN "public"."ct_shop_returns"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ct_shop_returns"."shop_bill_id" IS \'ID заказа\';
                COMMENT ON COLUMN "public"."ct_shop_returns"."shop_root_id" IS \'ID родителя магазина создавшего заказ\';
                COMMENT ON COLUMN "public"."ct_shop_returns"."country_id" IS \'Страна\';
                COMMENT ON COLUMN "public"."ct_shop_returns"."city_id" IS \'Город\';
                COMMENT ON COLUMN "public"."ct_shop_returns"."shop_return_root_id" IS \'Связать возвраты\';
                COMMENT ON COLUMN "public"."ct_shop_returns"."currency_id" IS \'ID валюты заказа\';
                COMMENT ON COLUMN "public"."ct_shop_returns"."amount" IS \'Стоимость заказа\';
                COMMENT ON COLUMN "public"."ct_shop_returns"."shop_comment" IS \'Комментарий магазина\';
                COMMENT ON COLUMN "public"."ct_shop_returns"."client_comment" IS \'Комментарий клиента\';
                COMMENT ON COLUMN "public"."ct_shop_returns"."options" IS \'Данные JSON\';
                COMMENT ON COLUMN "public"."ct_shop_returns"."name" IS \'Название (ФИО)\';
                COMMENT ON COLUMN "public"."ct_shop_returns"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_returns"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_returns"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_shop_returns"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ct_shop_returns"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_shop_returns"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_returns"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ct_shop_returns"."global_id" IS \'Глобальный ID\';
                COMMENT ON TABLE "public"."ct_shop_returns" IS \'Таблица заказов магазинов\';
                
                -- ----------------------------
                -- Indexes structure for table ct_shop_returns
                -- ----------------------------
                CREATE INDEX "shop_return_city_id" ON "public"."ct_shop_returns" USING btree (
                  "city_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_return_country_id" ON "public"."ct_shop_returns" USING btree (
                  "country_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_return_first" ON "public"."ct_shop_returns" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_return_index_id" ON "public"."ct_shop_returns" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_return_name_like" ON "public"."ct_shop_returns" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_return_shop_bill_id" ON "public"."ct_shop_returns" USING btree (
                  "shop_bill_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_return_shop_return_root_id" ON "public"."ct_shop_returns" USING btree (
                  "shop_return_root_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_return_shop_root_id" ON "public"."ct_shop_returns" USING btree (
                  "shop_root_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_return_shop_table_catalog_id" ON "public"."ct_shop_returns" USING btree (
                  "shop_table_catalog_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ct_shop_returns
                -- ----------------------------
                ALTER TABLE "public"."ct_shop_returns" ADD CONSTRAINT "ct_shop_bills_copy_pkey1" PRIMARY KEY ("global_id");
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
        'shop_return_root_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Связать возвраты',
        ),
        'currency_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID валюты заказа',
            'table' => 'DB_Currency',
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Стоимость заказа',
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
