<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">Фильтр</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>
	<form id="form-filter" class="box-body no-padding padding-b-10">
		<div class="col-md-12">
			<div class="row">
                <div class="col-md-4 filter-input">
                    <div class="form-group">
                        <span for="input-name"  class="col-md-4 control-label">Дата от</span>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input id="input-name" class="form-control" name="created_at_from" value="<?php echo Arr::path($siteData->urlParams, 'created_at_from', '');?>" type="datetime">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-fw fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 filter-input">
                    <div class="form-group">
                        <span for="input-name"  class="col-md-4 control-label">Дата до</span>
                        <div class="col-md-8">
                            <div class="input-group">
                                <input id="input-name" class="form-control" name="created_at_to"  value="<?php echo Arr::path($siteData->urlParams, 'created_at_to', '');?>" type="datetime">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-fw fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (Func::isShopMenu('shopbill/shop_root_id?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                    <div class="col-md-4 filter-input">
                        <div class="form-group">
                            <span for="input-rubric" class="col-md-4 control-label"><?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.shop_root_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></span>
                            <div class="col-md-8">
                                <div class="input-group input-group-select">
                                    <select id="input-rubric" name="shop_root_id" class="form-control select2" style="width: 100%;">
                                        <?php $tmp = Request_RequestParams::getParamInt('shop_root_id'); ?>
                                        <option value="-1" data-id="-1" <?php if($tmp === NULL){echo 'selected';} ?>></option>
                                        <option value="0" data-id="0" <?php if($tmp === 0){echo 'selected';} ?>>Без значения</option>
                                        <?php
                                        $tmp = 'data-id="'.$tmp.'"';
                                        echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/branch/list/list']));
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-md-4 filter-input">
                    <div class="form-group">
                        <span for="input-rubric" class="col-md-4 control-label"><?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.create_user_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></span>
                        <div class="col-md-8">
                            <div class="input-group input-group-select">
                                <select id="input-rubric" name="create_user_id" class="form-control select2" style="width: 100%;">
                                    <?php $tmp = Request_RequestParams::getParamInt('create_user_id'); ?>
                                    <option value="-1" data-id="-1" <?php if($tmp === NULL){echo 'selected';} ?>></option>
                                    <option value="0" data-id="0" <?php if($tmp === 0){echo 'selected';} ?>>Без значения</option>
                                    <?php
                                    $tmp = 'data-id="'.$tmp.'"';
                                    echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/operation/list/list']));
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (Func::isShopMenu('shopbill/shop_bill_status_id?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                    <div class="col-md-4 filter-input">
                        <div class="form-group">
                            <span for="input-rubric" class="col-md-4 control-label"><?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.shop_bill_status_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></span>
                            <div class="col-md-8">
                                <div class="input-group input-group-select">
                                    <select id="input-rubric" name="shop_bill_status_id" class="form-control select2" style="width: 100%;">
                                        <?php $tmp = Request_RequestParams::getParamInt('shop_bill_status_id'); ?>
                                        <option value="-1" data-id="-1" <?php if($tmp === NULL){echo 'selected';} ?>></option>
                                        <option value="0" data-id="0" <?php if($tmp === 0){echo 'selected';} ?>>Без значения</option>
                                        <?php
                                        $tmp = 'data-id="'.$tmp.'"';
                                        echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/bill/status/list/list']));
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (Func::isShopMenu('shopbill/shop_paid_type_id?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                    <div class="col-md-4 filter-input">
                        <div class="form-group">
                            <span for="input-rubric" class="col-md-4 control-label"><?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.shop_paid_type_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></span>
                            <div class="col-md-8">
                                <div class="input-group input-group-select">
                                    <select id="input-rubric" name="shop_paid_type_id" class="form-control select2" style="width: 100%;">
                                        <?php $tmp = Request_RequestParams::getParamInt('shop_paid_type_id'); ?>
                                        <option value="-1" data-id="-1" <?php if($tmp === NULL){echo 'selected';} ?>></option>
                                        <option value="0" data-id="0" <?php if($tmp === 0){echo 'selected';} ?>>Без значения</option>
                                        <?php
                                        $tmp = 'data-id="'.$tmp.'"';
                                        echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/paidtype/list/list']));
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (Func::isShopMenu('shopbill/shop_delivery_type_id?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                    <div class="col-md-4 filter-input">
                        <div class="form-group">
                            <span for="input-rubric" class="col-md-4 control-label"><?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.shop_delivery_type_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></span>
                            <div class="col-md-8">
                                <div class="input-group input-group-select">
                                    <select id="input-rubric" name="shop_delivery_type_id" class="form-control select2" style="width: 100%;">
                                        <?php $tmp = Request_RequestParams::getParamInt('shop_delivery_type_id'); ?>
                                        <option value="-1" data-id="-1" <?php if($tmp === NULL){echo 'selected';} ?>></option>
                                        <option value="0" data-id="0" <?php if($tmp === 0){echo 'selected';} ?>>Без значения</option>
                                        <?php
                                        $tmp = 'data-id="'.$tmp.'"';
                                        echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/deliverytype/list/list']));
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (Func::isShopMenu('shopbill/shop_coupon_id?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                    <div class="col-md-4 filter-input">
                        <div class="form-group">
                            <span for="input-rubric" class="col-md-4 control-label"><?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.shop_coupon_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></span>
                            <div class="col-md-8">
                                <div class="input-group input-group-select">
                                    <select id="input-rubric" name="shop_coupon_id" class="form-control select2" style="width: 100%;">
                                        <?php $tmp = Request_RequestParams::getParamInt('shop_coupon_id'); ?>
                                        <option value="-1" data-id="-1" <?php if($tmp === NULL){echo 'selected';} ?>></option>
                                        <option value="0" data-id="0" <?php if($tmp === 0){echo 'selected';} ?>>Без значения</option>
                                        <?php
                                        $tmp = 'data-id="'.$tmp.'"';
                                        echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::_shop/coupon/list/list']));
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (Func::isShopMenu('shopbill/country_id?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                    <div class="col-md-4 filter-input">
                        <div class="form-group">
                            <span for="input-rubric" class="col-md-4 control-label"><?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.country_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></span>
                            <div class="col-md-8">
                                <div class="input-group input-group-select">
                                    <select id="input-rubric" name="country_id" class="form-control select2" style="width: 100%;">
                                        <?php $tmp = Request_RequestParams::getParamInt('country_id'); ?>
                                        <option value="-1" data-id="-1" <?php if($tmp === NULL){echo 'selected';} ?>></option>
                                        <option value="0" data-id="0" <?php if($tmp === 0){echo 'selected';} ?>>Без значения</option>
                                        <?php
                                        $tmp = 'data-id="'.$tmp.'"';
                                        echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::country/list/list']));
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if (Func::isShopMenu('shopbill/city_id?type='.Request_RequestParams::getParamInt('type'), $siteData)){ ?>
                    <div class="col-md-4 filter-input">
                        <div class="form-group">
                            <span for="input-rubric" class="col-md-4 control-label"><?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.city_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></span>
                            <div class="col-md-8">
                                <div class="input-group input-group-select">
                                    <select id="input-rubric" name="city_id" class="form-control select2" style="width: 100%;">
                                        <?php $tmp = Request_RequestParams::getParamInt('city_id'); ?>
                                        <option value="-1" data-id="-1" <?php if($tmp === NULL){echo 'selected';} ?>></option>
                                        <option value="0" data-id="0" <?php if($tmp === 0){echo 'selected';} ?>>Без значения</option>
                                        <?php
                                        $tmp = 'data-id="'.$tmp.'"';
                                        echo trim(str_replace($tmp, $tmp.' selected', $siteData->replaceDatas['view::city/list/list']));
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="row margin-t-15">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Выберите группировки</label>
                        <select name="group_by[]" class="form-control select2" multiple="multiple" data-placeholder="Выберите группировки" style="width: 100%;">
                            <?php $groupBy = Request_RequestParams::getParamArray('group_by', array(), array()); ?>
                            <?php if ((Func::isShopMenu('shopbill/shop_root_id?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
                                <option value="shop_root_id" data-id="shop_root_id" <?php if((array_search('shop_root_id', $groupBy) !== FALSE)){echo 'selected'; }?>><?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.shop_root_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></option>
                            <?php }?>
                            <?php if ((Func::isShopMenu('shopbill/shop_bill_status_id?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
                                <option value="shop_bill_status_id" data-id="shop_bill_status_id" <?php if((array_search('shop_bill_status_id', $groupBy) !== FALSE)){echo 'selected'; }?>><?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.shop_bill_status_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></option>
                            <?php }?>
                            <?php if ((Func::isShopMenu('shopbill/shop_paid_type_id?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
                                <option value="shop_paid_type_id" data-id="shop_paid_type_id" <?php if((array_search('shop_paid_type_id', $groupBy) !== FALSE)){echo 'selected'; }?>><?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.shop_paid_type_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></option>
                            <?php }?>
                            <?php if ((Func::isShopMenu('shopbill/shop_delivery_type_id?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
                                <option value="shop_delivery_type_id" data-id="shop_delivery_type_id" <?php if((array_search('shop_delivery_type_id', $groupBy) !== FALSE)){echo 'selected'; }?>><?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.shop_delivery_type_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></option>
                            <?php }?>
                            <?php if ((Func::isShopMenu('shopbill/shop_coupon_id?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
                                <option value="shop_coupon_id" data-id="shop_coupon_id" <?php if((array_search('shop_coupon_id', $groupBy) !== FALSE)){echo 'selected'; }?>><?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.shop_coupon_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></option>
                            <?php }?>
                            <?php if ((Func::isShopMenu('shopbill/country_id?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
                                <option value="country_id" data-id="country_id" <?php if((array_search('country_id', $groupBy) !== FALSE)){echo 'selected'; }?>><?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.country_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></option>
                            <?php }?>
                            <?php if ((Func::isShopMenu('shopbill/city_id?type='.Request_RequestParams::getParamInt('type'), $siteData))){ ?>
                                <option value="city_id" data-id="city_id" <?php if((array_search('city_id', $groupBy) !== FALSE)){echo 'selected'; }?>><?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.city_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></option>
                            <?php }?>
                            <option value="create_user_id" data-id="create_user_id" <?php if((array_search('create_user_id', $groupBy) !== FALSE)){echo 'selected'; }?>><?php echo SitePageData::setPathReplace('type.form_data.shop_bill.fields_title.create_user_id', SitePageData::CASE_FIRST_LETTER_UPPER); ?></option>

                            <option value="created_at_date" data-id="created_at_date" disabled="disabled">Период</option>
                            <option value="created_at_date" data-id="created_at_date" <?php if((array_search('created_at_date', $groupBy) !== FALSE)){echo 'selected'; }?>>По дням</option>
                            <option value="created_at_month" data-id="created_at_month" <?php if((array_search('created_at_month', $groupBy) !== FALSE)){echo 'selected'; }?>>По месяцам</option>
                            <option value="created_at_year" data-id="created_at_year" <?php if((array_search('created_at_year', $groupBy) !== FALSE)){echo 'selected'; }?>>По годам</option>
                        </select>
                    </div>
                </div>
            </div>
		</div>
		<div class="col-md-12 margin-t-15">
			<div class="row filter-search">
				<div class="col-md-7 filter-input filter-limit">
					<div class="form-group">
						<span for="input-limit-page"  class="col-md-7 control-label">Кол-во записей</span>
						<div class="col-md-5">
							<div class="input-group">
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
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-1">
					<div hidden>
						<?php if($siteData->branchID > 0){ ?>
							<input name="shop_branch_id" value="<?php echo $siteData->branchID; ?>">
						<?php } ?>
						<input name="type" value="<?php echo intval(Request_RequestParams::getParamInt('type')); ?>">

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

					<button id="search-button" type="submit" class="btn btn-primary"><i class="fa fa-fw fa-search"></i> Поиск</button>
				</div>
			</div>
		</div>
	</form>
</div>