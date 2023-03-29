<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Worker_EntryExit_Log {
    const TABLE_NAME = 'ab_shop_worker_entry_exit_logs';
    const TABLE_ID = 428;
    const NAME = 'DB_Ab1_Shop_Worker_EntryExit_Log';
    const TITLE = 'Лог считывания карточек входа/выхода сотрудников';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_worker_entry_exit_logs";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_worker_entry_exit_logs
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_worker_entry_exit_logs" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "text" text COLLATE "pg_catalog"."default",
                  "image_path" varchar(100) COLLATE "pg_catalog"."default",
                  "files" text COLLATE "pg_catalog"."default",
                  "options" text COLLATE "pg_catalog"."default",
                  "order" int8 NOT NULL DEFAULT 0,
                  "old_id" varchar(64) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 0,
                  "create_user_id" int8 NOT NULL DEFAULT 0,
                  "update_user_id" int8 NOT NULL,
                  "delete_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "shop_worker_passage_id" int8 NOT NULL DEFAULT 0,
                  "shop_worker_id" int8 NOT NULL DEFAULT 0,
                  "date_entry" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "shop_card_id" int8 NOT NULL DEFAULT 0,
                  "date_exit" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "early_exit" int4 NOT NULL DEFAULT 0,
                  "guest_id" int8 NOT NULL DEFAULT 0,
                  "shop_worker_entry_exit_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."shop_worker_passage_id" IS \'ID точка входа/выхода\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."shop_worker_id" IS \'ID сотрудника\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."date_entry" IS \'Время входа \';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."shop_card_id" IS \'ID карточки сотрудника\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."date_exit" IS \'Время выхода\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."early_exit" IS \'На сколько раньше ушел\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."guest_id" IS \'ID гостя\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exit_logs"."shop_worker_entry_exit_id" IS \'ID зафиксированного входа\';
                COMMENT ON TABLE "public"."ab_shop_worker_entry_exit_logs" IS \'Лог считывания карточек входа/выхода сотрудников\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_worker_entry_exit_logs
                -- ----------------------------
                CREATE INDEX "ab_shop_worker_entry_exit_log_date_entry" ON "public"."ab_shop_worker_entry_exit_logs" USING btree (
                  "date_entry" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_worker_entry_exit_log_date_exit" ON "public"."ab_shop_worker_entry_exit_logs" USING btree (
                  "date_exit" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_worker_entry_exit_log_first" ON "public"."ab_shop_worker_entry_exit_logs" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_worker_entry_exit_log_guest_id" ON "public"."ab_shop_worker_entry_exit_logs" USING btree (
                  "guest_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_worker_entry_exit_log_index_id" ON "public"."ab_shop_worker_entry_exit_logs" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_worker_entry_exit_log_shop_worker_entry_exit_id" ON "public"."ab_shop_worker_entry_exit_logs" USING btree (
                  "shop_worker_entry_exit_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_worker_entry_exit_log_shop_worker_id" ON "public"."ab_shop_worker_entry_exit_logs" USING btree (
                  "shop_worker_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_worker_entry_exit_log_shop_worker_passage_id" ON "public"."ab_shop_worker_entry_exit_logs" USING btree (
                  "shop_worker_passage_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'shop_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID магазина',
            'table' => 'DB_Shop',
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
            'title' => '',
        ),
        'create_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
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
        'shop_worker_passage_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID точка входа/выхода',
            'table' => 'DB_Ab1_Shop_Worker_Passage',
        ),
        'shop_worker_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID сотрудника',
            'table' => 'DB_Ab1_Shop_Worker',
        ),
        'date_entry' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Время входа ',
        ),
        'shop_card_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID карточки сотрудника',
            'table' => 'DB_Magazine_Shop_Card',
        ),
        'date_exit' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Время выхода',
        ),
        'early_exit' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 9,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'На сколько раньше ушел',
        ),
        'guest_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID гостя',
            'table' => 'DB_Ab1_Guest',
        ),
        'shop_worker_entry_exit_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID зафиксированного входа',
            'table' => 'DB_Ab1_Shop_Worker_EntryExit',
        ),
        'shop_worker_passage_message_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID',
            'table' => 'DB_Ab1_Shop_Passage_Message',
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
