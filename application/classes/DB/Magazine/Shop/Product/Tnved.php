<?php
defined('SYSPATH') or die('No direct script access.');

class DB_Magazine_Shop_Product_TNVED {
    const TABLE_NAME = 'sp_shop_product_tnveds';
    const TABLE_ID = '';
    const NAME = 'DB_Magazine_Shop_Product_TNVED';
    const TITLE = '';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."sp_shop_product_tnveds";',
            'create' => '
                -- ----------------------------
                -- Table structure for sp_shop_product_tnveds
                -- ----------------------------
                DROP TABLE IF EXISTS "public"."sp_shop_product_tnveds";
                CREATE TABLE "public"."sp_shop_product_tnveds" (
                      
				"id" int8 NOT NULL ,
				"is_public" numeric(1,0) NOT NULL  DEFAULT 1,
				"shop_id" int8 NOT NULL  DEFAULT 0,
				"name" text  ,
				"text" text  ,
				"image_path" varchar(100) COLLATE "pg_catalog"."default"  ,
				"files" text  ,
				"options" text  ,
				"order" int8 NOT NULL  DEFAULT 0,
				"old_id" varchar(64) COLLATE "pg_catalog"."default" NOT NULL  DEFAULT 0,
				"create_user_id" int8   DEFAULT 0,
				"update_user_id" int8 NOT NULL  DEFAULT 0,
				"delete_user_id" int8   DEFAULT 0,
				"created_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
				"updated_at" timestamp(6) NOT NULL ,
				"deleted_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
				"is_delete" numeric(1,0) NOT NULL  DEFAULT 0,
				"language_id" int8 NOT NULL  DEFAULT 35,
				"global_id" int8 NOT NULL  DEFAULT nextval(\'global_id\'::regclass),
				"tnved" varchar(25) COLLATE "pg_catalog"."default"  ,
				"kpved" varchar(25) COLLATE "pg_catalog"."default"  ,
                );
                ALTER TABLE "public"."sp_shop_product_tnveds" OWNER TO "postgres";
                COMMENT ON COLUMN "public"."sp_shop_product_tnveds"."id" IS \'\';
                COMMENT ON COLUMN "public"."sp_shop_product_tnveds"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."sp_shop_product_tnveds"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."sp_shop_product_tnveds"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."sp_shop_product_tnveds"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."sp_shop_product_tnveds"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."sp_shop_product_tnveds"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."sp_shop_product_tnveds"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."sp_shop_product_tnveds"."order" IS \'\';
                COMMENT ON COLUMN "public"."sp_shop_product_tnveds"."old_id" IS \'\';
                COMMENT ON COLUMN "public"."sp_shop_product_tnveds"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sp_shop_product_tnveds"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sp_shop_product_tnveds"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."sp_shop_product_tnveds"."created_at" IS \'\';
                COMMENT ON COLUMN "public"."sp_shop_product_tnveds"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."sp_shop_product_tnveds"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."sp_shop_product_tnveds"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."sp_shop_product_tnveds"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."sp_shop_product_tnveds"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."sp_shop_product_tnveds"."tnved" IS \'ТНВЭД\';
                COMMENT ON COLUMN "public"."sp_shop_product_tnveds"."kpved" IS \'КПВЭД\';
                
                -- ----------------------------
                -- Indexes structure for table sp_shop_product_tnveds
                -- ----------------------------
				CREATE INDEX sp_shop_product_tnved_tnved ON sp_shop_product_tnveds USING btree (tnved); 
				CREATE INDEX sp_shop_product_tnved_kpved ON sp_shop_product_tnveds USING btree (kpved); 
				CREATE INDEX sp_shop_product_tnved_index_id ON sp_shop_product_tnveds USING btree (id); 
				CREATE INDEX sp_shop_product_tnved_first ON sp_shop_product_tnveds USING btree (is_delete, language_id, shop_id, is_public); 
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
            'length' => 0,
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
        'tnved' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 25,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ТНВЭД',
            'table' => '',
        ),
        'kpved' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 25,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'КПВЭД',
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
