<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Competitor_Price_Item {
    const TABLE_NAME = 'ab_shop_competitor_price_items';
    const TABLE_ID = 278;
    const NAME = 'DB_Ab1_Shop_Competitor_Price_Item';
    const TITLE = 'Цены на продукцию прайс-листа конкурента';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_competitor_price_items";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_competitor_price_items
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_competitor_price_items" (
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
                  "shop_competitor_id" int8 NOT NULL DEFAULT 0,
                  "shop_product_id" int8 NOT NULL DEFAULT 0,
                  "price" numeric(12,3) NOT NULL DEFAULT 0,
                  "delivery" numeric(12,3) NOT NULL DEFAULT 0,
                  "delivery_zhd" numeric(12,3) NOT NULL DEFAULT 0,
                  "product_capacity" text COLLATE "pg_catalog"."default",
                  "date" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "shop_competitor_price_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."shop_competitor_id" IS \'ID конкурента\';
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."shop_product_id" IS \'ID продукта\';
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."price" IS \'Стоимость\';
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."delivery" IS \'Стоимость доставки\';
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."delivery_zhd" IS \'Стоимость доставки ЖД\';
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."product_capacity" IS \'Производственная мощность\';
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."date" IS \'Дата фиксации прайс-листа конкурента\';
                COMMENT ON COLUMN "public"."ab_shop_competitor_price_items"."shop_competitor_price_id" IS \'ID прайс-листа конкурента\';
                COMMENT ON TABLE "public"."ab_shop_competitor_price_items" IS \'Список цен продукции прайс-листа конкурента\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_competitor_price_items
                -- ----------------------------
                CREATE INDEX "ab_shop_competitor_price_item_first" ON "public"."ab_shop_competitor_price_items" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_competitor_price_item_index_id" ON "public"."ab_shop_competitor_price_items" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_competitor_price_item_shop_competitor_id" ON "public"."ab_shop_competitor_price_items" USING btree (
                  "shop_competitor_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_competitor_price_item_shop_competitor_price_id" ON "public"."ab_shop_competitor_price_items" USING btree (
                  "shop_competitor_price_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_competitor_price_item_shop_product_id" ON "public"."ab_shop_competitor_price_items" USING btree (
                  "shop_product_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'shop_competitor_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID конкурента',
            'table' => 'DB_Ab1_Shop_Competitor',
        ),
        'shop_product_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID продукта',
            'table' => 'DB_Ab1_Shop_Product',
        ),
        'price' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Стоимость',
        ),
        'delivery' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Стоимость доставки',
        ),
        'delivery_zhd' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Стоимость доставки ЖД',
        ),
        'product_capacity' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Производственная мощность',
        ),
        'date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата фиксации прайс-листа конкурента',
        ),
        'shop_competitor_price_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID прайс-листа конкурента',
            'table' => 'DB_Ab1_Shop_Competitor_Price',
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
