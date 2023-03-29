<?php defined('SYSPATH') or die('No direct script access.');

class BaseResponse
{
    /**
     * Error code
     * @var int $error_code
     * @soap
     */
    public $error_code;
}
class CashCashOutCompleteResponse extends BaseResponse
{

}
class CashCashOutResponse extends BaseResponse
{
    /**
     * @var CashCashOutResponseData $response
     */
    public $response;
}
class CashCashOutResponseData
{
    /**
     * @var string $redirectURL
     */
    public $redirectURL;

    /**
     * @var int $operationId
     */
    public $operationId;
}
class CashCheckServiceFieldsResponse extends BaseResponse
{
    /**
     * @var CashCheckServiceFieldsResponseData $response
     */
    public $response;
}
class CashCheckServiceFieldsResponseData
{
    /**
     * @var string $data
     */
    public $data;
}
class CashConfirmOperationResponse extends BaseResponse {

}
class CashCreateInvoiceResponse extends BaseResponse{
    /**
     * @var CashCreateInvoiceResponseData $response
     * @soap
     */
    public $response;
}
class CashCreateInvoiceResponseData {
    /**
     * ID operations invoice
     * @var int $operationId
     * @soap
     */
    public $operationId;
    /**
     * Address forms of payment invoice which you want to redirect the user
     * @var string $operationUrl
     * @soap
     */
    public $operationUrl;
}
class CashCreateOperationResponse extends BaseResponse
{
    /**
     * @var CashCreateOperationResponseData $response
     */
    public $response;
}
class CashCreateOperationResponseData
{
    /**
     * @var int operationId
     */
    public $operationId;
}
class CashDeclineResponse
{
    public $error_code;
}
class CashDischargementResponse extends BaseResponse {

}
class CashGetBalanceResponse
{
    /**
     * @var CashGetBalanceResponseData $response
     */
    public $response;

    /**
     * @var int $error_code
     */
    public $error_code;
}
class CashGetBalanceResponseData
{
    /**
     * User's account balance;
     * @var int $amount
     */
    public $amount;
}
class CashGetCommissionResponse
{
    /**
     * @var CashGetCommissionResponseData $response
     */
    public $response;

    /**
     * @var int $error_code
     */
    public $error_code;
}
class CashGetCommissionResponseData
{
    /**
     * @var int $amount
     */
    public $amount;
}
class CashGetOperationDataResponse extends BaseResponse {
    /**
     * @var CashGetOperationDataResponseData $response
     * @soap
     */
    public $response;
}
class CashGetOperationDataResponseData {
    /**
     * @var CashGetOperationDataResponseDataRecord[] $records
     * @soap
     */
    public $records;
}
class CashGetOperationDataResponseDataRecord {
    /**
     * id operation
     * @var int $id
     * @soap
     */
    public $id;
    /**
     * Type of operation, the possible values
     * @var int $type
     * @soap
     */
    public $type;
    /**
     * Id lots, if the operation is related to the acquisition of the lot; otherwise a value of 0
     * @var int $lotId
     * @soap
     */
    public $lotId;
    /**
     * Amount of the transaction
     * @var int $sum
     * @soap
     */
    public $sum;
    /**
     * Data creation time operation (yyyy-mm-dd hh: mm: ss);
     * @var string $date
     * @soap
     */
    public $date;
    /**
     * Status, possible values:
     * @var int $status
     * @soap
     */
    public $status;
    /**
     * Comment
     * @var string $comment
     * @soap
     */
    public $comment;
    /**
     * Login sender
     * @var string $fromSubject
     * @soap
     */
    public $fromSubject;
    /**
     * The recipient's name
     * @var string $toSubject
     * @soap
     */
    public $toSubject;
    /**
     * Name, surname of the sender
     * @var string $fromFullName
     * @soap
     */
    public $fromFullName;
    /**
     * Name, surname of the receiver
     * @var string $toFullName
     * @soap
     */
    public $toFullName;
}
class CashGetOperationReceiptResponse extends BaseResponse
{
    /**
     * @var CashGetOperationReceiptResponseData $response
     */
    public $response;
}
class CashGetOperationReceiptResponseData
{
    /**
     * @var string $operator
     */
    public $operator;
    /**
     * @var string $op_bin
     */
    public $op_bin;
    /**
     * @var string $ch_nr
     */
    public $ch_nr;
    /**
     * @var string $tr_nr
     */
    public $tr_nr;
    /**
     * @var string $account_nr
     */
    public $account_nr;
    /**
     * @var string $date
     */
    public $date;
    /**
     * @var string $mer_name
     */
    public $mer_name;
    /**
     * @var string $mer_bin
     */
    public $mer_bin;
    /**
     * @var string[] $ident
     */
    public $ident;
    /**
     * @var string $admit
     */
    public $admit;
    /**
     * @var string $commis
     */
    public $commis;
    /**
     * @var string $sum
     */
    public $sum;
    /**
     * @var string $operation
     */
    public $operation;
    /**
     * @var string $vat
     */
    public $vat;
    /**
     * @var string $sup
     */
    public $sup;
}
class CashGetOperationsStatusResponse
{
    /**
     * @var CashGetOperationsStatusResponseRecord[] $response
     */
    public $response;

    /**
     * @var int $error_code
     */
    public $error_code;
}
class CashGetOperationsStatusResponseRecord
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
class CashGetServiceFieldsResponse extends BaseResponse
{
    /**
     * @var CashGetServiceFieldsResponseData $response
     */
    public $response;
}
class CashGetServiceFieldsResponseData
{
    /**
     * @var string $data
     */
    public $data;
}
class CashGetTransfersResponse extends BaseResponse
{
    /**
     * @var CashGetTransfersResponseData
     */
    public $response;
}
class CashGetTransfersResponseData
{
    /**
     * @var CashGetTransfersResponseDataRecordService[] $records
     */
    public $records;
    /**
     * @var int $lastChanged
     */
    public $lastChanged ;
}
class CashGetTransfersResponseDataRecord
{
    /**
     * @var int $id
     */
    public $id;

    /**
     * @var string $fromSubject
     */
    public $fromSubject;

    /***
     * @var string $toSubject
     */
    public $toSubject;

    /**
     * @var string $fromFullName
     */
    public $fromFullName;

    /**
     * @var string $toFullName
     */
    public $toFullName;

    /**
     * @var int $direction
     */
    public $direction;

    /**
     * @var string $date
     */
    public $date;

    /**
     * @var float $sum
     */
    public $sum;

    /**
     * @var int $type
     */
    public $type;

    /**
     * @var int $status
     */
    public $status;

    /**
     * @var string $comment
     */
    public $comment;

    /**
     * @var int $lotId
     */
    public $lotId;

    /**
     * @var CashGetTransfersResponseDataRecordService $service
     */
    public $service;

    /**
     * @var string $avatarName
     */
    public $avatarName;

    /**
     * @var string $imageLotName
     */
    public $imageLotName;
}
class CashGetTransfersResponseDataRecordService
{
    /**
     * @var string $service_name
     */
    public $service_name;

    /**
     * @var string $name
     */
    public $name;

    /**
     * @var string $picture
     */
    public $picture;
}
class CashInvoicingResponse extends BaseResponse
{
    /**
     * @var CashInvoicingResponseData $response
     */
    public $response;
}
class CashInvoicingResponseData
{
    /**
     * @var int $operationId
     */
    public $operationId;
}
class CashPrepaidCardCommissionResponse extends BaseResponse
{
    /**
     * @var CashPrepaidCardCommissionResponseData $response
     */
    public $response;
}
class CashPrepaidCardCommissionResponseData
{
    /**
     * @var int $commission
     */
    public $commission;
}
class CashPrepaidCardPerformResponse extends BaseResponse
{
    /**
     * @var CashPrepaidCardPerformResponseData $response
     */
    public $response;
}
class CashPrepaidCardPerformResponseData
{
    /**
     * @var int $amount
     */
    public $amount;

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
class CashPrepaidCardResponse extends BaseResponse
{
    /**
     * @var CashPrepaidCardResponseData $response
     */
    public $response;
}
class CashPrepaidCardResponseData
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
class CashRequestTransferResponse extends BaseResponse
{
    /**
     * @var CashRequestTransferResponseData $response
     */
    public $response;
}
class CashRequestTransferResponseData
{
    /**
     * @var int $operationId
     */
    public $operationId;
}
class CashReturnResponse extends BaseResponse
{

}
class CashSetOperationsStatusResponse
{
    /**
     * @var CashSetOperationsStatusResponseRecord[] $response
     */
    public $response;

    /**
     * @var int $error_code
     */
    public $error_code;
}
class CashSetOperationsStatusResponseRecord
{
    /**
     * @var string $ext_id
     */
    public $ext_id;

    /**
     * @var int $status
     */
    public $status;
}
class CashTransferResponse extends BaseResponse {

}
class CoreGetServiceIDByNameResponse
{
    /**
     * @var CoreGetServiceIDByNameResponseData $response
     */
    public $response;

    /**
     * @var int $error_code
     */
    public $error_code;
}
class CoreGetServiceIDByNameResponseData
{
    /**
     * @var int $serviceId
     */
    public $serviceId;

    /**
     * @var int $error_code
     */
    public $error_code;
}
class CoreLoginResponse extends BaseResponse {
    /**
     * @var CoreLoginResponseData $response
     * @soap
     */
    public $response;
}
class CoreLoginResponseData extends BaseResponse {
    /**
     * Session identifier
     * @var string session
     */
    public $session;
    /**
     * User ID
     * @var int id
     */
    public $id;
    /**
     * Name and last name
     * @var string username
     */
    public $username;
    /**
     * User type, possible values
     * @var int type
     */
    public $Type;
    /**
     * An array of user roles:
     * @var string[] roles
     */
    public $roles;
    /**
     * Avatars modification date (in the format "yyyy-mm-dd hh: mm: ss")
     * @var String $AvatarVersion
     */
    public $AvatarVersion;
    /**
     * Avatars file name (without the extension, all avatars extension "jpg")
     * @var String $avatarName
     */
    public $avatarName;
}
class CoreLogoutResponse extends BaseResponse {

}
class CoreSmthResponse extends BaseResponse {

}
class CoreUserExistsResponse extends BaseResponse
{
    /**
     * @var boolean $response
     */
    public $response;
}
class CoreUserSearchResponse extends BaseResponse
{
    /**
     * @var CoreUserSearchResponseData $response
     */
    public $response;
}
class CoreUserSearchResponseData
{
    /**
     * @var string $subject_name
     */
    public $subject_name;

    /**
     * @var string $avatarName
     */
    public $avatarName;
}
class CreateOperationResponse
{
    /**
     * @var int $OperationID
     */
    public $OperationID;

    /**
     * @var string $OperationURL
     */
    public $OperationURL;
}
class ServiceGetCategoriesResponse
{
    /**
     * @var ServiceGetCategoriesResponseData $response
     */
    public $response;

    /**
     * @var int $error_code
     */
    public $error_code;
}
class ServiceGetCategoriesResponseData
{
    /**
     * @var ServiceGetCategoriesResponseDataCategories[] $categories
     */
    public $categories;

    /**
     * @var string[] $modify_date
     */
    public $modify_date;

    /**
     * @var int $no_update
     */
    public $no_update;
}
class ServiceGetCategoriesResponseDataCategories
{
    /**
     * @var int $id;
     */
    public $id;

    /**
     * @var string $name
     */
    public $name;

    /**
     * @var int $tag_id
     */
    public $tag_id;

    /**
     * @var int $parent_id
     */
    public $parent_id;

    /**
     * @var string $picture
     */
    public $picture;

    /**
     * @var string[] $synonyms
     */
    public $synonyms;

    /**
     * @var ServiceGetCategoriesResponseDataServices[]
     */
    public $services;
}
class ServiceGetCategoriesResponseDataServices
{
    /**
     * @var int $id
     */
    public $id;
    /**
     * @var string $merchant
     */
    public $merchant;
    /**
     * @var string $service_name
     */
    public $service_name;
    /**
     * @var string $name
     */
    public $name;
    /**
     * @var string $picture
     */
    public $picture;
    /**
     * @var string[] $synonyms
     */
    public $synonyms;
    /**
     * @var string $description
     */
    public $description;
}
class SystemGetConfigResponse extends BaseResponse
{
    /**
     * @var SystemGetConfigResponse $response
     */
    public $response;
}
class SystemGetConfigResponseData
{
    /**
     * @var string $avatarsRoot
     */
    public $avatarsRoot;
    /**
     * @var string $servicePicturesRoot
     */
    public $servicePicturesRoot;
    /**
     * @var string $serviceMenuPicturesRoot
     */
    public $serviceMenuPicturesRoot;
    /**
     * @var string $lotPicturesRoot
     */
    public $lotPicturesRoot;
    /**
     * @var string $placePicturesRoot
     */
    public $placePicturesRoot;
}