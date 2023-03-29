<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ab1_Aura3 extends Controller
{
    /**
     * Получаем данные из запроса
     * @return bool
     */
    private function _getData()
    {
        if (key_exists('data', $_POST)) {
            $data = $_POST['data'];
        } elseif (key_exists('data', $_GET)) {
            $data = $_GET['data'];
        } else {
            $result = array(
                'status' => FALSE,
                'number' => '',
                'error' => 'Data request empty.',
            );
            $this->response->body(Json::json_encode($result));
            return false;
        }

        return $data;
    }

    /**
     * Печать чеков на локальном компьютере
     */
    public function action_print_fiscal_check() {
        $data = $this->_getData();
        if($data === false){
            return;
        }

        try {
            $number = Drivers_CashRegister_LocalComputerAura3::printFiscalCheck($data);
            $result = array(
                'status' => TRUE,
                'number' => $number,
                'error_code' => 0,
            );
        }catch (Drivers_CashRegister_Exception $e){
            $result = array(
                'status' => FALSE,
                'number' => '',
                'error_code' => $e->getErrorCode(),
                'command' => $e->getCommand(),
                'error' => $e->getMessage(),
            );
        }catch (HTTP_Exception_500 $e){
            $result = array(
                'status' => FALSE,
                'number' => '',
                'error' => $e->getMessage(),
            );
        }catch (Exception $e){
            $result = array(
                'status' => FALSE,
                'number' => '',
                'error' => $e->getMessage(),
            );
        }

        $this->response->body(json_encode($result));
    }

    /**
     * Печать возвратных чеков на локальном компьютере
     */
    public function action_print_return_fiscal_check() {
        $data = $this->_getData();
        if($data === false){
            return;
        }

        try {
            $number = Drivers_CashRegister_LocalComputerAura3::printReturnFiscalCheck($data);
            $result = array(
                'status' => TRUE,
                'number' => $number,
                'error_code' => 0,
            );
        }catch (Drivers_CashRegister_Exception $e){
            $result = array(
                'status' => FALSE,
                'number' => '',
                'error_code' => $e->getErrorCode(),
                'command' => $e->getCommand(),
                'error' => $e->getMessage(),
            );
        }catch (HTTP_Exception_500 $e){
            $result = array(
                'status' => FALSE,
                'number' => '',
                'error' => $e->getMessage(),
            );
        }catch (Exception $e){
            $result = array(
                'status' => FALSE,
                'number' => '',
                'error' => $e->getMessage(),
            );
        }

        $this->response->body(json_encode($result));
    }

    /**
     * Печать отчетов на локальном компьютере
     */
    public function action_print_report() {
        $data = $this->_getData();
        if($data === false){
            return;
        }

        try {
            Drivers_CashRegister_LocalComputerAura3::printReport($data);

            $result = array(
                'status' => TRUE,
                'error_code' => 0,
            );
        }catch (Drivers_CashRegister_Exception $e){
            $result = array(
                'status' => FALSE,
                'number' => '',
                'error_code' => $e->getErrorCode(),
                'command' => $e->getCommand(),
                'error' => $e->getMessage(),
            );
        }catch (HTTP_Exception_500 $e){
            $result = array(
                'status' => FALSE,
                'number' => '',
                'error' => $e->getMessage(),
            );
        }catch (Exception $e){
            $result = array(
                'status' => FALSE,
                'number' => '',
                'error' => $e->getMessage(),
            );
        }

        $this->response->body(json_encode($result));
    }

    /**
     * Открытие смены
     */
    public function action_open_shift() {
        try {
            Drivers_CashRegister_LocalComputerAura3::openShift();

            $result = array(
                'status' => TRUE,
                'error_code' => 0,
            );
        }catch (Drivers_CashRegister_Exception $e){
            $result = array(
                'status' => FALSE,
                'number' => '',
                'error_code' => $e->getErrorCode(),
                'command' => $e->getCommand(),
                'error' => $e->getMessage(),
            );
        }catch (HTTP_Exception_500 $e){
            $result = array(
                'status' => FALSE,
                'number' => '',
                'error' => $e->getMessage(),
            );
        }catch (Exception $e){
            $result = array(
                'status' => FALSE,
                'number' => '',
                'error' => $e->getMessage(),
            );
        }

        $this->response->body(json_encode($result));
    }

    /**
     * Закрытие смены
     */
    public function action_close_shift() {
        try {
            Drivers_CashRegister_LocalComputerAura3::closeShift();

            $result = array(
                'status' => TRUE,
                'error_code' => 0,
            );
        }catch (Drivers_CashRegister_Exception $e){
            $result = array(
                'status' => FALSE,
                'number' => '',
                'error_code' => $e->getErrorCode(),
                'command' => $e->getCommand(),
                'error' => $e->getMessage(),
            );
        }catch (HTTP_Exception_500 $e){
            $result = array(
                'status' => FALSE,
                'number' => '',
                'error' => $e->getMessage(),
            );
        }catch (Exception $e){
            $result = array(
                'status' => FALSE,
                'number' => '',
                'error' => $e->getMessage(),
            );
        }

        $this->response->body(json_encode($result));
    }

    /**
     * Статус кассового аппарата
     */
    public function action_status() {
        try {
            $result = Drivers_CashRegister_LocalComputerAura3::status();
            print_r($result);die;
        }catch (Drivers_CashRegister_Exception $e){
            $result = array(
                'number' => '',
                'error_code' => $e->getErrorCode(),
                'command' => $e->getCommand(),
                'error' => $e->getMessage(),
            );
        }catch (HTTP_Exception_500 $e){
            $result = array(
                'number' => '',
                'error' => $e->getMessage(),
            );
        }catch (Exception $e){
            $result = array(
                'number' => '',
                'error' => $e->getMessage(),
            );
        }

        $this->response->body(json_encode($result));
    }
}