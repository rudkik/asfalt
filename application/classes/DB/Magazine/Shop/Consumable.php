<?php defined('SYSPATH') or die('No direct script access.');

class DB_Magazine_Shop_Consumable {
    const TABLE_NAME = 'sp_shop_consumables';
    const TABLE_ID = 269;
    const NAME = 'DB_Magazine_Shop_Consumable';
    const TITLE = 'Расходники';
    const IS_CATALOG = false;

    const INTEGRATIONS = [
        Integration_Ab1_1C_Service::SERVICE_NAME => [
            'type' => 'cashout',
            'guid' => ['system' => 'id', '1c' => 'guid'],
            'guid_1c' => ['system' => 'guid_1c', '1c' => 'guid_1c'],
            'default' => [
                'operation' => 2,
                'currency' => 'KZT',
                'comment' => 'автоматическая загрузка',
            ]
        ],
    ];

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."sp_shop_consumables";',
            'create' => '
                -- ----------------------------
                -- Table structure for sp_shop_consumables
                -- ----------------------------
                CREATE TABLE "public"."sp_shop_consumables" (
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
                  "number" varchar(64) COLLATE "pg_catalog"."default" NOT NULL DEFAULT \'\'::character varying,
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "from_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "to_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "extradite" text COLLATE "pg_catalog"."default" NOT NULL DEFAULT \'\'::character varying,
                  "base" text COLLATE "pg_catalog"."default" NOT NULL DEFAULT \'\'::character varying,
                  "pko_number" varchar(64) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "pko_date" date
                )
                ;
                COMMENT ON COLUMN "public"."sp_shop_consumables"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."sp_shop_consumables"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."sp_shop_consumables"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."sp_shop_consumables"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."sp_shop_consumables"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."sp_shop_consumables"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."sp_shop_consumables"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."sp_shop_consumables"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sp_shop_consumables"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sp_shop_consumables"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."sp_shop_consumables"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."sp_shop_consumables"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."sp_shop_consumables"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."sp_shop_consumables"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."sp_shop_consumables"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."sp_shop_consumables"."number" IS \'Номер счета\';
                COMMENT ON COLUMN "public"."sp_shop_consumables"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."sp_shop_consumables"."extradite" IS \'Выдать\';
                COMMENT ON COLUMN "public"."sp_shop_consumables"."base" IS \'Основание\';
                COMMENT ON COLUMN "public"."sp_shop_consumables"."pko_number" IS \'Номер ПКО\';
                COMMENT ON COLUMN "public"."sp_shop_consumables"."pko_date" IS \'Дата ПКО\';
                COMMENT ON TABLE "public"."sp_shop_consumables" IS \'Список расходников\';
                
                -- ----------------------------
                -- Indexes structure for table sp_shop_consumables
                -- ----------------------------
                CREATE INDEX "sp_shop_consumable_created_at" ON "public"."sp_shop_consumables" USING btree (
                  "created_at" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_consumable_first" ON "public"."sp_shop_consumables" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_consumable_index_id" ON "public"."sp_shop_consumables" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'sum',
            ],
        ),
        'from_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => '',
        ),
        'to_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => '',
        ),
        'extradite' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Выдать',
        ),
        'base' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Основание',
        ),
        'pko_number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер ПКО',
        ),
        'pko_date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата ПКО',
        ),
        'shop_cashbox_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID фискального регистратора отправителя',
            'table' => 'DB_Ab1_Shop_Cashbox',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'sender' => 'old_id',
                ]
            ],
        ),
        'receiver_shop_cashbox_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID фискального регистратора получателя',
            'table' => 'DB_Ab1_Shop_Cashbox',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'receiver' => 'old_id',
                ]
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
