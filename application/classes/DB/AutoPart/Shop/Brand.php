<?php defined('SYSPATH') or die('No direct script access.');

class DB_AutoPart_Shop_Brand {
    const TABLE_NAME = 'ap_shop_brands';
    const TABLE_ID = 61;
    const NAME = 'DB_AutoPart_Shop_Brand';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ap_shop_brands";',
            'create' => '
                -- ----------------------------
                -- Table structure for ap_shop_brands
                -- ----------------------------
                CREATE TABLE "public"."ap_shop_brands" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "text" text COLLATE "pg_catalog"."default",
                  "options" text COLLATE "pg_catalog"."default",
                  "image_path" varchar(255) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "files" text COLLATE "pg_catalog"."default",
                  "seo" text COLLATE "pg_catalog"."default",
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
                  "is_translates" json,
                  "name_url" text COLLATE "pg_catalog"."default" DEFAULT NULL::character varying
                )
                ;
                COMMENT ON COLUMN "public"."ap_shop_brands"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_brands"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ap_shop_brands"."name" IS \'Название каталога\';
                COMMENT ON COLUMN "public"."ap_shop_brands"."text" IS \'Описание каталога (HTML-код)\';
                COMMENT ON COLUMN "public"."ap_shop_brands"."image_path" IS \'Путь к изображению рубрики\';
                COMMENT ON COLUMN "public"."ap_shop_brands"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ap_shop_brands"."seo" IS \'JSON массива настройки SEO\';
                COMMENT ON COLUMN "public"."ap_shop_brands"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_brands"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_brands"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ap_shop_brands"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ap_shop_brands"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ap_shop_brands"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_brands"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ap_shop_brands"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ap_shop_brands"."order" IS \'Позиция для сортировки\';
                COMMENT ON COLUMN "public"."ap_shop_brands"."is_translates" IS \'JSON если ли перевод по языкам\';
                COMMENT ON COLUMN "public"."ap_shop_brands"."name_url" IS \'Название для URL\';
                COMMENT ON TABLE "public"."ap_shop_brands" IS \'Список брендов \';
                
                -- ----------------------------
                -- Indexes structure for table ap_shop_brands
                -- ----------------------------
                CREATE INDEX "ap_shop_brand_first" ON "public"."ap_shop_brands" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_brand_index_id" ON "public"."ap_shop_brands" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_brand_index_order" ON "public"."ap_shop_brands" USING btree (
                  "order" "pg_catalog"."int4_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_brand_name_like" ON "public"."ap_shop_brands" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_brand_name_url" ON "public"."ap_shop_brands" USING btree (
                  "name_url" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ap_shop_brands
                -- ----------------------------
                ALTER TABLE "public"."ap_shop_brands" ADD CONSTRAINT "ct_shop_news_copy_pkey3" PRIMARY KEY ("global_id");
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
        'table_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID таблицы',
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
            'title' => 'Название каталога',
        ),
        'text' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Описание каталога (HTML-код)',
        ),
        'options' => array(
            'type' => DB_FieldType::FIELD_TYPE_JSON,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => '',
        ),
        'image_path' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 255,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Путь к изображению рубрики',
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
        'is_translates' => array(
            'type' => DB_FieldType::FIELD_TYPE_JSON,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON если ли перевод по языкам',
        ),
        'name_url' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название для URL',
        ),
        'is_disable_dumping' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Отключаем демпинг цен',
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
