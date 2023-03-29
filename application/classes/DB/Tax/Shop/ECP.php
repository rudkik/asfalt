<?php defined('SYSPATH') or die('No direct script access.');

class DB_Tax_Shop_ECP {
    const TABLE_NAME = 'tax_shop_ecps';
    const TABLE_ID = 61;
    const NAME = 'DB_Tax_Shop_ECP';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."tax_shop_ecps";',
            'create' => '
                -- ----------------------------
                -- Table structure for tax_shop_ecps
                -- ----------------------------
                CREATE TABLE "public"."tax_shop_ecps" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "shop_table_catalog_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_rubric_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_select_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_brand_id" int8 NOT NULL DEFAULT 0,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "text" text COLLATE "pg_catalog"."default",
                  "image_path" varchar(100) COLLATE "pg_catalog"."default",
                  "files" text COLLATE "pg_catalog"."default",
                  "options" text COLLATE "pg_catalog"."default",
                  "seo" text COLLATE "pg_catalog"."default",
                  "remarketing" text COLLATE "pg_catalog"."default",
                  "collations" text COLLATE "pg_catalog"."default",
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
                  "shop_table_object_ids" text COLLATE "pg_catalog"."default",
                  "shop_table_unit_id" int8 NOT NULL DEFAULT 0,
                  "auth_password" varchar(50) COLLATE "pg_catalog"."default",
                  "gostknca_password" varchar(50) COLLATE "pg_catalog"."default",
                  "auth_file" varchar(250) COLLATE "pg_catalog"."default",
                  "auth_name" varchar(250) COLLATE "pg_catalog"."default",
                  "gostknca_file" varchar(250) COLLATE "pg_catalog"."default",
                  "gostknca_name" varchar(250) COLLATE "pg_catalog"."default"
                )
                ;
                COMMENT ON COLUMN "public"."tax_shop_ecps"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."shop_table_catalog_id" IS \'Тип товара\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."shop_table_rubric_id" IS \'ID рубрики\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."shop_table_select_id" IS \'Тип выделения \';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."shop_table_brand_id" IS \'ID бренда \';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."seo" IS \'JSON массива настройки SEO\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."remarketing" IS \'Код ремаркетинга\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."collations" IS \'JSON список значений для сопоставления\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."shop_table_object_ids" IS \'JSON данные списком\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."shop_table_unit_id" IS \'Тип единицы измерения\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."auth_password" IS \'Пароль от ключа на авторизацию\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."gostknca_password" IS \'Пароль от ключа на подпись\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."auth_file" IS \'Файл авторизации в личном кабинете\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."auth_name" IS \'Имя файла авторизации в личном кабинете\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."gostknca_file" IS \'Файл авторизации в личном кабинете\';
                COMMENT ON COLUMN "public"."tax_shop_ecps"."gostknca_name" IS \'Имя файла авторизации в личном кабинете\';
                
                -- ----------------------------
                -- Indexes structure for table tax_shop_ecps
                -- ----------------------------
                CREATE INDEX "ab_shop_car_first_copy4_copy2_copy1" ON "public"."tax_shop_ecps" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_table_catalog_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_index_id_copy4_copy2_copy1" ON "public"."tax_shop_ecps" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'shop_table_object_ids' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON данные списком',
        ),
        'shop_table_unit_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип единицы измерения',
            'table' => 'DB_Shop_Table_Unit',
        ),
        'auth_password' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Пароль от ключа на авторизацию',
        ),
        'gostknca_password' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Пароль от ключа на подпись',
        ),
        'auth_file' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Файл авторизации в личном кабинете',
        ),
        'auth_name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Имя файла авторизации в личном кабинете',
        ),
        'gostknca_file' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Файл авторизации в личном кабинете',
        ),
        'gostknca_name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Имя файла авторизации в личном кабинете',
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
