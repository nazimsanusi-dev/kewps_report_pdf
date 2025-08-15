<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF
{
    public function Header()
    {
        // Top meta
        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 5, 'Pekeliling Perbendaharaan Malaysia', 0, 0, 'L');
        $this->Cell(0, 5, 'AM 6.9 Lampiran I', 0, 1, 'R');

        // Form code
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 6, 'KEW.PS-27', 0, 1, 'R');

        // Title
        $this->Ln(2);
        $this->SetFont('helvetica', 'B', 13);
        $this->Cell(0, 7, 'BORANG SEBUT HARGA PELUPUSAN STOK', 0, 1, 'C');

        $this->Ln(2);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(), 0, 0, 'C');
    }
}

/* ---------- OPTIONAL: dynamic variables (fill or leave '') ---------- */
$namaIndividu   = '';
$noPengenalan   = '';
$alamat1        = '';
$alamat2        = '';
$alamat3        = '';
$kepada1        = '';
$kepada2        = '';
$kepada3        = '';
$rujNo          = '';   // for "Tawaran Untuk Sebut Harga No."
$items = [
  // ['bil','perihal','kuantiti','harga','deposit']
  ['1','','','',''],
  ['2','','','',''],
  ['3','','','',''],
  ['4','','','',''],
];

/* ---------- helpers for underlines/inline blanks ---------- */
function Uline($text, $minWidth = 300) {
    // long underline for form fields (block)
    $mw = (int)$minWidth;
    $txt = htmlspecialchars($text);
    return '<span style="display:inline-block;border-bottom:0.5px solid #000;min-width:'.$mw.'px;">'.($txt ?: '&nbsp;').'</span>';
}
function Dot($minWidth = 120, $text = '') {
    // short inline underline within paragraphs
    $mw = (int)$minWidth;
    $txt = htmlspecialchars($text);
    return '<span style="display:inline-block;border-bottom:0.5px solid #000;min-width:'.$mw.'px;">'.($txt ?: '&nbsp;').'</span>';
}

/* ---------- styles ---------- */
$css = '
<style>
  .small { font-size:9pt; }
  .indent { text-align: justify; line-height:1.6; }
  .label { width:180px; }
  .dline { border-bottom:0.5px solid #000; display:inline-block; min-width:360px; }
  .th { background-color:#d9d9d9; font-weight:bold; text-align:center; border:0.5px solid #000; }
  .tc { text-align:center; }
  .tr { text-align:right; }
  table { border-collapse:collapse; }
</style>
';

$pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-27 - Borang Sebut Harga Pelupusan Stok');

$pdf->SetMargins(15, 38, 15);
$pdf->SetHeaderMargin(8);
$pdf->SetAutoPageBreak(true, 18);
$pdf->SetFont('helvetica', '', 11);

/* ---------------- PAGE 1 ---------------- */
$pdf->AddPage();

$pg1 = $css.'
<table width="100%" cellpadding="2" cellspacing="0" border="0">
  <tr>
    <td class="label">Nama Individu/ Syarikat</td>
    <td width="10">:</td>
    <td>______________________</td>
  </tr>
  <tr>
    <td>No. Kad Pengenalan/ Pendaftaran Syarikat</td>
    <td>:</td>
    <td>______________________</td>
  </tr>
  <tr>
    <td valign="top">Alamat</td>
    <td valign="top">:</td>
    <td>______________________<br/>
        ______________________<br/>
        ______________________
    </td>
  </tr>
</table>

<br>

<table width="100%" cellpadding="2" cellspacing="0" border="0">
  <tr>
    <td valign="top" class="label">Kepada</td>
    <td width="10" valign="top">:</td>
    <td>______________________<br/>
    ______________________<br/>
    ______________________<br/>
      <span class="small">(Nama dan Alamat Kementerian atau Jabatan)</span>
    </td>
  </tr>
</table>

<br>

<div>Tuan,</div>
<br>

<div><b><i>Tawaran Untuk Sebut Harga No.</i> ______________________ / ______________________</b></div>

<br>

<div class="indent">
Merujuk kepada perkara di atas, saya/ syarikat berminat menyertai sebut harga tersebut.
</div>

<br>

<div class="indent"><b>2.</b> Tawaran saya/ syarikat adalah seperti berikut:-</div>

<table cellpadding="5" cellspacing="0" width="100%" style="border:0.5px solid #000; margin-top:6px;">
  <tr>
    <td class="th" width="8%">Bil</td>
    <td class="th" width="48%">Perihal Stok</td>
    <td class="th" width="12%">Kuantiti</td>
    <td class="th" width="20%">Harga Tawaran<br>(RM)</td>
    <td class="th" width="12%">Deposit Sebut<br>Harga</td>
  </tr>';

foreach ($items as $r) {
  list($bil,$perihal,$kuantiti,$harga,$deposit) = array_pad($r,5,'');
  $pg1 .= '
  <tr>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000; border-left:0.5px solid #000;">'.htmlspecialchars($bil).'</td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;">'.htmlspecialchars($perihal).'</td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;" class="tc">'.htmlspecialchars($kuantiti).'</td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;" class="tr">'.htmlspecialchars($harga).'</td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;" class="tr">'.htmlspecialchars($deposit).'</td>
  </tr>';
}
$pg1 .= '</table>';

$pdf->writeHTML($pg1, true, false, true, false, '');

/* ---------------- PAGE 2 ---------------- */
$pdf->AddPage();

$pg2 = $css.'
<table width="195%" cellpadding="2" cellspacing="0" border="0">
  <tr>
    <td width="16" valign="top">3.</td>
    <td class="indent">Bersama-sama ini disertakan deposit sebut harga (sebanyak 5% daripada harga tawaran aset di atas atau RM5,000 mengikut mana yang terendah) yang bernilai RM '.Dot(120).' (Ringgit Malaysia '.Dot(180).') dalam bentuk Wang Pos/ Draf Bank, No. '.Dot(140).' atas nama '.Dot(220).' (Kementerian atau Jabatan).
    </td>
  </tr>
  <tr><td height="8"></td><td></td></tr>
  <tr>
    <td valign="top">4.</td>
    <td class="indent">Saya/ syarikat memahami dan bersetuju dengan semua syarat-syarat yang ditetapkan.
    </td>
  </tr>
</table>

<br><br>
<div>Sekian, terima kasih.</div>

<br><br><br>

<table width="70%" cellpadding="3" cellspacing="0" border="0">
  <tr>
    <td width="35%">Tandatangan</td>
    <td width="5%">:</td>
    <!-- <td style="border-bottom:0.5px solid #000;">&nbsp;</td> -->
  </tr>
  <tr>
    <td>Tarikh</td>
    <td>:</td>
    <!-- <td style="border-bottom:0.5px solid #000;">&nbsp;</td> -->
  </tr>
  <tr>
    <td>Cap Syarikat</td>
    <td>:</td>
    <!-- <td style="border-bottom:0.5px solid #000;">&nbsp;</td> -->
  </tr>
</table>
';

$pdf->writeHTML($pg2, true, false, true, false, '');

$pdf->Output('kew_ps_27.pdf', 'I');
