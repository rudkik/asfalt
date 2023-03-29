<?php
defined('SYSPATH') or die('No direct script access.');

class DB_AutoPart_Shop_Courier_Route_Item {
    const TABLE_NAME = 'ap_shop_courier_route_items';
    const TABLE_ID = '';
    const NAME = 'DB_AutoPart_Shop_Courier_Route_Item';
    const TITLE = '';
    const IS_CATALOG = false;


    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ap_shop_courier_route_items";',
            'create' => '
                -- ----------------------------
                -- Table structure for ap_shop_courier_route_items
                -- ----------------------------
                DROP TABLE IF EXISTS "public"."ap_shop_courier_route_items";
                CREATE TABLE "public"."ap_shop_courier_route_items" (
                      
				"id" int8 NOT NULL ,
				"is_public" numeric(1,0) NOT NULL  DEFAULT 1,
				"shop_id" int8 NOT NULL ,
				"name" varchar(250) COLLATE "pg_catalog"."default"  ,
				"text" text  ,
				"image_path" varchar(100) COLLATE "pg_catalog"."default"  ,
				"files" text  ,
				"options" text  ,
				"order" int8 NOT NULL  DEFAULT 0,
				"old_id" varchar(50) COLLATE "pg_catalog"."default"   DEFAULT NULL::character varying,
				"create_user_id" int8   DEFAULT 0,
				"update_user_id" int8 NOT NULL ,
				"delete_user_id" int8   DEFAULT 0,
				"created_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
				"updated_at" timestamp(6) NOT NULL ,
				"deleted_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
				"is_delete" numeric(1,0) NOT NULL  DEFAULT 0,
				"language_id" int8 NOT NULL  DEFAULT 35,
				"global_id" int8 NOT NULL  DEFAULT nextval(\'global_id\'::regclass),
				"shop_courier_id" int8 NOT NULL  DEFAULT 0,
				"seconds" numeric(12,3) NOT NULL  DEFAULT 0,
				"distance" numeric(12,3) NOT NULL  DEFAULT 0,
				"shop_supplier_address_id" int8 NOT NULL  DEFAULT 0,
				"shop_bill_delivery_address_id" int8 NOT NULL  DEFAULT 0,
				"shop_courier_route_id" int8 NOT NULL  DEFAULT 0,
				"shop_bill_id" int8 NOT NULL  DEFAULT 0,
				"shop_supplier_id" int8 NOT NULL  DEFAULT 0,
				"shop_other_address_id" int8 NOT NULL  DEFAULT 0,
				"shop_courier_route_item_id_from" int8 NOT NULL  DEFAULT 0,
				"from_at" timestamp(6)  ,
				"to_at" timestamp(6)  ,
				"is_finish" numeric(1,0) NOT NULL  DEFAULT 0,
				"shop_pre_order_id" int8 NOT NULL  DEFAULT 0,
                );
                ALTER TABLE "public"."ap_shop_courier_route_items" OWNER TO "postgres";
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."order" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."old_id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."created_at" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."shop_courier_id" IS \'ID Курьера\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."seconds" IS \'Количество секунд до точки\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."distance" IS \'Дистанция до точки в км\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."shop_supplier_address_id" IS \'ID адрес поставщика\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."shop_bill_delivery_address_id" IS \'ID точки доставки\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."shop_courier_route_id" IS \'ID маршрут курьера\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."shop_bill_id" IS \'ID заказа\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."shop_supplier_id" IS \'ID поставщика\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."shop_other_address_id" IS \'ID адрес\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."shop_courier_route_item_id_from" IS \'ID точки маршрута откуда произошел выезд\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."from_at" IS \'Время старта\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."to_at" IS \'Время окончания\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."is_finish" IS \'Завершен\';
                COMMENT ON COLUMN "public"."ap_shop_courier_route_items"."shop_pre_order_id" IS \'ID закуп товаров\';
                
                -- ----------------------------
                -- Indexes structure for table ap_shop_courier_route_items
                -- ----------------------------
				CREATE INDEX ap_shop_courier_route_item_shop_supplier_id ON public.ap_shop_courier_route_items USING btree (shop_supplier_id); 
				CREATE INDEX ap_shop_courier_route_item_shop_supplier_address_id ON public.ap_shop_courier_route_items USING btree (shop_supplier_address_id); 
				CREATE INDEX ap_shop_courier_route_item_shop_pre_order_id ON public.ap_shop_courier_route_items USING btree (shop_pre_order_id); 
				CREATE INDEX ap_shop_courier_route_item_shop_courier_route_id ON public.ap_shop_courier_route_items USING btree (shop_courier_route_id); 
				CREATE INDEX ap_shop_courier_route_item_shop_bill_id ON public.ap_shop_courier_route_items USING btree (shop_bill_id); 
				CREATE INDEX ap_shop_courier_route_item_shop_bill_delivery_address_id ON public.ap_shop_courier_route_items USING btree (shop_bill_delivery_address_id); 
				CREATE INDEX ap_shop_courier_route_item_is_finish ON public.ap_shop_courier_route_items USING btree (is_finish); 
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
            'length' => 50,
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
        'shop_courier_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID Курьера',
            'table' => 'DB_AutoPart_Shop_Courier',
        ),
        'seconds' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество секунд до точки',
            'table' => '',
        ),
        'distance' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Дистанция до точки в км',
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
        'shop_bill_delivery_address_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID точки доставки',
            'table' => 'DB_AutoPart_Shop_Bill_Delivery_Address',
        ),
        'shop_courier_route_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID маршрут курьера',
            'table' => 'DB_AutoPart_Shop_Courier_Route',
        ),
        'shop_bill_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID заказа',
            'table' => 'DB_AutoPart_Shop_Bill',
        ),
        'shop_supplier_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID поставщика',
            'table' => 'DB_AutoPart_Shop_Supplier',
        ),
        'shop_other_address_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID адрес',
            'table' => 'DB_AutoPart_Shop_Other_Address',
        ),
        'shop_courier_route_item_id_from' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID точки маршрута откуда произошел выезд',
            'table' => 'DB_AutoPart_Shop_Courier_Route_Item',
        ),
        'from_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Время старта',
            'table' => '',
        ),
        'to_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Время окончания',
            'table' => '',
        ),
        'is_finish' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Завершен',
            'table' => '',
        ),
        'shop_pre_order_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID точки маршрута откуда произошел выезд',
            'table' => 'DB_AutoPart_Shop_PreOrder',
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
