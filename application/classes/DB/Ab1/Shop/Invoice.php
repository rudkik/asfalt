<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Invoice {
    const TABLE_NAME = 'ab_shop_invoices';
    const TABLE_ID = 230;
    const NAME = 'DB_Ab1_Shop_Invoice';
    const TITLE = 'Накладные';
    const IS_CATALOG = true;

    const INTEGRATIONS = [
        Integration_Ab1_1C_Service::SERVICE_NAME => [
            'type' => 'productinvoice',
            'guid' => ['system' => 'id', '1c' => 'guid'],
            'guid_1c' => ['system' => 'guid_1c', '1c' => 'guid_1c'],
            'children' => [
                'rows' => [
                    [
                        'table' => 'DB_Ab1_Shop_Car_Item',
                        'field_1' => 'id',
                        'field_2' => 'shop_invoice_id',
                        'params' => [
                            'sum_quantity' => true,
                            'sum_amount' => true,
                            'group_by' => ['shop_id', 'price', 'shop_product_id', 'shop_subdivision_id']
                        ],
                    ],
                    [
                        'table' => 'DB_Ab1_Shop_Piece_Item',
                        'field_1' => 'id',
                        'field_2' => 'shop_invoice_id',
                        'params' => [
                            'sum_quantity' => true,
                            'sum_amount' => true,
                            'group_by' => ['shop_id', 'price', 'shop_product_id', 'shop_subdivision_id']
                        ],
                    ],
                ],
            ],
            'default' => [
                'ver' => 'plus',
                'nds' => 12,
                'currency' => 'KZT',
                'comment' => 'автоматическая загрузка',
                'proxy_who' => '',
                'type_pay' => '4',
            ],
        ],
    ];

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_invoices";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_invoices
                -- ----------------------------
               CREATE TABLE "public"."ab_shop_invoices" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "text" text COLLATE "pg_catalog"."default",
                  "image_path" varchar(100) COLLATE "pg_catalog"."default",
                  "files" text COLLATE "pg_catalog"."default",
                  "options" text COLLATE "pg_catalog"."default",
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
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "date" date DEFAULT NULL::timestamp without time zone,
                  "number" varchar(64) COLLATE "pg_catalog"."default" NOT NULL DEFAULT \'\'::character varying,
                  "shop_client_attorney_id" int8 NOT NULL DEFAULT 0,
                  "shop_client_contract_id" int8 NOT NULL DEFAULT 0,
                  "date_from" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "date_to" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_send_esf" numeric(1) NOT NULL DEFAULT 0,
                  "is_delivery" numeric(1) NOT NULL DEFAULT 0,
                  "product_type_id" int8 NOT NULL DEFAULT 1,
                  "is_give_to_client" numeric(1) NOT NULL DEFAULT 0,
                  "date_give_to_client" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "check_type_id" int8 NOT NULL DEFAULT 0,
                  "shop_move_client_id" int8 NOT NULL DEFAULT 0
                  "date_received_from_client" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "date_give_to_bookkeeping" timestamp(6) DEFAULT NULL::timestamp without time zone
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_invoices"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."shop_client_id" IS \'ID клиентa\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."date" IS \'Дата накладной\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."number" IS \'Номер накладной\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."shop_client_attorney_id" IS \'ID доверенности\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."shop_client_contract_id" IS \'ID договора\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."date_from" IS \'Дата от (с какого времени взяты данные)\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."date_to" IS \'Дата до (до какого времени взяты данные)\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."is_send_esf" IS \'Отправлено в ЭСФ\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."is_delivery" IS \'Доставка\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."product_type_id" IS \'ID типа продукции\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."is_give_to_client" IS \'Отдана накладная клиенту\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."date_give_to_client" IS \'Дата когда было отдана накладная клиенту\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."check_type_id" IS \'ID вида проверки\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."shop_move_client_id" IS \'ID склада откуда произошла реализация\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."date_received_from_client" IS \'Дата когда была получена накладная  от клиента\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."date_give_to_bookkeeping" IS \'Дата когда была отдана бухгалтерии\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_invoices
                -- ----------------------------
                CREATE INDEX "ab_shop_invoice_check_type_id" ON "public"."ab_shop_invoices" USING btree (
                  "check_type_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_invoice_date" ON "public"."ab_shop_invoices" USING btree (
                  "date" "pg_catalog"."date_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_invoice_first" ON "public"."ab_shop_invoices" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_invoice_index_id" ON "public"."ab_shop_invoices" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_invoice_is_give_to_client" ON "public"."ab_shop_invoices" USING btree (
                  "is_give_to_client" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_invoice_number" ON "public"."ab_shop_invoices" USING btree (
                  "number" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_invoice_old_id" ON "public"."ab_shop_invoices" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_invoice_product_type_id" ON "public"."ab_shop_invoices" USING btree (
                  "product_type_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_invoice_shop_client_attorney_id" ON "public"."ab_shop_invoices" USING btree (
                  "shop_client_attorney_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_invoice_shop_client_contract_id" ON "public"."ab_shop_invoices" USING btree (
                  "shop_client_contract_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_invoice_shop_client_id" ON "public"."ab_shop_invoices" USING btree (
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
                    'division' => 'old_id',
                ]
            ],
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
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'sum',
            ],
        ),
        'date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата накладной',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'date',
            ],
        ),
        'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Номер накладной',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'code',
            ],
        ),
        'shop_client_attorney_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID доверенности',
            'table' => 'DB_Ab1_Shop_Client_Attorney',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'proxy_num' => 'number',
                    'proxy_dat' => 'from_at',
                    'proxy_whom' => 'client_name',
                ]
            ],
        ),
        'shop_client_contract_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID договора',
            'table' => 'DB_Ab1_Shop_Client_Contract',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'contract_guid' => 'id',
                    'contract_guid_1c' => 'guid_1c',
                ]
            ],
        ),
        'date_from' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата от (с какого времени взяты данные)',
        ),
        'date_to' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата до (до какого времени взяты данные)',
        ),
        'is_send_esf' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Отправлено в ЭСФ',
        ),
        'is_delivery' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Доставка',
        ),
        'product_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID типа продукции',
            'table' => 'DB_Ab1_ProductType',
        ),
        'is_give_to_client' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Отдана накладная клиенту',
        ),
        'date_give_to_client' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата когда было отдана накладная клиенту',
        ),
        'check_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID вида проверки',
            'table' => 'DB_Ab1_CheckType',
        ),
        'shop_move_client_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID склада откуда произошла реализация',
            'table' => 'DB_Ab1_Shop_Move_Client',
        ),
        'date_received_from_client' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата когда была получена накладная  от клиента',
        ),
        'date_give_to_bookkeeping' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата когда была отдана бухгалтерии',
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
