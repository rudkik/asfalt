<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_ClientContract_Contact_Type {
    const TABLE_NAME = 'ab_client_contract_contact_types';
    const TABLE_ID = '';
    const NAME = 'DB_Ab1_ClientContract_Contact_Type';
    const TITLE = '';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_client_contract_contact_types";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_client_contract_contact_types
                -- ----------------------------
                DROP TABLE IF EXISTS "public"."ab_client_contract_contact_types";
                CREATE TABLE "public"."ab_client_contract_contact_types" (
                      
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
				"format" varchar(255) COLLATE "pg_catalog"."default"  ,
                );
                ALTER TABLE "public"."ab_client_contract_contact_types" OWNER TO "postgres";
                COMMENT ON COLUMN "public"."ab_client_contract_contact_types"."id" IS \'\';
                COMMENT ON COLUMN "public"."ab_client_contract_contact_types"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_client_contract_contact_types"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_client_contract_contact_types"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ab_client_contract_contact_types"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_client_contract_contact_types"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_client_contract_contact_types"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_client_contract_contact_types"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_client_contract_contact_types"."order" IS \'\';
                COMMENT ON COLUMN "public"."ab_client_contract_contact_types"."old_id" IS \'\';
                COMMENT ON COLUMN "public"."ab_client_contract_contact_types"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_client_contract_contact_types"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_client_contract_contact_types"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_client_contract_contact_types"."created_at" IS \'\';
                COMMENT ON COLUMN "public"."ab_client_contract_contact_types"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_client_contract_contact_types"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_client_contract_contact_types"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_client_contract_contact_types"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_client_contract_contact_types"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_client_contract_contact_types"."format" IS \'формата контакта\';
                
                -- ----------------------------
                -- Indexes structure for table ab_client_contract_contact_types
                -- ----------------------------
				CREATE INDEX ab_client_contract_contact_type_index_id ON public.ab_client_contract_contact_types USING btree (id); 
				CREATE INDEX ab_client_contract_contact_type_first ON public.ab_client_contract_contact_types USING btree (is_delete, language_id, shop_id, is_public); 
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
            'table' => 'DB_Ab1_Shop',
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
        'format' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 255,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'формата контакта',
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
