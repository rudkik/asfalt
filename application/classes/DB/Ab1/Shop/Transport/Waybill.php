<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Transport_Waybill {
    const TABLE_NAME = 'ab_shop_transport_waybills';
    const TABLE_ID = 361;
    const NAME = 'DB_Ab1_Shop_Transport_Waybill';
    const TITLE = 'Путевые листы';
    const IS_CATALOG = false;

    const INTEGRATIONS = [
        Integration_Ab1_1C_Service::SERVICE_NAME => [
            'type' => 'waybill',
            'guid' => ['system' => 'id', '1c' => 'guid'],
            'guid_1c' => ['system' => 'guid_1c', '1c' => 'guid_1c'],
            'default' => [
                'ver' => 'plus',
            ],
            'is_save_1c' => [
                'class' => 'Api_Ab1_Shop_Transport_Waybill', 'function' => 'is1CJSON'
            ],
            'children' => [
                'rows' => [
                    ['class' => 'Api_Ab1_Shop_Transport_Waybill', 'function' => 'get1CJSON'],
                ],
            ],
        ],
    ];

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_transport_waybills";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_transport_waybills
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_transport_waybills" (
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
                  "shop_transport_id" int8 NOT NULL DEFAULT 0,
                  "season_id" int8 NOT NULL DEFAULT 0,
                  "season_time_id" int8 NOT NULL DEFAULT 0,
                  "fuel_issue_id" int8 NOT NULL DEFAULT 0,
                  "fuel_type_id" int8 NOT NULL DEFAULT 0,
                  "fuel_quantity_issues" numeric(12,3) NOT NULL DEFAULT 0,
                  "fuel_quantity_expenses" numeric(12,3) NOT NULL DEFAULT 0,
                  "date" date,
                  "from_at" timestamp(6),
                  "to_at" timestamp(6),
                  "number" varchar(20) COLLATE "pg_catalog"."default",
                  "milage" numeric(12,2) NOT NULL DEFAULT 0,
                  "milage_from" numeric(12,2) NOT NULL DEFAULT 0,
                  "milage_to" numeric(12,2) NOT NULL DEFAULT 0,
                  "fuel_quantity_from" numeric(12,3) NOT NULL DEFAULT 0,
                  "fuel_quantity_to" numeric(12,3) NOT NULL DEFAULT 0,
                  "transport_view_id" int8 NOT NULL DEFAULT 0,
                  "transport_work_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."shop_transport_driver_id" IS \'ID водителя\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."shop_transport_id" IS \'ID транспорта\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."season_id" IS \'ID сезона\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."season_time_id" IS \'ID времени сезона\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."fuel_issue_id" IS \'ID способа выдачи топлива\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."fuel_type_id" IS \'ID топлива\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."fuel_quantity_issues" IS \'Количество топлива\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."fuel_quantity_expenses" IS \'Количество топлива\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."date" IS \'Дата путевого листа\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."from_at" IS \'Время выезда\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."to_at" IS \'Время въезда\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."number" IS \'Номер документа\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."milage" IS \'Пробег за день\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."milage_from" IS \'Пробег при выезде\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."milage_to" IS \'Пробег при заезде\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."fuel_quantity_from" IS \'Количество топлива при выезде\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."fuel_quantity_to" IS \'Количество топлива при заезде\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."transport_view_id" IS \'ID вид транспорта\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybills"."transport_work_id" IS \'ID вид работ\';
                COMMENT ON TABLE "public"."ab_shop_transport_waybills" IS \'Список путевых листов\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_transport_waybills
                -- ----------------------------
                CREATE INDEX "ab_shop_transport_waybill_date" ON "public"."ab_shop_transport_waybills" USING btree (
                  "date" "pg_catalog"."date_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_waybill_first" ON "public"."ab_shop_transport_waybills" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_waybill_full_name" ON "public"."ab_shop_transport_waybills" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name::text), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "ab_shop_transport_waybill_index_id" ON "public"."ab_shop_transport_waybills" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_waybill_old_id" ON "public"."ab_shop_transport_waybills" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_waybill_shop_transport_driver_id" ON "public"."ab_shop_transport_waybills" USING btree (
                  "shop_transport_driver_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_waybill_shop_transport_id" ON "public"."ab_shop_transport_waybills" USING btree (
                  "shop_transport_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
                    'bin_org' => 'bin',
                    'division_org' => 'old_id',
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
            'is_common_items' => true,
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'worker_iin' => 'shop_worker_id.iin',
                ]
            ],
        ),
        'shop_transport_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID транспорта',
            'table' => 'DB_Ab1_Shop_Transport',
            'is_common_items' => true,
        ),
        'season_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID сезона',
            'table' => 'DB_Ab1_Season',
        ),
        'season_time_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID времени сезона',
            'table' => 'DB_Ab1_Season_Time',
        ),
        'fuel_issue_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID способа выдачи топлива',
            'table' => 'DB_Ab1_Fuel_Issue',
            'is_common_items' => true,
        ),
        'fuel_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID топлива',
            'table' => 'DB_Ab1_Fuel_Type',
            'is_common_items' => true,
        ),
        'fuel_quantity_issues' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество топлива',
            'total_item' => array(
                'db_name' => 'DB_Ab1_Shop_Transport_Waybill_Fuel_Issue',
                'field' => 'quantity',
            )
        ),
        'fuel_quantity_expenses' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество топлива',
            'total_item' => array(
                'db_name' => 'DB_Ab1_Shop_Transport_Waybill_Fuel_Expense',
                'field' => 'quantity',
            )
        ),
        'date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата путевого листа',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'date',
            ],
        ),
        'from_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Время выезда',
        ),
        'to_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Время въезда',
        ),
        'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 20,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер документа',
            'is_sequence' => true,
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'code',
            ],
        ),
        'milage' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Пробег за день',
        ),
        'milage_from' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Пробег при выезде',
        ),
        'milage_to' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Пробег при заезде',
        ),
        'fuel_quantity_from' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество топлива при выезде',
        ),
        'fuel_quantity_to' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество топлива при заезде',
        ),
        'transport_view_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID вида транспорта',
            'table' => 'DB_Ab1_Transport_View',
        ),
        'transport_work_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID вида работы',
            'table' => 'DB_Ab1_Transport_Work',
        ),
        'transport_wage_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID вида заработной платы',
            'table' => 'DB_Ab1_Transport_Wage',
        ),
        'shop_subdivision_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => DB_Ab1_Shop_Subdivision::NAME,
        ),
        'transport_form_payment_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID форма оплаты',
            'table' => DB_Ab1_Transport_FormPayment::NAME,
        ),
        'wage' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Зарплата за рейсы',
        ),
        'guid_1c' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 32,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'GUID 1С',
        ),
    );

    // список связанных таблиц 1коМногим
    const ITEMS = array(
        'shop_transport_waybill_cars' => array(
            'table' => 'DB_Ab1_Shop_Transport_Waybill_Car',
            'field_id' => 'shop_transport_waybill_id',
            'is_view' => true,
        ),
        'shop_transport_waybill_escorts' => array(
            'table' => 'DB_Ab1_Shop_Transport_Waybill_Escort',
            'field_id' => 'shop_transport_waybill_id',
            'is_view' => true,
        ),
        'shop_transport_waybill_fuel_expenses' => array(
            'table' => 'DB_Ab1_Shop_Transport_Waybill_Fuel_Expense',
            'field_id' => 'shop_transport_waybill_id',
            'is_view' => true,
        ),
        'shop_transport_waybill_fuel_issues' => array(
            'table' => 'DB_Ab1_Shop_Transport_Waybill_Fuel_Issue',
            'field_id' => 'shop_transport_waybill_id',
            'is_view' => true,
        ),
        'shop_transport_waybill_trailers' => array(
            'table' => 'DB_Ab1_Shop_Transport_Waybill_Trailer',
            'field_id' => 'shop_transport_waybill_id',
            'is_view' => true,
        ),
        'shop_transport_waybill_work_drivers' => array(
            'table' => 'DB_Ab1_Shop_Transport_Waybill_Work_Driver',
            'field_id' => 'shop_transport_waybill_id',
            'is_view' => true,
        ),
        'shop_transport_waybill_work_cars' => array(
            'table' => 'DB_Ab1_Shop_Transport_Waybill_Work_Car',
            'field_id' => 'shop_transport_waybill_id',
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