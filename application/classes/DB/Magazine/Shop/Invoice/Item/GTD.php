<?php defined('SYSPATH') or die('No direct script access.');

class DB_Magazine_Shop_Invoice_Item_GTD {
    const TABLE_NAME = 'sp_shop_invoice_item_gtds';
    const TABLE_ID = 286;
    const NAME = 'DB_Magazine_Shop_Invoice_Item_GTD';
    const TITLE = 'ГТД счета-фактуры реализации продукции';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."sp_shop_invoice_item_gtds";',
            'create' => '
                -- ----------------------------
                -- Table structure for sp_shop_invoice_item_gtds
                -- ----------------------------
                CREATE TABLE "public"."sp_shop_invoice_item_gtds" (
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
                  "shop_production_id" int8 NOT NULL DEFAULT 0,
                  "quantity" float8 NOT NULL DEFAULT 0,
                  "price_realization" numeric(12,2) NOT NULL DEFAULT 0,
                  "amount_realization" float8 NOT NULL DEFAULT 0,
                  "shop_realization_item_id" int8 NOT NULL DEFAULT 0,
                  "esf_receive" text COLLATE "pg_catalog"."default",
                  "shop_invoice_id" int8 NOT NULL DEFAULT 0,
                  "is_esf" numeric(1) NOT NULL DEFAULT 0,
                  "shop_receive_item_id" int8 NOT NULL DEFAULT 0,
                  "shop_product_id" int8 NOT NULL DEFAULT 0,
                  "shop_invoice_item_id" int8 NOT NULL DEFAULT 0,
                  "price_receive" numeric(12,2) NOT NULL DEFAULT 0,
                  "amount_receive" float8 NOT NULL DEFAULT 0,
                  "shop_receive_item_gtd_id" int8 NOT NULL DEFAULT 0,
                  "shop_receive_id" int8 NOT NULL DEFAULT 0,
                  "tru_origin_code" int2 DEFAULT 6,
                  "product_declaration" varchar(255) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "product_number_in_declaration" varchar(255) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "catalog_tru_id" varchar(255) COLLATE "pg_catalog"."default",
                  "shop_realization_return_item_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."shop_production_id" IS \'ID продукции\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."quantity" IS \'Количество\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."price_realization" IS \'Цена реализации\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."amount_realization" IS \'Сумма реализации\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."shop_realization_item_id" IS \'ID реализации продукции\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."esf_receive" IS \'JSON строчки из ЭСФ приемки\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."shop_invoice_id" IS \'ID счет-фактура\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."is_esf" IS \'Есть сверка с ЭСФ\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."shop_receive_item_id" IS \'ID прихода продуктов\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."shop_product_id" IS \'ID продукта\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."shop_invoice_item_id" IS \'ID строчки счет-фактуры\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."price_receive" IS \'Цена прихода\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."amount_receive" IS \'Сумма прихода\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."shop_receive_item_gtd_id" IS \'ID ГТД прихода продуктов\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."shop_receive_id" IS \'ID прихода\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."tru_origin_code" IS \'Признак происхождения товара, работ, услуг взятый с ЭСФ, 2-ой столбец\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."product_declaration" IS \'№ Декларации на товары, заявления в рамках ТС, СТ-1 или СТ-KZ взятый с ЭСФ, 15-ый столбец\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."product_number_in_declaration" IS \'Номер товарной позиции из заявления в рамках ТС или Декларации на товары взятый с ЭСФ, 16-ый столбец\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."catalog_tru_id" IS \'Идентификатор товара, работ, услуг\';
                COMMENT ON COLUMN "public"."sp_shop_invoice_item_gtds"."shop_realization_return_item_id" IS \'ID возврата реализации продукции\';
                COMMENT ON TABLE "public"."sp_shop_invoice_item_gtds" IS \'Список ГТД счета-фактуры реализации продукции\';
                
                -- ----------------------------
                -- Indexes structure for table sp_shop_invoice_item_gtds
                -- ----------------------------
                CREATE INDEX "sp_shop_invoice_item_gtd_catalog_tru_id" ON "public"."sp_shop_invoice_item_gtds" USING btree (
                  "catalog_tru_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_invoice_item_gtd_first" ON "public"."sp_shop_invoice_item_gtds" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_invoice_item_gtd_index_id" ON "public"."sp_shop_invoice_item_gtds" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_invoice_item_gtd_is_esf" ON "public"."sp_shop_invoice_item_gtds" USING btree (
                  "is_esf" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_invoice_item_gtd_old_id" ON "public"."sp_shop_invoice_item_gtds" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_invoice_item_gtd_price_realization" ON "public"."sp_shop_invoice_item_gtds" USING btree (
                  "price_realization" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_invoice_item_gtd_product_declaration" ON "public"."sp_shop_invoice_item_gtds" USING btree (
                  "product_declaration" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_invoice_item_gtd_product_number_in_declaration" ON "public"."sp_shop_invoice_item_gtds" USING btree (
                  "product_number_in_declaration" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_invoice_item_gtd_shop_invoice_id" ON "public"."sp_shop_invoice_item_gtds" USING btree (
                  "shop_invoice_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_invoice_item_gtd_shop_invoice_item_id" ON "public"."sp_shop_invoice_item_gtds" USING btree (
                  "shop_invoice_item_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_invoice_item_gtd_shop_product_id" ON "public"."sp_shop_invoice_item_gtds" USING btree (
                  "shop_product_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_invoice_item_gtd_shop_production_id" ON "public"."sp_shop_invoice_item_gtds" USING btree (
                  "shop_production_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_invoice_item_gtd_shop_realization_item_id" ON "public"."sp_shop_invoice_item_gtds" USING btree (
                  "shop_realization_item_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_invoice_item_gtd_shop_realization_return_item_id" ON "public"."sp_shop_invoice_item_gtds" USING btree (
                  "shop_realization_return_item_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_invoice_item_gtd_shop_receive_id" ON "public"."sp_shop_invoice_item_gtds" USING btree (
                  "shop_receive_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_invoice_item_gtd_shop_receive_item_gtd_id" ON "public"."sp_shop_invoice_item_gtds" USING btree (
                  "shop_receive_item_gtd_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_invoice_item_gtd_shop_receive_item_id" ON "public"."sp_shop_invoice_item_gtds" USING btree (
                  "shop_receive_item_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_invoice_item_gtd_tru_origin_code" ON "public"."sp_shop_invoice_item_gtds" USING btree (
                  "tru_origin_code" "pg_catalog"."int2_ops" ASC NULLS LAST
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
        'shop_production_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID продукции',
            'table' => 'DB_Magazine_Shop_Production',
        ),
        'quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 20,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Количество',
        ),
        'price_realization' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена реализации',
        ),
        'amount_realization' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 20,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Сумма реализации',
        ),
        'shop_realization_item_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID реализации продукции',
            'table' => 'DB_Magazine_Shop_Realization_Item',
        ),
        'esf_receive' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON строчки из ЭСФ приемки',
        ),
        'shop_invoice_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID счет-фактура',
            'table' => 'DB_Ab1_Shop_Invoice',
        ),
        'is_esf' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Есть сверка с ЭСФ',
        ),
        'shop_receive_item_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID прихода продуктов',
            'table' => 'DB_Magazine_Shop_Receive_Item',
        ),
        'shop_product_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID продукта',
            'table' => 'DB_Magazine_Shop_Product',
        ),
        'shop_invoice_item_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID строчки счет-фактуры',
            'table' => 'DB_Magazine_Shop_Invoice_Item',
        ),
        'price_receive' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена прихода',
        ),
        'amount_receive' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 20,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Сумма прихода',
        ),
        'shop_receive_item_gtd_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID ГТД прихода продуктов',
            'table' => 'DB_Magazine_Shop_Receive_Item_GTD',
        ),
        'shop_receive_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID прихода',
            'table' => 'DB_Magazine_Shop_Receive',
        ),
        'tru_origin_code' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 4,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Признак происхождения товара, работ, услуг взятый с ЭСФ, 2-ой столбец',
        ),
        'product_declaration' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 255,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => '№ Декларации на товары, заявления в рамках ТС, СТ-1 или СТ-KZ взятый с ЭСФ, 15-ый столбец',
        ),
        'product_number_in_declaration' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 255,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Номер товарной позиции из заявления в рамках ТС или Декларации на товары взятый с ЭСФ, 16-ый столбец',
        ),
        'catalog_tru_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 255,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Идентификатор товара, работ, услуг',
        ),
        'shop_realization_return_item_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID возврата реализации продукции',
            'table' => 'DB_Magazine_Shop_Realization_Return_Item',
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
