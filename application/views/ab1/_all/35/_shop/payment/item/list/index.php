<?php $isShow = (Request_RequestParams::getParamBoolean('is_show')) && !$siteData->operation->getIsAdmin(); ?>
<table class="table table-hover table-db table-tr-line">
    <tr>
        <th>Продукт</th>
        <th class="width-110">Цена</th>
        <th class="width-120">Кол-во</th>
        <th class="width-110">Сумма</th>
        <?php $isShow = !$siteData->operation->getIsAdmin() && Request_RequestParams::getParamBoolean('is_show'); ?>
        <?php if(!$isShow){?>
        <th class="width-85"></th>
        <?php } ?>
    </tr>
    <tbody id="products">
    <?php
    foreach ($data['view::_shop/payment/item/one/index']->childs as $value) {
        echo $value->str;
    }
    ?>
    </tbody>
</table>
<?php if(!$isShow){ ?>
    <div class="modal-footer text-center">
        <button type="button" class="btn btn-danger" onclick="addElement('new-product', 'products', true);">Добавить строчку</button>
    </div>
<?php } ?>
<?php if(!$isShow){?>

    <div id="new-product" data-index="0">
        <!--
        <tr>
            <td>
                <select data-action="calc-payment-product" name="shop_payment_items[_#index#][shop_product_id]" class="form-control select2" required style="width: 100%;">
                    <option value="0" data-id="0">Без значения</option>
                    <?php echo $siteData->globalDatas['view::_shop/product/list/list']; ?>
                </select>
            </td>
            <td>
                <input data-type="money" data-fractional-length="2" data-action="calc-payment" data-id="price" name="shop_payment_items[_#index#][price]" type="text" class="form-control" placeholder="Цена" required value="0">
            </td>
            <td>
                <input data-type="money" data-fractional-length="3" data-action="calc-payment" data-id="quantity" name="shop_payment_items[_#index#][quantity]" type="text" class="form-control" placeholder="Кол-во" required value="0">
            </td>
            <td>
                <input data-type="money" data-fractional-length="2" data-action="amount-edit" data-id="amount" data-amount="0" name="shop_payment_items[_#index#][amount]" disabled type="text" class="form-control" value="0">
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