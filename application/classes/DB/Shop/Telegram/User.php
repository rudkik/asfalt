<?php defined('SYSPATH') or die('No direct script access.');

class DB_Shop_Telegram_User {
    const TABLE_NAME = 'ct_shop_telegram_users';
    const TABLE_ID = 61;
    const NAME = 'DB_Shop_Telegram_User';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_shop_telegram_users";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_shop_telegram_users
                -- ----------------------------
                CREATE TABLE "public"."ct_shop_telegram_users" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "shop_table_catalog_id" int8 NOT NULL DEFAULT 0,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "text" text COLLATE "pg_catalog"."default",
                  "image_path" varchar(255) COLLATE "pg_catalog"."default",
                  "files" text COLLATE "pg_catalog"."default",
                  "options" text COLLATE "pg_catalog"."default",
                  "order" int8 NOT NULL DEFAULT 0,
                  "old_id" varchar(50) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "create_user_id" int8 DEFAULT 0,
                  "update_user_id" int8 NOT NULL,
                  "delete_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "telegram_chat_id" varchar(100) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "telegram_language_id" int8 NOT NULL DEFAULT 35,
                  "telegram_last_command" varchar(100) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "telegram_is_operation" numeric(1) NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ct_shop_telegram_users"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_telegram_users"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ct_shop_telegram_users"."shop_table_catalog_id" IS \'Тип объекта\';
                COMMENT ON COLUMN "public"."ct_shop_telegram_users"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ct_shop_telegram_users"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ct_shop_telegram_users"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ct_shop_telegram_users"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ct_shop_telegram_users"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ct_shop_telegram_users"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_telegram_users"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_telegram_users"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_shop_telegram_users"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ct_shop_telegram_users"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_shop_telegram_users"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_telegram_users"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ct_shop_telegram_users"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_shop_telegram_users"."telegram_chat_id" IS \'ID телеграм чата\';
                COMMENT ON COLUMN "public"."ct_shop_telegram_users"."telegram_language_id" IS \'ID телеграмм языка\';
                COMMENT ON COLUMN "public"."ct_shop_telegram_users"."telegram_last_command" IS \'Последняя команда телеграм чата\';
                COMMENT ON COLUMN "public"."ct_shop_telegram_users"."telegram_is_operation" IS \'Оператор телеграм бота\';
                
                -- ----------------------------
                -- Indexes structure for table ct_shop_telegram_users
                -- ----------------------------
                CREATE INDEX "shop_telegram_user_first" ON "public"."ct_shop_telegram_users" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_table_catalog_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_telegram_user_full_name" ON "public"."ct_shop_telegram_users" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name::text), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "shop_telegram_user_full_text" ON "public"."ct_shop_telegram_users" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, text), \'B\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "shop_telegram_user_index_id" ON "public"."ct_shop_telegram_users" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_telegram_user_index_order" ON "public"."ct_shop_telegram_users" USING btree (
                  "order" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_telegram_user_name_like" ON "public"."ct_shop_telegram_users" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_telegram_user_old_id" ON "public"."ct_shop_telegram_users" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_telegram_user_telegram_chat_id" ON "public"."ct_shop_telegram_users" USING btree (
                  "telegram_chat_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ct_shop_telegram_users
                -- ----------------------------
                ALTER TABLE "public"."ct_shop_telegram_users" ADD CONSTRAINT "ct_shop_goods_copy1_pkey2" PRIMARY KEY ("global_id");
                ',
            'data' => '',
        ),
    );

    const FIELDS = array(
        'id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
        ),
        'is_public' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Опубликована ли запись',
        ),
        'shop_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID магазина',
            'table' => 'DB_Shop',
        ),
        'shop_table_catalog_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип объекта',
            'table' => 'DB_Shop_Table_Catalog',
        ),
        'name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название',
        ),
        'text' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Описание ',
        ),
        'image_path' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 255,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Картинка',
        ),
        'files' => array(
            'type' => DB_FieldType::FIELD_TYPE_FILES,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дополнительные файлы',
        ),
        'options' => array(
            'type' => DB_FieldType::FIELD_TYPE_JSON,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дополнительные поля',
        ),
        'order' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
        ),
        'old_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => '',
        ),
        'create_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Кто отредактировал эту запись',
            'table' => 'DB_User',
        ),
        'update_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Кто отредактировал эту запись',
            'table' => 'DB_User',
        ),
        'delete_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Кто удалил запись',
            'table' => 'DB_User',
        ),
        'created_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => '',
        ),
        'updated_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Дата обновления записи',
        ),
        'deleted_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата удаления записи',
        ),
        'is_delete' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Удалена ли запись',
        ),
        'language_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID языка',
            'table' => 'DB_Language',
        ),
        'global_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Глобальный ID',
        ),
        'telegram_chat_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 100,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID телеграм чата',
        ),
        'telegram_language_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID телеграмм языка',
            'table' => 'DB_Language',
        ),
        'telegram_last_command' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 100,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Последняя команда телеграм чата',
        ),
        'telegram_is_operation' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Оператор телеграм бота',
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
