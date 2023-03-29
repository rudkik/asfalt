<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Guest {
    const TABLE_NAME = 'ab_guests';
    const TABLE_ID = 424;
    const NAME = 'DB_Ab1_Guest';
    const TITLE = 'Список гостей';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_guests";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_guests
                -- ----------------------------
                CREATE TABLE "public"."ab_guests" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1,0) NOT NULL DEFAULT 1,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "text" text COLLATE "pg_catalog"."default",
                  "image_path" varchar(100) COLLATE "pg_catalog"."default",
                  "files" text COLLATE "pg_catalog"."default",
                  "options" text COLLATE "pg_catalog"."default",
                  "order" int8 NOT NULL DEFAULT 0,
                  "old_id" varchar(64) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 0,
                  "create_user_id" int8 DEFAULT 0,
                  "update_user_id" int8 NOT NULL,
                  "delete_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_delete" numeric(1,0) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "iin" int8,
                  "passport_number" int8,
                  "company_name" varchar(250) COLLATE "pg_catalog"."default"
                )
                ;
                COMMENT ON COLUMN "public"."ab_guests"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_guests"."name" IS \'ФИО гостя\';
                COMMENT ON COLUMN "public"."ab_guests"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_guests"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_guests"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_guests"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_guests"."old_id" IS \'ID 1c\';
                COMMENT ON COLUMN "public"."ab_guests"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_guests"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_guests"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_guests"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_guests"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_guests"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_guests"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_guests"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_guests"."iin" IS \'ИИН гостя\';
                COMMENT ON COLUMN "public"."ab_guests"."passport_number" IS \'Номер удостоверения\';
                COMMENT ON COLUMN "public"."ab_guests"."company_name" IS \'Назвние компании откуда пришел гость\';
                COMMENT ON TABLE "public"."ab_guests" IS \'Список гостей\';
                
                -- ----------------------------
                -- Indexes structure for table ab_guests
                -- ----------------------------
                CREATE INDEX "ab_guest_first" ON "public"."ab_guests" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_guest_index_id" ON "public"."ab_guests" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
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
        'name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ФИО гостя',
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
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дополнительные файлы',
        ),
        'options' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
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
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID 1c',
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
        'iin' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ИИН гостя',
        ),
        'passport_number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер удостоверения',
        ),
        'company_name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название компании откуда пришел гость',
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
