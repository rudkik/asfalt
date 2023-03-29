<?php defined('SYSPATH') or die('No direct script access.');

class DB_Magazine_Shop_Product {
    const TABLE_NAME = 'sp_shop_products';
    const TABLE_ID = 243;
    const NAME = 'DB_Magazine_Shop_Product';
    const TITLE = 'Продукты';
    const IS_CATALOG = true;

    const INTEGRATIONS = [
        Integration_Ab1_1C_Service::SERVICE_NAME => [
            'type' => 'item',
            'guid' => ['system' => 'id', '1c' => 'guid'],
            'guid_1c' => ['system' => 'guid_1c', '1c' => 'guid_1c'],
            'default' => [
                'ver' => 'mag',
                'kind' => 1,
                'service' => 0,
                'nds' => 12,
            ]
        ],
    ];

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."sp_shop_products";',
            'create' => '
                -- ----------------------------
                -- Table structure for sp_shop_products
                -- ----------------------------
                CREATE TABLE "public"."sp_shop_products" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "text" text COLLATE "pg_catalog"."default",
                  "image_path" varchar(255) COLLATE "pg_catalog"."default",
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
                  "name_1c" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "name_site" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "shop_product_rubric_id" int8 NOT NULL DEFAULT 0,
                  "unit_id" int8 NOT NULL DEFAULT 0,
                  "barcode" varchar(20) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "price_purchase" numeric(12,2) NOT NULL DEFAULT 0,
                  "price_cost" numeric(12,2) NOT NULL DEFAULT 0,
                  "name_esf" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "coefficient_revise" float8 NOT NULL DEFAULT 1,
                  "price_cost_without_nds" numeric(12,2) NOT NULL DEFAULT 0,
                  "price_average" numeric(12,2) NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."sp_shop_products"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."sp_shop_products"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."sp_shop_products"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."sp_shop_products"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."sp_shop_products"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."sp_shop_products"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."sp_shop_products"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."sp_shop_products"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sp_shop_products"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sp_shop_products"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."sp_shop_products"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."sp_shop_products"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."sp_shop_products"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."sp_shop_products"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."sp_shop_products"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."sp_shop_products"."name_1c" IS \'Название в 1C\';
                COMMENT ON COLUMN "public"."sp_shop_products"."name_site" IS \'Название на сайте\';
                COMMENT ON COLUMN "public"."sp_shop_products"."shop_product_rubric_id" IS \'ID рубрики продукта\';
                COMMENT ON COLUMN "public"."sp_shop_products"."unit_id" IS \'ID единиц измерения\';
                COMMENT ON COLUMN "public"."sp_shop_products"."barcode" IS \'Штрих-код\';
                COMMENT ON COLUMN "public"."sp_shop_products"."price_purchase" IS \'Последняя цена приемки продуктов\';
                COMMENT ON COLUMN "public"."sp_shop_products"."price_cost" IS \'Себестоимость\';
                COMMENT ON COLUMN "public"."sp_shop_products"."name_esf" IS \'Название для ЭСФ\';
                COMMENT ON COLUMN "public"."sp_shop_products"."coefficient_revise" IS \'Коэффициент приобразования при ревизии\';
                COMMENT ON COLUMN "public"."sp_shop_products"."price_cost_without_nds" IS \'Себестоимость без НДС\';
                COMMENT ON COLUMN "public"."sp_shop_products"."price_average" IS \'Средняя стоимость продукта (по остатку на начало дня приемки) без НДС\';
                COMMENT ON TABLE "public"."sp_shop_products" IS \'Список продуктов\';
                
                -- ----------------------------
                -- Indexes structure for table sp_shop_products
                -- ----------------------------
                CREATE INDEX "sp_shop_product_barcode" ON "public"."sp_shop_products" USING btree (
                  "barcode" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_product_coefficient_revise" ON "public"."sp_shop_products" USING btree (
                  "coefficient_revise" "pg_catalog"."float8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_product_first" ON "public"."sp_shop_products" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_product_full_name" ON "public"."sp_shop_products" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name::text), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "sp_shop_product_index_id" ON "public"."sp_shop_products" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_product_index_order" ON "public"."sp_shop_products" USING btree (
                  "order" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_product_old_id" ON "public"."sp_shop_products" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_product_shop_product_rubric_id" ON "public"."sp_shop_products" USING btree (
                  "shop_product_rubric_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_product_shop_unit_id" ON "public"."sp_shop_products" USING btree (
                  "unit_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'code',
            ],
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
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'name',
            ],
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
            'length' => 255,
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
        'name_1c' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название в 1C',
        ),
        'name_site' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название на сайте',
        ),
        'shop_product_rubric_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID рубрики продукта',
            'table' => 'DB_Magazine_Shop_Product_Rubric',
        ),
        'unit_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID единиц измерения',
            'table' => 'DB_Magazine_Unit',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'unit' => 'name',
                    'unitid' => 'code_esf',
                ]
            ],
        ),
        'barcode' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 20,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Штрих-код',
        ),
        'price_purchase' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Последняя цена приемки продуктов',
        ),
        'price_cost' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Себестоимость',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'price',
            ],
        ),
        'name_esf' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название для ЭСФ',
        ),
        'coefficient_revise' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 20,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Коэффициент приобразования при ревизии',
        ),
        'price_cost_without_nds' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Себестоимость без НДС',
        ),
        'price_average' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Средняя стоимость продукта (по остатку на начало дня приемки) без НДС',
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