<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Move_Other {
    const TABLE_NAME = 'ab_shop_move_others';
    const TABLE_ID = 218;
    const NAME = 'DB_Ab1_Shop_Move_Other';
    const TITLE = 'Перемещение прочих материалов';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_move_others";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_move_others
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_move_others" (
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
                  "quantity" numeric(12,3) NOT NULL DEFAULT 0,
                  "shop_driver_id" int8 NOT NULL DEFAULT 0,
                  "exit_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "arrival_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "weighted_exit_operation_id" int8 DEFAULT 0,
                  "weighted_exit_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "tarra" numeric(12,3) NOT NULL DEFAULT 0,
                  "shop_transport_company_id" int8 NOT NULL DEFAULT 0,
                  "is_test" numeric(1) NOT NULL DEFAULT 0,
                  "shop_move_place_id" int8 NOT NULL DEFAULT 0,
                  "shop_material_id" int8 NOT NULL DEFAULT 0,
                  "shop_car_tare_id" int8 NOT NULL DEFAULT 0,
                  "shop_material_other_id" int8 NOT NULL DEFAULT 0,
                  "shop_formula_material_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_move_others"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."quantity" IS \'Количество\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."shop_driver_id" IS \'ID водителя\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."exit_at" IS \'Время выезда\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."arrival_at" IS \'Время заезда\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."weighted_exit_operation_id" IS \'Оператор Весовая выезд\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."weighted_exit_at" IS \'Дата обработки Весовая выезд\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."tarra" IS \'Вес тары\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."is_test" IS \'Вес загружается вручную\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."shop_move_place_id" IS \'ID клиентa\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."shop_material_id" IS \'ID куда вывезли\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."shop_car_tare_id" IS \'ID тары\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."shop_material_other_id" IS \'ID материал прочее\';
                COMMENT ON COLUMN "public"."ab_shop_move_others"."shop_formula_material_id" IS \'ID рецепта материала (для списания материала)\';
                COMMENT ON TABLE "public"."ab_shop_move_others" IS \'Перемещение прочих материалов\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_move_others
                -- ----------------------------
                CREATE INDEX "ab_shop_move_other_index_id" ON "public"."ab_shop_move_others" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_move_other_shop_driver_id" ON "public"."ab_shop_move_others" USING btree (
                  "shop_driver_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_move_other_shop_material_id" ON "public"."ab_shop_move_others" USING btree (
                  "shop_material_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_move_other_shop_material_other_id" ON "public"."ab_shop_move_others" USING btree (
                  "shop_material_other_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_move_other_shop_move_place_id" ON "public"."ab_shop_move_others" USING btree (
                  "shop_move_place_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_move_other_shop_transport_company_id" ON "public"."ab_shop_move_others" USING btree (
                  "shop_transport_company_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_move_other_weighted_exit_operation_id" ON "public"."ab_shop_move_others" USING btree (
                  "weighted_exit_operation_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество',
        ),
        'shop_driver_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID водителя',
            'table' => 'DB_Ab1_Shop_Driver',
        ),
        'exit_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Время выезда',
        ),
        'arrival_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Время заезда',
        ),
        'weighted_exit_operation_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Оператор Весовая выезд',
            'table' => 'DB_Shop_Operation',
        ),
        'weighted_exit_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата обработки Весовая выезд',
        ),
        'tarra' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Вес тары',
        ),
        'shop_transport_company_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => 'DB_Ab1_Shop_Transport_Company',
        ),
        'is_test' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Вес загружается вручную',
        ),
        'shop_move_place_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID клиентa',
            'table' => 'DB_Ab1_Shop_Move_Place',
        ),
        'shop_material_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID куда вывезли',
            'table' => 'DB_Ab1_Shop_Material',
        ),
        'shop_car_tare_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID тары',
            'table' => 'DB_Ab1_Shop_Car_Tare',
        ),
        'shop_material_other_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID материал прочее',
            'table' => 'DB_Ab1_Shop_Material_Other',
        ),
        'shop_transport_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID транспорта АТЦ',
            'table' => 'DB_Ab1_Shop_Transport',
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
