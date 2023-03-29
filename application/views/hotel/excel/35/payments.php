<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Author>Kuk</Author>
  <LastAuthor>Kuk</LastAuthor>
  <LastPrinted>2018-10-23T03:39:51Z</LastPrinted>
  <Created>2018-10-23T03:35:52Z</Created>
  <Version>16.00</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns="urn:schemas-microsoft-com:office:office">
  <AllowPNG/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
  <WindowHeight>8265</WindowHeight>
  <WindowWidth>7890</WindowWidth>
  <WindowTopX>32767</WindowTopX>
  <WindowTopY>32767</WindowTopY>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Bottom"/>
   <Borders/>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="11"
    ss:Color="#000000"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="s65">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="13"
    ss:Color="#000000" ss:Bold="1"/>
  </Style>
  <Style ss:ID="s76">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Color="#000000"
    ss:Bold="1"/>
  </Style>
  <Style ss:ID="s81">
   <Alignment ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s82">
   <Alignment ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s83">
   <Alignment ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Color="#000000"/>
   <NumberFormat ss:Format="Short Date"/>
  </Style>
  <Style ss:ID="s84">
   <Alignment ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Color="#000000"/>
   <NumberFormat ss:Format="#,##0"/>
  </Style>
  <Style ss:ID="s85">
   <Alignment ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="11"
    ss:Color="#9C0006"/>
   <Interior ss:Color="#FFC7CE" ss:Pattern="Solid"/>
   <NumberFormat ss:Format="#,##0"/>
  </Style>
  <Style ss:ID="s183">
   <Alignment ss:Horizontal="Left" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Color="#000000" ss:Bold="1"/>
   <NumberFormat ss:Format="Short Date"/>
  </Style>
 </Styles>
 <Worksheet ss:Name="Лист1">
   <?php
   $row = 0;
   foreach ($payments['data'] as $payment){
       $row += count($payment['data']) + 1;
   }
   ?>
   <Table ss:ExpandedColumnCount="13" ss:ExpandedRowCount="<?php echo $row + 6; ?>" x:FullColumns="1"
   x:FullRows="1" ss:StyleID="Default">
   <Column ss:AutoFitWidth="0" ss:Width="25"/>
   <Column ss:Width="56.25"/>
   <Column ss:AutoFitWidth="0" ss:Width="153.75"/>
   <Column ss:Width="56.25"/>
   <Column ss:Width="58.5"/>
   <Column ss:Width="58.5"/>
   <Column ss:Width="150"/>
   <Column ss:Width="100"/>
   <Column ss:Width="59"/>
   <Column ss:Width="57.75"/>
   <Column ss:Width="58.5"/>
   <Column ss:Width="57.75"/>
   <Column ss:Width="57.75"/>
   <Row ss:Height="17.25">
    <Cell ss:MergeAcross="12" ss:StyleID="s65"><Data ss:Type="String">Отчет предоплаты по брони с <?php echo Helpers_DateTime::getDateFormatRus(Request_RequestParams::getParamDateTime('period_from')); ?> по <?php echo Helpers_DateTime::getDateFormatRus(Request_RequestParams::getParamDateTime('period_to')); ?></Data></Cell>
   </Row>
   <Row ss:Index="3" ss:AutoFitHeight="1">
    <Cell ss:StyleID="s76"><Data ss:Type="String">№</Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String">№ брони</Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String">Номера</Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String">Дата заезда</Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String">Дата выезда</Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String">Количество ночей</Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String">Контрагент</Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String">Телефон</Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String">Сумма заказа</Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String">Предоплата</Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String">Дата оплаты</Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String">20% оплаты</Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String">Разница</Data></Cell>
   </Row>
   <?php $i = 1; foreach ($payments['data'] as $payment){ ?>
   <?php foreach ($payment['data'] as $room){ ?>
   <Row ss:AutoFitHeight="1">
    <Cell ss:StyleID="s81"><Data ss:Type="Number"><?php echo $i++; ?></Data></Cell>
    <Cell ss:StyleID="s81"><Data ss:Type="Number"><?php echo $room['shop_bill_id']; ?></Data></Cell>
    <Cell ss:StyleID="s82"><Data ss:Type="String"><?php echo str_replace("\r\n", '&#10;', htmlspecialchars($room['rooms'], ENT_XML1)); ?></Data></Cell>
    <Cell ss:StyleID="s83"><Data ss:Type="DateTime"><?php echo $room['date_from']; ?></Data></Cell>
    <Cell ss:StyleID="s83"><Data ss:Type="DateTime"><?php echo $room['date_to']; ?></Data></Cell>
    <Cell ss:StyleID="s81"><Data ss:Type="Number"><?php echo Helpers_DateTime::diffDays($room['date_to'], $room['date_from']) ; ?></Data></Cell>
    <Cell ss:StyleID="s82"><Data ss:Type="String"><?php echo htmlspecialchars($room['client'], ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s82"><Data ss:Type="String"><?php echo htmlspecialchars($room['phone'], ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s84"><Data ss:Type="Number"><?php echo $room['amount']; ?></Data></Cell>
    <Cell ss:StyleID="s84"><Data ss:Type="Number"><?php echo $room['paid_amount']; ?></Data></Cell>
    <Cell ss:StyleID="s82"><Data ss:Type="String"><?php echo htmlspecialchars($room['paid_date'], ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s84"><Data ss:Type="Number"><?php echo $amount20 = round($room['amount'] / 5); ?></Data></Cell>
    <Cell ss:StyleID="<?php if($room['paid_amount'] - $amount20 > 0){ ?>s84<?php }else{ ?>s85<?php } ?>"><Data ss:Type="Number"><?php echo $room['paid_amount'] - $amount20; ?></Data></Cell>
   </Row>
   <?php } ?>
   <?php } ?>
   <Row ss:AutoFitHeight="1">
    <Cell ss:StyleID="s82"><Data ss:Type="String"></Data></Cell>
    <Cell ss:StyleID="s82"><Data ss:Type="String"></Data></Cell>
    <Cell ss:StyleID="s82"><Data ss:Type="String"></Data></Cell>
    <Cell ss:StyleID="s82"><Data ss:Type="String"></Data></Cell>
    <Cell ss:StyleID="s82"><Data ss:Type="String"></Data></Cell>
    <Cell ss:StyleID="s82"><Data ss:Type="String"></Data></Cell>
    <Cell ss:StyleID="s82"><Data ss:Type="String"></Data></Cell>
    <Cell ss:StyleID="s82"><Data ss:Type="String">Итого</Data></Cell>
    <Cell ss:StyleID="s84"><Data ss:Type="Number"><?php echo $payments['amount']; ?></Data></Cell>
    <Cell ss:StyleID="s84"><Data ss:Type="Number"><?php echo $payments['paid_amount']; ?></Data></Cell>
    <Cell ss:StyleID="s82"><Data ss:Type="String"></Data></Cell>
    <Cell ss:StyleID="s82"><Data ss:Type="String"></Data></Cell>
    <Cell ss:StyleID="s82"><Data ss:Type="String"></Data></Cell>
   </Row>
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <PageSetup>
    <Header x:Margin="0.3"/>
    <Footer x:Margin="0.3"/>
    <PageMargins x:Bottom="0.75" x:Left="0.25" x:Right="0.25" x:Top="0.75"/>
   </PageSetup>
   <Print>
    <ValidPrinterInfo/>
    <HorizontalResolution>600</HorizontalResolution>
    <VerticalResolution>600</VerticalResolution>
   </Print>
   <Selected/>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>10</ActiveRow>
     <ActiveCol>4</ActiveCol>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>
