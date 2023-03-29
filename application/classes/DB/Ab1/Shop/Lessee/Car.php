<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Lessee_Car {
    const TABLE_NAME = 'ab_shop_lessee_cars';
    const TABLE_ID = 313;
    const NAME = 'DB_Ab1_Shop_Lessee_Car';
    const TITLE = 'Машины арендаторов';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_lessee_cars";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_lessee_cars
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_lessee_cars" (
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
                  "shop_client_id" int8 NOT NULL DEFAULT 0,
                  "shop_product_id" int8 NOT NULL DEFAULT 0,
                  "quantity" numeric(12,3) NOT NULL DEFAULT 0,
                  "shop_driver_id" int8 NOT NULL DEFAULT 0,
                  "price" numeric(12,2) NOT NULL DEFAULT 0,
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "is_debt" numeric(1) NOT NULL DEFAULT 0,
                  "exit_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "arrival_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_exit" numeric(1) NOT NULL DEFAULT 0,
                  "shop_turn_id" int8 NOT NULL DEFAULT 1,
                  "asu_operation_id" int8 DEFAULT 0,
                  "asu_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "weighted_entry_operation_id" int8 DEFAULT 0,
                  "weighted_entry_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "weighted_exit_operation_id" int8 DEFAULT 0,
                  "weighted_exit_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "cash_operation_id" int8 DEFAULT 0,
                  "cash_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "number" varchar(64) COLLATE "pg_catalog"."default" NOT NULL DEFAULT \'\'::character varying,
                  "shop_turn_place_id" int8 NOT NULL DEFAULT 0,
                  "tarra" numeric(12,3) NOT NULL DEFAULT 0,
                  "is_delivery" numeric(1) NOT NULL DEFAULT 0,
                  "shop_client_attorney_id" int8 NOT NULL DEFAULT 0,
                  "packed_count" int8 NOT NULL DEFAULT 0,
                  "packed_quantity" numeric(12,5) NOT NULL DEFAULT 0,
                  "shop_transport_company_id" int8 NOT NULL DEFAULT 0,
                  "ticket" varchar(64) COLLATE "pg_catalog"."default" NOT NULL DEFAULT \'\'::character varying,
                  "is_test" numeric(1) NOT NULL DEFAULT 0,
                  "shop_delivery_id" int8 NOT NULL DEFAULT 0,
                  "delivery_km" numeric(12,2) NOT NULL DEFAULT 0,
                  "delivery_amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "spill" numeric(12,2) NOT NULL DEFAULT 0,
                  "delivery_quantity" numeric(12,3) NOT NULL DEFAULT 0,
                  "shop_storage_id" int8 NOT NULL DEFAULT 0,
                  "shop_subdivision_id" int8 NOT NULL DEFAULT 0,
                  "shop_heap_id" int8 NOT NULL DEFAULT 0,
                  "shop_formula_product_id" int8 NOT NULL DEFAULT 0,
                  "shop_transport_id" int8,
                  "shop_transport_waybill_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."shop_client_id" IS \'ID клиентa\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."shop_product_id" IS \'ID продукта\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."quantity" IS \'Количество\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."shop_driver_id" IS \'ID водителя\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."price" IS \'Цена\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."is_debt" IS \'Отпустить в долг\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."exit_at" IS \'Время выезда\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."arrival_at" IS \'Время заезда\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."is_exit" IS \'Выехала ли машина\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."shop_turn_id" IS \'ID очереди\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."asu_operation_id" IS \'Оператор АСУ\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."asu_at" IS \'Дата обработки АСУ\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."weighted_entry_operation_id" IS \'Оператор Весовая въезд\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."weighted_entry_at" IS \'Дата обработки Весовая въезд\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."weighted_exit_operation_id" IS \'Оператор Весовая выезд\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."weighted_exit_at" IS \'Дата обработки Весовая выезд\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."cash_operation_id" IS \'Оператор АСУ\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."cash_at" IS \'Дата обработки АСУ\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."number" IS \'Номер счета\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."shop_turn_place_id" IS \'ID места\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."tarra" IS \'Вес тары\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."is_delivery" IS \'Доставка\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."shop_client_attorney_id" IS \'ID доверенности\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."packed_count" IS \'Кол-во упаковок\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."packed_quantity" IS \'Вес упаковок\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."ticket" IS \'Номер талона клиента\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."is_test" IS \'Вес загружается вручную\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."shop_delivery_id" IS \'ID доставки\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."delivery_km" IS \'Расстояние доставки\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."delivery_amount" IS \'Стоимость доставки\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."spill" IS \'Сколько просыпал\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."delivery_quantity" IS \'Вес для доставки\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."shop_storage_id" IS \'ID склад (реализация со склада)\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."shop_subdivision_id" IS \'ID подразделения откуда произошла реализация\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."shop_heap_id" IS \'ID места забора материала\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."shop_formula_product_id" IS \'ID рецепта продукции (для списания материала)\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."shop_transport_id" IS \'ID транспорта АТЦ \';
                COMMENT ON COLUMN "public"."ab_shop_lessee_cars"."shop_transport_waybill_id" IS \'ID путевого листа\';
                COMMENT ON TABLE "public"."ab_shop_lessee_cars" IS \'Список машин арендаторов\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_lessee_cars
                -- ----------------------------
                CREATE INDEX "ab_shop_lessee_car_asu_operation_id" ON "public"."ab_shop_lessee_cars" USING btree (
                  "asu_operation_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_lessee_car_first" ON "public"."ab_shop_lessee_cars" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_lessee_car_is_exit" ON "public"."ab_shop_lessee_cars" USING btree (
                  "is_exit" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_lessee_car_shop_client_id" ON "public"."ab_shop_lessee_cars" USING btree (
                  "shop_client_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_lessee_car_shop_transport_id" ON "public"."ab_shop_lessee_cars" USING btree (
                  "shop_transport_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_lessee_car_shop_transport_waybill_id" ON "public"."ab_shop_lessee_cars" USING btree (
                  "shop_transport_waybill_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_lessee_car_shop_turn_id" ON "public"."ab_shop_lessee_cars" USING btree (
                  "shop_turn_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_lessee_car_shop_turn_place_id" ON "public"."ab_shop_lessee_cars" USING btree (
                  "shop_turn_place_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_lessee_car_weighted_entry_operation_id" ON "public"."ab_shop_lessee_cars" USING btree (
                  "weighted_entry_operation_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_lessee_car_weighted_exit_operation_id" ON "public"."ab_shop_lessee_cars" USING btree (
                  "weighted_exit_operation_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'shop_client_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID клиентa',
            'table' => 'DB_Ab1_Shop_Client',
            'is_common_items' => true,
        ),
        'shop_product_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID продукта',
            'table' => 'DB_Ab1_Shop_Product',
            'is_common_items' => true,
        ),
        'quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество',
        ),
        'shop_driver_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID водителя',
            'table' => 'DB_Ab1_Shop_Driver',
        ),
        'price' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена',
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма',
            'is_total_items' => true,
        ),
        'is_debt' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Отпустить в долг',
        ),
        'exit_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Время выезда',
        ),
        'arrival_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Время заезда',
        ),
        'is_exit' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Выехала ли машина',
        ),
        'shop_turn_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID очереди',
            'table' => 'DB_Ab1_Shop_Turn',
        ),
        'asu_operation_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Оператор АСУ',
            'table' => 'DB_Shop_Operation',
        ),
        'asu_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата обработки АСУ',
        ),
        'weighted_entry_operation_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Оператор Весовая въезд',
            'table' => 'DB_Shop_Operation',
        ),
        'weighted_entry_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата обработки Весовая въезд',
        ),
        'weighted_exit_operation_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Оператор Весовая выезд',
            'table' => 'DB_Shop_Operation',
        ),
        'weighted_exit_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата обработки Весовая выезд',
        ),
        'cash_operation_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Оператор АСУ',
            'table' => 'DB_Shop_Operation',
        ),
        'cash_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата обработки АСУ',
        ),
        'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Номер счета',
        ),
        'shop_turn_place_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID места',
            'table' => 'DB_Ab1_Shop_Turn_Place',
        ),
        'tarra' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Вес тары',
        ),
        'is_delivery' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Доставка',
        ),
        'shop_client_attorney_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID доверенности',
            'table' => 'DB_Ab1_Shop_Client_Attorney',
        ),
        'packed_count' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Кол-во упаковок',
        ),
        'packed_quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 5,
            'is_not_null' => true,
            'title' => 'Вес упаковок',
        ),
        'shop_transport_company_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => 'DB_Ab1_Shop_Transport_Company',
        ),
        'ticket' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Номер талона клиента',
        ),
        'is_test' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Вес загружается вручную',
        ),
        'shop_delivery_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID доставки',
            'table' => 'DB_Ab1_Shop_Delivery',
        ),
        'delivery_km' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Расстояние доставки',
        ),
        'delivery_amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Стоимость доставки',
        ),
        'spill' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сколько просыпал',
        ),
        'delivery_quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Вес для доставки',
        ),
        'shop_storage_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID склад (реализация со склада)',
            'table' => 'DB_Ab1_Shop_Storage',
        ),
        'shop_subdivision_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID подразделения откуда произошла реализация',
            'table' => 'DB_Ab1_Shop_Subdivision',
            'is_common_items' => true,
        ),
        'shop_heap_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID места забора материала',
            'table' => 'DB_Ab1_Shop_Heap',
            'is_common_items' => true,
        ),
        'shop_formula_product_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID рецепта продукции (для списания материала)',
            'table' => 'DB_Ab1_Shop_Formula_Product',
            'is_common_items' => true,
        ),
        'shop_transport_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID транспорта АТЦ',
            'table' => 'DB_Ab1_Shop_Transport',
        ),
        'shop_transport_waybill_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID путевого листа',
            'table' => 'DB_Ab1_Shop_Transport_Waybill',
        ),
    );

    // список связанных таблиц 1коМногим
    const ITEMS = array(
        'shop_lessee_car_items' => array(
            'table' => 'DB_Ab1_Shop_Lessee_Car_Item',
            'field_id' => 'shop_lessee_car_id',
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
