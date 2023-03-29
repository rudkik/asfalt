<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopEMail extends Controller_Cabinet_BasicCabinet {
    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Shop_EMail';
        $this->controllerName = 'shopemail';
        $this->tableID = Model_Shop_EMail::TABLE_ID;
        $this->tableName = Model_Shop_EMail::TABLE_NAME;
        $this->objectName = 'email';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }
    
    public function action_index() {
        $this->_sitePageData->url = '/cabinet/shopemail/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/email/list/index',
            )
        );

        $this->_requestEMailType();

        // получаем список 
        View_View::find('DB_Shop_EMail', $this->_sitePageData->shopID, "_shop/email/list/index", "_shop/email/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25), array('email_type_id'));

        $this->_putInMain('/main/_shop/email/index');
    }

    public function action_new() {
        $this->_sitePageData->url = '/cabinet/shopemail/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/email/one/new',
            )
        );

        // получаем языки перевода
        $this->getLanguagesByShop('', TRUE);

        $this->_requestEMailType();
        $this->_requestEMailTypeOptions();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $model = new Model_Shop_EMail();
        $this->_sitePageData->replaceDatas['view::_shop/email/one/new'] = Helpers_View::getViewObject($dataID, $model, '_shop/email/one/new',
            $this->_sitePageData, $this->_driverDB);

        $this->_putInMain('/main/_shop/email/new');
    }

    public function action_edit() {
        $this->_sitePageData->url = '/cabinet/shopemail/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('E-mail not is found!');
        }else {
            $model = new Model_Shop_EMail();
            if (! $this->dublicateObjectLanguage($model, $id)) {
                throw new HTTP_Exception_404('E-mail not is found!');
            }
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/email/one/edit',
            )
        );

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'id' => $id,
                ), FALSE
            ),
            TRUE
        );

        $this->_requestEMailType($model->getEMailTypeID());
        $this->_requestEMailTypeOptions();

        // получаем список 
        View_View::findOne('DB_Shop_EMail', $this->_sitePageData->shopID, "_shop/email/one/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id));

        $this->_putInMain('/main/_shop/email/edit');
    }

    public function action_save() {
        $this->_sitePageData->url = '/cabinet/shopemail/save';
        $result = Api_Shop_EMail::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    /**
     * Делаем запрос на список e-mail типов настроек
     */
    protected function _requestEMailTypeOptions(){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::emailtype/list/options',
            )
        );

        View_View::findAll('DB_EMailType', $this->_sitePageData->shopID,
            "emailtype/list/options", "emailtype/one/options", $this->_sitePageData, $this->_driverDB);
    }

    /**
     * Делаем запрос на список e-mail типов
     * @param null $currentID
     */
    protected function _requestEMailType($currentID = NULL){
        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::emailtype/list/list',
            )
        );

        $data = View_View::find('DB_EMailType', $this->_sitePageData->shopID,
            "emailtype/list/list", "emailtype/one/list", $this->_sitePageData, $this->_driverDB,
            array(Request_RequestParams::IS_NOT_READ_REQUEST_NAME => TRUE));

        if($currentID !== NULL){
            $s = 'data-id="'.$currentID.'"';
            $data = str_replace($s, $s.' selected', $data);
            $this->_sitePageData->replaceDatas['view::emailtype/list/list'] = $data;
        }
    }
}
