<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF
{
    public function Header()
    {
        // Top meta
        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 5, 'Pekeliling Perbendaharaan Malaysia', 0, 0, 'L');
        $this->Cell(0, 5, 'AM 6.10 Lampiran D', 0, 1, 'R');

        // Form code
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 6, 'KEW.PS-35', 0, 1, 'R');

        // Title
        $this->Ln(2);
        $this->SetFont('helvetica', 'B', 13);
        $this->Cell(0, 7, 'SIJIL HAPUS KIRA STOK', 0, 1, 'C');
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 5, '(diisi oleh Pegawai Stor)', 0, 1, 'C');
        $this->Ln(4);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(), 0, 0, 'C');
    }
}

/* -------- optional dynamic values (leave '' for blank lines) -------- */
$bilKelulusan = '123/ABC';
$tarikh       = '14 OGOS 2024';
$rows         = 4;  // number of item rows

/* -------- helpers -------- */
function Dot($minWidth = 160, $text = '')
{
    $w = (int)$minWidth; $t = htmlspecialchars($text);
    return '<span style="display:inline-block;border-bottom:0.5px solid #000;min-width:'.$w.'px;">'.($t !== '' ? $t : '&nbsp;').'</span>';
}

/* -------- styles -------- */
$css = '
<style>
  .small { font-size:9pt; }
  .indent { text-align: justify; line-height:1.6; }
  .th { background-color:#d9d9d9; font-weight:bold; text-align:center; border:0.5px solid #000; }
  .tc { text-align:center; }
  .tr { text-align:right; }
  table { border-collapse:collapse; }
</style>
';

$pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-35 - Sijil Hapus Kira Stok');

$pdf->SetMargins(15, 58, 15);   // header uses two lines
$pdf->SetHeaderMargin(8);
$pdf->SetAutoPageBreak(true, 18);
$pdf->SetFont('helvetica', '', 11);

$pdf->AddPage();

/* -------- body -------- */
$html  = $css;

/* Opening paragraph */
$html .= '
<div class="indent">
Merujuk surat kelulusan Bil <b>'.Dot(200, $bilKelulusan).'</b> bertarikh <b>'.Dot(120, $tarikh).'</b>. Stok berikut telah dihapus kira dan Daftar Stok berkenaan telah dikemaskini.
</div>
<br>
';

/* Items table */
$html .= '
<table cellpadding="5" cellspacing="0" width="100%" style="border:0.5px solid #000; margin-top:4px;">
  <tr>
    <td class="th" width="18%">No. Kod</td>
    <td class="th" width="58%">Perihal Stok</td>
    <td class="th" width="24%">Kuantiti</td>
  </tr>';

for ($i = 0; $i < $rows; $i++) {
    $html .= '
  <tr>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000; border-left:0.5px solid #000;"></td>
    <td style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
    <td class="tc" style="border-top:0.5px solid #000; border-right:0.5px solid #000;"></td>
  </tr>';
}
$html .= '</table>';

/* Signature block */
$html .= '
<br><br>
<table width="90%" cellpadding="4" cellspacing="0" border="0">
  <tr><td></td></tr>
  <tr>
    <td width="40%">Tandatangan Ketua Jabatan</td>
    <td width="3%">:</td>
    <td style="border-bottom:0.5px solid #000;">&nbsp;</td>
  </tr>
  <tr>
    <td>Nama</td>
    <td>:</td>
    <td style="border-bottom:0.5px solid #000;">&nbsp;</td>
  </tr>
  <tr>
    <td>Jawatan</td>
    <td>:</td>
    <td style="border-bottom:0.5px solid #000;">&nbsp;</td>
  </tr>
  <tr>
    <td>Tarikh</td>
    <td>:</td>
    <td style="border-bottom:0.5px solid #000;">&nbsp;</td>
  </tr>
  <tr>
    <td>Nama Kementerian/Jabatan</td>
    <td>:</td>
    <td style="border-bottom:0.5px solid #000;">&nbsp;</td>
  </tr>
</table>
';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('kew_ps_35.pdf', 'I');
