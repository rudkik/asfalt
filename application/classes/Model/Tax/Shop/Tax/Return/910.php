<?php defined('SYSPATH') or die('No direct script access.');


class Model_Tax_Shop_Tax_Return_910 extends Model_Shop_Table_Basic_Table{

	const TABLE_NAME = 'tax_shop_tax_return_910s';
	const TABLE_ID = 150;

	public function __construct(){
		parent::__construct(
			array(
                'revenue',
                'tax_view_id',
                'tax_status_id'
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}



    /**
     * Получение данных для вспомогательных элементов из базы данных
     * и добавление его в массив
     */
    public function dbGetElements($shopID = 0, $elements = NULL){
        if(($elements === NULL) || (! is_array($elements))){
        }else{
            foreach($elements as $element){
                switch($element){
                    case 'tax_view_id':
                        $this->_dbGetElement($this->getTaxViewID(), 'tax_view_id', new Model_Tax_View());
                        break;
                    case 'tax_status_id':
                        $this->_dbGetElement($this->getTaxStatusID(), 'tax_status_id', new Model_Tax_Status());
                        break;
                }
            }
        }

        parent::dbGetElements($shopID, $elements);
    }

    /**
     * Возвращаем cписок всех переменных
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);

        if($isParseArray === TRUE) {
            $arr['data'] = $this->getDataArray();
        }

        return $arr;
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $validation->rule('revenue', 'max_length', array(':value', 12))
            ->rule('year', 'max_length', array(':value', 4))
            ->rule('tax_view_id', 'max_length', array(':value', 11))
            ->rule('tax_status_id', 'max_length', array(':value', 11))
            ->rule('half_year', 'max_length', array(':value', 1));

        return $this->_validationFields($validation, $errorFields);
    }

    public function setTaxViewID($value){
        $this->setValueInt('tax_view_id', $value);
    }
    public function getTaxViewID(){
        return $this->getValueInt('tax_view_id');
    }

    public function setTaxStatusID($value){
        $this->setValueInt('tax_status_id', $value);
    }
    public function getTaxStatusID(){
        return $this->getValueInt('tax_status_id');
    }

    public function setRevenue($value){
        $this->setValueFloat('revenue', $value);
    }
    public function getRevenue(){
        return $this->getValueFloat('revenue');
    }

    public function setYear($value){
        $this->setValueInt('year', $value);
    }
    public function getYear(){
        return $this->getValueInt('year');
    }

    public function setHalfYear($value){
        $this->setValueInt('half_year', $value);
    }
    public function getHalfYear(){
        return $this->getValueInt('half_year');
    }

    public function setOSMS($value){
        $this->setValueFloat('osms', $value);
    }
    public function getOSMS(){
        return $this->getValueFloat('osms');
    }

    public function setIPN($value){
        $this->setValueFloat('ipn', $value);
    }
    public function getIPN(){
        return $this->getValueFloat('ipn');
    }

    public function setIKPN($value){
        $this->setValueFloat('ikpn', $value);
    }
    public function getIKPN(){
        return $this->getValueFloat('ikpn');
    }

    public function setSN($value){
        $this->setValueFloat('sn', $value);
    }
    public function getSN(){
        return $this->getValueFloat('sn');
    }

    public function setSO($value){
        $this->setValueFloat('so', $value);
    }
    public function getSO(){
        return $this->getValueFloat('so');
    }

    public function setOPV($value){
        $this->setValueFloat('opv', $value);
    }
    public function getOPV(){
        return $this->getValueFloat('opv');
    }

    // JSON Данные для просчета отчета
    // результат функции Api_Tax_Shop_Worker_Wage::saveSixWage
    public function setData($value){
        $this->setValue('data', $value);
    }
    public function getData(){
        return $this->getValue('data');
    }
    public function setDataArray(array $value){
        $this->setValueArray('data', $value);
    }
    public function getDataArray(){
        return $this->getValueArray('data');
    }
}
