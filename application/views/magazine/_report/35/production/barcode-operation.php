<?xml version="1.0"?>
<?mso-application progid="Excel.Sheet"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Author>Kim.E</Author>
  <LastAuthor>Kuk</LastAuthor>
  <LastPrinted>2020-01-16T05:44:47Z</LastPrinted>
  <Created>2019-11-04T05:13:50Z</Created>
  <LastSaved>2020-01-16T05:46:34Z</LastSaved>
  <Version>16.00</Version>
 </DocumentProperties>
 <OfficeDocumentSettings xmlns="urn:schemas-microsoft-com:office:office">
  <AllowPNG/>
 </OfficeDocumentSettings>
 <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
  <WindowHeight>11760</WindowHeight>
  <WindowWidth>19095</WindowWidth>
  <WindowTopX>120</WindowTopX>
  <WindowTopY>75</WindowTopY>
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
  <Style ss:ID="s16">
   <Font ss:FontName="Code EAN13" x:CharSet="2" ss:Size="11" ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s17">
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s20">
   <Alignment ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s21">
   <Alignment ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="11"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s47">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Font ss:FontName="Code EAN13" x:CharSet="2" ss:Size="36" ss:Color="#000000"/>
   <Interior ss:Color="#1F497D" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="s99">
   <Alignment ss:Vertical="Top"/>
   <Font ss:FontName="Code EAN13" x:CharSet="2" ss:Size="36" ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s101">
   <Alignment ss:Vertical="Top"/>
  </Style>
 </Styles>
 <Worksheet ss:Name="Для оператора">
  <Table ss:ExpandedColumnCount="7" ss:ExpandedRowCount="<?php echo count($productions['data']) + 10; ?>" x:FullColumns="1"
   x:FullRows="1" ss:DefaultRowHeight="15">
   <Column ss:StyleID="s101" ss:AutoFitWidth="0" ss:Width="103.5"/>
   <Column ss:AutoFitWidth="0" ss:Width="132.75"/>
   <Column ss:Width="21" ss:Span="1"/>
   <Column ss:Index="5" ss:AutoFitWidth="0" ss:Width="132.75"/>
   <Column ss:StyleID="s101" ss:AutoFitWidth="0" ss:Width="103.5"/>
   <Column ss:AutoFitWidth="0" ss:Width="105.75"/>
   <?php $i = 0; foreach ($productions['data'] as $production){ $i++;?>
   <?php $barcode = Helpers_Excel::getEncodeEAN13($production['barcode']); ?>
   <?php if($i % 2 == 1){?>
   <Row ss:AutoFitHeight="0" ss:Height="47.25">
    <Cell ss:StyleID="s99" ss:Formula="<?php echo $barcode; ?>">
        <Data ss:Type="String"><?php if(!empty($barcode)){ ?>2AAMKAK*aaaaaa+<?php }?></Data></Cell>
    <Cell ss:StyleID="s21"><Data ss:Type="String"><?php echo htmlspecialchars($production['name'], ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s20"><Data ss:Type="Number"><?php echo $i; ?></Data></Cell>
   <?php }else{?>       
    <Cell ss:StyleID="s20"><Data ss:Type="Number"><?php echo $i; ?></Data></Cell>
    <Cell ss:StyleID="s21"><Data ss:Type="String"><?php echo htmlspecialchars($production['name'], ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s99" ss:Formula="<?php echo $barcode; ?>">
        <Data ss:Type="String"><?php if(!empty($barcode)){ ?>2AAMKAK*aaaaaa+<?php }?></Data></Cell>
    <Cell ss:StyleID="s16"/>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="12.75">
    <Cell ss:MergeAcross="5" ss:StyleID="s47"/>
    <Cell ss:StyleID="s16"/>
   </Row>
   <?php }?>
   <?php }?>
   <?php if($i % 2 == 1){?>     
    <Cell ss:StyleID="s20"></Cell>
    <Cell ss:StyleID="s21"></Cell>
    <Cell ss:StyleID="s99"></Cell>
    <Cell ss:StyleID="s16"/>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="12.75">
    <Cell ss:MergeAcross="5" ss:StyleID="s47"/>
    <Cell ss:StyleID="s16"/>
   </Row>
   <?php }?>
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <PageSetup>
    <Header x:Margin="0.31496062992125984"
     x:Data="&amp;C&amp;&quot;-,полужирный&quot;&amp;14Список продукций для оператора&#10;"/>
    <Footer x:Margin="0.31496062992125984"/>
    <PageMargins x:Bottom="0.39370078740157483" x:Left="0.23622047244094491"
     x:Right="0.23622047244094491" x:Top="0.74803149606299213"/>
   </PageSetup>
   <Print>
    <ValidPrinterInfo/>
    <PaperSizeIndex>9</PaperSizeIndex>
    <HorizontalResolution>600</HorizontalResolution>
    <VerticalResolution>600</VerticalResolution>
   </Print>
   <Selected/>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>2</ActiveRow>
     <ActiveCol>9</ActiveCol>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>