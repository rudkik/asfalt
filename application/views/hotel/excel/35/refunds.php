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
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
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
   <Table ss:ExpandedColumnCount="8" ss:ExpandedRowCount="<?php echo count($refunds['data']) + 6; ?>" x:FullColumns="1"
   x:FullRows="1" ss:StyleID="Default">
   <Column ss:AutoFitWidth="0" ss:Width="18"/>
   <Column ss:Width="56.25"/>
   <Column ss:AutoFitWidth="0" ss:Width="253.75"/>
   <Column ss:Width="57.75"/>
   <Row ss:Height="17.25">
    <Cell ss:MergeAcross="4" ss:StyleID="s65"><Data ss:Type="String">Отчет по возвратам базы отдыха Кара Дала с <?php echo Helpers_DateTime::getDateFormatRus(Request_RequestParams::getParamDateTime('period_from')); ?> по <?php echo Helpers_DateTime::getDateFormatRus(Request_RequestParams::getParamDateTime('period_to')); ?></Data></Cell>
   </Row>
   <Row ss:Index="3">
    <Cell ss:StyleID="s76"><Data ss:Type="String">№</Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String">Дата</Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String">Контрагент</Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String">Сумма</Data></Cell>
   </Row>
   <?php $i = 1; foreach ($refunds['data'] as $refund){ ?>
   <Row ss:AutoFitHeight="1">
    <Cell ss:StyleID="s81"><Data ss:Type="Number"><?php echo $i; ?></Data></Cell>
    <Cell ss:StyleID="s83"><Data ss:Type="DateTime"><?php echo $refund['date']; ?></Data></Cell>
    <Cell ss:StyleID="s82"><Data ss:Type="String"><?php echo htmlspecialchars($refund['client'], ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s84"><Data ss:Type="Number"><?php echo $refund['amount']; ?></Data></Cell>
   </Row>
   <?php $i++; } ?>
   <Row ss:AutoFitHeight="1">
    <Cell ss:StyleID="s82"><Data ss:Type="String"></Data></Cell>
    <Cell ss:StyleID="s82"><Data ss:Type="String"></Data></Cell>
    <Cell ss:StyleID="s82"><Data ss:Type="String"></Data></Cell>
    <Cell ss:StyleID="s84"><Data ss:Type="Number"><?php echo $refunds['amount']; ?></Data></Cell>
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
