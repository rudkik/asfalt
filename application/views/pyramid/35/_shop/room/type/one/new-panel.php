<div id="<?php echo $panelID; ?>" class="form-group row" style="display: none">
    <input name="is_add_room_type" value="0" style="display: none">
    <div class="col-12 ks-panels-column-section">
        <div class="card panel ks-widget ks-widget-followers">
            <div class="card-header">
                Новая персона
                <div class="ks-controls">
                    <a data-panel="#<?php echo $panelID; ?>" data-select="#<?php echo $selectID; ?>" data-action="close-add-panel" href="#" class="ks-control">
                        <span class="ks-icon fa fa-close"></span>
                    </a>
                </div>
            </div>
            <div class="card-block ks-scrollable" data-height="236" style="padding: 0px;">
                <div class="ks-wrapper">
                    <div class="form-group row">
                        <label for="name" class="col-3 col-form-label">Название</label>
                        <div class="col-9">
                            <div class="form-group margin-0">
                                <input name="shop_room_type[name]" data-validation="length" data-validation-length="max250" maxlength="250" class="form-control" placeholder="Название" id="name" type="text">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="price" class="col-3 col-form-label">Стоимость номера</label>
                    <div class="col-9">
                        <div class="row">
                            <div class="col-5">
                                <div class="form-group margin-0">
                                    <input name="price" class="form-control money-format" placeholder="Стоимость номера" id="price" type="text">
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="row">
                                    <label for="price_feast" class="col-3 col-form-label">Стоимость номера в выходные дни</label>
                                    <div class="col-9">
                                        <div class="form-group margin-0">
                                            <input name="price_feast" class="form-control money-format" placeholder="Стоимость номера в выходные и праздничные дни" id="price" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="number" class="col-3 col-form-label">Кол-во мест</label>
                    <div class="col-9">
                        <div class="row">
                            <div class="col-5">
                                <div class="form-group margin-0">
                                    <input name="human" class="form-control money-format valid" placeholder="Кол-во мест" id="human" type="text">
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="row">
                                    <label for="number_extra" class="col-3 col-form-label">Кол-во доп. мест</label>
                                    <div class="col-9">
                                        <div class="form-group margin-0">
                                            <input name="human_extra" class="form-control money-format valid" placeholder="Кол-во дополнительных мест" id="human_extra" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label for="price_extra" class="col-3 col-form-label">Стоимость одного доп. <b>взрослого</b></label>
                    <div class="col-9">
                        <div class="row">
                            <div class="col-5">
                                <div class="form-group margin-0">
                                    <input name="price_extra" class="form-control money-format" placeholder="Стоимость одного дополнительного взрослого места" id="price_extra" type="text">
                                </div>
                            </div>
                            <div class="col-7">
                                <div class="row">
                                    <label for="price_child" class="col-3 col-form-label money-format">Стоимость одного доп. <b>детского</b></label>
                                    <div class="col-9">
                                        <div class="form-group margin-0">
                                            <input name="price_child" class="form-control" placeholder="Стоимость одного дополнительного детского места" id="price_child" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>