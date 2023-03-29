<?php defined('SYSPATH') or die('No direct script access.');

class DB_Shop_Good_To_Operation {
    const TABLE_NAME = 'ct_shop_good_to_operations';
    const TABLE_ID = 61;
    const NAME = 'DB_Shop_Good_To_Operation';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_shop_good_to_operations";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_shop_good_to_operations
                -- ----------------------------
                CREATE TABLE "public"."ct_shop_good_to_operations" (
                  "id" int8 NOT NULL,
                  "shop_id" int8 NOT NULL,
                  "shop_good_id" int8 NOT NULL DEFAULT 0,
                  "shop_operation_id" int8 NOT NULL DEFAULT 0,
                  "price" numeric(14,2) NOT NULL DEFAULT 0,
                  "deleted_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "order" int4 NOT NULL DEFAULT 0,
                  "delete_user_id" int8 DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "create_user_id" int8 DEFAULT 0,
                  "update_user_id" int8 NOT NULL,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "updated_at" timestamp(6) NOT NULL
                )
                ;
                COMMENT ON COLUMN "public"."ct_shop_good_to_operations"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ct_shop_good_to_operations"."shop_good_id" IS \'ID родительского таблица\';
                COMMENT ON COLUMN "public"."ct_shop_good_to_operations"."shop_operation_id" IS \'ID родительского объекта\';
                COMMENT ON COLUMN "public"."ct_shop_good_to_operations"."price" IS \'ID родительского категория\';
                COMMENT ON COLUMN "public"."ct_shop_good_to_operations"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_shop_good_to_operations"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_good_to_operations"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_shop_good_to_operations"."order" IS \'Позиция для сортировки\';
                COMMENT ON COLUMN "public"."ct_shop_good_to_operations"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_shop_good_to_operations"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ct_shop_good_to_operations"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_good_to_operations"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_good_to_operations"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON TABLE "public"."ct_shop_good_to_operations" IS \'Таблица атрибутов\';
                
                -- ----------------------------
                -- Indexes structure for table ct_shop_good_to_operations
                -- ----------------------------
                CREATE INDEX "shop_good_to_operation_id" ON "public"."ct_shop_good_to_operations" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_good_to_operation_shop_good_id" ON "public"."ct_shop_good_to_operations" USING btree (
                  "shop_good_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_good_to_operation_shop_operation_id" ON "public"."ct_shop_good_to_operations" USING btree (
                  "shop_operation_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ct_shop_good_to_operations
                -- ----------------------------
                ALTER TABLE "public"."ct_shop_good_to_operations" ADD CONSTRAINT "ct_shop_table_object_to_objects_copy_pkey1" PRIMARY KEY ("global_id");
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
        'shop_good_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID родительского таблица',
            'table' => 'DB_Shop_Good',
        ),
        'shop_operation_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID родительского объекта',
            'table' => 'DB_Shop_Operation',
        ),
        'price' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 14,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'ID родительского категория',
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
