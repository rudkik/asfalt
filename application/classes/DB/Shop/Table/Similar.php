<?php defined('SYSPATH') or die('No direct script access.');

class DB_Shop_Table_Similar {
    const TABLE_NAME = 'ct_shop_table_similars';
    const TABLE_ID = 61;
    const NAME = 'DB_Shop_Table_Similar';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_shop_table_similars";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_shop_table_similars
                -- ----------------------------
                CREATE TABLE "public"."ct_shop_table_similars" (
                  "id" int8 NOT NULL,
                  "shop_id" int8 NOT NULL,
                  "root_table_id" int8 NOT NULL DEFAULT 0,
                  "shop_root_object_id" int8 NOT NULL DEFAULT 0,
                  "shop_root_catalog_id" int8 NOT NULL DEFAULT 0,
                  "shop_child_object_id" int8 NOT NULL DEFAULT 0,
                  "deleted_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "order" int4 NOT NULL DEFAULT 0,
                  "delete_user_id" int8 DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35
                )
                ;
                COMMENT ON COLUMN "public"."ct_shop_table_similars"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ct_shop_table_similars"."root_table_id" IS \'ID родительского таблица\';
                COMMENT ON COLUMN "public"."ct_shop_table_similars"."shop_root_object_id" IS \'ID родительского объекта\';
                COMMENT ON COLUMN "public"."ct_shop_table_similars"."shop_root_catalog_id" IS \'ID родительского категория\';
                COMMENT ON COLUMN "public"."ct_shop_table_similars"."shop_child_object_id" IS \'ID ребенка объекта\';
                COMMENT ON COLUMN "public"."ct_shop_table_similars"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_shop_table_similars"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_table_similars"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_shop_table_similars"."order" IS \'Позиция для сортировки\';
                COMMENT ON COLUMN "public"."ct_shop_table_similars"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_shop_table_similars"."language_id" IS \'ID языка\';
                COMMENT ON TABLE "public"."ct_shop_table_similars" IS \'Таблица подобный товаров\';
                
                -- ----------------------------
                -- Indexes structure for table ct_shop_table_similars
                -- ----------------------------
                CREATE INDEX "shop_table_similiar_first" ON "public"."ct_shop_table_similars" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_table_similiar_id" ON "public"."ct_shop_table_similars" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_table_similiar_index_order" ON "public"."ct_shop_table_similars" USING btree (
                  "order" "pg_catalog"."int4_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_table_similiar_shop_child_object_id" ON "public"."ct_shop_table_similars" USING btree (
                  "shop_child_object_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_table_similiar_shop_root_catalog_id" ON "public"."ct_shop_table_similars" USING btree (
                  "shop_root_catalog_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_table_similiar_shop_root_object_id" ON "public"."ct_shop_table_similars" USING btree (
                  "shop_root_object_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_table_similiar_shop_root_table_id" ON "public"."ct_shop_table_similars" USING btree (
                  "root_table_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ct_shop_table_similars
                -- ----------------------------
                ALTER TABLE "public"."ct_shop_table_similars" ADD CONSTRAINT "ct_shop_good_similars_pkey" PRIMARY KEY ("global_id");
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
        'root_table_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID родительского таблица',
            'table' => 'DB_Table',
        ),
        'shop_root_object_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID родительского объекта',
        ),
        'shop_root_catalog_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID родительского категория',
        ),
        'shop_child_object_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID ребенка объекта',
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
        'delete_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Кто удалил запись',
            'table' => 'DB_User',
        ),
        'language_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID языка',
            'table' => 'DB_Language',
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
