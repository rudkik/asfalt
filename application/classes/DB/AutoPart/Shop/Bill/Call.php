<?php
defined('SYSPATH') or die('No direct script access.');

class DB_AutoPart_Shop_Bill_Call {
    const TABLE_NAME = 'ap_shop_bill_calls';
    const TABLE_ID = '';
    const NAME = 'DB_AutoPart_Shop_Bill_Call';
    const TITLE = '';
    const IS_CATALOG = false;


    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ap_shop_bill_calls";',
            'create' => '
                -- ----------------------------
                -- Table structure for ap_shop_bill_calls
                -- ----------------------------
                DROP TABLE IF EXISTS "public"."ap_shop_bill_calls";
                CREATE TABLE "public"."ap_shop_bill_calls" (
                      
				"id" int8 NOT NULL ,
				"is_public" numeric(1,0) NOT NULL  DEFAULT 1,
				"shop_id" int8 NOT NULL ,
				"name" varchar(250) COLLATE "pg_catalog"."default"  ,
				"text" text  ,
				"image_path" varchar(100) COLLATE "pg_catalog"."default"  ,
				"files" text  ,
				"options" text  ,
				"order" int8 NOT NULL  DEFAULT 0,
				"old_id" varchar(64) COLLATE "pg_catalog"."default" NOT NULL  DEFAULT 0,
				"create_user_id" int8   DEFAULT 0,
				"update_user_id" int8 NOT NULL ,
				"delete_user_id" int8   DEFAULT 0,
				"created_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
				"updated_at" timestamp(6) NOT NULL ,
				"deleted_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
				"is_delete" numeric(1,0) NOT NULL  DEFAULT 0,
				"language_id" int8 NOT NULL  DEFAULT 35,
				"global_id" int8 NOT NULL  DEFAULT nextval(\'global_id\'::regclass),
				"shop_operation_id" int8 NOT NULL  DEFAULT 0,
				"shop_bill_call_status_id" int8 NOT NULL  DEFAULT 0,
				"shop_bill_id" int8 NOT NULL  DEFAULT 0,
				"call_at" timestamp(6)  ,
				"plan_call_at" timestamp(6)  ,
				"is_call" numeric(1,0) NOT NULL  DEFAULT 0,
				"phone" varchar(64) COLLATE "pg_catalog"."default" NOT NULL ,
                );
                ALTER TABLE "public"."ap_shop_bill_calls" OWNER TO "postgres";
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."order" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."old_id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."created_at" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."shop_operation_id" IS \'ID Оператора\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."shop_bill_call_status_id" IS \'ID Статус зваонка\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."shop_bill_id" IS \'ID Заказ\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."call_at" IS \'время звонка\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."plan_call_at" IS \'время планируемого звонка\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."is_call" IS \'звонок совершен\';
                COMMENT ON COLUMN "public"."ap_shop_bill_calls"."phone" IS \'Телефон\';
                
                -- ----------------------------
                -- Indexes structure for table ap_shop_bill_calls
                -- ----------------------------
				CREATE INDEX ap_shop_bill_call_shop_bill_id ON public.ap_shop_bill_calls USING btree (shop_bill_id); 
				CREATE INDEX ap_shop_bill_call_shop_bill_call_status_id ON public.ap_shop_bill_calls USING btree (shop_bill_call_status_id); 
				CREATE INDEX ap_shop_bill_call_shop_operation_id ON public.ap_shop_bill_calls USING btree (shop_operation_id); 
				CREATE UNIQUE INDEX ap_shop_bill_calls_pkey ON public.ap_shop_bill_calls USING btree (global_id); 
                ',
            'data' => '',
        ),

    );
    const FIELDS = array(
        'id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => '',
        ),
        'is_public' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Опубликована ли запись',
            'table' => '',
        ),
        'shop_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID магазина',
            'table' => 'DB_Shop',
        ),
        'name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Название',
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
            'is_not_null' => true,
            'title' => '',
            'table' => '',
        ),
        'old_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
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
            'is_not_null' => true,
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
            'is_not_null' => true,
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
            'is_not_null' => true,
            'title' => 'Удалена ли запись',
            'table' => '',
        ),
        'language_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID языка',
            'table' => 'DB_Language',
        ),
        'global_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Глобальный ID',
            'table' => '',
        ),
        'shop_operation_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID Оператора',
            'table' => 'DB_AutoPart_Shop_Operation',
        ),
        'shop_bill_call_status_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID Статус зваонка',
            'table' => 'DB_AutoPart_Shop_Bill_Call_Status',
        ),
        'shop_bill_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID Заказ',
            'table' => 'DB_AutoPart_Shop_Bill',
        ),
        'call_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'время звонка',
            'table' => '',
        ),
        'plan_call_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'время планируемого звонка',
            'table' => '',
        ),
        'is_call' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'звонок совершен',
            'table' => '',
        ),
        'phone' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Телефон',
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
