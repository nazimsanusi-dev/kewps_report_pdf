<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF {
  public function Header() {
    // Meta (left/right)
    $this->SetFont('helvetica','',9);
    $this->Cell(0,5,'Pekeliling Perbendaharaan Malaysia',0,0,'L');
    $this->Cell(0,5,'AM 6.9 Lampiran C',0,1,'R');

    // Form code
    $this->SetFont('helvetica','B',12);
    $this->Cell(0,6,'KEW.PS-21',0,1,'R');

    $this->Ln(2);
    // Title
    $this->SetFont('helvetica','B',13);
    $this->Cell(0,7,'SIJIL PENYAKSIAN PEMUSNAHAN STOK',0,1,'C');
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
$pdf->SetTitle('KEW.PS-21 – Sijil Penyaksian Pemusnahan Stok');

$pdf->SetMargins(18, 48, 18);
$pdf->SetHeaderMargin(6);
$pdf->SetAutoPageBreak(true, 18);
$pdf->SetFont('helvetica','',10);
$pdf->AddPage();

/* ---------- Styles ---------- */
$style = '
<style>
  table { border-collapse: collapse; }
  .small { font-size: 9pt; }
  .dot  { letter-spacing: 2px; width:100%;}            /* makes dotted leaders look neat */
  .spacer { height: 8px; }
  .label { width: 28%; }                    /* left label width inside detail grid */
  .colon { width: 3%;  }
  .tl { text-align:left; }
</style>
';

/* ---------- Opening sentence ---------- */
$intro = '
<table width="100%" cellpadding="2" cellspacing="0">
  <tr>
    <td style="text-align:justify;">
      Disahkan stok di Kementerian/ Jabatan<span class="dot">.......................................</span>
      seperti berikut telah dimusnahkan.
    </td>
  </tr>
</table>
<br>
';
$spacing = '<div></div>';
/* ---------- Details block ---------- */
$details = '
<table class="centered-table" width="70%" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td class="label">Perihal Stok</td><td class="colon">:</td>
    <td class="dot">.........................................................</td>
  </tr>
  <tr>
    <td>Kuantiti</td><td>:</td>
    <td class="dot">.........................................................</td>
  </tr>
  <tr>
    <td>Secara</td><td>:</td>
    <td class="dot">.........................................................</td>
  </tr>
  <tr>
    <td>Tarikh</td><td>:</td>
    <td class="dot">.........................................................</td>
  </tr>
  <tr>
    <td>Tempat</td><td>:</td>
    <td class="dot">.........................................................</td>
  </tr>
</table>
<br><br><br>
';

/* ---------- Signatures (2 columns) ---------- */
$sign = '
<table width="100%" cellpadding="0" cellspacing="0" style="margin-top:50px;">
  <tr>

    <!-- Left signer -->
    <td width="50%" valign="top" style="text-align:center;">
      <table width="80%" align="center" cellpadding="2" cellspacing="0">
       <tr><td width="70%" class="tl">...................................</td><td width="5%"></td><td></td></tr>
        <tr><td width="50%" class="tl">(Tandatangan)</td><td width="5%"></td><td></td></tr>
        <tr><td class="tl">Nama</td><td width="5%">:</td><td></td></tr>
        <tr><td class="tl">Jawatan</td><td>:</td><td></td></tr>
        <tr><td class="tl">Nama Kementerian/Jabatan</td><td>:</td><td></td></tr>
      </table>
    </td>

    <!-- Right signer -->
    <td width="50%" valign="top" style="text-align:center;">
      <table width="80%" align="center" cellpadding="2" cellspacing="0">
       <tr><td width="70%" class="tl">...................................</td><td width="5%"></td><td></td></tr>
        <tr><td width="50%" class="tl">(Tandatangan)</td><td width="5%"></td><td></td></tr>
        <tr><td class="tl">Nama</td><td width="5%">:</td><td></td></tr>
        <tr><td class="tl">Jawatan</td><td>:</td><td></td></tr>
        <tr><td class="tl">Nama Kementerian/Jabatan</td><td>:</td><td></td></tr>
      </table>
    </td>

  </tr>
</table>
';

$pdf->writeHTML($style.$intro.$spacing.$details.$sign, true, false, true, false, '');
$pdf->Output('kew_ps_21_sijil_penyaksian_pemusnahan_stok.pdf', 'I');
