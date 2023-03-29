<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_Worker_Wage_002  {
    /**
     * Просчет ИПН
     * @param $year
     * @param $wage
     * @param $organizationTypeID
     * @param $organizationTaxTypeID
     * @param $workerStatusID
     * @param bool $isOwner
     * @return float|int
     */
    public static function calcIPN($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner = FALSE){
        if($wage <= Api_Tax_Const::getMinWageForIPN($year)){
            $percentIPN = 1;
        }else{
            $percentIPN = 10;
        }

        $basicWage = $wage;
        $opv = Api_Tax_Shop_Worker_Wage_001::calcOPV($year, $wage, $organizationTypeID, $organizationTaxTypeID, $workerStatusID, $isOwner);
        $wage = $wage - $opv - Api_Tax_Const::getMinWage($year);

        // прощет налогов для зарплаы для Казахстана
        $result = 0;
        switch ($organizationTypeID) {
            // ИП
            case Model_OrganizationType::ORGANIZATION_TYPE_IP:

                // выбор режима налогооблажения
                switch ($organizationTaxTypeID) {
                    // Упрощенный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_SIMPLIFIED:
                        if($isOwner){
                            //упрощенка для владельца
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = 0;
                                    break;
                                default:
                                    $result = 0;
                            }
                        }else{
                            // упрощенка для сотрудников
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = Api_Tax_Shop_Worker_Wage_001::calcPercent($wage, $percentIPN);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = Api_Tax_Shop_Worker_Wage_001::calcPercent($basicWage, $percentIPN);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = Api_Tax_Shop_Worker_Wage_001::calcPercent($wage, $percentIPN);
                                    break;
                                default:
                                    $result = Api_Tax_Shop_Worker_Wage_001::calcPercent($wage, $percentIPN);
                            }
                        }
                        break;
                    // Общеустановленный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_GENERALLY:
                        if($isOwner){
                            // для владельца общейустановленной
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = 0;
                                    break;
                                default:
                                    $result = 0;
                            }
                        }else{
                            // для сотрудников общейустановленной
                            switch ($workerStatusID) {
                                case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                    $result = Api_Tax_Shop_Worker_Wage_001::calcPercent($wage, $percentIPN);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                    $result = 0;
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                    $result = Api_Tax_Shop_Worker_Wage_001::calcPercent($basicWage, $percentIPN);
                                    break;
                                case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                    $result = Api_Tax_Shop_Worker_Wage_001::calcPercent($wage, $percentIPN);
                                    break;
                                default:
                                    $result = Api_Tax_Shop_Worker_Wage_001::calcPercent($wage, $percentIPN);
                            }
                        }
                        break;
                }
                break;
            // ТОО
            case Model_OrganizationType::ORGANIZATION_TYPE_TOO:
                // выбор режима налогооблажения
                switch ($organizationTaxTypeID) {
                    // Упрощенный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_SIMPLIFIED:
                        // упращенка
                        switch ($workerStatusID) {
                            case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                $result = Api_Tax_Shop_Worker_Wage_001::calcPercent($basicWage - 28284, $percentIPN);
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                $result = 0;
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                $result = Api_Tax_Shop_Worker_Wage_001::calcPercent($basicWage, $percentIPN);
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                $result = Api_Tax_Shop_Worker_Wage_001::calcPercent($wage, $percentIPN);
                                break;
                            default:
                                $result = Api_Tax_Shop_Worker_Wage_001::calcPercent($wage, $percentIPN);
                        }
                        break;
                    // Общеустановленный режим налогообложения
                    case Model_Tax_OrganizationTaxType::TAX_TYPE_GENERALLY:
                        // общеустановленное
                        switch ($workerStatusID) {
                            case Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER:
                                $result = Api_Tax_Shop_Worker_Wage_001::calcPercent($basicWage - 28284, $percentIPN);
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED:
                                $result = 0;
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN:
                                $result = Api_Tax_Shop_Worker_Wage_001::calcPercent($basicWage, $percentIPN);
                                break;
                            case Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL:
                                $result = Api_Tax_Shop_Worker_Wage_001::calcPercent($wage, $percentIPN);
                                break;
                            default:
                                $result = Api_Tax_Shop_Worker_Wage_001::calcPercent($wage, $percentIPN);
                        }
                        break;
                }
                break;
        }

        if($result < 0){
            $result = 0;
        }
        return $result;
    }
}
