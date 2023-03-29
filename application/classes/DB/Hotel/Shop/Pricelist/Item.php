<?php defined('SYSPATH') or die('No direct script access.');

class DB_Hotel_Shop_Pricelist_Item {
    const TABLE_NAME = 'hc_shop_pricelist_items';
    const TABLE_ID = 61;
    const NAME = 'DB_Hotel_Shop_Pricelist_Item';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."hc_shop_pricelist_items";',
            'create' => '
                -- ----------------------------
                -- Table structure for hc_shop_pricelist_items
                -- ----------------------------
                CREATE TABLE "public"."hc_shop_pricelist_items" (
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
                  "date_from" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "date_to" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "shop_room_id" int8 NOT NULL DEFAULT 0,
                  "price" numeric(12,2) NOT NULL DEFAULT 0,
                  "price_extra" numeric(12,2) NOT NULL DEFAULT 0,
                  "price_child" numeric(12,2) NOT NULL DEFAULT 0,
                  "shop_pricelist_id" int8 NOT NULL DEFAULT 0,
                  "price_feast" numeric(12,2) NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."date_from" IS \'Дата начала действия прайс-листа\';
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."date_to" IS \'Дата окончания действия прайс-листа\';
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."shop_room_id" IS \'ID комнаты\';
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."price" IS \'Цена всего номера\';
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."price_extra" IS \'Цена одного дополнительного взрослого\';
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."price_child" IS \'Цена одного дополнительного десткого\';
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."shop_pricelist_id" IS \'ID прайс-листа\';
                COMMENT ON COLUMN "public"."hc_shop_pricelist_items"."price_feast" IS \'Цена всего номера в праздничный день\';
                
                -- ----------------------------
                -- Indexes structure for table hc_shop_pricelist_items
                -- ----------------------------
                CREATE INDEX "hc_shop_pricelist_item_date_from" ON "public"."hc_shop_pricelist_items" USING btree (
                  "date_from" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "hc_shop_pricelist_item_date_to" ON "public"."hc_shop_pricelist_items" USING btree (
                  "date_to" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "hc_shop_pricelist_item_first" ON "public"."hc_shop_pricelist_items" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "hc_shop_pricelist_item_full_name" ON "public"."hc_shop_pricelist_items" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name::text), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "hc_shop_pricelist_item_index_id" ON "public"."hc_shop_pricelist_items" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "hc_shop_pricelist_item_shop_pricelist_id" ON "public"."hc_shop_pricelist_items" USING btree (
                  "shop_pricelist_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "hc_shop_pricelist_item_shop_room_id" ON "public"."hc_shop_pricelist_items" USING btree (
                  "shop_room_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'date_from' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата начала действия прайс-листа',
        ),
        'date_to' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата окончания действия прайс-листа',
        ),
        'shop_room_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID комнаты',
            'table' => 'DB_Hotel_Shop_Room',
        ),
        'price' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена всего номера',
        ),
        'price_extra' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена одного дополнительного взрослого',
        ),
        'price_child' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена одного дополнительного десткого',
        ),
        'shop_pricelist_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID прайс-листа',
            'table' => 'DB_Hotel_Shop_Pricelist',
        ),
        'price_feast' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена всего номера в праздничный день',
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
