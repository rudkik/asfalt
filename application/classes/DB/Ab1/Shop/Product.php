<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Product {
    const TABLE_NAME = 'ab_shop_products';
    const TABLE_ID = 61;
    const NAME = 'DB_Ab1_Shop_Product';
    const TITLE = 'Продукции для реализации';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_products";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_products
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_products" (
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
                  "name_1c" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "name_site" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "price" numeric(12,2) NOT NULL DEFAULT 0,
                  "unit" varchar(15) COLLATE "pg_catalog"."default",
                  "product_type_1c" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "type_1c" varchar(15) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "shop_product_rubric_id" int8 NOT NULL DEFAULT 0,
                  "tare" numeric(12,3) NOT NULL DEFAULT 0,
                  "is_packed" numeric(1) NOT NULL DEFAULT 0,
                  "volume" numeric(8,5) NOT NULL DEFAULT 1,
                  "coefficient_weight_quantity" numeric(8,5) NOT NULL DEFAULT 1,
                  "shop_product_group_id" int8 NOT NULL DEFAULT 0,
                  "product_type_id" int8 NOT NULL DEFAULT 1,
                  "name_short" varchar(30) COLLATE "pg_catalog"."default",
                  "product_view_id" int8 NOT NULL DEFAULT 2,
                  "shop_storage_id" int8 NOT NULL DEFAULT 0,
                  "shop_subdivision_id" int8 NOT NULL DEFAULT 0,
                  "shop_heap_id" int8 NOT NULL DEFAULT 0,
                  "shop_product_pricelist_rubric_id" int8 NOT NULL DEFAULT 0,
                  "is_pricelist" numeric(1) NOT NULL DEFAULT 1,
                  "name_recipe" text COLLATE "pg_catalog"."default",
                  "formula_type_ids" text COLLATE "pg_catalog"."default",
                  "shop_material_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_products"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_products"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_products"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ab_shop_products"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_products"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_products"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_products"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_products"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_products"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_products"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_products"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_products"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_products"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_products"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_products"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_products"."name_1c" IS \'Название в 1C\';
                COMMENT ON COLUMN "public"."ab_shop_products"."name_site" IS \'Название на сайте\';
                COMMENT ON COLUMN "public"."ab_shop_products"."price" IS \'Цена\';
                COMMENT ON COLUMN "public"."ab_shop_products"."unit" IS \'Единица измерения\';
                COMMENT ON COLUMN "public"."ab_shop_products"."product_type_1c" IS \'Тип продукта для 1С\';
                COMMENT ON COLUMN "public"."ab_shop_products"."type_1c" IS \'Тип 1С\';
                COMMENT ON COLUMN "public"."ab_shop_products"."tare" IS \'Тара фасовки\';
                COMMENT ON COLUMN "public"."ab_shop_products"."is_packed" IS \'Бывает ли фасованный\';
                COMMENT ON COLUMN "public"."ab_shop_products"."volume" IS \'Объем\';
                COMMENT ON COLUMN "public"."ab_shop_products"."coefficient_weight_quantity" IS \'Коэффициент веса в количество\';
                COMMENT ON COLUMN "public"."ab_shop_products"."shop_product_group_id" IS \'ID группы для отчета ЗАЯВКИ в основной сбыт\';
                COMMENT ON COLUMN "public"."ab_shop_products"."product_type_id" IS \'ID типа продукции\';
                COMMENT ON COLUMN "public"."ab_shop_products"."name_short" IS \'Краткое название\';
                COMMENT ON COLUMN "public"."ab_shop_products"."product_view_id" IS \'ID вида продукции\';
                COMMENT ON COLUMN "public"."ab_shop_products"."shop_storage_id" IS \'ID склад (реализация со склада)\';
                COMMENT ON COLUMN "public"."ab_shop_products"."shop_subdivision_id" IS \'ID подразделения откуда произошла реализация\';
                COMMENT ON COLUMN "public"."ab_shop_products"."shop_heap_id" IS \'ID места забора материала\';
                COMMENT ON COLUMN "public"."ab_shop_products"."shop_product_pricelist_rubric_id" IS \'ID рубрика прайс листа\';
                COMMENT ON COLUMN "public"."ab_shop_products"."is_pricelist" IS \'Вывести в прайс листе\';
                COMMENT ON COLUMN "public"."ab_shop_products"."name_recipe" IS \'Название по рецепту\';
                COMMENT ON COLUMN "public"."ab_shop_products"."formula_type_ids" IS \'Виды рецептов для продуктов, которым его можно изготавливать\';
                COMMENT ON COLUMN "public"."ab_shop_products"."shop_material_id" IS \'ID материала для продуктов, которые связаны 1 к 1\';
                COMMENT ON TABLE "public"."ab_shop_products" IS \'Список продукции для реализации\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_products
                -- ----------------------------
                CREATE INDEX "ab_shop_product_first" ON "public"."ab_shop_products" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_product_full_name" ON "public"."ab_shop_products" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name::text), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "ab_shop_product_index_id" ON "public"."ab_shop_products" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_product_index_order" ON "public"."ab_shop_products" USING btree (
                  "order" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_product_old_id" ON "public"."ab_shop_products" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_product_product_type_id" ON "public"."ab_shop_products" USING btree (
                  "product_type_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_product_product_view_id" ON "public"."ab_shop_products" USING btree (
                  "product_view_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_product_shop_material_id" ON "public"."ab_shop_products" USING btree (
                  "shop_material_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_product_shop_product_group_id" ON "public"."ab_shop_products" USING btree (
                  "shop_product_group_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_product_shop_product_rubric_id" ON "public"."ab_shop_products" USING btree (
                  "shop_product_rubric_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'price' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена',
        ),
        'unit' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 15,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Единица измерения',
        ),
        'product_type_1c' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Тип продукта для 1С',
        ),
        'type_1c' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 15,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Тип 1С',
        ),
        'shop_product_rubric_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => 'DB_Ab1_Shop_Product_Rubric',
        ),
        'tare' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Тара фасовки',
        ),
        'is_packed' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Бывает ли фасованный',
        ),
        'volume' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 8,
            'decimal' => 5,
            'is_not_null' => true,
            'title' => 'Объем',
        ),
        'coefficient_weight_quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 8,
            'decimal' => 5,
            'is_not_null' => true,
            'title' => 'Коэффициент веса в количество',
        ),
        'shop_product_group_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID группы для отчета ЗАЯВКИ в основной сбыт',
            'table' => 'DB_Ab1_Shop_Product_Group',
        ),
        'product_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID типа продукции',
            'table' => 'DB_Ab1_ProductType',
        ),
        'name_short' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 30,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Краткое название',
        ),
        'product_view_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID вида продукции',
            'table' => 'DB_Ab1_ProductView',
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
        ),
        'shop_heap_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID места забора материала',
            'table' => 'DB_Ab1_Shop_Heap',
        ),
        'shop_product_pricelist_rubric_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID рубрика прайс листа',
            'table' => 'DB_Ab1_Shop_Product_Pricelist_Rubric',
        ),
        'is_pricelist' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Вывести в прайс листе',
        ),
        'name_recipe' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название по рецепту',
        ),
        'formula_type_ids' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Виды рецептов для продуктов, которым его можно изготавливать',
        ),
        'shop_material_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID материала для продуктов, которые связаны 1 к 1',
            'table' => 'DB_Ab1_Shop_Material',
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
