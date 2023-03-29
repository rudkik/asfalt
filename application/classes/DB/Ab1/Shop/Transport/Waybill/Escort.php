<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Transport_Waybill_Escort {
    const TABLE_NAME = 'ab_shop_transport_waybill_escorts';
    const TABLE_ID = 416;
    const NAME = 'DB_Ab1_Shop_Transport_Waybill_Escort';
    const TITLE = 'Сопровождающие лица в путевых листах';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_transport_waybill_escorts";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_transport_waybill_escorts
                -- ----------------------------
               CREATE TABLE "public"."ab_shop_transport_waybill_escorts" (
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
                  "shop_transport_driver_id" int8 NOT NULL DEFAULT 0,
                  "shop_worker_id" int8 NOT NULL DEFAULT 0,
                  "date" date,
                  "from_at" timestamp(6),
                  "to_at" timestamp(6),
                  "milage" numeric(12,2) NOT NULL DEFAULT 0,
                  "shop_transport_waybill_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_escorts"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_escorts"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_escorts"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_escorts"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_escorts"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_escorts"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_escorts"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_escorts"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_escorts"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_escorts"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_escorts"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_escorts"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_escorts"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_escorts"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_escorts"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_escorts"."shop_transport_driver_id" IS \'ID водителя\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_escorts"."shop_worker_id" IS \'ID сотрудника\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_escorts"."date" IS \'Дата путевого листа\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_escorts"."from_at" IS \'Время выезда\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_escorts"."to_at" IS \'Время въезда\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_escorts"."milage" IS \'Пробег за день\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_escorts"."shop_transport_waybill_id" IS \'ID путевого листа\';
                COMMENT ON TABLE "public"."ab_shop_transport_waybill_escorts" IS \'Список сопровождающих лиц в путевых листах\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_transport_waybill_escorts
                -- ----------------------------
                CREATE INDEX "ab_shop_transport_waybill_escort_date" ON "public"."ab_shop_transport_waybill_escorts" USING btree (
                  "date" "pg_catalog"."date_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_waybill_escort_first" ON "public"."ab_shop_transport_waybill_escorts" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_waybill_escort_index_id" ON "public"."ab_shop_transport_waybill_escorts" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_waybill_escort_shop_transport_driver_id" ON "public"."ab_shop_transport_waybill_escorts" USING btree (
                  "shop_transport_driver_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_waybill_escort_shop_transport_waybill_id" ON "public"."ab_shop_transport_waybill_escorts" USING btree (
                  "shop_transport_waybill_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_waybill_escort_shop_worker_id" ON "public"."ab_shop_transport_waybill_escorts" USING btree (
                  "shop_worker_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
            'title' => 'Название',
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
        'shop_transport_driver_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID водителя',
            'table' => 'DB_Ab1_Shop_Transport_Driver',
        ),
        'shop_worker_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID сотрудника',
            'table' => 'DB_Ab1_Shop_Worker',
        ),
        'date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата путевого листа',
        ),
        'from_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Время выезда',
        ),
        'to_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Время въезда',
        ),
        'milage' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Пробег за день',
        ),
        'shop_transport_waybill_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID путевого листа',
            'table' => 'DB_Ab1_Shop_Transport_Waybill',
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
