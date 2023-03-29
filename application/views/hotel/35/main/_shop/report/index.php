<div id="report-index-record" class="modal-edit">
    <div class="modal-dialog" style="margin: 0px; max-width: 1200px">
        <div class="modal-content" style="border: none">
            <div class="modal-body">
                <div class="container-fluid">
                    <form class="has-validation-callback" action="/hotel/shopexcel/rooms_clients">
                        <h4>Отчет 1 Календарь бронирования в Excel</h4>
                        <div class="row">
                            <label for="period_from" class="col-2 col-form-label">Дата от</label>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group margin-0">
                                            <input name="period_from" class="form-control" id="period_from" type="datetime">
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="row">
                                            <label for="period_to" class="col-4 col-form-label">Дата до</label>
                                            <div class="col-8">
                                                <div class="form-group margin-0">
                                                    <input name="period_to" class="form-control"  id="period_to" type="datetime">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary">Создать</button>
                            </div>
                        </div>
                    </form>
                    <form class="has-validation-callback" action="/hotel/shopexcel/payments">
                        <h4>Отчет 2 Предоплаты по брони в Excel</h4>
                        <div class="row">
                            <label for="period_to" class="col-2 col-form-label">Клиент</label>
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group margin-0">
                                            <input data-client="#report-index-shop_client_id-payments" class="form-control clients typeahead" placeholder="Клиент" type="text">
                                            <input id="report-index-shop_client_id-payments" value="-1" name="shop_client_id" style="display: none">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row">
                                            <label for="period_from-payments" class="col-4 col-form-label">Дата от</label>
                                            <div class="col-8">
                                                <div class="form-group margin-0">
                                                    <input name="period_from" class="form-control" id="period_from-payments" type="datetime">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="row">
                                            <label for="period_to-payments" class="col-3 col-form-label">Дата до</label>
                                            <div class="col-9">
                                                <div class="form-group margin-0">
                                                    <input name="period_to" class="form-control"  id="period_to-payments" type="datetime">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary">Создать</button>
                            </div>
                        </div>
                    </form>
                    <form class="has-validation-callback" action="/hotel/shopexcel/cash_book">
                        <h4>Отчет 3 Кассовая книга в Excel</h4>
                        <div class="row">
                            <label for="created_at_from" class="col-2 col-form-label">Дата от</label>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group margin-0">
                                            <input name="created_at_from" class="form-control" id="created_at_from" type="datetime" value="<?php echo date('d.m.Y',strtotime('-1 day')); ?>">
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="row">
                                            <label for="created_at_to" class="col-4 col-form-label">Дата до</label>
                                            <div class="col-8">
                                                <div class="form-group margin-0">
                                                    <input name="created_at_to" class="form-control"  id="created_at_to" type="datetime" value="<?php echo date('d.m.Y'); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row">
                                    <label for="sheet_number" class="col-6 col-form-label">Номер листа</label>
                                    <div class="col-6">
                                        <div class="form-group margin-0">
                                            <input name="sheet_number" class="form-control" id="sheet_number" type="text" value="1">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary">Создать</button>
                            </div>
                        </div>
                    </form>
                    <form class="has-validation-callback" action="/hotel/shopexcel/act_check">
                        <h4>Отчет 4 Акт сверки по клиенту Excel</h4>
                        <div class="row">
                            <label for="period_to" class="col-2 col-form-label">Клиент</label>
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group margin-0">
                                            <input data-client="#report-index-shop_client_id-act_check" class="form-control clients typeahead" placeholder="Клиент" type="text" required>
                                            <input id="report-index-shop_client_id-act_check" value="-1" name="shop_client_id" style="display: none">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row">
                                            <label for="created_at_from" class="col-4 col-form-label">Дата от</label>
                                            <div class="col-8">
                                                <div class="form-group margin-0">
                                                    <input name="created_at_from" class="form-control" id="created_at_from" type="datetime">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="row">
                                            <label for="created_at_to" class="col-3 col-form-label">Дата до</label>
                                            <div class="col-9">
                                                <div class="form-group margin-0">
                                                    <input name="created_at_to" class="form-control"  id="created_at_to" type="datetime">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <button id="act_check-button" type="submit" class="btn btn-primary" disabled>Создать</button>
                            </div>
                        </div>
                    </form>
                    <form class="has-validation-callback" action="/hotel/shopexcel/act_check_group_client">
                        <h4>Отчет 5 Акт сверки по контрагенту 1С покупатель Кара Дала в Excel</h4>
                        <div class="row">
                            <label for="created_at_from" class="col-2 col-form-label">Дата от</label>
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group margin-0">
                                            <input name="created_at_from" class="form-control" id="created_at_from" type="datetime">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row">
                                            <label for="created_at_to" class="col-4 col-form-label">Дата до</label>
                                            <div class="col-8">
                                                <div class="form-group margin-0">
                                                    <input name="created_at_to" class="form-control"  id="created_at_to" type="datetime">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary">Создать</button>
                            </div>
                        </div>
                    </form>
                    <form class="has-validation-callback" action="/hotel/shopexcel/payments_finish_bill">
                        <h4>Отчет 6 По завершенным броням в Excel</h4>
                        <div class="row">
                            <label for="period_from" class="col-2 col-form-label">Дата от</label>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group margin-0">
                                            <input name="period_from" class="form-control" id="period_from" type="datetime">
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="row">
                                            <label for="period_to" class="col-4 col-form-label">Дата до</label>
                                            <div class="col-8">
                                                <div class="form-group margin-0">
                                                    <input name="period_to" class="form-control"  id="period_to" type="datetime">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary">Создать</button>
                            </div>
                        </div>
                    </form>
                    <?php if ($siteData->operation->getShopTableRubricID() != 2){ ?>
                        <form class="has-validation-callback" action="/hotel/shopexcel/bills_not_finish">
                            <h4>Отчет 7 Задолженность АБ1 в Excel</h4>
                            <div class="row">
                                <label for="date" class="col-2 col-form-label">Текущая дата</label>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="form-group margin-0">
                                                <input name="date" class="form-control" id="date" type="datetime" value="<?php echo date('d.m.Y'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Создать</button>
                                </div>
                            </div>
                        </form>
                        <form class="has-validation-callback" action="/hotel/shopexcel/beds_busy">
                            <h4>Отчет 8 Занятость номеров в Excel</h4>
                            <div class="row">
                                <label for="period_from" class="col-2 col-form-label">Дата от</label>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="form-group margin-0">
                                                <input name="period_from" class="form-control" id="period_from" type="datetime">
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="row">
                                                <label for="period_to" class="col-4 col-form-label">Дата до</label>
                                                <div class="col-8">
                                                    <div class="form-group margin-0">
                                                        <input name="period_to" class="form-control"  id="period_to" type="datetime">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Создать</button>
                                </div>
                            </div>
                        </form>
                        <form class="has-validation-callback" action="/hotel/shopexcel/payments_paid_type">
                            <h4>Отчет 9 По типам оплат в Excel</h4>
                            <div class="row">
                                <label for="period_from" class="col-2 col-form-label">Дата от</label>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="form-group margin-0">
                                                <input name="period_from" class="form-control" id="period_from" type="datetime">
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="row">
                                                <label for="period_to" class="col-4 col-form-label">Дата до</label>
                                                <div class="col-8">
                                                    <div class="form-group margin-0">
                                                        <input name="period_to" class="form-control"  id="period_to" type="datetime">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label for="date" class="col-2 col-form-label">Тип оплаты</label>
                                <div class="col-6">
                                    <select name="shop_paid_type_id" id="room-edit-shop_paid_type_id" class="form-control ks-select" data-parent="#report-index-record" style="width: 100%">
                                        <option value="-1" data-id="-1">Выберите способ оплаты</option>
                                        <?php echo $siteData->globalDatas['view::_shop/paid-type/list/list']; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Создать</button>
                                </div>
                            </div>
                        </form>
                        <form class="has-validation-callback" action="/hotel/shopexcel/refunds">
                            <h4>Отчет 10 по возвратам в Excel</h4>
                            <div class="row">
                                <label for="period_from" class="col-2 col-form-label">Дата от</label>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="form-group margin-0">
                                                <input name="period_from" class="form-control" id="period_from" type="datetime">
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="row">
                                                <label for="period_to" class="col-4 col-form-label">Дата до</label>
                                                <div class="col-8">
                                                    <div class="form-group margin-0">
                                                        <input name="period_to" class="form-control"  id="period_to" type="datetime">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Создать</button>
                                </div>
                            </div>
                        </form>
                        <form class="has-validation-callback" action="/hotel/shopexcel/income_expected">
                            <h4>Отчет 11 По ожидаемой реализации в Excel</h4>
                            <div class="row">
                                <label for="period_from" class="col-2 col-form-label">Дата от</label>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="form-group margin-0">
                                                <input name="period_from" class="form-control" id="period_from" type="datetime">
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="row">
                                                <label for="period_to" class="col-4 col-form-label">Дата до</label>
                                                <div class="col-8">
                                                    <div class="form-group margin-0">
                                                        <input name="period_to" class="form-control"  id="period_to" type="datetime">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Создать</button>
                                </div>
                            </div>
                        </form>
                        <form class="has-validation-callback" action="/hotel/shopexcel/income_finish">
                            <h4>Отчет 12 По реализации номеров в Excel</h4>
                            <div class="row">
                                <label for="period_from" class="col-2 col-form-label">Дата от</label>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="form-group margin-0">
                                                <input name="period_from" class="form-control" id="period_from" type="datetime">
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="row">
                                                <label for="period_to" class="col-4 col-form-label">Дата до</label>
                                                <div class="col-8">
                                                    <div class="form-group margin-0">
                                                        <input name="period_to" class="form-control"  id="period_to" type="datetime">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Создать</button>
                                </div>
                            </div>
                        </form>
                        <form class="has-validation-callback" action="/hotel/shopexcel/addition_room_busy">
                            <h4>Отчет 13 По занятым дополнительным местам в Excel</h4>
                            <div class="row">
                                <label for="period_from" class="col-2 col-form-label">Дата от</label>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="form-group margin-0">
                                                <input name="period_from" class="form-control" id="period_from" type="datetime">
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="row">
                                                <label for="period_to" class="col-4 col-form-label">Дата до</label>
                                                <div class="col-8">
                                                    <div class="form-group margin-0">
                                                        <input name="period_to" class="form-control"  id="period_to" type="datetime">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Создать</button>
                                </div>
                            </div>
                        </form>


                        <form class="has-validation-callback" action="/hotel/shopexcel/clients_coming_expense">
                            <h4>Приход и расход по клиентам в Excel</h4>
                            <div class="row">
                                <label for="created_at_from" class="col-2 col-form-label">Дата от</label>
                                <div class="col-10">
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-group margin-0">
                                                <input name="created_at_from" class="form-control" id="created_at_from" type="datetime">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="row">
                                                <label for="created_at_to" class="col-4 col-form-label">Дата до</label>
                                                <div class="col-8">
                                                    <div class="form-group margin-0">
                                                        <input name="created_at_to" class="form-control"  id="created_at_to" type="datetime">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="row">
                                                <label for="period_to" class="col-3 col-form-label">Клиент</label>
                                                <div class="col-9">
                                                    <div class="form-group margin-0">
                                                        <input data-client="#report-index-shop_client_id-clients_coming_expense" class="form-control clients typeahead" placeholder="Клиент" type="text">
                                                        <input id="report-index-shop_client_id-clients_coming_expense" value="-1" name="shop_client_id" style="display: none">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Создать</button>
                                </div>
                            </div>
                        </form>
                        <form class="has-validation-callback" action="/hotel/shopxml/save_payment">
                            <h4>Приходники в XML</h4>
                            <div class="row">
                                <label for="created_at_from" class="col-2 col-form-label">Дата от</label>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="form-group margin-0">
                                                <input name="created_at_from" class="form-control" id="date_from" type="datetime">
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="row">
                                                <label for="created_at_to" class="col-4 col-form-label">Дата до</label>
                                                <div class="col-8">
                                                    <div class="form-group margin-0">
                                                        <input name="created_at_to" class="form-control"  id="date_to" type="datetime">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Создать</button>
                                </div>
                            </div>
                        </form>
                        <form class="has-validation-callback" action="/hotel/shopxml/save_act_service">
                            <h4>Акты выполненных работ в XML</h4>
                            <div class="row">
                                <label for="created_at_from" class="col-2 col-form-label">Дата от</label>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="form-group margin-0">
                                                <input name="created_at_from" class="form-control" id="created_at_from" type="datetime">
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="row">
                                                <label for="created_at_to" class="col-4 col-form-label">Дата до</label>
                                                <div class="col-8">
                                                    <div class="form-group margin-0">
                                                        <input name="created_at_to" class="form-control"  id="created_at_to" type="datetime">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Создать</button>
                                </div>
                            </div>
                        </form>
                        <form class="has-validation-callback" action="/hotel/shopxml/save_consumable">
                            <h4>Расходники в XML</h4>
                            <div class="row">
                                <label for="created_at_from" class="col-2 col-form-label">Дата от</label>
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-5">
                                            <div class="form-group margin-0">
                                                <input name="created_at_from" class="form-control" id="created_at_from" type="datetime">
                                            </div>
                                        </div>
                                        <div class="col-7">
                                            <div class="row">
                                                <label for="created_at_to" class="col-4 col-form-label">Дата до</label>
                                                <div class="col-8">
                                                    <div class="form-group margin-0">
                                                        <input name="created_at_to" class="form-control"  id="created_at_to" type="datetime">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Создать</button>
                                </div>
                            </div>
                        </form>
                        <form class="has-validation-callback" action="/hotel/shopxml/load_payment">
                            <h4>Загрузить оплаты из 1С</h4>
                            <div class="row">
                                <label for="created_at_from" class="col-2 col-form-label">Файл</label>
                                <div class="col-6">
                                    <div class="form-group margin-0">
                                        <div class="file-upload" data-text="Выберите файл">
                                            <input type="file" name="file">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary">Загрузить</button>
                                </div>
                            </div>
                        </form>
                    <?php } ?>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#report-index-shop_client_id-act_check').change(function(){
            if (Number($(this).val()) > 0){
                $('#act_check-button').removeAttr('disabled');
            }else{
                $('#act_check-button').attr('disabled', '');
            }
        });
        $('#report-index-record input[type="datetime"]').datetimepicker({
            dayOfWeekStart : 1,
            lang:'ru',
            format:	'd.m.Y',
            timepicker:false,
        });
        $('#report-index-record form[data-action="submit"]').on('submit', function(e){
            e.preventDefault();
            var $that = $(this),
                formData = new FormData($that.get(0)); // создаем новый экземпляр объекта и передаем ему нашу форму (*)
            url = $(this).attr('action')+'?json=1';

            jQuery.ajax({
                url: url,
                data: formData,
                type: "POST",
                contentType: false, // важно - убираем форматирование данных по умолчанию
                processData: false, // важно - убираем преобразование строк по умолчанию
                success: function (data) {
                    var obj = jQuery.parseJSON($.trim(data));
                    if (!obj.error) {
                        $.notify("Запись сохранена");
                    }
                },
                error: function (data) {
                    console.log(data.responseText);
                }
            });

            return false;
        });
        $.validate({
            modules : 'location, date, security, file',
            lang: 'ru',
            onModulesLoaded : function() {

            }
        });
    });
</script>

