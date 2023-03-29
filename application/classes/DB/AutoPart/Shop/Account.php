<?php
defined('SYSPATH') or die('No direct script access.');

class DB_AutoPart_Shop_Account {
    const TABLE_NAME = 'ap_shop_accounts';
    const TABLE_ID = '';
    const NAME = 'DB_AutoPart_Shop_Account';
    const TITLE = '';
    const IS_CATALOG = false;


    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ap_shop_accounts";',
            'create' => '
                -- ----------------------------
                -- Table structure for ap_shop_accounts
                -- ----------------------------
                DROP TABLE IF EXISTS "public"."ap_shop_accounts";
                CREATE TABLE "public"."ap_shop_accounts" (
                      
				"id" int8 NOT NULL ,
				"is_public" numeric(1,0) NOT NULL  DEFAULT 1,
				"name" varchar(250) COLLATE "pg_catalog"."default"  ,
				"text" text  ,
				"image_path" varchar(100) COLLATE "pg_catalog"."default"  ,
				"files" text  ,
				"options" text  ,
				"create_user_id" int8   DEFAULT 0,
				"update_user_id" int8 NOT NULL ,
				"delete_user_id" int8   DEFAULT 0,
				"created_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
				"updated_at" timestamp(6) NOT NULL ,
				"deleted_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
				"is_delete" numeric(1,0) NOT NULL  DEFAULT 0,
				"language_id" int8 NOT NULL  DEFAULT 35,
				"global_id" int8 NOT NULL  DEFAULT nextval(\'global_id\'::regclass),
				"password" varchar(150) COLLATE "pg_catalog"."default" NOT NULL ,
				"user_hash" varchar(32) COLLATE "pg_catalog"."default"  ,
				"login" varchar(150) COLLATE "pg_catalog"."default" NOT NULL ,
				"link" varchar(150) COLLATE "pg_catalog"."default"  ,
                );
                ALTER TABLE "public"."ap_shop_accounts" OWNER TO "postgres";
                COMMENT ON COLUMN "public"."ap_shop_accounts"."id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_accounts"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_accounts"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ap_shop_accounts"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ap_shop_accounts"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ap_shop_accounts"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ap_shop_accounts"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ap_shop_accounts"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_accounts"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_accounts"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ap_shop_accounts"."created_at" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_accounts"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ap_shop_accounts"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ap_shop_accounts"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_accounts"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ap_shop_accounts"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ap_shop_accounts"."password" IS \'Пароль пользователя\';
                COMMENT ON COLUMN "public"."ap_shop_accounts"."user_hash" IS \'Для авторизации\';
                COMMENT ON COLUMN "public"."ap_shop_accounts"."login" IS \'Логин\';
                COMMENT ON COLUMN "public"."ap_shop_accounts"."link" IS \'Ссылка\';
                
                -- ----------------------------
                -- Indexes structure for table ap_shop_accounts
                -- ----------------------------
				CREATE UNIQUE INDEX ap_shop_accounts_pkey ON public.ap_shop_accounts USING btree (global_id); 
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
            'type' => DB_FieldType::FIELD_TYPE_FILES,
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
        'password' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 150,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Пароль пользователя',
            'table' => '',
        ),
        'user_hash' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 32,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Для авторизации',
            'table' => '',
        ),
        'login' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 150,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Логин',
            'table' => '',
        ),
        'link' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 150,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Ссылка',
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
