<?php


$fieldsDB = [];
$b = false;
foreach ($dbObject::FIELDS as $key => $field){
    //получить список констант из бд после global_id
    if ($b == true ){

        $fieldsDB[$key] = $field;
        continue;
    }
    if ($key == 'global_id' ){
        $b = true;
    }
}
?> defined('SYSPATH') or die('No direct script access.');
<?php $modelName = $dbObject::NAME;
    $modelName = Api_MVC::nameModel($modelName);
?>

class <?php echo $modelName; ?> extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = '<?php echo $dbObject::TABLE_NAME; ?>';
    const TABLE_ID = '<?php echo $dbObject::TABLE_ID; ?>';

    public function __construct(){
        parent::__construct(
            array(
<?php foreach ($fieldsDB as $key => $field) {
    echo "\t\t\t'$key',\n";
}?>
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );

        $this->isAddCreated = TRUE;
    }

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     * @param int $shopID
     * @param null | array $elements
     * @return bool
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements !== NULL) && (is_array($elements))){
            foreach($elements as $element){
                switch($element){
 <?php
 $restDbFields = [];
 foreach ($fieldsDB as $key => $field) {
     $list = explode('_', $key);
     if ($list[count($list) - 1] == 'id') {
         $restDbFields[$key] = $field;
     }
 }
 foreach ($restDbFields as $key => $restDbField) {
 ?>
                  case '<?php echo $key; ?>':
                            $this->_dbGetElement($this->get<?php echo Api_MVC::getNameField($key); ?>(), '<?php echo $key; ?>', new <?php echo Api_MVC::getModelName($key, $dbObject::TABLE_NAME); ?>(), $shopID);
                            break;
 <?php } ?>
                }
            }
        }

        return parent::dbGetElements($shopID, $elements);
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());

<?php foreach ($fieldsDB as $key => $fieldDB){
    if ($fieldDB['decimal'] > 0){ ?>
        $validation->rule('<?php echo $key; ?>', 'max_length', array(':value',<?php echo $fieldDB['length'] + 1; ?>));
<?php echo "\n";} else{ ?>        $this->isValidationField<?php if ($fieldDB['type'] == 0){
            echo 'Int';
        } if ($fieldDB['type'] == 1){
                echo 'Bool';
        } if ($fieldDB['type'] == 2){
            echo 'Str';
        } ?>('<?php echo  $key; ?>', $validation);
<?php }
} ?>

        return $this->_validationFields($validation, $errorFields);
    }

<?php foreach ($fieldsDB as $key => $fieldDB) {
    $getType = Api_MVC::getTypeModel($fieldDB['type']); ?>
    public function set<?php echo Api_MVC::getNameField($key); ?>($value){
        $this->setValue<?php echo $getType; ?>('<?php echo $key; ?>', $value);
    }
    public function get<?php echo Api_MVC::getNameField($key); ?>(){
        return $this->getValue<?php echo $getType; ?>('<?php echo $key; ?>');
    }

<?php } ?>

}
