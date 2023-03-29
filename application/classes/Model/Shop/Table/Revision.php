<?php defined('SYSPATH') or die('No direct script access.');


class Model_Shop_Table_Revision extends Model_Shop_Basic_Remarketing{

	const TABLE_NAME = 'ct_shop_table_revisions';
	const TABLE_ID = 81;

	public function __construct(){
		parent::__construct(
			array(
			),
			self::TABLE_NAME,
			self::TABLE_ID
		);

		$this->isAddCreated = TRUE;
        $this->isCreateUser = TRUE;
	}

    public function setShopTableStockID($value){
        $this->setValueInt('shop_table_stock_id', $value);
    }
    public function getShopTableStockID(){
        return $this->getValueInt('shop_table_stock_id');
    }
}
