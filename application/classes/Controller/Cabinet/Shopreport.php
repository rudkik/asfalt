<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cabinet_ShopReport extends Controller {

	public function action_index() {
        $class = 'Shop'.Func::mb_ucfirst(mb_strtolower($this->request->param('type')));
        if(!file_exists(APPPATH.'classes'.DIRECTORY_SEPARATOR.'Controller'.DIRECTORY_SEPARATOR.'Cabinet'.DIRECTORY_SEPARATOR.'Report'.DIRECTORY_SEPARATOR.$class.'.php')){
            throw new HTTP_Exception_404('Type not found.');
        }
        $class = 'Controller_Cabinet_Report_'.$class;
        $class = new $class($this->request, $this->response);

        $function = 'action_'.mb_strtolower($this->request->param('report'));
        if(!method_exists($class, $function)){
            throw new HTTP_Exception_404('Method not found.');
        }
        $class->before();
        $class->$function();
        $class->after();
	}
}
