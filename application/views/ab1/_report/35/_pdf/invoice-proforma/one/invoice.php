<html xmlns:v="urn:schemas-microsoft-com:vml"
      xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:x="urn:schemas-microsoft-com:office:excel"
      xmlns="http://www.w3.org/TR/REC-html40">

<head>
 <style>
  .table, .table td{
   border-top-color:#0f0f0f;border-top-width:0.1px;border-top-style:solid;
   border-right-color:#0f0f0f;border-right-width:0.1px;border-right-style:solid;
   border-bottom-color:#0f0f0f;border-bottom-width:0.1px;border-bottom-style:solid;
   border-left-color:#0f0f0f;border-left-width:0.1px;border-left-style:solid
  }
  table td{
   vertical-align: middle;
  }
  .bold, .bold td{
   font-weight: bold;
  }
 </style>
</head>

<body>
<p style="text-align: right">Внимание! Оплата данного счета означает согласие с условиями поставки товара. Уведомление об оплате обязательно, в противном случае не гарантируется наличие товара на складе. Товар отпускается по факту прихода денег на р/счет Поставщика, самовывозом при наличии доверенности и документов удостоверяющих личность</p>
<p class="bold" style="font-size: 12pt; line-height: 1.0">Поставщик: ТОО &quot;Асфальтобетон 1&quot;</p>
<p>Адрес: г.Алматы, ул. Серикова, 20 А, телефон: 386-29-73, факс: 386-29-76</p>
<b>&nbsp;&nbsp;Образец платежного поручения</b>
<br>
<table class="table" cellpadding="5" style="width: 100%;">
 <tr>
  <td class="bold" style="width: 50%;">Бенефициар: Товарищество с ограниченной ответственностью &quot;Асфальтобетон 1&quot; <br>БИН: 060440009474</td>
  <td class="bold" style="width: 25%; text-align: center;">ИИК<br>KZ906017131000030374</td>
  <td style="width: 25%; text-align: center;">Кбе<br>17</td>
 </tr>
 <tr>
  <td>Банк бенефициара:<br> АО &quot;Народный банк Казахстана&quot;</td>
  <td style="text-align: center;">БИК<br> HSBKKZKX</td>
  <td style="text-align: center;">Код назначения платежа<br> 710</td>
 </tr>
</table>

<p class="bold">ПЛАТЕЛЬЩИК: <?php echo $data->getElementValue('shop_client_id', 'name_1c'); ?> БИН / ИИН: <?php echo $data->getElementValue('shop_client_id', 'bin'); ?></p>
<p>Адрес: <?php echo $data->getElementValue('shop_client_id', 'address'); ?></p>


<table class="bold" cellpadding="3" style="width: 100%;">
 <tr>
  <td style="width: 50%; text-align: right;font-size: 13.0pt;" rowspan="2">Счет</td>
  <td style="width: 10%" rowspan="2"></td>
  <td class="table" style="width: 20%;text-align: center;">Номер документа</td>
  <td class="table" style="width: 20%;text-align: center;">Дата составления</td>
 </tr>
 <tr>
  <td class="table" style="text-align: center;"><?php echo $data->values['number']; ?></td>
  <td class="table" style="text-align: center;"><?php echo Helpers_DateTime::getDateFormatRus($data->values['created_at']); ?></td>
 </tr>
</table>
<p>Действителен в течение трех банковских дней
<br>Основание:
    <?php
    if($data->values['shop_client_contract_id'] > 0) {
        echo 'Договор №' . $data->getElementValue('shop_client_contract_id', 'number') . ' от ' . Helpers_DateTime::getDateFormatRus($data->getElementValue('shop_client_contract_id', 'from_at'));
    }else{
        echo 'Без договора';
    }
    ?>
    <?php  ?>
</p>

<table class="table" cellpadding="3" style="width: 100%;">
 <tr class="bold">
  <td style="width: 27px;text-align: center;">№</td>
  <td style="width: 290px;text-align: center;">Наименование</td>
  <td style="width: 70px;text-align: center;">Кол-во</td>
  <td style="width: 70px;text-align: center;">Ед.</td>
  <td style="width: 81px;text-align: center;">Цена</td>
  <td style="width: 107px;text-align: center;">Сумма</td>
 </tr>
    <?php echo $siteData->replaceDatas['view::_pdf/invoice-proforma/list/product']; ?>
</table>
<br><br>
<table cellpadding="3">
 <tr>
  <td style="width: 538px;text-align: right;">Итого:</td>
  <td class="bold" style="width: 107px;"><?php echo Func::getNumberStr($data->values['amount'], true, 2, false);?></td>
 </tr>
 <tr>
  <td style="text-align: right;">В том числе НДС:</td>
  <td class="bold"><?php echo Func::getNumberStr(round($data->values['amount'] / 112 * 12, 2), true, 2, false);?></td>
 </tr>
</table>
<br>
<hr>
<br>
<p>Всего наименований <?php echo Func::getNumberStr($data->additionDatas['count'], true, 0);?>, на сумму <?php echo Func::getNumberStr($data->values['amount'], true, 2, false);?><br>
<span class="bold" style="font-style: italic">Сумма прописью: <?php echo Func::numberToStr($data->values['amount'], TRUE, $siteData->currency);?></span>
</p>
<p>Исполнитель ___________________________________ / <?php echo $siteData->operation->getName(); ?> /</p>


</body>

</html>
