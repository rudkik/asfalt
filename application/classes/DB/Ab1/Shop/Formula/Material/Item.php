<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Formula_Material_Item {
    const TABLE_NAME = 'ab_shop_formula_material_items';
    const TABLE_ID = 106;
    const NAME = 'DB_Ab1_Shop_Formula_Material_Item';
    const TITLE = 'Сырьё рецепта производства материала из сырья';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_formula_material_items";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_formula_material_items
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_formula_material_items" (
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
                  "shop_formula_material_id" int8 NOT NULL DEFAULT 0,
                  "norm" numeric(12,9) NOT NULL DEFAULT 0,
                  "shop_raw_id" int8 NOT NULL DEFAULT 0,
                  "shop_material_id" int8 NOT NULL DEFAULT 0,
                  "norm_weight" numeric(12,3) NOT NULL DEFAULT 0,
                  "losses" numeric(12,9) NOT NULL DEFAULT 0,
                  "formula_type_ids" text COLLATE "pg_catalog"."default",
                  "is_start" numeric(1) NOT NULL DEFAULT 1,
                  "from_at" date,
                  "to_at" date,
                  "is_side" numeric(1) NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."shop_formula_material_id" IS \'ID рецепта\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."norm" IS \'Норма\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."shop_raw_id" IS \'ID сырья\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."shop_material_id" IS \'ID материала\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."norm_weight" IS \'Норма веса\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."losses" IS \'Потери\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."formula_type_ids" IS \'ID типов формул для отображения пользователей\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."is_start" IS \'Используется ли хоть один раз данный рецепт \';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."from_at" IS \'Дата начала действия рецепта\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."to_at" IS \'Дата окончания действия рецепта\';
                COMMENT ON COLUMN "public"."ab_shop_formula_material_items"."is_side" IS \'Побочное производство\';
                COMMENT ON TABLE "public"."ab_shop_formula_material_items" IS \'Список сырья рецепа производства материала из сырья\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_formula_material_items
                -- ----------------------------
                CREATE INDEX "shop_formula_material_item_first" ON "public"."ab_shop_formula_material_items" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_formula_material_item_from_at" ON "public"."ab_shop_formula_material_items" USING btree (
                  "from_at" "pg_catalog"."date_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_formula_material_item_full_name" ON "public"."ab_shop_formula_material_items" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name::text), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "shop_formula_material_item_index_id" ON "public"."ab_shop_formula_material_items" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_formula_material_item_is_side" ON "public"."ab_shop_formula_material_items" USING btree (
                  "is_side" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_formula_material_item_is_start" ON "public"."ab_shop_formula_material_items" USING btree (
                  "is_start" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_formula_material_item_shop_formula_material_id" ON "public"."ab_shop_formula_material_items" USING btree (
                  "shop_formula_material_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_formula_material_item_shop_raw_id" ON "public"."ab_shop_formula_material_items" USING btree (
                  "shop_raw_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_formula_material_item_to_at" ON "public"."ab_shop_formula_material_items" USING btree (
                  "to_at" "pg_catalog"."date_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_formula_product_item_is_side" ON "public"."ab_shop_formula_material_items" USING btree (
                  "is_side" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                ',
            'data' => '',
        ),
    );

    const FIELDS = array('id' => array(
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
        'shop_formula_material_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID рецепта',
            'table' => 'DB_Ab1_Shop_Formula_Material',
        ),
        'norm' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 9,
            'is_not_null' => true,
            'title' => 'Норма',
        ),
        'shop_raw_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID сырья',
            'table' => 'DB_Ab1_Shop_Raw',
        ),
        'shop_material_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID материала',
            'table' => 'DB_Ab1_Shop_Material',
        ),
        'norm_weight' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Норма веса',
        ),
        'losses' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 9,
            'is_not_null' => true,
            'title' => 'Потери',
        ),
        'formula_type_ids' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID типов формул для отображения пользователей',
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
        'shop_formula_material_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID материала, которое будет производиться',
            'table' => 'DB_Ab1_Shop_Formula_Material',
        ),
        'is_side' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Побочное производство',
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
