<section class="content hidden-panel">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-body">
					<div class="row" id="find_panel">
						<div class="col-md-3 col-sm-6">
							<div class="form-group">
								<label>Название</label>
								<input type="text" name="name" placeholder="Название" class="form-control" value="<?php echo Arr::path($siteData->urlParams, 'name', '');?>">
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
									<input type="submit" class="btn btn-primary" id="button-search" value="Фильтр" onclick="actionTableFind('<?php echo $siteData->urlBasic.$siteData->url?>?', 'find_panel', 'table_panel')">
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