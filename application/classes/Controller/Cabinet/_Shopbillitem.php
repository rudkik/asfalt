<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopBillItem extends Controller_Cabinet_BasicCabinet {

	public function action_index()
	{
		$this->_sitePageData->url = '/cabinet/shopbillitem/index';

		// задаем данные, которые будут меняться
		$this->_setGlobalDatas(
			array(
				'view::shopbillitems/index',
			)
		);

		// получаем список заказов
        View_View::find('DB_ShopBillItem', $this->_sitePageData->shopID, "shopbillitems/index", "shopbillitem/index",
			$this->_sitePageData, $this->_driverDB, array('shop_bill_id' => Request_RequestParams::getParamInt('bill_id')),
			array('shop_good_id', 'shop_table_catalog_id'));

		$this->_putInMain('/main/shopbillitem/index');
	}

	public function action_new(){
		$this->_sitePageData->url = '/cabinet/shopbillitem/new';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::shopbillitem/new',
            )
        );

		$dataID = new MyArray();
		$dataID->id = 0;
		$dataID->isFindDB = TRUE;

		$model = new Model_Shop_Bill_Item();
		$datas = Helpers_View::getViewObject($dataID, $model,
			'shopbillitem/new', $this->_sitePageData, $this->_driverDB);
        $this->_sitePageData->replaceDatas['view::shopbillitem/new'] = $datas;

		$this->_putInMain('/main/shopbillitem/new');
	}

	public function action_edit()
	{
		$this->_sitePageData->url = '/cabinet/shopbillitem/edit';

        // id записи
        $id = Request_RequestParams::getParamInt('id');
        if ($id === NULL) {
            throw new HTTP_Exception_404('Bill item not is found!');
        }else {
            $model = new Model_Shop_Bill_Item();
            if (!$this->getDBObject($model, $id)) {
                throw new HTTP_Exception_404('Bill item not is found!');
            }
        }

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::shopbillitem/edit',
            )
        );

		// получаем данные
		$data = View_View::findOne('DB_ShopBillItem', $this->_sitePageData->shopID, "shopbillitem/edit",
			$this->_sitePageData, $this->_driverDB, array('id' => $id));

		$this->_putInMain('/main/shopbillitem/edit');
	}

	/**
	 * Удаление
	 */
	public function action_del()
    {
        $this->_sitePageData->url = '/cabinet/shopbillitem/del';

        $id = Request_RequestParams::getParamInt('id');

        $model = new Model_Shop_Bill_Item();
        if (!$this->getDBObject($model, $id)) {
            throw new HTTP_Exception_404('Bill Item not is found!');
        }

        // удаляем запись из базы данных
      //  $result = $this->_dbDeleteRecord($id,
      //      $model);

        Helpers_Cart::countUpBill($this->_sitePageData->shopID, $model->getShopBillID(),
            $this->_sitePageData, $this->_driverDB);

        $url = Request_RequestParams::getParamStr('url');
        if (empty($url)) {
            $this->response->body(Json::json_encode($result));
        } else {
            $this->redirect($url . URL::query(
                    array(
                        'is_main' => 1,
                        'shop_id' => $this->_sitePageData->shopID,
                        'id' => $model->getShopBillID(),
                    ),
                    FALSE
                )
            );
        }

        $this->response->body(Json::json_encode($result));
    }

	/**
	 * Изменение
	 */
	public function action_save(){
		$this->_sitePageData->url = '/cabinet/shopbillitem/save';

		$model = new Model_Shop_Bill_Item();

		$id = Request_RequestParams::getParamInt('id');
        if($id === NULL){
            throw new HTTP_Exception_500('Bill Item not found.');
        }

		if (! $this->dublicateObjectLanguage($model, $id)) {
			throw new HTTP_Exception_500('Bill Item not found.');
		}

		Request_RequestParams::setParamInt('count', $model);

		$result = array();
		if ($model->validationFields($result)){
			$model->setEditUserID($this->_sitePageData->userID);
			$this->saveDBObject($model);

			$filePath = Request_RequestParams::getParamStr('image');
			if (!empty($filePath)) {
				$file = new Model_File($this->_sitePageData);
				$tmp = $file->saveImage($filePath, $model->id, Model_Shop_New::TABLE_ID, $this->_sitePageData);
				if (!empty($tmp)) {
					$model->setFileImage($tmp);
					$this->saveDBObject($model);

					$result['values'] = $model->getValues();
				}
			}

			$result['values'] = $model->getValues();
		}

        Helpers_Cart::countUpBill($this->_sitePageData->shopID, $model->getShopBillID(),
            $this->_sitePageData, $this->_driverDB);

        $url = Request_RequestParams::getParamStr('url');
        if ((empty($url)) || Request_RequestParams::getParamBoolean('json') || $result['error']) {
            $this->response->body(Json::json_encode($result));
        } else {
            $this->redirect($url . URL::query(
                    array(
                        'is_main' => 1,
                        'shop_id' => $this->_sitePageData->shopID,
                        'id' => $model->getShopBillID(),
                    ),
                    FALSE
                )
            );
        }
	}
}
