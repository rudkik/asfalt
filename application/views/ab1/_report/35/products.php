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
  <Created>2018-06-19T10:08:26Z</Created>
  <LastSaved>2018-06-19T10:16:04Z</LastSaved>
  <Version>11.9999</Version>
 </DocumentProperties>
 <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
  <WindowHeight>4890</WindowHeight>
  <WindowWidth>17970</WindowWidth>
  <WindowTopX>32760</WindowTopX>
  <WindowTopY>32760</WindowTopY>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Bottom"/>
   <Borders/>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="9"
    ss:Color="#000000"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="s62" ss:Name="Обычный 2">
   <Alignment ss:Horizontal="Left" ss:Vertical="Top" ss:WrapText="1"/>
   <Borders/>
   <Font x:CharSet="204" x:Family="Swiss" ss:Size="9" ss:Color="#000000"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="s73">
   <Alignment ss:Vertical="Center" ss:WrapText="1"/>
   <NumberFormat ss:Format="General Date"/>
  </Style>
  <Style ss:ID="s74">
   <Alignment ss:Vertical="Center" ss:WrapText="1"/>
  </Style>
  <Style ss:ID="s75">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="9"
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
   <NumberFormat ss:Format="0.000"/>
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
  <Style ss:ID="s80">
   <Alignment ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <NumberFormat ss:Format="General Date"/>
  </Style>
  <Style ss:ID="s82" ss:Parent="s62">
   <Alignment ss:Horizontal="Center" ss:Vertical="Top" ss:WrapText="1"/>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="14"
    ss:Bold="1"/>
  </Style>
  <Style ss:ID="s83" ss:Parent="s62">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="12"
    ss:Italic="1"/>
  </Style>
 </Styles>
 <Worksheet ss:Name="Лист1">
     <Names>
         <NamedRange ss:Name="Print_Titles" ss:RefersTo="=Лист1!R3"/>
     </Names>
  <Table ss:ExpandedColumnCount="12" ss:ExpandedRowCount="<?php echo count($products['data']) + 8; ?>" x:FullColumns="1"
   x:FullRows="1">
      <Column ss:AutoFitWidth="0" ss:Width="47.25"/>
      <Column ss:AutoFitWidth="0" ss:Width="45.75"/>
      <Column ss:AutoFitWidth="0" ss:Width="45"/>
      <Column ss:AutoFitWidth="0" ss:Width="109.25"/>
      <Column ss:Width="44.25"/>
      <Column ss:Width="55.5"/>
      <Column ss:AutoFitWidth="0" ss:Width="119"/>
      <Column ss:Width="34.5" ss:Span="1"/>
      <Column ss:Index="10" ss:Width="46.5"/>
      <Column ss:AutoFitWidth="0" ss:Width="103.5"/>
      <Column ss:AutoFitWidth="0" ss:Width="78"/>
   <Row ss:AutoFitHeight="0" ss:Height="18.75">
    <Cell ss:MergeAcross="11" ss:StyleID="s82"><Data ss:Type="String">Отгружено продукции</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="20.75">
    <Cell ss:MergeAcross="11" ss:StyleID="s83"><Data ss:Type="String">Отчет за период: с <?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds(Request_RequestParams::getParamStr('created_at_from')); ?> до <?php echo Helpers_DateTime::getDateTimeRusWithoutSeconds(Request_RequestParams::getParamStr('created_at_to')); ?></Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="1">
    <Cell ss:StyleID="s75"><Data ss:Type="String">Дата создания </Data><NamedCell
                ss:Name="Print_Titles"/></Cell>
    <Cell ss:StyleID="s75"><Data ss:Type="String">Дата въезда</Data><NamedCell
                ss:Name="Print_Titles"/></Cell>
    <Cell ss:StyleID="s75"><Data ss:Type="String">Дата выезда </Data><NamedCell
                ss:Name="Print_Titles"/></Cell>
    <Cell ss:StyleID="s75"><Data ss:Type="String">Клиент </Data><NamedCell
                ss:Name="Print_Titles"/></Cell>
    <Cell ss:StyleID="s75"><Data ss:Type="String">№ авто </Data><NamedCell
                ss:Name="Print_Titles"/></Cell>
    <Cell ss:StyleID="s75"><Data ss:Type="String"><?php echo htmlspecialchars(Func::mb_ucfirst(Arr::path($shopOptions, 'report.driver.position', 'Водитель')), ENT_XML1); ?> </Data><NamedCell
                ss:Name="Print_Titles"/></Cell>
    <Cell ss:StyleID="s75"><Data ss:Type="String">Продукт </Data><NamedCell
                ss:Name="Print_Titles"/></Cell>
    <Cell ss:StyleID="s75"><Data ss:Type="String">Тара</Data><NamedCell
                ss:Name="Print_Titles"/></Cell>
    <Cell ss:StyleID="s75"><Data ss:Type="String">Вес </Data><NamedCell
                ss:Name="Print_Titles"/></Cell>
    <Cell ss:StyleID="s75"><Data ss:Type="String">Сумма </Data><NamedCell
                ss:Name="Print_Titles"/></Cell>
    <Cell ss:StyleID="s75"><Data ss:Type="String">Место погрузки </Data><NamedCell
                ss:Name="Print_Titles"/></Cell>
    <Cell ss:StyleID="s75"><Data ss:Type="String">Оператор </Data><NamedCell
                ss:Name="Print_Titles"/></Cell>
   </Row>
   <?php foreach ($products['data'] as $product){ ?>
   <Row ss:AutoFitHeight="1">
    <Cell ss:StyleID="s80"><Data ss:Type="String"><?php echo $product['created_at']; ?></Data></Cell>
    <Cell ss:StyleID="s80"><Data ss:Type="String"><?php echo $product['weighted_entry_at']; ?></Data></Cell>
    <Cell ss:StyleID="s80"><Data ss:Type="String"><?php echo $product['exit_at']; ?></Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String"><?php echo $product['shop_client_name']; ?></Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String"><?php echo $product['name']; ?></Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String"><?php echo $product['shop_driver_name']; ?></Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String"><?php echo $product['shop_product_name']; ?></Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="Number"><?php echo $product['tarra']; ?></Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="Number"><?php echo $product['quantity']; ?></Data></Cell>
    <Cell ss:StyleID="s78"><Data ss:Type="Number"><?php echo $product['amount']; ?></Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String"><?php echo $product['shop_turn_place_name']; ?></Data></Cell>
    <Cell ss:StyleID="s76"><Data ss:Type="String"><?php echo $product['cash_operation_name']; ?></Data></Cell>
   </Row>
   <?php } ?>
   <Row ss:AutoFitHeight="0"/>
      <Row  ss:AutoFitHeight="0" ss:Height="15">
          <Cell ss:MergeAcross="11"><ss:Data ss:Type="String"
                                                              xmlns="http://www.w3.org/TR/REC-html40"><Font html:Color="#000000">Оператор:</Font><B><Font
                              html:Color="#000000"> <?php echo htmlspecialchars($operation['name'], ENT_XML1); ?>   _________________</Font></B></ss:Data></Cell>
      </Row>
   <Row ss:AutoFitHeight="0">
    <Cell ss:MergeAcross="11"><ss:Data ss:Type="String" xmlns="http://www.w3.org/TR/REC-html40"><Font
      html:Color="#000000">Сформирован:</Font><B><Font html:Color="#000000"> <?php echo date('d.m.Y H:i'); ?></Font></B></ss:Data></Cell>
   </Row>
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <PageSetup>
       <Layout x:Orientation="Landscape"/>
       <Header x:Margin="0.3"
               x:Data="&amp;L<?php echo $shop; ?>&amp;CОтгружено продукции &#10;&amp;RАБЦ &#10;стр. &amp;P из &amp;N"/>
       <Footer x:Margin="0.3"/>
       <PageMargins x:Bottom="0.75" x:Left="0.25" x:Right="0.25" x:Top="0.75"/>
   </PageSetup>
   <Print>
    <ValidPrinterInfo/>
    <PaperSizeIndex>9</PaperSizeIndex>
    <HorizontalResolution>-4</HorizontalResolution>
    <VerticalResolution>1200</VerticalResolution>
   </Print>
      <Selected/>
      <FreezePanes/>
      <FrozenNoSplit/>
      <SplitHorizontal>3</SplitHorizontal>
      <TopRowBottomPane>3</TopRowBottomPane>
      <ActivePane>2</ActivePane>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>13</ActiveRow>
     <ActiveCol>8</ActiveCol>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>
