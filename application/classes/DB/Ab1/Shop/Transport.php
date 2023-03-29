<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Transport {
    const TABLE_NAME = 'ab_shop_transports';
    const TABLE_ID = 407;
    const NAME = 'DB_Ab1_Shop_Transport';
    const TITLE = 'Транспортные средства';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_transports";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_transports
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_transports" (
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
                  "number" varchar(250) COLLATE "pg_catalog"."default",
                  "milage" numeric(12,2) NOT NULL DEFAULT 0,
                  "fuel_quantity" numeric(12,3) NOT NULL DEFAULT 0,
                  "shop_transport_mark_id" int8 NOT NULL DEFAULT 0,
                  "shop_transport_driver_id" int8 NOT NULL DEFAULT 0,
                  "shop_transport_fuel_storage_id" int8 NOT NULL DEFAULT 0,
                  "is_trailer" numeric(1) NOT NULL DEFAULT 0,
                  "shop_branch_storage_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_transports"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_transports"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_transports"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ab_shop_transports"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_transports"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_transports"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_transports"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_transports"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_transports"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_transports"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_transports"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_transports"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_transports"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_transports"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_transports"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_transports"."number" IS \'Номер машины\';
                COMMENT ON COLUMN "public"."ab_shop_transports"."milage" IS \'Пробег машины\';
                COMMENT ON COLUMN "public"."ab_shop_transports"."fuel_quantity" IS \'Количество бензина в баке\';
                COMMENT ON COLUMN "public"."ab_shop_transports"."shop_transport_mark_id" IS \'ID марки машины\';
                COMMENT ON COLUMN "public"."ab_shop_transports"."shop_transport_driver_id" IS \'ID основного водителя\';
                COMMENT ON COLUMN "public"."ab_shop_transports"."shop_transport_fuel_storage_id" IS \'ID склада хранения топлива\';
                COMMENT ON COLUMN "public"."ab_shop_transports"."is_trailer" IS \'Прицеп?\';
                COMMENT ON COLUMN "public"."ab_shop_transports"."shop_branch_storage_id" IS \'ID филиала гаража машины\';
                COMMENT ON TABLE "public"."ab_shop_transports" IS \'Список транспортных средств \';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_transports
                -- ----------------------------
                CREATE INDEX "ab_shop_transport_first" ON "public"."ab_shop_transports" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_full_name" ON "public"."ab_shop_transports" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name::text), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "ab_shop_transport_full_number" ON "public"."ab_shop_transports" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, number::text), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "ab_shop_transport_index_id" ON "public"."ab_shop_transports" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_old_id" ON "public"."ab_shop_transports" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_shop_branch_storage_id" ON "public"."ab_shop_transports" USING btree (
                  "shop_branch_storage_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_shop_transport_driver_id" ON "public"."ab_shop_transports" USING btree (
                  "shop_transport_driver_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_shop_transport_fuel_storage_id" ON "public"."ab_shop_transports" USING btree (
                  "shop_transport_fuel_storage_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_shop_transport_mark_id" ON "public"."ab_shop_transports" USING btree (
                  "shop_transport_mark_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер машины',
        ),
        'milage' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Пробег машины',
        ),
        'fuel_quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество бензина в баке',
        ),
        'shop_transport_mark_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID марки машины',
            'table' => 'DB_Ab1_Shop_Transport_Mark',
        ),
        'shop_transport_driver_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID основного водителя',
            'table' => 'DB_Ab1_Shop_Transport_Driver',
        ),
        'shop_transport_fuel_storage_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID склада хранения топлива',
            'table' => 'DB_Ab1_Shop_Transport_Fuel_Storage',
        ),
        'is_trailer' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Прицеп?',
        ),
        'shop_branch_storage_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID филиала гаража машины',
            'table' => 'DB_Shop',
        ),
        'transport_wage_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID вида заработной платы',
            'table' => 'DB_Ab1_Transport_Wage',
        ),
        'driver_norm_day' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Дневная часовая норма водителя',
        ),
        'is_wage' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Учитывать рейсы в зарплате',
        ),

    );

    // список связанных таблиц 1коМногим
    const ITEMS = array(
        'shop_transport_driver_tariffs' => array(
            'table' => 'DB_Ab1_Shop_Transport_Driver_Tariff',
            'field_id' => 'shop_transport_id',
            'is_view' => true,
        ),
        'shop_transport_to_works' => array(
            'table' => 'DB_Ab1_Shop_Transport_To_Work',
            'field_id' => 'shop_transport_id',
            'is_view' => true,
        ),
        'shop_transport_to_fuels' => array(
            'table' => 'DB_Ab1_Shop_Transport_To_Fuel',
            'field_id' => 'shop_transport_id',
            'is_view' => true,
        ),
        'shop_transport_to_work_drivers' => array(
            'table' => 'DB_Ab1_Shop_Transport_To_Work_Driver',
            'field_id' => 'shop_transport_id',
            'is_view' => true,
        ),
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
