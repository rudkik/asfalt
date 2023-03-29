<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Author>Apache POI</Author>
  <LastAuthor>Kuk</LastAuthor>
  <LastPrinted>2021-09-05T16:12:36Z</LastPrinted>
  <Created>2021-09-05T16:05:41Z</Created>
  <Version>16.00</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns="urn:schemas-microsoft-com:office:office">
  <AllowPNG/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
  <WindowHeight>11250</WindowHeight>
  <WindowWidth>28800</WindowWidth>
  <WindowTopX>32767</WindowTopX>
  <WindowTopY>32767</WindowTopY>
  <RefModeR1C1/>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Bottom"/>
   <Borders/>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="s16" ss:Name="Финансовый">
   <NumberFormat ss:Format="_-* #,##0.00_-;\-* #,##0.00_-;_-* &quot;-&quot;??_-;_-@_-"/>
  </Style>
  <Style ss:ID="s78">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="11"
    ss:Color="#000000" ss:Bold="1"/>
  </Style>
  <Style ss:ID="s79">
   <Alignment ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
  </Style>
  <Style ss:ID="s80" ss:Parent="s16">
   <Alignment ss:Horizontal="Right" ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"/>
   <NumberFormat ss:Format="_-* #,##0_-;\-* #,##0_-;_-* &quot;-&quot;??_-;_-@_-"/>
  </Style>
  <Style ss:ID="s81">
   <Alignment ss:Horizontal="Right" ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <NumberFormat/>
  </Style>
 </Styles>
 <Worksheet ss:Name="Sheet0">
  <Table ss:ExpandedColumnCount="15" ss:ExpandedRowCount="<?php echo count($billItems['data']) + 4; ?>" x:FullColumns="1"
   x:FullRows="1">
   <Column ss:Width="52.5"/>
      <Column ss:Width="60"/>
      <Column ss:Width="63"/>
   <Column ss:Width="45"/>
   <Column ss:AutoFitWidth="0" ss:Width="151.5"/>
   <Column ss:Width="145.5"/>
   <Column ss:AutoFitWidth="0" ss:Width="87.75"/>
      <Column ss:Width="85.5"/>
   <Column ss:AutoFitWidth="0" ss:Width="51"/>
   <Column ss:Width="38.25"/>
   <Column ss:Width="51"/>
   <Column ss:Width="135.75"/>
   <Column ss:Width="85.5"/>
   <Row>
    <Cell ss:StyleID="s78"><Data ss:Type="String">№ заказа</Data></Cell>
       <Cell ss:StyleID="s78"><Data ss:Type="String">Дата заказа</Data></Cell>
       <Cell ss:StyleID="s78"><Data ss:Type="String">Дата доставки</Data></Cell>
    <Cell ss:StyleID="s78"><Data ss:Type="String">Артикул</Data></Cell>
    <Cell ss:StyleID="s78"><Data ss:Type="String">Название товара</Data></Cell>
    <Cell ss:StyleID="s78"><Data ss:Type="String">Адрес </Data></Cell>
    <Cell ss:StyleID="s78"><Data ss:Type="String">Телефон</Data></Cell>
       <Cell ss:StyleID="s78"><Data ss:Type="String">ФИО</Data></Cell>
    <Cell ss:StyleID="s78"><Data ss:Type="String">Цена</Data></Cell>
    <Cell ss:StyleID="s78"><Data ss:Type="String">Кол-во</Data></Cell>
    <Cell ss:StyleID="s78"><Data ss:Type="String">Сумма</Data></Cell>
    <Cell ss:StyleID="s78"><Data ss:Type="String">Поставщик</Data></Cell>
    <Cell ss:StyleID="s78"><Data ss:Type="String">Компания</Data></Cell>
   </Row>
   <?php foreach ($billItems['data'] as $billItem){ ?>
   <Row ss:AutoFitHeight="1">
    <Cell ss:StyleID="s79"><Data ss:Type="String"><?php echo $billItem['bill']; ?></Data></Cell>
       <Cell ss:StyleID="s79"><Data ss:Type="String"><?php echo Helpers_DateTime::getDateFormatRus($billItem['date']); ?></Data></Cell>
       <Cell ss:StyleID="s79"><Data ss:Type="String"><?php echo Helpers_DateTime::getDateFormatRus($billItem['delivery_plan']); ?></Data></Cell>
    <Cell ss:StyleID="s79"><Data ss:Type="String"><?php echo $billItem['article']; ?></Data></Cell>
    <Cell ss:StyleID="s79"><Data ss:Type="String"><?php echo htmlspecialchars($billItem['product'], ENT_QUOTES); ?></Data></Cell>
    <Cell ss:StyleID="s79"><Data ss:Type="String"><?php echo htmlspecialchars($billItem['buyer'], ENT_QUOTES); ?></Data></Cell>
    <Cell ss:StyleID="s79"><Data ss:Type="String"><?php echo htmlspecialchars($billItem['address'], ENT_QUOTES); ?></Data></Cell>
    <Cell ss:StyleID="s79"><Data ss:Type="String" x:Ticked="1"><?php echo htmlspecialchars($billItem['phone'], ENT_QUOTES); ?></Data></Cell>
    <Cell ss:StyleID="s80"><Data ss:Type="Number"><?php echo $billItem['price']; ?></Data></Cell>
    <Cell ss:StyleID="s81"><Data ss:Type="Number"><?php echo $billItem['quantity']; ?></Data></Cell>
    <Cell ss:StyleID="s80"><Data ss:Type="Number"><?php echo $billItem['amount']; ?></Data></Cell>
    <Cell ss:StyleID="s79"><Data ss:Type="String"><?php echo htmlspecialchars($billItem['supplier'], ENT_QUOTES); ?></Data></Cell>
    <Cell ss:StyleID="s79"><Data ss:Type="String"><?php echo htmlspecialchars($billItem['company'], ENT_QUOTES); ?></Data></Cell>
   </Row>
   <?php }  ?>
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <PageSetup>
    <Layout x:Orientation="Landscape"/>
    <Header x:Margin="0.3"/>
    <Footer x:Margin="0.3"/>
    <PageMargins x:Bottom="0.75" x:Left="0.25" x:Right="0.25" x:Top="0.75"/>
   </PageSetup>
   <Print>
    <ValidPrinterInfo/>
    <HorizontalResolution>300</HorizontalResolution>
    <VerticalResolution>300</VerticalResolution>
   </Print>
   <Selected/>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>4</ActiveRow>
     <ActiveCol>5</ActiveCol>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>