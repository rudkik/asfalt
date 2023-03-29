<?php
$time2 = date('d.m.Y',strtotime('+1 day')).' 06:00';
$time1 = date('d.m.Y',strtotime('-1 months')).' 06:00';
?>
<form id="form-filter" class="box-body no-padding padding-bottom-10px">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group" style="margin-bottom: 5px">
                        <label for="shop_daughter_id">Отправитель</label>
                        <select id="shop_daughter_id" name="shop_daughter_id" class="form-control select2" style="width: 100%;">
                            <?php $tmp = Request_RequestParams::getParamInt('shop_daughter_id'); ?>
                            <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>>Выберите значение</option>
                            <option value="0" data-id="0" <?php if($tmp == 0 && $tmp !== NULL){echo 'selected';} ?>>Без значения</option>
                            <?php
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/daughter/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group" style="margin-bottom: 5px">
                        <label for="shop_branch_daughter_id">Отправитель филиал</label>
                        <select id="shop_branch_daughter_id" name="shop_branch_daughter_id" class="form-control select2" style="width: 100%;">
                            <?php $tmp = Request_RequestParams::getParamInt('shop_branch_daughter_id'); ?>
                            <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>>Выберите значение</option>
                            <option value="0" data-id="0" <?php if($tmp == 0 && $tmp !== NULL){echo 'selected';} ?>>Без значения</option>
                            <?php
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/branch/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group" style="margin-bottom: 5px">
                        <label for="shop_subdivision_daughter_id">Отправитель подразделение</label>
                        <select id="shop_subdivision_daughter_id" name="shop_subdivision_daughter_id" class="form-control select2" style="width: 100%;">
                            <?php $tmp = Request_RequestParams::getParamInt('shop_subdivision_daughter_id'); ?>
                            <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>>Выберите значение</option>
                            <option value="0" data-id="0" <?php if($tmp == 0 && $tmp !== NULL){echo 'selected';} ?>>Без значения</option>
                            <?php
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/subdivision/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="shop_material_id">Материал</label>
                        <select id="shop_material_id" name="shop_material_id" class="form-control select2" style="width: 100%;">
                            <?php $tmp = Request_RequestParams::getParamInt('shop_material_id'); ?>
                            <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>>Выберите значение</option>
                            <option value="0" data-id="0" <?php if($tmp == 0 && $tmp !== NULL){echo 'selected';} ?>>Без значения</option>
                            <?php
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/material/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="shop_transport_company_id">Транспортная компания</label>
                        <select id="shop_transport_company_id" name="shop_transport_company_id" class="form-control select2" style="width: 100%;">
                            <?php $tmp = Request_RequestParams::getParamInt('shop_transport_company_id'); ?>
                            <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>>Выберите значение</option>
                            <option value="0" data-id="0" <?php if($tmp == 0 && $tmp !== NULL){echo 'selected';} ?>>Без значения</option>
                            <?php
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/transport/company/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Номер машины</label>
                        <input class="form-control pull-right" type="text" name="name" data-type="auto-number" value="<?php echo htmlspecialchars(Arr::path($siteData->urlParams, 'name', ''), ENT_QUOTES);?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group" style="margin-bottom: 5px">
                        <label for="shop_branch_receiver_id">Получатель филиал</label>
                        <select id="shop_branch_receiver_id" name="shop_branch_receiver_id" class="form-control select2" style="width: 100%;">
                            <?php $tmp = Request_RequestParams::getParamInt('shop_branch_receiver_id'); ?>
                            <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>>Выберите значение</option>
                            <option value="0" data-id="0" <?php if($tmp == 0 && $tmp !== NULL){echo 'selected';} ?>>Без значения</option>
                            <?php
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/branch/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group" style="margin-bottom: 5px">
                        <label for="shop_subdivision_receiver_id">Получатель подразделение</label>
                        <select id="shop_subdivision_receiver_id" name="shop_subdivision_receiver_id" class="form-control select2" style="width: 100%;">
                            <?php $tmp = Request_RequestParams::getParamInt('shop_subdivision_receiver_id'); ?>
                            <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>>Выберите значение</option>
                            <option value="0" data-id="0" <?php if($tmp == 0 && $tmp !== NULL){echo 'selected';} ?>>Без значения</option>
                            <?php
                            $tmp = 'data-id="'.$tmp.'"';
                            echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/subdivision/list/list']));
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-1-5">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Время от</label>
                        <input class="form-control pull-right" type="datetime" date-type="datetime" name="created_at_from">
                    </div>
                </div>
                <div class="col-md-1-5">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Время до</label>
                        <input class="form-control pull-right" type="datetime" date-type="datetime" name="created_at_to">
                    </div>
                </div>
                <div class="col-md-1">
                    <div hidden>
                        <?php if($siteData->branchID > 0){ ?>
                            <input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
                        <?php } ?>
                        <input name="is_weighted" value="<?php echo Func::boolToInt(Request_RequestParams::getParamBoolean('is_weighted')); ?>">

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
                        <label for="input-limit-page">Кол-во записей</label>
                        <div class="input-group" style="width: 145px;">
                            <select id="input-limit-page" name="limit_page" class="form-control select2" style="width: 100%">
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
            <?php if($siteData->operation->getIsAdmin()){ ?>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="cash_operation_id">Оператор</label>
                            <select id="cash_operation_id" name="cash_operation_id" class="form-control select2" style="width: 100%;">
                                <?php $tmp = Request_RequestParams::getParamInt('cash_operation_id'); ?>
                                <option value="-1" data-id="-1" <?php if($tmp === NULL || $tmp < 0){echo 'selected';} ?>></option>
                                <option value="0" data-id="0" <?php if($tmp == 0 && $tmp !== NULL){echo 'selected';} ?>>Без значения</option>
                                <?php
                                $tmp = 'data-id="'.$tmp.'"';
                                echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/operation/list/list']));
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</form>