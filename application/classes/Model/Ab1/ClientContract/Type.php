<?php defined('SYSPATH') or die('No direct script access.');


class Model_Ab1_ClientContract_Type extends Model_Basic_Options {
    const CLIENT_CONTRACT_TYPE_SALE_PRODUCT = 1; // Продажа продукции
    const CLIENT_CONTRACT_TYPE_BUY_MATERIAL = 2; // Поставка материалов
    const CLIENT_CONTRACT_TYPE_BUY_RAW = 3; // Поставка сырья
    const CLIENT_CONTRACT_TYPE_TRANSPORTATION = 4; // Грузоперевозки
    const CLIENT_CONTRACT_TYPE_LEASE_CAR = 5; // Аренда автотранспорта
    const CLIENT_CONTRACT_TYPE_BUY_PRODUCT_SHOP = 6; // Поставка продуктов в магазин и столовую
    const CLIENT_CONTRACT_TYPE_BUY_FUEL = 7; // Закуп топлива

	const TABLE_NAME = 'ab_client_contract_types';
	const TABLE_ID = 373;

	public function __construct(){
		parent::__construct(
			array(
                'interface_id',
                'root_id',
            ),
			self::TABLE_NAME,
			self::TABLE_ID
		);
	}

    public function setInterfaceID($value){
        $this->setValueInt('interface_id', $value);
    }
    public function getInterfaceID(){
        return $this->getValueInt('interface_id');
    }

    public function setInterfaceIDs($value){
        $this->setValue('interface_ids', $value);
    }
    public function getInterfaceIDs(){
        return $this->getValue('interface_ids');
    }

    public function setInterfaceIDsArray(array $value){
        $this->setValueArray('interface_ids', $value, false, true);
    }
    public function getInterfaceIDsArray(){
        return $this->getValueArray('interface_ids', null, array(), false, true);
    }

    public function setRootID($value){
        $this->setValueInt('root_id', $value);
    }
    public function getRootID(){
        return $this->getValueInt('root_id');
    }
}
