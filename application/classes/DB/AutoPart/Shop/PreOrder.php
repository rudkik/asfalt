<?php
defined('SYSPATH') or die('No direct script access.');

class DB_AutoPart_Shop_PreOrder {
    const TABLE_NAME = 'ap_shop_pre_orders';
    const TABLE_ID = '';
    const NAME = 'DB_AutoPart_Shop_PreOrder';
    const TITLE = '';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ap_shop_pre_orders";',
            'create' => '
                -- ----------------------------
                -- Table structure for ap_shop_pre_orders
                -- ----------------------------
                DROP TABLE IF EXISTS "public"."ap_shop_pre_orders";
                CREATE TABLE "public"."ap_shop_pre_orders" (
                      
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
				"shop_courier_id" int8 NOT NULL  DEFAULT 0,
				"quantity" numeric(12,3) NOT NULL  DEFAULT 0,
				"number" varchar(250) COLLATE "pg_catalog"."default"  ,
				"is_buy" numeric(1,0) NOT NULL  DEFAULT 0,
				"buy_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
				"shop_supplier_address_id" int8 NOT NULL  DEFAULT 0,
				"is_load_file" numeric(1,0) NOT NULL  DEFAULT 0,
				"is_check" numeric(1,0) NOT NULL  DEFAULT 0,
				"shop_company_id" int8 NOT NULL  DEFAULT 0,
                );
                ALTER TABLE "public"."ap_shop_pre_orders" OWNER TO "postgres";
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."order" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."old_id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."created_at" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."is_nds" IS \'НДС есть ли\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."date" IS \'Дата документа\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."shop_supplier_id" IS \'ID поставщика\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."shop_courier_id" IS \'ID курьера\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."quantity" IS \'Количество товаров\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."number" IS \'Номер документа\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."is_buy" IS \'Куплен ли заказ?\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."buy_at" IS \'Дата покупки заказа\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."shop_supplier_address_id" IS \'ID адрес поставщика\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."is_load_file" IS \'Создана ли запись при загрузки из файла\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."is_check" IS \'Проверка\';
                COMMENT ON COLUMN "public"."ap_shop_pre_orders"."shop_company_id" IS \'ID компании\';
                
                -- ----------------------------
                -- Indexes structure for table ap_shop_pre_orders
                -- ----------------------------
				CREATE INDEX ap_shop_receive_shop_supplier_id_copy1 ON public.ap_shop_pre_orders USING btree (shop_supplier_id); 
				CREATE INDEX ap_shop_receive_shop_courier_id_copy1 ON public.ap_shop_pre_orders USING btree (shop_courier_id); 
				CREATE INDEX ap_shop_receive_shop_company_id_copy1 ON public.ap_shop_pre_orders USING btree (shop_company_id); 
				CREATE INDEX ap_shop_receive_is_check_copy1 ON public.ap_shop_pre_orders USING btree (is_check); 
				CREATE INDEX ap_shop_receive_is_buy_copy1 ON public.ap_shop_pre_orders USING btree (is_buy); 
				CREATE INDEX ap_shop_receive_index_id_copy1 ON public.ap_shop_pre_orders USING btree (id); 
				CREATE INDEX ap_shop_receive_first_copy1 ON public.ap_shop_pre_orders USING btree (is_delete, language_id, shop_id); 
				CREATE INDEX ap_shop_receive_date_copy1 ON public.ap_shop_pre_orders USING btree (date); 
				CREATE INDEX ap_shop_receive_buy_at_copy1 ON public.ap_shop_pre_orders USING btree (buy_at); 
				CREATE UNIQUE INDEX ap_shop_receives_copy1_pkey ON public.ap_shop_pre_orders USING btree (global_id); 
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
            'title' => 'Дата документа',
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
            'title' => 'Количество товаров',
            'table' => '',
        ),
        'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Номер документа',
            'table' => '',
        ),
        'is_buy' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Куплен ли заказ?',
            'table' => '',
        ),
        'buy_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Дата покупки заказа',
            'table' => '',
        ),
        'shop_supplier_address_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID адрес поставщика',
            'table' => 'DB_AutoPart_Shop_Supplier_Address',
        ),
        'is_load_file' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Создана ли запись при загрузки из файла',
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
        'shop_company_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID компании',
            'table' => 'DB_AutoPart_Shop_Company',
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
