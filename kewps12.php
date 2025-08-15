<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF
{
    public function Header()
    {
        // Top meta line: left + right
        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 5, 'Pekeliling Perbendaharaan Malaysia', 0, 0, 'L');
        $this->Cell(0, 5, 'AM 6.6 Lampiran C', 0, 1, 'R');

        // Form code at far right
        $this->Ln(2);
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 6, 'KEW.PS-12', 0, 1, 'R');

        // Title
        $this->Ln(6);
        $this->SetFont('helvetica', 'B', 14);
        $this->Cell(0, 8, 'SIJIL VERIFIKASI STOR BAGI TAHUN………..', 0, 1, 'C');

        // Space before body
        $this->Ln(10);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(), 0, 0, 'C');
    }
}

// Optional dynamic values (leave empty to keep underlines)
$tahun        = '2026';      // e.g. 2025
$kategoriStor = '';      // e.g. "Stor Am"
$jabatan      = '';      // e.g. "Jabatan/Bahagian/PTJ ABC"
$verifikasi   = '';      // e.g. "92"
$prestasi     = '';      // e.g. "88"
$ketuaNama    = '';
$ketuaJawatan = '';
$ketuaTarikh  = '';

// Helpers to show underline when value missing
function Uline($text, $minWidth = 420) {
    $w = (int)$minWidth;
    if (trim($text) === '') {
        return '<span style="display:inline-block;border-bottom:0.5px solid #000;min-width:'.$w.'px">&nbsp;</span>';
    }
    return '<span style="display:inline-block;border-bottom:0.5px solid #000;min-width:'.$w.'px">'.$text.'</span>';
}
function Ubox($text, $minWidth = 120) {
    $w = (int)$minWidth;
    if (trim($text) === '') {
        return '<span style="display:inline-block;border-bottom:0.5px solid #000;min-width:'.$w.'px">&nbsp;</span>';
    }
    return '<span style="display:inline-block;border-bottom:0.5px solid #000;min-width:'.$w.'px">'.$text.'</span>';
}

// Build body
$html = '
<style>
  .small { font-size:10pt; }
  .lineh { line-height:1.6; }
</style>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="lineh" style="text-align:justify;">
      Adalah disahkan bahawa 
      <span style="display:inline-block; border-bottom:0.5px solid #000; min-width:420px;">&nbsp;</span> 
      di
    </td>
  </tr>
  <tr><td height="6"></td></tr>
  <tr>
    <td align="center" class="small">(Kategori Stor)</td>
  </tr>
  <tr><td height="6"></td></tr>
  <tr>
    <td>
      <span style="display:inline-block; border-bottom:0.5px solid #000; min-width:420px;">&nbsp;</span>
    </td>
  </tr>
  <tr>
    <td align="center" class="small">(Jabatan/Bahagian/PTJ)</td>
  </tr>
  <tr><td height="8"></td></tr>
  <tr>
    <td class="lineh" style="text-align:justify;">
      telah dilaksanakan verifikasi stor dan telah mendapat markah seperti berikut:-
    </td>
  </tr>
</table>

<br>

<table width="100%" border="0" cellpadding="2" cellspacing="0" class="lineh">
  <tr>
    <td width="35%">a) Pelaksanaan Verifikasi Stor</td>
    <td width="5%">:</td>
    <td width="30%"> <?= Ubox($verifikasi) ?> %</td>
  </tr>
  <tr>
    <td width="35%">b) Prestasi Penilaian Stor</td>
    <td width="5%">:</td>
    <td width="30%"> <?= Ubox($prestasi) ?> %</td>
  </tr>
</table>


<br><br>

<table width="100%" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td width="35%">Nama Ketua Jabatan</td>
    <td width="5%">:</td>
    <td width="60%">'.Uline($ketuaNama).'</td>
  </tr>
  <tr>
    <td>Jawatan</td>
    <td>:</td>
    <td>'.Uline($ketuaJawatan).'</td>
  </tr>
  <tr>
    <td>Tarikh</td>
    <td>:</td>
    <td>'.Uline($ketuaTarikh).'</td>
  </tr>
</table>
';

$pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-12 - Sijil Verifikasi Stor');

$pdf->SetMargins(18, 45, 18);   // left, top, right (top leaves space for header)
$pdf->SetHeaderMargin(8);
$pdf->SetAutoPageBreak(true, 20);
$pdf->SetFont('helvetica', '', 11);

$pdf->AddPage();
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('kew_ps_12.pdf', 'I');
