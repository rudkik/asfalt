<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Client {
    const TABLE_NAME = 'ab_shop_clients';
    const TABLE_ID = 58;
    const NAME = 'DB_Ab1_Shop_Client';
    const TITLE = 'Клиенты';
    const IS_CATALOG = true;

    const INTEGRATIONS = [
        Integration_Ab1_1C_Service::SERVICE_NAME => [
            'type' => 'customer',
            'guid' => ['system' => 'id', '1c' => 'guid'],
            'guid_1c' => ['system' => 'guid_1c', '1c' => 'guid_1c'],
            'default' => [
                'ver' => 'plus',
                'contacts' => '',
            ],
            'children' => [
                //'contacts' => ['table' => 'DB_Ab1_Shop_Client_Contact', 'field' => 'shop_client_id'],
            ],
        ],
    ];

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_clients";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_clients
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_clients" (
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
                  "bin" varchar(12) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "address" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "amount" numeric(15,2) NOT NULL DEFAULT 0,
                  "contract" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "shop_payment_type_id" int8 NOT NULL DEFAULT 0,
                  "name_1c" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "name_site" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "account" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "bank" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "block_amount" numeric(15,2) NOT NULL DEFAULT 0,
                  "organization_type_id" int8 NOT NULL DEFAULT 0,
                  "kato_id" int8 NOT NULL DEFAULT 0,
                  "bik" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "amount_cash" numeric(15,2) NOT NULL DEFAULT 0,
                  "block_amount_cash" numeric(15,2) NOT NULL DEFAULT 0,
                  "amount_1c" numeric(15,2) NOT NULL DEFAULT 0,
                  "amount_cash_1c" numeric(15,2) NOT NULL DEFAULT 0,
                  "balance" numeric(12,2) NOT NULL DEFAULT 0,
                  "balance_cache" numeric(12,2) NOT NULL DEFAULT 0,
                  "phones" text COLLATE "pg_catalog"."default",
                  "email" text COLLATE "pg_catalog"."default",
                  "amount_act_revise_cash" numeric(15,2) NOT NULL DEFAULT 0,
                  "amount_act_revise" numeric(15,2) NOT NULL DEFAULT 0,
                  "client_type_id" int8 NOT NULL DEFAULT 0,
                  "name_find" varchar(250) COLLATE "pg_catalog"."default",
                  "bank_id" int8 NOT NULL DEFAULT 0,
                  "is_buyer" numeric(1) NOT NULL DEFAULT 0,
                  "contact_person" text COLLATE "pg_catalog"."default",
                  "director" text COLLATE "pg_catalog"."default",
                  "charter" text COLLATE "pg_catalog"."default",
                  "is_lawsuit" numeric(1) NOT NULL DEFAULT 0,
                  "state_certificate" text COLLATE "pg_catalog"."default"
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_clients"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_clients"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."bin" IS \'БИН\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."address" IS \'Адрес\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."amount" IS \'Сумма прихода\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."contract" IS \'Договор\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."shop_payment_type_id" IS \'ID типа оплаты\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."name_1c" IS \'Название в 1C\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."name_site" IS \'Название на сайте\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."account" IS \'Номер счета\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."bank" IS \'Банк\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."block_amount" IS \'Заблокированная сумма\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."organization_type_id" IS \'Тип организации\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."kato_id" IS \'ID КАТО\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."bik" IS \'БИК\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."amount_cash" IS \'Сумма наличные\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."block_amount_cash" IS \'Заблокированная сумма наличные\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."amount_1c" IS \'Сумма из 1С\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."amount_cash_1c" IS \'Сумма наличные из 1С\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."balance" IS \'Остаток по клиента\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."balance_cache" IS \'Остаток по наличным\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."phones" IS \'Телефоны\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."email" IS \'E-mail\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."amount_act_revise_cash" IS \'Сумма наличные актов сверки\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."amount_act_revise" IS \'Сумма актов сверки\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."client_type_id" IS \'Тип клиента\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."name_find" IS \'Название без пробелов для поиска\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."bank_id" IS \'ID банка\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."is_buyer" IS \'Покупал ли клиент, хоть один раз\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."contact_person" IS \'Контактное лицо\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."director" IS \'Директор\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."charter" IS \'Основание\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."is_lawsuit" IS \'Для клиента создано судебное производство\';
                COMMENT ON COLUMN "public"."ab_shop_clients"."state_certificate" IS \'Свидетельство о государственной регистрации\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_clients
                -- ----------------------------
                CREATE INDEX "ab_shop_client_first" ON "public"."ab_shop_clients" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_full_name" ON "public"."ab_shop_clients" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name::text), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "ab_shop_client_index_id" ON "public"."ab_shop_clients" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_index_order" ON "public"."ab_shop_clients" USING btree (
                  "order" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_is_buyer" ON "public"."ab_shop_clients" USING btree (
                  "is_buyer" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_name_find_like" ON "public"."ab_shop_clients" USING btree (
                  lower(name_find::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_name_like" ON "public"."ab_shop_clients" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_old_id" ON "public"."ab_shop_clients" USING btree (
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
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'code',
            ],
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
        'bin' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 12,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'БИН',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'bin',
            ]
        ),
        'address' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Адрес',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'address',
            ],
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 15,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма прихода',
        ),
        'contract' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Договор',
        ),
        'shop_payment_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID типа оплаты',
            'table' => 'DB_Shop_Payment_Type',
        ),
        'name_1c' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название в 1C',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'name',
            ],
        ),
        'name_site' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название на сайте',
        ),
        'account' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер счета',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'account',
            ],
        ),
        'bank' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Банк',
        ),
        'block_amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 15,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Заблокированная сумма',
        ),
        'organization_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип организации',
            'table' => 'DB_OrganizationType',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'entity' => 'old_id',
                ]
            ],
        ),
        'kato_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID КАТО',
            'table' => 'DB_Ab1_Kato',
        ),
        'bik' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'БИК',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'bik',
            ],
        ),
        'amount_cash' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 15,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма наличные',
        ),
        'block_amount_cash' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 15,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Заблокированная сумма наличные',
        ),
        'amount_1c' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 15,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма из 1С',
        ),
        'amount_cash_1c' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 15,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма наличные из 1С',
        ),
        'balance' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Остаток по клиента',
        ),
        'balance_cache' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Остаток по наличным',
        ),
        'phones' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Телефоны',
        ),
        'email' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'E-mail',
        ),
        'amount_act_revise_cash' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 15,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма наличные актов сверки',
        ),
        'amount_act_revise' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 15,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма актов сверки',
        ),
        'client_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип клиента',
            'table' => 'DB_Ab1_ClientType',
        ),
        'name_find' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название без пробелов для поиска',
        ),
        'bank_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID банка',
            'table' => 'DB_Bank',
        ),
        'is_buyer' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Покупал ли клиент, хоть один раз',
        ),
        'contact_person' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Контактное лицо',
        ),
        'director' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Директор',
        ),
        'charter' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Основание',
        ),
        'is_lawsuit' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Для клиента создано судебное производство',
        ),
        'client_type_ids' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Типы клиента',
        ),
        'mobile' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 20,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Мобильный телефон',
        ),
        'name_complete' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Полное название',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'complete',
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