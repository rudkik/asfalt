<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_ClientContract_Status {
    const TABLE_NAME = 'ab_client_contract_statuses';
    const TABLE_ID = 372;
    const NAME = 'DB_Ab1_ClientContract_Status';
    const TITLE = 'Статусы договоров';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_client_contract_statuses";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_client_contract_statuses
                -- ----------------------------
                CREATE TABLE "public"."ab_client_contract_statuses" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "name" varchar(50) COLLATE "pg_catalog"."default" NOT NULL,
                  "image_path" varchar(100) COLLATE "pg_catalog"."default",
                  "update_user_id" int8 NOT NULL,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6),
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "delete_user_id" int8 DEFAULT 0,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "create_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone
                )
                ;
                COMMENT ON COLUMN "public"."ab_client_contract_statuses"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_client_contract_statuses"."name" IS \'Название \';
                COMMENT ON COLUMN "public"."ab_client_contract_statuses"."image_path" IS \'Файл \';
                COMMENT ON COLUMN "public"."ab_client_contract_statuses"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_client_contract_statuses"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_client_contract_statuses"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_client_contract_statuses"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_client_contract_statuses"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_client_contract_statuses"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_client_contract_statuses"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_client_contract_statuses"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON TABLE "public"."ab_client_contract_statuses" IS \'Таблица статусов договоров\';
                
                -- ----------------------------
                -- Indexes structure for table ab_client_contract_statuses
                -- ----------------------------
                CREATE INDEX "ab_client_contract_status_first" ON "public"."ab_client_contract_statuses" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_client_contract_status_index_id" ON "public"."ab_client_contract_statuses" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ab_client_contract_statuses
                -- ----------------------------
                ALTER TABLE "public"."ab_client_contract_statuses" ADD CONSTRAINT "ab_client_contract_types_copy1_pkey" PRIMARY KEY ("global_id");
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
            'title' => 'Название ',
        ),
        'image_path' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 100,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Файл ',
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
        'create_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Кто отредактировал эту запись',
            'table' => 'DB_User',
        ),
        'created_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
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
