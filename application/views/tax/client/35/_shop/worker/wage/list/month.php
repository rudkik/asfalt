<?php
$panelID = 'worker-wage-month-'.rand(0, 10000);
?>

<div id="<?php echo $panelID; ?>" class="col-lg-12">
    <div class="card panel panel-default panel-table">
        <table class="table table-bordered table-items">
            <thead class="thead-default">
            <tr>
                <th>Сотрудник</th>
                <th>Статус</th>
                <th style="width: 80px;">Зарплата</th>
                <th style="width: 80px;">Владелец?</th>
                <th style="width: 30px;"></th>
            </tr>
            </thead>
            <tbody id="<?php echo $panelID; ?>-table-body" data-index="0">
            <?php
            if (count($data['view::_shop/worker/wage/one/month']->childs) > 0) {
                foreach ($data['view::_shop/worker/wage/one/month']->childs as $value) {
                    echo str_replace('#parent-select#', $panelID, $value->str);
                }
            }else{
            ?>
                <tr>
                    <td>
                        <select name="shop_worker_wages[0][shop_worker_id]" class="form-control ks-select" data-parent="#<?php echo $panelID; ?>" style="width: 100%">
                            <option value="0" data-id="0">Выберите сотрудника</option>
                            <?php echo $siteData->globalDatas['view::_shop/worker/list/list']; ?>
                        </select>
                    </td>
                    <td>
                        <select name="shop_worker_wages[0][worker_status_id]" class="form-control ks-select" data-parent="#<?php echo $panelID; ?>" style="width: 100%">
                            <option value="0" data-id="0">Без статуса</option>
                            <?php echo $siteData->globalDatas['view::workerstatus/list/list']; ?>
                        </select>
                    </td>
                    <td>
                        <input name="shop_worker_wages[0][wage]" class="form-control money-format" type="text" >
                    </td>
                    <td>
                        <input name="shop_worker_wages[0][is_owner]" class="form-control" type="checkbox" value="1" data-id="1">
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
            <select name="shop_worker_wages[#index#][shop_worker_id]" class="form-control ks-select" data-parent="#<?php echo $panelID; ?>" style="width: 100%">
                <option value="0" data-id="0">Выберите сотрудника</option>
                <?php echo $siteData->globalDatas['view::_shop/worker/list/list']; ?>
            </select>
        </td>
        <td>
            <select name="shop_worker_wages[#index#][worker_status_id]" class="form-control ks-select" data-parent="#<?php echo $panelID; ?>" style="width: 100%">
                <option value="0" data-id="0">Без статуса</option>
                <?php echo $siteData->globalDatas['view::workerstatus/list/list']; ?>
            </select>
        </td>
        <td>
            <input name="shop_worker_wages[#index#][wage]" class="form-control money-format" type="text" >
        </td>
        <td>
            <input name="shop_worker_wages[#index#][is_owner]" class="form-control" type="checkbox" value="1" data-id="1">
        </td>
        <td>
            <button type="button" class="close" aria-label="Close" data-action="tr-delete">
                <span aria-hidden="true" class="fa fa-close"></span>
            </button>
        </td>
    </tr>
-->
</div>