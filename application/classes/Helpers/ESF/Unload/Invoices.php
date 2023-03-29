<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Список объектов выгруженных электронных счет-фактур
 * Class Helpers_ESF_Unload_Invoices
 */
class Helpers_ESF_Unload_Invoices extends Helpers_Array_Collection
{
    /**
     * Загрузка данных из XML
     * @param string $filePath
     * @return bool
     */
    public function loadXML($filePath)
    {
        $this->clear();

        $xml = simplexml_load_file($filePath);
        $xml = Helpers_XML::xmlToArray($xml);

        $xml = Arr::path($xml, 'invoiceInfoContainer.invoiceSet', '');
        if(!is_array($xml)){
            return FALSE;
        }

        foreach ($xml as $invoices){
            if(key_exists('invoiceBody', $invoices)){
                $invoices = [$invoices];
            }

            foreach ($invoices as $child) {
                try {
                    $xmlProducts = simplexml_load_string(Arr::path($child, 'invoiceBody.value', ''));
                    if (empty($xmlProducts)) {
                        echo 9999;die;
                    }
                    $xmlProducts = Helpers_XML::xmlToArray($xmlProducts);
                } catch (Exception $e) {
                    continue;
                }

                $invoice = new Helpers_ESF_Unload_Invoice();
                $invoice->loadXMLArray($xmlProducts['invoice']);
                $invoice->setRegistrationNumber(Arr::path($child, 'registrationNumber.value', ''));
                $this->add($invoice);
            }
        }

        return TRUE;
    }
}