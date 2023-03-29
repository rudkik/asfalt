<?php defined('SYSPATH') or die('No direct script access.');

class DB_Nur_Shop_Task_Current {
    const TABLE_NAME = 'nr_shop_task_currents';
    const TABLE_ID = 30;
    const NAME = 'DB_Nur_Shop_Task_Current';

    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."nr_shop_task_currents";',
            'create' => '
                -- ----------------------------
                -- Table structure for nr_shop_task_currents
                -- ----------------------------
                CREATE TABLE "public"."nr_shop_task_currents" (
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
                  "date_start" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "date_finish" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "shop_bookkeeper_id" int8 NOT NULL DEFAULT 0,
                  "date_from" timestamp(6) DEFAULT NULL::timestamp without time zone,
                  "date_to" timestamp(6) DEFAULT NULL::timestamp without time zone
                )
                ;
                COMMENT ON COLUMN "public"."nr_shop_task_currents"."is_public" IS \'Опубликована ли запись\';
                COMMENT ON COLUMN "public"."nr_shop_task_currents"."shop_id" IS \'ID магазина\';
                COMMENT ON COLUMN "public"."nr_shop_task_currents"."name" IS \'Название\';
                COMMENT ON COLUMN "public"."nr_shop_task_currents"."text" IS \'Описание \';
                COMMENT ON COLUMN "public"."nr_shop_task_currents"."image_path" IS \'Картинка\';
                COMMENT ON COLUMN "public"."nr_shop_task_currents"."files" IS \'Дополнительные файлы\';
                COMMENT ON COLUMN "public"."nr_shop_task_currents"."options" IS \'Дополнительные поля\';
                COMMENT ON COLUMN "public"."nr_shop_task_currents"."create_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."nr_shop_task_currents"."update_user_id" IS \'Кто отредактировал эту запись\';
                COMMENT ON COLUMN "public"."nr_shop_task_currents"."delete_user_id" IS \'Кто удалил запись\';
                COMMENT ON COLUMN "public"."nr_shop_task_currents"."updated_at" IS \'Дата обновления записи\';
                COMMENT ON COLUMN "public"."nr_shop_task_currents"."deleted_at" IS \'Дата удаления записи\';
                COMMENT ON COLUMN "public"."nr_shop_task_currents"."is_delete" IS \'Удалена ли запись\';
                COMMENT ON COLUMN "public"."nr_shop_task_currents"."language_id" IS \'ID языка\';
                COMMENT ON COLUMN "public"."nr_shop_task_currents"."global_id" IS \'Глобальный ID\';
                COMMENT ON COLUMN "public"."nr_shop_task_currents"."shop_task_id" IS \'ID задачи\';
                COMMENT ON COLUMN "public"."nr_shop_task_currents"."date_start" IS \'Дата начала выполнения\';
                COMMENT ON COLUMN "public"."nr_shop_task_currents"."date_finish" IS \'Дата окончания выполнения\';
                COMMENT ON COLUMN "public"."nr_shop_task_currents"."shop_bookkeeper_id" IS \'Бухгалтер обслуживающий магазин\';
                COMMENT ON COLUMN "public"."nr_shop_task_currents"."date_from" IS \'Дата начала задания\';
                COMMENT ON COLUMN "public"."nr_shop_task_currents"."date_to" IS \'Дата окончания задания\';
                COMMENT ON TABLE "public"."nr_shop_task_currents" IS \'Таблица выполняемых/выполненных задач\';
                
                -- ----------------------------
                -- Indexes structure for table nr_shop_task_currents
                -- ----------------------------
                CREATE INDEX "nr_shop_task_current_date_finish" ON "public"."nr_shop_task_currents" USING btree (
                  "date_finish" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "nr_shop_task_current_date_from" ON "public"."nr_shop_task_currents" USING btree (
                  "date_from" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "nr_shop_task_current_date_start" ON "public"."nr_shop_task_currents" USING btree (
                  "date_start" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "nr_shop_task_current_date_to" ON "public"."nr_shop_task_currents" USING btree (
                  "date_to" "pg_catalog"."timestamp_ops" ASC NULLS LAST
                );
                CREATE INDEX "nr_shop_task_current_index_id" ON "public"."nr_shop_task_currents" USING btree (
                  "id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "nr_shop_task_current_index_order" ON "public"."nr_shop_task_currents" USING btree (
                  "order" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "nr_shop_task_current_name_like" ON "public"."nr_shop_task_currents" USING btree (
                  lower(name::text) COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
                );
                CREATE INDEX "nr_shop_task_current_shop_bookkeeper_id" ON "public"."nr_shop_task_currents" USING btree (
                  "shop_bookkeeper_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                CREATE INDEX "nr_shop_task_current_shop_task_id" ON "public"."nr_shop_task_currents" USING btree (
                  "shop_task_id" "pg_catalog"."int8_ops" ASC NULLS LAST
                );
                
                -- ----------------------------
                -- Primary Key structure for table nr_shop_task_currents
                -- ----------------------------
                ALTER TABLE "public"."nr_shop_task_currents" ADD CONSTRAINT "nr_shop_task_groups_copy1_pkey2" PRIMARY KEY ("global_id");
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
        'date_start' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата начала выполнения',
        ),
        'date_finish' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата окончания выполнения',
        ),
        'shop_bookkeeper_id' => array(
            'type' => DB_FieldType::FIELD_TYPE_INTEGER,
            'length' => 18,
            'decimal' => 0,
            'is_not_null' => true,
            'title' => 'Бухгалтер обслуживающий магазин',
        ),
        'date_from' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата начала задания',
        ),
        'date_to' => array(
            'type' => DB_FieldType::FIELD_TYPE_DATE_TIME,
            'length' => 6,
            'decimal' => 0,
            'is_not_null' => false,
            'title' => 'Дата окончания задания',
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