<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Product_TurnPlace_Item {
    const TABLE_NAME = 'ab_shop_product_turn_place_items';
    const TABLE_ID = 328;
    const NAME = 'DB_Ab1_Shop_Product_TurnPlace_Item';
    const TITLE = 'Нормы производства АСУ для расчета заработной платы';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_product_turn_place_items";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_product_turn_place_items
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_product_turn_place_items" (
                  "id" int8 NOT NULL,
                  "shop_id" int8 NOT NULL,
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
                  "price" numeric(12,2) NOT NULL DEFAULT 0,
                  "shop_turn_place_id" int8 NOT NULL DEFAULT 0,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "norm" float8 NOT NULL DEFAULT 0,
                  "from_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "to_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "shop_product_turn_place_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_product_turn_place_items"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_place_items"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_place_items"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_place_items"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_place_items"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_place_items"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_place_items"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_place_items"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_place_items"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_place_items"."shop_product_id" IS \'ID продукта\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_place_items"."price" IS \'Расценка на единицу\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_place_items"."shop_turn_place_id" IS \'ID места очереди (АСУ)\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_place_items"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_place_items"."norm" IS \'Норма времени на единицу\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_place_items"."from_at" IS \'Срок действия\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_place_items"."to_at" IS \'Срок действия\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_place_items"."shop_product_turn_place_id" IS \'ID группировки норм для мест хранение\';
                COMMENT ON TABLE "public"."ab_shop_product_turn_place_items" IS \'Список норм производства АСУ для расчета заработной платы\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_product_turn_place_items
                -- ----------------------------
                CREATE INDEX "ab_shop_product_turn_place_item_first" ON "public"."ab_shop_product_turn_place_items" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_product_turn_place_item_from_at" ON "public"."ab_shop_product_turn_place_items" USING btree (
                  "from_at" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_product_turn_place_item_index_id" ON "public"."ab_shop_product_turn_place_items" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_product_turn_place_item_shop_product_id" ON "public"."ab_shop_product_turn_place_items" USING btree (
                  "shop_product_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_product_turn_place_item_shop_turn_place_id" ON "public"."ab_shop_product_turn_place_items" USING btree (
                  "shop_turn_place_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_product_turn_place_item_to_at" ON "public"."ab_shop_product_turn_place_items" USING btree (
                  "to_at" "pg_catalog"."timestamp_ops" ASC NULLS LAST
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
        'shop_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID магазина',
            'table' => 'DB_Shop',
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
        'price' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Расценка на единицу',
        ),
        'shop_turn_place_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID места очереди (АСУ)',
            'table' => 'DB_Ab1_Shop_Turn_Place',
        ),
        'is_public' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Опубликована ли запись',
        ),
        'norm' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 53,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Норма времени на единицу',
        ),
        'from_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Срок действия',
        ),
        'to_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Срок действия',
        ),
        'shop_product_turn_place_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID группировки норм для мест хранение',
            'table' => 'DB_Ab1_Shop_Product_TurnPlace',
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
