<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Material_Moisture {
    const TABLE_NAME = 'ab_shop_material_moistures';
    const TABLE_ID = 347;
    const NAME = 'DB_Ab1_Shop_Material_Moisture';
    const TITLE = 'Исследования материалов за каждый день на влажность и плотность';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_material_moistures";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_material_moistures
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_material_moistures" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "create_user_id" int8 DEFAULT 0,
                  "update_user_id" int8 NOT NULL,
                  "delete_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "shop_material_id" int8 NOT NULL DEFAULT 0,
                  "moisture" float8 NOT NULL DEFAULT 0,
                  "density" float8 NOT NULL DEFAULT 0,
                  "date" date,
                  "quantity" numeric(12,3) NOT NULL DEFAULT 0,
                  "shop_daughter_id" int8 NOT NULL DEFAULT 0,
                  "shop_branch_daughter_id" int8 NOT NULL DEFAULT 0,
                  "shop_raw_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_material_moistures"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_material_moistures"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_material_moistures"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_material_moistures"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_material_moistures"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_material_moistures"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_material_moistures"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_material_moistures"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_material_moistures"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_material_moistures"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_material_moistures"."shop_material_id" IS \'ID материала\';
                COMMENT ON COLUMN "public"."ab_shop_material_moistures"."moisture" IS \'Влажность материала\';
                COMMENT ON COLUMN "public"."ab_shop_material_moistures"."density" IS \'Плотность материала\';
                COMMENT ON COLUMN "public"."ab_shop_material_moistures"."date" IS \'Дата исследования\';
                COMMENT ON COLUMN "public"."ab_shop_material_moistures"."quantity" IS \'Количество завезеного материала за день\';
                COMMENT ON COLUMN "public"."ab_shop_material_moistures"."shop_daughter_id" IS \'ID поставщика\';
                COMMENT ON COLUMN "public"."ab_shop_material_moistures"."shop_branch_daughter_id" IS \'ID филиала отправитель\';
                COMMENT ON COLUMN "public"."ab_shop_material_moistures"."shop_raw_id" IS \'ID сырья\';
                COMMENT ON TABLE "public"."ab_shop_material_moistures" IS \'Список исследований материалов за каждый день на влажность и плотность\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_material_moistures
                -- ----------------------------
                CREATE INDEX "ab_shop_material_moisture_date" ON "public"."ab_shop_material_moistures" USING btree (
                  "date" "pg_catalog"."date_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_material_moisture_first" ON "public"."ab_shop_material_moistures" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_material_moisture_index" ON "public"."ab_shop_material_moistures" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_material_moisture_shop_branch_daughter_id" ON "public"."ab_shop_material_moistures" USING btree (
                  "shop_branch_daughter_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_material_moisture_shop_daughter_id" ON "public"."ab_shop_material_moistures" USING btree (
                  "shop_daughter_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_material_moisture_shop_material_id" ON "public"."ab_shop_material_moistures" USING btree (
                  "shop_material_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_material_moisture_shop_raw_id" ON "public"."ab_shop_material_moistures" USING btree (
                  "shop_raw_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ab_shop_material_moistures
                -- ----------------------------
                ALTER TABLE "public"."ab_shop_material_moistures" ADD CONSTRAINT "ab_shop_client_attorney_balances_copy1_pkey" PRIMARY KEY ("global_id");
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
        'shop_material_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID материала',
            'table' => 'DB_Ab1_Shop_Material',
        ),
        'moisture' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 53,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Влажность материала',
        ),
        'density' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 53,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Плотность материала',
        ),
        'date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата исследования',
        ),
        'quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество завезеного материала за день',
        ),
        'shop_daughter_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID поставщика',
            'table' => 'DB_Ab1_Shop_Daughter',
        ),
        'shop_branch_daughter_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID филиала отправитель',
            'table' => 'DB_Shop',
        ),
        'shop_raw_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID сырья',
            'table' => 'DB_Ab1_Shop_Raw',
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
