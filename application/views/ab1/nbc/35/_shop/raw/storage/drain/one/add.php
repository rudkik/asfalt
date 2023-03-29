<div id="modal-add-drain" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php if(Request_RequestParams::getParamBoolean('is_upload')){?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 id="title-metering" class="modal-title"><b><?php echo $data->values['name'];?></b> - слив с битумного лотка</h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo Func::getFullURL($siteData, '/shoprawstoragedrain/save'); ?>" class="modal-fields">
                        <div class="row record-input record-list">
                            <div class="col-md-3 record-title">
                                <label>
                                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                    Лоток слива НБЦ
                                </label>
                            </div>
                            <div class="col-md-3">
                                <select id="shop_raw_drain_chute_id" name="shop_raw_drain_chute_id" class="form-control select2" style="width: 100%">
                                    <option data-id="0" value="0">Без значения</option>
                                    <?php echo $siteData->replaceDatas['view::_shop/raw/drain-chute/list/list'];?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer text-center">
                            <input name="shop_raw_storage_id" value="<?php echo $data->id;?>" style="display: none">
                            <input name="is_upload" value="<?php echo Request_RequestParams::getParamBoolean('is_upload');?>" style="display: none">
                            <button type="button" class="btn btn-primary" onclick="saveAddRaw();">Сохранить</button>
                        </div>
                    </form>
                </div>
            <?php }else{?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 id="title-metering" class="modal-title"><b><?php echo $data->values['name'];?></b> - производство материала</h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo Func::getFullURL($siteData, '/shoprawstoragedrain/save'); ?>" class="modal-fields">
                        <div class="row record-input record-list">
                            <div class="col-md-3 record-title">
                                <label>
                                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                    Куб готовой продукции
                                </label>
                            </div>
                            <div class="col-md-3">
                                <select id="shop_material_storage_id" name="shop_material_storage_id" class="form-control select2" style="width: 100%">
                                    <option data-id="0" value="0">Без значения</option>
                                    <?php echo $siteData->replaceDatas['view::_shop/material/storage/list/list'];?>
                                </select>
                            </div>
                        </div>
                        <div class="row record-input record-list">
                            <div class="col-md-3 record-title">
                                <label>
                                    <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
                                    Материал
                                </label>
                            </div>
                            <div class="col-md-3">
                                <select id="shop_material_id" name="shop_material_id" class="form-control select2" style="width: 100%">
                                    <option data-id="0" value="0">Без значения</option>
                                    <?php echo $siteData->replaceDatas['view::_shop/material/list/list'];?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer text-center">
                            <input name="shop_raw_storage_id" value="<?php echo $data->id;?>" style="display: none">
                            <input name="is_upload" value="<?php echo Request_RequestParams::getParamBoolean('is_upload');?>" style="display: none">
                            <button type="button" class="btn btn-primary" onclick="saveAddMaterial();">Сохранить</button>
                        </div>
                    </form>
                </div>
            <?php }?>
            <script>
                __init();
            </script>
        </div>
    </div>
</div>