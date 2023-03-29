<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopSubscribe extends Controller_Cabinet_BasicCabinet
{

    public function action_index(){
        $this->_sitePageData->url = '/cabinet/shopsubscribe/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::shopsubscribes/index',
                'view::subscribe_type',
            )
        );

        // получаем товары
        $model = new Model_Shop_Table_Catalog();
        $model->setDBDriver($this->_driverDB);
        if(! $this->getDBObject($model, Request_RequestParams::getParamInt('type'), $this->_sitePageData->shopMainID)){
            throw new HTTP_Exception_404('Subscribe catalog not is found!');
        }
        $this->_sitePageData->replaceDatas['view::subscribe_type'] = $model->getName();

        // получаем список
        View_View::find('DB_Shop_Subscribe', $this->_sitePageData->shopID,
            "shopsubscribes/index", "shopsubscribe/index", $this->_sitePageData, $this->_driverDB, array('limit_page' => 25));

        $this->_putInMain('/main/shopsubscribe/index');
    }

    public function action_new(){
        $this->_sitePageData->url = '/cabinet/shopsubscribe/new';

        $typeID = Request_RequestParams::getParamInt('type');

        // получаем товары
        $modelSubscribeCatalog = new Model_Shop_Table_Catalog();
        if(! $this->getDBObject($modelSubscribeCatalog, $typeID, $this->_sitePageData->shopMainID)){
            throw new HTTP_Exception_404('ShopSubscribeCatalog not is found!');
        }
        $this->_sitePageData->replaceDatas['view::subscribe_type'] = $modelSubscribeCatalog->getName();

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::shopsubscribe/new',
                'view::subscribe_type',
            )
        );

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'type' => $typeID,
                ), FALSE
            ),
            FALSE
        );

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $model = new Model_Shop_Subscribe();
        $datas = Helpers_View::getViewObject($dataID, $model, 'shopsubscribe/new', $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->replaceDatas['view::shopsubscribe/new'] = $datas;

        $this->_putInMain('/main/shopsubscribe/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/cabinet/shopsubscribe/edit';

        $typeID = Request_RequestParams::getParamInt('type');

        // получаем товары
        $modelSubscribeCatalog = new Model_Shop_Table_Catalog();
        if (! $this->getDBObject($modelSubscribeCatalog, $typeID, $this->_sitePageData->shopMainID)) {
            throw new HTTP_Exception_404('ShopSubscribeCatalog not is found!');
        }
        $this->_sitePageData->replaceDatas['view::subscribe_type'] = $modelSubscribeCatalog->getName();

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Subscribe not is found!');
        }else {
            $model = new Model_Shop_Subscribe();
            if (! $this->dublicateObjectLanguage($model, $id)) {
                throw new HTTP_Exception_404('Subscribe not is found!');
            }
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::shopsubscribe/edit',
                'view::subscribe_type',
            )
        );

        // получаем языки перевода
        $this->getLanguagesByShop(
            URL::query(
                array(
                    'id' => $id,
                    'type' => $typeID,
                ), FALSE
            ),
            FALSE
        );

        // получаем данные
        $data = View_View::findOne('DB_Shop_Subscribe', $this->_sitePageData->shopID, "shopsubscribe/edit",
            $this->_sitePageData, $this->_driverDB, array('id' => $id));

        $this->_putInMain('/main/shopsubscribe/edit');
    }

    /**
     * изменение статьи
     */
    public function action_save()
    {
        $this->_sitePageData->url = '/cabinet/shopsubscribe/save';

        $model = new Model_Shop_Subscribe();

        $id = Request_RequestParams::getParamInt('id');
        if (! $this->dublicateObjectLanguage($model, $id)) {
            throw new HTTP_Exception_500('Subscribe not found.');
        }

        Request_RequestParams::setParamBoolean('is_public', $model);
        Request_RequestParams::setParamStr('text', $model);
        Request_RequestParams::setParamStr('email', $model);

        $options = Request_RequestParams::getParamArray('options');
        if($options !== NULL){
            $model->setOptionsArray($options);
        }

        if ($model->id < 1) {
            $type = intval(Request_RequestParams::getParamInt('type'));
            $model->setShopSubscribeCatalogID($type);
        }else{
            $type = $model->getShopSubscribeCatalogID();
        }

        $result = array();
        if ($model->validationFields($result)) {
            $model->setEditUserID($this->_sitePageData->userID);
            if($model->id < 1) {
                $this->saveDBObject($model);
            }

            $file = new Model_File($this->_sitePageData);
            $file->saveFiles(Request_RequestParams::getParamArray('files'), $model, $this->_sitePageData, $this->_driverDB);

            $this->saveDBObject($model);
            $result['values'] = $model->getValues();
        }

        if (Request_RequestParams::getParamBoolean('json') || $result['error']) {
            $this->response->body(Json::json_encode($result));
        } else {
            $branchID = '';
            if($this->_sitePageData->branchID > 0){
                $branchID = '&shop_branch_id='.$this->_sitePageData->branchID;
            }
            if(Request_RequestParams::getParamBoolean('is_close') === FALSE){
                $this->redirect('/cabinet/shopsubscribe/edit?is_main=1&id='.$model->id.'&type='.$type.$branchID);
            }else{
                $this->redirect('/cabinet/shopsubscribe/index?is_main=1&type='.$type.'&shop_subscribe_id='.$model->id.$branchID);
            }
        }
    }
}
