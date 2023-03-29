<?php
defined('SYSPATH') or die('No direct script access.');

class DB_AutoPart_Shop_Purchase_Product {
    const TABLE_NAME = 'ap_shop_purchase_products';
    const TABLE_ID = '';
    const NAME = 'DB_AutoPart_Shop_Purchase_Product';
    const TITLE = '';
    const IS_CATALOG = false;


    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ap_shop_purchase_products";',
            'create' => '
                -- ----------------------------
                -- Table structure for ap_shop_purchase_products
                -- ----------------------------
                DROP TABLE IF EXISTS "public"."ap_shop_purchase_products";
                CREATE TABLE "public"."ap_shop_purchase_products" (
                      
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
                ALTER TABLE "public"."ap_shop_purchase_products" OWNER TO "postgres";
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."order" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."old_id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."created_at" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."is_nds" IS \'НДС есть ли\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."date" IS \'Дата\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."shop_supplier_id" IS \'ID поставщика\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."esf" IS \'Esf Описание \';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."esf_number" IS \'Esf номер\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."esf_date" IS \'Esf Дата\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."shop_courier_id" IS \'ID курьера\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."quantity" IS \'Первоначальное количество\';
                COMMENT ON COLUMN "public"."ap_shop_purchase_products"."number" IS \'Номер\';
                
                -- ----------------------------
                -- Indexes structure for table ap_shop_purchase_products
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
            'title' => 'ID источника',
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
        'shop_courier_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID курьера',
            'table' => 'DB_AutoPart_Shop_Courier',
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
            'title' => 'номер',
            'table' => '',
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
