{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
{!! '<' . '?mso-application progid="Excel.Sheet"?' . '>' !!}
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <Author>E-PKK Kabupaten Nganjuk</Author>
  <Created>{{ date('Y-m-d\TH:i:s\Z') }}</Created>
  <Company>TP PKK Kabupaten Nganjuk</Company>
 </DocumentProperties>
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Center"/>
   <Borders/>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Color="#000000"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="Title">
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="15" ss:Bold="1" ss:Color="#1E293B"/>
   <Alignment ss:Horizontal="Left" ss:Vertical="Center"/>
  </Style>
  <Style ss:ID="Subtitle">
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="11" ss:Italic="1" ss:Color="#475569"/>
   <Alignment ss:Horizontal="Left" ss:Vertical="Center"/>
  </Style>
  <Style ss:ID="HeaderBase">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center" ss:WrapText="1"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#94A3B8"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#94A3B8"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#94A3B8"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#94A3B8"/>
   </Borders>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="10" ss:Bold="1"/>
  </Style>
  <Style ss:ID="HeaderPanganMain" ss:Parent="HeaderBase">
   <Interior ss:Color="#FEF08A" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="HeaderPanganSub" ss:Parent="HeaderBase">
   <Interior ss:Color="#FEF9C3" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="HeaderSandangMain" ss:Parent="HeaderBase">
   <Interior ss:Color="#FBCFE8" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="HeaderSandangSub" ss:Parent="HeaderBase">
   <Interior ss:Color="#FCE7F3" ss:Pattern="Solid"/>
  </Style>
  <Style ss:ID="CellCenter">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CBD5E1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CBD5E1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CBD5E1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CBD5E1"/>
   </Borders>
  </Style>
  <Style ss:ID="CellLeft">
   <Alignment ss:Horizontal="Left" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CBD5E1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CBD5E1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CBD5E1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CBD5E1"/>
   </Borders>
  </Style>
  <Style ss:ID="CellNumber">
   <Alignment ss:Horizontal="Right" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CBD5E1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CBD5E1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CBD5E1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#CBD5E1"/>
   </Borders>
   <NumberFormat ss:Format="#,##0"/>
  </Style>
  <Style ss:ID="CellTotal">
   <Alignment ss:Horizontal="Right" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Double" ss:Weight="2" ss:Color="#475569"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#475569"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#475569"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#475569"/>
   </Borders>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="10" ss:Bold="1"/>
   <Interior ss:Color="#F1F5F9" ss:Pattern="Solid"/>
   <NumberFormat ss:Format="#,##0"/>
  </Style>
  <Style ss:ID="CellTotalLabel">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Double" ss:Weight="2" ss:Color="#475569"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#475569"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#475569"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1" ss:Color="#475569"/>
   </Borders>
   <Font ss:FontName="Calibri" x:Family="Swiss" ss:Size="10" ss:Bold="1"/>
   <Interior ss:Color="#F1F5F9" ss:Pattern="Solid"/>
  </Style>
 </Styles>

 @if($bidang == 'semua' || $bidang == 'pangan')
 {{-- WORKSHEET 1: PROGRAM PANGAN --}}
 <Worksheet ss:Name="Program Pangan">
  <Table ss:DefaultRowHeight="20">
   <Column ss:Width="35"/>
   <Column ss:Width="120"/>
   <Column ss:Width="120"/>
   <Column ss:Width="80"/>
   <Column ss:Width="65"/>
   <Column ss:Width="65"/>
   <Column ss:Width="65"/>
   <Column ss:Width="65"/>
   <Column ss:Width="65"/>
   <Column ss:Width="65"/>
   <Column ss:Width="65"/>
   <Column ss:Width="65"/>
   <Column ss:Width="65"/>
   <Column ss:Width="75"/>
   <Column ss:Width="80"/>
   <Column ss:Width="110"/>

   {{-- Judul --}}
   <Row ss:Height="24">
    <Cell ss:StyleID="Title"><Data ss:Type="String">LAPORAN PROGRAM PANGAN - TP PKK KABUPATEN NGANJUK</Data></Cell>
   </Row>
   <Row ss:Height="18">
    <Cell ss:StyleID="Subtitle"><Data ss:Type="String">Periode: {{ $periodeText }} | Sumber: Sistem E-PKK (Status: Disetujui)</Data></Cell>
   </Row>
   <Row ss:Height="10"/>

   {{-- Header Baris 1 --}}
   <Row ss:Height="24">
    <Cell ss:MergeDown="2" ss:StyleID="HeaderPanganMain"><Data ss:Type="String">NO</Data></Cell>
    <Cell ss:MergeDown="2" ss:StyleID="HeaderPanganMain"><Data ss:Type="String">KECAMATAN</Data></Cell>
    <Cell ss:MergeDown="2" ss:StyleID="HeaderPanganMain"><Data ss:Type="String">DESA / KELURAHAN</Data></Cell>
    <Cell ss:MergeDown="2" ss:StyleID="HeaderPanganMain"><Data ss:Type="String">JML KADER PANGAN</Data></Cell>
    <Cell ss:MergeAcross="8" ss:StyleID="HeaderPanganMain"><Data ss:Type="String">PANGAN</Data></Cell>
    <Cell ss:MergeDown="2" ss:StyleID="HeaderPanganMain"><Data ss:Type="String">STATUS</Data></Cell>
    <Cell ss:MergeDown="2" ss:StyleID="HeaderPanganMain"><Data ss:Type="String">TANGGAL LAPORAN</Data></Cell>
   </Row>

   {{-- Header Baris 2 --}}
   <Row ss:Height="22">
    <Cell ss:Index="5" ss:MergeAcross="1" ss:StyleID="HeaderPanganSub"><Data ss:Type="String">MAKANAN POKOK</Data></Cell>
    <Cell ss:MergeAcross="6" ss:StyleID="HeaderPanganSub"><Data ss:Type="String">PEMANFAATAN PEKARANGAN / HATINYA PKK</Data></Cell>
   </Row>

   {{-- Header Baris 3 --}}
   <Row ss:Height="22">
    <Cell ss:Index="5" ss:StyleID="HeaderPanganSub"><Data ss:Type="String">Beras</Data></Cell>
    <Cell ss:StyleID="HeaderPanganSub"><Data ss:Type="String">Non Beras</Data></Cell>
    <Cell ss:StyleID="HeaderPanganSub"><Data ss:Type="String">Peternakan</Data></Cell>
    <Cell ss:StyleID="HeaderPanganSub"><Data ss:Type="String">Perikanan</Data></Cell>
    <Cell ss:StyleID="HeaderPanganSub"><Data ss:Type="String">Warung Hidup</Data></Cell>
    <Cell ss:StyleID="HeaderPanganSub"><Data ss:Type="String">Lumbung Hidup</Data></Cell>
    <Cell ss:StyleID="HeaderPanganSub"><Data ss:Type="String">TOGA</Data></Cell>
    <Cell ss:StyleID="HeaderPanganSub"><Data ss:Type="String">Tan. Keras</Data></Cell>
    <Cell ss:StyleID="HeaderPanganSub"><Data ss:Type="String">Tan. Lainnya</Data></Cell>
   </Row>

   {{-- Baris Data --}}
   @php
    $noP = 1;
    $sKaderP = 0; $sBeras = 0; $sNonBeras = 0; $sTernak = 0; $sIkan = 0;
    $sWarung = 0; $sLumbung = 0; $sToga = 0; $sKeras = 0; $sLainnya = 0;
   @endphp
   @forelse($panganData as $row)
   @php
    $sKaderP += $row->kader_pangan ?? 0;
    $sBeras += $row->beras ?? 0;
    $sNonBeras += $row->non_beras ?? 0;
    $sTernak += $row->peternakan ?? 0;
    $sIkan += $row->perikanan ?? 0;
    $sWarung += $row->warung_hidup ?? 0;
    $sLumbung += $row->lumbung_hidup ?? 0;
    $sToga += $row->toga ?? 0;
    $sKeras += $row->tanaman_keras ?? 0;
    $sLainnya += $row->tanaman_lainnya ?? 0;
   @endphp
   <Row ss:Height="19">
    <Cell ss:StyleID="CellCenter"><Data ss:Type="Number">{{ $noP++ }}</Data></Cell>
    <Cell ss:StyleID="CellLeft"><Data ss:Type="String">{{ $row->nama_kec ?? '-' }}</Data></Cell>
    <Cell ss:StyleID="CellLeft"><Data ss:Type="String">{{ $row->nama_desa ?? '-' }}</Data></Cell>
    <Cell ss:StyleID="CellNumber"><Data ss:Type="Number">{{ $row->kader_pangan ?? 0 }}</Data></Cell>
    <Cell ss:StyleID="CellNumber"><Data ss:Type="Number">{{ $row->beras ?? 0 }}</Data></Cell>
    <Cell ss:StyleID="CellNumber"><Data ss:Type="Number">{{ $row->non_beras ?? 0 }}</Data></Cell>
    <Cell ss:StyleID="CellNumber"><Data ss:Type="Number">{{ $row->peternakan ?? 0 }}</Data></Cell>
    <Cell ss:StyleID="CellNumber"><Data ss:Type="Number">{{ $row->perikanan ?? 0 }}</Data></Cell>
    <Cell ss:StyleID="CellNumber"><Data ss:Type="Number">{{ $row->warung_hidup ?? 0 }}</Data></Cell>
    <Cell ss:StyleID="CellNumber"><Data ss:Type="Number">{{ $row->lumbung_hidup ?? 0 }}</Data></Cell>
    <Cell ss:StyleID="CellNumber"><Data ss:Type="Number">{{ $row->toga ?? 0 }}</Data></Cell>
    <Cell ss:StyleID="CellNumber"><Data ss:Type="Number">{{ $row->tanaman_keras ?? 0 }}</Data></Cell>
    <Cell ss:StyleID="CellNumber"><Data ss:Type="Number">{{ $row->tanaman_lainnya ?? 0 }}</Data></Cell>
    <Cell ss:StyleID="CellCenter"><Data ss:Type="String">{{ ucfirst(strtolower($row->status ?? '')) }}</Data></Cell>
    <Cell ss:StyleID="CellCenter"><Data ss:Type="String">{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y') }}</Data></Cell>
   </Row>
   @empty
   <Row ss:Height="22">
    <Cell ss:MergeAcross="14" ss:StyleID="CellCenter"><Data ss:Type="String">Tidak ada data laporan program pangan pada periode ini.</Data></Cell>
   </Row>
   @endforelse

   {{-- Total Baris --}}
   <Row ss:Height="22">
    <Cell ss:MergeAcross="2" ss:StyleID="CellTotalLabel"><Data ss:Type="String">TOTAL KABUPATEN</Data></Cell>
    <Cell ss:Index="4" ss:StyleID="CellTotal"><Data ss:Type="Number">{{ $sKaderP }}</Data></Cell>
    <Cell ss:StyleID="CellTotal"><Data ss:Type="Number">{{ $sBeras }}</Data></Cell>
    <Cell ss:StyleID="CellTotal"><Data ss:Type="Number">{{ $sNonBeras }}</Data></Cell>
    <Cell ss:StyleID="CellTotal"><Data ss:Type="Number">{{ $sTernak }}</Data></Cell>
    <Cell ss:StyleID="CellTotal"><Data ss:Type="Number">{{ $sIkan }}</Data></Cell>
    <Cell ss:StyleID="CellTotal"><Data ss:Type="Number">{{ $sWarung }}</Data></Cell>
    <Cell ss:StyleID="CellTotal"><Data ss:Type="Number">{{ $sLumbung }}</Data></Cell>
    <Cell ss:StyleID="CellTotal"><Data ss:Type="Number">{{ $sToga }}</Data></Cell>
    <Cell ss:StyleID="CellTotal"><Data ss:Type="Number">{{ $sKeras }}</Data></Cell>
    <Cell ss:StyleID="CellTotal"><Data ss:Type="Number">{{ $sLainnya }}</Data></Cell>
    <Cell ss:MergeAcross="1" ss:StyleID="CellTotalLabel"><Data ss:Type="String">-</Data></Cell>
   </Row>
  </Table>
 </Worksheet>
 @endif

 @if($bidang == 'semua' || $bidang == 'sandang')
 {{-- WORKSHEET 2: PROGRAM SANDANG --}}
 <Worksheet ss:Name="Program Sandang">
  <Table ss:DefaultRowHeight="20">
   <Column ss:Width="35"/>
   <Column ss:Width="130"/>
   <Column ss:Width="130"/>
   <Column ss:Width="120"/>
   <Column ss:Width="140"/>
   <Column ss:Width="140"/>
   <Column ss:Width="90"/>
   <Column ss:Width="110"/>

   {{-- Judul --}}
   <Row ss:Height="24">
    <Cell ss:StyleID="Title"><Data ss:Type="String">LAPORAN PROGRAM SANDANG - TP PKK KABUPATEN NGANJUK</Data></Cell>
   </Row>
   <Row ss:Height="18">
    <Cell ss:StyleID="Subtitle"><Data ss:Type="String">Periode: {{ $periodeText }} | Sumber: Sistem E-PKK (Status: Disetujui)</Data></Cell>
   </Row>
   <Row ss:Height="10"/>

   {{-- Header Baris 1 --}}
   <Row ss:Height="24">
    <Cell ss:MergeDown="1" ss:StyleID="HeaderSandangMain"><Data ss:Type="String">NO</Data></Cell>
    <Cell ss:MergeDown="1" ss:StyleID="HeaderSandangMain"><Data ss:Type="String">KECAMATAN</Data></Cell>
    <Cell ss:MergeDown="1" ss:StyleID="HeaderSandangMain"><Data ss:Type="String">DESA / KELURAHAN</Data></Cell>
    <Cell ss:MergeDown="1" ss:StyleID="HeaderSandangMain"><Data ss:Type="String">JML KADER SANDANG</Data></Cell>
    <Cell ss:MergeAcross="2" ss:StyleID="HeaderSandangMain"><Data ss:Type="String">INDUSTRI RUMAH TANGGA</Data></Cell>
    <Cell ss:MergeDown="1" ss:StyleID="HeaderSandangMain"><Data ss:Type="String">STATUS</Data></Cell>
    <Cell ss:MergeDown="1" ss:StyleID="HeaderSandangMain"><Data ss:Type="String">TANGGAL LAPORAN</Data></Cell>
   </Row>

   {{-- Header Baris 2 --}}
   <Row ss:Height="22">
    <Cell ss:Index="5" ss:StyleID="HeaderSandangSub"><Data ss:Type="String">Pangan</Data></Cell>
    <Cell ss:StyleID="HeaderSandangSub"><Data ss:Type="String">Sandang</Data></Cell>
    <Cell ss:StyleID="HeaderSandangSub"><Data ss:Type="String">Jasa</Data></Cell>
   </Row>

   {{-- Baris Data --}}
   @php
    $noS = 1;
    $sKaderS = 0; $sPanganS = 0; $sSandang = 0; $sJasa = 0;
   @endphp
   @forelse($sandangData as $row)
   @php
    $valPangan = $row->industri_pangan ?? $row->pangan ?? 0;
    $valSandang = $row->industri_sandang ?? $row->sandang ?? 0;
    $sKaderS += $row->kader_sandang ?? 0;
    $sPanganS += $valPangan;
    $sSandang += $valSandang;
    $sJasa += $row->jasa ?? 0;
   @endphp
   <Row ss:Height="19">
    <Cell ss:StyleID="CellCenter"><Data ss:Type="Number">{{ $noS++ }}</Data></Cell>
    <Cell ss:StyleID="CellLeft"><Data ss:Type="String">{{ $row->nama_kec ?? '-' }}</Data></Cell>
    <Cell ss:StyleID="CellLeft"><Data ss:Type="String">{{ $row->nama_desa ?? '-' }}</Data></Cell>
    <Cell ss:StyleID="CellNumber"><Data ss:Type="Number">{{ $row->kader_sandang ?? 0 }}</Data></Cell>
    <Cell ss:StyleID="CellNumber"><Data ss:Type="Number">{{ $valPangan }}</Data></Cell>
    <Cell ss:StyleID="CellNumber"><Data ss:Type="Number">{{ $valSandang }}</Data></Cell>
    <Cell ss:StyleID="CellNumber"><Data ss:Type="Number">{{ $row->jasa ?? 0 }}</Data></Cell>
    <Cell ss:StyleID="CellCenter"><Data ss:Type="String">{{ ucfirst(strtolower($row->status ?? '')) }}</Data></Cell>
    <Cell ss:StyleID="CellCenter"><Data ss:Type="String">{{ \Carbon\Carbon::parse($row->created_at)->format('d/m/Y') }}</Data></Cell>
   </Row>
   @empty
   <Row ss:Height="22">
    <Cell ss:MergeAcross="8" ss:StyleID="CellCenter"><Data ss:Type="String">Tidak ada data laporan program sandang pada periode ini.</Data></Cell>
   </Row>
   @endforelse

   {{-- Total Baris --}}
   <Row ss:Height="22">
    <Cell ss:MergeAcross="2" ss:StyleID="CellTotalLabel"><Data ss:Type="String">TOTAL KABUPATEN</Data></Cell>
    <Cell ss:Index="4" ss:StyleID="CellTotal"><Data ss:Type="Number">{{ $sKaderS }}</Data></Cell>
    <Cell ss:StyleID="CellTotal"><Data ss:Type="Number">{{ $sPanganS }}</Data></Cell>
    <Cell ss:StyleID="CellTotal"><Data ss:Type="Number">{{ $sSandang }}</Data></Cell>
    <Cell ss:StyleID="CellTotal"><Data ss:Type="Number">{{ $sJasa }}</Data></Cell>
    <Cell ss:MergeAcross="1" ss:StyleID="CellTotalLabel"><Data ss:Type="String">-</Data></Cell>
   </Row>
  </Table>
 </Worksheet>
 @endif

</Workbook>
