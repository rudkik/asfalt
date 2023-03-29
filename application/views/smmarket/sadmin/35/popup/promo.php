<div id="find-promo" class="modal fade bs-example-modal-lg in" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg select-goods">
        <div class="modal-content">
            <div class="box box-success margin-bottom-5px">
                <div class="box-header with-border">
                    <h3 class="box-title">Выберите товар</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-fw fa-close" style="font-size: 13px"></i></button>
                    </div>
                </div>
                <div id="find-goods-id" class="box-body">
                    <div class="col-md-12 padding-top-5px">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Категория</label>
                                    <select name="shop_table_rubric_id" class="form-control select2" style="width: 100%;">
                                        <option value="-1" data-id="-1"></option>
                                        <option value="0" data-id="0">Без рубрик</option>
                                        <?php echo $siteData->globalDatas['view::shopgoodcatalogs/list']; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Название</label>
                                    <input id="input-name" name="name"  class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-md-6 margin-top-25px">
                                <div class="row filter-search">
                                    <div class="col-md-7 filter-input filter-limit">
                                        <div class="form-group">
                                            <span for="input-limit-page"  class="col-md-7 control-label">Кол-во записей</span>
                                            <div class="col-md-5">
                                                <div class="input-group">
                                                    <select id="input-limit-page" name="limit_page" class="form-control select2" style="width: 100%">
                                                        <option value="25">25</option>
                                                        <option value="50">50</option>
                                                        <option value="100">100</option>
                                                        <option value="200">200</option>
                                                        <option value="500">500</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div hidden>
                                            <?php if($siteData->branchID > 0){ ?>
                                                <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
                                            <?php } ?>
                                            <input name="type" value="3722">
                                        </div>

                                        <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-search"></i> Поиск</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <section id="result-goods" class="content padding-top-5px">
                <table class="table table-hover table-green">
                    <thead>
                    <tr>
                        <th class="tr-header-number">Запуск</th>
                        <th class="tr-header-number">Новинки</th>
                        <th class="tr-header-id">ID</th>
                        <th colspan="2" style="min-width: 200px">Товар</th>
                        <th class="tr-header-amount">Цена</th>
                        <th class="tr-header-rubric">Категория</th>
                        <th class="tr-header-buttom-vertical"></th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </section>
        </div>
    </div>
</div>