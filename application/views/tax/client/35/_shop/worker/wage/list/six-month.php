<?php
$panelID = 'worker-wage-six-'.rand(0, 10000);
$year = Arr::path($additionDatas, 'year', date('Y'));
$halfYear = Arr::path($additionDatas, 'half_year', 1);
$minWage = Api_Tax_Shop_Worker_Wage::getMinWage($halfYear, $year);
?>

<div id="<?php echo $panelID; ?>" class="col-lg-12">
    <div class="card panel panel-default panel-table">
        <table class="table table-bordered table-items">
            <thead class="thead-default">
            <tr>
                <th>ФИО</th>
                <th>Статус</th>
                <?php if($halfYear == 1){ ?>
                <th style="width: 80px;">Январь</th>
                <th style="width: 80px;">Февраль</th>
                <th style="width: 80px;">Март</th>
                <th style="width: 80px;">Апрель</th>
                <th style="width: 80px;">Май</th>
                <th style="width: 80px;">Июнь</th>
                <?php }else{ ?>
                <th style="width: 80px;">Июль</th>
                <th style="width: 80px;">Август</th>
                <th style="width: 80px;">Сентябрь</th>
                <th style="width: 80px;">Октябрь</th>
                <th style="width: 80px;">Ноябрь</th>
                <th style="width: 80px;">Декабрь</th>
                <th style="width: 30px;"></th>
                <?php } ?>
            </tr>
            </thead>
            <tbody id="<?php echo $panelID; ?>-table-body" data-index="0">
            <?php
            if (count($data['view::_shop/worker/wage/one/six-month']->childs) > 0) {
                foreach ($data['view::_shop/worker/wage/one/six-month']->childs as $value) {
                    echo str_replace('#parent-select#', $panelID, $value->str);
                }
            }else{
            ?>
                <tr>
                    <td>
                        <div class="box-typeahead">
                            <input name="shop_worker_wages[0][shop_worker_name]" class="form-control workers_name typeahead" placeholder="ФИО сотрудника" type="text">
                        </div>
                    </td>
                    <td>
                        <select name="shop_worker_wages[0][worker_status_id]" class="form-control ks-select" data-parent="#<?php echo $panelID; ?>" style="width: 100%">
                            <option value="0" data-id="0">Без статуса</option>
                            <?php echo $siteData->globalDatas['view::workerstatus/list/list']; ?>
                        </select>
                    </td>
                    <td>
                        <input name="shop_worker_wages[0][1]" class="form-control money-format" type="text" placeholder="<?php echo $minWage; ?>">
                    </td>
                    <td>
                        <input name="shop_worker_wages[0][2]" class="form-control money-format" type="text" placeholder="<?php echo $minWage; ?>">
                    </td>
                    <td>
                        <input name="shop_worker_wages[0][3]" class="form-control money-format" type="text" placeholder="<?php echo $minWage; ?>">
                    </td>
                    <td>
                        <input name="shop_worker_wages[0][4]" class="form-control money-format" type="text" placeholder="<?php echo $minWage; ?>">
                    </td>
                    <td>
                        <input name="shop_worker_wages[0][5]" class="form-control money-format" type="text" placeholder="<?php echo $minWage; ?>">
                    </td>
                    <td>
                        <input name="shop_worker_wages[0][6]" class="form-control money-format" type="text" placeholder="<?php echo $minWage; ?>">
                    </td>
                    <td>
                        <button type="button" class="close" aria-label="Close" data-action="tr-delete">
                            <span aria-hidden="true" class="fa fa-close"></span>
                        </button>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <div class="card-footer">
            <button class="btn btn-primary" type="button" onclick="addTr('#<?php echo $panelID; ?>-table-tr', '#<?php echo $panelID; ?>-table-body')">Добавить сотрудника</button>
        </div>
    </div>
</div>
<style>
    .money-format{
        padding: 10px 8px;
    }
</style>
<div id="<?php echo $panelID; ?>-table-tr" data-index="1">

<!--
    <tr>
        <td>
            <div class="box-typeahead">
                <input name="shop_worker_wages[#index#][shop_worker_name]" class="form-control workers_name typeahead" placeholder="ФИО сотрудника" type="text">
            </div>
        </td>
        <td>
            <select name="shop_worker_wages[#index#][worker_status_id]" class="form-control ks-select" data-parent="#<?php echo $panelID; ?>" style="width: 100%">
                <option value="0" data-id="0">Без статуса</option>
                <?php echo $siteData->globalDatas['view::workerstatus/list/list']; ?>
            </select>
        </td>
        <td>
            <input name="shop_worker_wages[#index#][1]" class="form-control money-format" type="text" placeholder="<?php echo $minWage; ?>">
        </td>
        <td>
            <input name="shop_worker_wages[#index#][2]" class="form-control money-format" type="text" placeholder="<?php echo $minWage; ?>">
        </td>
        <td>
            <input name="shop_worker_wages[#index#][3]" class="form-control money-format" type="text" placeholder="<?php echo $minWage; ?>">
        </td>
        <td>
            <input name="shop_worker_wages[#index#][4]" class="form-control money-format" type="text" placeholder="<?php echo $minWage; ?>">
        </td>
        <td>
            <input name="shop_worker_wages[#index#][5]" class="form-control money-format" type="text" placeholder="<?php echo $minWage; ?>">
        </td>
        <td>
            <input name="shop_worker_wages[#index#][6]" class="form-control money-format" type="text" placeholder="<?php echo $minWage; ?>">
        </td>
        <td>
            <button type="button" class="close" aria-label="Close" data-action="tr-delete">
                <span aria-hidden="true" class="fa fa-close"></span>
            </button>
        </td>
    </tr>
-->
</div>