
defined('SYSPATH') or die('No direct script access.');

class <?php echo $name; ?> {
    const TABLE_NAME = '<?php echo $tableName; ?>';
    const TABLE_ID = '<?php echo ''; ?>';
    const NAME = '<?php echo $name; ?>';
    const TITLE = '<?php echo ''; ?>';
    const IS_CATALOG = false;


    const SQL = array(
        'postgres' => array(
            'drop' => 'DROP TABLE IF EXISTS "public"."<?php echo $tableName; ?>";',
            'create' => '
                -- ----------------------------
                -- Table structure for <?php echo $tableName ."\n"; ?>
                -- ----------------------------
                DROP TABLE IF EXISTS "public"."<?php echo $tableName; ?>";
                CREATE TABLE "public"."<?php echo $tableName; ?>" (
                      <?php
                      foreach ($fieldsDB['result'] as $fieldDB) {

                          if ($fieldDB['is_nullable'] == "YES"){
                              $fieldDB['is_nullable'] = "";
                          }else{
                              $fieldDB['is_nullable'] ="NOT NULL";
                          }
                          if ($fieldDB['col_default'] == NULL){
                              $fieldDB['col_default'];
                          }else{
                              $fieldDB['col_default'] =  " DEFAULT ".$fieldDB['col_default'];
                          }

                          if ($fieldDB['udt_name'] == 'varchar'){
                              if ($fieldDB['character_maximum_length'] != 0) {
                                  $fieldDB['udt_name'] .= "(".$fieldDB['character_maximum_length'].") COLLATE \"pg_catalog\".\"default\"";
                              }
                          }elseif ($fieldDB['udt_name'] == 'numeric'){
                               $fieldDB['udt_name'] .=  "(".$fieldDB['numeric_precision'].",".$fieldDB['numeric_scale'].")";
                          }elseif ($fieldDB['udt_name'] == 'timestamp'){
                              $fieldDB['udt_name'] .= "(".$fieldDB['datetime_precision'].")";
                          }
                          
                          if ($fieldDB['col_default']){
                              $fieldDB['col_default'] =  str_replace( "'", "\'", $fieldDB['col_default']);
                          }
                      echo "\n\t\t\t\t\"" . $fieldDB['column_name']."\" ". $fieldDB['udt_name']." ". $fieldDB['is_nullable'] ." ".$fieldDB['col_default'].",";
                      }
                      ?>

                );
                ALTER TABLE "public"."<?php echo $tableName; ?>" OWNER TO "postgres";
                <?php foreach ($fieldsDB['result'] as $fieldDB) { ?>
COMMENT ON COLUMN "public"."<?php echo $tableName; ?>"."<?php echo $fieldDB['column_name']; ?>" IS \'<?php echo $fieldDB['comment']; ?>\';
                <?php } ?>

                -- ----------------------------
                -- Indexes structure for table <?php echo $tableName."\n"; ?>
                -- ----------------------------
<?php
                foreach ($indexesDB['result'] as $fieldDB){
                    $fieldDB['indexdef'] =  str_replace( "'", "\'", $fieldDB['indexdef']);
                    echo "\t\t\t\t$fieldDB[indexdef]; \n";
                }
?>
                ',
            'data' => '',
        ),

    );
    const FIELDS = array(
<?php foreach ($fields as $key => $field){

        if ($field['is_not_null'] == '0'){
            $field['is_not_null'] = 'false';
        }else{
            $field['is_not_null'] = 'true';
        }?>
        '<?php echo $key; ?>' => array(
            'type' => DB_FieldType::<?php echo DB_FieldType::fieldTypeToStr($field['type']); ?>,
            'length' => <?php echo $field['length']; ?>,
            'decimal' => <?php echo $field['decimal']; ?>,
            'is_not_null' => <?php echo $field['is_not_null']; ?>,
            'title' => '<?php echo $field['title']; ?>',
            'table' => '<?php if (!empty($field['table'])){ echo $field['table'];} ?>',
        ),
<?php } ?>
);

    // список связанных таблиц 1коМногим
    const ITEMS = array(
<?php  foreach ($items as $key => $item){
    if ($item['is_view'] == 1){
        $item['is_view'] = 'true';
    }else{
        $item['is_view'] = 'false';
    }
    ?>
        '<?php echo $key; ?>' => array(
            'table' => '<?php echo $item['table']; ?>',
            'field_id' => '<?php echo $item['field_id']; ?>',
            'is_view' => <?php echo $item['is_view']; ?>,
        ),
<?php } ?>
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
