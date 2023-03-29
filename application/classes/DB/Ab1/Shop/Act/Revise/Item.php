<?php defined('SYSPATH') or die('No direct script access.');

class DB_Ab1_Shop_Act_Revise_Item {
    const TABLE_NAME = 'ab_shop_act_revise_items';
    const TABLE_ID = 299;
    const NAME = 'DB_Ab1_Shop_Act_Revise_Item';
    const TITLE = 'Документы клиентов для акта сверки';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ab_shop_act_revise_items";',
            'create' => '
                -- ----------------------------
                -- Table structure for ab_shop_act_revise_items
                -- ----------------------------
                CREATE TABLE "public"."ab_shop_act_revise_items" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "name" text COLLATE "pg_catalog"."default",
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
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "date" date DEFAULT NULL::timestamp without time zone,
                  "act_revise_type_id" varchar(250) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 0,
                  "shop_client_id" int8 NOT NULL DEFAULT 0,
                  "is_receive" numeric(1) NOT NULL DEFAULT 1,
                  "is_cache" numeric(1) NOT NULL DEFAULT 1,
                  "shop_act_revise_id" int8 NOT NULL DEFAULT 0,
                  "date_give_to_client" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "shop_client_contract_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."date" IS \'Дата документа\';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."act_revise_type_id" IS \'ID тип документа\';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."shop_client_id" IS \'ID тип документа\';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."is_receive" IS \'Если приход 1, если расход 0\';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."is_cache" IS \'Если Наличные 1, если Безналичные 0\';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."shop_act_revise_id" IS \'ID акта сверки\';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."date_give_to_client" IS \'Дата когда было отдан акт клиенту\';
                COMMENT ON COLUMN "public"."ab_shop_act_revise_items"."shop_client_contract_id" IS \'ID договора\';
                COMMENT ON TABLE "public"."ab_shop_act_revise_items" IS \'Список документов клиентов для акта сверки\';
                
                -- ----------------------------
                -- Indexes structure for table ab_shop_act_revise_items
                -- ----------------------------
                CREATE INDEX "ab_shop_act_revise_item_act_revise_type_id" ON "public"."ab_shop_act_revise_items" USING btree (
                  "act_revise_type_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_act_revise_item_date" ON "public"."ab_shop_act_revise_items" USING btree (
                  "date" "pg_catalog"."date_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_act_revise_item_first" ON "public"."ab_shop_act_revise_items" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_act_revise_item_full_name" ON "public"."ab_shop_act_revise_items" USING gin (
                  setweight(to_tsvector(\'russian\'::regconfig, name), \'A\'::"char") "pg_catalog"."tsvector_ops"
                );
                CREATE INDEX "ab_shop_act_revise_item_index_id" ON "public"."ab_shop_act_revise_items" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_act_revise_item_index_order" ON "public"."ab_shop_act_revise_items" USING btree (
                  "order" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_act_revise_item_is_cache" ON "public"."ab_shop_act_revise_items" USING btree (
                  "is_cache" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_act_revise_item_is_receive" ON "public"."ab_shop_act_revise_items" USING btree (
                  "is_receive" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_act_revise_item_name_like" ON "public"."ab_shop_act_revise_items" USING btree (
                  lower(name) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_act_revise_item_old_id" ON "public"."ab_shop_act_revise_items" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_act_revise_shop_act_revise_id" ON "public"."ab_shop_act_revise_items" USING btree (
                  "shop_act_revise_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_act_revise_shop_client_contract_id" ON "public"."ab_shop_act_revise_items" USING btree (
                  "shop_client_contract_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "ab_shop_act_revise_shop_client_id" ON "public"."ab_shop_act_revise_items" USING btree (
                  "shop_client_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Triggers structure for table ab_shop_act_revise_items
                -- ----------------------------
                CREATE TRIGGER "ab_shop_act_revise_item_amount_in_contract_paid_amount" AFTER INSERT OR UPDATE OF "shop_id", "is_delete", "amount", "shop_client_contract_id" OR DELETE ON "public"."ab_shop_act_revise_items"
                FOR EACH ROW
                EXECUTE PROCEDURE "public"."refresh_paid_amount_client_contract"();
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
            'length' => 0,
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
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма',
        ),
        'date' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата документа',
        ),
        'act_revise_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID тип документа',
            'table' => 'DB_Ab1_Shop_Act_Revise',
        ),
        'shop_client_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID тип документа',
            'table' => 'DB_Ab1_Shop_Client',
        ),
        'is_receive' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Если приход 1, если расход 0',
        ),
        'is_cache' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Если Наличные 1, если Безналичные 0',
        ),
        'shop_act_revise_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID акта сверки',
            'table' => 'DB_Ab1_Shop_Act_Revise',
        ),
        'date_give_to_client' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата когда было отдан акт клиенту',
        ),
        'shop_client_contract_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID договора',
            'table' => 'DB_Ab1_Shop_Client_Contract',
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
