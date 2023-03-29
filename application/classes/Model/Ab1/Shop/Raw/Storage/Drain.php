<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Raw_Storage_Drain extends Model_Shop_Basic_Options
{
    const TABLE_NAME = 'ab_shop_raw_storage_drains';
    const TABLE_ID = 356;

    public function __construct()
    {
        parent::__construct(
            array(
                'shop_raw_id',
                'shop_raw_storage_id',
                'shop_material_id',
                'shop_material_storage_id',
                'is_upload',
                'shop_raw_drain_chute_id',
                'shop_boxcar_client_id',
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
                    case 'shop_raw_id':
                        $this->_dbGetElement($this->getShopRawID(), 'shop_raw_id', new Model_Ab1_Shop_Raw(), $shopID);
                        break;
                    case 'shop_raw_storage_id':
                        $this->_dbGetElement($this->getShopRawStorageID(), 'shop_raw_storage_id', new Model_Ab1_Shop_Raw_Storage(), $shopID);
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
        $this->isValidationFieldInt('shop_raw_id', $validation);
        $this->isValidationFieldInt('shop_raw_storage_id', $validation);
        $this->isValidationFieldInt('shop_raw_drain_chute_id', $validation);
        $this->isValidationFieldBool('is_upload', $validation);
        $this->isValidationFieldInt('shop_material_id', $validation);
        $this->isValidationFieldInt('shop_material_storage_id', $validation);
        $this->isValidationFieldInt('shop_boxcar_client_id', $validation);
        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopBoxcarClientID($value){
        $this->setValueInt('shop_boxcar_client_id', $value);
    }
    public function getShopBoxcarClientID(){
        return $this->getValueInt('shop_boxcar_client_id');
    }

    public function setShopRawID($value)
    {
        $this->setValueInt('shop_raw_id', $value);
    }
    public function getShopRawID()
    {
        return $this->getValueInt('shop_raw_id');
    }

    public function setShopRawStorageID($value)
    {
        $this->setValueInt('shop_raw_storage_id', $value);
    }
    public function getShopRawStorageID()
    {
        return $this->getValueInt('shop_raw_storage_id');
    }

    public function setIsUpload($value)
    {
        $this->setValueBool('is_upload', $value);

        if($this->getIsUpload()){
            $this->setShopMaterialID(0);
            $this->setShopMaterialStorageID(0);
        }else{
            $this->setShopRawID(0);
            $this->setShopRawStorageID(0);
            $this->setShopRawDrainChuteID(0);
        }
    }
    public function getIsUpload()
    {
        return $this->getValueBool('is_upload');
    }

    public function setShopRawDrainChuteID($value)
    {
        $this->setValueInt('shop_raw_drain_chute_id', $value);
    }
    public function getShopRawDrainChuteID()
    {
        return $this->getValueInt('shop_raw_drain_chute_id');
    }

    public function setShopMaterialID($value)
    {
        $this->setValueInt('shop_material_id', $value);
    }
    public function getShopMaterialID()
    {
        return $this->getValueInt('shop_material_id');
    }

    public function setShopMaterialStorageID($value)
    {
        $this->setValueInt('shop_material_storage_id', $value);
    }
    public function getShopMaterialStorageID()
    {
        return $this->getValueInt('shop_material_storage_id');
    }
}
