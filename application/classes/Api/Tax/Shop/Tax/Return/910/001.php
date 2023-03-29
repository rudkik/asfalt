<?php defined('SYSPATH') or die('No direct script access.');

class Api_Tax_Shop_Tax_Return_910_001  {
    /**
     * Сохранение 910 формы в PDF
     * @param Model_Tax_Shop_Tax_Return_910 $model
     * @param SitePageData $sitePageData
     * @param $fileName
     * @param bool $isPHPOutput
     */
    public static function saveInPDF(Model_Tax_Shop_Tax_Return_910 $model, SitePageData $sitePageData, $fileName, $isPHPOutput = FALSE)
    {
        $pdf = new PDF_Tax_Return_910_001();
        $pdf->setBackgroundPages($sitePageData->languageID);
        $pdf->setBIN(Arr::path($sitePageData->shop->getRequisitesArray(), 'bin', ''));
        $pdf->setName(Arr::path($sitePageData->shop->getRequisitesArray(), 'company_name', ''));

        $pdf->setView($model->getTaxViewID());
        $pdf->setIsResident(Arr::path($sitePageData->shop->getRequisitesArray(), 'is_resident', TRUE));
        $pdf->setCategoryTaxpayer(2018);

        $modelAkimat = $sitePageData->shop->getElement('requisites_akimat_id', TRUE);
        if ($modelAkimat !== NULL) {
            $pdf->setBINAkimat($modelAkimat->getBIN());
        }

        $pdf->setOperationName(Arr::path($sitePageData->shop->getRequisitesArray(), 'director', ''));

        $modelAuthority = $sitePageData->shop->getElement('requisites_authority_id', TRUE);
        if ($modelAuthority !== NULL) {
            $pdf->setKOGDN($modelAuthority->getCode());
            $pdf->setKOGDZH($modelAuthority->getCode());
        }

        $pdf->setHalfYear($model->getHalfYear());
        $pdf->setYear($model->getYear());

        $options = $model->getOptionsArray();

        $pdf->set_910_00_001(Arr::path($options, '910.00.001', '', '_'));
        $pdf->set_910_00_002(Arr::path($options, '910.00.002', '', '_'));
        $pdf->set_910_00_003(round(Arr::path($options, '910.00.003_all', '', '_'), 1));
        $pdf->set_910_00_003_a(round(Arr::path($options, '910.00.003_a', '', '_'), 1));
        $pdf->set_910_00_003_b(round(Arr::path($options, '910.00.003_b', '', '_'), 1));

        $pdf->set_910_00_004(Arr::path($options, '910.00.004', '', '_'));
        $pdf->set_910_00_005(Arr::path($options, '910.00.005', '', '_'));
        $pdf->set_910_00_006(Arr::path($options, '910.00.006', '', '_'));
        $pdf->set_910_00_007(Arr::path($options, '910.00.007', '', '_'));
        $pdf->set_910_00_008(Arr::path($options, '910.00.008', '', '_'));
        $pdf->set_910_00_009(Arr::path($options, '910.00.009', '', '_'));


        $pdf->set_910_00_010_1(Arr::path($options, '910.00.010_1', '', '_'));
        $pdf->set_910_00_010_2(Arr::path($options, '910.00.010_2', '', '_'));
        $pdf->set_910_00_010_3(Arr::path($options, '910.00.010_3', '', '_'));
        $pdf->set_910_00_010_4(Arr::path($options, '910.00.010_4', '', '_'));
        $pdf->set_910_00_010_5(Arr::path($options, '910.00.010_5', '', '_'));
        $pdf->set_910_00_010_6(Arr::path($options, '910.00.010_6', '', '_'));
        $pdf->set_910_00_010_7(Arr::path($options, '910.00.010_7', '', '_'));

        $pdf->set_910_00_011_1(Arr::path($options, '910.00.011_1', '', '_'));
        $pdf->set_910_00_011_2(Arr::path($options, '910.00.011_2', '', '_'));
        $pdf->set_910_00_011_3(Arr::path($options, '910.00.011_3', '', '_'));
        $pdf->set_910_00_011_4(Arr::path($options, '910.00.011_4', '', '_'));
        $pdf->set_910_00_011_5(Arr::path($options, '910.00.011_5', '', '_'));
        $pdf->set_910_00_011_6(Arr::path($options, '910.00.011_6', '', '_'));
        $pdf->set_910_00_011_7(Arr::path($options, '910.00.011_7', '', '_'));

        $pdf->set_910_00_012_1(Arr::path($options, '910.00.012_1', '', '_'));
        $pdf->set_910_00_012_2(Arr::path($options, '910.00.012_2', '', '_'));
        $pdf->set_910_00_012_3(Arr::path($options, '910.00.012_3', '', '_'));
        $pdf->set_910_00_012_4(Arr::path($options, '910.00.012_4', '', '_'));
        $pdf->set_910_00_012_5(Arr::path($options, '910.00.012_5', '', '_'));
        $pdf->set_910_00_012_6(Arr::path($options, '910.00.012_6', '', '_'));
        $pdf->set_910_00_012_7(Arr::path($options, '910.00.012_7', '', '_'));

        $pdf->set_910_00_013_1(Arr::path($options, '910.00.013_1', '', '_'));
        $pdf->set_910_00_013_2(Arr::path($options, '910.00.013_2', '', '_'));
        $pdf->set_910_00_013_3(Arr::path($options, '910.00.013_3', '', '_'));
        $pdf->set_910_00_013_4(Arr::path($options, '910.00.013_4', '', '_'));
        $pdf->set_910_00_013_5(Arr::path($options, '910.00.013_5', '', '_'));
        $pdf->set_910_00_013_6(Arr::path($options, '910.00.013_6', '', '_'));
        $pdf->set_910_00_013_7(Arr::path($options, '910.00.013_7', '', '_'));

        $pdf->set_910_00_014_1(Arr::path($options, '910.00.014_1', '', '_'));
        $pdf->set_910_00_014_2(Arr::path($options, '910.00.014_2', '', '_'));
        $pdf->set_910_00_014_3(Arr::path($options, '910.00.014_3', '', '_'));
        $pdf->set_910_00_014_4(Arr::path($options, '910.00.014_4', '', '_'));
        $pdf->set_910_00_014_5(Arr::path($options, '910.00.014_5', '', '_'));
        $pdf->set_910_00_014_6(Arr::path($options, '910.00.014_6', '', '_'));
        $pdf->set_910_00_014_7(Arr::path($options, '910.00.014_7', '', '_'));

        $pdf->set_910_00_015_1(Arr::path($options, '910.00.015_1', '', '_'));
        $pdf->set_910_00_015_2(Arr::path($options, '910.00.015_2', '', '_'));
        $pdf->set_910_00_015_3(Arr::path($options, '910.00.015_3', '', '_'));
        $pdf->set_910_00_015_4(Arr::path($options, '910.00.015_4', '', '_'));
        $pdf->set_910_00_015_5(Arr::path($options, '910.00.015_5', '', '_'));
        $pdf->set_910_00_015_6(Arr::path($options, '910.00.015_6', '', '_'));
        $pdf->set_910_00_015_7(Arr::path($options, '910.00.015_7', '', '_'));

        $pdf->set_910_00_016_1(Arr::path($options, '910.00.016_1', '', '_'));
        $pdf->set_910_00_016_2(Arr::path($options, '910.00.016_2', '', '_'));
        $pdf->set_910_00_016_3(Arr::path($options, '910.00.016_3', '', '_'));
        $pdf->set_910_00_016_4(Arr::path($options, '910.00.016_4', '', '_'));
        $pdf->set_910_00_016_5(Arr::path($options, '910.00.016_5', '', '_'));
        $pdf->set_910_00_016_6(Arr::path($options, '910.00.016_6', '', '_'));
        $pdf->set_910_00_016_7(Arr::path($options, '910.00.016_7', '', '_'));

        $pdf->set_910_00_017_1(Arr::path($options, '910.00.017_1', '', '_'));
        $pdf->set_910_00_017_2(Arr::path($options, '910.00.017_2', '', '_'));
        $pdf->set_910_00_017_3(Arr::path($options, '910.00.017_3', '', '_'));
        $pdf->set_910_00_017_4(Arr::path($options, '910.00.017_4', '', '_'));
        $pdf->set_910_00_017_5(Arr::path($options, '910.00.017_5', '', '_'));
        $pdf->set_910_00_017_6(Arr::path($options, '910.00.017_6', '', '_'));
        $pdf->set_910_00_017_7(Arr::path($options, '910.00.017_7', '', '_'));

        $pdf->set_910_00_018_1(Arr::path($options, '910.00.018_1', '', '_'));
        $pdf->set_910_00_018_2(Arr::path($options, '910.00.018_2', '', '_'));
        $pdf->set_910_00_018_3(Arr::path($options, '910.00.018_3', '', '_'));
        $pdf->set_910_00_018_4(Arr::path($options, '910.00.018_4', '', '_'));
        $pdf->set_910_00_018_5(Arr::path($options, '910.00.018_5', '', '_'));
        $pdf->set_910_00_018_6(Arr::path($options, '910.00.018_6', '', '_'));
        $pdf->set_910_00_018_7(Arr::path($options, '910.00.018_7', '', '_'));

        $pdf->set_910_00_019_1(Arr::path($options, '910.00.019_1', '', '_'));
        $pdf->set_910_00_019_2(Arr::path($options, '910.00.019_2', '', '_'));
        $pdf->set_910_00_019_3(Arr::path($options, '910.00.019_3', '', '_'));
        $pdf->set_910_00_019_4(Arr::path($options, '910.00.019_4', '', '_'));
        $pdf->set_910_00_019_5(Arr::path($options, '910.00.019_5', '', '_'));
        $pdf->set_910_00_019_6(Arr::path($options, '910.00.019_6', '', '_'));
        $pdf->set_910_00_019_7(Arr::path($options, '910.00.019_7', '', '_'));

        $pdf->set_910_00_020_1(Arr::path($options, '910.00.020_1', '', '_'));
        $pdf->set_910_00_020_2(Arr::path($options, '910.00.020_2', '', '_'));
        $pdf->set_910_00_020_3(Arr::path($options, '910.00.020_3', '', '_'));
        $pdf->set_910_00_020_4(Arr::path($options, '910.00.020_4', '', '_'));
        $pdf->set_910_00_020_5(Arr::path($options, '910.00.020_5', '', '_'));
        $pdf->set_910_00_020_6(Arr::path($options, '910.00.020_6', '', '_'));
        $pdf->set_910_00_020_7(Arr::path($options, '910.00.020_7', '', '_'));

        $pdf->set_910_00_021_1(Arr::path($options, '910.00.021_1', '', '_'));
        $pdf->set_910_00_021_2(Arr::path($options, '910.00.021_2', '', '_'));
        $pdf->set_910_00_021_3(Arr::path($options, '910.00.021_3', '', '_'));
        $pdf->set_910_00_021_4(Arr::path($options, '910.00.021_4', '', '_'));
        $pdf->set_910_00_021_5(Arr::path($options, '910.00.021_5', '', '_'));
        $pdf->set_910_00_021_6(Arr::path($options, '910.00.021_6', '', '_'));
        $pdf->set_910_00_021_7(Arr::path($options, '910.00.021_7', '', '_'));

        $pdf->set_910_00_022_1(Arr::path($options, '910.00.022_1', '', '_'));
        $pdf->set_910_00_022_2(Arr::path($options, '910.00.022_2', '', '_'));
        $pdf->set_910_00_022_3(Arr::path($options, '910.00.022_3', '', '_'));
        $pdf->set_910_00_022_4(Arr::path($options, '910.00.022_4', '', '_'));
        $pdf->set_910_00_022_5(Arr::path($options, '910.00.022_5', '', '_'));
        $pdf->set_910_00_022_6(Arr::path($options, '910.00.022_6', '', '_'));
        $pdf->set_910_00_022_7(Arr::path($options, '910.00.022_7', '', '_'));

        $pdf->set_910_00_023_1(Arr::path($options, '910.00.023_1', '', '_'));
        $pdf->set_910_00_023_2(Arr::path($options, '910.00.023_2', '', '_'));
        $pdf->set_910_00_023_3(Arr::path($options, '910.00.023_3', '', '_'));
        $pdf->set_910_00_023_4(Arr::path($options, '910.00.023_4', '', '_'));
        $pdf->set_910_00_023_5(Arr::path($options, '910.00.023_5', '', '_'));
        $pdf->set_910_00_023_6(Arr::path($options, '910.00.023_6', '', '_'));
        $pdf->set_910_00_023_7(Arr::path($options, '910.00.023_7', '', '_'));

        $pdf->set_910_00_024_1(Arr::path($options, '910.00.024_1', '', '_'));
        $pdf->set_910_00_024_2(Arr::path($options, '910.00.024_2', '', '_'));
        $pdf->set_910_00_024_3(Arr::path($options, '910.00.024_3', '', '_'));
        $pdf->set_910_00_024_4(Arr::path($options, '910.00.024_4', '', '_'));
        $pdf->set_910_00_024_5(Arr::path($options, '910.00.024_5', '', '_'));
        $pdf->set_910_00_024_6(Arr::path($options, '910.00.024_6', '', '_'));
        $pdf->set_910_00_024_7(Arr::path($options, '910.00.024_7', '', '_'));

        if ($isPHPOutput){
            $pdf->Output($fileName, 'D');
        }else {
            $pdf->Output($fileName, 'F');
        }
    }

    /**
     * Сохранение данных для посчета формы 910.00
     * @param $halfYear
     * @param $year
     * @param SitePageData $sitePageData
     * @param Model_Driver_DBBasicDriver $driver
     * @return array
     * @throws HTTP_Exception_500
     */
    public static function saveData($halfYear, $year, SitePageData $sitePageData, Model_Driver_DBBasicDriver $driver)
    {
        $isEditWage = Request_RequestParams::getParamBoolean('is_edit_wage');

        // сотрудники
        $shopWorkerWages = Request_RequestParams::getParamArray('shop_worker_wages', array(), array());
        $data = Api_Tax_Shop_Worker_Wage::saveSixWage($halfYear, $year, $shopWorkerWages, $sitePageData,
            $driver, FALSE, $isEditWage);

        // владелец
        $shopWorkerWages = Request_RequestParams::getParamArray('shop_owner_wages', array(), array());
        $dataOwner = Api_Tax_Shop_Worker_Wage::saveSixWage($halfYear, $year, $shopWorkerWages,
            $sitePageData, $driver, TRUE, $isEditWage);

        $model = new Model_Tax_Shop_Tax_Return_910();
        $model->setDBDriver($driver);

        $id = Request_RequestParams::getParamInt('id');
        if($id > 0) {
            if (!Helpers_DB::dublicateObjectLanguage($model, $id, $sitePageData)) {
                throw new HTTP_Exception_500('Tax return 910 not found.');
            }
        }

        $model->setYear($year);
        $model->setHalfYear($halfYear);
        $model->setRevenue(Request_RequestParams::getParamFloat('revenue'));
        $model->setTaxViewID(Request_RequestParams::getParamInt('tax_view_id'));
        $model->setDataArray($data);

        $options = array(
            '910.00.001' => $model->getRevenue(),

            '910.00.003' => array(
                'all' => $data['half_year']['all']['count'] / 6,
                'a' => $data['half_year'][Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER]['count'] / 6,
                'b' => $data['half_year'][Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED]['count'] / 6,
            ),

            '910.00.004' => 0,
            '910.00.005' => self::calcPercent($model->getRevenue(), 3),
            '910.00.006' => 0,

            /** Для Владельца ИП **/
            // Зарплaта для Социальные отчисления Владельца
            '910.00.010' => array(
                '1' => $dataOwner[1]['all']['wage_so'],
                '2' => $dataOwner[2]['all']['wage_so'],
                '3' => $dataOwner[3]['all']['wage_so'],
                '4' => $dataOwner[4]['all']['wage_so'],
                '5' => $dataOwner[5]['all']['wage_so'],
                '6' => $dataOwner[6]['all']['wage_so'],
                '7' => $dataOwner['half_year']['all']['wage_so'],
            ),
            // Социальные отчисления Владельца
            '910.00.011' => array(
                '1' => $dataOwner[1]['all']['so'],
                '2' => $dataOwner[2]['all']['so'],
                '3' => $dataOwner[3]['all']['so'],
                '4' => $dataOwner[4]['all']['so'],
                '5' => $dataOwner[5]['all']['so'],
                '6' => $dataOwner[6]['all']['so'],
                '7' => $dataOwner['half_year']['all']['so'],
            ),
            // Зарплата для Пенсионки Владельца
            '910.00.012' => array(
                '1' => $dataOwner[1]['all']['wage_opv'],
                '2' => $dataOwner[2]['all']['wage_opv'],
                '3' => $dataOwner[3]['all']['wage_opv'],
                '4' => $dataOwner[4]['all']['wage_opv'],
                '5' => $dataOwner[5]['all']['wage_opv'],
                '6' => $dataOwner[6]['all']['wage_opv'],
                '7' => $dataOwner['half_year']['all']['wage_opv'],
            ),
            // Пенсионные отчисления Владельца
            '910.00.013' => array(
                '1' => $dataOwner[1]['all']['opv'],
                '2' => $dataOwner[2]['all']['opv'],
                '3' => $dataOwner[3]['all']['opv'],
                '4' => $dataOwner[4]['all']['opv'],
                '5' => $dataOwner[5]['all']['opv'],
                '6' => $dataOwner[6]['all']['opv'],
                '7' => $dataOwner['half_year']['all']['opv'],
            ),
            // Медицинское страхование Владельца
            '910.00.014' => array(
                '1' => $dataOwner[1]['all']['osms'],
                '2' => $dataOwner[2]['all']['osms'],
                '3' => $dataOwner[3]['all']['osms'],
                '4' => $dataOwner[4]['all']['osms'],
                '5' => $dataOwner[5]['all']['osms'],
                '6' => $dataOwner[6]['all']['osms'],
                '7' => $dataOwner['half_year']['all']['osms'],
            ),

            /** Для сотрудников, которые работают в ИП **/
            // Индивидуальный подоходный налог граждан Республики Казахстан
            '910.00.015' => array(
                '1' => $data[1][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['ipn'] + $data[1][Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER]['ipn'] + $data[1][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['ipn'],
                '2' => $data[2][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['ipn'] + $data[2][Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER]['ipn'] + $data[2][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['ipn'],
                '3' => $data[3][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['ipn'] + $data[3][Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER]['ipn'] + $data[3][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['ipn'],
                '4' => $data[4][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['ipn'] + $data[4][Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER]['ipn'] + $data[4][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['ipn'],
                '5' => $data[5][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['ipn'] + $data[5][Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER]['ipn'] + $data[5][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['ipn'],
                '6' => $data[6][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['ipn'] + $data[6][Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER]['ipn'] + $data[6][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['ipn'],
                '7' => $data['half_year'][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['ipn'] + $data['half_year'][Model_Tax_WorkerStatus::WORKER_STATUS_PENSIONER]['ipn'] + $data['half_year'][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['ipn'],
            ),
            // Индивидуальный подоходный налог иностранцев и лиц без гражданства
            '910.00.016' => array(
                '1' => $data[1][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN]['ipn'],
                '2' => $data[2][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN]['ipn'],
                '3' => $data[3][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN]['ipn'],
                '4' => $data[4][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN]['ipn'],
                '5' => $data[5][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN]['ipn'],
                '6' => $data[6][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN]['ipn'],
                '7' => $data['half_year'][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN]['ipn'],
            ),
            // Зарплaта для Социальные отчисления (Зарплата - Пенсионка) не добавлять Пенсион
            '910.00.017' => array(
                '1' => $data[1][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['wage_so'] + $data[1][Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED]['wage_so'] + $data[1][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN]['wage_so'] + $data[1][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['wage_so'],
                '2' => $data[2][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['wage_so'] + $data[2][Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED]['wage_so'] + $data[2][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN]['wage_so'] + $data[2][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['wage_so'],
                '3' => $data[3][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['wage_so'] + $data[3][Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED]['wage_so'] + $data[3][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN]['wage_so'] + $data[3][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['wage_so'],
                '4' => $data[4][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['wage_so'] + $data[4][Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED]['wage_so'] + $data[4][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN]['wage_so'] + $data[4][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['wage_so'],
                '5' => $data[5][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['wage_so'] + $data[5][Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED]['wage_so'] + $data[5][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN]['wage_so'] + $data[5][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['wage_so'],
                '6' => $data[6][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['wage_so'] + $data[6][Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED]['wage_so'] + $data[6][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN]['wage_so'] + $data[6][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['wage_so'],
                '7' => $data['half_year'][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['wage_so'] + $data['half_year'][Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED]['wage_so'] + $data['half_year'][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN]['wage_so'] + $data['half_year'][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['wage_so'],
            ),
            // Зарплaта для Пенсионки не добавлять Пенсион и Без вида на жительства
            '910.00.019' => array(
                '1' => $data[1][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['wage_opv'] + $data[1][Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED]['wage_opv'] + $data[1][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['wage_opv'],
                '2' => $data[2][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['wage_opv'] + $data[2][Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED]['wage_opv'] + $data[2][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['wage_opv'],
                '3' => $data[3][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['wage_opv'] + $data[3][Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED]['wage_opv'] + $data[3][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['wage_opv'],
                '4' => $data[4][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['wage_opv'] + $data[4][Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED]['wage_opv'] + $data[4][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['wage_opv'],
                '5' => $data[5][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['wage_opv'] + $data[5][Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED]['wage_opv'] + $data[5][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['wage_opv'],
                '6' => $data[6][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['wage_opv'] + $data[6][Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED]['wage_opv'] + $data[6][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['wage_opv'],
                '7' => $data['half_year'][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['wage_opv'] + $data['half_year'][Model_Tax_WorkerStatus::WORKER_STATUS_HANDICAPPED]['wage_opv'] + $data['half_year'][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['wage_opv'],
            ),
            // Зарплaта для Обязательные профессиональные пенсионные взносы
            '910.00.021' => array(
                '1' => $data[1]['all']['wage_oppv'],
                '2' => $data[1]['all']['wage_oppv'],
                '3' => $data[1]['all']['wage_oppv'],
                '4' => $data[1]['all']['wage_oppv'],
                '5' => $data[1]['all']['wage_oppv'],
                '6' => $data[1]['all']['wage_oppv'],
                '7' => $data['half_year']['all']['wage_oppv'],
            ),
            // Зарплaта для Медиционского страхования не добавлять Пенсион, Инвалид 3 группы
            '910.00.023' => array(
                '1' => $data[1][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['wage_osms'] + $data[1][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN]['wage_osms'] + $data[1][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['wage_osms'],
                '2' => $data[2][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['wage_osms'] + $data[2][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN]['wage_osms'] + $data[2][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['wage_osms'],
                '3' => $data[3][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['wage_osms'] + $data[3][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN]['wage_osms'] + $data[3][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['wage_osms'],
                '4' => $data[4][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['wage_osms'] + $data[4][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN]['wage_osms'] + $data[4][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['wage_osms'],
                '5' => $data[5][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['wage_osms'] + $data[5][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN]['wage_osms'] + $data[5][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['wage_osms'],
                '6' => $data[6][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['wage_osms'] + $data[6][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN]['wage_osms'] + $data[6][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['wage_osms'],
                '7' => $data['half_year'][Model_Tax_WorkerStatus::WORKER_STATUS_NATIONAL]['wage_osms'] + $data['half_year'][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN]['wage_osms'] + $data['half_year'][Model_Tax_WorkerStatus::WORKER_STATUS_ALIEN_NATIONAL]['wage_osms'],
            ),
        );

        if ($options['910.00.003']['all'] > 0.5){
            $options['910.00.003']['all'] = ceil($options['910.00.003']['all']);
        }
        if ($options['910.00.003']['a'] > 0.5){
            $options['910.00.003']['a'] = ceil($options['910.00.003']['a']);
        }
        if ($options['910.00.003']['b'] > 0.5){
            $options['910.00.003']['b'] = ceil($options['910.00.003']['b']);
        }

        if($data['half_year']['all']['count'] > 0) {
            $tmp = 0;
            for ($i = 1; $i < 7; $i++) {
                if ($data[$i]['all']['count'] > 0) {
                    $tmp += $data[$i]['all']['wage'] / $data[$i]['all']['count'];
                }
            }

            $options['910.00.004'] = ceil($tmp / 6);
        }

        $minWage = Api_Tax_Shop_Worker_Wage::getMinWage($halfYear, $year);
        if ($options['910.00.004'] >= 2.5 * $minWage){

            $v1 = $options['910.00.005'];
            if($options['910.00.001'] > 2044 * $minWage){
                $v1 = $v1 - self::calcPercent($options['910.00.001'] - 2044 * $minWage, 3);
            }

            $v2 = $options['910.00.003']['all'];
            if($v2 > 30){
                $v2 = $v2 - 30;
            }

            $options['910.00.006'] = self::calcPercent($v1 * $v2, 1.5);
        }

        $options['910.00.007'] = $options['910.00.005'] - $options['910.00.006'];
        $options['910.00.008'] = ceil($options['910.00.007'] * 0.5);

        // Социальные отчисления
        $options['910.00.018'] = array(
            '1' => self::calcPercent($options['910.00.017'][1], 3.5),
            '2' => self::calcPercent($options['910.00.017'][2], 3.5),
            '3' => self::calcPercent($options['910.00.017'][3], 3.5),
            '4' => self::calcPercent($options['910.00.017'][4], 3.5),
            '5' => self::calcPercent($options['910.00.017'][5], 3.5),
            '6' => self::calcPercent($options['910.00.017'][6], 3.5),
            '7' => self::calcPercent($options['910.00.017'][7], 3.5),
        );
        // Пенсионные выплаты
        $options['910.00.020'] = array(
            '1' => self::calcPercent($options['910.00.019'][1], 10),
            '2' => self::calcPercent($options['910.00.019'][2], 10),
            '3' => self::calcPercent($options['910.00.019'][3], 10),
            '4' => self::calcPercent($options['910.00.019'][4], 10),
            '5' => self::calcPercent($options['910.00.019'][5], 10),
            '6' => self::calcPercent($options['910.00.019'][6], 10),
            '7' => self::calcPercent($options['910.00.019'][7], 10),
        );
        // Медиционского страхования выплаты
        $options['910.00.024'] = array(
            '1' => self::calcPercent($options['910.00.023'][1], 1.5),
            '2' => self::calcPercent($options['910.00.023'][2], 1.5),
            '3' => self::calcPercent($options['910.00.023'][3], 1.5),
            '4' => self::calcPercent($options['910.00.023'][4], 1.5),
            '5' => self::calcPercent($options['910.00.023'][5], 1.5),
            '6' => self::calcPercent($options['910.00.023'][6], 1.5),
            '7' => self::calcPercent($options['910.00.023'][7], 1.5),
        );
        // Обязательные профессиональные пенсионные взносы
        $options['910.00.022'] = array(
            '1' => self::calcPercent($options['910.00.021'][1], 5),
            '2' => self::calcPercent($options['910.00.021'][2], 5),
            '3' => self::calcPercent($options['910.00.021'][3], 5),
            '4' => self::calcPercent($options['910.00.021'][4], 5),
            '5' => self::calcPercent($options['910.00.021'][5], 5),
            '6' => self::calcPercent($options['910.00.021'][6], 5),
            '7' => self::calcPercent($options['910.00.021'][7], 5),
        );

        $options['910.00.009'] = $options['910.00.008'] - $options['910.00.011'][7] - $options['910.00.018'][7];
        if($options['910.00.009'] < 0){
            $options['910.00.009'] = 0;
        }

        $model->setOPV($options['910.00.013'][7] + $options['910.00.020'][7] + $options['910.00.022'][7]);
        $model->setSO($options['910.00.011'][7] + $options['910.00.018'][7]);
        $model->setIPN($options['910.00.015'][7] + $options['910.00.016'][7]);
        $model->setOSMS($options['910.00.014'][7] + $options['910.00.024'][7]);
        $model->setSN($options['910.00.009']);
        $model->setIKPN($options['910.00.008']);

        $model->setOptionsArray($options);

        $result = array();
        if ($model->validationFields($result)) {
            Helpers_DB::saveDBObject($model, $sitePageData);
            $result['values'] = $model->getValues();
        }

        return array(
            'id' => $model->id,
            'result' => $result,
        );
    }

    /**
     * просчет процента от суммы с округлением
     * @param $amount
     * @param $percent
     * @return float
     */
    public static function calcPercent($amount, $percent){
        return ceil($amount / 100 * $percent);
    }
}
