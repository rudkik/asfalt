<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopRedirect extends Controller_Cabinet_BasicCabinet
{
    public function __construct(Request $request, Response $response)
    {
        $this->controllerName = 'shopredirect';
        $this->objectName = 'redirect';

        parent::__construct($request, $response);
        $this->_sitePageData->controllerName = $this->controllerName;
    }

    public function action_index()
    {
        $this->_sitePageData->url = '/cabinet/shopredirect/index';

        // задаем данные, которые будут меняться
        $this->_setGlobalDatas(
            array(
                'view::options/shop/redirect/list/index',
            )
        );

        // получаем шаблон магазина
        $modelSiteShablon = new Model_SiteShablon();
        $modelSiteShablon->setDBDriver($this->_driverDB);
        if (!$this->getDBObject($modelSiteShablon, $this->_sitePageData->shop->getSiteShablonID())) {
            throw new HTTP_Exception_500('Site template not found.');
        }

        $file = APPPATH . 'views' . DIRECTORY_SEPARATOR . $modelSiteShablon->getShablonPath() . DIRECTORY_SEPARATOR . 'redirects' . DIRECTORY_SEPARATOR . $this->_sitePageData->dataLanguageID . '.php';
        if (file_exists($file)) {
            $redirects = include($file);
        } else {
            $redirects = array();
        }

        $data = new MyArray();
        $i = 0;
        foreach ($redirects as $key => $value) {
            $obj = $data->addChild($i);
            $obj->values = array(
                'old' => $key,
                'new' => $value,
            );
            $obj->values['id'] = $i;
            $obj->isFindDB = TRUE;
            $i++;
        }

        $datas = Helpers_View::getViewObjects($data, new Model_Basic_LanguageObject(array(), '', 0),
            "options/shop/redirect/list/index", "options/shop/redirect/one/index", $this->_sitePageData, $this->_driverDB,
            $this->_sitePageData->shopID);
        $this->_sitePageData->replaceDatas['view::options/shop/redirect/list/index'] = $datas;

        $this->_putInMain('/main/options/shop/redirect/index');
    }


    /**
     * изменение статьи
     */
    public function action_save()
    {
        $this->_sitePageData->url = '/cabinet/shopredirect/save';

        // получаем шаблон магазина
        $modelSiteShablon = new Model_SiteShablon();
        $modelSiteShablon->setDBDriver($this->_driverDB);
        if (!$this->getDBObject($modelSiteShablon, $this->_sitePageData->shop->getSiteShablonID())) {
            throw new HTTP_Exception_500('Site template not found.');
        }

        $redirects = array();
        $arr = Request_RequestParams::getParamArray('redirects');
        if ($arr !== NULL) {

            foreach ($arr as $value) {
                $new = trim(Arr::path($value, 'new', ''));
                if (!empty($new)) {
                    $old = trim(Arr::path($value, 'old', ''));
                    if (!empty($old)) {
                        $redirects[$old] =  $new;
                    }
                }
            }

            $redirects = '<?php defined(\'SYSPATH\') or die(\'No direct script access.\');'."\r\n".'return ' . Helpers_Array::arrayToStrPHP($redirects).';';

            $filePath = APPPATH . 'views' . DIRECTORY_SEPARATOR . $modelSiteShablon->getShablonPath() . DIRECTORY_SEPARATOR . 'redirects' . DIRECTORY_SEPARATOR;
            if (Helpers_Path::createPath($filePath)) {
                $filePath = $filePath . $this->_sitePageData->dataLanguageID . '.php';

                $file = fopen($filePath, 'w');
                fwrite($file, $redirects);
                fclose($file);
                chmod($filePath, 0777);
            }
        }

        $branchID = '';
        if ($this->_sitePageData->branchID > 0) {
            $branchID = '&shop_branch_id=' . $this->_sitePageData->branchID;
        }
        $this->redirect('/cabinet/shopredirect/index?' . $branchID);
    }
}
