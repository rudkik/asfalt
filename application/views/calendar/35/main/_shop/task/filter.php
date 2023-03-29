<form id="form-filter" class="box-body no-padding padding-bottom-10px">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="name">Диапазон</label>
                        <div id="period" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                        <input id="period_from" name="period_from" style="display: none" value="<?php echo Request_RequestParams::getParamDate('period_from') ;?>">
                        <input id="period_to" name="period_to" style="display: none" value="<?php echo Request_RequestParams::getParamDate('period_to') ;?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="name">Project</label>
                        <input id="name" class="form-control" name="name" placeholder="Project" value="<?php echo htmlspecialchars(Arr::path($siteData->urlParams, 'name', ''), ENT_QUOTES);?>" type="text">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="name">Product</label>
                        <select id="shop_product_id" name="shop_product_id" class="form-control select2" data-type="select2" style="width: 100%;">
                            <option value="-1" data-id="-1">Выберите</option>
                            <?php
                            $tmp = Request_RequestParams::getParamInt('shop_product_id');
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/product/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="name">Category</label>
                        <select id="shop_rubric_id" name="shop_rubric_id" class="form-control select2" data-type="select2" style="width: 100%;">
                            <option value="-1" data-id="-1">Выберите</option>
                            <?php
                            $tmp = Request_RequestParams::getParamInt('shop_rubric_id');
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/rubric/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="name">Partner</label>
                        <select id="shop_partner_id" name="shop_partner_id" class="form-control select2" data-type="select2" style="width: 100%;">
                            <option value="-1" data-id="-1">Выберите</option>
                            <?php
                            $tmp = Request_RequestParams::getParamInt('shop_partner_id');
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/partner/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="name">Result</label>
                        <select id="shop_result_id" name="shop_result_id" class="form-control select2" data-type="select2" style="width: 100%;">
                            <option value="-1" data-id="-1">Выберите</option>
                            <?php
                            $tmp = Request_RequestParams::getParamInt('shop_result_id');
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/result/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div style="margin-top: 26px;">
                        <button data-action="calc" type="button" class="btn bg-primary btn-flat" style="margin-right: 15px;"><i class="fa fa-fw fa-calculator"></i> Посчитать</button>
                        <label id="calc" style="font-size: 19px;"></label>
                    </div>
                    <div hidden>
                        <?php if($siteData->branchID > 0){ ?>
                            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
                        <?php } ?>
                        <input name="is_edit" value="<?php echo Request_RequestParams::getParamBoolean('is_edit'); ?>">

                        <?php if(Arr::path($siteData->urlParams, 'is_public', '') == 1){?>
                            <input id="input-status" name="is_public" value="1">
                        <?php }elseif(Arr::path($siteData->urlParams, 'is_not_public', '') == 1){?>
                            <input id="input-status" name="is_not_public" value="1">
                        <?php }elseif(Arr::path($siteData->urlParams, 'is_delete', '') == 1){?>
                            <input id="input-status" name="is_delete" value="1">
                        <?php }else{?>
                            <input id="input-status" name="" value="1">
                        <?php }?>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group pull-right">
                        <label for="exampleInputEmail1">Кол-во записей</label>
                        <div class="input-group">
                            <select data-type="select2" id="input-limit-page" name="limit_page" class="form-control select2" style="width: 100%">
                                <?php $tmp = Request_RequestParams::getParamInt('limit_page'); ?>
                                <option value="25" <?php if(($tmp === NULL) || ($tmp == 25)){echo 'selected';} ?>>25</option>
                                <option value="50" <?php if($tmp == 50){echo 'selected';} ?>>50</option>
                                <option value="100" <?php if($tmp == 100){echo 'selected';} ?>>100</option>
                                <option value="200" <?php if($tmp == 200){echo 'selected';} ?>>200</option>
                                <option value="500" <?php if($tmp == 500){echo 'selected';} ?>>500</option>
                                <option value="1000" <?php if($tmp == 1000){echo 'selected';} ?>>1000</option>
                                <option value="5000" <?php if($tmp == 5000){echo 'selected';} ?>>5000</option>
                            </select>
                            <span class="input-group-btn">
							<button type="submit" class="btn bg-orange btn-flat"><i class="fa fa-fw fa-search"></i> Поиск</button>
						</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    $('[data-action="calc"]').click(function () {
        jQuery.ajax({
            url: '/calendar/shoptask/calc',
            data: $('#form-filter').serialize(),
            type: "POST",
            success: function (data) {
                $('#calc').html(Intl.NumberFormat('ru-RU', {maximumFractionDigits: 2}).format(data).replace(',', '.'));
            },
            error: function (data) {
                console.log(data.responseText);
            }
        });

    });

</script>