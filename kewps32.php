<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF
{
    public function Header()
    {
        // Top meta
        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 5, 'Pekeliling Perbendaharaan Malaysia', 0, 0, 'L');
        $this->Cell(0, 5, 'AM 6.10 Lampiran A', 0, 1, 'R');

        // Form code
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 6, 'KEW.PS-32', 0, 1, 'R');

        // Title
        $this->Ln(2);
        $this->SetFont('helvetica', 'B', 13);
        $this->Cell(0, 6, 'LAPORAN AWAL KEHILANGAN STOK', 0, 1, 'C');
        $this->Ln(2);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(), 0, 0, 'C');
    }
}

/* ---------- styles ---------- */
$css = '
<style>
  .indent { text-align: justify; line-height: 1.6; }
  .no     { width:18px; }
  .alpha  { width:16px; }
  .small  { font-size:9pt; }
  table   { border-collapse:collapse; }
</style>
';

$pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-32 - Laporan Awal Kehilangan Stok');

$pdf->SetMargins(15, 28, 15);
$pdf->SetHeaderMargin(8);
$pdf->SetAutoPageBreak(true, 18);
$pdf->SetFont('helvetica', '', 9);

$pdf->AddPage();

/* ---------- content ---------- */
$html  = $css;
$html .= '<div style="font-weight:bold;">Nyatakan:-</div>';

$html .= '
<table width="195%" cellpadding="2" cellspacing="0" border="0">
  <tr>
    <td class="no" valign="top">1.</td>
    <td class="indent">
      Keterangan Stok yang hilang.<br>
      <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr><td class="alpha" valign="top">(a)</td><td class="indent">Perihal Stok</td></tr>
        <tr><td class="alpha" valign="top">(b)</td><td class="indent">Jenama dan Model</td></tr>
        <tr><td class="alpha" valign="top">(c)</td><td class="indent">Kuantiti</td></tr>
        <tr><td class="alpha" valign="top">(d)</td><td class="indent">Tarikh Perolehan</td></tr>
        <tr><td class="alpha" valign="top">(e)</td><td class="indent">Harga Perolehan</td></tr>
        <tr><td class="alpha" valign="top">(f)</td><td class="indent">Anggaran Nilai Semasa</td></tr>
      </table>
    </td>
  </tr>

  <tr><td height="6"></td><td></td></tr>

  <tr>
    <td class="no" valign="top">2.</td>
    <td class="indent">Tempat sebenar di mana kehilangan berlaku.</td>
  </tr>

  <tr><td height="6"></td><td></td></tr>

  <tr>
    <td class="no" valign="top">3.</td>
    <td class="indent">Tarikh kehilangan berlaku atau diketahui.</td>
  </tr>

  <tr><td height="6"></td><td></td></tr>

  <tr>
    <td class="no" valign="top">4.</td>
    <td class="indent">Nyatakan cara bagaimana kehilangan berlaku lebih terperinci dan jelas termasuk pegawai-pegawai yang terlibat dan Stok kali terakhir ditinggalkan di mana.
    </td>
  </tr>

  <tr><td height="6"></td><td></td></tr>

  <tr>
    <td class="no" valign="top">5.</td>
    <td class="indent">Nama dan jawatan pegawai yang akhir sekali menyimpan/mengguna Stok yang hilang.</td>
  </tr>

  <tr><td height="6"></td><td></td></tr>

  <tr>
    <td class="no" valign="top">6.</td>
    <td class="indent">
      Nyatakan taraf jawatan pegawai (tetap/kontrak/sambilan).<br>
      <table width="195%" cellpadding="0" cellspacing="0" border="0">
        <tr><td class="alpha" valign="top">(a)</td><td class="indent">Tetap (Tarikh pencen dinyatakan)</td></tr>
        <tr><td class="alpha" valign="top">(b)</td><td class="indent">Kontrak (Salinan perjanjian)</td></tr>
        <tr><td class="alpha" valign="top">(c)</td><td class="indent">Sambilan (Salinan surat pelantikan)</td></tr>
      </table>
    </td>
  </tr>

  <tr><td height="6"></td><td></td></tr>

  <tr>
    <td class="no" valign="top">7.</td>
    <td class="indent">Sama ada seseorang pegawai difikirkan <i>prima facie</i> bertanggungjawab ke atas kehilangan itu. Jika ya, nama dan jawatannya.
    </td>
  </tr>

  <tr><td height="6"></td><td></td></tr>

  <tr>
    <td class="no" valign="top">8.</td>
    <td class="indent">Sama ada seseorang pegawai telah ditahan kerja.</td>
  </tr>

  <tr><td height="6"></td><td></td></tr>

  <tr>
    <td class="no" valign="top">9.</td>
    <td class="indent">No. Rujukan dan Tarikh Laporan Polis (jika ada).</td>
  </tr>

  <tr><td height="6"></td><td></td></tr>

  <tr>
    <td class="no" valign="top">10.</td>
    <td class="indent">Langkah-langkah sedia ada untuk mengekalkan kehilangan itu berlaku.</td>
  </tr>

  <tr><td height="6"></td><td></td></tr>

  <tr>
    <td class="no" valign="top">11.</td>
    <td class="indent">Langkah-langkah segera yang diambil bagi mencegah berulangnya kejadian ini.</td>
  </tr>

  <tr><td height="6"></td><td></td></tr>

  <tr>
    <td class="no" valign="top">12.</td>
    <td class="indent">Laporan hendaklah disertakan dengan dokumen sokongan dan gambar tempat kejadian.</td>
  </tr>

  <tr><td height="6"></td><td></td></tr>

  <tr>
    <td class="no" valign="top">13.</td>
    <td class="indent">Catatan.</td>
  </tr>
</table>

<br>

<!-- Signature block (bottom right) -->
<table width="100%" cellpadding="2" cellspacing="0" border="0">
    <tr>
        <td width="70%"></td>
        <td width="30%">
            <div>.....................................................</div>
            <div class="small">Tandatangan Ketua Jabatan</div>
        </td>
    </tr>
    <tr><td width="70%" style="vertical-align: top; text-align: right;">Nama</td><td width="5%">:</td></tr>
    <tr><td style="text-align: right;">Jawatan</td><td>:</td></tr>
    <tr><td style="text-align: right;">Tarikh</td><td>:</td></tr>
    <tr><td style="text-align: right;">Cap Jabatan</td><td>:</td></tr>
</table>
';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('kew_ps_32.pdf', 'I');
