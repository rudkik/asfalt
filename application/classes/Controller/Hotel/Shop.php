<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hotel_Shop extends Controller_Hotel_BasicHotel {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop';
        $this->controllerName = 'shop';
        $this->tableID = Model_Shop::TABLE_ID;
        $this->tableName = Model_Shop::TABLE_NAME;
        $this->objectName = 'shop';

        parent::__construct($request, $response);
    }

    public function action_edit() {
        $this->_sitePageData->url = '/hotel/shop/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::shop/one/edit',
            )
        );

        $this->_requestBanks(Arr::path($this->_sitePageData->shop->getRequisitesArray(), 'bank_id', 0));

        // получаем список заказов
        $shops = View_View::findOne('DB_Shop', $this->_sitePageData->shopID, "shop/one/edit", $this->_sitePageData, $this->_driverDB,
            array('id' => $this->_sitePageData->shopID, Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));
        $this->_sitePageData->replaceDatas['view::shop/one/edit'] = $shops;

        $this->_putInMain('/main/shop/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/hotel/shop/save';

        $result = Api_Shop::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            $this->redirect('/hotel/shopattorney/edit'
                . URL::query(
                    array(
                        'id' => $result['id'],
                    ),
                    FALSE
                )
                .$branchID
            );
        }
    }
}
