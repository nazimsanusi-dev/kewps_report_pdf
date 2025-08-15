<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF
{
    public function Header()
    {
        // Top meta
        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 5, 'Pekeliling Perbendaharaan Malaysia', 0, 0, 'L');
        $this->Cell(0, 5, 'AM 6.10 Lampiran B', 0, 1, 'R');

        // Form code
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 6, 'KEW.PS-33', 0, 1, 'R');

        // Right-aligned "No. Rujukan Fail / Tarikh"
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 5, 'No. Rujukan Fail:                        ', 0, 1, 'R');
        $this->Cell(0, 5, 'Tarikh:                        ', 0, 1, 'R');

        // Title
        $this->Ln(2);
        $this->SetFont('helvetica', 'B', 13);
        $this->Cell(0, 7, 'PELANTIKAN JAWATANKUASA PENYIASAT KEHILANGAN STOK', 0, 1, 'C');
        $this->Ln(2);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(), 0, 0, 'C');
    }
}

/* ---------- optional dynamic values (leave '' to keep lines) ---------- */
$kepada1 = 'NAZIM SANUSI';  $kepada2 = 'AKMAL XXX';  $pegawaiDilantik = 'SOFTWARE DEVELEPOR';
$namaStok = 'CHICKEN RICE SHOP'; $lokasi = 'UPNM SUNGGAI BESI';   $rujLaporanAwal = '123456';

/* ---------- helpers ---------- */
function Dot($minWidth = 160, $text = '')
{
    $w = (int)$minWidth; $t = htmlspecialchars($text);
    return '<span style="display:inline-block;border-bottom:0.5px solid #000;min-width:'.$w.'px;">'.($t !== '' ? $t : '&nbsp;').'</span>';
}

/* ---------- styles ---------- */
$css = '
<style>
  .indent { text-align: justify; line-height: 1.6; }
  .no     { width:18px; }
  .small  { font-size:9pt; }
  table   { border-collapse: collapse; }
</style>
';

$pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-33 - Pelantikan Jawatankuasa Penyiasat Kehilangan Stok');

$pdf->SetMargins(15, 54, 15);   // leave space for header block
$pdf->SetHeaderMargin(8);
$pdf->SetAutoPageBreak(true, 20);
$pdf->SetFont('helvetica', '', 11);
$pdf->AddPage();

/* ---------- body ---------- */
$html  = $css;

/* Kepada block */
$html .= '
<div><b>Kepada:</b></div>
'.Dot(240, $kepada1).'<br>'.Dot(240, $kepada2).'<br>
<span class="small">(Nama dan Jawatan Pegawai yang dilantik)</span>
<br><br>
';

/* Paragraph 1 */
$html .= '
<div class="indent">
Adalah dimaklumkan bahawa tuan/ puan dilantik sebagai Pengerusi/ Ahli Jawatankuasa Penyiasat untuk menyiasat kehilangan '.Dot(220, $namaStok).' (nama Stok) di '.Dot(320, $lokasi).' (Kementerian/ Jabatan/ PTJ) mulai dari tarikh surat ini. (No. Rujukan Laporan Awal '.Dot(220, $rujLaporanAwal).'.)
</div>
<br>
';

/* Paragraph 2 */
$html .= '
<table width="195%" cellpadding="2" cellspacing="0" border="0">
  <tr>
    <td class="no" valign="top">2.</td>
    <td class="indent">Tuan/ Puan adalah diberi kuasa untuk menjalankan siasatan dengan mendapatkan maklumat mengenai kes kehilangan tersebut daripada mana-mana pegawai yang berkenaan. Bersama-sama ini disertakan Laporan Awal dan Senarai Tugas Jawatankuasa Penyiasat sebagai panduan.
    </td>
  </tr>
</table>
<br>
';

/* Paragraph 3 */
$html .= '
<table width="195%" cellpadding="2" cellspacing="0" border="0">
  <tr>
    <td class="no" valign="top">3.</td>
    <td class="indent">Laporan siasatan hendaklah menggunakan Laporan Akhir (KEW.PS-34) seperti yang dilampirkan. Laporan ini mestilah dikembalikan sebelum '.Dot(180).' (tarikh).
    </td>
  </tr>
</table>
<br><br>
';

/* Signature block */
$html .= '
<table width="70%" cellpadding="4" cellspacing="0" border="0">
  <tr><td></td></tr>
  <tr><td></td></tr>
  <tr><td></td></tr>
  <tr>
    <td width="48S%">Tandatangan</td>
    <td width="4%">:</td>

  </tr>
  <tr>
    <td>Nama Pegawai Pengawal</td>
    <td>:</td>

  </tr>
  <tr>
    <td>Kementerian/Jabatan</td>
    <td>:</td>

  </tr>
</table>
';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('kew_ps_33.pdf', 'I');
