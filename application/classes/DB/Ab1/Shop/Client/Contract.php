<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Client_Contract {
    const TABLE_NAME = 'ab_shop_client_contracts';
    const TABLE_ID = 224;
    const NAME = 'DB_Ab1_Shop_Client_Contract';
    const TITLE = 'Договоры / доп.соглашения контрагентов';
    const IS_CATALOG = true;

    const INTEGRATIONS = [
        Integration_Ab1_1C_Service::SERVICE_NAME => [
            'type' => 'contract',
            'guid' => ['system' => 'id', '1c' => 'guid'],
            'guid_1c' => ['system' => 'guid_1c', '1c' => 'guid_1c'],
            'default' => [
                'ver' => 'plus',
            ]
        ],
    ];

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_client_contracts";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_client_contracts
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_client_contracts" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "name" text COLLATE "pg_catalog"."default",
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
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "number" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "from_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "to_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "shop_client_id" int8 NOT NULL DEFAULT 0,
                  "quantity" numeric(12,3) NOT NULL DEFAULT 0,
                  "balance_amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "block_amount" numeric(20,2) NOT NULL DEFAULT 0,
                  "subject" text COLLATE "pg_catalog"."default",
                  "is_basic" numeric(1) NOT NULL DEFAULT 1,
                  "basic_shop_client_contract_id" int8 NOT NULL DEFAULT 0,
                  "client_contract_type_id" int8 NOT NULL DEFAULT 0,
                  "client_contract_status_id" int8 NOT NULL DEFAULT 0,
                  "is_prolongation" numeric(1) NOT NULL DEFAULT 0,
                  "is_redaction_client" numeric(1) NOT NULL DEFAULT 0,
                  "executor_shop_worker_id" int8 NOT NULL DEFAULT 0,
                  "number_company" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "is_fixed_price" numeric(1) NOT NULL DEFAULT 0,
                  "original" varchar(50) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "is_fixed_contract" numeric(1) NOT NULL DEFAULT 0,
                  "is_show_branch" numeric(1) NOT NULL DEFAULT 0,
                  "is_add_basic_contract" numeric(1) NOT NULL DEFAULT 0,
                  "currency_id" int8 NOT NULL DEFAULT 18,
                  "shop_client_contract_storage_id" int8 NOT NULL DEFAULT 0,
                  "is_perpetual" numeric(1) NOT NULL DEFAULT 0,
                  "client_contract_view_id" int8 NOT NULL DEFAULT 1,
                  "paid_amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "is_receive" numeric(1) NOT NULL DEFAULT 1,
                  "block_paid_amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "shop_department_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."number" IS \'Номер договора (исходящий)\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."from_at" IS \'Контракт от\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."to_at" IS \'Контракт до\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."shop_client_id" IS \'ID клиента\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."quantity" IS \'Количество\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."balance_amount" IS \'Остаток по контракту\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."block_amount" IS \'Заблокированная сумма \';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."subject" IS \'Предмет договора\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."is_basic" IS \'Основной договор (1) / доп. соглашение (0)\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."basic_shop_client_contract_id" IS \'ID основного договора\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."client_contract_type_id" IS \'ID категория договора\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."client_contract_status_id" IS \'ID статуса договора\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."is_prolongation" IS \'Есть ли пролонгация договора\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."is_redaction_client" IS \'Редакция договора клиента (1) \ Асфальтобен (0)\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."executor_shop_worker_id" IS \'Исполнитель (сотрудник)\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."number_company" IS \'Номер договора (входящий)\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."is_fixed_price" IS \'Есть хоть одна фиксированная цена для продукции\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."original" IS \'Хранение оригинала\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."is_fixed_contract" IS \'Договор зафиксирован, изменения не доступны\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."is_show_branch" IS \'Показывать в СББЫТе филиала\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."is_add_basic_contract" IS \'Позиции доп.соглашения увеличивает сумму договора\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."currency_id" IS \'ID валюты договора\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."shop_client_contract_storage_id" IS \'ID места хранения оригинала\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."is_perpetual" IS \'Бессрочный договор\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."client_contract_view_id" IS \'ID тип договора\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."paid_amount" IS \'Оплаченная сумма по контракту\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."is_receive" IS \'Если приход (продажа) 1, если расход (покупка) 0\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."block_paid_amount" IS \'Потраченная сумма по контракту (данные из 1С)\';
                COMMENT ON COLUMN "public"."ab_shop_client_contracts"."shop_department_id" IS \'ID отдела\';
                COMMENT ON TABLE "public"."ab_shop_client_contracts" IS \'Таблица договоров / доп.соглашений контрагентов\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_client_contracts
                -- ----------------------------
                CREATE INDEX "ab_shop_client_contract_first" ON "public"."ab_shop_client_contracts" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_full_name" ON "public"."ab_shop_client_contracts" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "ab_shop_client_contract_index_id" ON "public"."ab_shop_client_contracts" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_index_order" ON "public"."ab_shop_client_contracts" USING btree (
                  "order" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_is_fixed_price" ON "public"."ab_shop_client_contracts" USING btree (
                  "is_fixed_price" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_is_receive" ON "public"."ab_shop_client_contracts" USING btree (
                  "is_receive" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_is_show_branch" ON "public"."ab_shop_client_contracts" USING btree (
                  "is_show_branch" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_name_like" ON "public"."ab_shop_client_contracts" USING btree (
                  lower(name) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_old_id" ON "public"."ab_shop_client_contracts" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_shop_client_contract_storage_id" ON "public"."ab_shop_client_contracts" USING btree (
                  "shop_client_contract_storage_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_shop_client_id" ON "public"."ab_shop_client_contracts" USING btree (
                  "shop_client_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_shop_department_id" ON "public"."ab_shop_client_contracts" USING btree (
                  "shop_department_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
            'length' => 0,
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
        'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер договора (исходящий)',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'code',
                    'number',
                ]
            ],
        ),
        'from_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Контракт от',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'date',
                    'date1',
                ]
            ],
        ),
        'to_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Контракт до',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'date2',
            ],
        ),
        'shop_client_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID клиента',
            'table' => 'DB_Ab1_Shop_Client',
            'is_common_items' => true,
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'customer_guid' => 'id',
                    'customer_guid_1c' => 'guid_1c',
                ]
            ],
        ),
        'quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество',
        ),
        'balance_amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Остаток по контракту',
        ),
        'block_amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 20,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Заблокированная сумма ',
        ),
        'subject' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Предмет договора',
        ),
        'is_basic' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Основной договор (1) / доп. соглашение (0)',
        ),
        'basic_shop_client_contract_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID основного договора',
            'table' => 'DB_Ab1_Shop_Client_Contract',
            'is_common_items' => true,
        ),
        'client_contract_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID вида договора',
            'table' => 'DB_Ab1_ClientContract_Type',
        ),
        'client_contract_status_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID статуса договора',
            'table' => 'DB_Ab1_ClientContract_Status',
        ),
        'is_prolongation' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Есть ли пролонгация договора',
        ),
        'is_redaction_client' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Редакция договора клиента (1) \ Асфальтобен (0)',
        ),
        'executor_shop_worker_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Испольнитель (сотрудник)',
            'table' => 'DB_Ab1_Shop_Worker',
        ),
        'number_company' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер договора (входящий)',
        ),
        'is_fixed_price' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Есть хоть одна фиксированная цена для продукции',
        ),
        'original' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Хранение оригинала',
        ),
        'is_fixed_contract' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Договор зафиксирован, изменения не доступны',
        ),
        'is_show_branch' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Показывать в СББЫТе филиала',
        ),
        'is_add_basic_contract' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Позиции доп.соглашения увеличивает сумму договора',
        ),
        'currency_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID валюты договора',
            'table' => 'DB_Currency',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'currency' => 'code',
                ]
            ],
        ),
        'shop_client_contract_storage_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID места хранения оригинала',
            'table' => 'DB_Ab1_Shop_Client_Contract_Storage',
        ),
        'is_perpetual' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Бессрочный договор',
        ),
        'client_contract_view_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID тип договора',
            'table' => 'DB_Ab1_ClientContract_View',
        ),
        'paid_amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Оплаченная сумма по контракту',
        ),
        'is_receive' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Если приход (продажа) 1, если расход (покупка) 0',
        ),
        'block_paid_amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Потраченная сумма по контракту (данные из 1С)',
        ),
        'shop_department_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID отдела',
            'table' => 'DB_Ab1_Shop_Department',
        ),
        'operation_updated_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Дата обновления операторов',
        ),
        'update_operation_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Оператор обновивший эту запись',
            'table' => 'DB_Ab1_Shop_Operation',
        ),
        'client_contract_kind_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => 'DB_Ab1_ClientContract_Kind',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'kind' => 'old_id',
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
        'shop_client_contract_items' => array(
            'table' => 'DB_Ab1_Shop_Client_Contract_Item',
            'field_id' => 'shop_client_contract_id',
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