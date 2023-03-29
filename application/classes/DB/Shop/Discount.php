<?php defined('SYSPATH') or die('No direct script access.');

class DB_Shop_Discount {
    const TABLE_NAME = 'ct_shop_discounts';
    const TABLE_ID = 61;
    const NAME = 'DB_Shop_Discount';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_shop_discounts";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_shop_discounts
                -- ----------------------------
                CREATE TABLE "public"."ct_shop_discounts" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "is_run" numeric(1) NOT NULL DEFAULT 0,
                  "shop_id" int8 NOT NULL,
                  "discount_type_id" int8 NOT NULL DEFAULT 0,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "from_at" timestamp(6),
                  "to_at" timestamp(6),
                  "text" text COLLATE "pg_catalog"."default",
                  "data" text COLLATE "pg_catalog"."default",
                  "bill_comment" varchar(250) COLLATE "pg_catalog"."default",
                  "image_path" varchar(100) COLLATE "pg_catalog"."default",
                  "files" text COLLATE "pg_catalog"."default",
                  "seo" text COLLATE "pg_catalog"."default",
                  "remarketing" text COLLATE "pg_catalog"."default",
                  "create_user_id" int8 DEFAULT 0,
                  "update_user_id" int8 NOT NULL,
                  "delete_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "order" int4 NOT NULL DEFAULT 0,
                  "discount" numeric(13,2) NOT NULL,
                  "is_percent" numeric(1) NOT NULL,
                  "shop_good_id" int8 NOT NULL DEFAULT 0,
                  "gift_type_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ct_shop_discounts"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."is_run" IS \'Запущена ли акция (отмечается системой)\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."discount_type_id" IS \'ID типа акции\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."name" IS \'Название акции\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."from_at" IS \'Время начала акции\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."to_at" IS \'Время окончания акции\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."data" IS \'Данные настройки \';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."bill_comment" IS \'Комментарий к заказу при скидки\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."image_path" IS \'Путь до картинки\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."seo" IS \'JSON массива настройки SEO\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."remarketing" IS \'Код ремаркетинга\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."order" IS \'Позиция для сортировки\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."discount" IS \'Размер скидки\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."is_percent" IS \'Скидка измеряется в проценте (иначе в валюте)\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."shop_good_id" IS \'ID товара\';
                COMMENT ON COLUMN "public"."ct_shop_discounts"."gift_type_id" IS \'ID типа подарка\';
                COMMENT ON TABLE "public"."ct_shop_discounts" IS \'Таблица акций магазина\';
                
                -- ----------------------------
                -- Indexes structure for table ct_shop_discounts
                -- ----------------------------
                CREATE INDEX "shop_discount_discount_type_id" ON "public"."ct_shop_discounts" USING btree (
                  "discount_type_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_discount_from_at" ON "public"."ct_shop_discounts" USING btree (
                  "from_at" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_discount_index_id" ON "public"."ct_shop_discounts" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_discount_is_public" ON "public"."ct_shop_discounts" USING btree (
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_discount_is_run" ON "public"."ct_shop_discounts" USING btree (
                  "is_run" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_discount_name_like" ON "public"."ct_shop_discounts" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_discount_order" ON "public"."ct_shop_discounts" USING btree (
                  "order" "pg_catalog"."int4_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_discount_to_at" ON "public"."ct_shop_discounts" USING btree (
                  "to_at" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ct_shop_discounts
                -- ----------------------------
                ALTER TABLE "public"."ct_shop_discounts" ADD CONSTRAINT "ct_shop_actions_copy_pkey" PRIMARY KEY ("global_id");
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
        'is_run' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Запущена ли акция (отмечается системой)',
        ),
        'shop_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID магазина',
            'table' => 'DB_Shop',
        ),
        'discount_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID типа акции',
            'table' => 'DB_DiscountType',
        ),
        'name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название акции',
        ),
        'from_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Время начала акции',
        ),
        'to_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Время окончания акции',
        ),
        'text' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Описание ',
        ),
        'data' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Данные настройки ',
        ),
        'bill_comment' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Комментарий к заказу при скидки',
        ),
        'image_path' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 100,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Путь до картинки',
        ),
        'files' => array(
            'type' => DB_FieldType::FIELD_TYPE_FILES,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дополнительные файлы',
        ),
        'seo' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON массива настройки SEO',
        ),
        'remarketing' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Код ремаркетинга',
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
        'order' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 9,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Позиция для сортировки',
        ),
        'discount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 13,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Размер скидки',
        ),
        'is_percent' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Скидка измеряется в проценте (иначе в валюте)',
        ),
        'shop_good_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID товара',
            'table' => 'DB_Shop_Good',
        ),
        'gift_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID типа подарка',
            'table' => 'DB_GiftType',
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
