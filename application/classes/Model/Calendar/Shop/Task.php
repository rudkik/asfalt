<?php defined('SYSPATH') or die('No direct script access.');


class Model_Calendar_Shop_Task extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'tc_shop_tasks';
	const TABLE_ID = 289;

	public function __construct(){
		parent::__construct(
			array(
                'date_from',
                'date_to',
                'shop_product_id',
                'shop_rubric_id',
                'shop_partner_id',
                'cost',
                'shop_result_id',
                'mbc',
                'is_calendar_outer',
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
        if(is_array($elements)){
            foreach($elements as $element){
                switch($element){
                    case 'shop_product_id':
                        $this->_dbGetElement($this->getShopProductID(), 'shop_product_id', new Model_Calendar_Shop_Product(), $shopID);
                        break;
                    case 'shop_result_id':
                        $this->_dbGetElement($this->getShopResultID(), 'shop_result_id', new Model_Calendar_Shop_Result(), $shopID);
                        break;
                    case 'shop_rubric_id':
                        $this->_dbGetElement($this->getShopRubricID(), 'shop_rubric_id', new Model_Calendar_Shop_Rubric(), $shopID);
                        break;
                    case 'shop_partner_id':
                        $this->_dbGetElement($this->getShopPartnerID(), 'shop_partner_id', new Model_Calendar_Shop_Partner(), $shopID);
                        break;
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

        $this->isValidationFieldInt('shop_product_id', $validation);
        $this->isValidationFieldInt('shop_rubric_id', $validation);
        $this->isValidationFieldInt('shop_partner_id', $validation);
        $this->isValidationFieldFloat('cost', $validation);
        $this->isValidationFieldInt('shop_result_id', $validation);
        $this->isValidationFieldStr('mbc', $validation, 20);
        $this->isValidationFieldBool('is_calendar_outer', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    public function setIsCalendarOuter($value){
        $this->setValueBool('is_calendar_outer', $value);
    }
    public function getIsCalendarOuter(){
        return $this->getValueBool('is_calendar_outer');
    }

    public function setShopProductID($value){
        $this->setValueInt('shop_product_id', $value);
    }
    public function getShopProductID(){
        return $this->getValueInt('shop_product_id');
    }

    public function setShopRubricID($value){
        $this->setValueInt('shop_rubric_id', $value);
    }
    public function getShopRubricID(){
        return $this->getValueInt('shop_rubric_id');
    }

    public function setShopPartnerID($value){
        $this->setValueInt('shop_partner_id', $value);
    }
    public function getShopPartnerID(){
        return $this->getValueInt('shop_partner_id');
    }

    public function setShopResultID($value){
        $this->setValueInt('shop_result_id', $value);
    }
    public function getShopResultID(){
        return $this->getValueInt('shop_result_id');
    }

    public function setDateFrom($value){
        $this->setValueDate('date_from', $value);
    }
    public function getDateFrom(){
        return $this->getValueDate('date_from');
    }

    public function setDateTo($value){
        $this->setValueDate('date_to', $value);
    }
    public function getDateTo(){
        return $this->getValueDate('date_to');
    }

    public function setCost($value){
        $this->setValueFloat('cost', $value);
    }
    public function getCost(){
        return $this->getValueFloat('cost');
    }

    public function setMBC($value){
        $this->setValue('mbc', $value);
    }
    public function getMBC(){
        return $this->getValue('mbc');
    }
}
