<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Client_Memcache extends Controller_BasicControler {
    public function action_mem(){
        $m = new Memcached();
        $m->addServer('localhost', 11211);
        /* Очищает все записи через 10 секунд */
        $m->flush();
    }

    /**
     * Карта сайта для поисковых машин
     */
    public function action_sitemap(){
        $this->_sitePageData->url = '/sitemap.xml';
        $this->_sitePageData->urlCanonical = $this->_sitePageData->url;
        $this->_sitePageData->isIndexRobots = TRUE;

        $this->response->body(
            View_SitePage::loadSitePage($this->_sitePageData->shopID,
                '/main/sitemap', $this->_sitePageData, $this->_driverDB));
    }
}