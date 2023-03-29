<?php defined('SYSPATH') or die('No direct script access.');

class DB_Shop_Operation {
    const TABLE_NAME = 'ct_shop_operations';
    const TABLE_ID = 61;
    const NAME = 'DB_Shop_Operation';
    const TITLE = 'Операторы';
    const IS_CATALOG = true;

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."ct_shop_operations";',
            'create' => '
                -- ----------------------------
                -- Table structure for ct_shop_operations
                -- ----------------------------
                CREATE TABLE "public"."ct_shop_operations" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
                  "shop_table_catalog_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_rubric_id" int8 NOT NULL DEFAULT 0,
                  "user_id" int8 NOT NULL DEFAULT 0,
                  "name" varchar(250) COLLATE "pg_catalog"."default",
                  "text" text COLLATE "pg_catalog"."default",
                  "image_path" varchar(100) COLLATE "pg_catalog"."default",
                  "files" text COLLATE "pg_catalog"."default",
                  "options" text COLLATE "pg_catalog"."default",
                  "order" int8 NOT NULL DEFAULT 0,
                  "create_user_id" int8 DEFAULT 0,
                  "update_user_id" int8 NOT NULL,
                  "delete_user_id" int8 DEFAULT 0,
                  "created_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "updated_at" timestamp(6) NOT NULL,
                  "deleted_at" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "is_delete" numeric(1) NOT NULL DEFAULT 0,
                  "language_id" int8 NOT NULL DEFAULT 35,
                  "global_id" int8 NOT NULL DEFAULT nextval(\'global_id\'::regclass),
                  "shop_table_object_ids" text COLLATE "pg_catalog"."default",
                  "password" varchar(150) COLLATE "pg_catalog"."default" NOT NULL,
                  "user_hash" varchar(32) COLLATE "pg_catalog"."default",
                  "email" varchar(150) COLLATE "pg_catalog"."default" NOT NULL,
                  "access" text COLLATE "pg_catalog"."default",
                  "shop_table_select_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_unit_id" int8 NOT NULL DEFAULT 0,
                  "shop_table_brand_id" int8 NOT NULL DEFAULT 0,
                  "is_admin" numeric(1) NOT NULL DEFAULT 0,
                  "shop_cashbox_id" int8 NOT NULL DEFAULT 0,
                  "shop_department_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."ct_shop_operations"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."shop_table_catalog_id" IS \'Тип товара\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."shop_table_rubric_id" IS \'ID рубрики\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."user_id" IS \'ID пользователя\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."ct_shop_operations"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."shop_table_object_ids" IS \'JSON данные списком\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."password" IS \'Пароль пользователя\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."user_hash" IS \'Для авторизации\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."email" IS \'E-mail пользователя\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."access" IS \'JSON доступ\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."shop_table_select_id" IS \'Тип выделения \';
                COMMENT ON COLUMN "public"."ct_shop_operations"."shop_table_unit_id" IS \'Тип единицы измерения\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."shop_table_brand_id" IS \'ID бренда \';
                COMMENT ON COLUMN "public"."ct_shop_operations"."is_admin" IS \'Администратор?\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."shop_cashbox_id" IS \'ID фискального регистратора\';
                COMMENT ON COLUMN "public"."ct_shop_operations"."shop_department_id" IS \'ID отдела\';
                
                -- ----------------------------
                -- Indexes structure for table ct_shop_operations
                -- ----------------------------
                CREATE INDEX "shop_operation_email" ON "public"."ct_shop_operations" USING btree (
                  "email" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_operation_first" ON "public"."ct_shop_operations" USING btree (
                  "is_delete" "pg_catalog"."numeric_ops" ASC NULLS LAST,
                  "language_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "shop_table_catalog_id" "pg_catalog"."int8_ops" ASC NULLS LAST,
                  "is_public" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_operation_index_id" ON "public"."ct_shop_operations" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_operation_index_order" ON "public"."ct_shop_operations" USING btree (
                  "order" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_operation_is_admin" ON "public"."ct_shop_operations" USING btree (
                  "is_admin" "pg_catalog"."numeric_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_operation_name_like" ON "public"."ct_shop_operations" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_operation_password" ON "public"."ct_shop_operations" USING btree (
                  "password" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_operation_shop_table_rubric_id" ON "public"."ct_shop_operations" USING btree (
                  "shop_table_rubric_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_operation_user_hash" ON "public"."ct_shop_operations" USING btree (
                  "user_hash" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "shop_operation_user_id" ON "public"."ct_shop_operations" USING btree (
                  "user_id" "pg_catalog"."int8_ops" ASC NULLS LAST
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
        'shop_table_catalog_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип товара',
            'table' => 'DB_Shop_Table_Catalog',
        ),
        'shop_table_rubric_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID рубрики',
            'table' => 'DB_Shop_Table_Rubric',
        ),
        'user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID пользователя',
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
        'shop_table_object_ids' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON данные списком',
        ),
        'password' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 150,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Пароль пользователя',
        ),
        'user_hash' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 32,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Для авторизации',
        ),
        'email' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 150,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'E-mail пользователя',
        ),
        'access' => array(
            'type' => DB_FieldType::FIELD_TYPE_STRING,
            'length' => 0,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'JSON доступ',
        ),
        'shop_table_select_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип выделения ',
            'table' => 'DB_Shop_Table_Select',
        ),
        'shop_table_unit_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Тип единицы измерения',
            'table' => 'DB_Shop_Table_Unit',
        ),
        'shop_table_brand_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID бренда ',
            'table' => 'DB_Shop_Table_Brand',
        ),
        'is_admin' => array(
            'type' => DB_FieldType::FIELD_TYPE_BOOLEAN,
            'length' => 1,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Администратор?',
        ),
        'shop_cashbox_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID фискального регистратора',
            'table' => 'DB_Ab1_Shop_Cashbox',
        ),
        'shop_department_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID отдела',
            'table' => 'DB_Ab1_Shop_Department',
        ),
        'operation_type_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID вида оператора',
            'table' => 'DB_Operation_Type',
        ),
        'shop_worker_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID сотрудника',
            'table' => 'DB_Ab1_Shop_Worker',
        ),
        'shop_position_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID сотрудника',
            'table' => 'DB_AutoPart_Shop_Position',
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
