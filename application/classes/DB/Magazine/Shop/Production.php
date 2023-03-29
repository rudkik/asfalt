<?php defined('SYSPATH') or die('No direct script access.');

class DB_Magazine_Shop_Production {
    const TABLE_NAME = 'sp_shop_productions';
    const TABLE_ID = 250;
    const NAME = 'DB_Magazine_Shop_Production';
    const TITLE = 'Продукция для реализации';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."sp_shop_productions";',
            'create' => '
                -- ----------------------------
                -- Table structure for sp_shop_productions
                -- ----------------------------
                CREATE TABLE "public"."sp_shop_productions" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "text" text COLLATE "pg_catalog"."default",
                  "image_path" varchar(255) COLLATE "pg_catalog"."default",
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
                  "price" numeric(12,2) NOT NULL DEFAULT 0,
                  "unit_id" int8 NOT NULL DEFAULT 0,
                  "shop_product_id" int8 NOT NULL DEFAULT 0,
                  "shop_production_rubric_id" int8 NOT NULL DEFAULT 0,
                  "barcode" varchar(20) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "coefficient" float8 NOT NULL DEFAULT 0,
                  "quantity_coming" numeric(12,3) NOT NULL DEFAULT 0,
                  "quantity_expense" numeric(12,3) NOT NULL DEFAULT 0,
                  "name_esf" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "price_cost" numeric(12,2) NOT NULL DEFAULT 0,
                  "is_price_cost" numeric(1) NOT NULL DEFAULT 0,
                  "coefficient_rubric" float8 NOT NULL DEFAULT 0,
                  "weight_kg" numeric(12,6) NOT NULL DEFAULT 0,
                  "is_special" numeric(1) NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."sp_shop_productions"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."sp_shop_productions"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."name_1c" IS \'Название в 1C\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."name_site" IS \'Название на сайте\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."price" IS \'Цена\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."unit_id" IS \'ID единиц измерения\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."shop_product_id" IS \'ID продукта\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."shop_production_rubric_id" IS \'ID рубрики продукции\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."barcode" IS \'Штрих-код\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."coefficient" IS \'Коэффициент приобразования\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."quantity_coming" IS \'Количество на приходе\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."quantity_expense" IS \'Количество на расходе\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."name_esf" IS \'Название для ЭСФ\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."price_cost" IS \'Себестоимость\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."is_price_cost" IS \'Продавать по себестоимости\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."coefficient_rubric" IS \'Коэффициент приобразования в рубрику shop_production_rubric_id\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."weight_kg" IS \'Вес нетто к киллограмах\';
                COMMENT ON COLUMN "public"."sp_shop_productions"."is_special" IS \'Специальный продукт\';
                COMMENT ON TABLE "public"."sp_shop_productions" IS \'Список продукции для реализации\';
                
                -- ----------------------------
                -- Indexes structure for table sp_shop_productions
                -- ----------------------------
                CREATE INDEX "sp_shop_production_barcode" ON "public"."sp_shop_productions" USING btree (
                  "barcode" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_production_coefficient" ON "public"."sp_shop_productions" USING btree (
                  "coefficient" "pg_catalog"."float8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_production_coefficient_rubric" ON "public"."sp_shop_productions" USING btree (
                  "coefficient_rubric" "pg_catalog"."float8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_production_first" ON "public"."sp_shop_productions" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_production_full_name" ON "public"."sp_shop_productions" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name::text), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "sp_shop_production_index_id" ON "public"."sp_shop_productions" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_production_index_order" ON "public"."sp_shop_productions" USING btree (
                  "order" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_production_is_special" ON "public"."sp_shop_productions" USING btree (
                  "is_special" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_production_old_id" ON "public"."sp_shop_productions" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_production_shop_product_id" ON "public"."sp_shop_productions" USING btree (
                  "shop_product_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_production_shop_production_rubric_id" ON "public"."sp_shop_productions" USING btree (
                  "shop_production_rubric_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_production_shop_unit_id" ON "public"."sp_shop_productions" USING btree (
                  "unit_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
            'length' => 255,
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
        'price' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена',
        ),
        'unit_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID единиц измерения',
            'table' => 'DB_Magazine_Unit',
        ),
        'shop_product_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID продукта',
            'table' => 'DB_Magazine_Shop_Product',
        ),
        'shop_production_rubric_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID рубрики продукции',
            'table' => 'DB_Magazine_Shop_Production_Rubric',
        ),
        'barcode' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 20,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Штрих-код',
        ),
        'coefficient' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 20,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Коэффициент приобразования',
        ),
        'quantity_coming' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество на приходе',
        ),
        'quantity_expense' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество на расходе',
        ),
        'name_esf' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Название для ЭСФ',
        ),
        'price_cost' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Себестоимость',
        ),
        'is_price_cost' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Продавать по себестоимости',
        ),
        'coefficient_rubric' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 20,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Коэффициент приобразования в рубрику shop_production_rubric_id',
        ),
        'weight_kg' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 6,
            'is_not_null' => true,
            'title' => 'Вес нетто к киллограмах',
        ),
        'is_special' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Специальный продукт',
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
