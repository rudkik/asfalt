<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Boxcar {
    const TABLE_NAME = 'ab_shop_boxcars';
    const TABLE_ID = 207;
    const NAME = 'DB_Ab1_Shop_Boxcar';
    const TITLE = 'Погрузка вагонов';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_boxcars";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_boxcars
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_boxcars" (
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
                  "date_drain_from" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "date_drain_to" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "date_departure" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "number" varchar(64) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 0,
                  "tracker" varchar(64) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 0,
                  "date_arrival" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "shop_boxcar_departure_station_id" int8 NOT NULL DEFAULT 0,
                  "shop_boxcar_client_id" int8 NOT NULL DEFAULT 0,
                  "contract_number" varchar(64) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "contract_date" date DEFAULT NULL::timestamp without time zone,
                  "place_of_departure" varchar(255) COLLATE "pg_catalog"."default",
                  "shop_boxcar_train_id" int8 NOT NULL DEFAULT 0,
                  "stamp" varchar(64) COLLATE "pg_catalog"."default",
                  "is_exit" numeric(1) NOT NULL DEFAULT 0,
                  "sending" varchar(64) COLLATE "pg_catalog"."default",
                  "shop_client_id" int8 NOT NULL DEFAULT 0,
                  "drain_from_shop_operation_id_1" int8 NOT NULL DEFAULT 0,
                  "drain_to_shop_operation_id_1" int8 NOT NULL DEFAULT 0,
                  "drain_text" text COLLATE "pg_catalog"."default",
                  "residue" float8 DEFAULT 0,
                  "drain_zhdc_from_shop_operation_id" int8 NOT NULL DEFAULT 0,
                  "drain_zhdc_to_shop_operation_id" int8 NOT NULL DEFAULT 0,
                  "zhdc_shop_operation_id" int8 NOT NULL DEFAULT 0,
                  "shop_client_contract_id" int8 NOT NULL DEFAULT 0,
                  "drain_from_shop_operation_id_2" int8 NOT NULL DEFAULT 0,
                  "drain_to_shop_operation_id_2" int8 NOT NULL DEFAULT 0,
                  "brigadier_drain_from_shop_operation_id" int8 NOT NULL DEFAULT 0,
                  "brigadier_drain_to_shop_operation_id" int8 NOT NULL DEFAULT 0,
                  "shop_raw_drain_chute_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."shop_raw_id" IS \'ID сырья\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."quantity" IS \'Количество\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."date_shipment" IS \'Дата отгрузки\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."date_drain_from" IS \'Дата начала слива\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."date_drain_to" IS \'Дата окончания слива\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."date_departure" IS \'Дата убытия\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."number" IS \'№ вагона\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."tracker" IS \'Код отслеживания\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."date_arrival" IS \'Дата прибытия\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."shop_boxcar_departure_station_id" IS \'ID Станция отправления\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."shop_boxcar_client_id" IS \'ID поставщик\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."contract_number" IS \'Номер договора\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."contract_date" IS \'Дата договора\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."shop_boxcar_train_id" IS \'ID поезда\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."stamp" IS \'№ пломбы\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."is_exit" IS \'Выехал вагон\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."sending" IS \'№ отправки\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."shop_client_id" IS \'ID клиента, для которого была поставка\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."drain_from_shop_operation_id_1" IS \'ID оператора начавшего разгрузку\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."drain_to_shop_operation_id_1" IS \'ID оператора окончевшего разгрузку\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."drain_text" IS \'Примечание разгрузки\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."residue" IS \'Остаток в цистерне по замеру глубины Метроштоком №135 МШ 4,5 мм\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."drain_zhdc_from_shop_operation_id" IS \'ID Диспетчер ЖДЦ и ДС начавшего разгрузку\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."drain_zhdc_to_shop_operation_id" IS \'ID диспетчера ЖДЦ и ДС окончевшего разгрузку\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."zhdc_shop_operation_id" IS \'ID диспетчера по ж.д документом\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."shop_client_contract_id" IS \'ID договора\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."drain_from_shop_operation_id_2" IS \'ID оператора начавшего разгрузку\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."drain_to_shop_operation_id_2" IS \'ID оператора окончевшего разгрузку\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."brigadier_drain_from_shop_operation_id" IS \'ID бригадир начавшего разгрузку\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."brigadier_drain_to_shop_operation_id" IS \'ID бригадир окончевшего разгрузку\';
                COMMENT ON COLUMN "public"."ab_shop_boxcars"."shop_raw_drain_chute_id" IS \'ID место слива\';
                COMMENT ON TABLE "public"."ab_shop_boxcars" IS \'Погрузка вагонов\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_boxcars
                -- ----------------------------
                CREATE INDEX "shop_boxcar_index_id" ON "public"."ab_shop_boxcars" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_boxcar_index_order" ON "public"."ab_shop_boxcars" USING btree (
                  "order" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_boxcar_name_like" ON "public"."ab_shop_boxcars" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_boxcar_shop_boxcar_client_id" ON "public"."ab_shop_boxcars" USING btree (
                  "shop_boxcar_client_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_boxcar_shop_boxcar_departure_station_id" ON "public"."ab_shop_boxcars" USING btree (
                  "shop_boxcar_departure_station_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_boxcar_shop_boxcar_train_id" ON "public"."ab_shop_boxcars" USING btree (
                  "shop_boxcar_train_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_boxcar_shop_client_id" ON "public"."ab_shop_boxcars" USING btree (
                  "shop_client_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_boxcar_shop_raw_id" ON "public"."ab_shop_boxcars" USING btree (
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
            'title' => 'Дата отгрузки',
        ),
        'date_drain_from' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата начала слива',
        ),
        'date_drain_to' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата окончания слива',
        ),
        'date_departure' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата убытия',
        ),
        'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '№ вагона',
        ),
        'tracker' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Код отслеживания',
        ),
        'date_arrival' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата прибытия',
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
        'place_of_departure' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 255,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => '',
        ),
        'shop_boxcar_train_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID поезда',
            'table' => 'DB_Ab1_Shop_Boxcar_Train',
        ),
        'stamp' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => '№ пломбы',
        ),
        'is_exit' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Выехал вагон',
        ),
        'sending' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => '№ отправки',
        ),
        'shop_client_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID клиента, для которого была поставка',
            'table' => 'DB_Ab1_Shop_Client',
        ),
        'drain_from_shop_operation_id_1' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID оператора начавшего разгрузку',
            'table' => 'DB_Ab1_Shop_Operation',
        ),
        'drain_to_shop_operation_id_1' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID оператора окончевшего разгрузку',
            'table' => 'DB_Ab1_Shop_Operation',
        ),
        'drain_text' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Примечание разгрузки',
        ),
        'residue' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 53,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Остаток в цистерне по замеру глубины Метроштоком №135 МШ 4,5 мм',
        ),
        'drain_zhdc_from_shop_operation_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID Диспетчер ЖДЦ и ДС начавшего разгрузку',
            'table' => 'DB_Ab1_Shop_Operation',
        ),
        'drain_zhdc_to_shop_operation_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID диспетчера ЖДЦ и ДС окончевшего разгрузку',
            'table' => 'DB_Ab1_Shop_Operation',
        ),
        'zhdc_shop_operation_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID диспетчера по ж.д документом',
            'table' => 'DB_Ab1_Shop_Operation',
        ),
        'shop_client_contract_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID договора',
            'table' => 'DB_Ab1_Shop_Client_Contract',
        ),
        'drain_from_shop_operation_id_2' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID оператора начавшего разгрузку',
            'table' => 'DB_Ab1_Shop_Operation',
        ),
        'drain_to_shop_operation_id_2' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID оператора окончевшего разгрузку',
            'table' => 'DB_Ab1_Shop_Operation',
        ),
        'brigadier_drain_from_shop_operation_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID бригадир начавшего разгрузку',
            'table' => 'DB_Ab1_Shop_Operation',
        ),
        'brigadier_drain_to_shop_operation_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID бригадир окончевшего разгрузку',
            'table' => 'DB_Ab1_Shop_Operation',
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
