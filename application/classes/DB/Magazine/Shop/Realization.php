<?php defined('SYSPATH') or die('No direct script access.');

class DB_Magazine_Shop_Realization {
    const TABLE_NAME = 'sp_shop_realizations';
    const TABLE_ID = 251;
    const NAME = 'DB_Magazine_Shop_Realization';
    const TITLE = 'Реализации';
    const IS_CATALOG = false;

    const INTEGRATIONS = [
        Integration_Ab1_1C_Service::SERVICE_NAME => [
            'type' => 'expense',
            'guid' => ['system' => 'id', '1c' => 'guid'],
            'guid_1c' => ['system' => 'guid_1c', '1c' => 'guid_1c'],
            'children' => [
                'rows' => [
                    ['table' => 'DB_Magazine_Shop_Realization_Item', 'field_1' => 'id', 'field_2' => 'shop_realization_id'],
                ],
            ],
            'default' => [
                'ver' => 'mag',
                'comment' => 'автоматическая загрузка',
            ],
            'params' => [
                'is_special' => Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF,
            ]
        ],
    ];

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."sp_shop_realizations";',
            'create' => '
                -- ----------------------------
                -- Table structure for sp_shop_realizations
                -- ----------------------------
                CREATE TABLE "public"."sp_shop_realizations" (
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
                  "shop_card_id" int8 NOT NULL DEFAULT 0,
                  "quantity" numeric(12,3) NOT NULL DEFAULT 0,
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "operation_id" int8 DEFAULT 0,
                  "shop_worker_id" int8 NOT NULL DEFAULT 0,
                  "is_special" numeric(1) NOT NULL DEFAULT 0,
                  "shop_write_off_type_id" int8 NOT NULL DEFAULT 0,
                  "fiscal_check" varchar(50) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "is_fiscal_check" numeric(1) NOT NULL DEFAULT 0,
                  "shop_cashbox_id" int8 NOT NULL DEFAULT 0,
                  "number" varchar(50) COLLATE "pg_catalog"."default"
                )
                ;
                COMMENT ON COLUMN "public"."sp_shop_realizations"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."shop_card_id" IS \'ID карты сотрудника\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."quantity" IS \'Количество\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."operation_id" IS \'Оператор приемки\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."shop_worker_id" IS \'ID работника\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."is_special" IS \'Спецзаказ (молока)\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."shop_write_off_type_id" IS \'ID места списания\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."fiscal_check" IS \'Номер фискального чека\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."is_fiscal_check" IS \'Есть ли фискальный чек\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."shop_cashbox_id" IS \'ID фискального регистратора\';
                COMMENT ON COLUMN "public"."sp_shop_realizations"."number" IS \'Номер счет-фактуры\';
                COMMENT ON TABLE "public"."sp_shop_realizations" IS \'Список реализации продукции\';
                
                -- ----------------------------
                -- Indexes structure for table sp_shop_realizations
                -- ----------------------------
                CREATE INDEX "sp_shop_realization_shop_worker_id" ON "public"."sp_shop_realizations" USING btree (
                  "shop_worker_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_relization_first" ON "public"."sp_shop_realizations" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_relization_full_name" ON "public"."sp_shop_realizations" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name::text), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "sp_shop_relization_index_id" ON "public"."sp_shop_realizations" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_relization_index_order" ON "public"."sp_shop_realizations" USING btree (
                  "order" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_relization_is_special" ON "public"."sp_shop_realizations" USING btree (
                  "is_special" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_relization_name_like" ON "public"."sp_shop_realizations" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_relization_old_id" ON "public"."sp_shop_realizations" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_relization_operation_id" ON "public"."sp_shop_realizations" USING btree (
                  "operation_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_relization_shop_card_id" ON "public"."sp_shop_realizations" USING btree (
                  "shop_card_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'bin_org' => 'bin',
                    'division' => 'old_id',
                ]
            ],
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
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => [
                    'user_iin' => 'shop_operation_id.shop_worker_id.iin',
                ]
            ],
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
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'date',
            ],
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
        'shop_card_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID карты сотрудника',
            'table' => 'DB_Magazine_Shop_Card',
        ),
        'quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество',
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма',
        ),
        'operation_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Оператор приемки',
        ),
        'shop_worker_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID работника',
            'table' => 'DB_Ab1_Shop_Worker',
        ),
        'is_special' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Спецзаказ (молока)',
        ),
        'shop_write_off_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID места списания',
            'table' => 'DB_Magazine_Shop_WriteOff_Type',
        ),
        'fiscal_check' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер фискального чека',
        ),
        'is_fiscal_check' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Есть ли фискальный чек',
        ),
        'shop_cashbox_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID фискального регистратора',
            'table' => 'DB_Ab1_Shop_Cashbox',
        ),
        'number' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 50,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер счет-фактуры',
            'integrations' => [
                Integration_Ab1_1C_Service::SERVICE_NAME => 'code',
            ],
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