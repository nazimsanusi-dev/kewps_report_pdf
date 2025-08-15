<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
  public function Header() {
    // Meta (left/right)
    $this->SetFont('helvetica','',9);
    $this->Cell(0,5,'Pekeliling Perbendaharaan Malaysia',0,0,'L');
    $this->Cell(0,5,'AM 6.6 Lampiran E',0,1,'R');

    // Green tag KEW.PS-15 (top-right)
    // $this->SetXY($this->getPageWidth()-42, 12);
    // $this->SetFillColor(188,238,104);
    $this->SetFont('helvetica','B',12);
    $this->Cell(0,7,'KEW.PS-15',0,1,'R');

    // Title
    $this->Ln(10);
    $this->SetFont('helvetica','B',13);
    $this->Cell(0,7,'BORANG PELARASAN STOK',0,1,'C');
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
$pdf->SetTitle('KEW.PS-15 – Borang Pelarasan Stok');

$pdf->SetMargins(10, 40, 10);
$pdf->SetHeaderMargin(6);
$pdf->SetAutoPageBreak(true, 18);
$pdf->SetFont('helvetica','',9);
$pdf->AddPage();

/* ---------------- Styles ---------------- */
$style = '
<style>
  table { border-collapse: collapse; }
  .b  { border:0.5px solid #000; }
  .th { background-color:#d9d9d9; font-weight:bold; text-align:center; }
  .tc { text-align:center; }
  .tl { text-align:left; }
  .label td { padding:1px 2px; }
</style>
';

/* --------- Top labels --------- */
$topInfo = '
<table width="100%" cellpadding="2" cellspacing="0" class="label">
  <tr>
    <td width="20%">Kementerian/ Jabatan:</td>
  </tr>
  <tr>
    <td>Kategori Stor:</td>
  </tr>
</table>
';

$head = '
<table width="100%" cellpadding="4" cellspacing="0">
  <tr>
    <td class="th b" width="7%"  rowspan="2">No.Kod</td>
    <td class="th b" width="18%" rowspan="2">Perihal Stok</td>
    <td class="th b" width="10%" rowspan="2">Tarikh<br>Penemuan</td>

    <td class="th b" width="16%" colspan="2">Baki di Kad Daftar Stok<br>(a)</td>
    <td class="th b" width="16%" colspan="2">Baki Fizikal<br>(b)</td>
    <td class="th b" width="15%" colspan="2">Perbezaan<br>(+/-)<br>(b)-(a)</td>

    <td class="th b" width="9%"  rowspan="2">Justifikasi</td>
    <td class="th b" width="9%"  rowspan="2">Kelulusan Ketua Jabatan<br>(Lulus/ Tidak Lulus)</td>
  </tr>
  <tr>
    <td class="th b" width="8%">Kuantiti</td>
    <td class="th b" width="8%">Nilai (RM)</td>

    <td class="th b" width="8%">Kuantiti</td>
    <td class="th b" width="8%">Nilai (RM)</td>

    <td class="th b" width="7%">Kuantiti</td>
    <td class="th b" width="8%">Nilai (RM)</td>
  </tr>
';

/* --------- Rows (blank lines) --------- */
$rows = '';
for ($i=0; $i<6; $i++) {
  $rows .= '
  <tr>
    <td class="b" style="height:18px;"></td>
    <td class="b"></td>
    <td class="b"></td>

    <td class="b tc"></td>
    <td class="b tc"></td>
    <td class="b tc"></td>
    <td class="b tc"></td>
    <td class="b tc"></td>
    <td class="b tc"></td>

    <td class="b"></td>
    <td class="b"></td>
  </tr>';
}
$table = $head.$rows.'</table>';

/* --------- Signature panels --------- */
$sign = '
<table cellpadding="10" cellspacing="0" width="100%" style="margin-top:10px;">
  <tr>
    <td width="51%" valign="top" class="b">
      <b>Disediakan oleh:</b><br><br>
      .........................................................<br>
      <span class="tl">(Tandatangan Pegawai Stor)</span><br><br>
      <table width="100%" cellpadding="2" cellspacing="0">
        <tr><td width="20%">Nama:</td><td></td></tr>
        <tr><td>Jawatan:</td><td></td></tr>
        <tr><td>Jabatan:</td><td></td></tr>
        <tr><td>Tarikh:</td><td></td></tr>
      </table>
    </td>

    <td width="49%" valign="top" class="b">
      <b>Disahkan Oleh:</b><br><br>
      .........................................................<br>
      <span class="tl">(Tandatangan Ketua Jabatan)</span><br><br>
      <table width="100%" cellpadding="2" cellspacing="0">
        <tr><td width="20%">Nama:</td><td></td></tr>
        <tr><td>Jawatan:</td><td></td></tr>
        <tr><td>Jabatan:</td><td></td></tr>
        <tr><td>Tarikh:</td><td></td></tr>
      </table>
    </td>
  </tr>
</table>
';

/* --------- Render --------- */
$pdf->writeHTML($style.$topInfo.$table.$sign, true, false, true, false, '');
$pdf->Output('kew_ps_15_borang_pelarasan_stok.pdf', 'I');
