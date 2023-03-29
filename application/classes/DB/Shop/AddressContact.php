<?php defined('SYSPATH') or die('No direct script access.');

class DB_Shop_AddressContact {
    const TABLE_NAME = 'ct_shop_address_contacts';
    const TABLE_ID = 61;
    const NAME = 'DB_Shop_AddressContact';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_shop_address_contacts";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_shop_address_contacts
                -- ----------------------------
                CREATE TABLE "public"."ct_shop_address_contacts" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "shop_address_id" int8 DEFAULT 0,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "text" varchar(2000) COLLATE "pg_catalog"."default",
                  "contact_type_id" int8 NOT NULL,
                  "shop_table_rubric_id" int8 DEFAULT 0,
                  "city_id" int8 NOT NULL DEFAULT 12,
                  "land_id" int8 NOT NULL DEFAULT 3161,
                  "create_user_id" int8 DEFAULT 0,
                  "update_user_id" int8 NOT NULL,
                  "delete_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "order" int4 NOT NULL DEFAULT 0,
                  "image_path" varchar(100) COLLATE "pg_catalog"."default",
                  "files" text COLLATE "pg_catalog"."default",
                  "land_ids" json
                )
                ;
                COMMENT ON COLUMN "public"."ct_shop_address_contacts"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_address_contacts"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ct_shop_address_contacts"."shop_address_id" IS \'ID контакта магазина\';
                COMMENT ON COLUMN "public"."ct_shop_address_contacts"."name" IS \'Контакт (номер телефона, e-mail, vk  и т.д.)\';
                COMMENT ON COLUMN "public"."ct_shop_address_contacts"."text" IS \'Информация после контакта (например "Спросить Оксану")\';
                COMMENT ON COLUMN "public"."ct_shop_address_contacts"."contact_type_id" IS \'Тип контакта (телефона, e-mail, vk  и т.д.)\';
                COMMENT ON COLUMN "public"."ct_shop_address_contacts"."shop_table_rubric_id" IS \'ID рубрики\';
                COMMENT ON COLUMN "public"."ct_shop_address_contacts"."city_id" IS \'ID город\';
                COMMENT ON COLUMN "public"."ct_shop_address_contacts"."land_id" IS \'ID страны\';
                COMMENT ON COLUMN "public"."ct_shop_address_contacts"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_address_contacts"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_address_contacts"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_shop_address_contacts"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ct_shop_address_contacts"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_shop_address_contacts"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_address_contacts"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ct_shop_address_contacts"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_shop_address_contacts"."order" IS \'Позиция для сортировки\';
                COMMENT ON COLUMN "public"."ct_shop_address_contacts"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ct_shop_address_contacts"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ct_shop_address_contacts"."land_ids" IS \'ID стран\';
                COMMENT ON TABLE "public"."ct_shop_address_contacts" IS \'Таблица контактов адресов\';
                
                -- ----------------------------
                -- Indexes structure for table ct_shop_address_contacts
                -- ----------------------------
                CREATE INDEX "shop_address_contact_city_id_" ON "public"."ct_shop_address_contacts" USING btree (
                  "city_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_address_contact_contact_type_id_" ON "public"."ct_shop_address_contacts" USING btree (
                  "contact_type_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_address_contact_index_id_" ON "public"."ct_shop_address_contacts" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_address_contact_land_id_" ON "public"."ct_shop_address_contacts" USING btree (
                  "land_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_address_contact_name_like_" ON "public"."ct_shop_address_contacts" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_address_contact_order_" ON "public"."ct_shop_address_contacts" USING btree (
                  "order" "pg_catalog"."int4_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_address_contact_rubric_id_" ON "public"."ct_shop_address_contacts" USING btree (
                  "shop_table_rubric_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_address_contact_shop_address_id_" ON "public"."ct_shop_address_contacts" USING btree (
                  "shop_address_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table ct_shop_address_contacts
                -- ----------------------------
                ALTER TABLE "public"."ct_shop_address_contacts" ADD CONSTRAINT "ct_shop_address_contacts_copy_pkey" PRIMARY KEY ("global_id");
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
        'shop_address_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID контакта магазина',
            'table' => 'DB_Shop_Address',
        ),
        'name' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 250,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Контакт (номер телефона, e-mail, vk  и т.д.)',
        ),
        'text' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 2000,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Информация после контакта (например Спросить Оксану)',
        ),
        'contact_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип контакта (телефона, e-mail, vk  и т.д.)',
            'table' => 'DB_ContactType',
        ),
        'shop_table_rubric_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID рубрики',
            'table' => 'DB_Shop_Table_Rubric',
        ),
        'city_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID город',
            'table' => 'DB_City',
        ),
        'land_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID страны',
            'table' => 'DB_Land',
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
        'order' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 9,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Позиция для сортировки',
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
        'land_ids' => array(
            'type' => DB_FieldType::FIELD_TYPE_JSON,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'ID стран',
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
