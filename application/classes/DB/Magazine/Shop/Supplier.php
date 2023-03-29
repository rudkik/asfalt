<?php defined('SYSPATH') or die('No direct script access.');

class DB_Magazine_Shop_Supplier {
    const TABLE_NAME = 'sp_shop_suppliers';
    const TABLE_ID = 241;
    const NAME = 'DB_Magazine_Shop_Supplier';
    const TITLE = 'Поставщики';
    const IS_CATALOG = true;

    const INTEGRATIONS = [
        Integration_Ab1_1C_Service::SERVICE_NAME => [
            'type' => 'customer',
            'guid' => ['system' => 'id', '1c' => 'guid'],
            'guid_1c' => ['system' => 'guid_1c', '1c' => 'guid_1c'],
            'default' => [
                'ver' => 'mag',
                'contacts' => '',
            ],
            'children' => [
                //'contacts' => ['table' => 'DB_Ab1_Shop_Client_Contact', 'field' => 'shop_client_id'],
            ],
        ],
    ];

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."sp_shop_suppliers";',
            'create' => '
                -- ----------------------------
                -- Table structure for sp_shop_suppliers
                -- ----------------------------
                CREATE TABLE "public"."sp_shop_suppliers" (
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
                  "bin" varchar(12) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "address" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "amount" numeric(15,2) NOT NULL DEFAULT 0,
                  "contract" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "name_1c" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "name_site" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "account" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "bank" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "bik" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "organization_type_id" int8 NOT NULL DEFAULT 0,
                  "is_nds" numeric(1) NOT NULL DEFAULT 1,
                  "phones" text COLLATE "pg_catalog"."default",
                  "email" text COLLATE "pg_catalog"."default"
                )
                ;
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."shop_table_rubric_id" IS \'ID рубрики\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."bin" IS \'БИН\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."address" IS \'Адрес\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."amount" IS \'Сумма прихода\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."contract" IS \'Договор\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."name_1c" IS \'Название в 1C\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."name_site" IS \'Название на сайте\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."account" IS \'Номер счета\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."bank" IS \'Банк\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."bik" IS \'БИК\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."organization_type_id" IS \'Тип организации\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."is_nds" IS \'Является ли плательщиком НДС\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."phones" IS \'Телефоны\';
                COMMENT ON COLUMN "public"."sp_shop_suppliers"."email" IS \'E-mail\';
                COMMENT ON TABLE "public"."sp_shop_suppliers" IS \'Список поставщиков\';
                
                -- ----------------------------
                -- Indexes structure for table sp_shop_suppliers
                -- ----------------------------
                CREATE INDEX "sp_shop_supplier_first" ON "public"."sp_shop_suppliers" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_supplier_full_name" ON "public"."sp_shop_suppliers" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name::text), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "sp_shop_supplier_index_id" ON "public"."sp_shop_suppliers" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_supplier_index_order" ON "public"."sp_shop_suppliers" USING btree (
                  "order" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_supplier_name_like" ON "public"."sp_shop_suppliers" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_supplier_old_id" ON "public"."sp_shop_suppliers" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_supplier_shop_table_rubric_id" ON "public"."sp_shop_suppliers" USING btree (
                  "shop_table_rubric_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'shop_table_rubric_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID рубрики',
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
            'title' => 'Описание ',
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
        'name_1c' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название в 1C',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => ['name', 'complete']
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
        'is_nds' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Является ли плательщиком НДС',
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
        'shop_client_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => DB_Ab1_Shop_Client::NAME,
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