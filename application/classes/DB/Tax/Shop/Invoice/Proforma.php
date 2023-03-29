<?php defined('SYSPATH') or die('No direct script access.');

class DB_Tax_Shop_Invoice_Proforma {
    const TABLE_NAME = 'tax_shop_invoice_proformas';
    const TABLE_ID = 61;
    const NAME = 'DB_Tax_Shop_Invoice_Proforma';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."tax_shop_invoice_proformas";',
            'create' => '
                -- ----------------------------
                -- Table structure for tax_shop_invoice_proformas
                -- ----------------------------
                CREATE TABLE "public"."tax_shop_invoice_proformas" (
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
                  "number" varchar(12) COLLATE "pg_catalog"."default",
                  "shop_contractor_id" int8 DEFAULT 0,
                  "date" date DEFAULT NULL::timestamp without time zone,
                  "shop_contract_id" int8 DEFAULT 0,
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "knp_id" int8 DEFAULT 0,
                  "is_nds" numeric(1) NOT NULL DEFAULT 0,
                  "nds" numeric(4,2) NOT NULL DEFAULT 1,
                  "shop_bank_account_id" int8 DEFAULT 0,
                  "shop_invoice_commercial_ids" text COLLATE "pg_catalog"."default",
                  "is_paid" numeric(1) NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."number" IS \'Номер\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."shop_contractor_id" IS \'ID контрагента\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."date" IS \'Дата счета фактуры\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."shop_contract_id" IS \'ID договора\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."knp_id" IS \'ID КНП\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."is_nds" IS \'НДС?\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."nds" IS \'НДС\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."shop_bank_account_id" IS \'ID банковского счета\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."shop_invoice_commercial_ids" IS \'Список счет-фактур через запятую\';
                COMMENT ON COLUMN "public"."tax_shop_invoice_proformas"."is_paid" IS \'Оплачен ли?\';
                COMMENT ON TABLE "public"."tax_shop_invoice_proformas" IS \'Список счетов на оплату\';
                
                -- ----------------------------
                -- Indexes structure for table tax_shop_invoice_proformas
                -- ----------------------------
                CREATE INDEX "tax_shop_invoice_commercial_first" ON "public"."tax_shop_invoice_proformas" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "tax_shop_invoice_commercial_index_id" ON "public"."tax_shop_invoice_proformas" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "tax_shop_invoice_commercial_is_paid" ON "public"."tax_shop_invoice_proformas" USING btree (
                  "is_paid" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "tax_shop_invoice_commercial_shop_contract_id" ON "public"."tax_shop_invoice_proformas" USING btree (
                  "shop_contract_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'knp_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID КНП',
            'table' => 'DB_Tax_KNP',
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
        'shop_invoice_commercial_ids' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Список счет-фактур через запятую',
        ),
        'is_paid' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Оплачен ли?',
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
