<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Bid_ShopCompetitor extends Controller_Ab1_Bid_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Competitor';
        $this->controllerName = 'shopcompetitor';
        $this->tableID = Model_Ab1_Shop_Competitor::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Competitor::TABLE_NAME;
        $this->objectName = 'competitor';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/bid/shopcompetitor/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/competitor/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Ab1_Shop_Competitor', $this->_sitePageData->shopMainID, "_shop/competitor/list/index", "_shop/competitor/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit' => 1000, 'limit_page' => 25));

        $this->_putInMain('/main/_shop/competitor/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bid/shopcompetitor/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/competitor/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/competitor/one/new'] = Helpers_View::getViewObject($dataID, new Model_Ab1_Shop_Competitor(),
            '_shop/competitor/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopMainID);

        $this->_putInMain('/main/_shop/competitor/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bid/shopcompetitor/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/competitor/one/edit',
            )
        );

        // id записи
        $shopCompetitorID = Request_RequestParams::getParamInt('id');
        if ($shopCompetitorID === NULL) {
            throw new HTTP_Exception_404('Competitor not is found!');
        }else {
            $model = new Model_Ab1_Shop_Competitor();
            if (! $this->dublicateObjectLanguage($model, $shopCompetitorID, $this->_sitePageData->shopMainID)) {
                throw new HTTP_Exception_404('Competitor not is found!');
            }
        }
        // получаем данные
        View_View::findOne('DB_Ab1_Shop_Competitor', $this->_sitePageData->shopMainID, "_shop/competitor/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopCompetitorID), array('shop_table_catalog_id'));

        $this->_putInMain('/main/_shop/competitor/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bid/shopcompetitor/save';

        $result = Api_Ab1_Shop_Competitor::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/bid/shopcompetitor/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/bid/shopcompetitor/index'
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

    public function action_del()
    {
        $this->_sitePageData->url = '/bid/shopcompetitor/del';
        $result = Api_Ab1_Shop_Competitor::delete($this->_sitePageData, $this->_driverDB);
        $this->response->body(Json::json_encode(array('error' => $result)));
    }
}
