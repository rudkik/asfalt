<div class="col-lg-3 col-xs-6">
    <a data-action="set-turn" href="<?php echo Func::getFullURL($siteData, '/shopcar/save', array(), array('id' => $data->additionDatas['shop_car_id'], 'shop_turn_place_id' => $data->id, 'shop_turn_id' => Model_Ab1_Shop_Turn::TURN_ASU), $data->values); ?>" class="small-box-footer">
        <div class="small-box #color#" style="margin-bottom: 5px;">
            <div class="inner">
                <div class="row">
                    <div class="col-md-3">
                        <h3 style="margin: 0px"><?php echo $data->additionDatas['turn'];?></h3>
                    </div>
                    <div class="col-md-9 text-right">
                        <h3 style="font-weight: 400; font-size: 30px; white-space: normal;"><?php echo $data->values['name'];?></h3>
                    </div>
                </div>
                <div style="margin-top: 10px;display: inline-block;width: 100%;">
                    <h4 class="pull-left" ><?php echo $data->additionDatas['ton_asu'];?> т</h4>
                    <h4 class="pull-right"><?php echo $data->additionDatas['ton'];?> т</h4>
                </div>
                <div style="margin-top: 10px"><?php echo $data->additionDatas['view::_shop/car/list/turn'];?></div>
            </div>
            <span class="small-box-footer">Выбрать <i class="fa fa-arrow-circle-right"></i></span>
        </div>
    </a>
    <?php if($data->additionDatas['is_select']){?>
        <div class="text-center"><label>Рекомендуем</label></div>
    <?php } ?>
</div>