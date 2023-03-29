<section class="content hidden-panel">
	<div class="row">
		<div class="col-md-12">
			<div class="box">					
				<div class="box-body">
					<div class="row" id="find_panel">
							<div class="col-md-3 col-sm-6">
								<div class="form-group">
									<label>Категория:</label>
									<select name="email_type_id" class="form-control select2" style="width: 100%;">
										<option value="-1" data-id="-1"></option>
										<?php echo trim($data['view::emailtypes/list']); ?>
									</select>
								</div>
							</div>

						<div class="col-md-3 col-sm-6">
							<div class="form-group public-checkbox">
								<label>
									<input name="is_public" type="checkbox" class="flat-red" checked> Опубликован
								</label>
							</div>
						</div>
						<div class="col-md-3 col-sm-6">
							<div class="form-group filtr-btn">
								<label>
									<input type="submit" class="btn btn-primary" id="button-search" value="Фильтр" onclick="actionTableFind('<?php echo $siteData->urlBasic.$siteData->url?>?<?php if($siteData->branchID > 0){echo '&shop_branch_id='.$siteData->branchID;} ?>', 'find_panel', 'table_panel')">
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="box-footer">
					<div class="row"></div>
				</div>
				<div class="box-header with-border">                  
					  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-angle-up"></i></button>
				</div>
			</div>
		</div>
	</div>
</section>