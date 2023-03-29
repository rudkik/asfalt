<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Boxcar_Train {
    const TABLE_NAME = 'ab_shop_boxcar_trains';
    const TABLE_ID = 211;
    const NAME = 'DB_Ab1_Shop_Boxcar_Train';
    const TITLE = 'Материалы вагонами';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_boxcar_trains";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_boxcar_trains
                -- ----------------------------
                DROP TABLE IF EXISTS "public"."ab_shop_boxcar_trains";
                CREATE TABLE "public"."ab_shop_boxcar_trains" (
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
                  "quantity" numeric(12,3) NOT NULL DEFAULT 0,
                  "date_shipment" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "date_departure" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "tracker" varchar(64) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 0,
                  "shop_boxcar_departure_station_id" int8 NOT NULL DEFAULT 0,
                  "shop_boxcar_client_id" int8 NOT NULL DEFAULT 0,
                  "contract_number" varchar(64) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "contract_date" date DEFAULT NULL::timestamp without time zone,
                  "date_drain_from" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "date_drain_to" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "shop_boxcar_factory_id" int8 NOT NULL DEFAULT 0,
                  "downtime_permitted" int4 NOT NULL DEFAULT 0,
                  "is_exit" numeric(1) NOT NULL DEFAULT 0,
                  "fine_day" numeric(12,2) NOT NULL DEFAULT 0,
                  "boxcars" text COLLATE "pg_catalog"."default",
                  "shop_client_id" int8 NOT NULL DEFAULT 0,
                  "shop_client_contract_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."shop_raw_id" IS \'ID сырья\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."quantity" IS \'Количество\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."date_shipment" IS \'Планируемая дата отгрузки\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."date_departure" IS \'Дата убытия последнего вагона\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."tracker" IS \'Код отслеживания\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."shop_boxcar_departure_station_id" IS \'ID Станция отправления\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."shop_boxcar_client_id" IS \'ID поставщик\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."contract_number" IS \'Номер договора\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."contract_date" IS \'Дата договора\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."date_drain_from" IS \'Дата начала слива первого вагона\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."date_drain_to" IS \'Дата окончания слива последнего вагона\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."shop_boxcar_factory_id" IS \'ID завода изготовителя\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."downtime_permitted" IS \'Допустимое время простоя (час)\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."is_exit" IS \'Выехал последний вагон\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."fine_day" IS \'Штраф за день\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."boxcars" IS \'Номера вагонов\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."shop_client_id" IS \'ID клиента, для которого была поставка\';
                COMMENT ON COLUMN "public"."ab_shop_boxcar_trains"."shop_client_contract_id" IS \'ID договора\';
                COMMENT ON TABLE "public"."ab_shop_boxcar_trains" IS \'Материалы вагонами\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_boxcar_trains
                -- ----------------------------
                CREATE INDEX "shop_boxcar_trian_index_id" ON "public"."ab_shop_boxcar_trains" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_boxcar_trian_index_order" ON "public"."ab_shop_boxcar_trains" USING btree (
                  "order" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_boxcar_trian_name_like" ON "public"."ab_shop_boxcar_trains" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_boxcar_trian_shop_boxcar_client_id" ON "public"."ab_shop_boxcar_trains" USING btree (
                  "shop_boxcar_client_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_boxcar_trian_shop_boxcar_departure_station_id" ON "public"."ab_shop_boxcar_trains" USING btree (
                  "shop_boxcar_departure_station_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_boxcar_trian_shop_client_contract_id" ON "public"."ab_shop_boxcar_trains" USING btree (
                  "shop_client_contract_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_boxcar_trian_shop_client_id" ON "public"."ab_shop_boxcar_trains" USING btree (
                  "shop_client_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_boxcar_trian_shop_raw_id" ON "public"."ab_shop_boxcar_trains" USING btree (
                  "shop_raw_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество',
        ),
        'date_shipment' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Планируемая дата отгрузки',
        ),
        'date_departure' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата убытия последнего вагона',
        ),
        'tracker' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Код отслеживания',
        ),
        'shop_boxcar_departure_station_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID Станция отправления',
            'table' => 'DB_Ab1_Shop_Boxcar_Departure_Station',
        ),
        'shop_boxcar_client_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID поставщик',
            'table' => 'DB_Ab1_Shop_Client',
        ),
        'contract_number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер договора',
        ),
        'contract_date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата договора',
        ),
        'date_drain_from' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата начала слива первого вагона',
        ),
        'date_drain_to' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата окончания слива последнего вагона',
        ),
        'shop_boxcar_factory_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID завода изготовителя',
            'table' => 'DB_Ab1_Shop_Boxcar_Factory',
        ),
        'downtime_permitted' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 9,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Допустимое время простоя (час)',
        ),
        'is_exit' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Выехал последний вагон',
        ),
        'fine_day' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Штраф за день',
        ),
        'boxcars' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номера вагонов',
        ),
        'shop_client_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID клиента, для которого была поставка',
            'table' => 'DB_Ab1_Shop_Client',
        ),
        'shop_client_contract_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID договора',
            'table' => 'DB_Ab1_Shop_Client_Contract',
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
