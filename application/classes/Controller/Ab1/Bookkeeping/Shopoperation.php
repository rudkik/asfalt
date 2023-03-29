<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Bookkeeping_ShopOperation extends Controller_Ab1_Bookkeeping_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Operation';
        $this->controllerName = 'shopoperation';
        $this->tableID = Model_Ab1_Shop_Operation::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Operation::TABLE_NAME;
        $this->objectName = 'operation';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/bookkeeping/shopoperation/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/operation/list/index',
            )
        );

        // получаем список
        View_View::find(
            'DB_Shop_Operation', $this->_sitePageData->shopID,
            '_shop/operation/list/index', '_shop/operation/one/index',
            $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25, 'shop_table_rubric_id' => Model_Ab1_Shop_Operation::RUBRIC_BOOKKEEPING),
            ['shop_worker_id' => ['name']]
        );

        $this->_putInMain('/main/_shop/operation/index');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/bookkeeping/shopoperation/new';
        $this->_actionShopOperationNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/bookkeeping/shopoperation/edit';
        $this->_actionShopOperationEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/bookkeeping/shopoperation/save';

        $result = Api_Shop_Operation::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $this->response->body(Json::json_encode($result['result']));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/bookkeeping/shopoperation/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/bookkeeping/shopoperation/index'
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
