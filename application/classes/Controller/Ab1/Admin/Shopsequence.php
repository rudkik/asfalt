<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Admin_ShopSequence extends Controller_Ab1_Admin_BasicAb1 {

    public function __construct(Request $request, Response $response)
    {
        $this->dbObject = 'DB_Ab1_Shop_Sequence';
        $this->controllerName = 'shopsequence';
        $this->tableID = Model_Ab1_Shop_Sequence::TABLE_ID;
        $this->tableName = Model_Ab1_Shop_Sequence::TABLE_NAME;
        $this->objectName = 'sequence';

        parent::__construct($request, $response);
    }

    public function action_index() {
        $this->_sitePageData->url = '/ab1-admin/shopsequence/index';

        $this->_requestListDB('DB_Table');

        parent::_actionIndex(
            array(
                'table_id' => array('name'),
            )
        );

        $params = Request_RequestParams::setParams(
            array(
                'limit' => 1000,
                'limit_page' => 25,
                'sort_by' => array(
                    'name' => 'asc',
                ),
            )
        );
        $ids = Request_Request::find(
            'DB_Ab1_Shop_Sequence', 0, $this->_sitePageData, $this->_driverDB, $params, 0, true,
            array(
                'shop_id' => array('name'),
                'table_id' => array('name'),
            )
        );

        $childs = array();
        $sequences = $this->_driverDB->getSequences();
        foreach ($sequences as $sequence){
            $list = array();
            $sequenceChild = '';
            foreach ($ids->childs as $child){
                $sequenceName = $child->values['sequence'];
                if(($sequence['sequence_name'] == $sequenceName && $child->values['is_branch'] == 0)
                    || strpos($sequence['sequence_name'], $sequenceName.'_s'.$child->values['shop_id']) !== false){
                    $list[] = $child;
                    $sequenceChild = $sequence['sequence_name'];
                }
            }

            foreach ($list as $child){
                if(Arr::path($child->additionDatas, 'number', false) !== false){
                    $child = (new MyArray())->cloneObj($child);
                    $childs[] = $child;
                }

                $child->additionDatas['sequence_name'] = $sequenceChild;
                $child->additionDatas['number'] = $this->_driverDB->getSequence($sequenceChild)['last_value'];
            }
        }
        $ids->childs = array_merge($ids->childs, $childs);

        $sortBy = Request_RequestParams::getParamArray('sort_by');
        if($sortBy === null){
            $sortBy = array('name' => 'asc',);
        }
        $ids->childsSortBy($sortBy, true, true);

        $result = Helpers_View::getViewObjects(
            $ids, new Model_Ab1_Shop_Sequence(),
            "_shop/sequence/list/index", "_shop/sequence/one/index",
            $this->_sitePageData, $this->_driverDB, 0
        );
        $this->_sitePageData->addReplaceAndGlobalDatas("view::_shop/sequence/list/index", $result);

        $this->_putInMain('/main/_shop/sequence/index');
    }

    public function action_edit()
    {
        $this->_sitePageData->url = '/ab1-admin/shopsequence/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        $model = new Model_Ab1_Shop_Sequence();
        if (! $this->dublicateObjectLanguage($model, $id, -1, false)) {
            throw new HTTP_Exception_404('Sequence not is found!');
        }

        $ids = Request_Request::findOneByID(
            'DB_Ab1_Shop_Sequence', $id, 0, $this->_sitePageData, $this->_driverDB,
            array('shop_id' => array('name'))
        );

        $sequence = Request_RequestParams::getParamStr('sequence');
        if(!empty($sequence)) {
            $ids->additionDatas['number'] = $this->_driverDB->getSequence($sequence)['last_value'];
        }

        Helpers_View::getView(
            "_shop/sequence/one/edit", $this->_sitePageData, $this->_driverDB, $ids
        );

        $this->_putInMain('/main/_shop/sequence/edit');
    }

    public function action_save()
    {
        $this->_sitePageData->url = '/ab1-admin/shopsequence/save';

        $shopID = $this->shopID;
        if($shopID < 1){
            $shopID = $this->_sitePageData->shopID;
        }

        $result = DB_Basic::save($this->dbObject, $shopID, $this->_sitePageData, $this->_driverDB);

        $number = Request_RequestParams::getParamInt('number');
        $numberOld = Request_RequestParams::getParamInt('number_old');
        $sequence = Request_RequestParams::getParamStr('sequence');
        if(!empty($number) && $number != $numberOld && !empty($sequence)){
            $this->_driverDB->setSequence($sequence, $number);
        }

        $this->_redirectSaveResult($result);
    }
}
