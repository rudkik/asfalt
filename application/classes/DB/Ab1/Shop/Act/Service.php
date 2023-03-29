<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Act_Service {
    const TABLE_NAME = 'ab_shop_act_services';
    const TABLE_ID = 245;
    const NAME = 'DB_Ab1_Shop_Act_Service';
    const TITLE = 'Акты выполненных работ';
    const IS_CATALOG = false;

    const INTEGRATIONS = [
        Integration_Ab1_1C_Service::SERVICE_NAME => [
            'type' => 'servicesinvoice',
            'guid' => ['system' => 'id', '1c' => 'guid'],
            'guid_1c' => ['system' => 'guid_1c', '1c' => 'guid_1c'],
            'children' => [
                'rows' => [
                    [
                        'table' => 'DB_Ab1_Shop_Car',
                        'field_1' => 'id',
                        'field_2' => 'shop_act_service_id',
                        'params' => [
                            'sum_delivery_quantity' => true,
                            'sum_delivery_amount' => true,
                            'group_by' => ['shop_delivery_id']
                        ],
                    ],
                    [
                        'table' => 'DB_Ab1_Shop_Piece',
                        'field_1' => 'id',
                        'field_2' => 'shop_act_service_id',
                        'params' => [
                            'sum_delivery_quantity' => true,
                            'sum_delivery_amount' => true,
                            'group_by' => ['shop_delivery_id']
                        ],
                    ],
                    [
                        'table' => 'DB_Ab1_Shop_Addition_Service_Item',
                        'field_1' => 'id',
                        'field_2' => 'shop_act_service_id',
                        'params' => [
                            'sum_quantity' => true,
                            'sum_amount' => true,
                            'group_by' => ['price', 'shop_product_id']
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
                'division' => '',
            ],
        ],
    ];

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_act_services";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_act_services
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_act_services" (
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
                  "shop_client_contract_id" int8 NOT NULL DEFAULT 0,
                  "date_from" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "date_to" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_send_esf" numeric(1) NOT NULL DEFAULT 0,
                  "act_service_paid_type_id" int8 NOT NULL DEFAULT 0,
                  "shop_client_attorney_id" int8 NOT NULL DEFAULT 0,
                  "shop_delivery_department_id" int8 NOT NULL DEFAULT 0,
                  "product_type_id" int8 NOT NULL DEFAULT 1,
                  "check_type_id" int8 NOT NULL DEFAULT 0,
                  "is_give_to_client" numeric(1) NOT NULL DEFAULT 0,
                  "date_give_to_client" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "date_received_from_client" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "date_give_to_bookkeeping" timestamp(6) DEFAULT NULL::timestamp without time zone
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_act_services"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."shop_client_id" IS \'ID клиентa\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."date" IS \'Дата акта выполенных работ\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."number" IS \'Номер акта выполенных работ\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."shop_client_contract_id" IS \'ID договора\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."date_from" IS \'Дата от (с какого времени взяты данные)\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."date_to" IS \'Дата до (до какого времени взяты данные)\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."is_send_esf" IS \'Отправлено в ЭСФ\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."act_service_paid_type_id" IS \'ID типа оплаты актов выполенных работ\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."shop_client_attorney_id" IS \'ID доверенности\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."shop_delivery_department_id" IS \'ID цеха доставки\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."product_type_id" IS \'ID типа продукции\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."check_type_id" IS \'ID вида проверки\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."is_give_to_client" IS \'Отдана накладная клиенту\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."date_give_to_client" IS \'Дата когда было отдана накладная клиенту\';
                COMMENT ON COLUMN "public"."ab_shop_act_services"."date_received_from_client" IS \'Дата когда была получена накладная  от клиента\';
                COMMENT ON COLUMN "public"."ab_shop_invoices"."date_give_to_bookkeeping" IS \'Дата когда была отдана бухгалтерии\';
                COMMENT ON TABLE "public"."ab_shop_act_services" IS \'Список актов выполненных работ\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_act_services
                -- ----------------------------
                CREATE INDEX "ab_shop_act_service_act_service_paid_type_id" ON "public"."ab_shop_act_services" USING btree (
                  "act_service_paid_type_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_act_service_check_type_id" ON "public"."ab_shop_act_services" USING btree (
                  "check_type_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_act_service_date" ON "public"."ab_shop_act_services" USING btree (
                  "date" "pg_catalog"."date_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_act_service_first" ON "public"."ab_shop_act_services" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_act_service_index_id" ON "public"."ab_shop_act_services" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_act_service_number" ON "public"."ab_shop_act_services" USING btree (
                  "number" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_act_service_old_id" ON "public"."ab_shop_act_services" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_act_service_shop_client_attorney_id" ON "public"."ab_shop_act_services" USING btree (
                  "shop_client_attorney_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_act_service_shop_client_contract_id" ON "public"."ab_shop_act_services" USING btree (
                  "shop_client_contract_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_act_service_shop_client_id" ON "public"."ab_shop_act_services" USING btree (
                  "shop_client_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_act_service_shop_delivery_department_id" ON "public"."ab_shop_act_services" USING btree (
                  "shop_delivery_department_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
            'title' => 'Дата акта выполенных работ',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'date',
            ],
        ),
        'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Номер акта выполенных работ',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'code',
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
        'act_service_paid_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID типа оплаты актов выполенных работ',
            'table' => 'DB_Ab1_ActServicePaidType',
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
        'shop_delivery_department_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID цеха доставки',
            'table' => 'DB_Ab1_Shop_Delivery_Department',
        ),
        'product_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID типа продукции',
            'table' => 'DB_Ab1_ProductType',
        ),
        'check_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID вида проверки',
            'table' => 'DB_Ab1_CheckType',
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