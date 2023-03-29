<?php defined('SYSPATH') or die('No direct script access.');

class BaseRequest
{
    public function __construct(array $data = [])
    {
        /**
         * Set data to object
         */
        if (!empty($data)) {
            foreach ($data as $property => $value) {
                if (property_exists($this, $property)) {
                    $this->{$property} = $value;
                }
            }
        }
    }
}
class CashCashOutCompleteRequest extends BaseRequest
{
    /**
     * @var int $operationID
     */
    public $operationID;
}
class CashCashOutRequest extends BaseRequest
{
    /**
     * @var float $amount
     */
    public $amount;
    /**
     * @var string $returnURL
     */
    public $returnURL;
    /**
     * @var string $postLink
     */
    public $postLink;
    /**
     * @var string $extID
     */
    public $extID;
    /**
     * @var string $phone
     */
    public $phone;
    /**
     * @var string $addParams
     */
    public $addParams;
}
class CashCheckServiceFieldsRequest extends BaseRequest
{
    /**
     * @var string $service
     */
    public $service;

    /**
     * @var string $merchant
     */
    public $merchant;

    /**
     * @var int $serviceId
     */
    public $serviceId;

    /**
     * @var string $fields
     */
    public $fields;
}
class CashConfirmOperationRequest extends BaseRequest
{
    /**
     * @var int $operationId
     */
    public $operationId;
    /**
     * @var int $type
     */
    public $type;
}
class CashCreateInvoiceExtended2Request extends CashCreateInvoiceExtendedRequest
{
    /**
     * @var int $cardForbidden
     */
    public $cardForbidden;
}
class CashCreateInvoiceExtendedRequest extends CashCreateInvoiceRequest
{
    /**
     * E-mail client (will be displayed in the form of payment in the payment card)
     * @var string $userEmail
     */
    public $userEmail;

    /**
     * Phone client (will be displayed in the form of payment in the payment card)
     * @var string $userPhone
     */
    public $userPhone;
}
class CashCreateInvoiceRequest extends BaseRequest {
    /**
     * Order ID on the side of the merchant
     * @var int $referenceId
     * @soap
     */
    public $referenceId;
    /**
     * The address to which the user will be redirected after payment
     * @var string $backUrl
     * @soap
     */
    public $backUrl;
    /**
     * A request that we send to you after successful payment
     * @var string $requestUrl
     * @soap
     */
    public $requestUrl = '';
    /**
     * Line - that sees the client in the form of payment
     * @var string $addInfo
     * @soap
     */
    public $addInfo;
    /**
     * The amount of the invoice. Data Type - a real unsigned number with a separator-point (you can transfer integers)
     * @var float $amount
     * @soap
     */
    public $amount;
    /**
     * The time when the operation becomes invalid. Data Type - a string with the date (YYYY-MM-DD HH: MM: SS)
     * @var string $deathDate
     * @soap
     */
    public $deathDate;
    /**
     * The type of service (not used)
     * @var $int $serviceType
     * @soap
     */
    public $serviceType = null;
    /**
     * Short mandatory comment that enters into the history of customer transactions
     * @var string $description
     * @soap
     */
    public $description = '';
    /**
     * Order ID. Data type - unsigned integer (not used)
     * @var int $orderNumber
     * @soap
     */
    public $orderNumber = null;
}
class CashCreateOperationRequest extends BaseRequest {
    /**
     * @var int $type
     */
    public $type;
    /**
     * @var string $receiver
     */
    public $receiver;
    /**
     * @var float $amount
     */
    public $amount;
    /**
     * @var string $description
     */
    public $description;
    /**
     * @var int $productId
     */
    public $productId;
    /**
     * @var string $service
     */
    public $service;
    /**
     * @var string $fields
     */
    public $fields;
    /**
     * @var int $userGroup
     */
    public $userGroup;
}
class CashDeclineRequest extends BaseRequest
{
    /**
     * @var int $operationId
     */
    public $operationId;
}
class CashDischargementRequest  extends BaseRequest
{
    /**
     * @var string $subjectFrom
     */
    public $subjectFrom;
    /**
     * @var int $accountFrom
     */
    public $accountFrom;

    /**
     * @var float $amount
     */
    public $amount;
}
class CashGetCommissionRequest extends BaseRequest
{
    /**
     * @var int $serviceId
     */
    public $serviceId;

    /**
     * @var int $amount
     */
    public $amount;
}
class CashGetOperationDataRequest extends BaseRequest {
    /**
     * Id array operations
     * @var int[] $operationId
     * @soap
     */
    public $operationId;
}
class CashGetOperationReceiptRequest extends BaseRequest
{
    /**
     * @var int $operationId
     */
    public $operationId;
}
class CashGetOperationsStatusRequest extends BaseRequest
{
    /**
     * @var string $ext_id
     */
    public $ext_id;

    /**
     * @var int $status
     */
    public $status;

    /**
     * @var string $dateFrom
     */
    public $dateFrom;

    /**
     * @var string $dateTo
     */
    public $dateTo;
}
class CashGetServiceFieldsRequest extends BaseRequest
{
    /**
     * @var string $service
     */
    public $service;

    /**
     * @var string $merchant
     */
    public $merchant;

    /**
     * @var string $fields
     */
    public $fields;
}
class CashGetTransfersRequest  extends BaseRequest
{
    /**
     * @var int $page
     */
    public $page;

    /**
     * @var int $perPage
     */
    public $perPage;

    /**
     * @var int[] $statuses
     */
    public $statuses;

    /**
     * @var int[] $types
     */
    public $types;

    /**
     * @var int $direction
     */
    public $direction;

    /**
     * @var boolean $reverse
     */
    public $reverse;

    /**
     * @var string $secondSubject
     */
    public $secondSubject;

    /**
     * @var string $dateFrom
     */
    public $dateFrom;

    /**
     * @var string $dateTo
     */
    public $dateTo;

    /**
     * @var int $lastChanged
     */
    public $lastChanged;
}
class CashInvoicingRequest extends BaseRequest
{
    /**
     * @var string $subjectFrom
     */
    public $subjectFrom;

    /**
     * @var int $amount
     */
    public $amount;

    /**
     * @var int $lifetime
     */
    public $lifetime;

    /**
     * @var int $service_type
     */
    public $service_type;

    /**
     * @var int $device_type
     */
    public $device_type;

    /**
     * @var string $description
     */
    public $description;

    /**
     * @var string $order_nr
     */
    public $order_nr;
}
class CashPrepaidCardCommissionRequest extends BaseRequest
{
    /**
     * @var int $amount
     */
    public $amount;
}
class CashPrepaidCardPerformRequest extends BaseRequest
{
    /**
     * @var int $operationId
     */
    public $operationId;

    /**
     * @var string $protectionCode
     */
    public $protectionCode;
}
class CashPrepaidCardRequest extends BaseRequest
{
    /**
     * @var float $amount
     */
    public $amount;
    /**
     * @var string $login
     */
    public $login;
    /**
     * @var CashPrepaidCardRequestData $billingInfo
     */
    public $billingInfo;
}
class CashPrepaidCardRequestData extends BaseRequest
{
    /**
     * @var string $name
     */
    public $name;
    /**
     * @var string $dateOfBirth
     */
    public $dateOfBirth;
    /**
     * @var string $documentNumber
     */
    public $documentNumber;
    /**
     * @var int $documentType
     */
    public $documentType;
    /**
     * @var string $dateOfIssue
     */
    public $dateOfIssue;
    /**
     * @var string $validity
     */
    public $validity;
    /**
     * @var string $personalNumber
     */
    public $personalNumber;
}
class CashRequestTransferRequest extends BaseRequest
{
    /**
     * @var string $login
     */
    public $login;
    /**
     * @var int $amount
     */
    public $amount;
    /**
     * @var string $description
     */
    public $description;
}
class CashReturnRequest extends BaseRequest
{
    /**
     * @var int $operationId
     */
    public $operationId;
}
class CashSetOperationsStatusRequest extends BaseRequest
{
    /**
     * @var CashSetOperationsStatusRequestRecord[] $records
     */
    public $records;
}
class CashSetOperationsStatusRequestRecord extends BaseRequest
{
    /**
     * @var string $ext_id
     */
    public $ext_id;

    /**
     * @var string $description
     */
    public $description;

    /**
     * @var int $status
     */
    public $status;

    /**
     * @var string $date
     */
    public $date;
}
class CashTransferRequest extends BaseRequest
{
    /**
     * @var int $operationId
     */
    public $operationId;
}
class CoreGetServiceIDByNameRequest extends BaseRequest
{
    /**
     * @var string $service_name
     */
    public $service_name;
}
class CoreLoginRequest extends BaseRequest {
    /**
     * Login in wooppay system
     * @var string $username
     * @soap
     */
    public $username;
    /**
     * Passowrd in wooppay service
     * @var string $password
     * @soap
     */
    public $password;
    /**
     * @var string $captcha
     * @soap
     */
    public $captcha = null;
}
class CoreLogoutRequest  extends BaseRequest
{

}
class CoreSmthRequest  extends BaseRequest
{

}
class CoreUserExistsRequest extends BaseRequest
{
    /**
     * @var string $login
     */
    public $login;

    /**
     * @var int $userGroup
     */
    public $userGroup;
}
class CoreUserSearchRequest extends BaseRequest
{
    /**
     * @var string $login
     */
    public $login;
}
class CreateOperationRequest extends BaseRequest
{
    /**
     * @var string $Login
     */
    public $Login;
    /**
     * @var string $Password
     */
    public $Password;
    /**
     * @var string $KNO
     */
    public $KNO;
    /**
     * @var string $Beneficiary
     */
    public $Beneficiary;
    /**
     * @var string $Beneficiary_Ru
     */
    public $Beneficiary_Ru;
    /**
     * @var string $BankBeneficiary
     */
    public $BankBeneficiary;
    /**
     * @var string $BankBeneficiary_Ru
     */
    public $BankBeneficiary_Ru;
    /**
     * @var string $OrderDate
     */
    public $OrderDate;
    /**
     * @var string $PayCode
     */
    public $PayCode;
    /**
     * @var string $KBK
     */
    public $KBK;
    /**
     * @var string $KBK_Ru
     */
    public $KBK_Ru;
    /**
     * @var string $KNP
     */
    public $KNP;
    /**
     * @var string $KNP_Ru
     */
    public $KNP_Ru;
    /**
     * @var float $Price
     */
    public $Price;
    /**
     * @var string $LastName
     */
    public $LastName;
    /**
     * @var string $FirstName
     */
    public $FirstName;
    /**
     * @var string $MiddleName
     */
    public $MiddleName;
    /**
     * @var string $IIN
     */
    public $IIN;
    /**
     * @var string $Currency
     */
    public $Currency;
    /**
     * @var string $MerchantID
     */
    public $MerchantID;
    /**
     * @var string $BackURL
     */
    public $BackURL;
}
class PayConfirmRequest extends BaseRequest
{
    /**
     * @var string $PayCode
     */
    public $PayCode;
    /**
     * @var string $OperatorName
     */
    public $OperatorName;
    /**
     * @var string $OperatorCallCenter
     */
    public $OperatorCallCenter;
    /**
     * @var string $OperatorPayDate
     */
    public $OperatorPayDate;
    /**
     * @var string $NumberWallet
     */
    public $NumberWallet;
    /**
     * @var string $OperatorNumberTransaction
     */
    public $OperatorNumberTransaction;
    /**
     * @var float $Amount
     */
    public $Amount;
    /**
     * @var string $IIN
     */
    public $IIN;
    /**
     * @var string $KBK
     */
    public $KBK;
    /**
     * @var string $KBK_Ru
     */
    public $KBK_Ru;
    /**
     * @var string $KNO
     */
    public $KNO;
    /**
     * @var string $KNP
     */
    public $KNP;
    /**
     * @var string $KNP_Ru
     */
    public $KNP_Ru;
    /**
     * @var string $Commission
     */
    public $Commission;
    /**
     * @var string $MerchantID
     */
    public $MerchantID;
}
class PayTransferConfirmRequest extends BaseRequest
{
    /**
     * @var string $PayCode
     */
    public $PayCode;
    /**
     * @var string $BankName
     */
    public $BankName;
    /**
     * @var string $BankCallCenter
     */
    public $BankCallCenter;
    /**
     * @var string $BankPayDate
     */
    public $BankPayDate;
    /**
     * @var string $BankNumberTransaction
     */
    public $BankNumberTransaction;
    /**
     * @var float $Amount
     */
    public $Amount;
    /**
     * @var string $IIN
     */
    public $IIN;
    /**
     * @var string $KBK
     */
    public $KBK;
    /**
     * @var string $KBK_Ru
     */
    public $KBK_Ru;
    /**
     * @var string $KNO
     */
    public $KNO;
    /**
     * @var string $KNP
     */
    public $KNP;
    /**
     * @var string $KNP_Ru
     */
    public $KNP_Ru;
    /**
     * @var string $Commission
     */
    public $Commission;
    /**
     * @var string $MerchantID
     */
    public $MerchantID;
}
class ServiceGetCategoriesRequest extends BaseRequest
{
    /**
     * @var int $parent
     */
    public $parent;

    /**
     * @var string $modify_date
     */
    public $modify_date;
}
class SystemGetConfigRequest extends BaseRequest
{

}













