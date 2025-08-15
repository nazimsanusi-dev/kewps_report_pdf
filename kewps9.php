<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
  public function Header() {
    // Top meta
    $this->SetFont('helvetica','',9);
    $this->Cell(0,5,'Pekeliling Perbendaharaan Malaysia',0,0,'L');
    $this->Cell(0,5,'AM 6.5 Lampiran C',0,1,'R');

    // Form code + No. BPS
    $this->SetFont('helvetica','B',12);
    $this->Cell(0,6,'KEW.PS-9',0,1,'R');

    $this->SetFont('helvetica','',10);
    $this->Cell(0,5,'No. BPS.: …………………………………',0,1,'R');

    // Title
    $this->Ln(3);
    $this->SetFont('helvetica','B',13);
    $this->Cell(0,7,'BORANG PEMBUNGKUSAN STOK (BPS)',0,1,'C');
    $this->Ln(2);
  }

  public function Footer() {
    // Salinan notes
    $this->SetY(-42);
    $this->SetFont('helvetica','',8);
    $this->Cell(0,5,'Salinan 1 – Disimpan oleh Bahagian Bungkusan dan Penghantaran           Salinan 2 – Dimasukkan ke dalam peti atau kotak bungkusan                   Salinan 3 – Dihantar terus kepada Pemohon',0,0,'L');
    // $this->Cell(0,5,'Salinan 2 – Dimasukkan ke dalam peti atau kotak bungkusan',0,0,'C');
    // $this->Cell(0,5,'Salinan 3 – Dihantar terus kepada Pemohon',0,1,'R');

    // Bottom code
    $this->SetY(-12);
    $this->SetFont('helvetica','',8);
    $this->Cell(0,8,'M.S. 13/13',0,0,'C');
  }
}

$pdf = new MYPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-9 – Borang Pembungkusan Stok (BPS)');

$pdf->SetMargins(10, 42, 10); // left, top (leave for header), right
$pdf->SetHeaderMargin(6);
$pdf->SetAutoPageBreak(true, 22);
$pdf->SetFont('helvetica','',9);
$pdf->AddPage();

$style = '
<style>
  .th{background-color:#d9d9d9; font-weight:bold; text-align:center;}
  .tdc{text-align:center;}
  .tdr{text-align:right;}
  .u { display:inline-block; border-bottom:0.5px solid #000; min-width:260px; }
  table { border-collapse: collapse; }
</style>
';

// Top Kepada / Daripada box
$addresses = '
<table cellpadding="6" cellspacing="0" width="100%" style="border:0.5px solid #000;">
  <tr>
    <td width="50%" valign="top" style="border-right:0.5px solid #000;">
      <b>Kepada:</b><br>
      <span class="small">(Nama Dan Alamat Pemohon)</span><br><br><br>
    </td>
    <td width="49%" valign="top">
      <b>Daripada:</b><br>
      <span class="small">(Nama Dan Alamat Stor Pengeluar)</span><br><br><br>
    </td>
  </tr>
</table>
';

// Items grid
$gridHead = '
<table cellpadding="4" cellspacing="0" width="100%" style="border:0.5px solid #000; margin-top:10px;">
  <tr>
    <td class="th" style="border-top:0.5px solid #000; border-right:0.5px solid #000; border-left:0.5px solid #000;" width="5%">Bil.</td>
    <td class="th" style="border-top:0.5px solid #000; border-right:0.5px solid #000;" width="16%">Nombor Permohonan<br>(Rujuk KEW.PS-7)</td>
    <td class="th" style="border-top:0.5px solid #000; border-right:0.5px solid #000;" width="12%">Nombor Kod</td>
    <td class="th" style="border-top:0.5px solid #000; border-right:0.5px solid #000;" width="23%">Perihal Stok</td>
    <td class="th" style="border-top:0.5px solid #000; border-right:0.5px solid #000;" width="10%">Kuantiti<br>Dibungkus</td>
    <td class="th" style="border-top:0.5px solid #000; border-right:0.5px solid #000;" width="17%">Maklumat<br>Bungkusan</td>
    <td class="th" style="border-top:0.5px solid #000; border-right:0.5px solid #000;" width="16%">Maklumat<br>Penghantaran</td>
  </tr>';

$rows = '';
for ($i=0; $i<5; $i++) {
  $rows .= '
  <tr>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000; height:18px;"></td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
    <td style="border-top:0.5px solid #000;"></td>
  </tr>';
}
$grid = $gridHead.$rows.'</table>';

// Signature panels
$sign = '
<table cellpadding="10" cellspacing="0" width="100%" style="margin-top:12px;">
  <tr>
    <!-- Diperiksa -->
    <td width="33%" valign="top" style="border:0.5px solid #000;">
      <b>Diperiksa oleh:</b><br><br>
      ........................................................<br>
      <span class="small">(Tandatangan)</span><br><br>
      <table width="100%" cellpadding="2" cellspacing="0">
        <tr><td>Nama:</td></tr>
        <tr><td>Jawatan:</td></tr>
        <tr><td>Tarikh:</td></tr>
      </table>
    </td>

    <!-- Dibungkus -->
    <td width="33%" valign="top" style="border:0.5px solid #000;">
      <b>Dibungkus oleh:</b><br><br>
      ........................................................<br>
      <span class="small">(Tandatangan)</span><br><br>
      <table width="100%" cellpadding="2" cellspacing="0">
        <tr><td>Nama:</td></tr>
        <tr><td>Jawatan:</td></tr>
        <tr><td>Tarikh:</td></tr>
        <tr><td>Cap Jabatan:</td></tr>
      </table>
    </td>

    <!-- Diterima -->
    <td width="33%" valign="top" style="border:0.5px solid #000;">
      <b>Diterima oleh:</b><br><br>
      ........................................................<br>
      <span class="small">(Tandatangan)</span><br><br>
      <table width="100%" cellpadding="1" cellspacing="0">
        <tr><td>Nama:</td></tr>
        <tr><td>Jawatan:</td></tr>
        <tr><td>Tarikh:</td></tr>
        <tr><td>Cap Jabatan:</td></tr>
      </table>
    </td>
  </tr>
</table>
';

$pdf->writeHTML($style.$addresses.$grid.$sign, true, false, true, false, '');
$pdf->Output('kew_ps_9_bps.pdf', 'I');
