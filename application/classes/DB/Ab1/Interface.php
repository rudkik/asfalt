<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Interface {
    const TABLE_NAME = 'ab_interfaces';
    const TABLE_ID = 343;
    const NAME = 'DB_Ab1_Interface';
    const TITLE = 'Интерфейсы АСВА';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_interfaces";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_interfaces
                -- ----------------------------
                CCREATE TABLE "public"."ab_interfaces" (
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
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "options" text COLLATE "pg_catalog"."default",
                  "code" varchar(10) COLLATE "pg_catalog"."default",
                  "report_number" int4
                )
                ;
                COMMENT ON COLUMN "public"."ab_interfaces"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_interfaces"."name" IS \'Название \';
                COMMENT ON COLUMN "public"."ab_interfaces"."image_path" IS \'Файл \';
                COMMENT ON COLUMN "public"."ab_interfaces"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_interfaces"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_interfaces"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_interfaces"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_interfaces"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_interfaces"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_interfaces"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_interfaces"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_interfaces"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_interfaces"."code" IS \'Код интерфейса\';
                COMMENT ON COLUMN "public"."ab_interfaces"."report_number" IS \'Номер последнего отчета\';
                COMMENT ON TABLE "public"."ab_interfaces" IS \'Таблица интерфейсов АСВА\';
                
                -- ----------------------------
                -- Indexes structure for table ab_interfaces
                -- ----------------------------
                CREATE INDEX "ab_interface_first" ON "public"."ab_interfaces" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_interface_index_id" ON "public"."ab_interfaces" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ab_interfaces
                -- ----------------------------
                ALTER TABLE "public"."ab_interfaces" ADD CONSTRAINT "ab_client_contract_views_copy1_pkey" PRIMARY KEY ("global_id");
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
        'options' => array(
            'type' => DB_FieldType::FIELD_TYPE_JSON,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дополнительные поля',
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
