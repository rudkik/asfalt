<?php defined('SYSPATH') or die('No direct script access.');

class DB_Tax_Shop_My_Invoice {
    const TABLE_NAME = 'tax_shop_my_invoices';
    const TABLE_ID = 61;
    const NAME = 'DB_Tax_Shop_My_Invoice';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."tax_shop_my_invoices";',
            'create' => '
                -- ----------------------------
                -- Table structure for tax_shop_my_invoices
                -- ----------------------------
                CREATE TABLE "public"."tax_shop_my_invoices" (
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
                  "shop_contract_id" int8 DEFAULT 0,
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "shop_act_revise_id" int8 NOT NULL DEFAULT 0,
                  "is_nds" numeric(1) NOT NULL DEFAULT 0,
                  "nds" numeric(4,2) NOT NULL DEFAULT 1,
                  "is_act_service" numeric(1) NOT NULL DEFAULT 0,
                  "act_service_number" varchar(50) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "act_service_date" date DEFAULT NULL::timestamp without time zone,
                  "is_act_product" numeric(1) NOT NULL DEFAULT 0,
                  "act_product_number" varchar(50) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "act_product_date" date DEFAULT NULL::timestamp without time zone,
                  "is_invoice_commercial" numeric(1) NOT NULL DEFAULT 0,
                  "invoice_commercial_number" varchar(50) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "invoice_commercial_date" date DEFAULT NULL::timestamp without time zone,
                  "is_cash_memo" numeric(1) NOT NULL DEFAULT 0,
                  "cash_memo_number" varchar(50) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "cash_memo_date" date DEFAULT NULL::timestamp without time zone
                )
                ;
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."shop_table_catalog_id" IS \'Тип товара\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."shop_table_rubric_id" IS \'ID рубрики\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."shop_table_select_id" IS \'Тип выделения \';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."shop_table_brand_id" IS \'ID бренда \';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."seo" IS \'JSON массива настройки SEO\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."remarketing" IS \'Код ремаркетинга\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."collations" IS \'JSON список значений для сопоставления\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."shop_table_object_ids" IS \'JSON данные списком\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."shop_table_unit_id" IS \'Тип единицы измерения\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."number" IS \'Номер\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."shop_contractor_id" IS \'ID контрагента\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."date" IS \'Дата счета фактуры\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."shop_contract_id" IS \'ID договора\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."shop_act_revise_id" IS \'ID ревизии\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."is_nds" IS \'НДС?\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."nds" IS \'НДС\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."is_act_service" IS \'Акт выполненных работ предоставлен?\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."act_service_number" IS \'Номер Акта выполненных работ\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."act_service_date" IS \'Дата Акта выполненных работ\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."is_act_product" IS \'Накладная на отпуск товаров предоставлена?\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."act_product_number" IS \'Номер Накладная на отпуск товаров\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."act_product_date" IS \'Дата Накладная на отпуск товаров\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."is_invoice_commercial" IS \'Счет-фактура предоставлена?\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."invoice_commercial_number" IS \'Номер Счет-фактуры\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."invoice_commercial_date" IS \'Дата Счет-фактуры\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."is_cash_memo" IS \'Товарный чек предоставлен?\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."cash_memo_number" IS \'Номер Товарного чека\';
                COMMENT ON COLUMN "public"."tax_shop_my_invoices"."cash_memo_date" IS \'Дата Товарного чека\';
                
                -- ----------------------------
                -- Indexes structure for table tax_shop_my_invoices
                -- ----------------------------
                CREATE INDEX "ab_shop_car_first_copy3_copy4" ON "public"."tax_shop_my_invoices" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_table_catalog_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_index_id_copy3_copy4" ON "public"."tax_shop_my_invoices" USING btree (
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
        'shop_contract_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID договора',
            'table' => 'DB_Tax_Shop_Contract',
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма',
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
        'is_act_service' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Акт выполненных работ предоставлен?',
        ),
        'act_service_number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер Акта выполненных работ',
        ),
        'act_service_date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата Акта выполненных работ',
        ),
        'is_act_product' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Накладная на отпуск товаров предоставлена?',
        ),
        'act_product_number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер Накладная на отпуск товаров',
        ),
        'act_product_date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата Накладная на отпуск товаров',
        ),
        'is_invoice_commercial' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Счет-фактура предоставлена?',
        ),
        'invoice_commercial_number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер Счет-фактуры',
        ),
        'invoice_commercial_date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата Счет-фактуры',
        ),
        'is_cash_memo' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Товарный чек предоставлен?',
        ),
        'cash_memo_number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер Товарного чека',
        ),
        'cash_memo_date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата Товарного чека',
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
