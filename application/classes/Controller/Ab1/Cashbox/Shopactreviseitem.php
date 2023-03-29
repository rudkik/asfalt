<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Cashbox_ShopActReviseItem extends Controller_Ab1_Cashbox_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Act_Revise_Item';
        $this->controllerName = 'shopactreviseitem';
        $this->tableID = Model_Ab1_Shop_Act_Revise_Item::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Act_Revise_Item::TABLE_NAME;
        $this->objectName = 'actreviseitem';

        parent::__construct($request, $response);
    }

    public function action_edit_contract() {
        $this->_sitePageData->url = '/cashbox/shopactreviseitem/edit_contract';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/act/revise/item/list/edit-contract',
            )
        );

        $date = date('Y-m-d');
        $params = Request_RequestParams::setParams(
            array(
                'is_basic' => true,
                'from_at_to' => $date,
                'to_at_from_equally' => $date,
            ),
            false
        );

        $limit = Request_RequestParams::getParamInt('limit_page');
        if($limit < 1){
            $limit = 25;
        }

        $shopClientContractIDs = Request_Request::findBranch(
            'DB_Ab1_Shop_Client_Contract', array(), $this->_sitePageData, $this->_driverDB, $params,
            0, true,
            array(
                'executor_shop_worker_id' => array('name')
            )
        );
        $clientIDs = $shopClientContractIDs->getChildArrayInt('shop_client_id', true);

        if(!empty($clientIDs)){
            $params = Request_RequestParams::setParams(
                array(
                    'date_from' => Helpers_DateTime::getYearBeginStr(date('Y')),
                    'shop_client_id' => $clientIDs,
                    'shop_client_contract_id' => 0,
                    'is_receive' => true,
                ),
                false
            );

            $ids = Request_Request::findBranch(
                'DB_Ab1_Shop_Act_Revise_Item', array(), $this->_sitePageData, $this->_driverDB, $params,
                $limit, true,
                array(
                    'shop_client_id' => array('name'),
                )
            );
        }else{
            $ids = new MyArray();
        }

        // группируем договора по клиентам
        $clientIDs = array();
        foreach ($shopClientContractIDs->childs as $child){
            $client = $child->values['shop_client_id'];
            if(!key_exists($client, $clientIDs)){
                $clientIDs[$client] = array();
            }

            $clientIDs[$client][$child->id] = $child;
        }

        foreach ($ids->childs as $child){
            $client = $child->values['shop_client_id'];
            if(key_exists($client, $clientIDs)){
                $child->additionDatas['contracts'] = $clientIDs[$client];
            }
        }

        $result = Helpers_View::getViewObjects(
            $ids, new Model_Ab1_Shop_Act_Revise_Item(),
            "_shop/act/revise/item/list/edit-contract", "_shop/act/revise/item/one/edit-contract",
            $this->_sitePageData, $this->_driverDB, 0
        );
        $this->_sitePageData->replaceDatas['view::_shop/act/revise/item/list/edit-contract'] = $result;

        // получаем список
       /* View_View::findBranch('DB_Ab1_Shop_Act_Revise_Item',
            array(),
            "_shop/act/revise/item/list/edit-contract", "_shop/act/revise/item/one/edit-contract",
            $this->_sitePageData, $this->_driverDB,
            $params,
            array(
                'limit_page' => 25,
                'shop_client_id' => array('name'),
                'shop_client_contract_id' => array('number'),
            )
        );*/

        $this->_putInMain('/main/_shop/act/revise/item/edit-contract');
    }

    public function action_save_contracts()
    {
        $this->_sitePageData->url = '/cashbox/shopactreviseitem/save_contracts';

        $shopClientContracts = Request_RequestParams::getParamArray('shop_client_contract_ids', array(), array());

        foreach ($shopClientContracts as $id => $shopClientContractID){
            if($shopClientContractID < 1 || $id < 1){
                continue;
            }
            $this->_driverDB->updateObjects(
                Model_Ab1_Shop_Act_Revise_Item::TABLE_NAME,
                array($id), array('shop_client_contract_id' => $shopClientContractID)
            );
        }

        $this->redirect('/cashbox/shopactreviseitem/edit_contract');
    }
}
