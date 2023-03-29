<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Transport_Wage {
    const TABLE_NAME = 'ab_transport_wages';
    const TABLE_ID = 410;
    const NAME = 'DB_Ab1_Transport_Wage';
    const TITLE = 'Виды для расчета зарплаты';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_transport_wages";',
            'create' => '
                -- ----------------------------
                -- ----------------------------
                -- Table structure for ab_transport_wages
                -- ----------------------------
                CREATE TABLE "public"."ab_transport_wages" (
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
                  "number" varchar(50) COLLATE "pg_catalog"."default"
                )
                ;
                COMMENT ON COLUMN "public"."ab_transport_wages"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_transport_wages"."name" IS \'Название топлива\';
                COMMENT ON COLUMN "public"."ab_transport_wages"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_transport_wages"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_transport_wages"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_transport_wages"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_transport_wages"."old_id" IS \'ID 1c\';
                COMMENT ON COLUMN "public"."ab_transport_wages"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_transport_wages"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_transport_wages"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_transport_wages"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_transport_wages"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_transport_wages"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_transport_wages"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_transport_wages"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_transport_wages"."number" IS \'Номер 1C\';
                COMMENT ON TABLE "public"."ab_transport_wages" IS \'Список видов для расчета зарплаты\';
                
                -- ----------------------------
                -- Records of ab_transport_wages
                -- ----------------------------
                INSERT INTO "public"."ab_transport_wages" VALUES (1, 1, \'Дежурка\', NULL, NULL, NULL, NULL, 0, \'0\', 20680, 20680, 0, \'2021-02-07 11:55:49\', \'2021-02-07 11:55:49\', NULL, 0, 35, 4602569, \'\');
                INSERT INTO "public"."ab_transport_wages" VALUES (2, 1, \'Технология\', NULL, NULL, NULL, NULL, 0, \'0\', 20680, 20680, 0, \'2021-02-07 11:56:00\', \'2021-02-07 11:56:00\', NULL, 0, 35, 4602570, \'\');
                INSERT INTO "public"."ab_transport_wages" VALUES (3, 1, \'Битумовоз, Легковые, Автобусы\', NULL, NULL, NULL, NULL, 0, \'0\', 20680, 20680, 0, \'2021-02-07 11:56:10\', \'2021-02-07 11:56:10\', NULL, 0, 35, 4602571, \'\');
                
                -- ----------------------------
                -- Indexes structure for table ab_transport_wages
                -- ----------------------------
                CREATE INDEX "ab_transport_wage_first" ON "public"."ab_transport_wages" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_transport_wage_full_name" ON "public"."ab_transport_wages" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name::text), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "ab_transport_wage_index_id" ON "public"."ab_transport_wages" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_transport_wage_name_like" ON "public"."ab_transport_wages" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_transport_wage_old_id" ON "public"."ab_transport_wages" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
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
            'title' => 'Номер авто',
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
            'is_not_automatic_save' => true, // запрет на автотамическое изменение поля
        ),
        'files' => array(
            'type' => DB_FieldType::FIELD_TYPE_FILES,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дополнительные файлы',
            'is_not_automatic_save' => true, // запрет на автотамическое изменение поля
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
        'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер 1C',
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
