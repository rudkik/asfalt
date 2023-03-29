<div class="col-md-9">
    <div class="form-horizontal box-partner-goods-edit">
        <div class="box-body">
            <?php if($siteData->branchID == 0){ ?>
            <div class="form-group">
                <label for="shop_branch_id" class="col-sm-2 control-label">Поставщик</label>
                <div class="col-sm-10">
                    <select name="shop_branch_id" class="form-control select2" id="shop_branch_id" style="width: 100%;">
                        <option value="0"></option>
                        <?php echo trim($siteData->globalDatas['view::shopbranches/list']); ?>
                    </select>
                </div>
            </div>
            <?php } ?>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-3">
                    <label>
                        <input name="is_public" <?php if ($data->values['is_public'] == 1) { echo ' value="1" checked'; }else{echo 'value="0"';} ?> data-id="1" type="checkbox" class="minimal" checked>
                        Опубликовать
                    </label>
                </div>
                <div class="col-sm-3">
                    <label>
                        <input name="good_select_type_id" <?php if ($data->values['good_select_type_id'] == 3723) { echo ' value="3723" checked'; }else{echo 'value="0"';} ?> data-id="3723" type="checkbox" class="minimal">
                        Новинка
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Название</label>
                        <div class="col-sm-10">
                            <input name="name" class="form-control" id="name" placeholder="Название товар" type="text" value="<?php echo htmlspecialchars($data->values['name'], ENT_QUOTES);?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="shop_table_unit_type_id" class="col-sm-2 control-label">Ед. измерения</label>
                        <div class="col-sm-10">
                            <select name="shop_table_unit_type_id" class="form-control select2" id="shop_table_unit_type_id" style="width: 100%;">
                                <option value="0"></option>
                                <?php echo trim($siteData->globalDatas['view::shopgoodunittypes/list']); ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="article" class="col-sm-2 control-label">Артикул</label>
                        <div class="col-sm-10">
                            <input name="article" class="form-control" id="article" placeholder="Артикул" type="text" value="<?php echo $data->values['article'];?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="barcode" class="col-sm-2 control-label">Штрихкод</label>
                        <div class="col-sm-10">
                            <input name="options[barcode]" class="form-control" id="barcode" placeholder="Штрихкод" type="text" value="<?php echo Arr::path($data->values, 'options.barcode', '');?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="shop_table_rubric_id" class="col-sm-2 control-label">Категория</label>
                <div class="col-sm-10">
                    <select name="shop_table_rubric_id" class="form-control select2" id="shop_table_rubric_id" style="width: 100%;">
                        <option value="0"></option>
                        <?php echo trim($siteData->globalDatas['view::shopgoodcatalogs/list']); ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="price_a" class="col-sm-2 control-label">Цена - А</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input name="options[price_a]" class="form-control" id="price_a" placeholder="Цена - А" type="text" value="<?php echo Func::getPrice($siteData->currency, Arr::path($data->values, 'options.price_a', ''));?>">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat" data-id="price_a" data-action="copy-price"><i class="fa fa-fw fa-calendar-plus-o"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price_b" class="col-sm-2 control-label">Цена - B</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input name="options[price_b]" class="form-control" id="price_b" placeholder="Цена - B" type="text" value="<?php echo Func::getPrice($siteData->currency, Arr::path($data->values, 'options.price_b', ''));?>">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat" data-id="price_b" data-action="copy-price"><i class="fa fa-fw fa-calendar-plus-o"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price_b_plus" class="col-sm-2 control-label">Цена - B+</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input name="options[price_b_plus]" class="form-control" id="price_b_plus" placeholder="Цена - B+" type="text" value="<?php echo Func::getPrice($siteData->currency, Arr::path($data->values, 'options.price_b_plus', ''));?>">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat" data-id="price_b_plus" data-action="copy-price"><i class="fa fa-fw fa-calendar-plus-o"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="price_c" class="col-sm-2 control-label">Цена - C</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input name="options[price_c]" class="form-control" id="price_c" placeholder="Цена - C" type="text" value="<?php echo Func::getPrice($siteData->currency, Arr::path($data->values, 'options.price_c', ''));?>">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat" data-id="price_c" data-action="copy-price"><i class="fa fa-fw fa-calendar-plus-o"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price_market" class="col-sm-2 control-label">Цена - рынки и базары</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input name="options[price_market]" class="form-control" id="price_market" placeholder="Цена - рынки и базары" type="text" value="<?php echo Func::getPrice($siteData->currency, Arr::path($data->values, 'options.price_market', ''));?>">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat" data-id="price_market" data-action="copy-price"><i class="fa fa-fw fa-calendar-plus-o"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price_horeca" class="col-sm-2 control-label">Цена - Horeca</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input name="options[price_horeca]" class="form-control" id="price_horeca" placeholder="Цена - Horeca" type="text" value="<?php echo Func::getPrice($siteData->currency, Arr::path($data->values, 'options.price_horeca', ''));?>">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-default btn-flat" data-id="price_horeca" data-action="copy-price"><i class="fa fa-fw fa-calendar-plus-o"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="info" class="col-sm-2 control-label">Описание</label>
                <div class="col-sm-10">
                    <textarea name="info" class="form-control" id="info" rows="5" placeholder="Описание"><?php echo $data->values['text'];?></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-3">
    <?php
    $view = View::factory('smmarket/sadmin/35/_addition/files');
    $view->siteData = $siteData;
    $view->data = $data;
    $view->columnSize = 12;
    echo Helpers_View::viewToStr($view);
    ?>
</div>
<div class="col-md-12">
    <div hidden>
        <input name="data_language_id" value="<?php echo $siteData->dataLanguageID; ?>">
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
        <?php } ?>
        <?php if($siteData->action != 'clone') { ?>
            <input name="id" value="<?php echo Arr::path($data->values, 'id', 0);?>">
        <?php }else{ ?>
            <input name="type" value="<?php echo $data->values['shop_table_catalog_id'];?>">
        <?php } ?>
    </div>
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
    </div>
</div>
