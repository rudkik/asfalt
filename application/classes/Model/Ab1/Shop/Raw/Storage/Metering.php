<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Raw_Storage_Metering extends Model_Shop_Basic_Options
{
    const TABLE_NAME = 'ab_shop_raw_storage_meterings';
    const TABLE_ID = 353;

    public function __construct()
    {
        parent::__construct(
            array(
                'shop_raw_id',
                'shop_raw_storage_id',
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
        $this->isValidationFieldFloat('meter', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
        return $this->_validationFields($validation, $errorFields);
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
        $this->setValueFloat('quantity', $value);
    }
    public function getQuantity()
    {
        return $this->getValueFloat('quantity');
    }
}
