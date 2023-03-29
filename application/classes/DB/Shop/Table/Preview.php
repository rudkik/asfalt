<?php defined('SYSPATH') or die('No direct script access.');

class DB_Shop_Table_Preview {
    const TABLE_NAME = 'ct_shop_table_previews';
    const TABLE_ID = 61;
    const NAME = 'DB_Shop_Table_Preview';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_shop_table_previews";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_shop_table_previews
                -- ----------------------------
                CREATE TABLE "public"."ct_shop_table_previews" (
                  "id" int8 NOT NULL,
                  "object_id" int8 NOT NULL,
                  "shop_id" int8 NOT NULL,
                  "table_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_catalog_id" int8 NOT NULL DEFAULT 0,
                  "preview_count" int8 NOT NULL DEFAULT 0,
                  "sales_count" int8 NOT NULL DEFAULT 0,
                  "storage_count" int4 NOT NULL DEFAULT 0,
                  "bill_count" int4 NOT NULL DEFAULT 0,
                  "rating" int8 NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass)
                )
                ;
                COMMENT ON COLUMN "public"."ct_shop_table_previews"."object_id" IS \'ID таблицы\';
                COMMENT ON COLUMN "public"."ct_shop_table_previews"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ct_shop_table_previews"."table_id" IS \'Тип объекта\';
                COMMENT ON COLUMN "public"."ct_shop_table_previews"."shop_table_catalog_id" IS \'ID записи\';
                COMMENT ON COLUMN "public"."ct_shop_table_previews"."preview_count" IS \'Количество просмотров\';
                COMMENT ON COLUMN "public"."ct_shop_table_previews"."sales_count" IS \'Количество проданных\';
                COMMENT ON COLUMN "public"."ct_shop_table_previews"."storage_count" IS \'Количество на складе\';
                COMMENT ON COLUMN "public"."ct_shop_table_previews"."bill_count" IS \'Количество заказов\';
                COMMENT ON COLUMN "public"."ct_shop_table_previews"."rating" IS \'Рейтинг\';
                COMMENT ON COLUMN "public"."ct_shop_table_previews"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ct_shop_table_previews"."global_id" IS \'Глобальный ID\';
                
                -- ----------------------------
                -- Primary Key structure for table ct_shop_table_previews
                -- ----------------------------
                ALTER TABLE "public"."ct_shop_table_previews" ADD CONSTRAINT "ct_shop_table_previews_pkey" PRIMARY KEY ("global_id");
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
        'object_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID таблицы',
        ),
        'shop_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID магазина',
            'table' => 'DB_Shop',
        ),
        'table_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип объекта',
            'table' => 'DB_Table',
        ),
        'shop_table_catalog_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID записи',
            'table' => 'DB_Shop_Table_Catalog',
        ),
        'preview_count' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Количество просмотров',
        ),
        'sales_count' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Количество проданных',
        ),
        'storage_count' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 9,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Количество на складе',
        ),
        'bill_count' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 9,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Количество заказов',
        ),
        'rating' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Рейтинг',
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
