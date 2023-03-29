<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Holiday {
    const TABLE_NAME = 'ab_holidays';
    const TABLE_ID = 344;
    const NAME = 'DB_Ab1_Holiday';
    const TITLE = 'Праздничные и выходные дни';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_holidays";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_holidays
                -- ----------------------------
                CREATE TABLE "public"."ab_holidays" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
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
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "year" int2 NOT NULL DEFAULT 0,
                  "day" date,
                  "is_free" numeric(1) NOT NULL DEFAULT 1,
                  "holiday_year_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_holidays"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_holidays"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_holidays"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_holidays"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_holidays"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_holidays"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_holidays"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_holidays"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_holidays"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_holidays"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_holidays"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_holidays"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_holidays"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_holidays"."year" IS \'Год\';
                COMMENT ON COLUMN "public"."ab_holidays"."day" IS \'Праздничный / выходной день \';
                COMMENT ON COLUMN "public"."ab_holidays"."is_free" IS \'Выходной ли день?\';
                COMMENT ON COLUMN "public"."ab_holidays"."holiday_year_id" IS \'ID года праздников / выходных дней\';
                COMMENT ON TABLE "public"."ab_holidays" IS \'Список праздничных и выходных дней\';
                
                -- ----------------------------
                -- Indexes structure for table ab_holidays
                -- ----------------------------
                CREATE INDEX "ab_holiday_day" ON "public"."ab_holidays" USING btree (
                  "day" "pg_catalog"."date_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_holiday_first" ON "public"."ab_holidays" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_holiday_full_name" ON "public"."ab_holidays" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name::text), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "ab_holiday_index_id" ON "public"."ab_holidays" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_holiday_is_free" ON "public"."ab_holidays" USING btree (
                  "is_free" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_holiday_name_like" ON "public"."ab_holidays" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_holiday_old_id" ON "public"."ab_holidays" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_holiday_year" ON "public"."ab_holidays" USING btree (
                  "year" "pg_catalog"."int2_ops" ASC NULLS LAST
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
            'title' => '',
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
        'old_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
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
        'year' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 16,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Год',
        ),
        'day' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Праздничный / выходной день в формате Год-месяц-день',
        ),
        'is_free' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Выходной ли день?',
        ),
        'holiday_year_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID года праздников / выходных дней',
            'table' => 'DB_Ab1_HolidayYear',
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
