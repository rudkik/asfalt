<?php defined('SYSPATH') or die('No direct script access.');

class DB_Tax_Shop_Invoice_Commercial {
    const TABLE_NAME = 'tax_shop_invoice_commercials';
    const TABLE_ID = 61;
    const NAME = 'DB_Tax_Shop_Invoice_Commercial';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."tax_shop_invoice_commercials";',
            'create' => '
                -- ----------------------------
                -- Table structure for tax_shop_invoice_commercials
                -- ----------------------------
                CREATE TABLE "public"."tax_shop_invoice_commercials" (
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
                  "address_delivery" text COLLATE "pg_catalog"."default",
                  "date" date DEFAULT NULL::timestamp without time zone,
                  "shop_contract_id" int8 DEFAULT 0,
                  "paid_type_id" int8 DEFAULT 0,
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "shop_attorney_id" int8 DEFAULT 0,
                  "shop_act_revise_id" int8 NOT NULL DEFAULT 0,
                  "is_nds" numeric(1) NOT NULL DEFAULT 0,
                  "nds" numeric(4,2) NOT NULL DEFAULT 1,
                  "shop_bank_account_id" int8 DEFAULT 0,
                  "shop_invoice_proforma_ids" text COLLATE "pg_catalog"."default"
                )
                ;
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."shop_table_catalog_id" IS \'Тип товара\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."shop_table_rubric_id" IS \'ID рубрики\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."shop_table_select_id" IS \'Тип выделения \';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."shop_table_brand_id" IS \'ID бренда \';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."seo" IS \'JSON массива настройки SEO\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."remarketing" IS \'Код ремаркетинга\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."collations" IS \'JSON список значений для сопоставления\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."shop_table_object_ids" IS \'JSON данные списком\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."shop_table_unit_id" IS \'Тип единицы измерения\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."number" IS \'Номер\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."shop_contractor_id" IS \'ID контрагента\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."address_delivery" IS \'Пункт назначения\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."date" IS \'Дата счета фактуры\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."shop_contract_id" IS \'ID договора\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."paid_type_id" IS \'ID способа оплаты\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."shop_attorney_id" IS \'ID доверенности\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."shop_act_revise_id" IS \'ID ревизии\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."is_nds" IS \'НДС?\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."nds" IS \'НДС\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."shop_bank_account_id" IS \'ID банковского счета\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_commercials"."shop_invoice_proforma_ids" IS \'Список счетов на оплату через запятую\';
                
                -- ----------------------------
                -- Indexes structure for table tax_shop_invoice_commercials
                -- ----------------------------
                CREATE INDEX "ab_shop_car_first_copy3" ON "public"."tax_shop_invoice_commercials" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_table_catalog_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_index_id_copy3" ON "public"."tax_shop_invoice_commercials" USING btree (
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
        'address_delivery' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Пункт назначения',
        ),
        'date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата счета фактуры',
        ),
        'shop_contract_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID договора',
            'table' => 'DB_Tax_Shop_Contract',
        ),
        'paid_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID способа оплаты',
            'table' => 'DB_PaidType',
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма',
        ),
        'shop_attorney_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID доверенности',
            'table' => 'DB_Tax_Shop_Attorney',
        ),
        'shop_act_revise_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID ревизии',
            'table' => 'DB_Tax_Shop_Act_Revise',
        ),
        'is_nds' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'НДС?',
        ),
        'nds' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 4,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'НДС',
        ),
        'shop_bank_account_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID банковского счета',
            'table' => 'DB_Tax_Shop_Bank_Account',
        ),
        'shop_invoice_proforma_ids' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Список счетов на оплату через запятую',
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
