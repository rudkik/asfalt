<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Nur_Bookkeeping_ShopBranch extends Controller_Nur_Bookkeeping_BasicNur {

    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopbranch';
        $this->tableID = Model_Shop::TABLE_ID;
        $this->tableName = Model_Shop::TABLE_NAME;
        $this->objectName = 'branch';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/nur-bookkeeping/shopbranch/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/branch/list/index',
            )
        );

        // получаем список
        View_View::find('DB_Shop',
            $this->_sitePageData->shopID, "_shop/branch/list/index", "_shop/branch/one/index",
            $this->_sitePageData, $this->_driverDB, array('limit_page' => 25),
            array(), TRUE, TRUE
        );

        $this->_putInMain('/main/_shop/branch/index');
    }

    public function action_json() {
        $this->_sitePageData->url = '/nur-bookkeeping/shopbranch/json';

        $this->_actionJSON(
            'Request_Nur_Shop',
            'findShopBranchIDs',
            array(
                'organization_type_id' => array('name'),
                'organization_tax_type_id' => array('name'),
            ),
            new Model_Nur_Shop(),
            FALSE,
            array('shop_bookkeeper_id' => $this->_sitePageData->operationID)
        );
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/nur-bookkeeping/shopbranch/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/branch/one/new',
            )
        );

        $this->_requestShopOperations(Model_Nur_Shop_Operation::RUBRIC_BOOKKEEPING);
        $this->_requestOrganizationTypes();
        $this->_requestOrganizationTaxTypes();
        $this->_requestShopTaskGroups();
        $this->_requestBanks();
        $this->_requestShopTaxViews();
        $this->_requestShopCompanyViews();
        $this->_requestAuthorities();
        $this->_requestAkimats();

        $dataID = new MyArray();
        $dataID->id = 0;
        $dataID->isFindDB = TRUE;

        $this->_sitePageData->replaceDatas['view::_shop/branch/one/new'] = Helpers_View::getViewObject(
            $dataID, new Model_Shop(),
            '_shop/branch/one/new', $this->_sitePageData, $this->_driverDB, $this->_sitePageData->shopID
        );

        $this->_putInMain('/main/_shop/branch/new');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/nur-bookkeeping/shopbranch/edit';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::_shop/branch/one/edit',
            )
        );

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Nur_Shop();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopID, FALSE)) {
            throw new HTTP_Exception_404('Branch not is found!');
        }

        $this->_requestShopOperations(Model_Nur_Shop_Operation::RUBRIC_BOOKKEEPING, $model->getShopBookkeeperID());
        $this->_requestOrganizationTypes($model->getOrganizationTypeID());
        $this->_requestOrganizationTaxTypes($model->getOrganizationTaxTypeID());
        $this->_requestShopTaskGroups($model->getShopTaskGroupIDs());
        $this->_requestBanks($model->getBankID());
        $this->_requestShopTaxViews($model->getShopTaxViewIDs());
        $this->_requestShopCompanyViews($model->getShopCompanyViewID());
        $this->_requestAuthorities($model->getAuthorityID());
        $this->_requestAkimats($model->getAkimatID());

        // получаем данные
        View_View::findOne(
            'DB_Nur_Shop', 0, "_shop/branch/one/edit",
            $this->_sitePageData, $this->_driverDB, Request_RequestParams::setParams(array('id' => $id))
        );

        $this->_putInMain('/main/_shop/branch/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/nur-bookkeeping/shopbranch/save';

        $result = Api_Nur_Shop::save($this->_sitePageData, $this->_driverDB, TRUE);
        $this->_redirectSaveResult($result);
    }

    public function action_save_requisites_pdf()
    {
        $this->_sitePageData->url = '/nur-bookkeeping/shopbranch/save_requisites_pdf';

        // id записи
        $shopBranchID = Request_RequestParams::getParamInt('id');
        $model = new Model_Nur_Shop();
        if (! $this->dublicateObjectLanguage($model, $shopBranchID, -1, FALSE)) {
            throw new HTTP_Exception_404('Client not is found!');
        }

        Api_Nur_Shop::saveRequisitesInPDF(
            $model, $this->_sitePageData, $this->_driverDB, 'Реквизиты '.$model->getName().'.pdf', TRUE
        );
        exit;
    }
}
