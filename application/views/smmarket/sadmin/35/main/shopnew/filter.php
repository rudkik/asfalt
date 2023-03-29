<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">Фильтр</h3>
		<div class="box-tools pull-right">
			<button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
		</div>
	</div>
	<form class="box-body no-padding padding-bottom-10px">
		<div class="col-md-12">
			<div class="row">
				<?php if ((Func::isShopMenu('shopnewrubric/index-all', array(), $siteData))
				|| ((Request_RequestParams::getParamInt('type') > 0) && (Func::isShopMenu('shopnewrubric/index?type='.Request_RequestParams::getParamInt('type'), array(), $siteData)))){ ?>
                    <div class="col-md-4 filter-input">
                        <div class="form-group">
                            <span for="input-rubric" class="col-md-4 control-label">Рубрика</span>
                            <div class="col-md-8">
                                <div class="input-group" style="width: 100%;">
                                    <select id="input-rubric" name="shop_new_rubric_id" class="form-control select2" style="width: 100%;">
                                        <option value="-1" data-id="-1"></option>
                                        <option value="0" data-id="0">Без рубрики</option>
                                        <?php echo trim($data['view::shopnewrubrics/list']); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
				<div class="col-md-4 filter-input">
					<div class="form-group">
						<span for="input-name"  class="col-md-4 control-label">Название</span>
						<div class="col-md-8">
							<div class="input-group">
								<input id="input-name" class="form-control" name="name" placeholder="Название" value="<?php echo htmlspecialchars(Arr::path($siteData->urlParams, 'name', ''), ENT_QUOTES);?>" type="text">
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-warning btn-flat"><i class="fa fa-fw fa-search"></i></button>
                                </span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12 margin-top-15px">
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