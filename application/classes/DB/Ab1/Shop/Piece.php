<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Piece {
    const TABLE_NAME = 'ab_shop_pieces';
    const TABLE_ID = 95;
    const NAME = 'DB_Ab1_Shop_Piece';
    const TITLE = 'Реализация ЖБИ и БС';
    const IS_CATALOG = false;

    const INTEGRATIONS = [
        Integration_Ab1_1C_Service::SERVICE_NAME => [
            'guid' => ['system' => 'id', '1c' => 'item_guid'],
            'guid_1c' => ['system' => 'guid_1c', '1c' => 'item_guid_1c'],
            'default' => [
                'nds' => 12,
                'division' => '',
            ],
        ],
    ];

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_pieces";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_pieces
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_pieces" (
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
                  "number" varchar(64) COLLATE "pg_catalog"."default" NOT NULL DEFAULT \'\'::character varying,
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "is_debt" numeric(1) NOT NULL DEFAULT 0,
                  "shop_payment_id" int8 NOT NULL DEFAULT 0,
                  "is_delivery" numeric(1) NOT NULL DEFAULT 0,
                  "shop_client_attorney_id" int8 NOT NULL DEFAULT 0,
                  "shop_transport_company_id" int8 NOT NULL DEFAULT 0,
                  "ticket" varchar(64) COLLATE "pg_catalog"."default" NOT NULL DEFAULT \'\'::character varying,
                  "is_balance" numeric(1) NOT NULL DEFAULT 0,
                  "shop_driver_id" int8 NOT NULL DEFAULT 0,
                  "cash_operation_id" int8 DEFAULT 0,
                  "shop_delivery_id" int8 NOT NULL DEFAULT 0,
                  "distance" numeric(12,3) NOT NULL DEFAULT 0,
                  "delivery_km" numeric(12,2) NOT NULL DEFAULT 0,
                  "delivery_amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "delivery_quantity" numeric(12,3) NOT NULL DEFAULT 0,
                  "quantity" numeric(12,3) NOT NULL DEFAULT 0,
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
                  "shop_move_client_id" int8 NOT NULL DEFAULT 86436,
                  "shop_subdivision_id" int8 NOT NULL DEFAULT 0,
                  "shop_storage_id" int8 NOT NULL DEFAULT 0,
                  "shop_heap_id" int8 NOT NULL DEFAULT 0,
                  "shop_formula_product_id" int8 NOT NULL DEFAULT 0,
                  "shop_transport_id" int8,
                  "shop_transport_waybill_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_pieces"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."shop_client_id" IS \'ID клиентa\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."number" IS \'Номер счета\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."is_debt" IS \'Отпустить в долг\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."shop_payment_id" IS \'ID оплаты\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."is_delivery" IS \'Доставка\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."shop_client_attorney_id" IS \'ID доверенности\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."ticket" IS \'Номер талона клиента\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."is_balance" IS \'Проверять оплату по балансу\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."shop_driver_id" IS \'ID водителя\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."cash_operation_id" IS \'Оператор АСУ\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."shop_delivery_id" IS \'ID доставки\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."distance" IS \'Расстояние доставки (км)\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."delivery_km" IS \'Расстояние доставки\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."delivery_amount" IS \'Стоимость доставки\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."delivery_quantity" IS \'Вес для доставки\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."quantity" IS \'Количество общее\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."shop_client_contract_id" IS \'ID договора\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."root_id" IS \'ID главной записи, используется при разбиении\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."is_charity" IS \'Благотворительство\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."is_one_attorney" IS \'Одна ли доверенность\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."is_invoice" IS \'Сформирована накладная\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."shop_act_service_id" IS \'ID акта выполненных работ\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."is_invoice_print" IS \'Нужно ли печатать накладную\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."delivery_shop_client_attorney_id" IS \'ID доверенности доставки\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."delivery_shop_client_contract_id" IS \'ID договора доставки\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."quantity_service" IS \'Количество дополнительных услуг\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."amount_service" IS \'Сумма дополнительных услуг\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."shop_move_client_id" IS \'ID склада откуда произошла реализация\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."shop_subdivision_id" IS \'ID подразделения откуда произошла реализация\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."shop_storage_id" IS \'ID склад (реализация со склада)\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."shop_heap_id" IS \'ID места забора материала\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."shop_formula_product_id" IS \'ID рецепта продукции (для списания материала)\';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."shop_transport_id" IS \'ID транспорта АТЦ \';
                COMMENT ON COLUMN "public"."ab_shop_pieces"."shop_transport_waybill_id" IS \'ID путевого листа\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_pieces
                -- ----------------------------
                CREATE INDEX "ab_shop_piece_created_at" ON "public"."ab_shop_pieces" USING btree (
                  "created_at" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_piece_delivery_shop_client_attorney_id" ON "public"."ab_shop_pieces" USING btree (
                  "delivery_shop_client_attorney_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_piece_delivery_shop_client_contract_id" ON "public"."ab_shop_pieces" USING btree (
                  "delivery_shop_client_contract_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_piece_first" ON "public"."ab_shop_pieces" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_piece_index_id" ON "public"."ab_shop_pieces" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_piece_shop_client_attorney_id" ON "public"."ab_shop_pieces" USING btree (
                  "shop_client_attorney_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_piece_shop_client_contract_id" ON "public"."ab_shop_pieces" USING btree (
                  "shop_client_contract_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_piece_shop_client_id" ON "public"."ab_shop_pieces" USING btree (
                  "shop_client_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_piece_shop_delivery_id" ON "public"."ab_shop_pieces" USING btree (
                  "shop_delivery_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_piece_shop_formula_product_id" ON "public"."ab_shop_pieces" USING btree (
                  "shop_formula_product_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_piece_shop_heap_id" ON "public"."ab_shop_pieces" USING btree (
                  "shop_heap_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_piece_shop_payment_id" ON "public"."ab_shop_pieces" USING btree (
                  "shop_payment_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_piece_shop_storage_id" ON "public"."ab_shop_pieces" USING btree (
                  "shop_storage_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_piece_shop_subdivision_id" ON "public"."ab_shop_pieces" USING btree (
                  "shop_subdivision_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_piece_shop_transport_company_id" ON "public"."ab_shop_pieces" USING btree (
                  "shop_transport_company_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_piece_shop_transport_id" ON "public"."ab_shop_pieces" USING btree (
                  "shop_transport_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_piece_shop_transport_waybill_id" ON "public"."ab_shop_pieces" USING btree (
                  "shop_transport_waybill_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'shop_client_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID клиентa',
            'table' => 'DB_Ab1_Shop_Client',
            'is_common_items' => true,
        ),
        'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Номер счета',
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
        'shop_payment_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID оплаты',
            'table' => 'DB_Ab1_Shop_Payment',
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
            'is_common_items' => true,
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
        'is_balance' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Проверять оплату по балансу',
        ),
        'shop_driver_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID водителя',
            'table' => 'DB_Ab1_Shop_Driver',
        ),
        'cash_operation_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Оператор АСУ',
            'table' => 'DB_Shop_Operation',
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
        'distance' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Расстояние доставки (км)',
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
        'quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество общее',
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
            'table' => 'DB_Ab1_Shop_Client_Attorney',
        ),
        'delivery_shop_client_contract_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID договора доставки',
            'table' => 'DB_Ab1_Shop_Client_Contract',
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
        'shop_subdivision_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID подразделения откуда произошла реализация',
            'table' => 'DB_Ab1_Shop_Subdivision',
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
        'shop_piece_items' => array(
            'table' => 'DB_Ab1_Shop_Piece_Item',
            'field_id' => 'shop_piece_id',
            'is_view' => true,
        ),
        'shop_addition_service_items' => array(
            'table' => 'DB_Ab1_Shop_Addition_Service_Item',
            'field_id' => 'shop_addition_service_id',
            'is_view' => true,
        ),
        'shop_transport_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID транспорта АТЦ',
            'table' => 'DB_Ab1_Shop_Transport',
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