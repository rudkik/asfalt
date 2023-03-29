<?php defined('SYSPATH') or die('No direct script access.');

class DB_Magazine_Shop_Receive {
    const TABLE_NAME = 'sp_shop_receives';
    const TABLE_ID = 247;
    const NAME = 'DB_Magazine_Shop_Receive';
    const TITLE = 'Приемка';
    const IS_CATALOG = false;

    const INTEGRATIONS = [
        Integration_Ab1_1C_Service::SERVICE_NAME => [
            'type' => 'arrival',
            'guid' => ['system' => 'id', '1c' => 'guid'],
            'guid_1c' => ['system' => 'guid_1c', '1c' => 'guid_1c'],
            'children' => [
                'rows' => [
                    ['table' => 'DB_Magazine_Shop_Receive_Item', 'field_1' => 'id', 'field_2' => 'shop_receive_id'],
                ],
            ],
            'default' => [
                'ver' => 'mag',
                'currency' => 'KZT',
                'comment' => 'автоматическая загрузка',
                'contract_guid' => '',
                'contract_guid_1c' => '',
            ],
        ],
    ];

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."sp_shop_receives";',
            'create' => '
                -- ----------------------------
                -- Table structure for sp_shop_receives
                -- ----------------------------
                CREATE TABLE "public"."sp_shop_receives" (
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
                  "shop_supplier_id" int8 NOT NULL DEFAULT 0,
                  "quantity" numeric(12,3) NOT NULL DEFAULT 0,
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "operation_id" int8 DEFAULT 0,
                  "esf" text COLLATE "pg_catalog"."default",
                  "is_esf" numeric(1) NOT NULL DEFAULT 0,
                  "esf_date" timestamp(0) DEFAULT NULL::timestamp without time zone,
                  "date" date,
                  "esf_type_id" int8 NOT NULL DEFAULT 0,
                  "esf_number" varchar(50) COLLATE "pg_catalog"."default",
                  "is_nds" numeric(1) NOT NULL DEFAULT 0,
                  "number" varchar(50) COLLATE "pg_catalog"."default"
                )
                ;
                COMMENT ON COLUMN "public"."sp_shop_receives"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."sp_shop_receives"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."shop_supplier_id" IS \'ID поставщика\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."quantity" IS \'Количество\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."operation_id" IS \'Оператор приемки\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."esf" IS \'JSON полного документа ЭСФ\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."is_esf" IS \'Есть сверка с ЭСФ\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."esf_date" IS \'Время загрузки ЭСФ\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."date" IS \'Дата приемки\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."esf_type_id" IS \'ID тип счет-фактуры (электронная, бумажная)\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."esf_number" IS \'Номер счет фактуры\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."is_nds" IS \'Приход с НДС\';
                COMMENT ON COLUMN "public"."sp_shop_receives"."number" IS \'Номер счет-фактуры\';
                COMMENT ON TABLE "public"."sp_shop_receives" IS \'Список приемки продуктов\';
                
                -- ----------------------------
                -- Indexes structure for table sp_shop_receives
                -- ----------------------------
                CREATE INDEX "sp_shop_receive_esf_type_id" ON "public"."sp_shop_receives" USING btree (
                  "esf_type_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_receive_first" ON "public"."sp_shop_receives" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_receive_full_name" ON "public"."sp_shop_receives" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name::text), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "sp_shop_receive_index_id" ON "public"."sp_shop_receives" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_receive_index_order" ON "public"."sp_shop_receives" USING btree (
                  "order" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_receive_is_esf" ON "public"."sp_shop_receives" USING btree (
                  "is_esf" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_receive_name_like" ON "public"."sp_shop_receives" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_receive_old_id" ON "public"."sp_shop_receives" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_receive_operation_id" ON "public"."sp_shop_receives" USING btree (
                  "operation_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_receive_shop_supplier_id" ON "public"."sp_shop_receives" USING btree (
                  "shop_supplier_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
                    'storage' => 'old_id',
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
        'shop_supplier_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID поставщика',
            'table' => 'DB_Magazine_Shop_Supplier',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'customer_guid' => 'shop_client_id.id',
                    'customer_guid_1c' => 'shop_client_id.guid_1c',
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
        'operation_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Оператор приемки',
        ),
        'esf' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON полного документа ЭСФ',
        ),
        'is_esf' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Есть сверка с ЭСФ',
        ),
        'esf_date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Время загрузки ЭСФ',
        ),
        'date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата приемки',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'date',
            ],
        ),
        'esf_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID тип счет-фактуры (электронная, бумажная)',
            'table' => 'DB_Magazine_ESFType',
        ),
        'esf_number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер счет фактуры',
        ),
        'is_nds' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Приход с НДС',
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