<?php $isShow = !$siteData->operation->getIsAdmin() && Request_RequestParams::getParamBoolean('is_show'); ?>
    <div class="row record-input record-list">
        <div class="col-md-3 record-title">
            <label>
                Рецепт
            </label>
        </div>
        <div class="col-md-9">
            <table class="table table-hover table-db table-tr-line" data-action="fixed">
                <tr>
                    <th>Материал</th>
                    <th class="tr-header-buttom-sort">Потери (%)</th>
                    <th class="tr-header-amount">Норма (%)</th>
                    <th class="tr-header-amount">Вес (кг)</th>
                    <?php if(!$isShow){ ?>
                        <th class="tr-header-buttom"></th>
                    <?php } ?>
                </tr>
                <tbody id="materials">
                <?php
                foreach ($data['view::_shop/formula/product/item/one/index']->childs as $value) {
                    echo $value->str;
                }
                ?>
                </tbody>
            </table>
            <?php if(!$isShow){ ?>
                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-danger" onclick="addElement('new-material', 'materials', true);">Добавить материал</button>
                </div>
            <?php } ?>
        </div>
    </div>
<?php if(!$isShow){ ?>
    <div id="new-material" data-index="0">
        <!--
        <tr>
            <td>
                <select data-action="calc" name="shop_formula_items[_#index#][shop_material_id]" class="form-control select2" required style="width: 100%;">
                    <option value="0" data-id="0">Без значения</option>
                    <?php echo $siteData->globalDatas['view::_shop/material/list/list']; ?>
                </select>
            </td>
            <td>
                <input data-type="money" data-fractional-length="3" data-action="calc" name="shop_formula_items[_#index#][losses]" type="text" class="form-control" placeholder="Потери (%)" required value="0">
            </td>
            <td>
                <input data-type="money" data-action="calc" name="shop_formula_items[_#index#][norm]" type="text" class="form-control" placeholder="Норма (%)" required value="0">
            </td>
            <td>
                <input data-type="money" data-fractional-length="3" data-action="calc" name="shop_formula_items[_#index#][norm_weight]" type="text" class="form-control" placeholder="Норма (вес)" required value="0">
            </td>
            <td>
                <ul class="list-inline tr-button delete">
                    <li class="tr-remove"><a data-action="remove-tr" data-parent-count="4" href="" class="link-red text-sm"><i class="fa fa-remove margin-r-5"></i> Удалить</a></li>
                </ul>
            </td>
        </tr>
        -->
    </div>
<?php } ?>