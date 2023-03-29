<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_Client_ShopECP extends Controller_Tax_Client_BasicTax {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopecp';
        $this->tableID = Model_Tax_Shop_ECP::TABLE_ID;
        $this->tableName = Model_Tax_Shop_ECP::TABLE_NAME;
        $this->objectName = 'ecp';

        parent::__construct($request, $response);
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tax/shopecp/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/ecp/one/edit',
            )
        );

        $ids = Request_Tax_Shop_ECP::findShopECPIDs($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 1, TRUE);
        if (count($ids->childs) == 0){
            $data = $ids->addChild(0);
            $data->isFindDB = TRUE;
            $data->isLoadElements = TRUE;
        }

        $this->_sitePageData->replaceDatas['view::_shop/ecp/one/edit'] = Helpers_View::getViewObject($ids->childs[0], new Model_Tax_Shop_ECP(),
            '_shop/ecp/one/edit', $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/ecp/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tax/shopecp/save';

        $id = Request_Tax_Shop_ECP::findShopECPIDs($this->_sitePageData->shopID, $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE), 1, TRUE);
        if (count($id->childs) == 0){
            $id = 0;
        }else{
            $id = $id->childs[0]->id;
        }

        $result = Api_Tax_Shop_ECP::save($id, $this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $result = $result['result'];
            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/tax/shopecp/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/tax/shopecp/index'
                    . URL::query(
                        array(
                            'is_public_ignore' => TRUE,
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }
        }
    }
}
