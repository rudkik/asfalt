<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tax_Client_ShopBankAccount extends Controller_Tax_Client_BasicTax {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopbankaccount';
        $this->tableID = Model_Tax_Shop_Bank_Account::TABLE_ID;
        $this->tableName = Model_Tax_Shop_Bank_Account::TABLE_NAME;
        $this->objectName = 'bankaccount';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/tax/shopbankaccount/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bank/account/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Tax_Shop_Bank_Account', $this->_sitePageData->shopID, "_shop/bank/account/list/index",
            "_shop/bank/account/one/index", $this->_sitePageData, $this->_driverDB, array(),
            array('bank_id' => array('name')), TRUE, TRUE);

        $this->_putInMain('/main/_shop/bank/account/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/tax/shopbankaccount/json';

        $this->_actionJSON(
            'Request_Tax_Shop_Bank_Account',
            'findShopBankAccountIDs',
            array(
                'bank_id' => array('name'),
            )
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/tax/shopbankaccount/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bank/account/one/new',
            )
        );

        $this->_requestBanks();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $data = $this->_sitePageData->replaceDatas['view::_shop/bank/account/one/new'] = Helpers_View::getViewObject($dataID, new Model_Tax_Shop_Bank_Account(),
            '_shop/bank/account/one/new', $this->_sitePageData, $this->_driverDB);

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/tax/shopbankaccount/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/bank/account/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Tax_Shop_Bank_Account();
        if (! $this->dublicateObjectLanguage($model, $id, -1, FALSE)) {
            throw new HTTP_Exception_404('Bank account not is found!');
        }

        $this->_requestBanks($model->getBankID());

        // получаем данные
        $data = View_View::findOne('DB_Tax_Shop_Bank_Account', $this->_sitePageData->shopID, "_shop/bank/account/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id), array());

        $this->response->body($this->_sitePageData->replaceStaticDatas($data));
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/tax/shopbankaccount/save';

        $result = Api_Tax_Shop_Bank_Account::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult(
            $result,
            array(
                'bank_name' => array(
                    'id' => 'bank_id',
                    'model' => new Model_Bank(),
                ),
            )
        );
    }

    public function action_del()
    {
        $this->_sitePageData->url = '/tax/shopbankaccount/del';

        Api_Tax_Shop_Bank_Account::delete($this->_sitePageData, $this->_driverDB);

        $this->response->body(Json::json_encode(array('error' => TRUE)));
    }
}
