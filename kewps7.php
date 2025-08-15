<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
  public function Header() {
    // Top meta
    $this->SetFont('helvetica','',9);
    $this->Cell(0,5,'Pekeliling Perbendaharaan Malaysia',0,0,'L');
    $this->Cell(0,5,'AM 6.5 Lampiran A',0,1,'R');

    // Lampiran tag
    $this->SetXY($this->getPageWidth()-90, 15);
    $this->SetFillColor(255, 235, 59);
    $this->SetFont('helvetica','B',10);
    $this->Cell(28,7,'Lampiran 3',0,0,'C',true);

    // Form code + No. BPSS
    $this->SetXY(0, 15);
    $this->SetFont('helvetica','B',12);
    $this->Cell(0,6,'KEW.PS-7',0,1,'R');
    $this->SetFont('helvetica','',10);
    // $this->Cell(0,6,'',0,1,'R');
    $this->Cell(0,6,'No. BPSS. : .............................',0,1,'R');

    // Title
    $this->Ln(1);
    $this->SetFont('helvetica','B',13);
    $this->Cell(0,7,'BORANG PERMOHONAN STOK',0,1,'C');
    $this->SetFont('helvetica','',11);
    $this->Cell(0,5,'(ANTARA STOR)',0,1,'C');
    $this->Cell(0,5,'',0,1,'C');
    $this->Ln(2);
  }
  public function Footer() {
    $this->SetY(-15);
    $this->SetFont('helvetica','I',8);
    $this->Cell(0,10,'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(),0,0,'C');
  }
}

$pdf = new MYPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-7 – Borang Permohonan Stok (Antara Stor)');

$pdf->SetMargins(4, 44, 4);
$pdf->SetHeaderMargin(6);
$pdf->SetAutoPageBreak(true, 16);
$pdf->SetFont('helvetica','',8);
$pdf->AddPage();

$style = '
<style>
  .th{ background-color:#d9d9d9; font-weight:bold; text-align:center; }
  .thin-border td, .thin-border th { border:0.5px solid #000; }
  .box { border:0.5px solid #000; }
  .small{ font-size:9pt; }
</style>
';

/* ---------- TWO ADDRESS BOXES ---------- */
$addr = '
<table width="100%" cellpadding="5" cellspacing="0" style="border-collapse:collapse; margin-bottom:4px;">
  <tr>
    <td class="box" width="39%" valign="top">
      <b>Nama dan Alamat Stor Pemesan:</b><br><br><br>
    </td>
    <td class="box" width="61%" valign="top">
      <b>Nama dan Alamat Stor Pengeluar:</b><br><br><br>
    </td>
  </tr>
</table>
';

/* ---------- MAIN GRID ---------- */
/* Column plan (total 14 leaf columns):
   Left (Pemesan) 5 cols = 46%:
     No.Kod(6) | Perihal(18) | Kuantiti Dimohon(8) | Catatan(7) | Kuantiti Diterima(7)
   Right (Pengeluar) 9 cols = 54%:
     Unit(6) | Baki Sedia Ada(6) | Kuantiti Diluluskan(6) | Harga Seunit(6) | Harga Jumlah(6) | Catatan(6) | Kuantiti Dikeluarkan(6) | Pembungkusan(6) | No. BPS(6)
*/
$tbl = '
<table class="thin-border" width="100%" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
  <!-- Row 1: two big groups -->
  <tr>
    <th class="th" width="39%" colspan="5" rowspan="2">Dilengkapkan Oleh Stor Pemesan</th>
    <th class="th" width="61%" colspan="9" rowspan="1">Dilengkapkan Oleh Stor Pengeluar</th>
  </tr>

  <!-- Row 2: right-side subgroups; left band -->
  <tr>
    <th class="th" width="35%" colspan="6">BAHAGIAN BEKALAN KAWALAN DAN AKAUN</th>
    <th class="th" width="26%" colspan="3">BAHAGIAN SIMPANAN</th>
  </tr>

  <!-- Row 3: leaf headers except HARGA (which has colspan=2) -->
  <tr>
    <!-- Dilengkapkan Oleh Stor Pemesan -->
    <th class="th" width="6%"  rowspan="2">No. Kod</th>
    <th class="th" width="11%" rowspan="2">Perihal Stok</th>
    <th class="th" width="8%"  rowspan="2">Kuantiti Dimohon</th>
    <th class="th" width="7%"  rowspan="2">Catatan</th>
    <th class="th" width="7%"  rowspan="2">Kuantiti Diterima</th>

    <!--  BAHAGIAN BEKALAN KAWALAN DAN AKAUN -->
    <th class="th" width="6%"  rowspan="2">Unit Pengukuran</th>
    <th class="th" width="6%"  rowspan="2">Baki Sedia Ada</th>
    <th class="th" width="6%"  rowspan="2">Kuantiti Diluluskan</th>
    <!-- Harga group is 12% total -->
    <th class="th" width="12%" colspan="2">Harga (RM)</th>
    <th class="th" width="5%"  rowspan="2">Catatan</th>

    <!--  BAHAGIAN SIMPANAN -->
    <th class="th" width="8%"  rowspan="2">Kuantiti Dikeluarkan</th>
    <th class="th" width="9%"  rowspan="2">Pembungkusan<br>(Perlu/ Tidak Perlu)</th>
    <th class="th" width="9%"  rowspan="2">No. Borang Pembungkusan Stok (BPS)</th>
  </tr>

  <!-- Row 4: the two subcolumns for Harga -->
  <tr>
    <th class="th" width="6%">Seunit</th>
    <th class="th" width="6%">Jumlah</th>
  </tr>
';

/* empty rows */
for ($i=0; $i<4; $i++) {
  $tbl .= '
  <tr>
    '.str_repeat('<td height="18"></td>', 14).'
  </tr>';
}
$tbl .= '</table>';

$css = '
<style>
  .small {
    font-size: 9px; /* smaller text */
    line-height: 1.1; /* tighter spacing */
  }
  .box {
    border: 1px solid #000;
    padding: 4px; /* reduce padding */
  }
</style>
';

/* ---------- SIGNATURE BLOCKS ---------- */
$sig = $css . '
<table width="100%" cellpadding="6" cellspacing="0" style="margin-top:8px; border-collapse:collapse;">
  <tr>
    <td class="box" width="19%" valign="top">
      <b>Pemohon</b><br>
      <div class="small">……………………………………</div><br>
      <div class="small">Nama Pegawai:</div>
      <div class="small">Jawatan:</div>
      <div class="small">Jabatan:</div>
      <div class="small">Tarikh:</div>
    </td>

    <td class="box" width="20%" valign="top">
      <b>Pegawai Penerima</b><br>
      
      <div class="small">……………………………………</div><br>
      <div class="small">Nama Pegawai:</div>
      <div class="small">Jawatan:</div>
      <div class="small">Jabatan:</div>
      <div class="small">Tarikh:</div>
      <div class="small"><i>(Dilengkapkan setelah stok diterima)</i></div>
    </td>

    <td class="box" width="35%" valign="top">
      <b>Pegawai Pelulus</b><br>
      
      <div class="small">……………………………………</div><br>
      <div class="small">Nama Pegawai:</div>
      <div class="small">Jawatan:</div>
      <div class="small">Jabatan:</div>
      <div class="small">Tarikh:</div>
    </td>

    <td class="box" width="26%" valign="top">
      <b>Dikeluarkan dan Direkod oleh:</b><br>
      
      <div class="small">……………………………………</div><br>
      <div class="small">Nama Pegawai:</div>
      <div class="small">Jawatan:</div>
      <div class="small">Jabatan:</div>
      <div class="small">Tarikh:</div>
    </td>
  </tr>
</table>

<div class="small" style="margin-top:6px; text-align:center;">
  NOTA: Ruangan Tandatangan Boleh Ditandatangani Pada Lampiran Terakhir Sahaja.
</div>
';

$pdf->writeHTML($style.$addr.$tbl.$sig, true, false, true, false, '');
$pdf->Output('kew_ps_7_permohonan_stok_antara_stor.pdf', 'I');
