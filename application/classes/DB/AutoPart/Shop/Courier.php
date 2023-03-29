<?php
defined('SYSPATH') or die('No direct script access.');

class DB_AutoPart_Shop_Courier {
    const TABLE_NAME = 'ap_shop_couriers';
    const TABLE_ID = '';
    const NAME = 'DB_AutoPart_Shop_Courier';
    const TITLE = '';
    const IS_CATALOG = false;


    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ap_shop_couriers";',
            'create' => '
                -- ----------------------------
                -- Table structure for ap_shop_couriers
                -- ----------------------------
                DROP TABLE IF EXISTS "public"."ap_shop_couriers";
                CREATE TABLE "public"."ap_shop_couriers" (
                      
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
                );
                ALTER TABLE "public"."ap_shop_couriers" OWNER TO "postgres";
                COMMENT ON COLUMN "public"."ap_shop_couriers"."id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_couriers"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_couriers"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ap_shop_couriers"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ap_shop_couriers"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ap_shop_couriers"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ap_shop_couriers"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ap_shop_couriers"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ap_shop_couriers"."order" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_couriers"."old_id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_couriers"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_couriers"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_couriers"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ap_shop_couriers"."created_at" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_couriers"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ap_shop_couriers"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ap_shop_couriers"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_couriers"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ap_shop_couriers"."global_id" IS \'Глобальный ID\';
                
                -- ----------------------------
                -- Indexes structure for table ap_shop_couriers
                -- ----------------------------
				CREATE INDEX ap_shop_courier_index_id ON ap_shop_couriers USING btree (id); 
				CREATE INDEX ap_shop_courier_first ON ap_shop_couriers USING btree (is_delete, language_id, shop_id, is_public); 
				CREATE UNIQUE INDEX ap_shop_marks_copy1_pkey ON ap_shop_couriers USING btree (global_id); 
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
        'iin' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ИИН',
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
