<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Formula_Material {
    const TABLE_NAME = 'ab_shop_formula_materials';
    const TABLE_ID = 107;
    const NAME = 'DB_Ab1_Shop_Formula_Material';
    const TITLE = 'Рецепт производства материала из сырья';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_formula_materials";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_formula_materials
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_formula_materials" (
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
                  "shop_material_id" int8 NOT NULL DEFAULT 0,
                  "wet" numeric(12,11) NOT NULL DEFAULT 0,
                  "contract_number" varchar(64) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "contract_date" date DEFAULT NULL::timestamp without time zone,
                  "formula_type_id" int8 NOT NULL DEFAULT 99,
                  "is_start" numeric(1) NOT NULL DEFAULT 1,
                  "from_at" date,
                  "to_at" date
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."shop_material_id" IS \'ID производимого материала\';
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."wet" IS \'Влажность\';
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."contract_number" IS \'Номер приказа\';
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."contract_date" IS \'Дата приказа\';
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."formula_type_id" IS \'ID типа формулы\';
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."is_start" IS \'Используется ли хоть один раз данный рецепт \';
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."from_at" IS \'Дата начала действия рецепта\';
                COMMENT ON COLUMN "public"."ab_shop_formula_materials"."to_at" IS \'Дата окончания действия рецепта\';
                COMMENT ON TABLE "public"."ab_shop_formula_materials" IS \'Рецеп производства материала из сырья\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_formula_materials
                -- ----------------------------
                CREATE INDEX "shop_formula_material_first" ON "public"."ab_shop_formula_materials" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_formula_material_from_at" ON "public"."ab_shop_formula_materials" USING btree (
                  "from_at" "pg_catalog"."date_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_formula_material_full_name" ON "public"."ab_shop_formula_materials" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name::text), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "shop_formula_material_index_id" ON "public"."ab_shop_formula_materials" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_formula_material_is_start" ON "public"."ab_shop_formula_materials" USING btree (
                  "is_start" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_formula_material_shop_material_id" ON "public"."ab_shop_formula_materials" USING btree (
                  "shop_material_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_formula_material_to_at" ON "public"."ab_shop_formula_materials" USING btree (
                  "to_at" "pg_catalog"."date_ops" ASC NULLS LAST
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
        'shop_material_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID производимого материала',
            'table' => 'DB_Ab1_Shop_Material',
            'is_common_items' => true,
        ),
        'wet' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 11,
            'is_not_null' => true,
            'title' => 'Влажность',
        ),
        'contract_number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер приказа',
        ),
        'contract_date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата приказа',
        ),
        'formula_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID типа формулы',
            'table' => 'DB_Ab1_FormulaType',
            'is_common_items' => true,
        ),
        'is_start' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Используется ли хоть один раз данный рецепт ',
        ),
        'from_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата начала действия рецепта',
        ),
        'to_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата окончания действия рецепта',
        ),
    );

    // список связанных таблиц 1коМногим
    const ITEMS = array(
        'shop_formula_material_items' => array(
            'table' => 'DB_Ab1_Shop_Formula_Material_Item',
            'field_id' => 'shop_formula_material_id',
            'is_view' => true,
        ),
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
