<?php defined('SYSPATH') or die('No direct script access.');

class DB_Shop_Calendar {
    const TABLE_NAME = 'ct_shop_calendars';
    const TABLE_ID = 61;
    const NAME = 'DB_Shop_Calendar';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_shop_calendars";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_shop_calendars
                -- ----------------------------
                CREATE TABLE "public"."ct_shop_calendars" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "shop_table_catalog_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_rubric_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_select_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_brand_id" int8 NOT NULL DEFAULT 0,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "article" varchar(100) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "text" text COLLATE "pg_catalog"."default",
                  "image_path" varchar(100) COLLATE "pg_catalog"."default",
                  "files" text COLLATE "pg_catalog"."default",
                  "options" text COLLATE "pg_catalog"."default",
                  "seo" text COLLATE "pg_catalog"."default",
                  "remarketing" text COLLATE "pg_catalog"."default",
                  "collations" text COLLATE "pg_catalog"."default",
                  "order" int8 NOT NULL DEFAULT 0,
                  "is_group" numeric(1) NOT NULL DEFAULT 0,
                  "old_id" int8 NOT NULL DEFAULT 0,
                  "create_user_id" int8 DEFAULT 0,
                  "update_user_id" int8 NOT NULL,
                  "delete_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "shop_table_object_ids" text COLLATE "pg_catalog"."default",
                  "download_file_path" varchar(150) COLLATE "pg_catalog"."default",
                  "download_file_name" varchar(150) COLLATE "pg_catalog"."default",
                  "shop_table_unit_id" int8 NOT NULL DEFAULT 0,
                  "date_from" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "date_to" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "time_from" time(6) DEFAULT NULL::timestamp without time zone,
                  "time_to" time(6) DEFAULT NULL::timestamp without time zone,
                  "calendar_event_type_id" int8 NOT NULL DEFAULT 150,
                  "time_options" text COLLATE "pg_catalog"."default" NOT NULL DEFAULT 150
                )
                ;
                COMMENT ON COLUMN "public"."ct_shop_calendars"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."shop_table_catalog_id" IS \'Тип товара\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."shop_table_rubric_id" IS \'ID рубрики\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."shop_table_select_id" IS \'Тип выделения \';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."shop_table_brand_id" IS \'ID бренда \';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."article" IS \'Артикул у товара\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."seo" IS \'JSON массива настройки SEO\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."remarketing" IS \'Код ремаркетинга\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."collations" IS \'JSON список значений для сопоставления\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."is_group" IS \'Является ли это группа товаров\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."shop_table_object_ids" IS \'JSON данные списком\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."download_file_path" IS \'Путь до файла скачивания\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."download_file_name" IS \'Название файла для скачивания\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."shop_table_unit_id" IS \'Тип единицы измерения\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."date_from" IS \'Дата начала события\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."date_to" IS \'Дата заверешния события\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."time_from" IS \'Время начала события\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."time_to" IS \'Время заверешния события\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."calendar_event_type_id" IS \'ID частота повторения события календаря\';
                COMMENT ON COLUMN "public"."ct_shop_calendars"."time_options" IS \'JSON настройки события календаря Настройки времени показа и период повторений\';
                
                -- ----------------------------
                -- Indexes structure for table ct_shop_calendars
                -- ----------------------------
                CREATE INDEX "shop_calendar_date_from" ON "public"."ct_shop_calendars" USING btree (
                  "date_from" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_calendar_date_to" ON "public"."ct_shop_calendars" USING btree (
                  "date_to" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_calendar_first" ON "public"."ct_shop_calendars" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_table_catalog_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_calendar_index_id" ON "public"."ct_shop_calendars" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_calendar_index_order" ON "public"."ct_shop_calendars" USING btree (
                  "order" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_calendar_is_group" ON "public"."ct_shop_calendars" USING btree (
                  "is_group" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_calendar_name_like" ON "public"."ct_shop_calendars" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_calendar_old_id" ON "public"."ct_shop_calendars" USING btree (
                  "old_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_calendar_shop_table_brand_id" ON "public"."ct_shop_calendars" USING btree (
                  "shop_table_brand_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_calendar_shop_table_rubric_id" ON "public"."ct_shop_calendars" USING btree (
                  "shop_table_rubric_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_calendar_shop_table_select_type_id" ON "public"."ct_shop_calendars" USING btree (
                  "shop_table_select_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ct_shop_calendars
                -- ----------------------------
                ALTER TABLE "public"."ct_shop_calendars" ADD CONSTRAINT "ct_shop_files_copy1_pkey" PRIMARY KEY ("global_id");
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
            'title' => 'Тип товара',
            'table' => 'DB_Shop_Table_Catalog',
        ),
        'shop_table_rubric_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID рубрики',
            'table' => 'DB_Shop_Table_Rubric',
        ),
        'shop_table_select_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип выделения ',
            'table' => 'DB_Shop_Table_Select',
        ),
        'shop_table_brand_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID бренда ',
            'table' => 'DB_Shop_Table_Brand',
        ),
        'name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название',
        ),
        'article' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 100,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Артикул у товара',
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
        'seo' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON массива настройки SEO',
        ),
        'remarketing' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Код ремаркетинга',
        ),
        'collations' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON список значений для сопоставления',
        ),
        'order' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
        ),
        'is_group' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Является ли это группа товаров',
        ),
        'old_id' => array(
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
        'shop_table_object_ids' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON данные списком',
        ),
        'download_file_path' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 150,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Путь до файла скачивания',
        ),
        'download_file_name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 150,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название файла для скачивания',
        ),
        'shop_table_unit_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип единицы измерения',
            'table' => 'DB_Shop_Table_Unit',
        ),
        'date_from' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата начала события',
        ),
        'date_to' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата заверешния события',
        ),
        'time_from' => array(
            'type' => DB_FieldType::FIELD_TYPE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Время начала события',
        ),
        'time_to' => array(
            'type' => DB_FieldType::FIELD_TYPE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Время заверешния события',
        ),
        'calendar_event_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID частота повторения события календаря',
            'table' => 'DB_CalendarEventType',
        ),
        'time_options' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'JSON настройки события календаря Настройки времени показа и период повторений',
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
