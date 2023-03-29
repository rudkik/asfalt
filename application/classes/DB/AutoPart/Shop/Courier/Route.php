<?php
defined('SYSPATH') or die('No direct script access.');

class DB_AutoPart_Shop_Courier_Route {
    const TABLE_NAME = 'ap_shop_courier_routes';
    const TABLE_ID = '';
    const NAME = 'DB_AutoPart_Shop_Courier_Route';
    const TITLE = '';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ap_shop_courier_routes";',
            'create' => '
                -- ----------------------------
                -- Table structure for ap_shop_courier_routes
                -- ----------------------------
                DROP TABLE IF EXISTS "public"."ap_shop_courier_routes";
                CREATE TABLE "public"."ap_shop_courier_routes" (
                      
				"id" int8 NOT NULL ,
				"is_public" numeric(1,0) NOT NULL  DEFAULT 1,
				"shop_id" int8 NOT NULL ,
				"name" varchar(250) COLLATE "pg_catalog"."default"  ,
				"text" text  ,
				"image_path" varchar(100) COLLATE "pg_catalog"."default"  ,
				"files" text  ,
				"options" text  ,
				"order" int8 NOT NULL  DEFAULT 0,
				"old_id" varchar(50) COLLATE "pg_catalog"."default"   DEFAULT NULL::character varying,
				"create_user_id" int8   DEFAULT 0,
				"update_user_id" int8 NOT NULL ,
				"delete_user_id" int8   DEFAULT 0,
				"created_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
				"updated_at" timestamp(6) NOT NULL ,
				"deleted_at" timestamp(6)   DEFAULT NULL::timestamp without time zone,
				"is_delete" numeric(1,0) NOT NULL  DEFAULT 0,
				"language_id" int8 NOT NULL  DEFAULT 35,
				"global_id" int8 NOT NULL  DEFAULT nextval(\'global_id\'::regclass),
				"shop_courier_id" int8 NOT NULL  DEFAULT 0,
				"price_km" numeric(12,2) NOT NULL  DEFAULT 0,
				"amount" numeric(12,2) NOT NULL  DEFAULT 0,
				"shop_courier_address_id_from" int8 NOT NULL  DEFAULT 0,
				"date" date  ,
				"quantity_points" int8   DEFAULT 0,
				"seconds" numeric(12,3) NOT NULL  DEFAULT 0,
				"distance" numeric(12,3) NOT NULL  DEFAULT 0,
				"mean_point_distance_km" numeric(12,3) NOT NULL  DEFAULT 0,
				"mean_point_second" numeric(12,3) NOT NULL  DEFAULT 0,
				"wage" numeric(12,2) NOT NULL  DEFAULT 0,
				"price_point" numeric(12,2) NOT NULL  DEFAULT 0,
				"shop_courier_address_id_to" int8 NOT NULL  DEFAULT 0,
				"from_at" timestamp(0)  ,
				"to_at" timestamp(0)  ,
				"is_finish" numeric(1,0) NOT NULL  DEFAULT 0,
                );
                ALTER TABLE "public"."ap_shop_courier_routes" OWNER TO "postgres";
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."order" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."old_id" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."created_at" IS \'\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."shop_courier_id" IS \'ID Курьера\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."price_km" IS \'Цена за км\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."shop_courier_address_id_from" IS \'ID точка старта курьера (адрес курера)\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."date" IS \'Дата\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."quantity_points" IS \'количество точек в маршруте\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."seconds" IS \'количество секунд  в пути\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."distance" IS \'пройденная дистанция в км\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."mean_point_distance_km" IS \'среднее расстояние до одной точки\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."mean_point_second" IS \'среднее количество секунд до одной точки\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."wage" IS \'зарплата курьера\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."price_point" IS \'цена за точку\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."shop_courier_address_id_to" IS \'ID точка окончания курьера (адрес курера)\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."from_at" IS \'Время начала\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."to_at" IS \'Время окончания\';
                COMMENT ON COLUMN "public"."ap_shop_courier_routes"."is_finish" IS \'\';
                
                -- ----------------------------
                -- Indexes structure for table ap_shop_courier_routes
                -- ----------------------------
				CREATE INDEX ap_shop_courier_route_date ON ap_shop_courier_routes USING btree (date); 
				CREATE INDEX ap_shop_courier_route_shop_courier_address_id_to ON ap_shop_courier_routes USING btree (shop_courier_address_id_to); 
				CREATE INDEX ap_shop_courier_route_shop_courier_address_id_from ON ap_shop_courier_routes USING btree (shop_courier_address_id_from); 
				CREATE UNIQUE INDEX ap_shop_couriers_copy1_pkey ON ap_shop_courier_routes USING btree (global_id); 
				CREATE INDEX ap_shop_courier_route_shop_courier_id ON ap_shop_courier_routes USING btree (shop_courier_id); 
				CREATE INDEX ap_shop_courier_route_index_id ON ap_shop_courier_routes USING btree (id); 
				CREATE INDEX ap_shop_courier_route_first ON ap_shop_courier_routes USING btree (is_delete, language_id, shop_id, is_public); 
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
            'length' => 50,
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
        'shop_courier_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID Курьера',
            'table' => 'DB_AutoPart_Shop_Courier',
        ),
        'price_km' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена за км',
            'table' => '',
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма',
            'table' => '',
        ),
        'shop_courier_address_id_from' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID точка старта курьера (адрес курера)',
            'table' => 'DB_AutoPart_Shop_Courier_Address',
        ),
        'date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Дата',
            'table' => '',
        ),
        'quantity_points' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'количество точек в маршруте',
            'table' => '',
        ),
        'seconds' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'количество секунд  в пути',
            'table' => '',
        ),
        'distance' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'пройденная дистанция в км',
            'table' => '',
        ),
        'mean_point_distance_km' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'среднее расстояние до одной точки',
            'table' => '',
        ),
        'mean_point_second' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'среднее количество секунд до одной точки',
            'table' => '',
        ),
        'wage' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'зарплата курьера',
            'table' => '',
        ),
        'price_point' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'цена за точку',
            'table' => '',
        ),
        'shop_courier_address_id_to' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID точка окончания курьера (адрес курера)',
            'table' => 'DB_AutoPart_Shop_Courier_Address',
        ),
        'from_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Время начала',
            'table' => '',
        ),
        'to_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Время окончания',
            'table' => '',
        ),
        'is_finish' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => '',
        ),
        'quantity_receive_points' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'количество точек в маршруте',
            'table' => '',
        ),
        'quantity_bill_points' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'количество точек в маршруте',
            'table' => '',
        ),
        'quantity_return_points' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'количество точек в маршруте',
            'table' => '',
        ),
        'quantity_other_points' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 64,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'количество точек в маршруте',
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
