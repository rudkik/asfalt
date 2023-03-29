<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Worker_EntryExit {
    const TABLE_NAME = 'ab_shop_worker_entry_exits';
    const TABLE_ID = 402;
    const NAME = 'DB_Ab1_Shop_Worker_EntryExit';
    const TITLE = 'Регистрация входа/выхода сотрудников';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_worker_entry_exits";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_worker_entry_exits
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_worker_entry_exits" (
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
                  "is_car" numeric(1) NOT NULL DEFAULT 0,
                  "shop_worker_passage_id" int8 NOT NULL DEFAULT 0,
                  "shop_worker_id" int8 NOT NULL DEFAULT 0,
                  "date_entry" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "shop_card_id" int8 NOT NULL DEFAULT 0,
                  "is_exit" numeric(1) NOT NULL DEFAULT 0,
                  "date_exit" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "late_for" int8,
                  "early_exit" int8,
                  "guest_id" int8
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."is_car" IS \'Проезд машине?\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."shop_worker_passage_id" IS \'ID точка входа/выхода\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."shop_worker_id" IS \'ID сотрудника\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."date_entry" IS \'Время входа \';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."shop_card_id" IS \'ID карточки сотрудника\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."is_exit" IS \'Вышел ли сотрудник\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."date_exit" IS \'Время выхода\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."late_for" IS \'На сколько опоздал\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."early_exit" IS \'На сколько раньше ушел\';
                COMMENT ON COLUMN "public"."ab_shop_worker_entry_exits"."guest_id" IS \'ID гостя\';
                COMMENT ON TABLE "public"."ab_shop_worker_entry_exits" IS \'Список входа/выхода сотрудников\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_worker_entry_exits
                -- ----------------------------
                CREATE INDEX "ab_shop_worker_entry_exit_date_entry" ON "public"."ab_shop_worker_entry_exits" USING btree (
                  "date_entry" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_worker_entry_exit_date_exit" ON "public"."ab_shop_worker_entry_exits" USING btree (
                  "date_exit" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_worker_entry_exit_first" ON "public"."ab_shop_worker_entry_exits" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_worker_entry_exit_index_id" ON "public"."ab_shop_worker_entry_exits" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_worker_entry_exit_is_exit" ON "public"."ab_shop_worker_entry_exits" USING btree (
                  "is_exit" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_worker_entry_exit_shop_worker_id" ON "public"."ab_shop_worker_entry_exits" USING btree (
                  "shop_worker_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_worker_entry_exit_shop_worker_passage_id" ON "public"."ab_shop_worker_entry_exits" USING btree (
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
        'is_car' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Проезд машине?',
        ),
        'shop_worker_passage_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID точка входа',
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
        'is_exit' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Вышел ли сотрудник',
        ),
        'date_exit' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Время выхода',
        ),
        'late_for' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'На сколько опоздал',
        ),
        'early_exit' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'На сколько раньше ушел',
        ),
        'guest_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID гостя',
            'table' => 'DB_AB1_Guest'
        ),
        'shop_department_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID отдела',
            'table' => 'DB_AB1_Shop_Department'
        ),
        'time_work' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Сколько секунд отработал сотрудник',
        ),
        'exit_shop_worker_passage_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID точка выхода',
            'table' => 'DB_Ab1_Shop_Worker_Passage',
        ),
        'is_inside_move' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Внутреннее перемещение?',
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
