<?php defined('SYSPATH') or die('No direct script access.');

class DB_Shop {
    const TABLE_NAME = 'ct_shops';
    const TABLE_ID = 49;
    const NAME = 'DB_Shop';
    const TITLE = 'Магазины';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "ct_shops";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_shops
                -- ----------------------------
                CREATE TABLE "public"."ct_shops" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "main_shop_id" int8 NOT NULL DEFAULT 0,
                  "shop_root_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_rubric_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_catalog_id" int8 NOT NULL DEFAULT 0,
                  "is_block" numeric(1) NOT NULL DEFAULT 0,
                  "is_active" numeric(1) NOT NULL DEFAULT 1,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "official_name" varchar(250) COLLATE "pg_catalog"."default",
                  "domain" varchar(250) COLLATE "pg_catalog"."default",
                  "sub_domain" varchar(250) COLLATE "pg_catalog"."default",
                  "currency_ids" varchar(500) COLLATE "pg_catalog"."default",
                  "default_currency_id" int8 NOT NULL DEFAULT 0,
                  "language_ids" varchar(500) COLLATE "pg_catalog"."default",
                  "default_language_id" int8 NOT NULL DEFAULT 0,
                  "city_id" int8 NOT NULL DEFAULT 0,
                  "city_ids" varchar(500) COLLATE "pg_catalog"."default",
                  "text" text COLLATE "pg_catalog"."default",
                  "image_path" varchar(100) COLLATE "pg_catalog"."default",
                  "files" text COLLATE "pg_catalog"."default",
                  "options" text COLLATE "pg_catalog"."default",
                  "seo" text COLLATE "pg_catalog"."default",
                  "remarketing" text COLLATE "pg_catalog"."default",
                  "collations" text COLLATE "pg_catalog"."default",
                  "order" int8 NOT NULL DEFAULT 0,
                  "old_id" int8 NOT NULL DEFAULT 0,
                  "requisites" text COLLATE "pg_catalog"."default",
                  "work_time" text COLLATE "pg_catalog"."default",
                  "delivery_work_time" text COLLATE "pg_catalog"."default",
                  "site_shablon_id" int8 NOT NULL DEFAULT 0,
                  "site_shablon_path" varchar(100) COLLATE "pg_catalog"."default",
                  "shop_menu" text COLLATE "pg_catalog"."default",
                  "create_user_id" int8 DEFAULT 0,
                  "update_user_id" int8 NOT NULL,
                  "delete_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "params" text COLLATE "pg_catalog"."default",
                  "shop_table_select_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_brand_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ct_shops"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ct_shops"."main_shop_id" IS \'ID основного магазина\';
                COMMENT ON COLUMN "public"."ct_shops"."shop_root_id" IS \'Родитель магазина\';
                COMMENT ON COLUMN "public"."ct_shops"."shop_table_catalog_id" IS \'ID тип филлиала\';
                COMMENT ON COLUMN "public"."ct_shops"."is_block" IS \'Заблокировать магазин (доступно магазину)\';
                COMMENT ON COLUMN "public"."ct_shops"."is_active" IS \'Активная ли запись\';
                COMMENT ON COLUMN "public"."ct_shops"."name" IS \'Название магазина\';
                COMMENT ON COLUMN "public"."ct_shops"."official_name" IS \'Официальное название магазина\';
                COMMENT ON COLUMN "public"."ct_shops"."domain" IS \'Адрес внешнего домена\';
                COMMENT ON COLUMN "public"."ct_shops"."sub_domain" IS \'Адрес поддомена на сайте\';
                COMMENT ON COLUMN "public"."ct_shops"."currency_ids" IS \'Список ID курсов валют для магазина\';
                COMMENT ON COLUMN "public"."ct_shops"."default_currency_id" IS \'ID курса валюты используемые магазином по умолчанию\';
                COMMENT ON COLUMN "public"."ct_shops"."language_ids" IS \'Список ID языков для магазина\';
                COMMENT ON COLUMN "public"."ct_shops"."default_language_id" IS \'ID языка используемый магазином по умолчанию\';
                COMMENT ON COLUMN "public"."ct_shops"."city_id" IS \'ID города, где работает магазин\';
                COMMENT ON COLUMN "public"."ct_shops"."city_ids" IS \'Список городов магазина\';
                COMMENT ON COLUMN "public"."ct_shops"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ct_shops"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ct_shops"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ct_shops"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ct_shops"."seo" IS \'JSON массива настройки SEO\';
                COMMENT ON COLUMN "public"."ct_shops"."remarketing" IS \'Код ремаркетинга\';
                COMMENT ON COLUMN "public"."ct_shops"."collations" IS \'JSON список значений для сопоставления\';
                COMMENT ON COLUMN "public"."ct_shops"."requisites" IS \'Реквизиты\';
                COMMENT ON COLUMN "public"."ct_shops"."work_time" IS \'JSON времени работы магазина\';
                COMMENT ON COLUMN "public"."ct_shops"."delivery_work_time" IS \'JSON времени работы доставки \';
                COMMENT ON COLUMN "public"."ct_shops"."site_shablon_id" IS \'ID шаблона сайта магазина\';
                COMMENT ON COLUMN "public"."ct_shops"."site_shablon_path" IS \'Путь шаблона сайта\';
                COMMENT ON COLUMN "public"."ct_shops"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shops"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shops"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_shops"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ct_shops"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_shops"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_shops"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ct_shops"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_shops"."params" IS \'JSON Параметры магазина (например на какой e-mail слать письма)\';
                COMMENT ON COLUMN "public"."ct_shops"."shop_table_select_id" IS \'Тип выделения \';
                COMMENT ON COLUMN "public"."ct_shops"."shop_table_brand_id" IS \'ID бренда \';
                COMMENT ON TABLE "public"."ct_shops" IS \'Таблица магазинов\';
                
                -- ----------------------------
                -- Indexes structure for table ct_shops
                -- ----------------------------
                CREATE INDEX "shop_city_id" ON "public"."ct_shops" USING btree (
                  "city_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_first" ON "public"."ct_shops" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_index_id" ON "public"."ct_shops" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_index_order" ON "public"."ct_shops" USING btree (
                  "order" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_is_active" ON "public"."ct_shops" USING btree (
                  "is_active" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_is_block" ON "public"."ct_shops" USING btree (
                  "is_block" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_main_shop_id" ON "public"."ct_shops" USING btree (
                  "main_shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_name_like" ON "public"."ct_shops" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_old_id" ON "public"."ct_shops" USING btree (
                  "old_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_shop_root_id" ON "public"."ct_shops" USING btree (
                  "shop_root_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_shop_table_brand_id" ON "public"."ct_shops" USING btree (
                  "shop_table_brand_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_shop_table_rubric_id" ON "public"."ct_shops" USING btree (
                  "shop_table_rubric_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_shop_table_select_type_id" ON "public"."ct_shops" USING btree (
                  "shop_table_select_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_shop_table_unit_type_id" ON "public"."ct_shops" USING btree (
                  "shop_table_unit_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );',
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
        'main_shop_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID основного магазина',
            'table' => 'DB_User',
        ),
        'shop_root_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Родитель магазина',
        ),
        'shop_table_rubric_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => 'DB_Shop_Table_Rubric',
        ),
        'shop_table_catalog_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID тип филлиала',
            'table' => 'DB_Shop_Table_Catalog',
        ),
        'is_block' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Заблокировать магазин (доступно магазину)',
        ),
        'is_active' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Активная ли запись',
        ),
        'name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название магазина',
        ),
        'official_name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Официальное название магазина',
        ),
        'domain' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Адрес внешнего домена',
        ),
        'sub_domain' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Адрес поддомена на сайте',
        ),
        'currency_ids' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 500,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Список ID курсов валют для магазина',
        ),
        'default_currency_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID курса валюты используемые магазином по умолчанию',
            'table' => 'DB_Currency',
        ),
        'language_ids' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 500,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Список ID языков для магазина',
        ),
        'default_language_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID языка используемый магазином по умолчанию',
            'table' => 'DB_Language',
        ),
        'city_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID города, где работает магазин',
            'table' => 'DB_City',
        ),
        'city_ids' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 500,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Список городов магазина',
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
        'order' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
        ),
        'old_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
        ),
        'requisites' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Реквизиты',
        ),
        'work_time' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON времени работы магазина',
        ),
        'delivery_work_time' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON времени работы доставки ',
        ),
        'site_shablon_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID шаблона сайта магазина',
            'table' => 'DB_SiteShablon',
        ),
        'site_shablon_path' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 100,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Путь шаблона сайта',
        ),
        'shop_menu' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
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
        'params' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON Параметры магазина (например на какой e-mail слать письма)',
        ),
        'shop_table_select_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип выделения ',
            'table' => 'DB_Shop_Table_Select',
        ),
        'shop_table_brand_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID бренда ',
            'table' => 'DB_Shop_Table_Brand',
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
