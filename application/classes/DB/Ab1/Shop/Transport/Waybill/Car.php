<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Transport_Waybill_Car {
    const TABLE_NAME = 'ab_shop_transport_waybill_cars';
    const TABLE_ID = 415;
    const NAME = 'DB_Ab1_Shop_Transport_Waybill_Car';
    const TITLE = 'Задания путевого листа';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_transport_waybill_cars";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_transport_waybill_cars
                -- ----------------------------
               CREATE TABLE "public"."ab_shop_transport_waybill_cars" (
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
                  "shop_transport_driver_id" int8 NOT NULL DEFAULT 0,
                  "shop_transport_id" int8 NOT NULL DEFAULT 0,
                  "date" date,
                  "from_at" timestamp(6),
                  "to_at" timestamp(6),
                  "distance" numeric(12,2) NOT NULL DEFAULT 0,
                  "shop_transport_waybill_id" int8 NOT NULL DEFAULT 0,
                  "shop_car_to_material_id" int8 NOT NULL DEFAULT 0,
                  "shop_ballast_id" int8 NOT NULL DEFAULT 0,
                  "shop_piece_item_id" int8 NOT NULL DEFAULT 0,
                  "shop_transportation_id" int8 NOT NULL DEFAULT 0,
                  "shop_car_id" int8 NOT NULL DEFAULT 0,
                  "shop_client_to_id" int8 NOT NULL DEFAULT 0,
                  "shop_daughter_from_id" int8 NOT NULL DEFAULT 0,
                  "shop_branch_to_id" int8 NOT NULL DEFAULT 0,
                  "shop_branch_from_id" int8 NOT NULL DEFAULT 0,
                  "shop_ballast_crusher_to_id" int8 NOT NULL DEFAULT 0,
                  "shop_ballast_crusher_from_id" int8 NOT NULL DEFAULT 0,
                  "quantity" numeric(12,3) NOT NULL DEFAULT 0,
                  "shop_transportation_place_to_id" int8 NOT NULL DEFAULT 0,
                  "shop_material_id" int8 NOT NULL DEFAULT 0,
                  "shop_raw_id" int8 NOT NULL DEFAULT 423186,
                  "shop_product_id" int8 NOT NULL DEFAULT 0,
                  "count_trip" int2,
                  "shop_move_car_id" int8 NOT NULL DEFAULT 0,
                  "shop_lessee_car_id" int8 NOT NULL DEFAULT 0,
                  "shop_transport_route_id" int8 NOT NULL DEFAULT 0,
                  "shop_move_client_to_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_transport_driver_id" IS \'ID водителя\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_transport_id" IS \'ID транспорта\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."date" IS \'Дата путевого листа\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."from_at" IS \'Время выезда\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."to_at" IS \'Время въезда\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."distance" IS \'Расстояние\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_transport_waybill_id" IS \'ID путевого листа\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_car_to_material_id" IS \'ID перевозки материала\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_ballast_id" IS \'ID перевозки балласта\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_piece_item_id" IS \'ID перевозки штучного товара\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_transportation_id" IS \'ID рейсов перевозки\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_car_id" IS \'ID перевозки продукции\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_client_to_id" IS \'ID клиентa получателя\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_daughter_from_id" IS \'ID поставщика отправителя\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_branch_to_id" IS \'ID филиала получателя\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_branch_from_id" IS \'ID филиала отправителя\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_ballast_crusher_to_id" IS \'ID дробилки получателя\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_ballast_crusher_from_id" IS \'ID дробилки отправителя\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."quantity" IS \'Кол-во перевезенного груза\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_transportation_place_to_id" IS \'ID места перевозки получатель\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_material_id" IS \'ID материала\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_raw_id" IS \'ID сырья \';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_product_id" IS \'ID продукта\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."count_trip" IS \'Количество поездок\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_move_car_id" IS \'ID перемещения\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_lessee_car_id" IS \'ID ответ.хранения\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_transport_route_id" IS \'ID маршрута\';
                COMMENT ON COLUMN "public"."ab_shop_transport_waybill_cars"."shop_move_client_to_id" IS \'ID подразделение для перемещения\';
                COMMENT ON TABLE "public"."ab_shop_transport_waybill_cars" IS \'Список заданий путевого листа\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_transport_waybill_cars
                -- ----------------------------
                CREATE INDEX "ab_shop_transport_waybill_car_date" ON "public"."ab_shop_transport_waybill_cars" USING btree (
                  "date" "pg_catalog"."date_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_waybill_car_first" ON "public"."ab_shop_transport_waybill_cars" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_waybill_car_index_id" ON "public"."ab_shop_transport_waybill_cars" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_waybill_car_shop_transport_driver_id" ON "public"."ab_shop_transport_waybill_cars" USING btree (
                  "shop_transport_driver_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_waybill_car_shop_transport_id" ON "public"."ab_shop_transport_waybill_cars" USING btree (
                  "shop_transport_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_transport_waybill_car_shop_transport_waybill_id" ON "public"."ab_shop_transport_waybill_cars" USING btree (
                  "shop_transport_waybill_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'shop_transport_driver_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID водителя',
            'table' => 'DB_Ab1_Shop_Transport_Driver',
        ),
        'shop_transport_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID транспорта',
            'table' => 'DB_Ab1_Shop_Transport',
        ),
        'date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата путевого листа',
        ),
        'from_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Время выезда',
        ),
        'to_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Время въезда',
        ),
        'distance' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Расстояние',
        ),
        'shop_transport_waybill_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID путевого листа',
            'table' => 'DB_Ab1_Shop_Transport_Waybill',
        ),
        'shop_car_to_material_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID перевозки материала',
            'table' => 'DB_Ab1_Shop_Car_To_Material',
        ),
        'shop_ballast_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID перевозки балласта',
            'table' => 'DB_Ab1_Shop_Ballast',
        ),
        'shop_piece_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID перевозки штучного товара',
            'table' => 'DB_Ab1_Shop_Piece',
        ),
        'shop_transportation_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID рейсов перевозки',
            'table' => 'DB_Ab1_Shop_Transportation',
        ),
        'shop_car_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID перевозки продукции',
            'table' => 'DB_Ab1_Shop_Car',
        ),
        'shop_client_to_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID клиентa получателя',
            'table' => 'DB_Ab1_Shop_Client',
        ),
        'shop_daughter_from_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID поставщика отправителя',
            'table' => 'DB_Ab1_Shop_Daughter',
        ),
        'shop_branch_to_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID филиала получателя',
            'table' => 'DB_Shop',
        ),
        'shop_branch_from_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID филиала отправителя',
            'table' => 'DB_Shop',
        ),
        'shop_ballast_crusher_to_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID дробилки получателя',
            'table' => 'DB_Ab1_Shop_Ballast_Crusher',
        ),
        'shop_ballast_crusher_from_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID дробилки отправителя',
            'table' => 'DB_Ab1_Shop_Ballast_Crusher',
        ),
        'quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Кол-во перевезенного груза',
        ),
        'shop_transportation_place_to_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID места перевозки получатель',
            'table' => 'DB_Ab1_Shop_Transportation_Place',
        ),
        'shop_material_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID материала',
            'table' => 'DB_Ab1_Shop_Material',
        ),
        'shop_raw_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID сырья ',
            'table' => 'DB_Ab1_Shop_Raw',
        ),
        'shop_product_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID продукта',
            'table' => 'DB_Ab1_Shop_Product',
        ),
        'count_trip' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 16,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Количество поездок',
        ),
        'shop_move_car_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID перемещения',
            'table' => 'DB_Ab1_Shop_Move_Car',
        ),
        'shop_lessee_car_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID ответ.хранения',
            'table' => 'DB_Ab1_Shop_Lessee_Car',
        ),
        'shop_transport_route_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID маршрута',
            'table' => 'DB_Ab1_Shop_Transport_Route',
        ),
        'shop_move_client_to_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID подразделение для перемещения',
            'table' => 'DB_Ab1_Shop_Move_Client',
        ),
        'shop_move_place_to_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID места для перемещения',
            'table' => 'DB_Ab1_Shop_Move_Place',
        ),
        'shop_material_other_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID прочего материала',
            'table' => 'DB_Ab1_Shop_Material_Other',
        ),
        'shop_move_other_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID прочего перемещения',
            'table' => 'DB_Ab1_Shop_Move_Other',
        ),
        'wage' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена рейса',
        ),
        'shop_ballast_distance_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID дистанции балласта',
            'table' => 'DB_Ab1_Shop_Ballast_Distance',
        ),
        'to_name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Название пункта отправления',
        ),
        'product_name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Название продукта',
        ),
        'is_hand' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Запись создана вручную',
        ),
        'is_wage' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Учитывать рейс в зарплате',
        ),
        'coefficient' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Коэффициент',
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
