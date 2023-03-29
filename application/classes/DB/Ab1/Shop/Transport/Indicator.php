<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Transport_Indicator {
    const TABLE_NAME = 'ab_shop_transport_indicators';
    const TABLE_ID = 396;
    const NAME = 'DB_Ab1_Shop_Transport_Indicator';
    const TITLE = 'Показатели расчета транспортных средств';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_transport_indicators";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_transport_indicators
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_transport_indicators" (
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
                  "is_show_document_indicator" numeric(1) NOT NULL DEFAULT 0,
                  "is_expense_fuel" numeric(1) NOT NULL DEFAULT 0,
                  "is_calc_wage" numeric(1) NOT NULL DEFAULT 0,
                  "is_calc_work_time" numeric(1) NOT NULL DEFAULT 0,
                  "autocomplete_type_id" int8 NOT NULL DEFAULT 0,
                  "shop_transport_work_id" int8 NOT NULL DEFAULT 0,
                  "identifier" varchar(250) COLLATE "pg_catalog"."default",
                  "is_show_document_transport" numeric(1) NOT NULL DEFAULT 0,
                  "indicator_type_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."is_show_document_indicator" IS \'Отображать показатель в документе расчета\';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."is_expense_fuel" IS \'Является показателем расчета нормы расхода ГСМ\';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."is_calc_wage" IS \'Является показателем расчета заработной платы\';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."is_calc_work_time" IS \'Засчитывается как отработанное время\';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."autocomplete_type_id" IS \'Автозаполнение (1 - Из сведений о транспортном средстве, 2 - По параметру выработки, 3 - По данным кадрого учета)\';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."shop_transport_work_id" IS \'ID параметра выработки\';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."identifier" IS \'Идентификатор\';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."is_show_document_transport" IS \'Отображать показатель в сведениях транспортного средства\';
                COMMENT ON COLUMN "public"."ab_shop_transport_indicators"."indicator_type_id" IS \'ID вид параметра выработки (Пробег, Общее время работы и т.д.)\';
                COMMENT ON TABLE "public"."ab_shop_transport_indicators" IS \'Список показателей расчета транспортных средств\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_transport_indicators
                -- ----------------------------
                CREATE INDEX "ab_shop_transport_indicator_first" ON "public"."ab_shop_transport_indicators" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_indicator_full_name" ON "public"."ab_shop_transport_indicators" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name::text), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "ab_shop_transport_indicator_index_id" ON "public"."ab_shop_transport_indicators" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_indicator_is_show_document_indicator" ON "public"."ab_shop_transport_indicators" USING btree (
                  "is_show_document_indicator" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_indicator_is_show_document_transport" ON "public"."ab_shop_transport_indicators" USING btree (
                  "is_show_document_transport" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_indicator_old_id" ON "public"."ab_shop_transport_indicators" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
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
        'is_show_document_indicator' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Отображать показатель в документе расчета',
        ),
        'is_expense_fuel' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Является показателем расчета нормы расхода ГСМ',
        ),
        'is_calc_wage' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Является показателем расчета заработной платы',
        ),
        'is_calc_work_time' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Засчитывается как отработанное время',
        ),
        'autocomplete_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Автозаполнение (1 - Из сведений о транспортном средстве, 2 - По параметру выработки, 3 - По данным кадрого учета)',
        ),
        'shop_transport_work_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID параметра выработки',
            'table' => 'DB_Ab1_Shop_Transport_Work',
        ),
        'identifier' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Идентификатор',
        ),
        'is_show_document_transport' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Отображать показатель в сведениях транспортного средства',
        ),
        'indicator_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID вид параметра выработки (Пробег, Общее время работы и т.д.)',
            'table' => 'DB_Ab1_Shop_Transport_Indicator',
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
