<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Client_Balance_Day {
    const TABLE_NAME = 'ab_shop_client_balance_days';
    const TABLE_ID = 346;
    const NAME = 'DB_Ab1_Shop_Client_Balance_Day';
    const TITLE = 'Положительный баланс клиента по дням, возникший в день оплаты';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_client_balance_days";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_client_balance_days
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_client_balance_days" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "create_user_id" int8 DEFAULT 0,
                  "update_user_id" int8 NOT NULL,
                  "delete_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "shop_client_id" int8 NOT NULL DEFAULT 0,
                  "date" date,
                  "amount" numeric(12,3) NOT NULL DEFAULT 0,
                  "block_amount" numeric(12,3) NOT NULL DEFAULT 0,
                  "balance" numeric(12,3) NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_client_balance_days"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_client_balance_days"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_client_balance_days"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_client_balance_days"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_client_balance_days"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_client_balance_days"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_client_balance_days"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_client_balance_days"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_client_balance_days"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_client_balance_days"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_client_balance_days"."shop_client_id" IS \'ID клиентa\';
                COMMENT ON COLUMN "public"."ab_shop_client_balance_days"."date" IS \'Фиксации положительного балланса клиента\';
                COMMENT ON COLUMN "public"."ab_shop_client_balance_days"."amount" IS \'Первоначально положительный баланс, который возник в момент оплаты\';
                COMMENT ON COLUMN "public"."ab_shop_client_balance_days"."block_amount" IS \'Истраченная сумма\';
                COMMENT ON COLUMN "public"."ab_shop_client_balance_days"."balance" IS \'Остаток баланса\';
                COMMENT ON TABLE "public"."ab_shop_client_balance_days" IS \'Положительный баланс клиента по дням, возникший в день оплаты\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_client_balance_days
                -- ----------------------------
                CREATE INDEX "ab_shop_client_balance_day_balance" ON "public"."ab_shop_client_balance_days" USING btree (
                  "balance" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_balance_day_date" ON "public"."ab_shop_client_balance_days" USING btree (
                  "date" "pg_catalog"."date_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_balance_day_first" ON "public"."ab_shop_client_balance_days" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_balance_day_index_id" ON "public"."ab_shop_client_balance_days" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_balance_day_shop_client_id" ON "public"."ab_shop_client_balance_days" USING btree (
                  "shop_client_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
            'is_not_null' => true,
            'title' => 'ID клиентa',
            'table' => 'DB_Ab1_Shop_Client',
        ),
        'date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Фиксации положительного балланса клиента',
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Первоначально положительный баланс, который возник в момент оплаты',
        ),
        'block_amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Истраченная сумма',
        ),
        'balance' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Остаток баланса',
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
