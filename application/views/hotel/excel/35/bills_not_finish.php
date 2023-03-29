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
  <LastPrinted>2018-10-30T02:46:58Z</LastPrinted>
  <Created>2018-10-29T08:55:37Z</Created>
  <LastSaved>2018-10-30T02:50:10Z</LastSaved>
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
  <Style ss:ID="s66">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="11"
    ss:Color="#000000" ss:Bold="1"/>
  </Style>
  <Style ss:ID="s75">
   <Alignment ss:Horizontal="Right" ss:Vertical="Bottom"/>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="11"
    ss:Color="#000000" ss:Bold="1"/>
  </Style>
  <Style ss:ID="s76">
   <Alignment ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
  </Style>
  <Style ss:ID="s77">
   <Alignment ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <NumberFormat ss:Format="Short Date"/>
  </Style>
  <Style ss:ID="s78">
   <Alignment ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <NumberFormat ss:Format="#,##0"/>
  </Style>
  <Style ss:ID="s79">
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="11"
    ss:Color="#000000" ss:Bold="1"/>
   <NumberFormat ss:Format="#,##0"/>
  </Style>
  <Style ss:ID="s65">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="13"
    ss:Color="#000000" ss:Bold="1"/>
  </Style>
 </Styles>
 <Worksheet ss:Name="Лист1">
  <Table ss:ExpandedColumnCount="6" ss:ExpandedRowCount="<?php echo count($bills['data']) + 6; ?>" x:FullColumns="1"
   x:FullRows="1">
   <Column ss:AutoFitWidth="0" ss:Width="29.25"/>
   <Column ss:AutoFitWidth="0" ss:Width="275.25"/>
   <Column ss:Width="62.25"/>
   <Column ss:Width="66"/>
   <Column ss:Width="99"/>
   <Column ss:Width="69"/>
   <Row ss:Height="17.25">
    <Cell ss:MergeAcross="4" ss:StyleID="s65"><Data ss:Type="String">Отчет Задолженность АБ1 на <?php echo Helpers_DateTime::getDateFormatRus(Request_RequestParams::getParamDateTime('date')); ?></Data></Cell>
   </Row>
   <Row ss:Height="17.25"></Row>
   <Row>
    <Cell ss:StyleID="s66"><Data ss:Type="String">№</Data></Cell>
    <Cell ss:StyleID="s66"><Data ss:Type="String">Клиент</Data></Cell>
    <Cell ss:StyleID="s66"><Data ss:Type="String">Дата заезда</Data></Cell>
    <Cell ss:StyleID="s66"><Data ss:Type="String">Дата выезда</Data></Cell>
    <Cell ss:StyleID="s66"><Data ss:Type="String">Оплаченная сумма</Data></Cell>
    <Cell ss:StyleID="s66"><Data ss:Type="String">Даты оплаты</Data></Cell>
   </Row>
   <?php $i = 0; foreach ($bills['data'] as $bill) { $i++;?>
   <Row ss:AutoFitHeight="1">
    <Cell ss:StyleID="s76"><Data ss:Type="Number"><?php echo $i; ?></Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String"><?php echo $bill['client']; ?></Data></Cell>
    <Cell ss:StyleID="s77"><Data ss:Type="DateTime"><?php echo $bill['date_from']; ?></Data></Cell>
    <Cell ss:StyleID="s77"><Data ss:Type="DateTime"><?php echo $bill['date_to']; ?></Data></Cell>
    <Cell ss:StyleID="s78"><Data ss:Type="Number"><?php echo $bill['paid_amount']; ?></Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String"><?php echo $bill['paid_date']; ?></Data></Cell>
   </Row>
   <?php } ?>
   <Row>
    <Cell ss:Index="4" ss:StyleID="s75"><Data ss:Type="String">Итого:</Data></Cell>
    <Cell ss:StyleID="s79"><Data ss:Type="Number"><?php echo $bills['paid_amount']; ?></Data></Cell>
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
     <ActiveRow>6</ActiveRow>
     <ActiveCol>5</ActiveCol>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>
