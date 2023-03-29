<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Material_Storage_Metering extends Model_Shop_Basic_Options
{
    const TABLE_NAME = 'ab_shop_material_storage_meterings';
    const TABLE_ID = 354;

    public function __construct()
    {
        parent::__construct(
            array(
                'shop_material_id',
                'shop_material_storage_id',
                'meter',
                'quantity',
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
                    case 'shop_material_storage_id':
                        $this->_dbGetElement($this->getShopMaterialStorageID(), 'shop_material_storage_id', new Model_Ab1_Shop_Material_Storage(), $shopID);
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
        $this->isValidationFieldInt('shop_material_storage_id', $validation);
        $this->isValidationFieldFloat('meter', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        return $this->_validationFields($validation, $errorFields);
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

    public function setMeter($value)
    {
        $this->setValueFloat('meter', $value);
    }
    public function getMeter()
    {
        return $this->getValueFloat('meter');
    }

    public function setQuantity($value)
    {
        $this->setValueFloat('quantity', round($value, 3));
    }
    public function getQuantity()
    {
        return $this->getValueFloat('quantity');
    }
}
