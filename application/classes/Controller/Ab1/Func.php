<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Func extends Controller
{
    /**
     * Разница в датах в часах
     */
    public function action_diff_hours() {
        //$this->_sitePageData->url = '/ab1/func/diff_hours';

        $dateFrom = Request_RequestParams::getParamDateTime('date_from');
        $dateTo = Request_RequestParams::getParamDateTime('date_to');

        if(empty($dateFrom) || empty($dateTo)){
            $this->response->body(0);
            return;
        }

        $isDinner = Request_RequestParams::getParamBoolean('is_dinner');

        if($isDinner){
            $dinnerFrom = date('Y-m-d 12:00:00');
            $dinnerTo = date('Y-m-d 13:00:00');
            if(strtotime($dateFrom) >= strtotime($dinnerTo)){
                $result = Helpers_DateTime::diffHours($dateTo, $dateFrom);
            }elseif(strtotime($dateFrom) >= strtotime($dinnerFrom)){
                $result = Helpers_DateTime::diffHours($dateTo, $dinnerTo);
            }elseif(strtotime($dateTo) <= strtotime($dinnerFrom)){
                $result = Helpers_DateTime::diffHours($dateTo, $dateFrom);
            }elseif(strtotime($dinnerTo) >= strtotime($dateTo)){
                $result = Helpers_DateTime::diffHours($dinnerFrom, $dateFrom);
            }else{
                $result = Helpers_DateTime::diffHours($dinnerFrom, $dateFrom)
                            + Helpers_DateTime::diffHours($dateTo, $dinnerTo);
            }
        }else{
            $result = Helpers_DateTime::diffHours($dateTo, $dateFrom);
        }

        $this->response->body(ceil($result));
    }

}