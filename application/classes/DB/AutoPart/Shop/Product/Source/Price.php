<?php
defined('SYSPATH') or die('No direct script access.');

class DB_AutoPart_Shop_Product_Source_Price {
    const TABLE_NAME = 'ap_shop_product_source_prices';
    const TABLE_ID = '';
    const NAME = 'DB_AutoPart_Shop_Product_Source_Price';
    const TITLE = '';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ap_shop_product_source_prices";',
            'create' => '
                -- ----------------------------
                -- Table structure for ap_shop_product_source_prices
                -- ----------------------------
                DROP TABLE IF EXISTS "public"."ap_shop_product_source_prices";
                CREATE TABLE "public"."ap_shop_product_source_prices" (
                      
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
				"price_min" numeric(12,2) NOT NULL  DEFAULT 0,
				"price_cost" numeric(12,2) NOT NULL  DEFAULT 0,
				"shop_source_id" int8 NOT NULL  DEFAULT 0,
				"price_max" numeric(12,2) NOT NULL  DEFAULT 0,
				"shop_rubric_source_id" int8 NOT NULL  DEFAULT 0,
				"shop_product_id" int8 NOT NULL  DEFAULT 0,
				"profit" numeric(12,2) NOT NULL  DEFAULT 0,
				"price_source" numeric(12,2) NOT NULL  DEFAULT 0,
				"shop_company_id" int8 NOT NULL  DEFAULT 0,
				"commission" int2 NOT NULL  DEFAULT 0,
				"price_supplier" numeric(12,2) NOT NULL  DEFAULT 0,
				"shop_product_source_id" int8 NOT NULL  DEFAULT 0,
				"position_number" numeric(12,2) NOT NULL  DEFAULT 0,
				"position_count" numeric(12,2) NOT NULL  DEFAULT 0,
                );
                ALTER TABLE "public"."ap_shop_product_source_prices" OWNER TO "postgres";
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."order" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."old_id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."created_at" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."price_min" IS \'Минимальная цена\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."price_cost" IS \'Себестоимость\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."shop_source_id" IS \'ID источника интеграции\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."price_max" IS \'Максимальная цена\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."shop_rubric_source_id" IS \'ID рубрики источника интеграции\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."shop_product_id" IS \'ID продукции\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."profit" IS \'Прибыль\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."price_source" IS \'Цена продажи на сайте источника\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."shop_company_id" IS \'ID компании\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."commission" IS \'Процент комиссии для размещения товаров у этого поставщика\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."price_supplier" IS \'Цена продажи поставщика\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."shop_product_source_id" IS \'ID продукции источника\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."position_number" IS \'Позиция размещения у источника\';
                COMMENT ON COLUMN "public"."ap_shop_product_source_prices"."position_count" IS \'Количество предложений товара\';
                
                -- ----------------------------
                -- Indexes structure for table ap_shop_product_source_prices
                -- ----------------------------
				CREATE INDEX ap_shop_product_source_price_shop_source_id ON ap_shop_product_source_prices USING btree (shop_source_id); 
				CREATE INDEX ap_shop_product_source_price_shop_rubric_source_id ON ap_shop_product_source_prices USING btree (shop_rubric_source_id); 
				CREATE INDEX ap_shop_product_source_price_shop_product_id ON ap_shop_product_source_prices USING btree (shop_product_id); 
				CREATE INDEX ap_shop_product_source_price_shop_company_id ON ap_shop_product_source_prices USING btree (shop_company_id); 
				CREATE INDEX ap_shop_product_source_price_index_id ON ap_shop_product_source_prices USING btree (id); 
				CREATE INDEX ap_shop_product_source_price_first ON ap_shop_product_source_prices USING btree (is_delete, language_id, shop_id, is_public); 
				CREATE UNIQUE INDEX ap_shop_product_sources_copy1_pkey ON ap_shop_product_source_prices USING btree (global_id); 
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
            'title' => 'Номер авто',
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
        'price_min' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Минимальная цена',
            'table' => '',
        ),
        'price_cost' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Себестоимость',
            'table' => '',
        ),
        'shop_source_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID источника интеграции',
            'table' => 'DB_AutoPart_Shop_Source',
        ),
        'price_max' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Максимальная цена',
            'table' => '',
        ),
        'shop_rubric_source_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID рубрики источника интеграции',
            'table' => 'DB_AutoPart_Shop_Rubric_Source',
        ),
        'shop_product_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID продукции',
            'table' => 'DB_AutoPart_Shop_Product',
        ),
        'profit' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Прибыль',
            'table' => '',
        ),
        'price_source' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена продажи на сайте источника',
            'table' => '',
        ),
        'shop_company_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID компании',
            'table' => 'DB_AutoPart_Shop_Company',
        ),
        'commission' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 16,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Процент комиссии для размещения товаров у этого поставщика',
            'table' => '',
        ),
        'price' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена продажи',
            'table' => '',
        ),
        'shop_product_source_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID продукции источника',
            'table' => 'DB_AutoPart_Shop_Product_Source',
        ),
        'position_number' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Позиция размещения у источника',
            'table' => '',
        ),
        'position_count' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Количество предложений товара',
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
