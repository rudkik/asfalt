<?php
defined('SYSPATH') or die('No direct script access.');

class DB_AutoPart_Shop_Product_Join {
    const TABLE_NAME = 'ap_shop_product_joins';
    const TABLE_ID = '';
    const NAME = 'DB_AutoPart_Shop_Product_Join';
    const TITLE = '';
    const IS_CATALOG = false;


    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ap_shop_product_joins";',
            'create' => '
                -- ----------------------------
                -- Table structure for ap_shop_product_joins
                -- ----------------------------
                DROP TABLE IF EXISTS "public"."ap_shop_product_joins";
                CREATE TABLE "public"."ap_shop_product_joins" (
                      
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
				"shop_source_id" int8 NOT NULL  DEFAULT 0,
				"quantity" int2 NOT NULL  DEFAULT 0,
				"shop_operation_id" int8 NOT NULL  DEFAULT 0,
				"date" date NOT NULL ,
				"shop_product_id" int8 NOT NULL  DEFAULT 0,
                );
                ALTER TABLE "public"."ap_shop_product_joins" OWNER TO "postgres";
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."order" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."old_id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."created_at" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."shop_source_id" IS \'ID источника интеграции\';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."quantity" IS \'Количество распознано\';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."shop_operation_id" IS \'ID оператора\';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."date" IS \'Дата распознания\';
                COMMENT ON COLUMN "public"."ap_shop_product_joins"."shop_product_id" IS \'ID последнего распознанного товара\';
                
                -- ----------------------------
                -- Indexes structure for table ap_shop_product_joins
                -- ----------------------------
				CREATE INDEX ap_shop_product_join_date ON ap_shop_product_joins USING btree (date); 
				CREATE INDEX ap_shop_product_join_shop_operation_id ON ap_shop_product_joins USING btree (shop_operation_id); 
				CREATE INDEX ap_shop_product_join_shop_source_id ON ap_shop_product_joins USING btree (shop_source_id); 
				CREATE INDEX ap_shop_product_join_index_id ON ap_shop_product_joins USING btree (id); 
				CREATE INDEX ap_shop_product_join_first ON ap_shop_product_joins USING btree (is_delete, language_id, shop_id, is_public); 
				CREATE UNIQUE INDEX ap_shop_product_sources_copy1_pkey1 ON ap_shop_product_joins USING btree (global_id); 
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
        'shop_source_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID источника интеграции',
            'table' => 'DB_AutoPart_Shop_Source',
        ),
        'quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 16,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Количество распознано',
            'table' => '',
        ),
        'shop_operation_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID оператора',
            'table' => 'DB_Shop_Operation',
        ),
        'date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Дата распознания',
            'table' => '',
        ),
        'shop_product_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID последнего распознанного товара',
            'table' => 'DB_AutoPart_Shop_Product',
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
