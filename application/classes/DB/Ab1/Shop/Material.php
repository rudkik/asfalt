<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Material {
    const TABLE_NAME = 'ab_shop_materials';
    const TABLE_ID = 79;
    const NAME = 'DB_Ab1_Shop_Material';
    const TITLE = 'Материалы';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_materials";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_materials
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_materials" (
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
                  "name_1c" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "name_site" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "unit" varchar(15) COLLATE "pg_catalog"."default",
                  "product_type_1c" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "type_1c" varchar(15) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "shop_material_rubric_id" int8 NOT NULL DEFAULT 0,
                  "coefficient_recipe" numeric(12,3),
                  "price" numeric(10,2),
                  "access_formula_type_ids" text COLLATE "pg_catalog"."default",
                  "unit_recipe" varchar(15) COLLATE "pg_catalog"."default",
                  "name_recipe" text COLLATE "pg_catalog"."default",
                  "formula_type_ids" text COLLATE "pg_catalog"."default",
                  "is_weighted" numeric(1) NOT NULL DEFAULT 1,
                  "is_moisture_and_density" numeric(1) NOT NULL DEFAULT 0,
                  "shop_material_rubric_make_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_materials"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_materials"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."name_1c" IS \'Название в 1C\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."name_site" IS \'Название на сайте\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."unit" IS \'Единица измерения\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."product_type_1c" IS \'Тип продукта для 1С\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."type_1c" IS \'Тип 1С\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."shop_material_rubric_id" IS \'ID рубрики\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."coefficient_recipe" IS \'Коэфициент для рецептов\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."access_formula_type_ids" IS \'ID типов рецептов в которых учавствует\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."unit_recipe" IS \'Единица измерения рецепта\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."name_recipe" IS \'Название по рецепту\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."formula_type_ids" IS \'ID типов рецептов для отображения\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."is_weighted" IS \'Выводить ли материал в Весовой\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."is_moisture_and_density" IS \'У материала возможно ли вычисления влажности и плотности\';
                COMMENT ON COLUMN "public"."ab_shop_materials"."shop_material_rubric_make_id" IS \'ID рубрики для производства\';
                COMMENT ON TABLE "public"."ab_shop_materials" IS \'Список материалов\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_materials
                -- ----------------------------
                CREATE INDEX "ab_shop_material_first" ON "public"."ab_shop_materials" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_material_index_id" ON "public"."ab_shop_materials" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_material_is_weighted" ON "public"."ab_shop_materials" USING btree (
                  "is_weighted" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_material_shop_material_rubric_id" ON "public"."ab_shop_materials" USING btree (
                  "shop_material_rubric_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'name_1c' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название в 1C',
        ),
        'name_site' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название на сайте',
        ),
        'unit' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 15,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Единица измерения',
        ),
        'product_type_1c' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Тип продукта для 1С',
        ),
        'type_1c' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 15,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Тип 1С',
        ),
        'shop_material_rubric_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID рубрики',
            'table' => 'DB_Ab1_Shop_Material_Rubric',
        ),
        'coefficient_recipe' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => false,
            'title' => 'Коэфициент для рецептов',
        ),
        'price' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 10,
            'decimal' => 2,
            'is_not_null' => false,
            'title' => '',
        ),
        'access_formula_type_ids' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID типов рецептов в которых учавствует',
        ),
        'unit_recipe' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 15,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Единица измерения рецепта',
        ),
        'name_recipe' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название по рецепту',
        ),
        'formula_type_ids' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID типов рецептов для отображения',
        ),
        'is_weighted' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Выводить ли материал в Весовой',
        ),
        'is_moisture_and_density' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'У материала возможно ли вычисления влажности и плотности',
        ),
        'shop_material_rubric_make_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID рубрики для производства',
            'table' => 'DB_Ab1_Shop_Material_Rubric_Make',
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
