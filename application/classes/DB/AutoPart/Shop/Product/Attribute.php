<?php defined('SYSPATH') or die('No direct script access.');

class DB_AutoPart_Shop_Product_Attribute {
    const TABLE_NAME = 'ap_shop_product_attributes';
    const TABLE_ID = 431;
    const NAME = 'DB_AutoPart_Shop_Product_Attribute';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ap_shop_product_attributes";',
            'create' => '
                -- ----------------------------
                -- Table structure for ap_shop_attributes
                -- ----------------------------
                CREATE TABLE "public"."ap_shop_attributes" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1,0) NOT NULL DEFAULT 1,
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
                  "is_delete" numeric(1,0) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "attribute_type_id" int8 NOT NULL DEFAULT 0
                  "shop_product_attribute_type_id" int8 NOT NULL DEFAULT 0
                  "shop_product_attribute_rubric_id" int8 NOT NULL DEFAULT 0
                )
                ;
                ALTER TABLE "public"."ap_shop_attributes" OWNER TO "postgres";
                COMMENT ON COLUMN "public"."ap_shop_attributes"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_attributes"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ap_shop_attributes"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."ap_shop_attributes"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ap_shop_attributes"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ap_shop_attributes"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ap_shop_attributes"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ap_shop_attributes"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_attributes"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_attributes"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ap_shop_attributes"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ap_shop_attributes"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ap_shop_attributes"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_attributes"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ap_shop_attributes"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ap_shop_attributes"."attribute_type_id" IS \'ID типа атрибута\';
                COMMENT ON TABLE "public"."ap_shop_attributes" IS \'Список атрибутов продукции\';
                
                -- ----------------------------
                -- Indexes structure for table ap_shop_attributes
                -- ----------------------------
                CREATE INDEX "ap_shop_attribute_attribute_type_id" ON "public"."ap_shop_attributes" USING btree (
                  "attribute_type_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_attribute_first" ON "public"."ap_shop_attributes" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_attribute_index_id" ON "public"."ap_shop_attributes" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_attribute_name" ON "public"."ap_shop_attributes" USING btree (
                  "name" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_attribute_shop_product_attribute_type_id" ON "public"."ap_shop_attributes" USING btree (
                  "shop_product_attribute_type_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ap_shop_attribute_shop_product_attribute_rubric_id" ON "public"."ap_shop_attributes" USING btree (
                  "shop_product_attribute_rubric_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
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
            'type' => DB_FieldType::FIELD_TYPE_STRING,
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
        'shop_attribute_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID атрибута',
            'table' => 'DB_AutoPart_Shop_Attribute',
        ),
        'shop_product_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID продукции',
            'table' => 'DB_AutoPart_Shop_Product',
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
