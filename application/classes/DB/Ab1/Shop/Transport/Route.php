<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Transport_Route {
    const TABLE_NAME = 'ab_shop_transport_routes';
    const TABLE_ID = 398;
    const NAME = 'DB_Ab1_Shop_Transport_Route';
    const TITLE = 'Маршруты для движения транспорта';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_transport_routes";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_transport_routes
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_transport_routes" (
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
                  "shop_branch_from_id" int8 NOT NULL DEFAULT 0,
                  "shop_branch_to_id" int8 NOT NULL DEFAULT 0,
                  "distance" numeric(12,3) NOT NULL DEFAULT 0,
                  "shop_daughter_from_id" int8 NOT NULL DEFAULT 0,
                  "shop_daughter_to_id" int8 NOT NULL DEFAULT 0,
                  "number" varchar(250) COLLATE "pg_catalog"."default",
                  "amount" numeric(12,2) NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_transport_routes"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_routes"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_transport_routes"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."ab_shop_transport_routes"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_transport_routes"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_transport_routes"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_transport_routes"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_transport_routes"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_routes"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_routes"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_routes"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_transport_routes"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_transport_routes"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_routes"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_transport_routes"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_transport_routes"."shop_branch_from_id" IS \'ID филиала откуда везти\';
                COMMENT ON COLUMN "public"."ab_shop_transport_routes"."shop_branch_to_id" IS \'ID филиала куда везти\';
                COMMENT ON COLUMN "public"."ab_shop_transport_routes"."distance" IS \'Расстояние\';
                COMMENT ON COLUMN "public"."ab_shop_transport_routes"."shop_daughter_from_id" IS \'ID поставщика откуда везти\';
                COMMENT ON COLUMN "public"."ab_shop_transport_routes"."shop_daughter_to_id" IS \'ID поставщика куда везти\';
                COMMENT ON COLUMN "public"."ab_shop_transport_routes"."number" IS \'Код 1с\';
                COMMENT ON COLUMN "public"."ab_shop_transport_routes"."amount" IS \'Расценка для зарплаты водителям\';
                COMMENT ON TABLE "public"."ab_shop_transport_routes" IS \'Список маршрутов для движения транспорта\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_transport_routes
                -- ----------------------------
                CREATE INDEX "ab_shop_transport_route_first" ON "public"."ab_shop_transport_routes" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_route_index_id" ON "public"."ab_shop_transport_routes" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_route_shop_branch_from_id" ON "public"."ab_shop_transport_routes" USING btree (
                  "shop_branch_from_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_route_shop_branch_to_id" ON "public"."ab_shop_transport_routes" USING btree (
                  "shop_branch_to_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_route_shop_daughter_from_id" ON "public"."ab_shop_transport_routes" USING btree (
                  "shop_daughter_from_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_route_shop_daughter_to_id" ON "public"."ab_shop_transport_routes" USING btree (
                  "shop_daughter_to_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'shop_branch_from_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID филиала откуда везти',
            'table' => 'DB_Shop',
        ),
        'shop_branch_to_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID филиала куда везти',
            'table' => 'DB_Shop',
        ),
        'distance' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Расстояние',
        ),
        'shop_daughter_from_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID поставщика откуда везти',
            'table' => 'DB_Ab1_Shop_Daughter',
        ),
        'shop_daughter_to_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID поставщика куда везти',
            'table' => 'DB_Ab1_Shop_Daughter',
        ),
        'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Код 1С',
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Расценка для зарплаты водителям',
        ),
        'table_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID таблицы перевозки',
            'table' => 'DB_Table',
        ),
        'shop_product_rubric_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID рубрики продукции ',
            'table' => 'DB_Ab1_Shop_Product_Rubric',
        ),
        'shop_ballast_distance_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID дистанции балласта',
            'table' => 'DB_Ab1_Shop_Ballast_Distance',
        ),
        'shop_client_to_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID клиента вывоза',
            'table' => 'DB_Ab1_Shop_Client',
        ),
        'formula' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Формула зарплата',
        ),
        'shop_transportation_place_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID места выгрузки перевозок',
            'table' => 'DB_Ab1_Shop_Transportation_Place',
        ),
        'shop_storage_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID склада',
            'table' => 'DB_Ab1_Shop_Storage',
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
