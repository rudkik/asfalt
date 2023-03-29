<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Register_Raw {
    const TABLE_NAME = 'ab_shop_register_raws';
    const TABLE_ID = 339;
    const NAME = 'DB_Ab1_Shop_Register_Raw';
    const TITLE = 'Регистр учета сырья';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_register_raws";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_register_raws
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_register_raws" (
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
                  "price" numeric(12,2) NOT NULL DEFAULT 0,
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "shop_transport_company_id" int8 NOT NULL DEFAULT 0,
                  "shop_subdivision_id" int8 NOT NULL DEFAULT 0,
                  "shop_heap_id" int8 NOT NULL DEFAULT 0,
                  "shop_object_id" int8 NOT NULL DEFAULT 0,
                  "table_id" int8 NOT NULL DEFAULT 0,
                  "shop_formula_raw_id" int8 NOT NULL DEFAULT 0,
                  "shop_ballast_crusher_id" int8 NOT NULL DEFAULT 0,
                  "shop_raw_id" int8 NOT NULL DEFAULT 0,
                  "shop_formula_material_id" int8 NOT NULL DEFAULT 0,
                  "root_shop_register_material_id" int8 NOT NULL DEFAULT 0,
                  "root_shop_register_raw_id" int8 NOT NULL DEFAULT 0,
                  "level" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."quantity" IS \'Количество\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."price" IS \'Цена\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."shop_transport_company_id" IS \'ID транспортная компания\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."shop_subdivision_id" IS \'ID подразделения откуда произошла реализация\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."shop_heap_id" IS \'ID места забора/прихода сырья\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."shop_object_id" IS \'ID объекта (Производство сырья дробилками т.д.)\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."table_id" IS \'ID таблица\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."shop_formula_raw_id" IS \'ID рецепта сырья (для производства сырья из сырья)\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."shop_ballast_crusher_id" IS \'ID технологической линии\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."shop_raw_id" IS \'ID сырья\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."shop_formula_material_id" IS \'ID формулы производства материала\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."root_shop_register_material_id" IS \'От какого материала произошло производство\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."root_shop_register_raw_id" IS \'От какого сырья произошло производство\';
                COMMENT ON COLUMN "public"."ab_shop_register_raws"."level" IS \'Уровень вложенности\';
                COMMENT ON TABLE "public"."ab_shop_register_raws" IS \'Регистр учета сырья\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_register_raws
                -- ----------------------------
                CREATE INDEX "ab_shop_register_raw_first" ON "public"."ab_shop_register_raws" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_register_raw_index_id" ON "public"."ab_shop_register_raws" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_register_raw_level" ON "public"."ab_shop_register_raws" USING btree (
                  "level" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_register_raw_root_shop_register_material_id" ON "public"."ab_shop_register_raws" USING btree (
                  "root_shop_register_material_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_register_raw_root_shop_register_raw_id" ON "public"."ab_shop_register_raws" USING btree (
                  "root_shop_register_raw_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_register_raw_shop_ballast_crusher_id" ON "public"."ab_shop_register_raws" USING btree (
                  "shop_ballast_crusher_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_register_raw_shop_formula_material_id" ON "public"."ab_shop_register_raws" USING btree (
                  "shop_formula_material_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_register_raw_shop_heap_id" ON "public"."ab_shop_register_raws" USING btree (
                  "shop_heap_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_register_raw_shop_material_id" ON "public"."ab_shop_register_raws" USING btree (
                  "shop_raw_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_register_raw_shop_object_id" ON "public"."ab_shop_register_raws" USING btree (
                  "shop_object_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_register_raw_shop_subdivision_id" ON "public"."ab_shop_register_raws" USING btree (
                  "shop_subdivision_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_register_raw_table_id" ON "public"."ab_shop_register_raws" USING btree (
                  "table_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'price' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена',
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма',
        ),
        'shop_transport_company_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID транспортная компания',
            'table' => 'DB_Ab1_Shop_Transport_Company',
        ),
        'shop_subdivision_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID подразделения откуда произошла реализация',
            'table' => 'DB_Ab1_Shop_Subdivision',
        ),
        'shop_heap_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID места забора/прихода сырья',
            'table' => 'DB_Ab1_Shop_Heap',
        ),
        'shop_object_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID объекта (Производство сырья дробилками т.д.)',
        ),
        'table_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID таблица',
            'table' => 'DB_Table',
        ),
        'shop_formula_raw_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID рецепта сырья (для производства сырья из сырья)',
            'table' => 'DB_Ab1_Shop_Formula_Raw',
        ),
        'shop_ballast_crusher_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID технологической линии',
            'table' => 'DB_Ab1_Shop_Ballast_Crusher',
        ),
        'shop_raw_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID сырья',
            'table' => 'DB_Ab1_Shop_Raw',
        ),
        'shop_formula_material_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID формулы производства материала',
            'table' => 'DB_Ab1_Shop_Formula_Material',
        ),
        'root_shop_register_material_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'От какого материала произошло производство',
            'table' => 'DB_Ab1_Shop_Register_Material',
        ),
        'root_shop_register_raw_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'От какого сырья произошло производство',
            'table' => 'DB_Ab1_Shop_Register_Raw',
        ),
        'level' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Уровень вложенности',
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
