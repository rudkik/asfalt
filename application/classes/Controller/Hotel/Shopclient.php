<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hotel_ShopClient extends Controller_Hotel_BasicHotel
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Hotel_Shop_Client';
        $this->controllerName = 'shopclient';
        $this->tableID = Model_Hotel_Shop_Client::TABLE_ID;
        $this->tableName = Model_Hotel_Shop_Client::TABLE_NAME;
        $this->objectName = 'client';

        parent::__construct($request, $response);
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/hotel/shopclient/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Hotel_Shop_Client', $this->_sitePageData->shopID, "_shop/client/list/index",
            "_shop/client/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/client/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/hotel/shopclient/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/one/new',
            )
        );

        $this->_requestBanks();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/client/one/new'] = Helpers_View::getViewObject($dataID, new Model_Hotel_Shop_Client(),
            '_shop/client/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/hotel/shopclient/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/client/one/edit',
            )
        );

        // id записи
        $shopClientID = Request_RequestParams::getParamInt('id');
        if ($shopClientID === NULL) {
            throw new HTTP_Exception_404('Client not is found!');
        } else {
            $model = new Model_Hotel_Shop_Client();
            if (!$this->dublicateObjectLanguage($model, $shopClientID)) {
                throw new HTTP_Exception_404('Client not is found!');
            }
        }

        $this->_requestBanks($model->getBankID());

        // получаем данные
        $data = View_View::findOne('DB_Hotel_Shop_Client', $this->_sitePageData->shopID, "_shop/client/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopClientID), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/hotel/shopclient/save';

        $result = Api_Hotel_Shop_Client::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if ($this->_sitePageData->branchID > 0) {
                $branchID = '&shop_branch_id=' . $this->_sitePageData->branchID;
            }

            if (Request_RequestParams::getParamBoolean('is_close') === FALSE) {
                $this->redirect('/hotel/shopclient/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    . $branchID
                );
            } else {
                $this->redirect('/hotel/shopclient/index'
                    . URL::query(
                        array(
                            'is_public_ignore' => TRUE,
                        ),
                        FALSE
                    )
                    . $branchID
                );
            }
        }
    }

    public function action_recount_balance()
    {
        $this->_sitePageData->url = '/hotel/shopclient/recount_balance';

        Api_Hotel_Shop_Client::recountClientsBalance($this->_sitePageData, $this->_driverDB);
    }
}
