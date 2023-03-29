<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Ballast {
    const TABLE_NAME = 'ab_shop_ballasts';
    const TABLE_ID = 188;
    const NAME = 'DB_Ab1_Shop_Ballast';
    const TITLE = 'Перевозки балласта';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_ballasts";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_ballasts
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_ballasts" (
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
                  "shop_ballast_car_id" int8 NOT NULL DEFAULT 0,
                  "shop_ballast_driver_id" int8 NOT NULL DEFAULT 0,
                  "quantity" numeric(12,3) NOT NULL DEFAULT 0,
                  "date" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "shop_ballast_crusher_id" int8 NOT NULL DEFAULT 0,
                  "shop_ballast_distance_id" int8 NOT NULL DEFAULT 0,
                  "is_storage" numeric(1) NOT NULL DEFAULT 0,
                  "tariff" numeric(12,2) NOT NULL DEFAULT 0,
                  "shop_work_shift_id" int8 NOT NULL DEFAULT 0,
                  "shop_raw_id" int8 NOT NULL DEFAULT 423186,
                  "take_shop_ballast_crusher_id" int8 NOT NULL DEFAULT 0,
                  "tariff_holiday" numeric(12,2) NOT NULL DEFAULT 0,
                  "shop_transport_id" int8,
                  "shop_transport_waybill_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."shop_ballast_car_id" IS \'ID машины\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."shop_ballast_driver_id" IS \'ID водителя\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."quantity" IS \'Количество\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."date" IS \'Время выезда\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."shop_ballast_crusher_id" IS \'ID дробилки\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."shop_ballast_distance_id" IS \'ID дистанции\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."is_storage" IS \'Складирование\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."tariff" IS \'Стоимость рейса в будничный день\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."shop_work_shift_id" IS \'ID смены\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."shop_raw_id" IS \'ID сырья (по умолчанию балласт)\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."take_shop_ballast_crusher_id" IS \'ID дробилки/места откуда взяли балласт (0 карьер)\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."tariff_holiday" IS \'Надценка стоимости рейса в праздничный день\';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."shop_transport_id" IS \'ID транспорта АТЦ \';
                COMMENT ON COLUMN "public"."ab_shop_ballasts"."shop_transport_waybill_id" IS \'ID путевого листа\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_ballasts
                -- ----------------------------
                CREATE INDEX "ab_shop_ballast_first" ON "public"."ab_shop_ballasts" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_ballast_index_id" ON "public"."ab_shop_ballasts" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_ballast_shop_ballast_crusher_id" ON "public"."ab_shop_ballasts" USING btree (
                  "shop_ballast_crusher_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_ballast_shop_ballast_distance_id" ON "public"."ab_shop_ballasts" USING btree (
                  "shop_ballast_distance_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_ballast_shop_transport_id" ON "public"."ab_shop_ballasts" USING btree (
                  "shop_transport_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_ballast_shop_transport_waybill_id" ON "public"."ab_shop_ballasts" USING btree (
                  "shop_transport_waybill_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_ballast_shop_work_shift_id" ON "public"."ab_shop_ballasts" USING btree (
                  "shop_work_shift_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'shop_ballast_car_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID машины',
            'table' => 'DB_Ab1_Shop_Ballast_Car',
        ),
        'shop_ballast_driver_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID водителя',
            'table' => 'DB_Ab1_Shop_Ballast_Driver',
        ),
        'quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество',
        ),
        'date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Время выезда',
        ),
        'shop_ballast_crusher_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID дробилки',
            'table' => 'DB_Ab1_Shop_Ballast_Crusher',
        ),
        'shop_ballast_distance_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID дистанции',
            'table' => 'DB_Ab1_Shop_Ballast_Distance',
        ),
        'is_storage' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Складирование',
        ),
        'tariff' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 5,
            'is_not_null' => true,
            'title' => 'Стоимость рейса',
        ),
        'shop_work_shift_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID смены',
            'table' => 'DB_Ab1_Shop_Work_Shift',
        ),
        'shop_raw_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID сырья',
            'table' => 'DB_Ab1_Shop_Raw',
        ),
        'take_shop_ballast_crusher_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID откуда забрали',
            'table' => 'DB_Ab1_Shop_Ballast_Crusher',
        ),
        'tariff_holiday' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Наценка стоимости рейса в праздничный день',
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
