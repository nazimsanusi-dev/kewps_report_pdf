<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF
{
    public function Header()
    {
        // Top meta line
        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 5, 'Pekeliling Perbendaharaan Malaysia', 0, 0, 'L');
        $this->Cell(0, 5, 'AM 6.9 Lampiran K', 0, 1, 'R');

        // Form code
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 6, 'KEW.PS-29', 0, 1, 'R');

        // Title
        $this->Ln(2);
        $this->SetFont('helvetica', 'B', 13);
        $this->Cell(0, 7, 'KENYATAAN JUALAN LELONG STOK', 0, 1, 'C');
        $this->Ln(2);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(), 0, 0, 'C');
    }
}

/* ------------ Optional dynamic values (fill/leave blank) ------------- */
$kementerian  = ' XYZ 123 / ABC 456';    // e.g. "Kementerian XYZ / Jabatan ABC"
$tarikh       = '12 Ogos 2025';    // e.g. "12 Ogos 2025"
$masa         = '9:00 pagi';    // e.g. "9:00 pagi"
$tempat       = 'Dewan Lelongan Jabatan, Putrajaya';    // e.g. "Dewan Lelongan Jabatan, Putrajaya"
$jam          = '9.00 PAGI';

/* ---------------- Helpers for underlines ---------------- */
function Dot($minWidth = 140, $text = '')
{
    $mw  = (int)$minWidth;
    $txt = htmlspecialchars($text);
    return '<span style="display:inline-block;border-bottom:0.5px solid #000;min-width:'.$mw.'px;">'.($txt !== '' ? $txt : '&nbsp;').'</span>';
}

/* ---------------- Styles ---------------- */
$css = '
<style>
  .indent { text-align: justify; line-height: 1.6; }
  .no     { width:16px; }
  .roman  { width:25px; }
  .small  { font-size:9pt; }
  table { border-collapse: collapse; }
</style>
';

$pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-29 - Kenyataan Jualan Lelong Stok');

$pdf->SetMargins(15, 38, 15);
$pdf->SetHeaderMargin(8);
$pdf->SetAutoPageBreak(true, 18);
$pdf->SetFont('helvetica', '', 11);

$pdf->AddPage();

/* ---------------- Page content ---------------- */
$html = $css . '

<!-- Intro paragraph -->
<div class="indent">
Dimaklumkan bahawa Kementerian / Jabatan, <b>'.Dot(250, $kementerian).'</b> akan mengadakan jualan lelong Stok seperti berikut:-
</div>

<br>

<!-- Tarikh / Masa / Tempat -->
<table width="195%" cellpadding="2" cellspacing="0" border="0">
  <tr>
    <td width="70"><b>Tarikh</b></td><td width="10">:</td><td>'.Dot(220, $tarikh).'</td>
  </tr>
  <tr>
    <td><b>Masa</b></td><td>:</td><td>'.Dot(220, $masa).'</td>
  </tr>
  <tr>
    <td><b>Tempat</b></td><td>:</td><td>'.Dot(220, $tempat).'</td>
  </tr>
</table>

<br>
<br>

<!-- Item 2 -->
<table width="195%" cellpadding="2" cellspacing="0" border="0">
  <tr>
    <td class="no" valign="top">2.</td>
    <td class="indent">Senarai Stok yang akan dilelong adalah seperti di KEW.PS-30. Semua Stok boleh dilihat pada tarikh <b>'.Dot(120, $tarikh).'</b> hingga <b>'.Dot(120, $tarikh).'</b> di alamat <b>'.Dot(300, $tempat).'</b> di antara jam <b>'.Dot(120, $jam).'</b> hingga <b>'.Dot(120, $jam).'</b>.
    </td>
  </tr>
</table>

<br>
<br>

<!-- Item 3 heading -->
<table width="195%" cellpadding="2" cellspacing="0" border="0">
  <tr>
    <td class="no" valign="top">3.</td>
    <td class="indent">Syarat dan peraturan lelong adalah seperti berikut:-
    </td>
  </tr>
</table>

<br>

<!-- Roman numerals list -->
<table width="195%" cellpadding="2" cellspacing="0" border="0">
  <tr>
    <td class="roman" valign="top">(i)</td>
    <td class="indent">Stok akan dijual tertakluk kepada harga simpanan.</td>
  </tr>
  <tr>
    <td class="roman" valign="top">(ii)</td>
    <td class="indent">Pembida yang berminat untuk menyertai lelongan, perlu mendaftar dengan Pegawai Pelelong dengan memberikan nama penuh, No. Kad Pengenalan dan alamat kepada Pegawai Pelelong semasa lelongan dilakukan serta membayar deposit sebanyak 5% daripada harga simpanan atau maksimum RM1,000.
    </td>
  </tr>
  <tr>
    <td class="roman" valign="top">(iii)</td>
    <td class="indent">Penawar harga tertinggi adalah pembida yang berjaya dan jika ada apa-apa perselisihan yang berkbangkit mengenai penawar yang tertinggi, Stok berkenaan akan dilelong semula.
    </td>
  </tr>
  <tr>
    <td class="roman" valign="top">(iv)</td>
    <td class="indent">Jabatan berhak mengubah susunan jualan tersebut di senarai KEW.PS-30 dan menarik balik mana-mana Stok daripada senarai tersebut.
    </td>
  </tr>
  <tr>
    <td class="roman" valign="top">(v)</td>
    <td class="indent">Semua Stok adalah dilelong sebagaimana keadaannya semasa dilihat (<i>as-is-where-is basis</i>).
    </td>
  </tr>
  <tr>
    <td class="roman" valign="top">(vi)</td>
    <td class="indent">Jabatan ini tidak akan bertanggungjawab ke atas Stok yang telah dijual.
    </td>
  </tr>
  <tr>
    <td class="roman" valign="top">(vii)</td>
    <td class="indent">Semua perbelanjaan bagi mengangkut Stok hendaklah ditanggung oleh pembida sendiri.
    </td>
  </tr>
  <tr>
    <td class="roman" valign="top">(viii)</td>
    <td class="indent">Pembida yang berjaya hendaklah memberitahu nama penuh, no. Kad Pengenalan dan alamat kepada Pegawai Pelelong semasa jualan dilakukan.
    </td>
  </tr>
  <tr>
    <td class="roman" valign="top">(ix)</td>
    <td class="indent">Pembayaran penuh hendaklah dibuat dalam tempoh tujuh (7) hari dari tarikh lelongan.
    </td>
  </tr>
  <tr>
    <td class="roman" valign="top">(x)</td>
    <td class="indent">Pembida yang berjaya hendaklah mengambil Stok dalam tempoh empat belas (14) hari dari tarikh lelong. Jika tidak, Jabatan berhak untuk melupuskannya.
    </td>
  </tr>
  <tr>
    <td class="roman" valign="top">(xi)</td>
    <td class="indent">Segala bayaran hendaklah dijelaskan sepenuhnya sebelum Stok boleh dikeluarkan dari premis Jabatan.
    </td>
  </tr>
</table>
';

$pdf->writeHTML($html, true, false, true, false, '');

// Stream the PDF
$pdf->Output('kew_ps_29.pdf', 'I');
