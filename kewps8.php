<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
  public function Header() {
    // Top meta
    $this->SetFont('helvetica','',9);
    $this->Cell(0,5,'Pekeliling Perbendaharaan Malaysia',0,0,'L');
    $this->Cell(0,5,'AM 6.5 Lampiran B',0,1,'R');

    // Lampiran tag
    $this->SetXY($this->getPageWidth()-90, 15);
    $this->SetFillColor(255, 235, 59);
    $this->SetFont('helvetica','B',10);
    $this->Cell(28,7,'Lampiran 4',0,0,'C',true);

    // Form code + No. BPSS
    $this->SetXY(0, 15);
    $this->SetFont('helvetica','B',12);
    $this->Cell(0,6,'KEW.PS-8',0,1,'R');
    $this->SetFont('helvetica','',10);
    // $this->Cell(0,6,'',0,1,'R');
    $this->Cell(0,6,'No. BPSI. : .............................',0,1,'R');

    // Title
    $this->Ln(1);
    $this->SetFont('helvetica','B',13);
    $this->Cell(0,7,'BORANG PERMOHONAN STOK',0,1,'C');
    $this->SetFont('helvetica','',11);
    $this->Cell(0,5,'(INDIVIDU KEPADA STOR)',0,1,'C');
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
$pdf->SetTitle('KEW.PS-8 – Borang Permohonan Stok (Individu Kepada Stor)');

$pdf->SetMargins(14, 44, 14);
$pdf->SetHeaderMargin(6);
$pdf->SetAutoPageBreak(true, 16);
$pdf->SetFont('helvetica','',10);
$pdf->AddPage();

$style = '
<style>
  .th{ background-color:#d9d9d9; font-weight:bold; text-align:center; }
  .thin-border td, .thin-border th { border:0.5px solid #000; }
  .box { border:0.5px solid #000; }
  .small{ font-size:9pt; }
</style>
';

$grid = '
<table cellpadding="4" cellspacing="0" width="100%" style="border-collapse:collapse; margin-top:6px;">
  <!-- Group headers -->
  <tr>
    <td class="th" style="border:0.5px solid #000;" width="36%" colspan="4">Permohonan</td>
    <td class="th" style="border:0.5px solid #000;" width="32%" colspan="3">Pegawai Pelulus</td>
    <td class="th" style="border:0.5px solid #000;" width="32%" colspan="2">Perakuan Penerimaan</td>
  </tr>

  <!-- Column headers -->
  <tr>
    <td class="th" style="border:0.5px solid #000;" width="7%">No. Kod</td>
    <td class="th" style="border:0.5px solid #000;" width="11%">Perihal Stok</td>
    <td class="th" style="border:0.5px solid #000;" width="10%">Kuantiti Dimohon</td>
    <td class="th" style="border:0.5px solid #000;" width="8%">Catatan</td>

    <td class="th" style="border:0.5px solid #000;" width="10%">Baki Sedia Ada</td>
    <td class="th" style="border:0.5px solid #000;" width="12%">Kuantiti Diluluskan</td>
    <td class="th" style="border:0.5px solid #000;" width="10%">Catatan</td>

    <td class="th" style="border:0.5px solid #000;" width="15%">Kuantiti Diterima</td>
    <td class="th" style="border:0.5px solid #000;" width="17%">Catatan</td>
  </tr>
';

// === Empty data rows ===
$rowCount = 6; // Change this number as needed
for ($i = 0; $i < $rowCount; $i++) {
    $grid .= '<tr>';
    for ($j = 0; $j < 9; $j++) {
        $height = ($j === 0) ? ' height:20px;' : '';
        $grid .= '<td style="border:0.5px solid #000;' . $height . '"></td>';
    }
    $grid .= '</tr>';
}

$grid .= '</table>';

// ===== SIGNATURE BLOCKS =====
$sign = '
<table cellpadding="10" cellspacing="0" width="100%" style="border-collapse:collapse; margin-top:12px;">
  <tr>
    <!-- Pemohon -->
    <td width="36%" valign="top" style="border:0.5px solid #000;">
      <div style="font-weight:bold; margin-bottom:6px;">Pemohon:</div>
      <br>
      <div>.......................................</div>
      <div class="small">(Tandatangan)</div>
      <br>
      <table width="100%" cellpadding="0" cellspacing="0">
        <tr><td>Nama</td><td>:</td></tr>
        <tr><td>Jawatan</td><td>:</td></tr>
        <tr><td>Tarikh</td><td>:</td></tr>
      </table>
    </td>

    <!-- Pegawai Pelulus -->
    <td width="32%" valign="top" style="border:0.5px solid #000;">
      <div style="font-weight:bold; margin-bottom:6px;">Pegawai Pelulus:</div>
      <br>
      <div>.......................................</div>
      <div class="small">(Tandatangan)</div>
      <br>
      <table width="100%" cellpadding="0" cellspacing="0">
        <tr><td>Nama</td><td>:</td></tr>
        <tr><td>Jawatan</td><td>:</td></tr>
        <tr><td>Tarikh</td><td>:</td></tr>
      </table>
    </td>

    <!-- Pemohon/Wakil -->
    <td width="32%" valign="top" style="border:0.5px solid #000;">
      <div style="font-weight:bold; margin-bottom:6px;">Pemohon/ Wakil:</div>
      <br>
      <div>.......................................</div>
      <div class="small">(Tandatangan)</div>
      <br>
      <table width="100%" cellpadding="0" cellspacing="0">
        <tr><td>Nama</td><td>:</td></tr>
        <tr><td>Jawatan</td><td>:</td></tr>
        <tr><td>Tarikh</td><td>:</td></tr>
      </table>
    </td>
  </tr>
</table>
';

// render
$pdf->writeHTML($style.$grid.$sign, true, false, true, false, '');
$pdf->Output('kew_ps_8_BORANG_PERMOHONAN_STOK.pdf', 'I');
