<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border"><b style="font-size: 18px;">Доставки</b></div>
            <div class="box-body with-border">
                <table id="buket_sobran" class="table table-bordered table-hover table-striped top10">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Стоимость</th>
                        <th style="width: 70px;"></th>
                    </tr>
                    </thead>
                    <tbody id="body_panel">
                        <?php
						foreach ($data['view::shopdeliverytype/index']->childs as $value){
						    echo $value->str;
						}
						?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-md-10"></div>
	<div class="col-md-2">
		<input type="submit" class="btn btn-success btn-block" value="Добавить доставку" onclick="actionAddTR('body_panel', 'tr_panel')">
	</div>
</div>

<div hidden="hidden" id="tr_panel">
<!--
<tr>
    <td><input name="name" type="text" class="form-control" value=""></td>
    <td><input name="info" type="text" class="form-control" value=""></td>
    <td><input name="price" type="text" class="form-control" value=""></td>
    <td style="width: 178px;">
        <?php if($siteData->branchID > 0){ ?>
            <input name="shop_branch_id" type="text" hidden="hidden" value="<?php echo $siteData->branchID; ?>">
        <?php } ?>
    	<a buttom-tr="save" href="<?php echo $siteData->urlBasic; ?>/cabinet/shopdeliverytype/save" class="btn btn-primary btn-sm checkbox-toggle">сохранить</a>
    	<a buttom-tr="del" href="<?php echo $siteData->urlBasic; ?>/cabinet/shopdeliverytype/del" class="btn btn-danger btn-sm checkbox-toggle">удалить</a>
    </td>
</tr>
 -->
</div>

