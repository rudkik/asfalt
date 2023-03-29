<?php
defined('SYSPATH') or die('No direct script access.');

class DB_AutoPart_Shop_Receive {
    const TABLE_NAME = 'ap_shop_receives';
    const TABLE_ID = '';
    const NAME = 'DB_AutoPart_Shop_Receive';
    const TITLE = '';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ap_shop_receives";',
            'create' => '
                -- ----------------------------
                -- Table structure for ap_shop_receives
                -- ----------------------------
                DROP TABLE IF EXISTS "public"."ap_shop_receives";
                CREATE TABLE "public"."ap_shop_receives" (
                      
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
				"is_nds" numeric(1,0) NOT NULL  DEFAULT 0,
				"date" date  ,
				"amount" numeric(12,2) NOT NULL  DEFAULT 0,
				"shop_supplier_id" int8 NOT NULL  DEFAULT 0,
				"esf" text  ,
				"esf_number" varchar(250) COLLATE "pg_catalog"."default"  ,
				"esf_date" date  ,
				"shop_courier_id" int8 NOT NULL  DEFAULT 0,
				"quantity" numeric(12,3) NOT NULL  DEFAULT 0,
				"number" varchar(250) COLLATE "pg_catalog"."default"  ,
                );
                ALTER TABLE "public"."ap_shop_receives" OWNER TO "postgres";
                COMMENT ON COLUMN "public"."ap_shop_receives"."id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ap_shop_receives"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."order" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."old_id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."created_at" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."is_nds" IS \'НДС есть ли\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."date" IS \'Дата\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."shop_supplier_id" IS \'ID поставщика\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."esf" IS \'Esf Описание \';
                COMMENT ON COLUMN "public"."ap_shop_receives"."esf_number" IS \'Esf номер\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."esf_date" IS \'Esf Дата\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."shop_courier_id" IS \'ID курьера\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."quantity" IS \'Первоначальное количество\';
                COMMENT ON COLUMN "public"."ap_shop_receives"."number" IS \'Номер\';
                
                -- ----------------------------
                -- Indexes structure for table ap_shop_receives
                -- ----------------------------
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
        'is_nds' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'НДС есть ли',
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
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма',
            'table' => '',
        ),
        'shop_supplier_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID поставщика',
            'table' => 'DB_AutoPart_Shop_Supplier',
        ),
        'esf' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Esf Описание ',
            'table' => '',
        ),
        'esf_number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Esf номер',
            'table' => '',
        ),
        'esf_date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Esf Дата',
            'table' => '',
        ),
        'quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Первоначальное количество',
            'table' => '',
        ),
        'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Номер',
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
        'is_load_file' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Создана ли запись при загрузки из файла',
            'table' => '',
        ),
        'shop_company_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID курьера',
            'table' => 'DB_AutoPart_Shop_Company',
        ),
        'is_return' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Является возвратом',
            'table' => '',
        ),
        'return_shop_receive_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID закупа возврата',
            'table' => 'DB_AutoPart_Shop_Receive',
        ),
        'is_store' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'На складе',
            'table' => '',
        ),
    );

    // список связанных таблиц 1коМногим
    const ITEMS = array(
        'shop_receive_items' => array(
            'table' => 'DB_AutoPart_Shop_Receive_Item',
            'field_id' => 'shop_receive_id',
            'is_view' => false,
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
