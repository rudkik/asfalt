<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Client_Contract_Item {
    const TABLE_NAME = 'ab_shop_client_contract_items';
    const TABLE_ID = 225;
    const NAME = 'DB_Ab1_Shop_Client_Contract_Item';
    const TITLE = 'Продукция договоров';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_client_contract_items";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_client_contract_items
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_client_contract_items" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "name" text COLLATE "pg_catalog"."default",
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
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "price" numeric(12,2) NOT NULL DEFAULT 0,
                  "quantity" numeric(12,3) NOT NULL DEFAULT 0,
                  "shop_client_contract_id" int8 NOT NULL DEFAULT 0,
                  "shop_product_id" int8 NOT NULL DEFAULT 0,
                  "shop_product_rubric_id" int8 NOT NULL DEFAULT 0,
                  "discount" numeric(12,2) NOT NULL DEFAULT 0,
                  "is_discount_amount" numeric(1) NOT NULL DEFAULT 1,
                  "block_amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "balance_amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "agreement_number" varchar(20) COLLATE "pg_catalog"."default",
                  "is_fixed_price" numeric(1) NOT NULL DEFAULT 0,
                  "from_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "product_shop_branch_id" int8 NOT NULL DEFAULT 0,
                  "unit" text COLLATE "pg_catalog"."default",
                  "shop_material_id" int8 NOT NULL DEFAULT 0,
                  "shop_raw_id" int8 NOT NULL DEFAULT 0,
                  "shop_client_id" int8 NOT NULL DEFAULT 0,
                  "basic_shop_client_contract_id" int8 NOT NULL DEFAULT 0,
                  "is_add_basic_contract" numeric(1) NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."price" IS \'Цена\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."quantity" IS \'Кол-во\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."shop_client_contract_id" IS \'ID договора\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."shop_product_id" IS \'ID продукции\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."shop_product_rubric_id" IS \'ID рубрики продукции\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."discount" IS \'Скидка\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."is_discount_amount" IS \'Скидка в валюте\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."block_amount" IS \'Сумма истраченная\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."balance_amount" IS \'Сумма остатка\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."agreement_number" IS \'Номер дополнительного соглашения (откуда взялась строчка)\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."is_fixed_price" IS \'Фиксированная цена для продукции\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."from_at" IS \'Дата старта скидки\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."product_shop_branch_id" IS \'ID филиала продукции\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."unit" IS \'Единица измерения\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."shop_material_id" IS \'ID материала\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."shop_raw_id" IS \'ID сырья\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."shop_client_id" IS \'ID клиента\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."basic_shop_client_contract_id" IS \'ID основного договора\';
                COMMENT ON COLUMN "public"."ab_shop_client_contract_items"."is_add_basic_contract" IS \'Позиция доп.соглашения увеличивает сумму договора\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_client_contract_items
                -- ----------------------------
                CREATE INDEX "ab_shop_client_contract_item_basic_shop_client_contract_id" ON "public"."ab_shop_client_contract_items" USING btree (
                  "basic_shop_client_contract_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_item_first" ON "public"."ab_shop_client_contract_items" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_item_from_at" ON "public"."ab_shop_client_contract_items" USING btree (
                  "from_at" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_item_full_name" ON "public"."ab_shop_client_contract_items" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "ab_shop_client_contract_item_index_id" ON "public"."ab_shop_client_contract_items" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_item_index_order" ON "public"."ab_shop_client_contract_items" USING btree (
                  "order" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_item_is_add_basic_contract" ON "public"."ab_shop_client_contract_items" USING btree (
                  "is_add_basic_contract" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_item_is_fixed_price" ON "public"."ab_shop_client_contract_items" USING btree (
                  "is_fixed_price" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_item_name_like" ON "public"."ab_shop_client_contract_items" USING btree (
                  lower(name) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_item_old_id" ON "public"."ab_shop_client_contract_items" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_item_shop_client_attorney_id" ON "public"."ab_shop_client_contract_items" USING btree (
                  "shop_client_contract_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_item_shop_client_id" ON "public"."ab_shop_client_contract_items" USING btree (
                  "shop_client_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_item_shop_material_id" ON "public"."ab_shop_client_contract_items" USING btree (
                  "shop_material_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_item_shop_product_id" ON "public"."ab_shop_client_contract_items" USING btree (
                  "shop_product_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_item_shop_product_rubric_id" ON "public"."ab_shop_client_contract_items" USING btree (
                  "shop_product_rubric_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_client_contract_item_shop_raw_id" ON "public"."ab_shop_client_contract_items" USING btree (
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
            'length' => 0,
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
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма',
        ),
        'price' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена',
        ),
        'quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Кол-во',
        ),
        'shop_client_contract_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID договора',
            'table' => 'DB_Ab1_Shop_Client_Contract',
        ),
        'shop_product_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID продукции',
            'table' => 'DB_Ab1_Shop_Product',
        ),
        'shop_product_rubric_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID рубрики продукции',
            'table' => 'DB_Ab1_Shop_Product_Rubric',
        ),
        'discount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Скидка',
        ),
        'is_discount_amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Скидка в валюте',
        ),
        'block_amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма истраченная',
        ),
        'balance_amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма остатка',
        ),
        'agreement_number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 20,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер дополнительного соглашения (откуда взялась строчка)',
        ),
        'is_fixed_price' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Фиксированная цена для продукции',
        ),
        'from_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата старта скидки',
        ),
        'product_shop_branch_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID филиала продукции',
            'table' => 'DB_Shop',
        ),
        'unit' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Единица измерения',
        ),
        'shop_material_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID материала',
            'table' => 'DB_Ab1_Shop_Material',
        ),
        'shop_raw_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID сырья',
            'table' => 'DB_Ab1_Shop_Raw',
        ),
        'shop_client_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID клиента',
            'table' => 'DB_Ab1_Shop_Client',
        ),
        'basic_shop_client_contract_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID основного договора',
            'table' => 'DB_Ab1_Shop_Client_Contract',
        ),
        'is_add_basic_contract' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Позиция доп.соглашения увеличивает сумму договора',
        ),
        'fuel_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID топлива',
            'table' => 'DB_Ab1_Fuel',
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
