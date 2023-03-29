<?php defined('SYSPATH') or die('No direct script access.');

class DB_OrganizationType {
    const TABLE_NAME = 'ct_organization_types';
    const TABLE_ID = 61;
    const NAME = 'DB_OrganizationType';
    const TITLE = 'Формы деятельности';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_organization_types";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_organization_types
                -- ----------------------------
                CREATE TABLE "public"."ct_organization_types" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "name" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
                  "update_user_id" int8 NOT NULL,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6),
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "delete_user_id" int8 DEFAULT 0,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "land_id" int8 NOT NULL DEFAULT 0,
                  "options" text COLLATE "pg_catalog"."default",
                  "is_bin" numeric(1) NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ct_organization_types"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ct_organization_types"."name" IS \'Название города\';
                COMMENT ON COLUMN "public"."ct_organization_types"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_organization_types"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ct_organization_types"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_organization_types"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_organization_types"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_organization_types"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_organization_types"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ct_organization_types"."land_id" IS \'ID страны\';
                COMMENT ON COLUMN "public"."ct_organization_types"."options" IS \'Дополнительные поля \';
                COMMENT ON COLUMN "public"."ct_organization_types"."is_bin" IS \'Обзятателен ли БИН\';
                COMMENT ON TABLE "public"."ct_organization_types" IS \'Таблица городов\';
                
                -- ----------------------------
                -- Indexes structure for table ct_organization_types
                -- ----------------------------
                CREATE INDEX "organization_type_first" ON "public"."ct_organization_types" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "organization_type_index_id" ON "public"."ct_organization_types" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "organization_type_land_id" ON "public"."ct_organization_types" USING btree (
                  "land_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "organization_type_name_like" ON "public"."ct_organization_types" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ct_organization_types
                -- ----------------------------
                ALTER TABLE "public"."ct_organization_types" ADD CONSTRAINT "ct_organization_types_pkey" PRIMARY KEY ("global_id");
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
            'title' => 'Название города',
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
        'language_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID языка',
            'table' => 'DB_Language',
        ),
        'land_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID страны',
            'table' => 'DB_Land',
        ),
        'options' => array(
            'type' => DB_FieldType::FIELD_TYPE_JSON,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дополнительные поля ',
        ),
        'is_bin' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Обзятателен ли БИН',
        ),
        'old_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
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
