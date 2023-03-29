<?php defined('SYSPATH') or die('No direct script access.');

class DB_LandToIp {
    const TABLE_NAME = 'ct_land_to_ips';
    const TABLE_ID = 61;
    const NAME = 'DB_LandToIp';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_land_to_ips";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_land_to_ips
                -- ----------------------------
                CREATE TABLE "public"."ct_land_to_ips" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "ip_from" varchar(15) COLLATE "pg_catalog"."default" NOT NULL,
                  "ip_to" varchar(15) COLLATE "pg_catalog"."default" NOT NULL,
                  "land_id" int8 NOT NULL DEFAULT 0,
                  "land_code" varchar(5) COLLATE "pg_catalog"."default",
                  "update_user_id" int8 NOT NULL,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6),
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "delete_user_id" int8 DEFAULT 0,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "create_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "ip_from_int" int8 NOT NULL DEFAULT 0,
                  "ip_to_int" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ct_land_to_ips"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ct_land_to_ips"."ip_from" IS \'IP от\';
                COMMENT ON COLUMN "public"."ct_land_to_ips"."ip_to" IS \'IP до\';
                COMMENT ON COLUMN "public"."ct_land_to_ips"."land_id" IS \'ID страны\';
                COMMENT ON COLUMN "public"."ct_land_to_ips"."land_code" IS \'Код страны\';
                COMMENT ON COLUMN "public"."ct_land_to_ips"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_land_to_ips"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ct_land_to_ips"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_land_to_ips"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_land_to_ips"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_land_to_ips"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_land_to_ips"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_land_to_ips"."created_at" IS \'Дата создания\';
                COMMENT ON COLUMN "public"."ct_land_to_ips"."ip_from_int" IS \'IP от\';
                COMMENT ON COLUMN "public"."ct_land_to_ips"."ip_to_int" IS \'IP до\';
                COMMENT ON TABLE "public"."ct_land_to_ips" IS \'Страна по IP\';
                
                -- ----------------------------
                -- Indexes structure for table ct_land_to_ips
                -- ----------------------------
                CREATE INDEX "land_to_ip_first" ON "public"."ct_land_to_ips" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "land_to_ip_index_id" ON "public"."ct_land_to_ips" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "land_to_ip_ip" ON "public"."ct_land_to_ips" USING btree (
                  "ip_from_int" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "ip_to_int" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "land_to_ip_land_id" ON "public"."ct_land_to_ips" USING btree (
                  "land_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ct_land_to_ips
                -- ----------------------------
                ALTER TABLE "public"."ct_land_to_ips" ADD CONSTRAINT "ct_land_to_ips_pkey" PRIMARY KEY ("global_id");
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
        'ip_from' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 15,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'IP от',
        ),
        'ip_to' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 15,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'IP до',
        ),
        'land_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID страны',
            'table' => 'DB_Land',
        ),
        'land_code' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 5,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Код страны',
        ),
        'update_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Кто отредактировал эту запись',
            'table' => 'DB_User',
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
        'delete_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Кто удалил запись',
            'table' => 'DB_User',
        ),
        'global_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Глобальный ID',
        ),
        'create_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Кто отредактировал эту запись',
            'table' => 'DB_User',
        ),
        'created_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата создания',
        ),
        'ip_from_int' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'IP от',
        ),
        'ip_to_int' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'IP до',
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
