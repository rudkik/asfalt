<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Transport_Waybill_Work_Driver {
    const TABLE_NAME = 'ab_shop_transport_waybill_work_drivers';
    const TABLE_ID = 367;
    const NAME = 'DB_Ab1_Shop_Transport_Waybill_Work_Driver';
    const TITLE = 'Параметры выработки в путевых листах';
    const IS_CATALOG = false;

    const INTEGRATIONS = [
        Integration_Ab1_1C_Service::SERVICE_NAME => [
            'type' => 'waybill_str',
            'guid' => ['system' => 'id', '1c' => 'guid'],
            'guid_1c' => ['system' => 'guid_1c', '1c' => 'guid_1c'],
            'default' => [
                'ver' => 'plus',
            ],
            'children' => [
                'rows' => [
                    ['class' => 'Api_Ab1_Shop_Transport_Waybill_Work_Driver', 'function' => 'get1CJSON'],
                ],
            ],
        ],
    ];

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_transport_waybill_work_drivers";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_transport_waybill_work_drivers
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_transport_waybill_work_drivers" (
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
                  "shop_transport_driver_id" int8 NOT NULL DEFAULT 0,
                  "shop_transport_work_id" int8 NOT NULL DEFAULT 0,
                  "date" date,
                  "quantity" numeric(12,2) NOT NULL DEFAULT 0,
                  "shop_transport_waybill_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_work_drivers"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_work_drivers"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_work_drivers"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_work_drivers"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_work_drivers"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_work_drivers"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_work_drivers"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_work_drivers"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_work_drivers"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_work_drivers"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_work_drivers"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_work_drivers"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_work_drivers"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_work_drivers"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_work_drivers"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_work_drivers"."shop_transport_driver_id" IS \'ID водителя\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_work_drivers"."shop_transport_work_id" IS \'ID работы\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_work_drivers"."date" IS \'Дата путевого листа\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_work_drivers"."quantity" IS \'Количество\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_work_drivers"."shop_transport_waybill_id" IS \'ID путевого листа\';
                COMMENT ON TABLE "public"."ab_shop_transport_waybill_work_drivers" IS \'Список параметров выработки в путевых листах\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_transport_waybill_work_drivers
                -- ----------------------------
                CREATE INDEX "ab_shop_transport_waybill_work_date" ON "public"."ab_shop_transport_waybill_work_drivers" USING btree (
                  "date" "pg_catalog"."date_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_waybill_work_first" ON "public"."ab_shop_transport_waybill_work_drivers" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_waybill_work_index_id" ON "public"."ab_shop_transport_waybill_work_drivers" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_waybill_work_shop_transport_driver_id" ON "public"."ab_shop_transport_waybill_work_drivers" USING btree (
                  "shop_transport_driver_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_waybill_work_shop_transport_waybill_id" ON "public"."ab_shop_transport_waybill_work_drivers" USING btree (
                  "shop_transport_waybill_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_waybill_work_shop_transport_work_id" ON "public"."ab_shop_transport_waybill_work_drivers" USING btree (
                  "shop_transport_work_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'division_org' => 'old_id',
                    'bin_org' => 'bin',
                ]
            ],
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
        'shop_transport_driver_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID водителя',
            'table' => 'DB_Ab1_Shop_Transport_Driver',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'worker_iin' => 'shop_worker_id.iin',
                ]
            ],
        ),
        'shop_transport_work_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID работы',
            'table' => 'DB_Ab1_Shop_Transport_Work',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'code1c' => 'old_id',
                    'str' => 'name',
                ]
            ],
        ),
        'date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата путевого листа',
        ),
        'quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Количество',
        ),
        'shop_transport_waybill_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID путевого листа',
            'table' => 'DB_Ab1_Shop_Transport_Waybill',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'typeofwork' => 'transport_view_id.number',
                    'strtypeofwork' => 'transport_view_id.name',
                    'typeoftime' => 'transport_view_id.is_public',
                ]
            ],
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