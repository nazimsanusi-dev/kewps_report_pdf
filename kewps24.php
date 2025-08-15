<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
  public function Header() {
    // Meta (left/right)
    $this->SetFont('helvetica','',9);
    $this->Cell(0,5,'Pekeliling Perbendaharaan Malaysia',0,0,'L');
    $this->Cell(0,5,'AM 6.9 Lampiran F',0,1,'R');

    // Form code
    $this->SetFont('helvetica','B',12);
    $this->Cell(0,6,'KEW.PS-24',0,1,'R');
    $this->Ln(1);
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
$pdf->SetTitle('KEW.PS-24 – Borang Tender Pelupusan Stok');

$pdf->SetMargins(16, 42, 16);
$pdf->SetHeaderMargin(6);
$pdf->SetAutoPageBreak(true, 20);
$pdf->SetFont('helvetica','',10);

/* --------- Styles --------- */
$style = '
<style>
  table { border-collapse: collapse; }
  .b  { border:0.5px solid #000; }
  .th { background-color:#d9d9d9; font-weight:bold; text-align:center; }
  .tc { text-align:center; }
  .tl { text-align:left; }
  .dot{ letter-spacing:2px; }
  .small{ font-size:9pt; }
</style>
';

/* ================= PAGE 1 ================= */
$pdf->AddPage();

$page1 = '
<div style="text-align:center; font-weight:bold; font-size:13pt;">BORANG TENDER PELUPUSAN STOK</div>
<br>

<table width="100%" cellpadding="2" cellspacing="0">
  <tr><td width="40%">Nama Individu/ Syarikat:</td></tr>
  <tr><td>No. Kad Pengenalan/ Pendaftaran Syarikat:</td></tr>
</table>
<tr><td></td></tr>

<br>
<table width="100%" cellpadding="2" cellspacing="0">
  <tr><td width="15%">Alamat:</td><td class="dot">______________________</td></tr>
  <tr><td></td><td class="dot">______________________</td></tr>
  <tr><td></td><td class="dot">______________________</td></tr>
</table>

<br>
<tr><td></td></tr>
<table width="100%" cellpadding="2" cellspacing="0">
  <tr><td width="15%">Kepada:</td><td class="dot">______________________</td></tr>
  <tr><td></td><td class="dot">______________________</td></tr>
  <tr><td></td><td class="dot">______________________</td></tr>
<br>
<tr><td></td></tr>
</table>
<div class="small">(Nama dan Alamat Kementerian atau Jabatan)</div>

<br>
Tuan,
<br><br>
<b>Tawaran Untuk Tender No. ……………./……..</b>
<br><br>
Merujuk kepada perkara di atas, saya/ syarikat berminat menyertai tender tersebut.
<br><br>
2.  Tawaran saya/ syarikat adalah seperti berikut:-
<br><br>

<!-- Offer table -->
<table width="100%" cellpadding="5" cellspacing="0">
  <tr>
    <td class="th b" width="10%">Bil</td>
    <td class="th b" width="44%">Perihal Stok</td>
    <td class="th b" width="14%">Kuantiti</td>
    <td class="th b" width="16%">Harga Tawaran<br>(RM)</td>
    <td class="th b" width="16%">Deposit Tender</td>
  </tr>';
for ($i=0; $i<4; $i++) {
  $page1 .= '
  <tr>
    <td class="b tc">'.($i+1).'</td>
    <td class="b"></td>
    <td class="b tc"></td>
    <td class="b tc"></td>
    <td class="b tc"></td>
  </tr>';
}
$page1 .= '</table>';

$pdf->writeHTML($style.$page1, true, false, true, false, '');

/* ================= PAGE 2 ================= */
$pdf->AddPage();

$page2 = '
3.  Bersama-sama ini disertakan deposit tender (sebanyak 10% daripada harga tawaran Stok di atas atau RM10,000 mengikut mana yang terendah) yang bernilai RM _________ (Ringgit Malaysia ____________________________) dalam bentuk Wang Pos/ Draf Bank, No. ________________________ atas nama ________________________ (Kementerian atau Jabatan).
<br><br>
4.  Saya/ syarikat memahami dan bersetuju dengan semua syarat-syarat yang ditetapkan.
<br><br>
Sekian, terima kasih.
<br><br><br>

<table width="100%" cellpadding="4" cellspacing="0">
  <tr>
    <td width="28%">Tandatangan</td>
    <td width="3%">:</td>
    <td class="dot">..................................</td>
  </tr>
  <tr>
    <td>Tarikh</td>
    <td>:</td>
    <td class="dot">..................................</td>
  </tr>
  <tr>
    <td>Cap Syarikat</td>
    <td>:</td>
    <td class="dot">..................................</td>
  </tr>
</table>
';

$pdf->writeHTML($style.$page2, true, false, true, false, '');

$pdf->Output('kew_ps_24_borang_tender_pelupusan_stok.pdf', 'I');
