<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
  public function Header() {
    // Top meta
    $this->SetFont('helvetica','',9);
    $this->Cell(0,5,'Pekeliling Perbendaharaan Malaysia',0,0,'L');
    $this->Cell(0,5,'AM 6.6 Lampiran D',0,1,'R');

    // Form code
    $this->SetFont('helvetica','B',12);
    $this->Cell(0,6,'KEW.PS-13',0,1,'R');

    // Title
    $this->Ln(2);
    $this->SetFont('helvetica','B',13);
    $this->Cell(0,7,'LAPORAN VERIFIKASI STOR',0,1,'C');
    $this->SetFont('helvetica','',10);
    $this->Cell(0,5,'TAHUN ………………',0,1,'C');
    $this->Ln(4);
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
$pdf->SetTitle('KEW.PS-13 – Laporan Verifikasi Stor');

$pdf->SetMargins(10, 44, 10);  // leave space for header
$pdf->SetHeaderMargin(6);
$pdf->SetAutoPageBreak(true, 18);
$pdf->SetFont('helvetica','',9);
$pdf->AddPage();

$style = '
<style>
  table { border-collapse: collapse; }
  .b  { border:0.5px solid #000; }
  .th { background:#d9d9d9; font-weight:bold; text-align:center; }
  .tc { text-align:center; }
  .tr { text-align:right; }
  .petunjuk { font-size:9pt; }
</style>
';

/* ------- MAIN TABLE -------

Widths plan (sum 100%):
- Kementerian/Jabatan: 22%
- Kategori Stor:       10%
- Jumlah Kuantiti Stok group (3 cols): 30%  -> 10% each
- Peratusan Diverifikasi: 13%
- Jumlah Stok group (6 cols): 25% -> 4%,4%,4%,4%,4%,5%

*/
$head = '
<table width="100%" cellpadding="4" cellspacing="0">
  <tr>
    <td class="th b" width="22%" rowspan="2">KEMENTERIAN/<br>JABATAN</td>
    <td class="th b" width="10%" rowspan="2">KATEGORI<br>STOR</td>
    <td class="th b" width="30%" colspan="3">JUMLAH KUANTITI STOK</td>
    <td class="th b" width="13%" rowspan="2">PERATUSAN<br>DIVERI­FIKASI<br>(%)<br>(c) = [(b)/(a)]×100</td>
    <td class="th b" width="25%" colspan="6">JUMLAH STOK</td>
  </tr>
  <tr>
    <td class="th b" width="10%">KESELURUHAN<br>(a)</td>
    <td class="th b" width="10%">DIVERIFIKASI<br>(b)</td>
    <td class="th b" width="10%">TIDAK<br>DIVERIFIKASI</td>

    <td class="th b tc" width="4%">A</td>
    <td class="th b tc" width="4%">B</td>
    <td class="th b tc" width="4%">C</td>
    <td class="th b tc" width="4%">D</td>
    <td class="th b tc" width="4%">E</td>
    <td class="th b tc" width="5%">F</td>
  </tr>
';

$rows = '';
// Example first row (as in screenshot)
$rows .= '
  <tr>
    <td class="b">JIM IBU PEJABAT</td>
    <td class="b tc">PUSAT</td>
    <td class="b tc">300</td>
    <td class="b tc">150</td>
    <td class="b tc">150</td>
    <td class="b tc">50%</td>
    <td class="b tc">70</td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
  </tr>
';
// Add blank rows
for ($i=0; $i<8; $i++) {
  $rows .= '
  <tr>
    <td class="b" style="height:18px;"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
  </tr>';
}

// Bottom total row: "JUMLAH KESELURUHAN"
$footerRow = '
  <tr>
    <td class="b th" colspan="2" style="text-align:left;">JUMLAH KESELURUHAN</td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
    <td class="b"></td>
  </tr>
</table>
';

// Petunjuk
$petunjuk = '
<br>
<table width="100%" cellpadding="4" cellspacing="0">
  <tr>
    <td class="petunjuk">
      <b>PETUNJUK:</b> Status Aset Semasa Pemeriksaan <b>A</b>: Usang, <b>B</b>: Rosak, <b>C</b>: Tidak Aktif,
      <b>D</b>: Tidak Diperlukan, <b>E</b>: Luput Tempoh, <b>F</b>: Hilang
    </td>
  </tr>
</table>
';

$pdf->writeHTML($style.$head.$rows.$footerRow.$petunjuk, true, false, true, false, '');
$pdf->Output('kew_ps_13_laporan_verifikasi_stor.pdf', 'I');
