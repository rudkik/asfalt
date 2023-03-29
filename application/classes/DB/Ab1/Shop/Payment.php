<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Payment {
    const TABLE_NAME = 'ab_shop_payments';
    const TABLE_ID = 59;
    const NAME = 'DB_Ab1_Shop_Payment';
    const TITLE = 'Оплаты наличными / банковской карточкой клиента';
    const IS_CATALOG = false;

    const INTEGRATIONS = [
        Integration_Ab1_1C_Service::SERVICE_NAME => [
            'type' => 'moneyin',
            'guid' => ['system' => 'id', '1c' => 'guid'],
            'guid_1c' => ['system' => 'guid_1c', '1c' => 'guid_1c'],
            'default' => [
                'ver' => 'plus',
                'operation' => 1,
                'nds' => 12,
                'currency' => 'KZT',
            ]
        ],
    ];

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_payments";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_payments
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_payments" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "shop_table_rubric_id" int8 NOT NULL DEFAULT 0,
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
                  "shop_client_id" int8 NOT NULL DEFAULT 0,
                  "number" varchar(64) COLLATE "pg_catalog"."default" NOT NULL DEFAULT \'\'::character varying,
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "payment_type_id" int8 NOT NULL DEFAULT 1,
                  "shop_car_id" int8 NOT NULL DEFAULT 0,
                  "shop_piece_id" int8 NOT NULL DEFAULT 0,
                  "fiscal_check" varchar(50) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "shop_cashbox_id" int8 NOT NULL DEFAULT 0,
                  "is_fiscal_check" numeric(1) NOT NULL DEFAULT 0,
                  "shop_client_contract_id" int8 NOT NULL DEFAULT 0,
                  "shop_client_balance_day_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_payments"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."shop_table_rubric_id" IS \'ID вид пользователя (малый сбыт, касса)\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_payments"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."shop_client_id" IS \'ID клиентa\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."number" IS \'Номер счета\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."payment_type_id" IS \'ID типа оплаты\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."shop_car_id" IS \'ID машины\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."shop_piece_id" IS \'ID оплаты\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."fiscal_check" IS \'Номер фискального чека\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."shop_cashbox_id" IS \'ID фискального регистратора\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."is_fiscal_check" IS \'Есть ли фискальный чек\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."shop_client_contract_id" IS \'ID договора клиентa\';
                COMMENT ON COLUMN "public"."ab_shop_payments"."shop_client_balance_day_id" IS \'ID баланса фиксации цены продукции (для клиентов внесших предоплату)\';
                COMMENT ON TABLE "public"."ab_shop_payments" IS \'Список оплат наличных / банковской карточкой клиента\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_payments
                -- ----------------------------
                CREATE INDEX "ab_shop_payment_first" ON "public"."ab_shop_payments" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_payment_index_id_" ON "public"."ab_shop_payments" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_payment_payment_type_id" ON "public"."ab_shop_payments" USING btree (
                  "payment_type_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_payment_shop_cashbox_id" ON "public"."ab_shop_payments" USING btree (
                  "shop_cashbox_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_payment_shop_client_balance_day_id" ON "public"."ab_shop_payments" USING btree (
                  "shop_client_balance_day_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_payment_shop_client_id_" ON "public"."ab_shop_payments" USING btree (
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
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'bin_org' => 'bin',
                ]
            ],
        ),
        'shop_table_rubric_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID вид пользователя (малый сбыт, касса)',
            'table' => 'DB_Shop_Table_Rubric',
        ),
        'name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название',
        ),
        'text' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Описание',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'comment',
            ],
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
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'user_iin' => 'shop_operation_id.shop_worker_id.iin',
                ]
            ],
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
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'date',
            ],
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
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'customer_guid' => 'id',
                    'customer_guid_1c' => 'guid_1c',
                ]
            ],
        ),
        'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Номер счета',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'code',
            ],
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма',
            'is_total_items' => true,
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'sum',
            ],
        ),
        'payment_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID типа оплаты',
            'table' => 'DB_Ab1_PaymentType',
        ),
        'shop_car_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID машины',
            'table' => 'DB_Ab1_Shop_Car',
        ),
        'shop_piece_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID оплаты',
            'table' => 'DB_Ab1_Shop_Piece',
        ),
        'fiscal_check' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер фискального чека',
        ),
        'shop_cashbox_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID фискального регистратора',
            'table' => 'DB_Ab1_Shop_Cashbox',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'cashbox' => 'old_id',
                ]
            ],
        ),
        'is_fiscal_check' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Есть ли фискальный чек',
        ),
        'shop_client_contract_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID договора клиентa',
            'table' => 'DB_Ab1_Shop_Client_Contract',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'rows.0.contract_guid' => 'id',
                    'rows.0.contract_guid_1c' => 'guid_1c',
                ]
            ],
        ),
        'shop_client_balance_day_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID баланса фиксации цены продукции (для клиентов внесших предоплату)',
            'table' => 'DB_Ab1_Shop_Client_Balance_Day',
        ),
        'shop_cashbox_terminal_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID постртерминала',
            'table' => 'DB_Ab1_Shop_Cashbox_Terminal',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'terminal' => 'old_id',
                ]
            ],
        ),
        'guid_1c' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 32,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'GUID 1С',
        ),
    );

    // список связанных таблиц 1коМногим
    const ITEMS = array(
        'shop_payment_items' => array(
            'table' => 'DB_Ab1_Shop_Payment_Item',
            'field_id' => 'shop_payment_id',
            'is_view' => true,
        ),
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