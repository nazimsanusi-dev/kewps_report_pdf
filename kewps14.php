<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
  public function Header() {
    // Top meta
    $this->SetFont('helvetica','',9);
    $this->Cell(0,5,'Pekeliling Perbendaharaan Malaysia',0,0,'L');
    $this->Cell(0,5,'AM 6.3 Lampiran D',0,1,'R');

    // Green tag KEW.PS-14 (top-right)
    $this->SetXY($this->getPageWidth()-40, 12);
    // $this->SetFillColor(188, 238, 104);          // soft green
    // $this->SetFont('helvetica','B',10);
    // $this->Cell(0,7,'KEW.PS-14',0,1,'R',true);

    // Form code
    $this->SetFont('helvetica','B',12);
    $this->Cell(0,6,'KEW.PS-14',0,1,'R');

    // Title
    $this->Ln(10);
    $this->SetFont('helvetica','B',13);
    $this->Cell(0,7,'LAPORAN KEDUDUKAN SEMASA STOK',0,1,'C');
    $this->SetFont('helvetica','',10);
    $this->Cell(0,5,'TAHUN …….',0,1,'C');
    $this->Ln(2);
  }
  public function Footer() {
    $this->SetY(-14);
    $this->SetFont('helvetica','I',8);
    $this->Cell(0,10,'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(),0,0,'C');
  }
}

$pdf = new MYPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-14 – Laporan Kedudukan Semasa Stok');

$pdf->SetMargins(10, 40, 10);   // left, top (header space), right
$pdf->SetHeaderMargin(6);
$pdf->SetAutoPageBreak(true, 18);
$pdf->SetFont('helvetica','',9);
$pdf->AddPage();

// Styles (no repeated inline borders)
$style = '
<style>
  table { border-collapse: collapse; }
  .b  { border:0.5px solid #000; }
  .th { background-color:#d9d9d9; font-weight:bold; text-align:center; }
  .tc { text-align:center; }
  .tl { text-align:left; }
  .grey { background-color:#ADADAD; }
  .label td { padding:1px 2px; }
</style>
';

// Top “Kementerian/Jabatan” + “Kategori Stor”
$topInfo = '
<table width="100%" cellpadding="2" cellspacing="0" class="label">
  <tr>
    <td width="20%">KEMENTERIAN/JABATAN</td><td width="2%">:</td><td></td>
  </tr>
  <tr>
    <td>KATEGORI STOR</td><td>:</td><td></td>
  </tr>
</table>
';

// ===== Main table =====
// Width plan (sum 100%):
//  - Col1 "TAHUN SEMASA" = 16%
//  - Group "KEDUDUKAN STOK" = 68% (4 x 17%)
//  - Right "KADAR PUSINGAN STOK" = 16%
$head = '
<table width="100%" cellpadding="4" cellspacing="0">
  <tr>
    <td class="th b tc" width="16%" rowspan="4">TAHUN<br>SEMASA</td>
    <td class="th b tc" width="68%" colspan="4">KEDUDUKAN STOK</td>
    <td class="th b tc" width="16%" rowspan="4">
      KADAR<br>PUSINGAN STOK<br><br>
      <span class="tc">(c)<br>----------------<br>((a + d) ÷ 2)</span>
    </td>
  </tr>
  <tr>
    <td class="th b tc" width="17%">Sedia Ada</td>
    <td class="th b tc" width="17%">Penerimaan</td>
    <td class="th b tc" width="17%">Pengeluaran</td>
    <td class="th b tc" width="17%">Stok Semasa</td>
  </tr>
  <tr>
    <td class="th b tl"><span class="tl">Jumlah<br>Nilai Stok (RM)</span></td>
    <td class="th b tl"><span class="tl">Jumlah<br>Nilai Stok (RM)</span></td>
    <td class="th b tl"><span class="tl">Jumlah<br>Nilai Stok (RM)</span></td>
    <td class="th b tl"><span class="tl">Jumlah<br>Nilai Stok (RM)</span></td>
  </tr>
  <tr>
    <td class="th b tc">(a)</td>
    <td class="th b tc">(b)</td>
    <td class="th b tc">(c)</td>
    <td class="th b tc">(d) = (a)+(b)-(c)</td>
  </tr>
';

// Data rows
$rows = '';

// Row 1: Baki Bawa Hadapan + “Baki Stok Akhir Tahun ……” note spanning 4 cols
$rows .= '
  <tr>
    <td class="b tl th">Baki Bawa Hadapan</td>
    <td class="b tl th" colspan="3">Baki Stok Akhir Tahun ………… :</td>
    <td class="b tl"></td>
    <td class="b grey"></td>
  </tr>
';

// Quarter rows
$labels = [
  'Suku Tahun Pertama',
  'Suku Tahun Kedua',
  'Suku Tahun Ketiga',
  'Suku Tahun Keempat'
];
foreach ($labels as $lab) {
  $rows .= '
  <tr>
    <td class="b tl th">'.$lab.'</td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b grey"></td>
  </tr>';
}

// Final “Nilai Tahunan / Kadar Pusingan Stok”
$rows .= '
  <tr>
    <td class="b tl th" colspan="2">Nilai Tahunan</td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b tc">Kadar Pusingan Stok</td>
    <td class="b"></td>
  </tr>
</table>
';

$pdf->writeHTML($style.$topInfo.$head.$rows, true, false, true, false, '');
$pdf->Output('kew_ps_14_laporan_kedudukan_semasa_stok.pdf', 'I');
