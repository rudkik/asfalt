<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Raw_DrainChute extends Model_Shop_Basic_Options
{
    const TABLE_NAME = 'ab_shop_raw_drain_chutes';
    const TABLE_ID = 352;

    public function __construct()
    {
        parent::__construct(
            array(
                'shop_raw_id',
                'shop_boxcar_client_id',
                'size_ton',
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
        $this->isValidationFieldInt('shop_boxcar_client_id', $validation);
        $this->isValidationFieldFloat('size_ton', $validation);
        $this->isValidationFieldFloat('quantity', $validation);
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

    public function setSizeTon($value)
    {
        $this->setValueFloat('size_ton', $value);
    }
    public function getSizeTon()
    {
        return $this->getValueFloat('size_ton');
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
