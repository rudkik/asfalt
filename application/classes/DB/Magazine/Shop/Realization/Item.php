<?php defined('SYSPATH') or die('No direct script access.');

class DB_Magazine_Shop_Realization_Item {
    const TABLE_NAME = 'sp_shop_realization_items';
    const TABLE_ID = 252;
    const NAME = 'DB_Magazine_Shop_Realization_Item';
    const TITLE = 'Реализация продукции';
    const IS_CATALOG = false;

    const INTEGRATIONS = [
        Integration_Ab1_1C_Service::SERVICE_NAME => [],
    ];

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."sp_shop_realization_items";',
            'create' => '
                -- ----------------------------
                -- Table structure for sp_shop_realization_items
                -- ----------------------------
                CREATE TABLE "public"."sp_shop_realization_items" (
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
                  "shop_production_id" int8 NOT NULL DEFAULT 0,
                  "quantity" numeric(12,3) NOT NULL DEFAULT 0,
                  "price" numeric(12,2) NOT NULL DEFAULT 0,
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "shop_realization_id" int8 NOT NULL DEFAULT 0,
                  "shop_card_id" int8 NOT NULL DEFAULT 0,
                  "shop_worker_id" int8 NOT NULL DEFAULT 0,
                  "shop_invoice_id" int8 NOT NULL DEFAULT 0,
                  "is_special" numeric(1) NOT NULL DEFAULT 0,
                  "shop_write_off_type_id" int8 NOT NULL DEFAULT 0,
                  "shop_realization_return_id" int8 NOT NULL DEFAULT 0,
                  "is_return" numeric(1) NOT NULL DEFAULT 0,
                  "esf_receive_quantity" numeric(12,3) NOT NULL DEFAULT 0,
                  "is_esf" numeric(1) NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."shop_production_id" IS \'ID продукции\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."quantity" IS \'Количество\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."price" IS \'Цена\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."shop_realization_id" IS \'ID реализации\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."shop_card_id" IS \'ID карты\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."shop_worker_id" IS \'ID работника\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."shop_invoice_id" IS \'ID счет-фактуры\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."is_special" IS \'Спецзаказ (молока)\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."shop_write_off_type_id" IS \'ID места списания\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."shop_realization_return_id" IS \'ID возврата реализации\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."is_return" IS \'Возвращен ли товар?\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."esf_receive_quantity" IS \'Количество распределенное по ЭСФ приемки\';
                COMMENT ON COLUMN "public"."sp_shop_realization_items"."is_esf" IS \'Есть сверка с ЭСФ\';
                COMMENT ON TABLE "public"."sp_shop_realization_items" IS \'Список реализации продукции\';
                
                -- ----------------------------
                -- Indexes structure for table sp_shop_realization_items
                -- ----------------------------
                CREATE INDEX "sp_shop_realization_item_first" ON "public"."sp_shop_realization_items" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_realization_item_full_name" ON "public"."sp_shop_realization_items" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name::text), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "sp_shop_realization_item_index_id" ON "public"."sp_shop_realization_items" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_realization_item_name_like" ON "public"."sp_shop_realization_items" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_realization_item_old_id" ON "public"."sp_shop_realization_items" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_realization_item_shop_card_id" ON "public"."sp_shop_realization_items" USING btree (
                  "shop_card_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_realization_item_shop_invoice_id" ON "public"."sp_shop_realization_items" USING btree (
                  "shop_invoice_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_realization_item_shop_production_id" ON "public"."sp_shop_realization_items" USING btree (
                  "shop_production_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_realization_item_shop_realization_id" ON "public"."sp_shop_realization_items" USING btree (
                  "shop_realization_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_realization_item_shop_realization_return_id" ON "public"."sp_shop_realization_items" USING btree (
                  "shop_realization_return_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_realization_item_shop_worker_id" ON "public"."sp_shop_realization_items" USING btree (
                  "shop_worker_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_relization_item_created_at" ON "public"."sp_shop_realization_items" USING btree (
                  "created_at" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_relization_item_is_return" ON "public"."sp_shop_realization_items" USING btree (
                  "is_return" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_relization_item_is_special" ON "public"."sp_shop_realization_items" USING btree (
                  "is_special" "pg_catalog"."numeric_ops" ASC NULLS LAST
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
        'shop_production_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID продукции',
            'table' => 'DB_Magazine_Shop_Production',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'item_guid' => ['id', 'shop_product_id.id'],
                    'item_guid_1c' => ['guid_1c', 'shop_product_id.guid_1c'],
                    'item_name' => ['name', 'shop_product_id.name'],
                ]
            ],
        ),
        'quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'number',
            ],
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
        ),
        'shop_realization_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID реализации',
            'table' => 'DB_Magazine_Shop_Realization',
        ),
        'shop_card_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID карты',
            'table' => 'DB_Magazine_Shop_Card',
        ),
        'shop_worker_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID работника',
            'table' => 'DB_Ab1_Shop_Worker',
        ),
        'shop_invoice_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID счет-фактуры',
            'table' => 'DB_Magazine_Shop_Invoice',
        ),
        'is_special' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Спецзаказ (молока)',
        ),
        'shop_write_off_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID места списания',
            'table' => 'DB_Magazine_Shop_WriteOff_Type',
        ),
        'shop_realization_return_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID возврата реализации',
            'table' => 'DB_Magazine_Shop_Realization_Return',
        ),
        'is_return' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Возвращен ли товар?',
        ),
        'esf_receive_quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество распределенное по ЭСФ приемки',
        ),
        'is_esf' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Есть сверка с ЭСФ',
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