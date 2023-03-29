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
  <WindowHeight>12510</WindowHeight>
  <WindowWidth>24240</WindowWidth>
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
  <Style ss:ID="s20">
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="18"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s21">
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="66"
    ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s23">
   <Font ss:FontName="Code EAN13" x:CharSet="2" ss:Size="18" ss:Color="#000000"/>
  </Style>
  <Style ss:ID="s26">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="DashDotDot" ss:Weight="1"
     ss:Color="#808080"/>
    <Border ss:Position="Left" ss:LineStyle="DashDotDot" ss:Weight="1"
     ss:Color="#808080"/>
   </Borders>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="18"
    ss:Color="#000000" ss:Bold="1"/>
  </Style>
  <Style ss:ID="s27">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="DashDotDot" ss:Weight="1"
     ss:Color="#808080"/>
    <Border ss:Position="Right" ss:LineStyle="DashDotDot" ss:Weight="1"
     ss:Color="#808080"/>
   </Borders>
   <Font ss:FontName="Calibri" x:CharSet="204" x:Family="Swiss" ss:Size="18"
    ss:Color="#000000" ss:Bold="1"/>
  </Style>
  <Style ss:ID="s28">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders/>
   <Font ss:FontName="Code EAN13" x:CharSet="2" ss:Size="64"/>
  </Style>
  <Style ss:ID="s29">
   <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
   <Borders>
    <Border ss:Position="Right" ss:LineStyle="DashDotDot" ss:Weight="1"
     ss:Color="#808080"/>
   </Borders>
   <Font ss:FontName="Code EAN13" x:CharSet="2" ss:Size="64"/>
  </Style>
 </Styles>
 <Worksheet ss:Name="Для лотков">
  <Table ss:ExpandedColumnCount="5" ss:ExpandedRowCount="<?php echo count($productions['data']) + 5; ?>" x:FullColumns="1"
   x:FullRows="1" ss:DefaultRowHeight="15">
   <Column ss:AutoFitWidth="0" ss:Width="251.25" ss:Span="1"/>
   <Column ss:Index="5" ss:Width="228"/>
   <?php
   $i = 0;
   $j = 0;
   $data = array();
   foreach ($productions['data'] as $production) {
       $i++;
       if($i % 2 == 1){
           $data[$j] = array(
               'left' => $production,
               'right' => array(
                   'name' => '',
                   'barcode' => '',
               ),
           );
       }else{
           $data[$j]['right'] = $production;
           $j++;
       }
   }
   ?>
   <?php foreach ($data as $production){?>
   <Row ss:AutoFitHeight="0" ss:Height="82.5" ss:StyleID="s21">
    <?php $barcode = Helpers_Excel::getEncodeEAN13($production['left']['barcode']); ?>
    <Cell ss:StyleID="s29" ss:Formula="<?php echo $barcode; ?>">
        <Data ss:Type="String"><?php if(!empty($barcode)){ ?>2AAMKAK*aaaaaa+<?php }?></Data></Cell>
    <?php $barcode = Helpers_Excel::getEncodeEAN13($production['right']['barcode']); ?>
    <Cell ss:StyleID="s28" ss:Formula="<?php echo $barcode; ?>">
        <Data ss:Type="String"><?php if(!empty($barcode)){ ?>2AAMKAK*aaaaaa+<?php }?></Data></Cell>
   </Row>
   <Row ss:Height="46.5" ss:StyleID="s20">
    <Cell ss:StyleID="s27"><Data ss:Type="String"><?php echo htmlspecialchars($production['left']['name'], ENT_XML1); ?></Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="String"><?php echo htmlspecialchars($production['right']['name'], ENT_XML1); ?></Data></Cell>
    <Cell ss:Index="5" ss:StyleID="s23"/>
   </Row>
   <?php }?>
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <PageSetup>    
    <Header x:Margin="0.31496062992125984"
     x:Data="&amp;C&amp;&quot;-,полужирный&quot;&amp;14Список продукций для лотков&#10;"/>
    <Footer x:Margin="0.31496062992125984"/>
    <PageMargins x:Bottom="0.35433070866141736" x:Left="0.23622047244094491"
     x:Right="0.23622047244094491" x:Top="0.74803149606299213"/>
   </PageSetup>
   <Print>
    <ValidPrinterInfo/>
    <PaperSizeIndex>9</PaperSizeIndex>
    <HorizontalResolution>600</HorizontalResolution>
    <VerticalResolution>600</VerticalResolution>
   </Print>
   <Selected/>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>