<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
  public function Header() {
    // Top meta (left/right)
    $this->SetFont('helvetica','',9);
    $this->Cell(0,5,'Pekeliling Perbendaharaan Malaysia',0,0,'L');
    $this->Cell(0,5,'AM 6.9 Lampiran A',0,1,'R');

    // Form code + No. Rujukan/Tarikh
    $this->SetFont('helvetica','B',12);
    $this->Cell(0,6,'KEW.PS-19',0,1,'R');

    $this->Cell(0,6,'',0,1,'R');

    $this->SetFont('helvetica','',10);
    $this->Cell(0,5,'No. Rujukan:  ……………………',0,1,'R');
    $this->Cell(0,5,'Tarikh:  ……………………',0,1,'R');

    // Space before body
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
$pdf->SetTitle('KEW.PS-19 – Lantikan Lembaga Pemeriksa Pelupusan Stok Kerajaan');

$pdf->SetMargins(16, 44, 16);
$pdf->SetHeaderMargin(6);
$pdf->SetAutoPageBreak(true, 18);
$pdf->SetFont('helvetica','',10);
$pdf->AddPage();

/* ---------- Styles ---------- */
$style = '
<style>
  table { border-collapse: collapse; }
  .subject { font-weight:bold; text-transform:uppercase; }
  .dot { letter-spacing:2px; } /* for neat dotted lines like in sample */
  .small { font-size:9pt; }
  .indent {
    text-indent: 24px;
    text-align: justify;
    margin-top: 12px;         /* Adds space above the paragraph */
    line-height: 2.5;         /* Adds space between lines/sentences */
  }  
</style>
';

/* ---------- Body ---------- */
$body = '
<table width="100%" cellpadding="2" cellspacing="0">
  <tr><td width="12%">Kepada:</td><td class="dot">.................................</td></tr>
  <tr><td></td><td class="dot">.................................</td></tr>
  <tr><td></td><td class="dot">.................................</td></tr>
  <tr><td></td><td class="small">(Gelaran Jawatan Pegawai yang dilantik)</td></tr>
</table>

<br><br>
Tuan/ Puan,
<br><br>

<div class="subject">LANTIKAN SEBAGAI LEMBAGA PEMERIKSA PELUPUSAN STOK KERAJAAN</div>

<p class="indent">
Adalah dimaklumkan bahawa Tuan/Puan dilantik sebagai Pengerusi/Ahli
Lembaga Pemeriksa untuk memeriksa stok yang dicadangkan untuk dilupuskan
bagi tempoh selama ________ (tahun) mulai dari ________ hingga
________.
</p>

<p class="indent">
2. Laporan pemeriksaan hendaklah disediakan dengan menggunakan
Borang Pelupusan Stok (KEW.PS-20) dan dikemukakan kepada Urus Setia
Pelupusan Jabatan dalam tempoh dua (2) minggu selepas pemeriksaan
dijalankan.
</p>

<div></div><div></div><div></div><div></div>

<br><br><br>
<table width="100%" cellpadding="2" cellspacing="0" margin-top="30">
  <tr><td class="dot">......................................</td></tr>
  <tr><td class="small">(Tandatangan)</td></tr>
</table>
<br>
<table width="100%" cellpadding="2" cellspacing="0">
  <tr><td width="25%">Nama</td><td width="3%">:</td><td class="dot">..............................</td></tr>
  <tr><td>Jawatan</td><td>:</td><td class="dot">..............................</td></tr>
  <tr><td>Kementerian/ Jabatan</td><td>:</td><td class="dot">..............................</td></tr>
</table>
';

$pdf->writeHTML($style.$body, true, false, true, false, '');
$pdf->Output('kew_ps_19_lantikan_lembaga_pemeriksa.pdf', 'I');

