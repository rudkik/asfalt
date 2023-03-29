<?php
defined('SYSPATH') or die('No direct script access.');

class DB_AutoPart_Shop_Supplier_Parser {
    const TABLE_NAME = 'ap_shop_supplier_parsers';
    const TABLE_ID = '';
    const NAME = 'DB_AutoPart_Shop_Supplier_Parser';
    const TITLE = '';
    const IS_CATALOG = false;


    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ap_shop_supplier_parsers";',
            'create' => '
                -- ----------------------------
                -- Table structure for ap_shop_supplier_parsers
                -- ----------------------------
                DROP TABLE IF EXISTS "public"."ap_shop_supplier_parsers";
                CREATE TABLE "public"."ap_shop_supplier_parsers" (
                      
				"id" int8 NOT NULL ,
				"is_public" numeric(1,0) NOT NULL  DEFAULT 1,
				"shop_id" int8 NOT NULL ,
				"name" varchar(250) COLLATE "pg_catalog"."default"  ,
				"text" text  ,
				"options" text  ,
				"image_path" varchar(255) COLLATE "pg_catalog"."default"   DEFAULT NULL::character varying,
				"files" text  ,
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
				"step" int8 NOT NULL  DEFAULT 0,
                );
                ALTER TABLE "public"."ap_shop_supplier_parsers" OWNER TO "postgres";
                COMMENT ON COLUMN "public"."ap_shop_supplier_parsers"."id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_supplier_parsers"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_supplier_parsers"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ap_shop_supplier_parsers"."name" IS \'Название каталога\';
                COMMENT ON COLUMN "public"."ap_shop_supplier_parsers"."text" IS \'Описание каталога (HTML-код)\';
                COMMENT ON COLUMN "public"."ap_shop_supplier_parsers"."options" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_supplier_parsers"."image_path" IS \'Путь к изображению рубрики\';
                COMMENT ON COLUMN "public"."ap_shop_supplier_parsers"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ap_shop_supplier_parsers"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_supplier_parsers"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_supplier_parsers"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ap_shop_supplier_parsers"."created_at" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_supplier_parsers"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ap_shop_supplier_parsers"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ap_shop_supplier_parsers"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_supplier_parsers"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ap_shop_supplier_parsers"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ap_shop_supplier_parsers"."shop_supplier_id" IS \'ID Поставщика\';
                COMMENT ON COLUMN "public"."ap_shop_supplier_parsers"."step" IS \'Шаг\';
                
                -- ----------------------------
                -- Indexes structure for table ap_shop_supplier_parsers
                -- ----------------------------
				CREATE INDEX ap_shop_supplier_parser_index_order ON public.ap_shop_supplier_parsers USING btree (step); 
				CREATE INDEX ap_shop_supplier_parser_index_id ON public.ap_shop_supplier_parsers USING btree (id); 
				CREATE INDEX ap_shop_supplier_parser_first ON public.ap_shop_supplier_parsers USING btree (is_delete, language_id, shop_id, is_public); 
				CREATE INDEX ap_shop_supplier_parser_shop_supplier_id ON public.ap_shop_supplier_parsers USING btree (shop_supplier_id); 
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
            'title' => 'Название каталога',
            'table' => '',
        ),
        'text' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Описание каталога (HTML-код)',
            'table' => '',
        ),
        'options' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => '',
        ),
        'image_path' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 255,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Путь к изображению рубрики',
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
            'title' => 'ID Поставщика',
            'table' => 'DB_AutoPart_Shop_Supplier',
        ),
        'step' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Шаг',
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
