<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Magazine_Social_ShopRealizationItem extends Controller_Magazine_Social_BasicMagazine{

    public function action_statistics()
    {
        $this->_sitePageData->url = '/social/shoprealizationitem/statistics';

        if(Request_RequestParams::getParamInt('is_special') == Model_Magazine_Shop_Realization::SPECIAL_TYPE_WRITE_OFF){
            $this->_actionShopRealizationItemWriteOffStatistics();
        }else {
            $this->_actionShopRealizationItemStatistics();
        }
    }
}
