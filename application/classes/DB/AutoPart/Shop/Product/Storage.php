<?php
defined('SYSPATH') or die('No direct script access.');

class DB_AutoPart_Shop_Product_Storage {
    const TABLE_NAME = 'ap_shop_product_storages';
    const TABLE_ID = '';
    const NAME = 'DB_AutoPart_Shop_Product_Storage';
    const TITLE = '';
    const IS_CATALOG = false;


    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ap_shop_product_storages";',
            'create' => '
                -- ----------------------------
                -- Table structure for ap_shop_product_storages
                -- ----------------------------
                DROP TABLE IF EXISTS "public"."ap_shop_product_storages";
                CREATE TABLE "public"."ap_shop_product_storages" (
                      
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
				"shop_supplier_id" int8 NOT NULL  DEFAULT 0,
				"shop_other_address_id" int8 NOT NULL  DEFAULT 0,
                );
                ALTER TABLE "public"."ap_shop_product_storages" OWNER TO "postgres";
                COMMENT ON COLUMN "public"."ap_shop_product_storages"."id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_product_storages"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_product_storages"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ap_shop_product_storages"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ap_shop_product_storages"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ap_shop_product_storages"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ap_shop_product_storages"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ap_shop_product_storages"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ap_shop_product_storages"."order" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_product_storages"."old_id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_product_storages"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_product_storages"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_product_storages"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ap_shop_product_storages"."created_at" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_product_storages"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ap_shop_product_storages"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ap_shop_product_storages"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_product_storages"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ap_shop_product_storages"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ap_shop_product_storages"."shop_supplier_id" IS \'ID поставщика\';
                COMMENT ON COLUMN "public"."ap_shop_product_storages"."shop_other_address_id" IS \'ID Другой адрес\';
                
                -- ----------------------------
                -- Indexes structure for table ap_shop_product_storages
                -- ----------------------------
				CREATE INDEX ap_shop_product_storage_shop_other_address_id ON public.ap_shop_product_storages USING btree (shop_other_address_id); 
				CREATE INDEX ap_shop_product_storage_shop_supplier_id ON public.ap_shop_product_storages USING btree (shop_supplier_id); 
				CREATE INDEX ap_shop_product_storage_index_id ON public.ap_shop_product_storages USING btree (id); 
				CREATE INDEX ap_shop_product_storage_first ON public.ap_shop_product_storages USING btree (is_delete, language_id, shop_id, is_public); 
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
            'title' => 'ID Другой адрес',
            'table' => 'DB_AutoPart_Shop_Other_Address',
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
