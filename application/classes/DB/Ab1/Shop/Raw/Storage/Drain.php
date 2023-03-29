<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Raw_Storage_Drain {
    const TABLE_NAME = 'ab_shop_raw_storage_drains';
    const TABLE_ID = 356;
    const NAME = 'DB_Ab1_Shop_Raw_Storage_Drain';
    const TITLE = 'Загрузка/выгрузка хранилища сырья';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_raw_storage_drains";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_raw_storage_drains
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_raw_storage_drains" (
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
                  "create_user_id" int8 DEFAULT 0,
                  "update_user_id" int8 NOT NULL,
                  "delete_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "shop_raw_id" int8 NOT NULL DEFAULT 0,
                  "shop_raw_storage_id" int8 NOT NULL DEFAULT 0,
                  "is_upload" numeric(1) NOT NULL DEFAULT 1,
                  "shop_raw_drain_chute_id" int8 NOT NULL DEFAULT 0,
                  "shop_material_storage_id" int8 NOT NULL DEFAULT 0,
                  "shop_material_id" int8 NOT NULL DEFAULT 0,
                  "shop_boxcar_client_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_raw_storage_drains"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_raw_storage_drains"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_raw_storage_drains"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ab_shop_raw_storage_drains"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_raw_storage_drains"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_raw_storage_drains"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_raw_storage_drains"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_raw_storage_drains"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_raw_storage_drains"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_raw_storage_drains"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_raw_storage_drains"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_raw_storage_drains"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_raw_storage_drains"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_raw_storage_drains"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_raw_storage_drains"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_raw_storage_drains"."shop_raw_id" IS \'ID сырья\';
                COMMENT ON COLUMN "public"."ab_shop_raw_storage_drains"."shop_raw_storage_id" IS \'ID хранилища сырья\';
                COMMENT ON COLUMN "public"."ab_shop_raw_storage_drains"."is_upload" IS \'Производят ли закачку? (иначе слив)\';
                COMMENT ON COLUMN "public"."ab_shop_raw_storage_drains"."shop_raw_drain_chute_id" IS \'ID лотка закачки сырья из вагонов \';
                COMMENT ON COLUMN "public"."ab_shop_raw_storage_drains"."shop_material_storage_id" IS \'ID хранилища материала для слива\';
                COMMENT ON COLUMN "public"."ab_shop_raw_storage_drains"."shop_material_id" IS \'ID материала\';
                COMMENT ON COLUMN "public"."ab_shop_raw_storage_drains"."shop_boxcar_client_id" IS \'ID поставщика сырья\';
                COMMENT ON TABLE "public"."ab_shop_raw_storage_drains" IS \'Список загрузки/выгрузки хранилица сырья\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_raw_storage_drains
                -- ----------------------------
                CREATE INDEX "ab_shop_raw_storage_drain_first" ON "public"."ab_shop_raw_storage_drains" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_raw_storage_drain_index_id" ON "public"."ab_shop_raw_storage_drains" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_raw_storage_drain_is_upload" ON "public"."ab_shop_raw_storage_drains" USING btree (
                  "is_upload" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_raw_storage_drain_shop_boxcar_client_id" ON "public"."ab_shop_raw_storage_drains" USING btree (
                  "shop_boxcar_client_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_raw_storage_drain_shop_material_id" ON "public"."ab_shop_raw_storage_drains" USING btree (
                  "shop_material_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_raw_storage_drain_shop_raw_drain_chute_id" ON "public"."ab_shop_raw_storage_drains" USING btree (
                  "shop_raw_drain_chute_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_raw_storage_drain_shop_raw_id" ON "public"."ab_shop_raw_storage_drains" USING btree (
                  "shop_raw_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_raw_storage_drain_shop_raw_storage_id" ON "public"."ab_shop_raw_storage_drains" USING btree (
                  "shop_raw_storage_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'shop_raw_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID сырья',
            'table' => 'DB_Ab1_Shop_Raw',
        ),
        'shop_raw_storage_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID хранилища сырья',
            'table' => 'DB_Ab1_Shop_Raw_Storage',
        ),
        'is_upload' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Производят ли закачку? (иначе слив)',
        ),
        'shop_raw_drain_chute_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID лотка закачки сырья из вагонов ',
            'table' => 'DB_Ab1_Shop_Raw_DrainChute',
        ),
        'shop_material_storage_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID хранилища материала для слива',
            'table' => 'DB_Ab1_Shop_Material_Storage',
        ),
        'shop_material_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID материала',
            'table' => 'DB_Ab1_Shop_Material',
        ),
        'shop_boxcar_client_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID поставщика сырья',
            'table' => 'DB_Ab1_Shop_Boxcar_Client',
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
