<?php defined('SYSPATH') or die('No direct script access.');

class DB_CalendarEventType {
    const TABLE_NAME = 'ct_calendar_event_types';
    const TABLE_ID = 61;
    const NAME = 'DB_CalendarEventType';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_calendar_event_types";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_calendar_event_types
                -- ----------------------------
                CREATE TABLE "public"."ct_calendar_event_types" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "name" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
                  "update_user_id" int8 NOT NULL,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6),
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "delete_user_id" int8 DEFAULT 0,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "fields_options" text COLLATE "pg_catalog"."default",
                  "language_id" int8 NOT NULL DEFAULT 35
                )
                ;
                COMMENT ON COLUMN "public"."ct_calendar_event_types"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ct_calendar_event_types"."name" IS \'Название типа карты\';
                COMMENT ON COLUMN "public"."ct_calendar_event_types"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_calendar_event_types"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ct_calendar_event_types"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_calendar_event_types"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_calendar_event_types"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_calendar_event_types"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_calendar_event_types"."fields_options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ct_calendar_event_types"."language_id" IS \'ID языка\';
                COMMENT ON TABLE "public"."ct_calendar_event_types" IS \'Таблица типов карты адресов (яндекс, гугл)\';
                
                -- ----------------------------
                -- Indexes structure for table ct_calendar_event_types
                -- ----------------------------
                CREATE INDEX "map_type_index_id_copy1" ON "public"."ct_calendar_event_types" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ct_calendar_event_types
                -- ----------------------------
                ALTER TABLE "public"."ct_calendar_event_types" ADD CONSTRAINT "ct_map_types_copy1_pkey" PRIMARY KEY ("global_id");
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
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Название типа карты',
        ),
        'update_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Кто отредактировал эту запись',
            'table' => 'DB_User',
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
        'delete_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Кто удалил запись',
            'table' => 'DB_User',
        ),
        'global_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Глобальный ID',
        ),
        'fields_options' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дополнительные поля',
        ),
        'language_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID языка',
            'table' => 'DB_Language',
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
