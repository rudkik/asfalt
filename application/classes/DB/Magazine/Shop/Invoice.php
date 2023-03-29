<?php defined('SYSPATH') or die('No direct script access.');

class DB_Magazine_Shop_Invoice {
    const TABLE_NAME = 'sp_shop_invoices';
    const TABLE_ID = 280;
    const NAME = 'DB_Magazine_Shop_Invoice';
    const TITLE = 'Счета-фактуры реализации';
    const IS_CATALOG = false;

    const INTEGRATIONS = [
        Integration_Ab1_1C_Service::SERVICE_NAME => [
            'type' => 'productinvoice',
            'guid' => ['system' => 'id', '1c' => 'guid'],
            'guid_1c' => ['system' => 'guid_1c', '1c' => 'guid_1c'],
            'children' => [
                'rows' => [
                    [
                        'table' => 'DB_Magazine_Shop_Invoice_Item',
                        'field_1' => 'id',
                        'field_2' => 'shop_invoice_id',
                        'params' => [
                            'sum_quantity' => true,
                            'sum_amount' => true,
                            'group_by' => ['shop_id', 'price', 'shop_product_id', 'shop_production_id']
                        ],
                    ],
                ],
            ],
            'default' => [
                'ver' => 'mag',
                'nds' => 12,
                'currency' => 'KZT',
                'comment' => 'автоматическая загрузка',
                'proxy_who' => '',
                'proxy_num' => '',
                'proxy_dat' => '',
                'proxy_whom' => '',
                'contract_guid' => '',
                'contract_guid_1c' => '',
                'type_pay' => '1',
                'customer_guid' => '',
                'customer_guid_1c' => '',
            ],
        ],
    ];

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."sp_shop_invoices";',
            'create' => '
                -- ----------------------------
                -- Table structure for sp_shop_invoices
                -- ----------------------------
                CREATE TABLE "public"."sp_shop_invoices" (
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
                  "quantity" numeric(12,3) NOT NULL DEFAULT 0,
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "date" date DEFAULT NULL::timestamp without time zone,
                  "date_from" date DEFAULT NULL::timestamp without time zone,
                  "date_to" date DEFAULT NULL::timestamp without time zone,
                  "number" varchar(50) COLLATE "pg_catalog"."default",
                  "number_esf" varchar(50) COLLATE "pg_catalog"."default",
                  "is_esf_receive" numeric(1) NOT NULL DEFAULT 0,
                  "esf_type_id" varchar(255) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 0,
                  "esf_date" date DEFAULT NULL::timestamp without time zone,
                  "shop_invoice_id" int8 NOT NULL DEFAULT 0,
                  "is_import_esf" numeric(1) NOT NULL DEFAULT 0,
                  "import_esf" text COLLATE "pg_catalog"."default"
                )
                ;
                COMMENT ON COLUMN "public"."sp_shop_invoices"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."quantity" IS \'Количество\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."date" IS \'Дата совершения оборота\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."date_from" IS \'Период сбора реализации продукции от\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."date_to" IS \'Период сбора реализации продукции до\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."number" IS \'Номер счет-фактуры\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."number_esf" IS \'Номер ЭСФ\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."is_esf_receive" IS \'Есть сверка с ЭСФ приход\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."esf_type_id" IS \'Список ID тип счет-фактуры (электронная, бумажная)\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."esf_date" IS \'Дата выписки счет-фактуры\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."shop_invoice_id" IS \'Основная ЭСФ при возвратной\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."is_import_esf" IS \'Импорт файла из личного кабинета ЭСФ\';
                COMMENT ON COLUMN "public"."sp_shop_invoices"."import_esf" IS \'JSON полного документа ЭСФ\';
                COMMENT ON TABLE "public"."sp_shop_invoices" IS \'Список счетов-фактур реализации\';
                
                -- ----------------------------
                -- Indexes structure for table sp_shop_invoices
                -- ----------------------------
                CREATE INDEX "sp_shop_invoice_date" ON "public"."sp_shop_invoices" USING btree (
                  "date" "pg_catalog"."date_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_invoice_first" ON "public"."sp_shop_invoices" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_invoice_index_id" ON "public"."sp_shop_invoices" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_invoice_index_order" ON "public"."sp_shop_invoices" USING btree (
                  "order" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_invoice_number" ON "public"."sp_shop_invoices" USING btree (
                  "number" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_invoice_old_id" ON "public"."sp_shop_invoices" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
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
        'quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество',
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
            'title' => 'Дата совершения оборота',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'date',
            ],
        ),
        'date_from' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Период сбора реализации продукции от',
        ),
        'date_to' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Период сбора реализации продукции до',
        ),
        'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер счет-фактуры',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'code',
            ],
        ),
        'number_esf' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер ЭСФ',
        ),
        'is_esf_receive' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Есть сверка с ЭСФ приход',
        ),
        'esf_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 255,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Список ID тип счет-фактуры (электронная, бумажная)',
            'table' => 'DB_Magazine_ESFType',
        ),
        'esf_date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата выписки счет-фактуры',
        ),
        'shop_invoice_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Основная ЭСФ при возвратной',
            'table' => 'DB_Magazine_Shop_Invoice',
        ),
        'is_import_esf' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Импорт файла из личного кабинета ЭСФ',
        ),
        'import_esf' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON полного документа ЭСФ',
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