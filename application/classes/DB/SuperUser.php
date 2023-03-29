<?php defined('SYSPATH') or die('No direct script access.');

class DB_SuperUser {
    const TABLE_NAME = 'ct_super_users';
    const TABLE_ID = 61;
    const NAME = 'DB_SuperUser';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_super_users";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_super_users
                -- ----------------------------
                CREATE TABLE "public"."ct_super_users" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "user_id" int8 NOT NULL DEFAULT 0,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "text" text COLLATE "pg_catalog"."default",
                  "image_path" varchar(100) COLLATE "pg_catalog"."default",
                  "files" text COLLATE "pg_catalog"."default",
                  "options" text COLLATE "pg_catalog"."default",
                  "order" int8 NOT NULL DEFAULT 0,
                  "create_user_id" int8 DEFAULT 0,
                  "update_user_id" int8 NOT NULL,
                  "delete_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "password" varchar(150) COLLATE "pg_catalog"."default" NOT NULL,
                  "user_hash" varchar(32) COLLATE "pg_catalog"."default",
                  "email" varchar(150) COLLATE "pg_catalog"."default" NOT NULL,
                  "access" text COLLATE "pg_catalog"."default"
                )
                ;
                COMMENT ON COLUMN "public"."ct_super_users"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ct_super_users"."user_id" IS \'ID пользователя\';
                COMMENT ON COLUMN "public"."ct_super_users"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ct_super_users"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ct_super_users"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ct_super_users"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ct_super_users"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ct_super_users"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_super_users"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_super_users"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_super_users"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ct_super_users"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_super_users"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_super_users"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ct_super_users"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_super_users"."password" IS \'Пароль пользователя\';
                COMMENT ON COLUMN "public"."ct_super_users"."user_hash" IS \'Для авторизации\';
                COMMENT ON COLUMN "public"."ct_super_users"."email" IS \'E-mail пользователя\';
                COMMENT ON COLUMN "public"."ct_super_users"."access" IS \'JSON доступ\';
                COMMENT ON TABLE "public"."ct_super_users" IS \'Таблица операторов магазина\';
                
                -- ----------------------------
                -- Indexes structure for table ct_super_users
                -- ----------------------------
                CREATE INDEX "super_user_email" ON "public"."ct_super_users" USING btree (
                  "email" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "super_user_first" ON "public"."ct_super_users" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "super_user_index_id" ON "public"."ct_super_users" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "super_user_name_like" ON "public"."ct_super_users" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "super_user_password" ON "public"."ct_super_users" USING btree (
                  "password" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "super_user_user_hash" ON "public"."ct_super_users" USING btree (
                  "user_hash" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "super_user_user_id" ON "public"."ct_super_users" USING btree (
                  "user_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ct_super_users
                -- ----------------------------
                ALTER TABLE "public"."ct_super_users" ADD CONSTRAINT "ct_super_users_pkey" PRIMARY KEY ("global_id");
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
        'user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID пользователя',
            'table' => 'DB_User',
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
            'length' => 100,
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
        'password' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 150,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Пароль пользователя',
        ),
        'user_hash' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 32,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Для авторизации',
        ),
        'email' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 150,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'E-mail пользователя',
        ),
        'access' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON доступ',
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
