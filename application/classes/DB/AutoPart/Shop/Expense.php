<?php
defined('SYSPATH') or die('No direct script access.');

class DB_AutoPart_Shop_Expense {
    const TABLE_NAME = 'ap_shop_expenses';
    const TABLE_ID = '';
    const NAME = 'DB_AutoPart_Shop_Expense';
    const TITLE = '';
    const IS_CATALOG = false;


    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ap_shop_expenses";',
            'create' => '
                -- ----------------------------
                -- Table structure for ap_shop_expenses
                -- ----------------------------
                DROP TABLE IF EXISTS "public"."ap_shop_expenses";
                CREATE TABLE "public"."ap_shop_expenses" (
                      
				"id" int8 NOT NULL ,
				"is_public" numeric(1,0) NOT NULL  DEFAULT 1,
				"shop_id" int8 NOT NULL ,
				"name" varchar(250) COLLATE "pg_catalog"."default"  ,
				"text" text  ,
				"image_path" varchar(100) COLLATE "pg_catalog"."default"  ,
				"files" text  ,
				"options" text  ,
				"order" int8 NOT NULL  DEFAULT 0,
				"old_id" varchar(64) COLLATE "pg_catalog"."default" NOT NULL  DEFAULT 0,
				"create_user_id" int8   DEFAULT 0,
				"update_user_id" int8 NOT NULL ,
				"delete_user_id" int8   DEFAULT 0,
				"created_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
				"updated_at" timestamp(6) NOT NULL ,
				"deleted_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
				"is_delete" numeric(1,0) NOT NULL  DEFAULT 0,
				"language_id" int8 NOT NULL  DEFAULT 35,
				"global_id" int8 NOT NULL  DEFAULT nextval(\'global_id\'::regclass),
				"is_check" numeric(1,0) NOT NULL  DEFAULT 0,
				"date" date  ,
				"shop_source_id" int8 NOT NULL  DEFAULT 0,
				"amount" numeric(12,0) NOT NULL  DEFAULT 0,
				"shop_company_id" int8 NOT NULL  DEFAULT 0,
				"number" varchar(50) COLLATE "pg_catalog"."default"  ,
				"iik" varchar(50) COLLATE "pg_catalog"."default"  ,
				"kpn" varchar(5) COLLATE "pg_catalog"."default"  ,
				"shop_bank_account_id" int8 NOT NULL  DEFAULT 0,
				"is_load_file" numeric(1,0) NOT NULL  DEFAULT 0,
				"shop_expense_type_id" int8 NOT NULL  DEFAULT 0,
                );
                ALTER TABLE "public"."ap_shop_expenses" OWNER TO "postgres";
                COMMENT ON COLUMN "public"."ap_shop_expenses"."id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."order" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."old_id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."created_at" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."is_check" IS \'Проверка\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."date" IS \'Дата\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."shop_source_id" IS \'ID источника\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."shop_company_id" IS \'ID компании\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."number" IS \'№ документа\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."iik" IS \'Номер счета (ИИК бенефициара / отправителя денег)\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."kpn" IS \'КПН\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."shop_bank_account_id" IS \'ID банковского счета\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."is_load_file" IS \'Создана ли запись при загрузки из файла\';
                COMMENT ON COLUMN "public"."ap_shop_expenses"."shop_expense_type_id" IS \'ID вид расхода\';
                
                -- ----------------------------
                -- Indexes structure for table ap_shop_expenses
                -- ----------------------------
				CREATE INDEX ap_shop_expense_shop_expense_type_id ON ap_shop_expenses USING btree (shop_expense_type_id); 
				CREATE INDEX ap_shop_expense_shop_source_id ON ap_shop_expenses USING btree (shop_source_id); 
				CREATE INDEX ap_shop_expense_shop_bank_account_id ON ap_shop_expenses USING btree (shop_bank_account_id); 
				CREATE INDEX ap_shop_expense_is_check ON ap_shop_expenses USING btree (is_check); 
				CREATE INDEX ap_shop_expense_index_id ON ap_shop_expenses USING btree (id); 
				CREATE INDEX ap_shop_expense_first ON ap_shop_expenses USING btree (is_delete, language_id, shop_id); 
				CREATE INDEX ap_shop_expense_date ON ap_shop_expenses USING btree (date); 
				CREATE INDEX ap_shop_expense_shop_company_id ON ap_shop_expenses USING btree (shop_company_id); 
				CREATE UNIQUE INDEX ap_shop_payment_sources_copy1_pkey2 ON ap_shop_expenses USING btree (global_id); 
                ',
            'data' => '',
        ),

    );
    const FIELDS = array(
        'id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => '',
        ),
        'is_public' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Опубликована ли запись',
            'table' => '',
        ),
        'shop_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID магазина',
            'table' => 'DB_Shop',
        ),
        'name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Название',
            'table' => '',
        ),
        'text' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Описание ',
            'table' => '',
        ),
        'image_path' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 100,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Картинка',
            'table' => '',
        ),
        'files' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Дополнительные файлы',
            'table' => '',
        ),
        'options' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Дополнительные поля',
            'table' => '',
        ),
        'order' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => '',
        ),
        'old_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => '',
        ),
        'create_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Кто отредактировал эту запись',
            'table' => 'DB_User',
        ),
        'update_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Кто отредактировал эту запись',
            'table' => 'DB_User',
        ),
        'delete_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Кто удалил запись',
            'table' => 'DB_User',
        ),
        'created_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => '',
        ),
        'updated_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Дата обновления записи',
            'table' => '',
        ),
        'deleted_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Дата удаления записи',
            'table' => '',
        ),
        'is_delete' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Удалена ли запись',
            'table' => '',
        ),
        'language_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID языка',
            'table' => 'DB_Language',
        ),
        'global_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Глобальный ID',
            'table' => '',
        ),
        'is_check' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Проверка',
            'table' => '',
        ),
        'date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Дата',
            'table' => '',
        ),
        'shop_source_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID источника',
            'table' => 'DB_AutoPart_Shop_Source',
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма',
            'table' => '',
        ),
        'shop_company_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID Компании',
            'table' => 'DB_AutoPart_Shop_Company',
        ),
        'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Номер документа',
            'table' => '',
        ),
        'iik' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Номер счета (ИИК бенефициара / отправителя денег)',
            'table' => '',
        ),
        'kpn' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 5,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'КПН',
            'table' => '',
        ),
        'shop_bank_account_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID банковского счета',
            'table' => 'DB_AutoPart_Shop_Bank_Account',
        ),
        'is_load_file' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Создана ли запись при загрузки из файла',
            'table' => '',
        ),
        'shop_expense_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID Тип расходов',
            'table' => 'DB_AutoPart_Shop_Expense_Type',
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
