<?php if(count($data['view::View_Ads_Shop_Parcel\-account-expect-ozhidaemye']->childs) > 0){?>
    <div class="col-md-10">
        <div class="title--block margin-tb-1">
            Ваши ожидаемые посылки
        </div>
        <div class="table__wrap margin-b-1-5">
            <table class="table table--with_content">
                <thead class="table__head">
                <tr class="table__row">
                    <td class="table__col">Трэкинг ID</td>
                    <td class="table__col">Цена посылки</td>
                    <td class="table__col">Описание посылки</td>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($data['view::View_Ads_Shop_Parcel\-account-expect-ozhidaemye']->childs as $value){
                    echo $value->str;
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-10">
        `   <a href="<?php echo $siteData->urlBasic;?>/account/await/add" class="btn btn--p-medium margin-b-3">
            Добавить посылку
        </a>
    </div>
<?php }else{?>
    <div class="col-sm-10 d-flex d-sm-block justify-content-center">
        <div class="title--block margin-tb-1" style="white-space: nowrap;">
            Ожидаемых посылок пока нет
        </div>
    </div>
    <div class="col-sm-10 d-flex d-sm-block justify-content-center">
        <a href="<?php echo $siteData->urlBasic;?>/account/await/add" class="btn btn--p-medium margin-b-3">
            Добавить посылку
        </a>
    </div>
<?php }?>
