<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Admin_ClientContractType extends Controller_Ab1_Admin_BasicAb1
{

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_ClientContract_Type';
        $this->controllerName = 'clientcontracttype';
        $this->tableID = Model_Ab1_ClientContract_Type::TABLE_ID;
        $this->tableName = Model_Ab1_ClientContract_Type::TABLE_NAME;
        $this->objectName = 'clientcontracttype';

        parent::__construct($request, $response);

        $this->shopID = 0;
        $this->editAndNewBasicTemplate = 'ab1/_all';
    }

    public function action_index() {
        $this->_sitePageData->url = '/jurist/clientcontracttype/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::client-contract/type/list/index',
            )
        );
        $this->_requestClientContractTypes(null, true);

        $ids = Request_Request::findNotShop(
            'DB_Ab1_ClientContract_Type', $this->_sitePageData, $this->_driverDB,
            array('limit' => 1000, 'limit_page' => 25), 0, true, array('root_id' => array('name'))
        );
        $pageOptions = $this->_sitePageData->getPageOptions();

        foreach ($ids->childs as $child){
            if(empty($child->values['interface_ids'])){
                continue;
            }
            /** @var Model_Ab1_ClientContract_Type $model */
            $model = $child->createModel('DB_Ab1_ClientContract_Type', $this->_driverDB);

            $interfaceIDs = Request_Request::find(
                'DB_Ab1_Interface', $this->_sitePageData->shopMainID,
                $this->_sitePageData, $this->_driverDB,
                Request_RequestParams::setParams(
                    array(
                        'id' => $model->getInterfaceIDsArray(),
                    )
                ),
                0, true
            );
            $child->values['interface_ids'] = implode(', ', $interfaceIDs->getChildArrayValue('name'));
        }

        $this->_sitePageData->setPageOptions($pageOptions);
        $result = Helpers_View::getViewObjects(
            $ids, new Model_Ab1_ClientContract_Type(),
            "client-contract/type/list/index", "client-contract/type/one/index",
            $this->_sitePageData, $this->_driverDB, 0, TRUE,
            array('root_id' => array('name'))
        );
        $this->_sitePageData->replaceDatas['view::client-contract/type/list/index'] = $result;

        $this->_putInMain('/main/client-contract/type/index');
    }


    public function action_template_pdf() {
        $this->_sitePageData->url = '/ab1-admin/clientcontracttype/template_pdf';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_ClientContract_Type();
        if (! $this->dublicateObjectLanguage($model, $id, $this->_sitePageData->shopMainID, FALSE)) {
            throw new HTTP_Exception_404('Client contract type not is found!');
        }

        // получаем данные
        $this->_sitePageData->newShopShablonPath('ab1/_all');
        View_View::findOne('DB_Ab1_ClientContract_Type',
            0, "client-contract/type/one/template/pdf",
            $this->_sitePageData, $this->_driverDB, array('id' => $id)
        );
        $this->_sitePageData->previousShopShablonPath();

        $this->_putInMain('/main/client-contract/type/template/pdf');
    }

    public function action_new()
    {
        $this->_sitePageData->url = '/ab1-admin/clientcontracttype/new';
        $this->_actionClientContractTypeNew();
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ab1-admin/clientcontracttype/edit';
        $this->_actionClientContractTypeEdit();
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/ab1-admin/clientcontracttype/save';

        $result = Api_Ab1_ClientContract_Type::save($this->_sitePageData, $this->_driverDB);
        $this->_redirectSaveResult($result);
    }

    public function action_save_pdf()
    {
        $this->_sitePageData->url = '/ab1-admin/clientcontracttype/save_pdf';

        $model = new Model_Ab1_ClientContract_Type();
        $model->setDBDriver($this->_driverDB);

        $id = Request_RequestParams::getParamInt('id');
        if (!Helpers_DB::dublicateObjectLanguage($model, $id, $this->_sitePageData, 0)) {
            throw new HTTP_Exception_500('Client contract type not found.');
        }

        Request_RequestParams::setParamStr('name', $model);
        $options = $model->getOptionsArray();

        $contracts = Request_RequestParams::getParamArray('contract');
        foreach ($contracts as $index => $contract){
            $arr = Arr::path($contract, 'contract_template_others', array());
            $others = [];
            foreach ($arr as $child){
                if(empty($child['url'])){
                    $others[$child['key']] = $child['name'];
                }else {
                    $others[$child['key']] = [
                        'name' => $child['name'],
                        'url' => $child['url'],
                        'field' => $child['field'],
                    ];
                }
            }
            $contracts[$index]['contract_template_others'] = $others;

            $arr = Arr::path($contract, 'contract_template_params', array());
            $others = [];
            foreach ($arr as $child){
                $others[$child['key']] = $child;
            }
            $contracts[$index]['contract_template_params'] = $others;
        }
        $options['contract'] = $contracts;

        $contracts = Request_RequestParams::getParamArray('agreement');
        foreach ($contracts as $index => $contract){
            $arr = Arr::path($contract, 'contract_template_others', array());
            $others = [];
            foreach ($arr as $child){
                if(empty($child['url'])){
                    $others[$child['key']] = $child['name'];
                }else {
                    $others[$child['key']] = [
                        'name' => $child['name'],
                        'url' => $child['url'],
                        'field' => $child['field'],
                    ];
                }
            }
            $contracts[$index]['contract_template_others'] = $others;

            $arr = Arr::path($contract, 'contract_template_params', array());
            $others = [];
            foreach ($arr as $child){
                $others[$child['key']] = $child;
            }
            $contracts[$index]['contract_template_params'] = $others;
        }
        $options['agreement'] = $contracts;

        $duplicate = Request_RequestParams::getParamStr('duplicate');
        if(!empty($duplicate)){
            $data = Arr::path($options, $duplicate);
            if(is_array($data)){
                $duplicate = explode('.', $duplicate);
                $duplicate[count($duplicate) - 1] = str_replace('.', '_', microtime(true));
                Arr::set_path($options, implode('.', $duplicate) , $data);
            }
        }

        $model->setOptionsArray($options);
        Helpers_DB::saveDBObject($model,  $this->_sitePageData, 0);
        if(Request_RequestParams::getParamBoolean('is_close') === false){
            self::redirect('/ab1-admin/clientcontracttype/template_pdf' . URL::query(['id' => $id], false));
        }else {
            self::redirect('/ab1-admin/clientcontracttype/index');
        }
    }
}
