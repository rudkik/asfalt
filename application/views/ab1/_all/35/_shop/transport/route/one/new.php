<div class="row record-input record-list">
    <div class="col-md-3 record-title"></div>
    <div class="col-md-9">
        <label class="span-checkbox">
            <input name="is_public" value="0" style="display: none;">
            <input name="is_public" value="1" checked type="checkbox" class="minimal">
            Показать
        </label>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            Код 1С
        </label>
    </div>
    <div class="col-md-3">
        <input name="number" type="text" class="form-control" placeholder="Код 1С">
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Название маршрута
        </label>
    </div>
    <div class="col-md-9">
        <input name="name" type="text" class="form-control" placeholder="Название маршрута" required >
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Расстояние (км)
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="3" name="distance" type="phone" class="form-control" placeholder="Расстояние (км)" required >
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Расценка (для расчета зарплаты водителей)
        </label>
    </div>
    <div class="col-md-3">
        <input data-type="money" data-fractional-length="2" name="amount" type="phone" class="form-control" placeholder="Расценка" required>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Формула расчета зарплаты
        </label>
    </div>
    <div class="col-md-9">
        <textarea name="formula" class="form-control" placeholder="Формула"></textarea>
        <p>
            <b>Параметры для формулы:</b>
            <a href="#" data-action="add-formula">Рейсы</a>
            <a href="#" data-action="add-formula">Расстояние</a>
            <a href="#" data-action="add-formula">Масса</a>
            <a href="#" data-action="add-formula">Расценка</a>
            <a href="#" data-action="add-formula">Коэффициент</a>
        </p>
    </div>
</div>
<h3 class="text-blue">Параметры определения маршрута</h3>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Таблица
        </label>
    </div>
    <div class="col-md-9">
        <select id="table_id" name="table_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::table/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list">
    <div class="col-md-3 record-title">
        <label style="margin-top: 33px;">
            Откуда
        </label>
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Филиал</label>
                    <select id="shop_branch_from_id" name="shop_branch_from_id" class="form-control select2" required style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6" id="shop_daughter_from">
                <div class="form-group">
                    <label>Поставщик</label>
                    <select id="shop_daughter_from_id" name="shop_daughter_from_id" class="form-control select2" required style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo $siteData->globalDatas['view::_shop/daughter/list/list']; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row record-input record-list" id="to">
    <div class="col-md-3 record-title">
        <label style="margin-top: 33px;">
            Куда
        </label>
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Филиал</label>
                    <select id="shop_branch_to_id" name="shop_branch_to_id" class="form-control select2" required style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo $siteData->globalDatas['view::_shop/branch/list/list']; ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Поставщик</label>
                    <select id="shop_daughter_to_id" name="shop_daughter_to_id" class="form-control select2" required style="width: 100%;">
                        <option value="0" data-id="0">Без значения</option>
                        <?php echo $siteData->globalDatas['view::_shop/daughter/list/list']; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row record-input record-list" id="product">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Клиент
        </label>
    </div>
    <div class="col-md-3">
        <select data-action="shop_client" data-basic-url="<?php echo $siteData->actionURLName;?>" data-action-select2="1"
                id="shop_client_to_id" name="shop_client_to_id" class="form-control select2" style="width: 100%">
        </select>
    </div>
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Рубрика продукции
        </label>
    </div>
    <div class="col-md-3">
        <select id="shop_product_rubric_id" name="shop_product_rubric_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/product/rubric/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list" id="distance">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Дистанции балласта
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_ballast_distance_id" name="shop_ballast_distance_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/ballast/distance/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list" id="transportation-place">
    <div class="col-md-3 record-title">
        <label>
            <sup><i class="fa fa-fw fa-asterisk text-red"></i></sup>
            Места выгрузки
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_transportation_place_id" name="shop_transportation_place_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/transportation/place/list/list']; ?>
        </select>
    </div>
</div>
<div class="row record-input record-list" id="shop_storage">
    <div class="col-md-3 record-title">
        <label>
            Места выгрузки
        </label>
    </div>
    <div class="col-md-9">
        <select id="shop_storage_id" name="shop_storage_id" class="form-control select2" required style="width: 100%;">
            <option value="0" data-id="0">Без значения</option>
            <?php echo $siteData->globalDatas['view::_shop/storage/list/list']; ?>
        </select>
    </div>
</div>
<div class="row">
    <div class="modal-footer text-center">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#shop_branch_from_id').change(function () {
            if($(this).val() > 0){
                $('#shop_daughter_from_id').val(0).trigger('change');
            }
        });
        $('#shop_daughter_from_id').change(function () {
            if($(this).val() > 0){
                $('#shop_branch_from_id').val(0).trigger('change');
            }
        });
        $('#shop_branch_to_id').change(function () {
            if($(this).val() > 0){
                $('#shop_daughter_to_id').val(0).trigger('change');
            }
        });
        $('#shop_daughter_to_id').change(function () {
            if($(this).val() > 0){
                $('#shop_branch_to_id').val(0).trigger('change');
            }
        });

        $('#table_id').change(function () {
            $('#shop_daughter_from').css('display', 'none');
            $('#to').css('display', 'none');
            $('#product').css('display', 'none');
            $('#distance').css('display', 'none');
            $('#transportation-place').css('display', 'none');
            $('#shop_storage').css('display', 'none');

            $('#shop_daughter_from_id').attr('disabled', '');
            $('#shop_daughter_to_id').attr('disabled', '');
            $('#shop_branch_to_id').attr('disabled', '');
            $('#shop_client_to_id').attr('disabled', '');
            $('#shop_product_rubric_id').attr('disabled', '');
            $('#shop_ballast_distance_id').attr('disabled', '');
            $('#shop_storage_id').attr('disabled', '');

            var table = $(this).val();
            if(table == <?php echo Model_Ab1_Shop_Car::TABLE_ID; ?>
                || table == <?php echo Model_Ab1_Shop_Piece::TABLE_ID; ?>
                || table == <?php echo Model_Ab1_Shop_Lessee_Car::TABLE_ID; ?>
                || table == <?php echo Model_Ab1_Shop_Move_Car::TABLE_ID; ?>
                || table == <?php echo Model_Ab1_Shop_Defect_Car::TABLE_ID; ?>){
                $('#product').css('display', 'block');

                $('#shop_client_to_id').removeAttr('disabled');
                $('#shop_product_rubric_id').removeAttr('disabled');
            }else {
                if (table == <?php echo Model_Ab1_Shop_Ballast::TABLE_ID; ?>
                    || table == <?php echo Model_Ab1_Shop_Transportation::TABLE_ID; ?>) {
                    $('#distance').css('display', 'block');

                    $('#shop_ballast_distance_id').removeAttr('disabled');
                }else {
                    if (table == <?php echo Model_Ab1_Shop_Car_To_Material::TABLE_ID; ?>) {
                        $('#shop_daughter_from').css('display', 'block');
                        $('#to').css('display', 'block');

                        $('#shop_daughter_from_id').removeAttr('disabled', '');
                        $('#shop_daughter_to_id').removeAttr('disabled', '');
                        $('#shop_branch_to_id').removeAttr('disabled', '');
                    }else {
                        if (table == <?php echo Model_Ab1_Shop_Move_Other::TABLE_ID; ?>){

                        }else {
                            if (table == <?php echo Model_Ab1_Shop_Product_Storage::TABLE_ID; ?>) {
                                $('#shop_storage').css('display', 'block');

                                $('#shop_daughter_from').removeAttr('disabled', '');
                                $('#shop_storage_id').removeAttr('disabled', '');
                            }
                        }
                    }
                }
            }
        }).trigger('change');

        $('[data-action="add-formula"]').click(function (e) {
            e.preventDefault();

            var el = $('[name="formula"]');
            el.val(el.val() + ' ' + $(this).text() + ' ');
        });
    });
</script>