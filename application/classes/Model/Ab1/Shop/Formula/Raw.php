<?php defined('SYSPATH') or die('No direct script access.');

class Model_Ab1_Shop_Formula_Raw extends Model_Shop_Basic_Options
{

    const TABLE_NAME = 'ab_shop_formula_raws';
    const TABLE_ID = 384;

    public function __construct()
    {
        parent::__construct(
            array(
                'shop_raw_id',
                'contract_number',
                'contract_date',
                'from_at',
                'to_at',
                'is_start',
                'shop_ballast_crusher_id',
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );
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
                    case 'shop_ballast_crusher_id':
                        $this->_dbGetElement($this->getShopBallastCrusherID(), 'shop_ballast_crusher_id', new Model_Ab1_Shop_Ballast_Crusher(), $shopID);
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
        $this->isValidationFieldInt('shop_ballast_crusher_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setShopBallastCrusherID($value)
    {
        $this->setValueInt('shop_ballast_crusher_id', $value);
    }
    public function getShopBallastCrusherID()
    {
        return $this->getValueInt('shop_ballast_crusher_id');
    }

    public function setShopRawID($value)
    {
        $this->setValueInt('shop_raw_id', $value);
    }
    public function getShopRawID()
    {
        return $this->getValueInt('shop_raw_id');
    }

    public function setContractNumber($value)
    {
        $this->setValue('contract_number', $value);
    }

    public function getContractNumber()
    {
        return $this->getValue('contract_number');
    }

    public function setContractDate($value)
    {
        $this->setValueDate('contract_date', $value);
    }

    public function getContractDate()
    {
        return $this->getValueDateTime('contract_date');
    }

    public function setFromAt($value)
    {
        $this->setValueDateTime('from_at', $value);
    }

    public function getFromAt()
    {
        return $this->getValue('from_at');
    }

    public function setToAt($value)
    {
        $this->setValueDateTime('to_at', $value);
    }

    public function getToAt()
    {
        return $this->getValue('to_at');
    }

    public function setIsStart($value)
    {
        $this->setValueBool('is_start', $value);
    }

    public function getIsStart()
    {
        return $this->getValueBool('is_start');
    }
}
