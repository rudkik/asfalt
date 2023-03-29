<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Lessee_Car_Item {
    const TABLE_NAME = 'ab_shop_lessee_car_items';
    const TABLE_ID = 314;
    const NAME = 'DB_Ab1_Shop_Lessee_Car_Item';
    const TITLE = 'Товары машин арендаторов';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_lessee_car_items";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_lessee_car_items
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_lessee_car_items" (
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
                  "quantity" numeric(12,3) NOT NULL DEFAULT 0,
                  "price" numeric(12,2) NOT NULL DEFAULT 0,
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "shop_lessee_car_id" int8 NOT NULL DEFAULT 0,
                  "shop_client_id" int8 NOT NULL DEFAULT 0,
                  "shop_storage_id" int8 NOT NULL DEFAULT 0,
                  "shop_subdivision_id" int8 NOT NULL DEFAULT 0,
                  "shop_heap_id" int8 NOT NULL DEFAULT 0,
                  "shop_formula_product_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."shop_product_id" IS \'ID продукта\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."quantity" IS \'Количество\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."price" IS \'Цена\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."shop_lessee_car_id" IS \'ID оплаты\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."shop_client_id" IS \'ID клиента\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."shop_storage_id" IS \'ID склад (реализация со склада)\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."shop_subdivision_id" IS \'ID подразделения откуда произошла реализация\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."shop_heap_id" IS \'ID места забора материала\';
                COMMENT ON COLUMN "public"."ab_shop_lessee_car_items"."shop_formula_product_id" IS \'ID рецепта продукции (для списания материала)\';
                COMMENT ON TABLE "public"."ab_shop_lessee_car_items" IS \'Список товаров машин арендаторов\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_lessee_car_items
                -- ----------------------------
                CREATE INDEX "ab_shop_car_lessee_item_first" ON "public"."ab_shop_lessee_car_items" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_lessee_item_full_name" ON "public"."ab_shop_lessee_car_items" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name::text), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "ab_shop_car_lessee_item_index_id" ON "public"."ab_shop_lessee_car_items" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_lessee_item_name_like" ON "public"."ab_shop_lessee_car_items" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_lessee_item_old_id" ON "public"."ab_shop_lessee_car_items" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_lessee_item_shop_client_id" ON "public"."ab_shop_lessee_car_items" USING btree (
                  "shop_client_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_lessee_item_shop_lessee_car_id" ON "public"."ab_shop_lessee_car_items" USING btree (
                  "shop_lessee_car_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_lessee_item_shop_product_id" ON "public"."ab_shop_lessee_car_items" USING btree (
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
        'shop_product_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID продукта',
            'table' => 'DB_Ab1_Shop_Product',
        ),
        'quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество',
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
        'shop_lessee_car_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID оплаты',
            'table' => 'DB_Ab1_Shop_Lessee_Car',
        ),
        'shop_client_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID клиента',
            'table' => 'DB_Ab1_Shop_Client',
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
        'shop_formula_product_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID рецепта продукции (для списания материала)',
            'table' => 'DB_Ab1_Shop_Formula_Product',
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
