<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Client_Favorite extends Controller_Client_BasicClient {
    /**
     * Добавляем товар
     */
	public function action_add_good(){
		$this->_sitePageData->url = '/favorite/add_good';

		Api_Favorite::addGood(
            Request_RequestParams::getParamInt('id'),
			Request_RequestParams::getParamInt('child_id'),
            $this->_sitePageData
        );

        $this->_returnFavorite();
	}

    /**
     * Удаляем товар
     */
    public function action_del_good(){
        $this->_sitePageData->url = '/favorite/del_good';

        Api_Favorite::delGood(
            Request_RequestParams::getParamInt('id'),
            Request_RequestParams::getParamInt('child_id'),
            $this->_sitePageData
        );

        $this->_returnFavorite();
    }

    /**
     * Очищаем корзину магазина
     */
    public function action_clear(){
        $this->_sitePageData->url = '/favorite/clear';

        Api_Favorite::clear($this->_sitePageData);

        $this->_returnFavorite();
    }

    /**
     * Отвечаем на запрос
     * @return bool
     * @throws HTTP_Exception_404
     */
    private function _returnFavorite(){
        if (!Request_RequestParams::getParamBoolean('is_result')) {
            $this->response->body(
                json_encode(
                    array(
                        'error' => FALSE,
                    )
                )
            );
            return TRUE;
        }

        // проводим редирект или получаем данные, если задана ссылка
        $url = Request_RequestParams::getParamStr('url');
        if (!empty($url)) {
            if (Request_RequestParams::getParamBoolean('is_redirect')) {
                $this->redirect($url);
                return TRUE;
            }

            // получаем данные по ссылки, имметируем запрос ссылки
            if($url[0] != '/') {
                $this->_sitePageData->url = '/' . $url;
            }
            $this->response->body(
                View_SitePage::loadSitePage(
                    $this->_sitePageData->shopID, '', $this->_sitePageData, $this->_driverDB, FALSE
                )
            );
            return TRUE;
        }

        // Получаем список товаров в избранном
        $shopGoods = Api_Favorite::getShopGoods($this->_sitePageData);

        $this->response->body(
            json_encode(
                array(
                    'error' => FALSE,
                    'count' => count($shopGoods->childs),
                )
            )
        );
        return TRUE;
    }
}