<?php defined('SYSPATH') or die('No direct script access.');

class DB_Nur_Shop_Task_Group_Item {
    const TABLE_NAME = 'nr_shop_task_group_items';
    const TABLE_ID = 30;
    const NAME = 'DB_Nur_Shop_Task_Group_Item';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."nr_shop_task_group_items";',
            'create' => '
                -- ----------------------------
                -- Table structure for nr_shop_task_group_items
                -- ----------------------------
                CREATE TABLE "public"."nr_shop_task_group_items" (
                  "id" int8 NOT NULL,
                  "is_public" numeric(1) NOT NULL DEFAULT 1,
                  "shop_id" int8 NOT NULL,
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
                  "shop_task_id" int8 NOT NULL DEFAULT 0,
                  "shop_task_group_id" int8 NOT NULL DEFAULT 0
                )
                ;
                COMMENT ON COLUMN "public"."nr_shop_task_group_items"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."nr_shop_task_group_items"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."nr_shop_task_group_items"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."nr_shop_task_group_items"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."nr_shop_task_group_items"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."nr_shop_task_group_items"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."nr_shop_task_group_items"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."nr_shop_task_group_items"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."nr_shop_task_group_items"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."nr_shop_task_group_items"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."nr_shop_task_group_items"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."nr_shop_task_group_items"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."nr_shop_task_group_items"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."nr_shop_task_group_items"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."nr_shop_task_group_items"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."nr_shop_task_group_items"."shop_task_id" IS \'ID задачи\';
                COMMENT ON COLUMN "public"."nr_shop_task_group_items"."shop_task_group_id" IS \'ID группа задачи\';
                COMMENT ON TABLE "public"."nr_shop_task_group_items" IS \'Таблица связей групп из задач\';
                
                -- ----------------------------
                -- Indexes structure for table nr_shop_task_group_items
                -- ----------------------------
                CREATE INDEX "nr_shop_task_group_item_index_id" ON "public"."nr_shop_task_group_items" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "nr_shop_task_group_item_index_order" ON "public"."nr_shop_task_group_items" USING btree (
                  "order" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "nr_shop_task_group_item_shop_task_group_id" ON "public"."nr_shop_task_group_items" USING btree (
                  "shop_task_group_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "nr_shop_task_group_item_shop_task_id" ON "public"."nr_shop_task_group_items" USING btree (
                  "shop_task_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table nr_shop_task_group_items
                -- ----------------------------
                ALTER TABLE "public"."nr_shop_task_group_items" ADD CONSTRAINT "nr_shop_task_groups_copy1_pkey" PRIMARY KEY ("global_id");
            ',
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
        ),
        'update_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Кто отредактировал эту запись',
        ),
        'delete_user_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Кто удалил запись',
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
        ),
        'global_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Глобальный ID',
        ),
        'shop_task_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID задачи',
        ),
        'shop_task_group_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'ID группа задачи',
        ),
    );

    // список связанных таблиц 1коМногим
    const ITEMS = array(

    );

    /**
     * Получение
     * @param string $db
     * @param array|string $fields
     * @param bool $isDropTable
     * @return string
     */
    public static function getCreateTableSQL($db = 'postgres', $fields = 'all', $isDropTable = FALSE)
    {
        if (!key_exists($db, self::SQL)){
            return '';
        }

        $sql = '';
        if ($isDropTable){
            $sql .= self::SQL[$db]['drop'];
        }
        $sql .= self::SQL[$db]['create'];
        if (is_array($fields)) {
            foreach ($fields as $field) {
                if (key_exists($field, self::SQL[$db]['fields'])) {
                    $sql .= self::SQL[$db]['fields'][$field];
                }
            }
        }elseif($fields == 'all'){
            foreach (self::SQL[$db]['fields'] as $field) {
                $sql .= $field;
            }
        }

        return $sql.self::SQL[$db]['data'];
    }
}