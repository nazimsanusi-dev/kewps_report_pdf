<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
  public function Header() {
    // Meta left/right
    $this->SetFont('helvetica','',9);
    $this->Cell(0,5,'Pekeliling Perbendaharaan Malaysia',0,0,'L');
    $this->Cell(0,5,'AM 6.9 Lampiran G',0,1,'R');

    // Form code
    $this->SetFont('helvetica','B',12);
    $this->Cell(0,6,'KEW.PS-25',0,1,'R');

    // Titles
    $this->Ln(2);
    $this->SetFont('helvetica','B',13);
    $this->Cell(0,7,'JADUAL TENDER PELUPUSAN STOK',0,1,'C');
    $this->SetFont('helvetica','',10);
    $this->Cell(0,5,'(Untuk dipamer di Papan Kenyataan)',0,1,'C');
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
$pdf->SetTitle('KEW.PS-25 – Jadual Tender Pelupusan Stok');

$pdf->SetMargins(16, 46, 16);
$pdf->SetHeaderMargin(6);
$pdf->SetAutoPageBreak(true, 20);
$pdf->SetFont('helvetica','',10);
$pdf->AddPage();

/* -------- Styles -------- */
$style = '
<style>
  table { border-collapse: collapse; }
  .b  { border:0.5px solid #000; }
  .th { background-color:#d9d9d9; font-weight:bold; text-align:center; }
  .tc { text-align:center; }
  .tl { text-align:left; }
  .dot{ letter-spacing:0px; }
  .small{ font-size:9pt; }
</style>
';

/* -------- Main table (3 columns) -------- */
$head = '
<table width="100%" cellpadding="5" cellspacing="0">
  <tr>
    <td class="th b" width="10%">Bil.</td>
    <td class="th b" width="55%">Kod Petender</td>
    <td class="th b" width="35%">Harga</td>
  </tr>';
$rows = '';
for ($i=0; $i<5; $i++) {
  $rows .= '
  <tr>
    <td class="b tc" style="height:24px;">'.($i+1).'.</td>
    <td class="b"></td>
    <td class="b"></td>
  </tr>';
}
$table = $head.$rows.'</table>';

/* -------- Nota -------- */
$nota = '
<br>
<table width="100%" cellpadding="3" cellspacing="0">
  <tr>
    <td width="8%" class="tl"><b>Nota :</b></td>
    <td width="91%"class="tl">Harga tawaran di atas adalah harga yang tercatat di dalam dokumen tender yang diterima sebelum diperiksa. Kerajaan adalah tidak terikat menerima mana-mana tender yang dijadualkan.
    </td>
  </tr>
</table>
';

/* -------- Signatures -------- */
$sig = '
<br><br>
<table width="100%" cellpadding="2" cellspacing="0">
    <tr><td><div></div></td></tr>
    <tr>
    <td width="100%" class="tc">
      <div>___________________________</div>
      <div class="small">(Tandatangan Pengerusi)</div>
      <br>
      <div class="tc" style="display:inline-block; min-width:60%;">Nama : <span class="dot">___________________________</span><br>Jawatan : <span class="dot">___________________________</span>
      </div>
    </td>
    </tr>
    <tr><td><div></div></td></tr>
</table>

<br>
<table width="100%" cellpadding="2" cellspacing="0">
  <tr>
    <td width="50%" class="tc" valign="top">
      <div>____________________________</div>
      <div class="small">(Tandatangan Ahli)</div>
      <br>
      <div class="tl" style="display:inline-block; min-width:75%;">
        Nama : <span class="dot">___________________________</span><br>
        Jawatan : <span class="dot">___________________________</span>
      </div>
    </td>
    <td width="50%" class="tc" valign="top">
      <div>____________________________</div>
      <div class="small">(Tandatangan Ahli)</div>
      <br>
      <div class="tl" style="display:inline-block; min-width:75%;">
        Nama : <span class="dot">___________________________</span><br>
        Jawatan : <span class="dot">___________________________</span>
      </div>
    </td>
  </tr>
</table>

<br><br>
<div class="tc">Tarikh : <span class="dot">________________________</span></div>
';

/* -------- Render -------- */
$pdf->writeHTML($style.$table.$nota.$sig, true, false, true, false, '');
$pdf->Output('kew_ps_25_jadual_tender_pelupusan_stok.pdf', 'I');
