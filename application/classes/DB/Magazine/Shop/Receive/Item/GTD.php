<?php defined('SYSPATH') or die('No direct script access.');

class DB_Magazine_Shop_Receive_Item_GTD {
    const TABLE_NAME = 'sp_shop_receive_item_gtds';
    const TABLE_ID = 285;
    const NAME = 'DB_Magazine_Shop_Receive_Item_GTD';
    const TITLE = 'ГДТ продуктов приемки';
    const IS_CATALOG = false;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."sp_shop_receive_item_gtds";',
            'create' => '
                -- ----------------------------
                -- Table structure for sp_shop_receive_item_gtds
                -- ----------------------------
                CREATE TABLE "public"."sp_shop_receive_item_gtds" (
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
                  "shop_product_id" int8 NOT NULL DEFAULT 0,
                  "quantity" numeric(12,3) NOT NULL DEFAULT 0,
                  "price" numeric(12,2) NOT NULL DEFAULT 0,
                  "amount" numeric(12,2) NOT NULL DEFAULT 0,
                  "shop_receive_id" int8 NOT NULL DEFAULT 0,
                  "shop_supplier_id" int8 NOT NULL DEFAULT 0,
                  "esf" text COLLATE "pg_catalog"."default",
                  "is_esf" numeric(1) NOT NULL DEFAULT 0,
                  "quantity_invoice" numeric(12,3) NOT NULL DEFAULT 0,
                  "shop_receive_item_id" int8 NOT NULL DEFAULT 0,
                  "quantity_balance" numeric(12,2) NOT NULL DEFAULT 0,
                  "tru_origin_code" int2 DEFAULT 6,
                  "product_declaration" varchar(255) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "product_number_in_declaration" varchar(255) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
                  "catalog_tru_id" varchar(255) COLLATE "pg_catalog"."default"
                )
                ;
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."name" IS \'Номер авто\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."shop_product_id" IS \'ID продукта\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."quantity" IS \'Количество\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."price" IS \'Цена\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."amount" IS \'Сумма\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."shop_receive_id" IS \'ID приемки\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."shop_supplier_id" IS \'ID поставщика\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."esf" IS \'JSON строчки из ЭСФ\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."is_esf" IS \'Есть сверка с ЭСФ\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."quantity_invoice" IS \'Количество счета-фактуры\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."shop_receive_item_id" IS \'ID продукта приемки\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."quantity_balance" IS \'Остаток продуктов на складе\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."tru_origin_code" IS \'Признак происхождения товара, работ, услуг взятый с ЭСФ, 2-ой столбец\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."product_declaration" IS \'№ Декларации на товары, заявления в рамках ТС, СТ-1 или СТ-KZ взятый с ЭСФ, 15-ый столбец\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."product_number_in_declaration" IS \'Номер товарной позиции из заявления в рамках ТС или Декларации на товары взятый с ЭСФ, 16-ый столбец\';
                COMMENT ON COLUMN "public"."sp_shop_receive_item_gtds"."catalog_tru_id" IS \'Идентификатор товара, работ, услуг\';
                COMMENT ON TABLE "public"."sp_shop_receive_item_gtds" IS \'Список ГДТ продукктов приемки\';
                
                -- ----------------------------
                -- Indexes structure for table sp_shop_receive_item_gtds
                -- ----------------------------
                CREATE INDEX "sp_shop_receive_item_gtd_first" ON "public"."sp_shop_receive_item_gtds" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_receive_item_gtd_index_id" ON "public"."sp_shop_receive_item_gtds" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_receive_item_gtd_is_esf" ON "public"."sp_shop_receive_item_gtds" USING btree (
                  "is_esf" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_receive_item_gtd_old_id" ON "public"."sp_shop_receive_item_gtds" USING btree (
                  "old_id" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_receive_item_gtd_shop_product_id" ON "public"."sp_shop_receive_item_gtds" USING btree (
                  "shop_product_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_receive_item_gtd_shop_receive_id" ON "public"."sp_shop_receive_item_gtds" USING btree (
                  "shop_receive_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_receive_item_gtd_shop_receive_item_id" ON "public"."sp_shop_receive_item_gtds" USING btree (
                  "shop_receive_item_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "sp_shop_receive_item_gtd_shop_supplier_id" ON "public"."sp_shop_receive_item_gtds" USING btree (
                  "shop_supplier_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'shop_product_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID продукта',
            'table' => 'DB_Magazine_Shop_Product',
        ),
        'quantity' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество',
        ),
        'price' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Цена',
        ),
        'amount' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Сумма',
        ),
        'shop_receive_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID приемки',
            'table' => 'DB_Magazine_Shop_Receive',
        ),
        'shop_supplier_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID поставщика',
            'table' => 'DB_Magazine_Shop_Supplier',
        ),
        'esf' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON строчки из ЭСФ',
        ),
        'is_esf' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Есть сверка с ЭСФ',
        ),
        'quantity_invoice' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 3,
            'is_not_null' => true,
            'title' => 'Количество счета-фактуры',
        ),
        'shop_receive_item_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID продукта приемки',
            'table' => 'DB_Magazine_Shop_Receive_Item',
        ),
        'quantity_balance' => array(
            'type' => DB_FieldType::FIELD_TYPE_FLOAT,
            'length' => 12,
            'decimal' => 2,
            'is_not_null' => true,
            'title' => 'Остаток продуктов на складе',
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
