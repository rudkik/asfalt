<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Formula_Product {
    const TABLE_NAME = 'ab_shop_formula_products';
    const TABLE_ID = 199;
    const NAME = 'DB_Ab1_Shop_Formula_Product';
    const TITLE = 'Рецепт производства материала из сырья';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_formula_products";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_formula_products
                -- ----------------------------
                DROP TABLE IF EXISTS "public"."ab_shop_formula_products";
                CREATE TABLE "public"."ab_shop_formula_products" (
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
                  "shop_product_id" int8 NOT NULL DEFAULT 0,
                  "contract_number" varchar(64) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "contract_date" date DEFAULT NULL::timestamp without time zone,
                  "formula_type_id" int8 NOT NULL DEFAULT 99,
                  "is_start" numeric(1) NOT NULL DEFAULT 1,
                  "from_at" date,
                  "to_at" date
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_formula_products"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_formula_products"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_formula_products"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."ab_shop_formula_products"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_formula_products"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_formula_products"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_formula_products"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_formula_products"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_formula_products"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_formula_products"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_formula_products"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_formula_products"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_formula_products"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_formula_products"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_formula_products"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_formula_products"."shop_product_id" IS \'ID производимого продукции\';
                COMMENT ON COLUMN "public"."ab_shop_formula_products"."contract_number" IS \'Номер приказа\';
                COMMENT ON COLUMN "public"."ab_shop_formula_products"."contract_date" IS \'Дата приказа\';
                COMMENT ON COLUMN "public"."ab_shop_formula_products"."formula_type_id" IS \'ID типа формулы\';
                COMMENT ON COLUMN "public"."ab_shop_formula_products"."is_start" IS \'Используется ли хоть один раз данный рецепт \';
                COMMENT ON COLUMN "public"."ab_shop_formula_products"."from_at" IS \'Дата начала действия рецепта\';
                COMMENT ON COLUMN "public"."ab_shop_formula_products"."to_at" IS \'Дата окончания действия рецепта\';
                COMMENT ON TABLE "public"."ab_shop_formula_products" IS \'Рецеп производства материала из сырья\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_formula_products
                -- ----------------------------
                CREATE INDEX "shop_formula_product_first" ON "public"."ab_shop_formula_products" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_formula_product_from_at" ON "public"."ab_shop_formula_products" USING btree (
                  "from_at" "pg_catalog"."date_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_formula_product_full_name" ON "public"."ab_shop_formula_products" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name::text), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "shop_formula_product_index_id" ON "public"."ab_shop_formula_products" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_formula_product_is_start" ON "public"."ab_shop_formula_products" USING btree (
                  "is_start" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_formula_product_shop_product_id" ON "public"."ab_shop_formula_products" USING btree (
                  "shop_product_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_formula_product_to_at" ON "public"."ab_shop_formula_products" USING btree (
                  "to_at" "pg_catalog"."date_ops" ASC NULLS LAST
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
        'shop_product_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID производимого продукции',
            'table' => 'DB_Ab1_Shop_Product',
        ),
        'contract_number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер приказа',
        ),
        'contract_date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата приказа',
        ),
        'formula_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID типа формулы',
            'table' => 'DB_Ab1_FormulaType',
        ),
        'is_start' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Используется ли хоть один раз данный рецепт ',
        ),
        'from_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата начала действия рецепта',
        ),
        'to_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата окончания действия рецепта',
        ),
    );

    // список связанных таблиц 1коМногим
    const ITEMS = array(
        'shop_formula_product_items' => array(
            'table' => 'DB_Ab1_Shop_Formula_Product_Item',
            'field_id' => 'shop_formula_product_id',
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
