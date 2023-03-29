<?php
defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Delivery_Discount_Item {
    const TABLE_NAME = 'ab_shop_delivery_discount_items';
    const TABLE_ID = '';
    const NAME = 'DB_Ab1_Shop_Delivery_Discount_Item';
    const TITLE = '';
    const IS_CATALOG = false;


    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_delivery_discount_items";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_delivery_discount_items
                -- ----------------------------
                DROP TABLE IF EXISTS "public"."ab_shop_delivery_discount_items";
                CREATE TABLE "public"."ab_shop_delivery_discount_items" (
                      
				"id" int8 NOT NULL ,
				"shop_id" int8 NOT NULL ,
				"create_user_id" int8   DEFAULT 0,
				"update_user_id" int8 NOT NULL ,
				"delete_user_id" int8   DEFAULT 0,
				"created_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
				"updated_at" timestamp(6) NOT NULL ,
				"deleted_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
				"is_delete" numeric(1,0) NOT NULL  DEFAULT 0,
				"language_id" int8 NOT NULL  DEFAULT 35,
				"global_id" int8 NOT NULL  DEFAULT nextval(\'global_id\'::regclass),
				"shop_product_id" int8 NOT NULL  DEFAULT 0,
				"price" numeric(12,2) NOT NULL  DEFAULT 0,
				"shop_delivery_discount_id" int8 NOT NULL  DEFAULT 0,
				"is_public" numeric(1,0) NOT NULL  DEFAULT 1,
				"shop_product_rubric_id" int8 NOT NULL  DEFAULT 0,
				"shop_client_id" int8 NOT NULL  DEFAULT 0,
				"from_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
				"to_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
				"discount" numeric(12,2) NOT NULL  DEFAULT 0,
				"is_discount_amount" numeric(1,0) NOT NULL  DEFAULT 1,
				"block_amount" numeric(12,2) NOT NULL  DEFAULT 0,
				"balance_amount" numeric(12,2) NOT NULL  DEFAULT 0,
				"amount" numeric(12,2) NOT NULL  DEFAULT 0,
				"product_shop_branch_id" int8 NOT NULL  DEFAULT 0,
                );
                ALTER TABLE "public"."ab_shop_delivery_discount_items" OWNER TO "postgres";
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."id" IS \'\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."created_at" IS \'\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."shop_product_id" IS \'Тип единицы измерения\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."price" IS \'Цена\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."shop_delivery_discount_id" IS \'ID прайс-листа\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."shop_product_rubric_id" IS \'ID рубрики\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."shop_client_id" IS \'ID клиента\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."from_at" IS \'Срок действия от\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."to_at" IS \'Срок действия до\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."discount" IS \'Скидка в тенге\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."is_discount_amount" IS \'Скидка в валюте\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."block_amount" IS \'Сумма истраченная\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."balance_amount" IS \'Сумма остатка\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."ab_shop_delivery_discount_items"."product_shop_branch_id" IS \'ID филиала продукции\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_delivery_discount_items
                -- ----------------------------
				CREATE INDEX ab_shop_delivery_discount_item_first ON public.ab_shop_delivery_discount_items USING btree (is_delete, language_id, shop_id, is_public); 
				CREATE INDEX ab_shop_delivery_discount_item_from_at ON public.ab_shop_delivery_discount_items USING btree (from_at); 
				CREATE INDEX ab_shop_delivery_discount_item_index_id ON public.ab_shop_delivery_discount_items USING btree (id); 
				CREATE INDEX ab_shop_delivery_discount_item_shop_client_id ON public.ab_shop_delivery_discount_items USING btree (shop_client_id); 
				CREATE INDEX ab_shop_delivery_discount_item_shop_delivery_discount_id ON public.ab_shop_delivery_discount_items USING btree (shop_delivery_discount_id); 
				CREATE INDEX ab_shop_delivery_discount_item_shop_product_id ON public.ab_shop_delivery_discount_items USING btree (shop_product_id); 
				CREATE INDEX ab_shop_delivery_discount_item_shop_product_rubric_id ON public.ab_shop_delivery_discount_items USING btree (shop_product_rubric_id); 
				CREATE INDEX ab_shop_delivery_discount_item_to_at ON public.ab_shop_delivery_discount_items USING btree (to_at); 
				CREATE UNIQUE INDEX ab_shop_delivery_discount_items_pkey ON public.ab_shop_delivery_discount_items USING btree (global_id); 
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
        'shop_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID магазина',
            'table' => 'DB_Ab1_Shop',
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
        'shop_product_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип единицы измерения',
            'table' => 'DB_Ab1_Shop_Product',
        ),
        'price' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена',
            'table' => '',
        ),
        'shop_delivery_discount_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID прайс-листа',
            'table' => 'DB_Ab1_Shop_Delivery_Discount',
        ),
        'is_public' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Опубликована ли запись',
            'table' => '',
        ),
        'shop_product_rubric_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID рубрики',
            'table' => 'DB_Ab1_Shop_Product_Rubric',
        ),
        'shop_client_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID клиента',
            'table' => 'DB_Ab1_Shop_Client',
        ),
        'from_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Срок действия от',
            'table' => '',
        ),
        'to_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Срок действия до',
            'table' => '',
        ),
        'discount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Скидка в тенге',
            'table' => '',
        ),
        'is_discount_amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Скидка в валюте',
            'table' => '',
        ),
        'block_amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма истраченная',
            'table' => '',
        ),
        'balance_amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма остатка',
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
        'product_shop_branch_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID филиала продукции',
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
