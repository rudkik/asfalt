<?php
defined('SYSPATH') or die('No direct script access.');

class DB_AutoPart_Shop_Bill_Return {
    const TABLE_NAME = 'ap_shop_bill_returns';
    const TABLE_ID = '';
    const NAME = 'DB_AutoPart_Shop_Bill_Return';
    const TITLE = '';
    const IS_CATALOG = false;


    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ap_shop_bill_returns";',
            'create' => '
                -- ----------------------------
                -- Table structure for ap_shop_bill_returns
                -- ----------------------------
                DROP TABLE IF EXISTS "public"."ap_shop_bill_returns";
                CREATE TABLE "public"."ap_shop_bill_returns" (
                      
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
				"return_at" timestamp(6)  ,
				"plan_return_at" timestamp(6)  ,
				"shop_bill_id" int8 NOT NULL  DEFAULT 0,
				"shop_bill_return_status_id" int8 NOT NULL  DEFAULT 0,
				"is_return " numeric(1,0) NOT NULL  DEFAULT 0,
				"is_refusal" numeric(1,0) NOT NULL  DEFAULT 0,
                );
                ALTER TABLE "public"."ap_shop_bill_returns" OWNER TO "postgres";
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."order" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."old_id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."created_at" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."return_at" IS \'время возврата\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."plan_return_at" IS \'время планируемого возврата\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."shop_bill_id" IS \'ID Заказ\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."shop_bill_return_status_id" IS \'ID статус возврата заказа\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."is_return " IS \'возврат совершен\';
                COMMENT ON COLUMN "public"."ap_shop_bill_returns"."is_refusal" IS \'возврат отказан\';
                
                -- ----------------------------
                -- Indexes structure for table ap_shop_bill_returns
                -- ----------------------------
				CREATE INDEX ap_shop_bill_return_shop_bill_id ON public.ap_shop_bill_returns USING btree (shop_bill_id); 
				CREATE INDEX "ap_shop_bill_return_shop_bill_return_status_id " ON public.ap_shop_bill_returns USING btree (shop_bill_return_status_id); 
				CREATE UNIQUE INDEX ap_shop_bill_return_statuses_copy1_pkey ON public.ap_shop_bill_returns USING btree (global_id); 
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
        'return_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'время планируемого звонка',
            'table' => '',
        ),
        'plan_return_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'время планируемого звонка',
            'table' => '',
        ),
        'shop_bill_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID Заказ',
            'table' => 'DB_AutoPart_Shop_Bill',
        ),
        'shop_bill_return_status_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID статус возврата заказа',
            'table' => 'DB_AutoPart_Shop_Bill_Return_Status',
        ),
        'is_return ' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'возврат совершен',
            'table' => '',
        ),
        'is_refusal' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'возврат отказан',
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
