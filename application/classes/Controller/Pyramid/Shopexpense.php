<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Pyramid_ShopExpense extends Controller_Pyramid_BasicPyramid {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopexpense';
        $this->tableID = Model_Pyramid_Shop_Expense::TABLE_ID;
        $this->tableName = Model_Pyramid_Shop_Expense::TABLE_NAME;
        $this->objectName = 'expense';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/pyramid/shopexpense/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/expense/list/index',
            )
        );

        View_View::find('DB_Pyramid_Shop_Expense', $this->_sitePageData->shopID, "_shop/expense/list/index",
            "_shop/expense/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array(), TRUE, TRUE);

        $this->_putInMain('/main/_shop/expense/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/pyramid/shopexpense/json';
        $this->_actionJSON(
            'Request_Pyramid_Shop_Expense',
            'findShopExpenseIDs',
            array(
                'shop_expense_type_id' => array('name'),
                'currency_id' => array('symbol'),
            ),
            array(
                'shop_client_id' => $this->_sitePageData->operationID
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/pyramid/shopexpense/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/expense/one/new',
            )
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/expense/one/new'] = Helpers_View::getViewObject($dataID, new Model_Pyramid_Shop_Expense(),
            '_shop/expense/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/pyramid/shopexpense/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/expense/one/edit',
            )
        );

        // id записи
        $shopExpenseID = Request_RequestParams::getParamInt('id');
        if ($shopExpenseID === NULL) {
            throw new HTTP_Exception_404('Expense not is found!');
        }else {
            $model = new Model_Pyramid_Shop_Expense();
            if (! $this->dublicateObjectLanguage($model, $shopExpenseID)) {
                throw new HTTP_Exception_404('Expense not is found!');
            }
        }

        // получаем данные
        $data = View_View::findOne('DB_Pyramid_Shop_Expense', $this->_sitePageData->shopID, "_shop/expense/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $shopExpenseID), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/pyramid/shopexpense/save';

        $result = Api_Pyramid_Shop_Expense::save($this->_sitePageData, $this->_driverDB);

        if (Request_RequestParams::getParamBoolean('json') || $result['result']['error']) {
            $result = $result['result'];

            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }

            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/pyramid/shopexpense/edit'
                    . URL::query(
                        array(
                            'id' => $result['id'],
                        ),
                        FALSE
                    )
                    .$branchID
                );
            }else {
                $this->redirect('/pyramid/shopexpense/index'
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
        $this->_sitePageData->url = '/pyramid/shopexpense/del';

        Api_Pyramid_Shop_Expense::delete($this->_sitePageData, $this->_driverDB);

        $this->response->body(Json::json_encode(array('error' => TRUE)));
    }
}
