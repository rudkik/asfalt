<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Author>Сладушка</Author>
  <LastAuthor>User</LastAuthor>
  <Created>2018-05-14T08:48:37Z</Created>
  <LastSaved>2018-10-01T07:48:08Z</LastSaved>
  <Version>12.00</Version>
 </DocumentProperties>
 <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
  <WindowHeight>7995</WindowHeight>
  <WindowWidth>20115</WindowWidth>
  <WindowTopX>1</WindowTopX>
  <WindowTopY>1</WindowTopY>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Center"/>
   <Borders/>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="11"
    ss:Color="#000000"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="s291">
   <Alignment ss:Vertical="Center"/>
   <Borders/>
   <Interior/>
   <NumberFormat ss:Format="Fixed"/>
  </Style>
  <Style ss:ID="s337">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="12"
    ss:Color="#000000" ss:Bold="1"/>
   <Interior/>
  </Style>
  <Style ss:ID="s340">
   <Alignment ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="12"
    ss:Color="#000000"/>
   <Interior/>
  </Style>
  <Style ss:ID="s341">
   <Alignment ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="12"
    ss:Color="#000000"/>
   <Interior/>
  </Style>
  <Style ss:ID="s347">
   <Alignment ss:Horizontal="Right" ss:Vertical="Center"/>
   <Borders/>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="12"
    ss:Color="#000000" ss:Bold="1"/>
   <Interior/>
  </Style>
  <Style ss:ID="s350">
   <Alignment ss:Horizontal="Right" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="12"/>
   <Interior/>
   <NumberFormat/>
  </Style>
  <Style ss:ID="s351">
   <Alignment ss:Horizontal="Right" ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="12"
    ss:Color="#000000"/>
   <Interior/>
   <NumberFormat/>
  </Style>
 </Styles>
 <Worksheet ss:Name="Отчет">
  <Table ss:ExpandedColumnCount="8" ss:ExpandedRowCount="<?php echo count($goods['data']) + 2; ?>" x:FullColumns="1"
   x:FullRows="1" ss:StyleID="s291" ss:DefaultColumnWidth="34.5"
   ss:DefaultRowHeight="15.75">
   <Column ss:StyleID="s291" ss:Width="47.25"/>
   <Column ss:StyleID="s291" ss:Width="212.25"/>
   <Column ss:StyleID="s291" ss:Width="47.25"/>
   <Column ss:StyleID="s291" ss:Width="60"/>
   <Column ss:StyleID="s291" ss:Width="93"/>
   <Column ss:StyleID="s291" ss:Width="93.75"/>
   <Column ss:StyleID="s291" ss:Width="102.75"/>
   <Column ss:StyleID="s291" ss:Width="78"/>
   <Row>
    <Cell ss:StyleID="s337"><Data ss:Type="String">№</Data></Cell>
    <Cell ss:StyleID="s337"><Data ss:Type="String">Наименование продукта</Data></Cell>
    <Cell ss:StyleID="s337"><Data ss:Type="String">Вес (кг) </Data></Cell>
    <Cell ss:StyleID="s337"><Data ss:Type="String">Цена за кг</Data></Cell>
    <Cell ss:StyleID="s337"><Data ss:Type="String">Забрал коробок</Data></Cell>
    <Cell ss:StyleID="s337"><Data ss:Type="String">Вернул коробок</Data></Cell>
    <Cell ss:StyleID="s337"><Data ss:Type="String">Продано коробок</Data></Cell>
    <Cell ss:StyleID="s337"><Data ss:Type="String">Сумма</Data></Cell>
   </Row>
   <?php $i = 0; foreach ($goods['data'] as $good){ $i++; ?>
   <Row ss:AutoFitHeight="0">
    <Cell ss:StyleID="s340"><Data ss:Type="Number"><?php echo $i; ?></Data></Cell>
    <Cell ss:StyleID="s341"><Data ss:Type="String"><?php echo htmlspecialchars($good['name'], ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s341"><Data ss:Type="Number"><?php echo htmlspecialchars($good['weight'], ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s341"><Data ss:Type="Number"><?php echo htmlspecialchars($good['price'], ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s341"><Data ss:Type="Number"><?php echo htmlspecialchars($good['took'], ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s341"><Data ss:Type="Number"><?php echo htmlspecialchars($good['took'] - $good['quantity'], ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s341"><Data ss:Type="Number"><?php echo htmlspecialchars($good['quantity'], ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s341"><Data ss:Type="Number"><?php echo htmlspecialchars($good['amount'], ENT_XML1); ?></Data></Cell>
   </Row>
   <?php } ?>
   <Row ss:AutoFitHeight="0">
    <Cell ss:Index="6" ss:StyleID="Default"/>
    <Cell ss:StyleID="s347"><Data ss:Type="String">Итого:</Data></Cell>
    <Cell ss:StyleID="s350"><Data ss:Type="Number"><?php echo $goods['amount']; ?></Data></Cell>
   </Row>
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <PageSetup>
    <Header x:Margin="0.3"/>
    <Footer x:Margin="0.3"/>
    <PageMargins x:Bottom="0.75" x:Left="0.7" x:Right="0.7" x:Top="0.75"/>
   </PageSetup>
   <Print>
    <ValidPrinterInfo/>
    <PaperSizeIndex>9</PaperSizeIndex>
    <HorizontalResolution>1</HorizontalResolution>
    <VerticalResolution>1</VerticalResolution>
   </Print>
   <Selected/>
   <LeftColumnVisible>2</LeftColumnVisible>
   <FreezePanes/>
   <FrozenNoSplit/>
   <SplitHorizontal>1</SplitHorizontal>
   <TopRowBottomPane>1</TopRowBottomPane>
   <ActivePane>2</ActivePane>
   <Panes>
    <Pane>
     <Number>3</Number>
    </Pane>
    <Pane>
     <Number>2</Number>
     <ActiveRow>2</ActiveRow>
     <ActiveCol>1</ActiveCol>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>
