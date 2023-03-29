<?php defined('SYSPATH') or die('No direct script access.');

class DB_AutoPart_Shop_Supplier {
    const TABLE_NAME = 'ap_shop_suppliers';
    const TABLE_ID = 61;
    const NAME = 'DB_AutoPart_Shop_Supplier';
    const TITLE = 'Список поставщиков';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ap_shop_suppliers";',
            'create' => '
                -- ----------------------------
                -- Table structure for ap_shop_suppliers
                -- ----------------------------
                CREATE TABLE "public"."ap_shop_suppliers" (
                      
				"id" int8 NOT NULL ,
				"is_public" numeric(1,0) NOT NULL  DEFAULT 1,
				"shop_id" int8 NOT NULL ,
				"name" varchar(250) COLLATE "pg_catalog"."default"  ,
				"text" text  ,
				"options" text  ,
				"image_path" varchar(255) COLLATE "pg_catalog"."default"   DEFAULT NULL::character varying,
				"files" text  ,
				"seo" text  ,
				"create_user_id" int8   DEFAULT 0,
				"update_user_id" int8 NOT NULL ,
				"delete_user_id" int8   DEFAULT 0,
				"created_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
				"updated_at" timestamp(6) NOT NULL ,
				"deleted_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
				"is_delete" numeric(1,0) NOT NULL  DEFAULT 0,
				"language_id" int8 NOT NULL  DEFAULT 35,
				"global_id" int8 NOT NULL  DEFAULT nextval(\'global_id\'::regclass),
				"order" int4 NOT NULL  DEFAULT 0,
				"is_translates" json  ,
				"name_url" text   DEFAULT NULL::character varying,
				"integrations" text   DEFAULT NULL::character varying,
				"is_disable_dumping" numeric(1,0) NOT NULL  DEFAULT 0,
				"min_markup" numeric(12,2) NOT NULL  DEFAULT 5000,
				"name_organization" varchar(250) COLLATE "pg_catalog"."default"  ,
				"bank_name" varchar(250) COLLATE "pg_catalog"."default"  ,
				"bank_id" int8 NOT NULL  DEFAULT 0,
				"bank_number" varchar(250) COLLATE "pg_catalog"."default"  ,
				"director_name" varchar(250) COLLATE "pg_catalog"."default"  ,
				"director_position" varchar(250) COLLATE "pg_catalog"."default"  ,
				"legal_address" varchar(250) COLLATE "pg_catalog"."default"  ,
				"post_address" varchar(250) COLLATE "pg_catalog"."default"  ,
                );
                ALTER TABLE "public"."ap_shop_suppliers" OWNER TO "postgres";
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."name" IS \'Название каталога\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."text" IS \'Описание каталога (HTML-код)\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."options" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."image_path" IS \'Путь к изображению рубрики\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."seo" IS \'JSON массива настройки SEO\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."created_at" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."order" IS \'Позиция для сортировки\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."is_translates" IS \'JSON если ли перевод по языкам\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."name_url" IS \'Название для URL\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."integrations" IS \'JSON интеграции с другими системами (настройки загрузки прайс листов)\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."is_disable_dumping" IS \'Отключаем демпинг цен\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."min_markup" IS \'Минимальная наценка на товар\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."name_organization" IS \'Название организации\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."bank_name" IS \'Название банка\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."bank_id" IS \'ID Банка\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."bank_number" IS \'номер счета\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."director_name" IS \'ФИО\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."director_position" IS \'должность\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."legal_address" IS \'Юридические адреса\';
                COMMENT ON COLUMN "public"."ap_shop_suppliers"."post_address" IS \'Почтовой адрес\';
                
               CREATE INDEX "ap_shop_supplier_first" ON "public"."ap_shop_suppliers" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_supplier_index_id" ON "public"."ap_shop_suppliers" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_supplier_bank_id" ON "public"."ap_shop_suppliers" USING btree (
                  "bank_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_supplier_index_order" ON "public"."ap_shop_suppliers" USING btree (
                  "order" "pg_catalog"."int4_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_supplier_name_like" ON "public"."ap_shop_suppliers" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_supplier_name_url" ON "public"."ap_shop_suppliers" USING btree (
                  "name_url" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ap_shop_suppliers
                -- ----------------------------
                ALTER TABLE "public"."ap_shop_suppliers" ADD CONSTRAINT "ap_shop_brands_copy1_pkey" PRIMARY KEY ("global_id"); 
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
            'table' => '',
        ),
        'is_public' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Опубликована ли запись',
            'table' => '',
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
            'table' => '',
        ),
        'text' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Описание каталога (HTML-код)',
            'table' => '',
        ),
        'options' => array(
            'type' => DB_FieldType::FIELD_TYPE_JSON,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => '',
            'table' => '',
        ),
        'image_path' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 255,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Путь к изображению рубрики',
            'table' => '',
        ),
        'files' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дополнительные файлы',
            'table' => '',
        ),
        'seo' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON массива настройки SEO',
            'table' => '',
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
            'table' => '',
        ),
        'updated_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Дата обновления записи',
            'table' => '',
        ),
        'deleted_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата удаления записи',
            'table' => '',
        ),
        'is_delete' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Удалена ли запись',
            'table' => '',
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
            'table' => '',
        ),
        'order' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 9,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Позиция для сортировки',
            'table' => '',
        ),
        'is_translates' => array(
            'type' => DB_FieldType::FIELD_TYPE_JSON,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON если ли перевод по языкам',
            'table' => '',
        ),
        'name_url' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название для URL',
            'table' => '',
        ),
        'integrations' => array(
            'type' => DB_FieldType::FIELD_TYPE_JSON,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON интеграции с другими системами (настройки загрузки прайс листов)',
            'table' => '',
        ),
        'is_disable_dumping' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Отключаем демпинг цен',
            'table' => '',
        ),
        'min_markup' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Минимальная наценка на товар',
            'table' => '',
        ),
        'phone' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 12,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Минимальная наценка на товар',
            'table' => '',
        ),
        'bin' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'БИН',
            'table' => '',
        ),
        'name_organization' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Название организации',
            'table' => '',
        ),
        'bank_name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Название банка',
            'table' => '',
        ),
        'bank_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID Банка',
            'table' => 'DB_Bank',
        ),
        'bank_number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'номер счета',
            'table' => '',
        ),
        'director_name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ФИО',
            'table' => '',
        ),
        'director_position' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'должность
',
            'table' => '',
        ),
        'legal_address' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Юридические адреса',
            'table' => '',
        ),
        'post_address' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Почтовой адрес',
            'table' => '',
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
