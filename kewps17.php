<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
  public function Header() {
    // Top meta
    $this->SetFont('helvetica','',9);
    $this->Cell(0,5,'Pekeliling Perbendaharaan Malaysia',0,0,'L');
    $this->Cell(0,5,'AM 6.8 Lampiran A',0,1,'R');

    // Form code + No. Permohonan
    $this->SetFont('helvetica','B',12);
    $this->Cell(0,6,'KEW.PS-17',0,1,'R');
    $this->SetFont('helvetica','',10);
    $this->Cell(0,5,'No. Permohonan : ……………',0,1,'R');

    // Title
    $this->Ln(2);
    $this->SetFont('helvetica','B',13);
    $this->Cell(0,7,'BORANG PINDAHAN STOK',0,1,'C');
    $this->Ln(2);
  }
  public function Footer() {
    $this->SetY(-14);
    $this->SetFont('helvetica','I',8);
    $this->Cell(0,10,'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(),0,0,'C');
  }
}

$pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-17 – Borang Pindahan Stok');

$pdf->SetMargins(12, 44, 12);
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
  .small { font-size:9pt; }
</style>
';

/* -------- Items table -------- */
$head = '
<table width="100%" cellpadding="4" cellspacing="0">
  <tr>
    <td class="th b tc" width="8%">No Kod</td>
    <td class="th b tc" width="18%">Perihal Stok</td>
    <td class="th b tc" width="12%">Unit<br>Pengukuran</td>
    <td class="th b tc" width="12%">Jumlah Nilai Stok<br>(RM)</td>
    <td class="th b tc" width="12%">Kuantiti Dimohon</td>
    <td class="th b tc" width="12%">Kuantiti Dilulus</td>
    <td class="th b tc" width="26%">Catatan</td>
  </tr>';
$rows = '';
for ($i=0; $i<6; $i++) {
  $rows .= '
  <tr>
    <td class="b" style="height:20px;"></td>
    <td class="b"></td>
    <td class="b tc"></td>
    <td class="b tc"></td>
    <td class="b tc"></td>
    <td class="b tc"></td>
    <td class="b"></td>
  </tr>';
}
$itemsTable = $head.$rows.'</table>';

/* -------- Signatures (Pemohon & Pelulus) -------- */
$sigTop = '
<table width="100%" cellpadding="8" cellspacing="0" style="margin-top:10px;">
  <tr>
    <!-- Pemohon -->
    <td width="50%" class="b" valign="top">
      <div>................................................</div>
      <div class="small">(Tandatangan Pemohon)</div><br>
      <table width="100%" cellpadding="2" cellspacing="0">
        <tr><td width="24%">Nama</td><td width="3%">:</td><td></td></tr>
        <tr><td>Jawatan</td><td>:</td><td></td></tr>
        <tr><td>Kem./ Jab.</td><td>:</td><td></td></tr>
        <tr><td>Tarikh</td><td>:</td><td></td></tr>
      </table>
    </td>

    <!-- Pelulus -->
    <td width="50%" class="b" valign="top">
      <div>................................................</div>
      <div class="small">(Tandatangan Pelulus)</div><br>
      <table width="100%" cellpadding="2" cellspacing="0">
        <tr><td width="24%">Nama</td><td width="3%">:</td><td></td></tr>
        <tr><td>Jawatan</td><td>:</td><td></td></tr>
        <tr><td>Kem./ Jab.</td><td>:</td><td></td></tr>
        <tr><td>Tarikh</td><td>:</td><td></td></tr>
      </table>
    </td>
  </tr>
</table>
';

/* -------- Signatures (Penyerah & Penerima) -------- */
$sigBottom = '
<table width="100%" cellpadding="8" cellspacing="0">
  <tr>
    <!-- Penyerah -->
    <td width="50%" class="b" valign="top">
      <div>Dengan ini saya menyerahkan stok yang dinyatakan di atas.</div><br>
      <div>................................................</div>
      <div class="small">(Tandatangan Penyerah)</div><br>
      <table width="100%" cellpadding="2" cellspacing="0">
        <tr><td width="24%">Nama</td><td width="3%">:</td><td></td></tr>
        <tr><td>Jawatan</td><td>:</td><td></td></tr>
        <tr><td>Kem./ Jab.</td><td>:</td><td></td></tr>
        <tr><td>Tarikh</td><td>:</td><td></td></tr>
      </table>
    </td>

    <!-- Penerima -->
    <td width="50%" class="b" valign="top">
      <div>Dengan ini saya menerima stok yang dinyatakan di atas.</div><br>
      <div>................................................</div>
      <div class="small">(Tandatangan Penerima)</div><br>
      <table width="100%" cellpadding="2" cellspacing="0">
        <tr><td width="24%">Nama</td><td width="3%">:</td><td></td></tr>
        <tr><td>Jawatan</td><td>:</td><td></td></tr>
        <tr><td>Kem./ Jab.</td><td>:</td><td></td></tr>
        <tr><td>Tarikh</td><td>:</td><td></td></tr>
      </table>
    </td>
  </tr>
</table>
';

/* -------- Render -------- */
$pdf->writeHTML($style.$itemsTable.$sigTop.$sigBottom, true, false, true, false, '');
$pdf->Output('kew_ps_17_borang_pindahan_stok.pdf', 'I');
