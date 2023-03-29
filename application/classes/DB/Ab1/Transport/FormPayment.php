<?php
defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Transport_FormPayment {
    const TABLE_NAME = 'ab_transport_form_payments';
    const TABLE_ID = '';
    const NAME = 'DB_Ab1_Transport_FormPayment';
    const TITLE = '';
    const IS_CATALOG = false;


    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_transport_form_payments";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_transport_form_payments
                -- ----------------------------
                DROP TABLE IF EXISTS "public"."ab_transport_form_payments";
                CREATE TABLE "public"."ab_transport_form_payments" (
                      
					id" int8 NOT NULL ,
					is_public" numeric(1,0) NOT NULL  DEFAULT 1,
					name" varchar(250) COLLATE "pg_catalog"."default"  ,
					text" text  ,
					image_path" varchar(100) COLLATE "pg_catalog"."default"  ,
					files" text  ,
					options" text  ,
					order" int8 NOT NULL  DEFAULT 0,
					old_id" varchar(64) COLLATE "pg_catalog"."default" NOT NULL  DEFAULT 0,
					create_user_id" int8   DEFAULT 0,
					update_user_id" int8 NOT NULL ,
					delete_user_id" int8   DEFAULT 0,
					created_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
					updated_at" timestamp(6) NOT NULL ,
					deleted_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
					is_delete" numeric(1,0) NOT NULL  DEFAULT 0,
					language_id" int8 NOT NULL  DEFAULT 35,
					global_id" int8 NOT NULL  DEFAULT nextval(\'global_id\'::regclass),
					number" varchar(50) COLLATE "pg_catalog"."default"  ,
                );
                    ALTER TABLE "public"."ab_transport_form_payments" OWNER TO "postgres";
                    COMMENT ON COLUMN "public"."ab_transport_form_payments"."id" IS \'\';
                    COMMENT ON COLUMN "public"."ab_transport_form_payments"."is_public" IS \'Опубликована ли запись\';
                    COMMENT ON COLUMN "public"."ab_transport_form_payments"."name" IS \'Название топлива\';
                    COMMENT ON COLUMN "public"."ab_transport_form_payments"."text" IS \'Описание \';
                    COMMENT ON COLUMN "public"."ab_transport_form_payments"."image_path" IS \'Картинка\';
                    COMMENT ON COLUMN "public"."ab_transport_form_payments"."files" IS \'Дополнительные файлы\';
                    COMMENT ON COLUMN "public"."ab_transport_form_payments"."options" IS \'Дополнительные поля\';
                    COMMENT ON COLUMN "public"."ab_transport_form_payments"."order" IS \'\';
                    COMMENT ON COLUMN "public"."ab_transport_form_payments"."old_id" IS \'ID 1c\';
                    COMMENT ON COLUMN "public"."ab_transport_form_payments"."create_user_id" IS \'Кто отредактировал эту запись\';
                    COMMENT ON COLUMN "public"."ab_transport_form_payments"."update_user_id" IS \'Кто отредактировал эту запись\';
                    COMMENT ON COLUMN "public"."ab_transport_form_payments"."delete_user_id" IS \'Кто удалил запись\';
                    COMMENT ON COLUMN "public"."ab_transport_form_payments"."created_at" IS \'\';
                    COMMENT ON COLUMN "public"."ab_transport_form_payments"."updated_at" IS \'Дата обновления записи\';
                    COMMENT ON COLUMN "public"."ab_transport_form_payments"."deleted_at" IS \'Дата удаления записи\';
                    COMMENT ON COLUMN "public"."ab_transport_form_payments"."is_delete" IS \'Удалена ли запись\';
                    COMMENT ON COLUMN "public"."ab_transport_form_payments"."language_id" IS \'ID языка\';
                    COMMENT ON COLUMN "public"."ab_transport_form_payments"."global_id" IS \'Глобальный ID\';
                    COMMENT ON COLUMN "public"."ab_transport_form_payments"."number" IS \'Номер 1C\';
                    
                    -- ----------------------------
                    -- Indexes structure for table ab_transport_form_payments
                    -- ----------------------------
                    
					 CREATE INDEX ab_transport_form_payment_full_name ON ab_transport_form_payments USING gin (setweight(to_tsvector(\'russian\'::regconfig, (name)::text), \'A\'::"char"))
					 CREATE INDEX ab_transport_form_payment_old_id ON ab_transport_form_payments USING btree (old_id)
					 CREATE INDEX ab_transport_form_payment_name_like ON ab_transport_form_payments USING btree (lower((name)::text))
					 CREATE INDEX ab_transport_form_payment_index_id ON ab_transport_form_payments USING btree (id)
					 CREATE INDEX ab_transport_form_payment_first ON ab_transport_form_payments USING btree (is_delete, language_id, is_public)                ',
            'data' => '',
        ),

    );
    const FIELDS = array(
        'id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => '',
            'table' => '',
        ),
       'is_public' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Опубликована ли запись',
            'table' => '',
        ),
       'name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Название топлива',
            'table' => '',
        ),
       'text' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Описание ',
            'table' => '',
        ),
       'image_path' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 100,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Картинка',
            'table' => '',
        ),
       'files' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Дополнительные файлы',
            'table' => '',
        ),
       'options' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Дополнительные поля',
            'table' => '',
        ),
       'order' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => '',
            'table' => '',
        ),
       'old_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID 1c',
            'table' => '',
        ),
       'create_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Кто отредактировал эту запись',
            'table' => 'DB_User',
        ),
       'update_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Кто отредактировал эту запись',
            'table' => 'DB_User',
        ),
       'delete_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Кто удалил запись',
            'table' => 'DB_User',
        ),
       'created_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => '',
        ),
       'updated_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата обновления записи',
            'table' => '',
        ),
       'deleted_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Дата удаления записи',
            'table' => '',
        ),
       'is_delete' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Удалена ли запись',
            'table' => '',
        ),
       'language_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID языка',
            'table' => 'DB_Language',
        ),
       'global_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Глобальный ID',
            'table' => '',
        ),
       'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Номер 1C',
            'table' => '',
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
