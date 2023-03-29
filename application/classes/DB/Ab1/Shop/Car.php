<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Car {
    const TABLE_NAME = 'ab_shop_cars';
    const TABLE_ID = 60;
    const NAME = 'DB_Ab1_Shop_Car';
    const TITLE = 'Реализации через весовую';
    const IS_CATALOG = false;

    const INTEGRATIONS = [
        Integration_Ab1_1C_Service::SERVICE_NAME => [
            'default' => [
                'nds' => 12,
            ],
        ],
    ];

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_cars";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_cars
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_cars" (
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
                  "shop_payment_id" int8 NOT NULL DEFAULT 0,
                  "shop_turn_place_id" int8 NOT NULL DEFAULT 0,
                  "tarra" numeric(12,3) NOT NULL DEFAULT 0,
                  "is_balance" numeric(1) NOT NULL DEFAULT 0,
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
                  "shop_client_contract_id" int8 NOT NULL DEFAULT 0,
                  "root_id" int8 NOT NULL DEFAULT 0,
                  "is_charity" numeric(1) NOT NULL DEFAULT 0,
                  "is_one_attorney" numeric(1) NOT NULL DEFAULT 1,
                  "is_invoice" numeric(1) NOT NULL DEFAULT 0,
                  "shop_act_service_id" int8 NOT NULL DEFAULT 0,
                  "is_invoice_print" numeric(1) NOT NULL DEFAULT 0,
                  "delivery_shop_client_attorney_id" int8 NOT NULL DEFAULT 0,
                  "delivery_shop_client_contract_id" int8 NOT NULL DEFAULT 0,
                  "quantity_service" numeric(12,3) NOT NULL DEFAULT 0,
                  "amount_service" numeric(12,2) NOT NULL DEFAULT 0,
                  "shop_move_client_id" int8 NOT NULL DEFAULT 86434,
                  "shop_storage_id" int8 NOT NULL DEFAULT 0,
                  "shop_subdivision_id" int8 NOT NULL DEFAULT 0,
                  "shop_heap_id" int8 NOT NULL DEFAULT 0,
                  "shop_formula_product_id" int8 NOT NULL DEFAULT 0,
                  "shop_client_balance_day_id" int8 NOT NULL DEFAULT 0,
                  "shop_transport_id" int8,
                  "shop_transport_waybill_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_cars"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_cars"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."shop_client_id" IS \'ID клиентa\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."shop_product_id" IS \'ID продукта\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."quantity" IS \'Количество\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."shop_driver_id" IS \'ID водителя\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."price" IS \'Цена\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."is_debt" IS \'Отпустить в долг\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."exit_at" IS \'Время выезда\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."arrival_at" IS \'Время заезда\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."is_exit" IS \'Выехала ли машина\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."shop_turn_id" IS \'ID очереди\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."asu_operation_id" IS \'Оператор АСУ\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."asu_at" IS \'Дата обработки АСУ\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."weighted_entry_operation_id" IS \'Оператор Весовая въезд\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."weighted_entry_at" IS \'Дата обработки Весовая въезд\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."weighted_exit_operation_id" IS \'Оператор Весовая выезд\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."weighted_exit_at" IS \'Дата обработки Весовая выезд\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."cash_operation_id" IS \'Оператор АСУ\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."cash_at" IS \'Дата обработки АСУ\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."number" IS \'Номер счета\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."shop_payment_id" IS \'ID оплаты\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."shop_turn_place_id" IS \'ID места\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."tarra" IS \'Вес тары\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."is_balance" IS \'Проверять оплату по балансу\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."packed_count" IS \'Кол-во упаковок\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."packed_quantity" IS \'Вес упаковок\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."ticket" IS \'Номер талона клиента\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."is_test" IS \'Вес загружается вручную\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."shop_delivery_id" IS \'ID доставки\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."delivery_km" IS \'Расстояние доставки\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."delivery_amount" IS \'Стоимость доставки\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."spill" IS \'Сколько просыпал\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."delivery_quantity" IS \'Вес для доставки\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."shop_client_contract_id" IS \'ID договора\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."root_id" IS \'ID главной записи, используется при разбиении\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."is_charity" IS \'Благотворительство\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."is_one_attorney" IS \'Одна ли доверенность\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."is_invoice" IS \'Сформирована накладная\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."shop_act_service_id" IS \'ID акта выполненных работ\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."is_invoice_print" IS \'Нужно ли печатать накладную\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."delivery_shop_client_attorney_id" IS \'ID доверенности доставки\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."delivery_shop_client_contract_id" IS \'ID договора доставки\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."quantity_service" IS \'Количество дополнительных услуг\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."amount_service" IS \'Сумма дополнительных услуг\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."shop_move_client_id" IS \'ID склада откуда произошла реализация\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."shop_storage_id" IS \'ID склад (реализация со склада)\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."shop_subdivision_id" IS \'ID подразделения откуда произошла реализация\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."shop_heap_id" IS \'ID места забора материала\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."shop_formula_product_id" IS \'ID рецепта продукции (для списания материала)\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."shop_client_balance_day_id" IS \'ID баланса фиксации цены продукции (для клиентов внесших предоплату)\';
                COMMENT ON COLUMN "public"."ab_shop_cars"."shop_transport_id" IS \'ID транспорта АТЦ \';
                COMMENT ON COLUMN "public"."ab_shop_cars"."shop_transport_waybill_id" IS \'ID путевого листа\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_cars
                -- ----------------------------
                CREATE INDEX "ab_shop_car_asu_operation_id" ON "public"."ab_shop_cars" USING btree (
                  "asu_operation_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_created_at" ON "public"."ab_shop_cars" USING btree (
                  "created_at" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_delivery_shop_client_attorney_id" ON "public"."ab_shop_cars" USING btree (
                  "delivery_shop_client_attorney_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_delivery_shop_client_contract_id" ON "public"."ab_shop_cars" USING btree (
                  "delivery_shop_client_contract_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_exit_at" ON "public"."ab_shop_cars" USING btree (
                  "exit_at" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_first" ON "public"."ab_shop_cars" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_index_id" ON "public"."ab_shop_cars" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_is_exit" ON "public"."ab_shop_cars" USING btree (
                  "is_exit" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_shop_client_attorney_id" ON "public"."ab_shop_cars" USING btree (
                  "shop_client_attorney_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_shop_client_balance_day_id" ON "public"."ab_shop_cars" USING btree (
                  "shop_client_balance_day_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_shop_client_contract_id" ON "public"."ab_shop_cars" USING btree (
                  "shop_client_contract_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_shop_client_id" ON "public"."ab_shop_cars" USING btree (
                  "shop_client_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_shop_delivery_id" ON "public"."ab_shop_cars" USING btree (
                  "shop_delivery_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_shop_formula_product_id" ON "public"."ab_shop_cars" USING btree (
                  "shop_formula_product_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_shop_heap_id" ON "public"."ab_shop_cars" USING btree (
                  "shop_heap_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_shop_payment_id" ON "public"."ab_shop_cars" USING btree (
                  "shop_payment_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_shop_storage_id" ON "public"."ab_shop_cars" USING btree (
                  "shop_storage_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_shop_subdivision_id" ON "public"."ab_shop_cars" USING btree (
                  "shop_subdivision_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_shop_transport_company_id" ON "public"."ab_shop_cars" USING btree (
                  "shop_transport_company_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_shop_transport_id" ON "public"."ab_shop_cars" USING btree (
                  "shop_transport_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_shop_transport_waybill_id" ON "public"."ab_shop_cars" USING btree (
                  "shop_transport_waybill_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_shop_turn_id" ON "public"."ab_shop_cars" USING btree (
                  "shop_turn_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_shop_turn_place_id" ON "public"."ab_shop_cars" USING btree (
                  "shop_turn_place_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_weighted_entry_operation_id" ON "public"."ab_shop_cars" USING btree (
                  "weighted_entry_operation_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_weighted_exit_operation_id" ON "public"."ab_shop_cars" USING btree (
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
        'shop_payment_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID оплаты',
            'table' => 'DB_Ab1_Shop_Payment',
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
        'is_balance' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Проверять оплату по балансу',
        ),
        'is_delivery' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
        ),
        'shop_client_attorney_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => 'DB_Ab1_Shop_Client_Attorney',
            'is_common_items' => true,
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
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'item_har' => 'old_id',
                    'item_guid' => 'shop_product_id.old_id',
                    'item_guid_1c' => 'shop_product_id.guid_1c',
                ]
            ],
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
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'row_sum',
            ],
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
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'number',
            ],
        ),
        'shop_client_contract_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID договора',
            'table' => 'DB_Ab1_Shop_Client_Contract',
            'is_common_items' => true,
        ),
        'root_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID главной записи, используется при разбиении',
        ),
        'is_charity' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Благотворительство',
        ),
        'is_one_attorney' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Одна ли доверенность',
        ),
        'is_invoice' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Сформирована накладная',
        ),
        'shop_act_service_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID акта выполненных работ',
            'table' => 'DB_Ab1_Shop_Act_Service',
            'is_common_items' => true,
        ),
        'is_invoice_print' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Нужно ли печатать накладную',
        ),
        'delivery_shop_client_attorney_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID доверенности доставки',
        ),
        'delivery_shop_client_contract_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID договора доставки',
        ),
        'quantity_service' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество дополнительных услуг',
        ),
        'amount_service' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма дополнительных услуг',
        ),
        'shop_move_client_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID склада откуда произошла реализация',
            'table' => 'DB_Ab1_Shop_Move_Client',
            'is_common_items' => true,
        ),
        'shop_storage_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID склад (реализация со склада)',
            'table' => 'DB_Ab1_Shop_Storage',
            'is_common_items' => true,
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
        'shop_client_balance_day_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID баланса фиксации цены продукции (для клиентов внесших предоплату)',
            'table' => 'DB_Ab1_Shop_Client_Balance_Day',
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
        'shop_car_items' => array(
            'table' => 'DB_Ab1_Shop_Car_Item',
            'field_id' => 'shop_car_id',
            'is_view' => true,
        ),
        'shop_addition_service_items' => array(
            'table' => 'DB_Ab1_Shop_Addition_Service_Item',
            'field_id' => 'shop_addition_service_id',
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