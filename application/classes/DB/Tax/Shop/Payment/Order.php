<?php defined('SYSPATH') or die('No direct script access.');

class DB_Tax_Shop_Payment_Order {
    const TABLE_NAME = 'tax_shop_payment_orders';
    const TABLE_ID = 61;
    const NAME = 'DB_Tax_Shop_Payment_Order';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."tax_shop_payment_orders";',
            'create' => '
                -- ----------------------------
                -- Table structure for tax_shop_payment_orders
                -- ----------------------------
                CREATE TABLE "public"."tax_shop_payment_orders" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "shop_table_catalog_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_rubric_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_select_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_brand_id" int8 NOT NULL DEFAULT 0,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "text" text COLLATE "pg_catalog"."default",
                  "image_path" varchar(100) COLLATE "pg_catalog"."default",
                  "files" text COLLATE "pg_catalog"."default",
                  "options" text COLLATE "pg_catalog"."default",
                  "seo" text COLLATE "pg_catalog"."default",
                  "remarketing" text COLLATE "pg_catalog"."default",
                  "collations" text COLLATE "pg_catalog"."default",
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
                  "shop_table_object_ids" text COLLATE "pg_catalog"."default",
                  "shop_table_unit_id" int8 NOT NULL DEFAULT 0,
                  "number" varchar(12) COLLATE "pg_catalog"."default",
                  "shop_contractor_id" int8 DEFAULT 0,
                  "date" date DEFAULT NULL::timestamp without time zone,
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "kbe_id" int8 DEFAULT 0,
                  "knp_id" int8 DEFAULT 0,
                  "kbk_id" int8 DEFAULT 0,
                  "is_items" numeric(1) NOT NULL DEFAULT 0,
                  "authority_id" int8 DEFAULT 0,
                  "gov_contractor_id" int8 DEFAULT 0,
                  "shop_act_revise_id" int8 NOT NULL DEFAULT 0,
                  "is_cash" numeric(1) NOT NULL DEFAULT 1,
                  "is_coming" numeric(1) NOT NULL DEFAULT 1,
                  "shop_bank_account_id" int8 DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."shop_table_catalog_id" IS \'Тип товара\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."shop_table_rubric_id" IS \'ID рубрики\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."shop_table_select_id" IS \'Тип выделения \';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."shop_table_brand_id" IS \'ID бренда \';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."seo" IS \'JSON массива настройки SEO\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."remarketing" IS \'Код ремаркетинга\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."collations" IS \'JSON список значений для сопоставления\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."shop_table_object_ids" IS \'JSON данные списком\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."shop_table_unit_id" IS \'Тип единицы измерения\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."number" IS \'Номер\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."shop_contractor_id" IS \'ID контрагента\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."date" IS \'Дата счета фактуры\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."kbe_id" IS \'КБе\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."knp_id" IS \'Код назначения платежа\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."kbk_id" IS \'Код бюджетной классификации\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."is_items" IS \'Привязать реестр\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."authority_id" IS \'Налоговый коммитет\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."gov_contractor_id" IS \'ID правительственного контрагента\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."shop_act_revise_id" IS \'ID ревизии\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."is_cash" IS \'Наличные/безналичные\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."is_coming" IS \'Приход/Расход\';
                COMMENT ON COLUMN "public"."tax_shop_payment_orders"."shop_bank_account_id" IS \'ID банковского счета\';
                
                -- ----------------------------
                -- Indexes structure for table tax_shop_payment_orders
                -- ----------------------------
                CREATE INDEX "ab_shop_car_first_copy3_copy2" ON "public"."tax_shop_payment_orders" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_table_catalog_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_index_id_copy3_copy2" ON "public"."tax_shop_payment_orders" USING btree (
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
        ),
        'shop_table_catalog_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип товара',
            'table' => 'DB_Shop_Table_Catalog',
        ),
        'shop_table_rubric_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID рубрики',
            'table' => 'DB_Shop_Table_Rubric',
        ),
        'shop_table_select_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип выделения ',
            'table' => 'DB_Shop_Table_Select',
        ),
        'shop_table_brand_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID бренда ',
            'table' => 'DB_Shop_Table_Brand',
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
        'seo' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON массива настройки SEO',
        ),
        'remarketing' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Код ремаркетинга',
        ),
        'collations' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON список значений для сопоставления',
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
        'shop_table_object_ids' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON данные списком',
        ),
        'shop_table_unit_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип единицы измерения',
            'table' => 'DB_Shop_Table_Unit',
        ),
        'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 12,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер',
        ),
        'shop_contractor_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID контрагента',
            'table' => 'DB_Tax_Shop_Contractor',
        ),
        'date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата счета фактуры',
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма',
        ),
        'kbe_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'КБе',
            'table' => 'DB_Tax_KBe',
        ),
        'knp_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Код назначения платежа',
            'table' => 'DB_Tax_KNP',
        ),
        'kbk_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Код бюджетной классификации',
            'table' => 'DB_Tax_KBK',
        ),
        'is_items' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Привязать реестр',
        ),
        'authority_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Налоговый коммитет',
            'table' => 'DB_Tax_Authority',
        ),
        'gov_contractor_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID правительственного контрагента',
            'table' => 'DB_Tax_GovContractor',
        ),
        'shop_act_revise_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID ревизии',
            'table' => 'DB_Tax_Shop_Act_Revise',
        ),
        'is_cash' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Наличные/безналичные',
        ),
        'is_coming' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Приход/Расход',
        ),
        'shop_bank_account_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID банковского счета',
            'table' => 'DB_Tax_Shop_Bank_Account',
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
