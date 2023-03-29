<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
          xmlns:o="urn:schemas-microsoft-com:office:office"
          xmlns:x="urn:schemas-microsoft-com:office:excel"
          xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
          xmlns:html="http://www.w3.org/TR/REC-html40">
    <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
        <Author>Kuk</Author>
        <LastAuthor>Kuk</LastAuthor>
        <LastPrinted>2017-06-04T07:44:09Z</LastPrinted>
        <Created>2017-06-04T07:41:16Z</Created>
        <Company>Hewlett-Packard</Company>
        <Version>11.9999</Version>
    </DocumentProperties>
    <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
        <WindowHeight>10035</WindowHeight>
        <WindowWidth>20115</WindowWidth>
        <WindowTopX>360</WindowTopX>
        <WindowTopY>60</WindowTopY>
        <ProtectStructure>False</ProtectStructure>
        <ProtectWindows>False</ProtectWindows>
    </ExcelWorkbook>
    <Styles>
        <Style ss:ID="Default" ss:Name="Normal">
            <Alignment ss:Vertical="Bottom"/>
            <Borders/>
            <Font ss:FontName="Arial Cyr" x:CharSet="204"/>
            <Interior/>
            <NumberFormat/>
            <Protection/>
        </Style>
        <Style ss:ID="s21">
            <Alignment ss:Horizontal="Center" ss:Vertical="Bottom"/>
            <Borders>
             <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
            </Borders>
              <Font ss:FontName="Arial Cyr" x:CharSet="204" ss:Bold="1"/>
        </Style>
        <Style ss:ID="s22">
            <Alignment ss:Horizontal="Left" ss:Vertical="Bottom"/>
            <Borders>
             <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
            <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
            </Borders>
        </Style>
    </Styles>
    <Worksheet ss:Name="Лист1">
        <Table ss:ExpandedColumnCount="2" ss:ExpandedRowCount="<?php echo count($data['view::shopbill/save/root-group-by-bill-amount']->childs) + 1; ?>" x:FullColumns="1"
               x:FullRows="1">
            <Column ss:AutoFitWidth="0" ss:Width="222.75"/>
            <Column ss:AutoFitWidth="0" ss:Width="68.25"/>
            <Row>
                <Cell ss:StyleID="s21"><Data ss:Type="String">Торговая точка</Data></Cell>
                <Cell ss:StyleID="s21"><Data ss:Type="String">Сумма</Data></Cell>
            </Row>
            <?php
            foreach ($data['view::shopbill/save/root-group-by-bill-amount']->childs as $value) {
                echo $value->str."\r\n";
            }
            ?>
        </Table>
        <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
            <PageSetup>
                <Layout x:Orientation="Landscape"/>
                <PageMargins x:Bottom="0.984251969" x:Left="0.39" x:Right="0.53" x:Top="0.49"/>
            </PageSetup>
            <Print>
                <ValidPrinterInfo/>
                <PaperSizeIndex>9</PaperSizeIndex>
                <HorizontalResolution>600</HorizontalResolution>
                <VerticalResolution>0</VerticalResolution>
            </Print>
            <Selected/>
            <Panes>
                <Pane>
                    <Number>3</Number>
                    <ActiveRow>2</ActiveRow>
                    <RangeSelection>R3C1:R3C4</RangeSelection>
                </Pane>
            </Panes>
            <ProtectObjects>False</ProtectObjects>
            <ProtectScenarios>False</ProtectScenarios>
        </WorksheetOptions>
    </Worksheet>
</Workbook>