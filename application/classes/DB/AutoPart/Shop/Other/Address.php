<?php
defined('SYSPATH') or die('No direct script access.');

class DB_AutoPart_Shop_Other_Address {
    const TABLE_NAME = 'ap_shop_other_addresses';
    const TABLE_ID = '';
    const NAME = 'DB_AutoPart_Shop_Other_Address';
    const TITLE = '';
    const IS_CATALOG = false;


    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ap_shop_other_addresses";',
            'create' => '
                -- ----------------------------
                -- Table structure for ap_shop_other_addresses
                -- ----------------------------
                DROP TABLE IF EXISTS "public"."ap_shop_other_addresses";
                CREATE TABLE "public"."ap_shop_other_addresses" (
                      
				"id" int8 NOT NULL ,
				"is_public" numeric(1,0) NOT NULL  DEFAULT 1,
				"shop_id" int8 NOT NULL ,
				"name" varchar(250) COLLATE "pg_catalog"."default"  ,
				"text" text  ,
				"image_path" varchar(100) COLLATE "pg_catalog"."default"  ,
				"files" text  ,
				"options" text  ,
				"seo" text  ,
				"order" int8 NOT NULL  DEFAULT 0,
				"old_id" varchar(50) COLLATE "pg_catalog"."default"   DEFAULT NULL::character varying,
				"create_user_id" int8   DEFAULT 0,
				"update_user_id" int8  ,
				"delete_user_id" int8   DEFAULT 0,
				"created_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
				"updated_at" timestamp(6) NOT NULL ,
				"deleted_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
				"is_delete" numeric(1,0) NOT NULL  DEFAULT 0,
				"language_id" int8 NOT NULL  DEFAULT 35,
				"global_id" int8 NOT NULL  DEFAULT nextval(\'global_id\'::regclass),
				"street" varchar(250) COLLATE "pg_catalog"."default"  ,
				"house" varchar(250) COLLATE "pg_catalog"."default"  ,
				"apartment" varchar(250) COLLATE "pg_catalog"."default"  ,
				"city_name" varchar(250) COLLATE "pg_catalog"."default"  ,
				"city_id" int8 NOT NULL  DEFAULT nextval(\'global_id\'::regclass),
				"latitude" numeric(12,6)  ,
				"longitude" numeric(12,6)  ,
                );
                ALTER TABLE "public"."ap_shop_other_addresses" OWNER TO "postgres";
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."seo" IS \'JSON массива настройки SEO\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."order" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."old_id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."created_at" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."street" IS \'Улица\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."house" IS \'Дом\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."apartment" IS \'Квартира\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."city_name" IS \'Город\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."city_id" IS \'ID города\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."latitude" IS \'Широта\';
                COMMENT ON COLUMN "public"."ap_shop_other_addresses"."longitude" IS \'Длина\';
                
                -- ----------------------------
                -- Indexes structure for table ap_shop_other_addresses
                -- ----------------------------
				CREATE INDEX ap_shop_other_address_index_id ON public.ap_shop_other_addresses USING btree (id); 
				CREATE INDEX ap_shop_other_address_first ON public.ap_shop_other_addresses USING btree (is_delete, language_id, shop_id, is_public); 
				CREATE UNIQUE INDEX ap_shop_courier_addresses_copy1_pkey ON public.ap_shop_other_addresses USING btree (global_id); 
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
        'seo' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'JSON массива настройки SEO',
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
        'street' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Улица',
            'table' => '',
        ),
        'house' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Дом',
            'table' => '',
        ),
        'apartment' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Квартира',
            'table' => '',
        ),
        'city_name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Город',
            'table' => '',
        ),
        'city_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID города',
            'table' => 'DB_City',
        ),
        'latitude' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 6,
            'is_not_null' => true,
            'title' => 'Широта',
            'table' => '',
        ),
        'longitude' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 6,
            'is_not_null' => true,
            'title' => 'Длина',
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
