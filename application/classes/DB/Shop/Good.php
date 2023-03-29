<?php defined('SYSPATH') or die('No direct script access.');

class DB_Shop_Good {
    const TABLE_NAME = 'ct_shop_goods';
    const TABLE_ID = 61;
    const NAME = 'DB_Shop_Good';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_shop_goods";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_shop_goods
                -- ----------------------------
                CREATE TABLE "public"."ct_shop_goods" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "shop_table_catalog_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_rubric_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_select_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_unit_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_brand_id" int8 NOT NULL DEFAULT 0,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "article" varchar(100) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "price" numeric(12,2) NOT NULL DEFAULT 0,
                  "price_old" numeric(12,2) NOT NULL DEFAULT 0,
                  "text" text COLLATE "pg_catalog"."default",
                  "image_path" varchar(255) COLLATE "pg_catalog"."default",
                  "files" text COLLATE "pg_catalog"."default",
                  "options" text COLLATE "pg_catalog"."default",
                  "seo" text COLLATE "pg_catalog"."default",
                  "remarketing" text COLLATE "pg_catalog"."default",
                  "collations" text COLLATE "pg_catalog"."default",
                  "system_is_discount" numeric(1) NOT NULL DEFAULT 0,
                  "system_shop_discount_id" int8 NOT NULL DEFAULT 0,
                  "system_discount" numeric(4,2) NOT NULL DEFAULT 0,
                  "system_is_percent" numeric(1) DEFAULT 0,
                  "system_is_action" numeric(1) NOT NULL DEFAULT 0,
                  "system_shop_action_id" int8 NOT NULL DEFAULT 0,
                  "discount" numeric(4,2) NOT NULL DEFAULT 0,
                  "is_percent" numeric(1) NOT NULL DEFAULT 0,
                  "order" int8 NOT NULL DEFAULT 0,
                  "is_group" numeric(1) NOT NULL DEFAULT 0,
                  "is_in_stock" numeric(1) NOT NULL DEFAULT 1,
                  "old_id" varchar(50) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "create_user_id" int8 DEFAULT 0,
                  "update_user_id" int8 NOT NULL,
                  "delete_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "shop_table_object_ids" text COLLATE "pg_catalog"."default",
                  "discount_from_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "discount_to_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "shop_table_stock_id" int8 NOT NULL DEFAULT 0,
                  "stock_name" varchar(50) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "work_type_id" int8 NOT NULL DEFAULT 211,
                  "addition_files" text COLLATE "pg_catalog"."default",
                  "name_url" text COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "uuid" text COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "is_translates" json,
                  "version_current" int8 NOT NULL DEFAULT 1,
                  "version_last" int8 NOT NULL DEFAULT 1,
                  "version_is_last" numeric(1) NOT NULL DEFAULT 1,
                  "shop_table_rubric_ids" text COLLATE "pg_catalog"."default"
                )
                ;
                COMMENT ON COLUMN "public"."ct_shop_goods"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."shop_table_catalog_id" IS \'Тип товара\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."shop_table_rubric_id" IS \'ID рубрики\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."shop_table_select_id" IS \'Тип выделения \';
                COMMENT ON COLUMN "public"."ct_shop_goods"."shop_table_unit_id" IS \'Тип единицы измерения\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."shop_table_brand_id" IS \'ID бренда \';
                COMMENT ON COLUMN "public"."ct_shop_goods"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."article" IS \'Артикул у товара\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."price" IS \'Цена\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."price_old" IS \'Старая цена\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ct_shop_goods"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."seo" IS \'JSON массива настройки SEO\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."remarketing" IS \'Код ремаркетинга\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."collations" IS \'JSON список значений для сопоставления\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."system_is_discount" IS \'Если ли скидка, проставлена системой\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."system_discount" IS \'Скидка проставленная системой по правилам скидок\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."discount" IS \'Скидка\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."is_group" IS \'Является ли это группа товаров\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."is_in_stock" IS \'Есть ли в наличии\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."shop_table_object_ids" IS \'JSON данные списком\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."discount_from_at" IS \'Время начала скидки\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."discount_to_at" IS \'Время окончания скидки\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."shop_table_stock_id" IS \'ID хранилища\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."stock_name" IS \'Каталожный номер (штрих-код позиции на складе)\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."work_type_id" IS \'Этап обработки\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."addition_files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."name_url" IS \'Название для URL\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."uuid" IS \'UUID\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."is_translates" IS \'JSON если ли перевод по языкам\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."version_current" IS \'Номер версии\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."version_last" IS \'Последняя версия\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."version_is_last" IS \'Последняя утвержденная версия\';
                COMMENT ON COLUMN "public"."ct_shop_goods"."shop_table_rubric_ids" IS \'JSON списка рубрик + имя URL\';
                
                -- ----------------------------
                -- Indexes structure for table ct_shop_goods
                -- ----------------------------
                CREATE INDEX "shop_good_discount_from_at" ON "public"."ct_shop_goods" USING btree (
                  "discount_from_at" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_good_discount_to_at" ON "public"."ct_shop_goods" USING btree (
                  "discount_to_at" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_good_first" ON "public"."ct_shop_goods" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_table_catalog_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_good_full_name" ON "public"."ct_shop_goods" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name::text), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "shop_good_full_text" ON "public"."ct_shop_goods" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, text), \'B\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "shop_good_index_id" ON "public"."ct_shop_goods" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_good_index_order" ON "public"."ct_shop_goods" USING btree (
                  "order" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_good_is_group" ON "public"."ct_shop_goods" USING btree (
                  "is_group" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_good_is_in_stock" ON "public"."ct_shop_goods" USING btree (
                  "is_in_stock" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_good_name_like" ON "public"."ct_shop_goods" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_good_name_url" ON "public"."ct_shop_goods" USING btree (
                  "name_url" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_good_old_id" ON "public"."ct_shop_goods" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_good_shop_table_brand_id" ON "public"."ct_shop_goods" USING btree (
                  "shop_table_brand_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_good_shop_table_rubric_id" ON "public"."ct_shop_goods" USING btree (
                  "shop_table_rubric_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_good_shop_table_select_type_id" ON "public"."ct_shop_goods" USING btree (
                  "shop_table_select_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_good_shop_table_stock_id" ON "public"."ct_shop_goods" USING btree (
                  "shop_table_stock_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_good_shop_table_unit_type_id" ON "public"."ct_shop_goods" USING btree (
                  "shop_table_unit_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_good_stock_name" ON "public"."ct_shop_goods" USING btree (
                  "stock_name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_good_system_is_action" ON "public"."ct_shop_goods" USING btree (
                  "system_is_action" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_good_system_is_discount" ON "public"."ct_shop_goods" USING btree (
                  "system_is_discount" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_good_version_current" ON "public"."ct_shop_goods" USING btree (
                  "version_current" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_good_version_is_last" ON "public"."ct_shop_goods" USING btree (
                  "version_is_last" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ct_shop_goods
                -- ----------------------------
                ALTER TABLE "public"."ct_shop_goods" ADD CONSTRAINT "ct_shop_goods_pkey1" PRIMARY KEY ("global_id");
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
        'shop_table_catalog_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип товара',
            'table' => 'DB_Shop_Table_Catalog',
        ),
        'shop_table_rubric_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID рубрики',
            'table' => 'DB_Shop_Table_Rubric',
        ),
        'shop_table_select_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип выделения ',
            'table' => 'DB_Shop_Table_Select',
        ),
        'shop_table_unit_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип единицы измерения',
            'table' => 'DB_Shop_Table_Unit',
        ),
        'shop_table_brand_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID бренда ',
            'table' => 'DB_Shop_Table_Brand',
        ),
        'name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название',
        ),
        'article' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 100,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Артикул у товара',
        ),
        'price' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена',
        ),
        'price_old' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Старая цена',
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
            'length' => 255,
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
        'collations' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON список значений для сопоставления',
        ),
        'system_is_discount' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Если ли скидка, проставлена системой',
        ),
        'system_shop_discount_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => 'DB_Shop_Discount',
        ),
        'system_discount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 4,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Скидка проставленная системой по правилам скидок',
        ),
        'system_is_percent' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => '',
        ),
        'system_is_action' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
        ),
        'system_shop_action_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => 'DB_Shop_Action',
        ),
        'discount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 4,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Скидка',
        ),
        'is_percent' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
        ),
        'order' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
        ),
        'is_group' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Является ли это группа товаров',
        ),
        'is_in_stock' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Есть ли в наличии',
        ),
        'old_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
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
        'shop_table_object_ids' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON данные списком',
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
        'shop_table_stock_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID хранилища',
            'table' => 'DB_Shop_Table_Stock',
        ),
        'stock_name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Каталожный номер (штрих-код позиции на складе)',
        ),
        'work_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Этап обработки',
            'table' => 'DB_WorkType',
        ),
        'addition_files' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дополнительные файлы',
        ),
        'name_url' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название для URL',
        ),
        'uuid' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'UUID',
        ),
        'is_translates' => array(
            'type' => DB_FieldType::FIELD_TYPE_JSON,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON если ли перевод по языкам',
        ),
        'version_current' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Номер версии',
        ),
        'version_last' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Последняя версия',
        ),
        'version_is_last' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Последняя утвержденная версия',
        ),
        'shop_table_rubric_ids' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON списка рубрик + имя URL',
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
