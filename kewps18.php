<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
  public function Header() {
    // Top meta (left/right)
    $this->SetFont('helvetica','',9);
    $this->Cell(0,5,'Pekeliling Perbendaharaan Malaysia',0,0,'L');
    $this->Cell(0,5,'AM 6.8 Lampiran B',0,1,'R');

    // Form code
    $this->SetFont('helvetica','B',12);
    $this->Cell(0,6,'KEW.PS-18',0,1,'R');

    // Title
    $this->Ln(2);
    $this->SetFont('helvetica','B',13);
    $this->Cell(0,7,'LAPORAN PINDAHAN STOK',0,1,'C');
    $this->SetFont('helvetica','',10);
    $this->Cell(0,5,'BAGI TAHUN ……………',0,1,'C');
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
$pdf->SetTitle('KEW.PS-18 – Laporan Pindahan Stok');

$pdf->SetMargins(12, 44, 12);   // leave space for header
$pdf->SetHeaderMargin(6);
$pdf->SetAutoPageBreak(true, 18);
$pdf->SetFont('helvetica','',9);
$pdf->AddPage();

/* -------- Styles -------- */
$style = '
<style>
  table { border-collapse: collapse; }
  .b  { border:0.5px solid #000; }
  .th { background-color:#d9d9d9; font-weight:bold; text-align:center; }
  .tc { text-align:center; }
  .tl { text-align:left; }
</style>
';

/* -------- Header table (fixed widths sum to 100%) -------- */
$head = '
<table width="100%" cellpadding="4" cellspacing="0">
  <tr>
    <td class="th b tc" width="20%" rowspan="2">TAHUN SEMASA</td>
    <td class="th b tc" width="40%" colspan="2">TERIMAAN</td>
    <td class="th b tc" width="40%" colspan="2">PENGELUARAN</td>
  </tr>
  <tr>
    <td class="th b tc" width="20%">JUMLAH<br>KUANTITI<br>PINDAHAN</td>
    <td class="th b tc" width="20%">JUMLAH NILAI<br>(RM)</td>
    <td class="th b tc" width="20%">JUMLAH<br>KUANTITI<br>PINDAHAN</td>
    <td class="th b tc" width="20%">JUMLAH NILAI<br>(RM)</td>
  </tr>
';

/* -------- Body rows -------- */
$rows = '';
$labels = [
  'Suku Tahun Pertama',
  'Suku Tahun Kedua',
  'Suku Tahun Ketiga',
  'Suku Tahun Keempat'
];
foreach ($labels as $lab) {
  $rows .= '
  <tr>
    <td class="b tl">'.$lab.'</td>
    <td class="b tc"></td>
    <td class="b tc"></td>
    <td class="b tc"></td>
    <td class="b tc"></td>
  </tr>';
}

// Total row
$rows .= '
  <tr>
    <td class="b th tl">JUMLAH KESELURUHAN</td>
    <td class="b th"></td>
    <td class="b th"></td>
    <td class="b th"></td>
    <td class="b th"></td>
  </tr>
</table>
';

$pdf->writeHTML($style.$head.$rows, true, false, true, false, '');
$pdf->Output('kew_ps_18_laporan_pindahan_stok.pdf', 'I');
