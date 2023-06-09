<?php defined('SYSPATH') or die('No direct script access.');

include_once 'response/Response.php';
include_once 'request/Request.php';
include_once 'exception/WooppayException.php';

class Wooppay {

    const ERROR_UNABLE_CONNECTION_TO_SERVICE = 'Unable to connect to the service';
    const ERROR_WRONG_LOGIN_OR_PASSWORD = 'Wrong login or password';

    public function __construct(Options $options = null)
    {
        if ($options != null) {
            $this->connect($options);
        }
    }

    /**
     * Connect to payment system
     * @param Options $options
     * @throws WooppayException
     */
    public function connect(Options $options)
    {
        $url = Reference::URI_API;
        if ($options->isTest()) {
            $url = Reference::URI_API_TEST;
        }

        try {
            $basicAccessAuthenticationParams = [];
            if ($options->getServerLogin() !== null) {
                $basicAccessAuthenticationParams = [
                    'login' => $options->getServerLogin(),
                    'password' => $options->getServerPassword()
                ];
            }

            $this->soap = new SoapClient($url, $basicAccessAuthenticationParams);
        } catch (\Exception $e) {
            throw new WooppayException(self::ERROR_UNABLE_CONNECTION_TO_SERVICE);
        }

        $this->login($options->getLogin(), $options->getPassword());
    }

    /**
     * Response to wooppay service
     * @param bool|true $success -
     */
    public static function response($success = true)
    {
        header('Content-Type: application/json');
        $data = new \stdClass();
        $data->data = 1;
        if (!$success) {
            $data->data = 0;
        }
        exit(json_encode($data));
    }

    /**
     * Login to service
     * @param $login - login in system
     * @param $password - password is sytem
     * @return CoreLoginResponse
     * @throws WooppayException
     */
    public function login($login, $password)
    {
        $request = new CoreLoginRequest(['username' => $login, 'password' => $password]);

        $data = $this->soap->core_login($request);

        if (!empty($data->response->session)) {
            $this->soap->__setCookie('session', $data->response->session);
            $this->sessionData = $data;
            return $data;
        } else {
            throw new WooppayException(self::ERROR_WRONG_LOGIN_OR_PASSWORD);
        }
    }

    /**
     * Logout from service
     * @param CoreLogoutRequest $request
     * @return mixed
     */
    public function logout(CoreLogoutRequest $request)
    {
        return $this->core_logout($request);
    }

    /**
     * Create invoice
     * @param CashCreateInvoiceRequest $request
     * @return CashCreateInvoiceResponse
     */
    public function createInvoice(CashCreateInvoiceRequest $request)
    {
        return $this->soap->cash_createInvoice($request);
    }

    /**
     * Check that operation is paid
     * @param int $operationId
     * @return boolean
     */
    public function isPaid($operationId)
    {
        $request = new CashGetOperationDataRequest(['operationId' => [$operationId]]);
        $data = $this->soap->cash_getOperationData($request);
        if ($data->response->records[0]->status == Reference::OPERATION_STATUS_DONE)
            return true;

        return false;
    }

    /**
     * @param $request
     * @return CoreSmthResponse
     */
    public function core_smth(CoreSmthRequest $request)
    {
        return $this->soap->core_smth($request);
    }

    /**
     * @param CashCreateOperationRequest $request
     * @return CashCreateOperationResponse
     */
    public function cash_createOperation(CashCreateOperationRequest $request)
    {
        return $this->soap->cash_createOperation($request);
    }

    /**
     * @param CashConfirmOperationRequest $request
     * @return CashConfirmOperationResponse
     */
    public function cash_confirmOperation(CashConfirmOperationRequest $request)
    {
        return $this->soap->cash_confirmOperation($request);
    }

    /**
     * @param CashDischargementRequest $request
     * @return CashDischargementResponse
     */
    public function cash_dischargement(CashDischargementRequest $request)
    {
        return $this->soap->cash_dischargement($request);
    }

    /**
     * @param CashTransferRequest $request
     * @return CashTransferResponse
     */
    public function cash_transfer(CashTransferRequest $request)
    {
        return $this->soap->cash_transfer($request);
    }

    /**
     * @param CashGetTransfersRequest $request
     * @return CashGetTransfersResponse
     */
    public function cash_getTransfers(CashGetTransfersRequest $request)
    {
        return $this->soap->cash_getTransfers($request);
    }

    /**
     * @param CashGetCommissionRequest $request
     * @return CashGetCommissionResponse
     */
    public function cash_getCommission(CashGetCommissionRequest $request)
    {
        return $this->soap->cash_getCommission($request);
    }

    /**
     * @param CoreGetServiceIDByNameRequest $request
     * @return CoreGetServiceIDByNameResponse
     */
    public function core_getServiceIDByName(CoreGetServiceIDByNameRequest $request)
    {
        return $this->soap->core_getServiceIDByName($request);
    }

    /**
     * Get account balance
     * @return CashGetBalanceResponse
     */
    public function cash_getBalance()
    {
        return $this->soap->cash_getBalance();
    }

    /**
     * @param ServiceGetCategoriesRequest $request
     * @return ServiceGetCategoriesResponse
     */
    public function service_getCategories( $request)
    {
        return $this->soap->service_getCategories($request);
    }

    /**
     * @param CashDeclineRequest $request
     * @return CashDeclineResponse
     */
    public function cash_decline(CashDeclineRequest $request)
    {
        return $this->soap->cash_decline($request);
    }

    /**
     * @param CashSetOperationsStatusRequest $request
     * @return CashSetOperationsStatusResponse
     */
    public function cash_setOperationsStatus(CashSetOperationsStatusRequest $request)
    {
        return $this->soap->cash_setOperationsStatus($request);
    }

    /**
     * @param CashGetOperationsStatusRequest $request
     * @return CashGetOperationsStatusResponse
     */
    public function cash_getOperationsStatus(CashGetOperationsStatusRequest $request)
    {
        return $this->soap->cash_getOperationsStatus($request);
    }

    /**
     * @param CashCashOutRequest $request
     * @return CashCashOutResponse
     */
    public function cash_cashOut(CashCashOutRequest $request)
    {
        return $this->soap->cash_cashOut($request);
    }

    /**
     * @param CashCashOutCompleteRequest $request
     * @return CashCashOutCompleteResponse
     */
    public function cash_cashOutComplete(CashCashOutCompleteRequest $request)
    {
        return $this->soap->cash_cashOutComplete($request);
    }

    /**
     * @param CashReturnRequest $request
     * @return CashReturnResponse
     */
    public function cash_paymentReturn(CashReturnRequest $request)
    {
        return $this->soap->cash_paymentReturn($request);
    }

    /**
     * @param CoreUserSearchRequest $request
     * @return CoreUserSearchResponse
     */
    public function core_userSearch(CoreUserSearchRequest $request)
    {
        return $this->soap->core_userSearch($request);
    }

    /**
     * @param SystemGetConfigRequest $request
     * @return SystemGetConfigResponse
     */
    public function system_getConfig(SystemGetConfigRequest $request)
    {
        return $this->soap->system_getConfig($request);
    }

    /**
     * @param CashRequestTransferRequest $request
     * @return CashRequestTransferResponse
     */
    public function cash_requestTransfer(CashRequestTransferRequest $request)
    {
        return $this->soap->cash_requestTransfer($request);
    }

    /**
     * @param CashInvoicingRequest $request
     * @return CashInvoicingResponse
     */
    public function cash_invoicing(CashInvoicingRequest $request)
    {
        return $this->soap->cash_invoicing($request);
    }

    /**
     * @param CashGetServiceFieldsRequest $request
     * @return CashGetServiceFieldsResponse
     */
    public function cash_getServiceFields(CashGetServiceFieldsRequest $request)
    {
        return $this->soap->cash_getServiceFields($request);
    }

    /**
     * @param CashCheckServiceFieldsRequest $request
     * @return CashCheckServiceFieldsResponse
     */
    public function cash_checkServiceFields(CashCheckServiceFieldsRequest $request)
    {
        return $this->soap->cash_checkServiceFields($request);
    }

    /**
     * @param CashGetOperationReceiptRequest $request
     * @return CashGetOperationReceiptResponse
     */
    public function cash_getOperationReceipt(CashGetOperationReceiptRequest $request)
    {
        return $this->soap->cash_getOperationReceipt($request);
    }

    /**
     * Get operation information
     * @param CashGetOperationDataRequest $request
     * @return CashGetOperationDataResponse
     */
    public function cash_getOperationData(CashGetOperationDataRequest $request)
    {
        return $this->soap->cash_getOperationData($request);
    }

    /**
     * @param CoreUserExistsRequest $request
     * @return CoreUserExistsResponse
     */
    public function core_userExists(CoreUserExistsRequest $request)
    {
        return $this->soap->core_userExists($request);
    }

    /**
     * Create invoice
     * @param CashCreateInvoiceRequest $request
     * @return CashCreateInvoiceResponse
     */
    public function cash_createInvoice(CashCreateInvoiceRequest $request)
    {
        return $this->soap->cash_createInvoice($request);
    }

    /**
     * Create invoice with extended parameters
     * @param CashCreateInvoiceExtendedRequest $request
     * @return CashCreateInvoiceResponse
     */
    public function cash_createInvoiceExtended(CashCreateInvoiceExtendedRequest $request)
    {
        return $this->soap->cash_createInvoiceExtended($request);
    }

    /**
     * @param CashCreateInvoiceExtended2Request $request
     * @return CashCreateInvoiceResponse
     */
    public function cash_createInvoice2Extended(CashCreateInvoiceExtended2Request $request)
    {
        return $this->soap->cash_createInvoice2Extended($request);
    }

    /**
     * @param CashPrepaidCardPerformRequest $request
     * @return CashPrepaidCardPerformResponse
     */
    public function cash_prepaidCardPerform(CashPrepaidCardPerformRequest $request)
    {
        return $this->soap->cash_prepaidCardPerform($request);
    }

    /**
     * @param CashPrepaidCardRequest $request
     * @return CashPrepaidCardResponse
     */
    public function cash_prepaidCard(CashPrepaidCardRequest $request)
    {
        return $this->soap->cash_prepaidCard($request);
    }

    /**
     * @param CashPrepaidCardCommissionRequest $request
     * @return CashPrepaidCardCommissionResponse
     */
    public function cash_prepaidCardCommission(CashPrepaidCardCommissionRequest $request)
    {
        return $this->soap->cash_prepaidCardCommission($request);
    }

    /**
     * @param CreateOperationRequest $request
     * @return CreateOperationResponse
     */
    public function createOperation(CreateOperationRequest $request)
    {
        return $this->soap->createOperation($request);
    }

    /**
     * @param CreateOperationRequest $request
     * @return CreateOperationResponse
     */
    public function createOperationFake(CreateOperationRequest $request)
    {
        return $this->soap->createOperationFake($request);
    }

    /**
     * @param PayConfirmRequest $request
     * @return CreateOperationResponse
     */
    public function payConfirm(PayConfirmRequest $request)
    {
        return $this->soap->payConfirm($request);
    }

    /**
     * @param PayTransferConfirmRequest $request
     * @return CreateOperationResponse
     */
    public function payTransferConfirm(PayTransferConfirmRequest $request)
    {
        return $this->soap->payTransferConfirm($request);
    }

    /**
     * Call method from SOAP
     * @param $name
     * @param $arguments
     * @return BaseResponse
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->soap, $name], $arguments);
    }

    /**
     * Get current session data
     * @return CoreLoginResponseData
     */
    public function getSessionData()
    {
        return $this->sessionData;
    }

    private $soap;
    /**
     * @var CoreLoginResponseData
     */
    protected $sessionData;
}