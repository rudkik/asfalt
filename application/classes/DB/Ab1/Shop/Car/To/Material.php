<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Car_To_Material {
    const TABLE_NAME = 'ab_shop_car_to_materials';
    const TABLE_ID = 77;
    const NAME = 'DB_Ab1_Shop_Car_To_Material';
    const TITLE = 'Машины для перевозки материалов';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_car_to_materials";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_car_to_materials
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_car_to_materials" (
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
                  "shop_daughter_id" int8 NOT NULL DEFAULT 0,
                  "shop_material_id" int8 NOT NULL DEFAULT 0,
                  "quantity" numeric(12,3) NOT NULL DEFAULT 0,
                  "shop_driver_id" int8 NOT NULL DEFAULT 0,
                  "shop_turn_place_id" int8 NOT NULL DEFAULT 0,
                  "weighted_operation_id" int8 DEFAULT 0,
                  "update_tare_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "tarra" numeric(12,3) NOT NULL DEFAULT 0,
                  "shop_car_tare_id" int8,
                  "quantity_invoice" numeric(12,3) DEFAULT 0,
                  "shop_client_material_id" int8 NOT NULL DEFAULT 0,
                  "shop_transport_company_id" int8 NOT NULL DEFAULT 0,
                  "is_test" numeric(1) NOT NULL DEFAULT 0,
                  "shop_branch_receiver_id" int8 NOT NULL DEFAULT 0,
                  "quantity_daughter" numeric(12,3) NOT NULL DEFAULT 0,
                  "shop_branch_daughter_id" int8 NOT NULL DEFAULT 0,
                  "shop_heap_receiver_id" int8 NOT NULL DEFAULT 0,
                  "shop_heap_daughter_id" int8 NOT NULL DEFAULT 0,
                  "receiver_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "date_document" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "shop_subdivision_receiver_id" int8 NOT NULL DEFAULT 0,
                  "shop_subdivision_daughter_id" int8 NOT NULL DEFAULT 0,
                  "is_weighted" numeric(1) NOT NULL DEFAULT 1,
                  "shop_transport_id" int8,
                  "number" varchar(10) COLLATE "pg_catalog"."default",
                  "shop_transport_waybill_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."shop_daughter_id" IS \'ID филлиала\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."shop_material_id" IS \'ID материала\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."quantity" IS \'Количество\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."shop_driver_id" IS \'ID водителя\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."shop_turn_place_id" IS \'ID места\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."weighted_operation_id" IS \'Оператор АСУ\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."update_tare_at" IS \'Дата обработки АСУ\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."tarra" IS \'Вес тары\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."is_test" IS \'Вес загружается вручную\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."shop_branch_receiver_id" IS \'ID филиала куда привезли материал\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."quantity_daughter" IS \'Количество по информации отправителя\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."shop_branch_daughter_id" IS \'ID филиала отправитель\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."shop_heap_receiver_id" IS \'ID места хранения материала\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."shop_heap_daughter_id" IS \'ID места откуда взяли материал\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."receiver_at" IS \'Дата принятия материала\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."date_document" IS \'Дата документа\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."shop_subdivision_receiver_id" IS \'ID подразделения хранения материала\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."shop_subdivision_daughter_id" IS \'ID подразделения откуда взяли материал\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."is_weighted" IS \'Машина прошла через весовую\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."shop_transport_id" IS \'ID транспорта АТЦ \';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."number" IS \'Номер ТТН\';
                COMMENT ON COLUMN "public"."ab_shop_car_to_materials"."shop_transport_waybill_id" IS \'ID путевого листа\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_car_to_materials
                -- ----------------------------
                CREATE INDEX "ab_shop_car_to_material_first" ON "public"."ab_shop_car_to_materials" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_to_material_index_id" ON "public"."ab_shop_car_to_materials" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_to_material_is_weighted" ON "public"."ab_shop_car_to_materials" USING btree (
                  "is_weighted" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_to_material_old_id" ON "public"."ab_shop_car_to_materials" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_to_material_shop_branch_daughter_id" ON "public"."ab_shop_car_to_materials" USING btree (
                  "shop_branch_daughter_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_to_material_shop_car_tare_id" ON "public"."ab_shop_car_to_materials" USING btree (
                  "shop_car_tare_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_to_material_shop_client_material_id" ON "public"."ab_shop_car_to_materials" USING btree (
                  "shop_client_material_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_to_material_shop_daughter_id" ON "public"."ab_shop_car_to_materials" USING btree (
                  "shop_daughter_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_to_material_shop_driver_id" ON "public"."ab_shop_car_to_materials" USING btree (
                  "shop_driver_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_to_material_shop_heap_daughter_id" ON "public"."ab_shop_car_to_materials" USING btree (
                  "shop_heap_daughter_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_to_material_shop_heap_receiver_id" ON "public"."ab_shop_car_to_materials" USING btree (
                  "shop_heap_receiver_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_to_material_shop_material_id" ON "public"."ab_shop_car_to_materials" USING btree (
                  "shop_material_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_to_material_shop_subdivision_daughter_id" ON "public"."ab_shop_car_to_materials" USING btree (
                  "shop_subdivision_daughter_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_to_material_shop_subdivision_receiver_id" ON "public"."ab_shop_car_to_materials" USING btree (
                  "shop_subdivision_receiver_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_to_material_shop_transport_company_id" ON "public"."ab_shop_car_to_materials" USING btree (
                  "shop_transport_company_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_to_material_shop_transport_id" ON "public"."ab_shop_car_to_materials" USING btree (
                  "shop_transport_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_to_material_shop_transport_waybill_id" ON "public"."ab_shop_car_to_materials" USING btree (
                  "shop_transport_waybill_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_to_material_sshop_branch_receiver_id" ON "public"."ab_shop_car_to_materials" USING btree (
                  "shop_branch_receiver_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_car_to_material_weighted_operation_id" ON "public"."ab_shop_car_to_materials" USING btree (
                  "weighted_operation_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'shop_daughter_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID филлиала',
            'table' => 'DB_Ab1_Shop_Daughter',
        ),
        'shop_material_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID материала',
            'table' => 'DB_Ab1_Shop_Material',
        ),
        'quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество',
        ),
        'shop_driver_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID водителя',
            'table' => 'DB_Ab1_Shop_Driver',
        ),
        'shop_turn_place_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID места',
            'table' => 'DB_Ab1_Shop_Turn_Place',
        ),
        'weighted_operation_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Оператор АСУ',
            'table' => 'DB_Shop_Operation',
        ),
        'update_tare_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата обработки АСУ',
        ),
        'tarra' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Вес тары',
        ),
        'shop_car_tare_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => '',
            'table' => 'DB_Ab1_Shop_Car_Tare',
        ),
        'quantity_invoice' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => false,
            'title' => '',
        ),
        'shop_client_material_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => 'DB_Ab1_Shop_Client_Material',
        ),
        'shop_transport_company_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => '',
            'table' => 'DB_Ab1_Shop_Transport_Company',
        ),
        'is_test' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Вес загружается вручную',
        ),
        'shop_branch_receiver_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID филиала куда привезли материал',
            'table' => 'DB_Shop',
        ),
        'quantity_daughter' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество по информации отправителя',
        ),
        'shop_branch_daughter_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID филиала отправитель',
            'table' => 'DB_Shop',
        ),
        'shop_heap_receiver_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID места хранения материала',
            'table' => 'DB_Ab1_Shop_Heap',
        ),
        'shop_heap_daughter_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID места откуда взяли материал',
            'table' => 'DB_Ab1_Shop_Heap',
        ),
        'receiver_at' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата принятия материала',
        ),
        'date_document' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата документа',
        ),
        'shop_subdivision_receiver_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID подразделения хранения материала',
            'table' => 'DB_Ab1_Shop_Subdivision',
        ),
        'shop_subdivision_daughter_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID подразделения откуда взяли материал',
            'table' => 'DB_Ab1_Shop_Subdivision',
        ),
        'is_weighted' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Машина прошла через весовую',
        ),
        'shop_transport_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID транспорта АТЦ',
            'table' => 'DB_Ab1_Shop_Transport',
        ),
        'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 10,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер ТТН',
        ),
        'shop_transport_waybill_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID путевого листа',
            'table' => 'DB_Ab1_Shop_Transport_Waybill',
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
