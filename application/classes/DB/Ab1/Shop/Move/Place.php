<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Move_Place {
    const TABLE_NAME = 'ab_shop_move_places';
    const TABLE_ID = 213;
    const NAME = 'DB_Ab1_Shop_Move_Place';
    const TITLE = 'Место вывоза прочего материала';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_move_places";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_move_places
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_move_places" (
                
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
                  "bin" varchar(12) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "address" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "contract" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "shop_payment_type_id" int8 NOT NULL DEFAULT 0,
                  "name_1c" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "name_site" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "account" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "bank" varchar(250) COLLATE "pg_catalog"."default" DEFAULT \'\'::character varying,
                  "organization_type_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_move_places"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."bin" IS \'БИН\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."address" IS \'Адрес\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."contract" IS \'Договор\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."shop_payment_type_id" IS \'ID типа оплаты\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."name_1c" IS \'Название в 1C\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."name_site" IS \'Название на сайте\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."account" IS \'Номер счета\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."bank" IS \'Банк\';
                COMMENT ON COLUMN "public"."ab_shop_move_places"."organization_type_id" IS \'Тип организации\';
                COMMENT ON TABLE "public"."ab_shop_move_places" IS \'Место вывоза прочего материала\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_move_places
                -- ----------------------------
                CREATE INDEX "ab_shop_move_place_index_id" ON "public"."ab_shop_move_places" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
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
        'bin' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 12,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'БИН',
        ),
        'address' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Адрес',
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма',
        ),
        'contract' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Договор',
        ),
        'shop_payment_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID типа оплаты',
            'table' => 'DB_Ab1_PaymentType',
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
        'account' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер счета',
        ),
        'bank' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Банк',
        ),
        'organization_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип организации',
            'table' => 'DB_OrganizationType',
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
