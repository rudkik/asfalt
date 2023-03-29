<?php if(count($data['view::View_Ads_Shop_Invoice\-account-invoice-scheta']->childs)> 0){ ?>
<div class="col-sm-10">
    <div class="title--block margin-tb-1">
        Счета на оплату
    </div>
</div>
<div class="col-sm-10">
    <div class="table__wrap margin-b-4">
        <table class="table table--with_content">
            <thead class="table__head">
            <tr class="table__row">
                <td class="table__col">Трэкинг ID</td>
                <td class="table__col">Цена посылки</td>
                <td class="table__col">Описание посылки</td>
                <td class="table__col">Статус</td>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($data['view::View_Ads_Shop_Invoice\-account-invoice-scheta']->childs as $value){
                echo $value->str;
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<?php }else{ ?>
    <div class="col-sm-10">
        <div class="title--block margin-tb-1">
            Счетов на оплату за посылки еще нет
        </div>
    </div>
<?php } ?>

