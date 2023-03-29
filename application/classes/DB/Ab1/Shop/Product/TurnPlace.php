<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Product_TurnPlace {
    const TABLE_NAME = 'ab_shop_product_turn_places';
    const TABLE_ID = 327;
    const NAME = 'DB_Ab1_Shop_Product_TurnPlace';
    const TITLE = 'Группировка норм производства АСУ для расчета заработной платы';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_product_turn_places";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_product_turn_places
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_product_turn_places" (
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
                  "shop_turn_place_id" int8 NOT NULL DEFAULT 0,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "from_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "to_at" timestamp(6) DEFAULT NULL::timestamp without time zone
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_product_turn_places"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_places"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_places"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_places"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_places"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_places"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_places"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_places"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_places"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_places"."shop_turn_place_id" IS \'ID места очереди (АСУ)\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_places"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_places"."from_at" IS \'Срок действия\';
                COMMENT ON COLUMN "public"."ab_shop_product_turn_places"."to_at" IS \'Срок действия\';
                COMMENT ON TABLE "public"."ab_shop_product_turn_places" IS \'Группировка норм производства АСУ для расчета заработной платы\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_product_turn_places
                -- ----------------------------
                CREATE INDEX "ab_shop_product_turn_place_first" ON "public"."ab_shop_product_turn_places" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_product_turn_place_from_at" ON "public"."ab_shop_product_turn_places" USING btree (
                  "from_at" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_product_turn_place_index_id" ON "public"."ab_shop_product_turn_places" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_product_turn_place_shop_turn_place_id" ON "public"."ab_shop_product_turn_places" USING btree (
                  "shop_turn_place_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_product_turn_place_to_at" ON "public"."ab_shop_product_turn_places" USING btree (
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
        'shop_turn_place_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID места очереди (АСУ)',
            'table' => 'DB_Ab1_Shop_Turn_Place',
            'is_common_items' => true,
        ),
        'is_public' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Опубликована ли запись',
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
    );

    // список связанных таблиц 1коМногим
    const ITEMS = array(
        'shop_product_turn_place_items' => array(
            'table' => 'DB_Ab1_Shop_Product_TurnPlace_Item',
            'field_id' => 'shop_product_turn_place_id',
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
