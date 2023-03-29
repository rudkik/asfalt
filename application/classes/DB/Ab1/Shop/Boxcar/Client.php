<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Boxcar_Client extends DB_Ab1_Shop_Client{
    const TABLE_NAME = 'ab_shop_boxcar_clients';
    const TABLE_ID = 208;
    const NAME = 'DB_Ab1_Shop_Boxcar_Client';
    const TITLE = 'Поставщики продукции вагонов';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_boxcar_clients";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_boxcar_clients
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_boxcar_clients" (
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
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "contract" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "shop_payment_type_id" int8 NOT NULL DEFAULT 0,
                  "name_1c" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "account" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "bank" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "organization_type_id" int8 NOT NULL DEFAULT 0,
                  "kato_id" int8 NOT NULL DEFAULT 0,
                  "bik" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."bin" IS \'БИН\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."address" IS \'Адрес\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."contract" IS \'Договор\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."shop_payment_type_id" IS \'ID типа оплаты\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."name_1c" IS \'Название в 1C\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."account" IS \'Номер счета\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."bank" IS \'Банк\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."organization_type_id" IS \'Тип организации\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."kato_id" IS \'ID КАТО\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_clients"."bik" IS \'БИК\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_boxcar_clients
                -- ----------------------------
                CREATE INDEX "shop_boxcar_client_first" ON "public"."ab_shop_boxcar_clients" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_boxcar_client_full_name" ON "public"."ab_shop_boxcar_clients" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name::text), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "shop_boxcar_client_index_id" ON "public"."ab_shop_boxcar_clients" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_boxcar_client_index_order" ON "public"."ab_shop_boxcar_clients" USING btree (
                  "order" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_boxcar_client_name_like" ON "public"."ab_shop_boxcar_clients" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_boxcar_client_old_id" ON "public"."ab_shop_boxcar_clients" USING btree (
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
        'bin' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 12,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'БИН',
        ),
        'address' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Адрес',
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма',
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
            'table' => 'DB_Ab1_PaymentType',
        ),
        'name_1c' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название в 1C',
        ),
        'account' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер счета',
        ),
        'bank' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Банк',
        ),
        'organization_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип организации',
            'table' => 'DB_OrganizationType',
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
        ),
    );
}
