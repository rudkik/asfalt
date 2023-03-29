<?php defined('SYSPATH') or die('No direct script access.');

class DB_Sladushka_Shop_Worker_Good_Item {
    const TABLE_NAME = 'sl_shop_worker_good_items';
    const TABLE_ID = 61;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."sl_shop_worker_good_items";',
            'create' => '
                -- ----------------------------
                -- Table structure for sl_shop_worker_good_items
                -- ----------------------------
                CREATE TABLE "public"."sl_shop_worker_good_items" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
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
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "shop_worker_id" int8 DEFAULT 0,
                  "shop_worker_good_id" int8 DEFAULT 0,
                  "shop_good_id" int8 DEFAULT 0,
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "price" numeric(12,2) NOT NULL DEFAULT 0,
                  "quantity" numeric(12,3) NOT NULL DEFAULT 0,
                  "took" numeric(12,2) NOT NULL DEFAULT 0,
                  "return" numeric(12,2) NOT NULL DEFAULT 0,
                  "weight" numeric(12,2) NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."shop_worker_id" IS \'ID сотрудника\';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."shop_worker_good_id" IS \'ID заявки\';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."shop_good_id" IS \'ID продукта\';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."price" IS \'Цена\';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."quantity" IS \'Кол-во\';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."took" IS \'Забрал\';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."return" IS \'Отдал\';
                COMMENT ON COLUMN "public"."sl_shop_worker_good_items"."weight" IS \'Вес коробки\';
                
                -- ----------------------------
                -- Indexes structure for table sl_shop_worker_good_items
                -- ----------------------------
                CREATE INDEX "ab_shop_car_index_id_copy3_copy1_copy2_copy1" ON "public"."sl_shop_worker_good_items" USING btree (
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
        'shop_worker_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID сотрудника',
            'table' => 'DB_Sladushka_Shop_Worker',
        ),
        'shop_worker_good_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID заявки',
            'table' => 'DB_Sladushka_Shop_Worker_Good',
        ),
        'shop_good_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID продукта',
            'table' => 'DB_Shop_Good',
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма',
        ),
        'price' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена',
        ),
        'quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Кол-во',
        ),
        'took' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Забрал',
        ),
        'return' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Отдал',
        ),
        'weight' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Вес коробки',
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
