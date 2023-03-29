<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Material_Storage extends Model_Shop_Basic_Options
{
    const TABLE_NAME = 'ab_shop_material_storages';
    const TABLE_ID = 351;

    public function __construct()
    {
        parent::__construct(
            array(
                'shop_material_id',
                'ton_in_meter',
                'size_meter',
                'quantity',
                'is_up',
                'is_upload',
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );
        $this->isAddCreated = TRUE;
    }

    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     */
    public function dbGetElements($shopID = 0, $elements = NULL)
    {
        if (($elements === NULL) || (!is_array($elements))) {
        } else {
            foreach ($elements as $element) {
                switch ($element) {
                    case 'shop_material_id':
                        $this->_dbGetElement($this->getShopMaterialID(), 'shop_material_id', new Model_Ab1_Shop_Material(), $shopID);
                        break;
                }
            }
        }

        parent::dbGetElements($shopID, $elements);
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $this->isValidationFieldInt('shop_material_id', $validation);
        $this->isValidationFieldFloat('ton_in_meter', $validation);
        $this->isValidationFieldFloat('size_meter', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        $this->isValidationFieldBool('is_up', $validation);
        $this->isValidationFieldBool('is_upload', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * изменяет значение по именя
     * Название поля
     * Значение поля
     */
    public function setValue($name, $value)
    {
        parent::setValue($name, $value);

        if($name == 'quantity') {
            $this->setIsUp($this->getQuantity() >= $this->getOriginalValue('quantity'));
        }
    }

    public function setIsUp($value)
    {
        $this->setValueBool('is_up', $value);
    }
    public function getIsUp()
    {
        return $this->getValueBool('is_up');
    }

    public function setIsUpload($value)
    {
        $this->setValueBool('is_upload', $value);
    }
    public function getIsUpload()
    {
        return $this->getValueBool('is_upload');
    }

    public function setShopMaterialID($value)
    {
        $this->setValueInt('shop_material_id', $value);
    }
    public function getShopMaterialID()
    {
        return $this->getValueInt('shop_material_id');
    }

    public function setTonInMeter($value)
    {
        $this->setValueFloat('ton_in_meter', $value);
    }
    public function getTonInMeter()
    {
        return $this->getValueFloat('ton_in_meter');
    }

    public function setSizeMeter($value)
    {
        $this->setValueFloat('size_meter', $value);
    }
    public function getSizeMeter()
    {
        return $this->getValueFloat('size_meter');
    }

    public function setQuantity($value){
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity(){
        return $this->getValueFloat('quantity');
    }

    public function setMeter($value){
        $this->setValueFloat('meter', $value);
    }
    public function getMeter(){
        return $this->getValueFloat('meter');
    }
}
