<?php defined('SYSPATH') or die('No direct script access.');

class DB_Shop_Return_Item {
    const TABLE_NAME = 'ct_shop_return_items';
    const TABLE_ID = 61;
    const NAME = 'DB_Shop_Return_Item';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_shop_return_items";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_shop_return_items
                -- ----------------------------
                CREATE TABLE "public"."ct_shop_return_items" (
                  "id" int8 NOT NULL,
                  "shop_id" int8 NOT NULL,
                  "shop_table_catalog_id" int8 NOT NULL DEFAULT 0,
                  "shop_return_id" int8 NOT NULL,
                  "shop_good_id" int8 NOT NULL,
                  "shop_table_child_id" int8 DEFAULT 0,
                  "price" numeric(12,2) NOT NULL,
                  "count" numeric(12,2) NOT NULL,
                  "amount" numeric(12,2) NOT NULL,
                  "discount" numeric(5,2) NOT NULL DEFAULT 0,
                  "is_percent" numeric(1) NOT NULL DEFAULT 0,
                  "is_add_action" numeric(1) NOT NULL DEFAULT 0,
                  "client_comment" text COLLATE "pg_catalog"."default",
                  "create_user_id" int8 DEFAULT 0,
                  "update_user_id" int8 NOT NULL,
                  "delete_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "shop_discount_id" int8 DEFAULT 0,
                  "options" text COLLATE "pg_catalog"."default",
                  "shop_root_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ct_shop_return_items"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ct_shop_return_items"."shop_return_id" IS \'ID возврата\';
                COMMENT ON COLUMN "public"."ct_shop_return_items"."shop_good_id" IS \'ID товара\';
                COMMENT ON COLUMN "public"."ct_shop_return_items"."shop_table_child_id" IS \'ID подтовара\';
                COMMENT ON COLUMN "public"."ct_shop_return_items"."price" IS \'Цена одного букета\';
                COMMENT ON COLUMN "public"."ct_shop_return_items"."count" IS \'Количество букетов\';
                COMMENT ON COLUMN "public"."ct_shop_return_items"."amount" IS \'Стоимость букетов\';
                COMMENT ON COLUMN "public"."ct_shop_return_items"."discount" IS \'Скидка на букеты\';
                COMMENT ON COLUMN "public"."ct_shop_return_items"."is_add_action" IS \'Товар добавлен по акциям\';
                COMMENT ON COLUMN "public"."ct_shop_return_items"."client_comment" IS \'Комментарий клиента\';
                COMMENT ON COLUMN "public"."ct_shop_return_items"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_return_items"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_return_items"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_shop_return_items"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ct_shop_return_items"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_shop_return_items"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_return_items"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ct_shop_return_items"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_shop_return_items"."shop_discount_id" IS \'ID скидки\';
                COMMENT ON COLUMN "public"."ct_shop_return_items"."options" IS \'Данные JSON\';
                COMMENT ON COLUMN "public"."ct_shop_return_items"."shop_root_id" IS \'ID родителя магазина создавшего заказ\';
                COMMENT ON TABLE "public"."ct_shop_return_items" IS \'Таблица продуктов заказа\';
                
                -- ----------------------------
                -- Indexes structure for table ct_shop_return_items
                -- ----------------------------
                CREATE INDEX "shop_return_item_first" ON "public"."ct_shop_return_items" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_table_catalog_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_return_item_index_id" ON "public"."ct_shop_return_items" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_return_item_shop_good_id" ON "public"."ct_shop_return_items" USING btree (
                  "shop_good_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_return_item_shop_return_id" ON "public"."ct_shop_return_items" USING btree (
                  "shop_return_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ct_shop_return_items
                -- ----------------------------
                ALTER TABLE "public"."ct_shop_return_items" ADD CONSTRAINT "ct_shop_bill_items_copy_pkey" PRIMARY KEY ("global_id");
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
        'shop_table_catalog_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => 'DB_Shop_Table_Catalog',
        ),
        'shop_return_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID возврата',
            'table' => 'DB_Shop_Return',
        ),
        'shop_good_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID товара',
            'table' => 'DB_Shop_Good',
        ),
        'shop_table_child_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID подтовара',
            'table' => 'DB_Shop_Table_Child',
        ),
        'price' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена одного букета',
        ),
        'count' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Количество букетов',
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Стоимость букетов',
        ),
        'discount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 5,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Скидка на букеты',
        ),
        'is_percent' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
        ),
        'is_add_action' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Товар добавлен по акциям',
        ),
        'client_comment' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Комментарий клиента',
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
        'shop_discount_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID скидки',
            'table' => 'DB_Shop_Discount',
        ),
        'options' => array(
            'type' => DB_FieldType::FIELD_TYPE_JSON,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Данные JSON',
        ),
        'shop_root_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID родителя магазина создавшего заказ',
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
