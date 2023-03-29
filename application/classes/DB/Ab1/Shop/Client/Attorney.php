<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Client_Attorney {
    const TABLE_NAME = 'ab_shop_client_attorneys';
    const TABLE_ID = 94;
    const NAME = 'DB_Ab1_Shop_Client_Attorney';
    const TITLE = 'Доверенности клиентов';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_client_attorneys";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_client_attorneys
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_client_attorneys" (
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
                  "block_amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "shop_client_id" int8 NOT NULL DEFAULT 0,
                  "name_weight" text COLLATE "pg_catalog"."default",
                  "shop_client_contract_id" int8 NOT NULL DEFAULT 0,
                  "client_name" text COLLATE "pg_catalog"."default",
                  "delivery_amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "block_delivery_amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "amount_1c" numeric(12,2) NOT NULL DEFAULT 0,
                  "balance" numeric(12,2) NOT NULL DEFAULT 0,
                  "balance_delivery" numeric(12,2) NOT NULL DEFAULT 0,
                  "attorney_update_user_id" int8 NOT NULL DEFAULT 0,
                  "attorney_updated_at" timestamp(6) DEFAULT NULL::timestamp without time zone
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."number" IS \'Номер\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."from_at" IS \'Доверенность от\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."to_at" IS \'Доверенность до\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."block_amount" IS \'Заблокированная сумма\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."shop_client_id" IS \'ID клиента\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."name_weight" IS \'Название весовой\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."shop_client_contract_id" IS \'ID договора\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."client_name" IS \'Доверенное лицо\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."delivery_amount" IS \'Сумма доставки\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."block_delivery_amount" IS \'Заблокированная сумма доставки\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."amount_1c" IS \'Сумма с 1С\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."balance" IS \'Остаток по доверенности\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."balance_delivery" IS \'Остаток по доcтавки\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."attorney_update_user_id" IS \'Кто отредактировал доверенность из интерфейса доверенности\';
                COMMENT ON COLUMN "public"."ab_shop_client_attorneys"."attorney_updated_at" IS \'Дата обновления записи из интерфейса доверенности\';
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
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма',
            'is_total_items' => true,
        ),
        'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер',
        ),
        'from_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Доверенность от',
        ),
        'to_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Доверенность до',
        ),
        'block_amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Заблокированная сумма',
        ),
        'shop_client_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID клиента',
            'table' => 'DB_Ab1_Shop_Client',
        ),
        'name_weight' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название весовой',
        ),
        'shop_client_contract_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID договора',
            'table' => 'DB_Ab1_Shop_Client_Contract',
        ),
        'client_name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Доверенное лицо',
        ),
        'delivery_amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма доставки',
        ),
        'block_delivery_amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Заблокированная сумма доставки',
        ),
        'amount_1c' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма с 1С',
        ),
        'balance' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Остаток по доверенности',
        ),
        'balance_delivery' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Остаток по доcтавки',
        ),
        'attorney_update_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Кто отредактировал доверенность из интерфейса доверенности',
            'table' => 'DB_User',
        ),
        'attorney_updated_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата обновления записи из интерфейса доверенности',
        ),
    );

    // список связанных таблиц 1коМногим
    const ITEMS = array(
        'shop_client_attorney_items' => array(
            'table' => 'DB_Ab1_Shop_Client_Attorney_Item',
            'field_id' => 'shop_client_attorney_id',
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
