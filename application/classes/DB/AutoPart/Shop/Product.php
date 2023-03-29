<?php defined('SYSPATH') or die('No direct script access.');

class DB_AutoPart_Shop_Product {
    const TABLE_NAME = 'ap_shop_products';
    const TABLE_ID = 61;
    const NAME = 'DB_AutoPart_Shop_Product';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ap_shop_products";',
            'create' => '
                -- ----------------------------
                -- Table structure for ap_shop_products
                -- ----------------------------
                CREATE TABLE "public"."ap_shop_products" (
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
                  "quantity" numeric(12,3) NOT NULL DEFAULT 0,
                  "price" numeric(12,2) NOT NULL DEFAULT 0,
                  "paid_quantity" numeric(12,2) NOT NULL DEFAULT 0,
                  "total_quantity" numeric(12,2) NOT NULL DEFAULT 0,
                  "shop_storage_id" int8 NOT NULL DEFAULT 0,
                  "barcode" varchar(50) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "work_type_id" int8 NOT NULL DEFAULT 211,
                  "name_url" text COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "discount" numeric(4,2) NOT NULL DEFAULT 0,
                  "discount_from_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "discount_to_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "shop_mark_id" int8 NOT NULL DEFAULT 0,
                  "shop_model_id" int8 NOT NULL DEFAULT 0,
                  "shop_brand_id" int8 NOT NULL DEFAULT 0,
                  "article" varchar(50) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "integrations" text COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "tnved" varchar(50) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "price_cost" numeric(12,2) NOT NULL DEFAULT 0,
                  "shop_supplier_id" int8 NOT NULL DEFAULT 0,
                  "shop_rubric_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ap_shop_products"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_products"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ap_shop_products"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."ap_shop_products"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ap_shop_products"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ap_shop_products"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ap_shop_products"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ap_shop_products"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_products"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_products"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ap_shop_products"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ap_shop_products"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ap_shop_products"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_products"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ap_shop_products"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ap_shop_products"."quantity" IS \'Первоначальное количество\';
                COMMENT ON COLUMN "public"."ap_shop_products"."price" IS \'Цена\';
                COMMENT ON COLUMN "public"."ap_shop_products"."paid_quantity" IS \'Количество проданого\';
                COMMENT ON COLUMN "public"."ap_shop_products"."total_quantity" IS \'Количество остаток\';
                COMMENT ON COLUMN "public"."ap_shop_products"."shop_storage_id" IS \'ID хранилища\';
                COMMENT ON COLUMN "public"."ap_shop_products"."barcode" IS \'Штрих-код позиции на складе\';
                COMMENT ON COLUMN "public"."ap_shop_products"."work_type_id" IS \'Этап обработки\';
                COMMENT ON COLUMN "public"."ap_shop_products"."name_url" IS \'Название для URL\';
                COMMENT ON COLUMN "public"."ap_shop_products"."name_supplier" IS \'Название парсера\';
                COMMENT ON COLUMN "public"."ap_shop_products"."discount" IS \'Скидка\';
                COMMENT ON COLUMN "public"."ap_shop_products"."discount_from_at" IS \'Время начала скидки\';
                COMMENT ON COLUMN "public"."ap_shop_products"."discount_to_at" IS \'Время окончания скидки\';
                COMMENT ON COLUMN "public"."ap_shop_products"."shop_mark_id" IS \'ID марки\';
                COMMENT ON COLUMN "public"."ap_shop_products"."shop_model_id" IS \'ID модель\';
                COMMENT ON COLUMN "public"."ap_shop_products"."shop_brand_id" IS \'ID бренда\';
                COMMENT ON COLUMN "public"."ap_shop_products"."article" IS \'Артикул\';
                COMMENT ON COLUMN "public"."ap_shop_products"."integrations" IS \'JSON интеграции с другими системами\';
                COMMENT ON COLUMN "public"."ap_shop_products"."tnved" IS \'Код ТНВЭД\';
                COMMENT ON COLUMN "public"."ap_shop_products"."price_cost" IS \'Себестоимость\';
                COMMENT ON COLUMN "public"."ap_shop_products"."shop_supplier_id" IS \'ID поставщика\';
                COMMENT ON COLUMN "public"."ap_shop_products"."shop_rubric_id" IS \'ID рубрики\';
                COMMENT ON COLUMN "public"."ap_shop_products"."shop_status_id" IS \'ID статуса\';
                COMMENT ON COLUMN "public"."ap_shop_products"."shop_supplier_parser_id" IS \'ID Парсера\';
                COMMENT ON TABLE "public"."ap_shop_products" IS \'Список запчастей / товаров\';
                
                -- ----------------------------
                -- Indexes structure for table ap_shop_products
                -- ----------------------------
                CREATE INDEX "ap_shop_product_article" ON "public"."ap_shop_products" USING btree (
                  "article" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_product_barcode" ON "public"."ap_shop_products" USING btree (
                  "barcode" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_product_created_at" ON "public"."ap_shop_products" USING btree (
                  "created_at" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_product_discount_from_at" ON "public"."ap_shop_products" USING btree (
                  "discount_from_at" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_product_discount_to_at" ON "public"."ap_shop_products" USING btree (
                  "discount_to_at" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_product_first" ON "public"."ap_shop_products" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_product_index_id" ON "public"."ap_shop_products" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_product_shop_brand_id" ON "public"."ap_shop_products" USING btree (
                  "shop_brand_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_product_shop_mark_id" ON "public"."ap_shop_products" USING btree (
                  "shop_mark_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_product_shop_model_id" ON "public"."ap_shop_products" USING btree (
                  "shop_model_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_product_shop_rubric_id" ON "public"."ap_shop_products" USING btree (
                  "shop_rubric_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_product_shop_status_id" ON "public"."ap_shop_products" USING btree (
                  "shop_status_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_product_shop_storage_id" ON "public"."ap_shop_products" USING btree (
                  "shop_storage_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_product_shop_supplier_id" ON "public"."ap_shop_products" USING btree (
                  "shop_supplier_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_product_total_quantity" ON "public"."ap_shop_products" USING btree (
                  "total_quantity" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_product_work_type_id" ON "public"."ap_shop_products" USING btree (
                  "work_type_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_product_shop_supplier_parser_id" ON "public"."ap_shop_products" USING btree (
                  "shop_supplier_parser_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Первоначальное количество',
        ),
        'price' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена',
        ),
        'paid_quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Количество проданого',
        ),
        'total_quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Количество остаток',
        ),
        'shop_storage_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID хранилища',
            'table' => 'DB_AutoPart_Shop_Storage',
        ),
        'barcode' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Штрих-код позиции на складе',
        ),
        'work_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Этап обработки',
            'table' => 'DB_WorkType',
        ),
        'name_url' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название для URL',
        ),
        'discount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 4,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Скидка',
        ),
        'discount_from_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Время начала скидки',
        ),
        'discount_to_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Время окончания скидки',
        ),
        'shop_mark_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID марки',
            'table' => 'DB_AutoPart_Shop_Mark',
        ),
        'shop_model_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID модель',
            'table' => 'DB_AutoPart_Shop_Model',
        ),
        'shop_brand_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID бренда',
            'table' => 'DB_AutoPart_Shop_Brand',
        ),
        'article' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Артикул',
        ),
        'integrations' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON интеграции с другими системами',
        ),
        'tnved' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Код ТНВЭД',
        ),
        'price_cost' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Себестоимость',
        ),
        'shop_supplier_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID поставщика',
            'table' => 'DB_AutoPart_Shop_Supplier',
        ),
        'shop_rubric_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID рубрики',
            'table' => 'DB_AutoPart_Shop_Rubric',
        ),
        'shop_product_status_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID статуса',
            'table' => 'DB_AutoPart_Shop_Product_Status',
        ),
        'is_in_stock' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Есть в наличии или нет',
        ),
        'stock_quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Количество на складе',
        ),
        'stock_compare_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Сравнений акции',
        ),
        'is_on_order' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Возможно под заказ',
        ),
        'shop_supplier_parser_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID Парсера',
            'table' => 'DB_AutoPart_Shop_Supplier_Parser',
        ),
        'name_supplier' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 255,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название парсера',
        ),
        'root_shop_product_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID основного товара, когда несколько товаров разных поставщиков',
            'table' => 'DB_AutoPart_Shop_Product',
        ),
        'child_product_count' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Количество товаров привязанных к этому товару',
        ),
        'url' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
        ),
        'is_found_supplier' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Не найден товар в источники',
        ),
        'is_load_site_supplier' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Загружен товар у поставщика из сайт',
        ),
        'shop_product_join_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => 'DB_AutoPart_Shop_Product_Join',
        ),
        'params' => array(
            'type' => DB_FieldType::FIELD_TYPE_ARRAY,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
        ),
    );

    // список связанных таблиц 1коМногим
     const ITEMS = array(
         'shop_product_attributes' => array( // название переменной переданной из формы (например shop_piece_items)
             'table' => 'DB_AutoPart_Shop_Product_Attribute', // *связь с другой таблицой
             'field_id' => 'shop_product_id', // *по какому полю будет идти связть id = shop_piece_id
             'is_view' => true, // отображать при добавлении и редактировании по view
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
