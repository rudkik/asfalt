<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_Shop_Client extends Model_Shop_Table_Basic_Table{

    const TABLE_NAME = 'ab_shop_clients';
    const TABLE_ID = 58;

    public function __construct(){
        parent::__construct(
            array(
                'organization_type_id',
                'kato_id',
                'amount_cash_1c',
                'amount_1c',
                'balance',
                'balance_cache',
                'amount_act_revise_cash',
                'amount_act_revise',
                'bank_id',
                'client_type_id',
            ),
            self::TABLE_NAME,
            self::TABLE_ID
        );
    }

    /**
     * Проверяем поля на ошибки
     * @param array $errorFields - массив ошибок
     * @return boolean
     */
    public function validationFields(array &$errorFields)
    {
        $validation = new Validation($this->getValues());
        $validation->rule('bin', 'max_length', array(':value', 12))
            ->rule('address', 'max_length', array(':value', 250))
            ->rule('bik', 'max_length', array(':value', 8))
            ->rule('account', 'max_length', array(':value', 250))
            ->rule('bank', 'max_length', array(':value', 250))
            ->rule('amount', 'max_length', array(':value', 15))
            ->rule('debit_begin_year', 'max_length', array(':value', 12))
            ->rule('block_amount', 'max_length', array(':value', 15))
            ->rule('amount_cash', 'max_length', array(':value', 15))
            ->rule('block_amount_cash', 'max_length', array(':value', 15))
            ->rule('contract', 'max_length', array(':value', 250))
            ->rule('shop_payment_type_id', 'max_length', array(':value', 11))
            ->rule('organization_type_id', 'max_length', array(':value', 11))
            ->rule('kato_id', 'max_length', array(':value', 11))
            ->rule('name_1c', 'max_length', array(':value', 250))
            ->rule('name_site', 'max_length', array(':value', 250))
            ->rule('name_find', 'max_length', array(':value', 250));

        $this->isValidationFieldFloat('amount_cash_1c', $validation, 15);
        $this->isValidationFieldFloat('amount_1c', $validation, 15);
        $this->isValidationFieldFloat('balance', $validation, 15);
        $this->isValidationFieldFloat('balance_cache', $validation, 15);
        $this->isValidationFieldFloat('amount_act_revise_cash', $validation, 15);
        $this->isValidationFieldFloat('amount_act_revise', $validation, 15);
        $this->isValidationFieldInt('bank_id', $validation);
        $this->isValidationFieldInt('client_type_id', $validation);

        return $this->_validationFields($validation, $errorFields);
    }

    /**
     * Возвращаем cписок всех переменных
     */
    public function getValues($isGetElement = FALSE, $isParseArray = FALSE, $shopID = NULL)
    {
        $this->calcBalace();
        $arr = parent::getValues($isGetElement, $isParseArray, $shopID);
        return $arr;
    }

    function calcBalace(){
        $this->setBalanceCache($this->getAmountCash1C() + $this->getAmountCash() + $this->getAmountActReviseCash() - $this->getBlockAmountCash());
        $this->setBalance(
            $this->getAmount1C() + $this->getAmount() + $this->getAmountActRevise() - $this->getBlockAmount()
            + $this->getAmountCash() - $this->getBlockAmountCash() + $this->getAmountActReviseCash()
        );
    }

    /**
     * изменяет значение по имени
     * Название поля
     * Значение поля
     */
    public function setValue($name, $value) {
        if ($name == 'name'){
            $this->setNameFind(
                Func::mb_str_replace('"', '',
                    Func::mb_str_replace('.', '',
                        Func::mb_str_replace(',', '',
                            Func::mb_str_replace(' ', '', $value)
                        )
                    )
                )
            );
        }elseif ($name == 'name_1c'){
            if(!empty($value)){
                if($this->getName() == $this->getName1C() || Func::_empty($this->getName())){
                    $this->setName($value);
                }
                if($this->getNameSite() == $this->getName1C() || Func::_empty($this->getNameSite())){
                    $this->setNameSite($value);
                }
            }
        }elseif ($name == 'amount_1c' || $name == 'amount_cash_1c'){
            $value = round($value, 2);
        }

        parent::setValue($name, $value);
    }

    public function setNameFind($value){
        $this->setValue('name_find', $value);
    }
    public function getNameFind(){
        return $this->getValue('name_find');
    }

    public function setOrganizationTypeID($value){
        $this->setValueInt('organization_type_id', $value);
    }
    public function getOrganizationTypeID(){
        return $this->getValueInt('organization_type_id');
    }

    public function setKatoID($value){
        $this->setValueInt('kato_id', $value);
    }
    public function getKatoID(){
        return $this->getValueInt('kato_id');
    }

    public function setBankID($value){
        $this->setValueInt('bank_id', $value);
    }
    public function getBankID(){
        return $this->getValueInt('bank_id');
    }

    public function setClientTypeID($value){
        $this->setValueInt('client_type_id', $value);
    }
    public function getClientTypeID(){
        return $this->getValueInt('client_type_id');
    }

    public function setBIN($value){
        $this->setValue('bin', $value);
    }
    public function getBIN(){
        return $this->getValue('bin');
    }

    public function setBIK($value){
        $this->setValue('bik', $value);
    }
    public function getBIK(){
        return $this->getValue('bik');
    }

    public function setAddress($value){
        $this->setValue('address', $value);
    }
    public function getAddress(){
        return $this->getValue('address');
    }

    public function setAccount($value){
        $this->setValue('account', $value);
    }
    public function getAccount(){
        return $this->getValue('account');
    }

    public function setBank($value){
        $this->setValue('bank', $value);
    }
    public function getBank(){
        return $this->getValue('bank');
    }

    public function setEMail($value){
        $this->setValue('email', $value);
    }
    public function getEMail(){
        return $this->getValue('email');
    }

    public function setPhones($value){
        $this->setValue('phones', $value);
    }
    public function getPhones(){
        return $this->getValue('phones');
    }

    public function setContactPerson($value){
        $this->setValue('contact_person', $value);
    }
    public function getContactPerson(){
        return $this->getValue('contact_person');
    }

    public function setAmount($value){
        $this->setValueFloat('amount', round($value, 2));
        $this->calcBalace();
    }
    public function getAmount(){
        return $this->getValueFloat('amount');
    }

    public function setDebitBeginYear($value){
        $this->setValueFloat('debit_begin_year', $value);
    }
    public function getDebitBeginYear(){
        return $this->getValueFloat('debit_begin_year');
    }

    public function setBlockAmount($value){
        $this->setValueFloat('block_amount', round($value, 2));
        $this->calcBalace();
    }
    public function getBlockAmount(){
        return $this->getValueFloat('block_amount');
    }

    public function setAmountCash($value){
        $this->setValueFloat('amount_cash', round($value, 2));
        $this->calcBalace();
    }
    public function getAmountCash(){
        return $this->getValueFloat('amount_cash');
    }

    public function setAmountCash1C($value){
        $this->setValueFloat('amount_cash_1c', round($value, 2));
        $this->calcBalace();
    }
    public function getAmountCash1C(){
        return $this->getValueFloat('amount_cash_1c');
    }

    public function setAmount1C($value){
        $this->setValueFloat('amount_1c', round($value, 2));
        $this->calcBalace();
    }
    public function getAmount1C(){
        return $this->getValueFloat('amount_1c');
    }

    public function setBlockAmountCash($value){
        $this->setValueFloat('block_amount_cash', round($value, 2));
        $this->calcBalace();
    }
    public function getBlockAmountCash(){
        return $this->getValueFloat('block_amount_cash');
    }

    public function setAmountActReviseCash($value){
        $this->setValueFloat('amount_act_revise_cash', round($value, 2));
        $this->calcBalace();
    }
    public function getAmountActReviseCash(){
        return $this->getValueFloat('amount_act_revise_cash');
    }

    public function setAmountActRevise($value){
        $this->setValueFloat('amount_act_revise', round($value, 2));
        $this->calcBalace();
    }
    public function getAmountActRevise(){
        return $this->getValueFloat('amount_act_revise');
    }

    public function setBalance($value){
        $this->setValueFloat('balance', round($value, 2));
    }
    public function getBalance(){
        return $this->getValueFloat('balance');
    }

    public function setBalanceCache($value){
        $this->setValueFloat('balance_cache', round($value, 2));
    }
    public function getBalanceCache(){
        return $this->getValueFloat('balance_cache');
    }

    public function setContact($value){
        $this->setValue('contract', $value);
    }
    public function getContact(){
        return $this->getValue('contract');
    }

    public function setShopPaymentTypeID($value){
        $this->setValueInt('shop_payment_type_id', $value);
    }
    public function getShopPaymentTypeID(){
        return $this->getValueInt('shop_payment_type_id');
    }

    public function setName($value){
        parent::setName($value);
        $this->setNames($value);
    }

    public function setName1C($value){
        $this->setValue('name_1c', $value);
        $this->setNames($value);
    }
    public function getName1C(){
        return $this->getValue('name_1c');
    }
    public function setNameSite($value){
        $this->setValue('name_site', $value);
        $this->setNames($value);
    }
    public function getNameSite(){
        return $this->getValue('name_site');
    }

    public function setNames($name){
        if(Func::_empty($name)){
            return;
        }
        if(Func::_empty($this->getName())){
            $this->setName($name);
        }
        if(Func::_empty($this->getNameSite())){
            $this->setNameSite($name);
        }
        if(Func::_empty($this->getName1C())){
            $this->setName1C($name);
        }
    }
    // JSON настройки списка полей
    public function setClientTypeIDs($value){
        $this->setValue('client_type_ids', $value);
    }
    public function getClientTypeIDs(){
        return $this->getValue('client_type_ids');
    }
    public function setClientTypeIDsArray(array $value){
        $this->setValueArray('client_type_ids', $value, false, true);
    }
    public function getClientTypeIDsArray(){
        return $this->getValueArray('client_type_ids', null, array(), false, true);
    }

    public function setGUID1C($value){
        $this->setValue('guid_1c', $value);
    }
    public function getGUID1C(){
        return $this->getValue('guid_1c');
    }
}