<div class="modal-dialog" style="max-width: 1100px;">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Данные для отчета формы 910.00</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="fa fa-close"></span>
            </button>
        </div>
        <form class="has-validation-callback" action="/tax/shoptaxreturn910/save_data">
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Сохранить зарплаты?</label>
                        <div class="col-10">
                            <input name="is_edit_wage" value="0" style="display: none">
                            <label class="ks-checkbox-slider ks-on-off ks-primary">
                                <input name="is_edit_wage" type="checkbox" value="1">
                                <span class="ks-indicator"></span>
                                <span class="ks-on">да</span>
                                <span class="ks-off">нет</span>
                            </label>
                        </div>
                    </div>
                    <div class="row">
                        <label for="number" class="col-2 col-form-label">Полугодие</label>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-5">
                                    <div class="form-group margin-0">
                                        <select name="half_year" id="<?php echo $formName; ?>-data-half_year" class="form-control ks-select" data-parent="#<?php echo $formName; ?>-data-record" style="width: 100%">
                                            <?php $halfYear = Arr::path($data->values, 'half_year', 1); ?>
                                            <option value="1" data-id="1"<?php if($halfYear == 1){echo ' selected';}?>>Первое полугодие</option>
                                            <option value="2" data-id="2"<?php if($halfYear == 2){echo ' selected';}?>>Второе полугодие</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                        <label for="date" class="col-3 col-form-label">Год</label>
                                        <div class="col-9">
                                            <div class="form-group margin-0">
                                                <input name="year" data-validation="length" class="form-control" placeholder="Год" id="year" type="text" value="<?php echo Arr::path($data->values, 'year', date('Y')); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="<?php echo $formName; ?>-data-revenue" class="col-2 col-form-label">Доход</label>
                        <div class="col-10">
                            <input name="revenue" data-validation="length" class="form-control money-format" placeholder="Доход" id="revenue" type="text" value="<?php echo Arr::path($data->values, 'revenue', 0); ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="<?php echo $formName; ?>-data-tax_view_id" class="col-2 col-form-label">Вид декларации</label>
                        <div class="col-10">
                            <select name="tax_view_id" id="<?php echo $formName; ?>-data-record-tax_view_id" class="form-control ks-select" data-parent="#<?php echo $formName; ?>-data-record" style="width: 100%">
                                <?php echo $siteData->globalDatas['view::tax-view/list/list']; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-form-label text-left">Заработная плата для <b>владельца ИП</b> за отчетный период</label>
                    </div>
                    <div id="<?php echo $formName; ?>-data-wages-owner"  class="form-group row">
                        <?php echo $siteData->globalDatas['view::_shop/worker/wage/list/six-month-owner']; ?>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-form-label text-left">Заработная плата для <b>сотрудников</b> за отчетный период</label>
                    </div>
                    <div id="<?php echo $formName; ?>-data-wages"  class="form-group row">
                        <?php echo $siteData->globalDatas['view::_shop/worker/wage/list/six-month']; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input name="id" value="<?php echo Arr::path($data->values, 'id', 0); ?>" style="display: none">
                <button type="button" class="btn btn-primary-outline ks-light" data-dismiss="modal">Закрыть</button>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        __initTable();

        $('#<?php echo $formName; ?>-data-record form select[name="half_year"], #<?php echo $formName; ?>-data-record form input[name="year"]').change(function () {
            var half_year = $('#<?php echo $formName; ?>-data-record form select[name="half_year"]').val();
            var year = $('#<?php echo $formName; ?>-data-record form input[name="year"]').val();

            jQuery.ajax({
                url: '/tax/shopworkerwage/six_month',
                data: ({
                    'half_year': (half_year),
                    'year': (year),
                    'is_owner': (0),
                }),
                type: "POST",
                success: function (data) {
                    $('#<?php echo $formName; ?>-data-wages').html(data);
                    __initTr();
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });


            jQuery.ajax({
                url: '/tax/shopworkerwage/six_month',
                data: ({
                    'half_year': (half_year),
                    'year': (year),
                    'is_owner': (1),
                }),
                type: "POST",
                success: function (data) {
                    $('#<?php echo $formName; ?>-data-wages-owner').html(data);
                    __initTr();
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });

            jQuery.ajax({
                    url: '/tax/shopinvoicecommercial/get_amount',
                    data: ({
                        'half_year': (half_year),
                        'year': (year),
                    }),
                    type: "POST",
                    success: function (data) {
                        $('#<?php echo $formName; ?>-data-record input[name="revenue"]').val(data).trigger('change');
                },
                error: function (data) {
                console.log(data.responseText);
            }
            });
        });
    });
</script>