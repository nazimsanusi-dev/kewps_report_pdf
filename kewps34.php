<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF
{
    public function Header()
    {
        // Top meta
        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 5, 'Pekeliling Perbendaharaan Malaysia', 0, 0, 'L');
        $this->Cell(0, 5, 'AM 6.10 Lampiran C', 0, 1, 'R');

        // Form code
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 6, 'KEW.PS-34', 0, 1, 'R');

        // Title
        $this->Ln(2);
        $this->SetFont('helvetica', 'B', 13);
        $this->Cell(0, 7, 'LAPORAN AKHIR KEHILANGAN STOK', 0, 1, 'C');
        $this->Ln(2);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(), 0, 0, 'C');
    }
}

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
  .alpha  { width:16px; }
  .roman  { width:20px; }
  .small  { font-size:9pt; }
  table   { border-collapse:collapse; }
</style>
';

$pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-34 - Laporan Akhir Kehilangan Stok');

$pdf->SetMargins(15, 28, 15);
$pdf->SetHeaderMargin(8);
$pdf->SetAutoPageBreak(true, 18);
$pdf->SetFont('helvetica', '', 11);
$pdf->AddPage();

/* ---------- content ---------- */
$html  = $css;
$html .= '<div><b>Nyatakan:-</b></div><br>';

$html .= '
<table width="195%" cellpadding="2" cellspacing="0" border="0">

  <!-- 1 -->
  <tr>
    <td class="no" valign="top">1.</td>
    <td class="indent">
      Keterangan Stok yang hilang.<br>
      <table width="195%" cellpadding="0" cellspacing="0" border="0">
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

  <!-- 2 -->
  <tr>
    <td class="no" valign="top">2.</td>
    <td class="indent">
      Perihal Kehilangan.<br>
      <table width="195%" cellpadding="0" cellspacing="0" border="0">
        <tr><td class="alpha" valign="top">(a)</td><td class="indent">Tarikh diketahui</td></tr>
        <tr><td class="alpha" valign="top">(b)</td><td class="indent">Tarikh sebenar berlaku</td></tr>
        <tr><td class="alpha" valign="top">(c)</td><td class="indent">Tempat kejadian</td></tr>
        <tr><td class="alpha" valign="top">(d)</td><td class="indent">Bagaimana kehilangan diketahui</td></tr>
        <tr><td class="alpha" valign="top">(e)</td><td class="indent">Bagaimana kehilangan berlaku</td></tr>
      </table>
    </td>
  </tr>

  <tr><td height="6"></td><td></td></tr>

  <!-- 3 -->
  <tr>
    <td class="no" valign="top">3.</td>
    <td class="indent">Sama ada Laporan Hasil Penyiasatan Polis telah diterima. Jika ada, sila sertakan.</td>
  </tr>

  <tr><td height="6"></td><td></td></tr>

  <!-- 4 -->
  <tr>
    <td class="no" valign="top">4.</td>
    <td class="indent">
      (a) Nama pegawai yang:-<br>
      <table width="195%" cellpadding="0" cellspacing="0" border="0">
        <tr><td class="roman" valign="top">(i)</td><td class="indent">Secara langsung menjaga stok tersebut.</td></tr>
        <tr><td class="roman" valign="top">(ii)</td><td class="indent">Bertanggungjawab sebagai penyelia.</td></tr>
        <tr><td class="roman" valign="top">(iii)</td><td class="indent">Bertanggungjawab ke atas kehilangan itu.</td></tr>
      </table>
      <br>
      (b) Mengenai setiap pegawai di atas, nyatakan:-<br>
      <table width="195%" cellpadding="0" cellspacing="0" border="0">
        <tr><td class="roman" valign="top">(i)</td><td class="indent">Jawatan hakiki pada masa kehilangan.</td></tr>
        <tr><td class="roman" valign="top">(ii)</td><td class="indent">Tugasnya (sertakan senarai tugas).</td></tr>
        <tr><td class="roman" valign="top">(iii)</td><td class="indent">Taraf Jawatan (sama ada tetap/ dalam percubaan/ sementara/ kontrak).</td></tr>
        <tr><td class="roman" valign="top">(iv)</td><td class="indent">Sama ada ditahan kerja atau digantung kerja. Jika ada nyatakan tarikh kuat kuasa hukuman.</td></tr>
        <tr><td class="roman" valign="top">(v)</td><td class="indent">Tarikh bersara atau penamatan perkhidmatan.</td></tr>
        <tr><td class="roman" valign="top">(vi)</td><td class="indent">Sama ada pernah melakukan apa-apa kesalahan dan hukumannya. (Jika ada, berikan butir-butir ringkas dan rujukannya)</td></tr>
        <tr><td class="roman" valign="top">(vii)</td><td class="indent">Maklumat lain, jika ada.</td></tr>
      </table>
    </td>
  </tr>

  <tr><td height="6"></td><td></td></tr>

  <!-- 5 -->
  <tr>
    <td class="no" valign="top">5.</td>
    <td class="indent">Nyatakan adakah Tatacara Pengurusan Stor atau Arahan Keselamatan Kerajaan atau arahan lain termasuk langkah berjaga-jaga yang telah ditetapkan dipatuhi. Jika ada tidak dipatuhi, nyatakan arahan tersebut.
    </td>
  </tr>

  <tr><td height="6"></td><td></td></tr>

  <!-- 6 -->
  <tr>
    <td class="no" valign="top">6.</td>
    <td class="indent">Apakah langkah-langkah yang telah diambil untuk mencegah berulangnya kejadian ini.</td>
  </tr>

  <tr><td height="6"></td><td></td></tr>

  <!-- 7 -->
  <tr>
    <td class="no" valign="top">7.</td>
    <td class="indent">
      Rumusan Siasatan.
      <div style="height:70px;border-bottom:0.5px solid #000;"></div>
    </td>
  </tr>

  <tr><td height="6"></td><td></td></tr>

  <!-- 8 -->
  <tr>
    <td class="no" valign="top">8.</td>
    <td class="indent">Nyatakan sama ada tindakan surcaj patut dikenakan atau tidak dengan memberikan justifikasi.<br>
      <table width="195%" cellpadding="2" cellspacing="0" border="0" style="margin-top:4px;">
        <tr>
          <td width="5%" class="alpha" valign="top">(a)</td>
          <td class="indent">
            Syor Surcaj/ Tatatertib: '.Dot(260).'_________________________<br>
            Justifikasi: '.Dot(360).'___________________________________<br>
            Nama dan Jawatan Pegawai: '.Dot(320).'____________________
          </td>
        </tr>
        <tr><td colspan="2" align="center"><span>atau</span></td></tr>
        <tr>
          <td width="5%" class="alpha" valign="top">(b)</td>
          <td class="indent">
            Syor Tanpa Surcaj: '.Dot(300).'____________________________<br>
            Justifikasi: '.Dot(360).'___________________________________<br>
            Nama dan Jawatan Pegawai: '.Dot(320).'____________________
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <tr><td height="10"></td><td></td></tr>

  <!-- signatures: Pengerusi & Ahli -->
  <tr>
    <td></td>
    <td>
      <table width="115%" cellpadding="3" cellspacing="0" border="0">
        <tr>
          <td width="22%">Tandatangan</td><td width="3%">:</td>
          <td style="border-bottom:0.5px solid #000;">&nbsp;(Pengerusi)</td>
        </tr>
        <tr>
          <td>Nama</td><td>:</td><td style="border-bottom:0.5px solid #000;">&nbsp;</td>
        </tr>
        <tr>
          <td>Jawatan</td><td>:</td><td style="border-bottom:0.5px solid #000;">&nbsp;</td>
        </tr>
        <tr>
          <td>Tarikh</td><td>:</td><td style="border-bottom:0.5px solid #000;">&nbsp;</td>
        </tr>
        <tr><td></td></tr>
        <tr><td width="22%">Tandatangan</td><td width="3%">:</td><td style="border-bottom:0.5px solid #000;">&nbsp;(Ahli)</td></tr>
        <tr><td>Nama</td><td>:</td><td style="border-bottom:0.5px solid #000;">&nbsp;</td></tr>
        <tr><td>Jawatan</td><td>:</td><td style="border-bottom:0.5px solid #000;"></td></tr>
        <tr><td>Tarikh</td><td>:</td><td style="border-bottom:0.5px solid #000;">&nbsp;</td></tr>
      </table>
    </td>
  </tr>

</table>

<br><br>

<!-- 9. Ulasan & Syor Pegawai Pengawal -->
<div><b>9. Ulasan dan Syor Pegawai Pengawal</b></div>
<br>
<table width="115%" cellpadding="3" cellspacing="0" border="0">
  <tr>
    <td width="11.5%">Ulasan</td><td >: _________________________________________</td>
  </tr>
  <tr><td colspan="3" style="height:6px;"></td></tr>
  <tr>
    <td width="11.5%">Syor</td><td>: _________________________________________</td>
  </tr>
</table>

<br><br>

<table width="115%" cellpadding="3" cellspacing="0" border="0">
  <tr>
    <td width="26%">Tandatangan</td><td width="3%">:</td>
    <td style="border-bottom:0.5px solid #000;">&nbsp;</td>
  </tr>
  <tr>
    <td>Nama</td><td>:</td>
    <td style="border-bottom:0.5px solid #000;">&nbsp;</td>
  </tr>
  <tr>
    <td>Jawatan</td><td>:</td>
    <td style="border-bottom:0.5px solid #000;">&nbsp;</td>
  </tr>
  <tr>
    <td>Tarikh</td><td>:</td>
    <td style="border-bottom:0.5px solid #000;">&nbsp;</td>
  </tr>
  <tr>
    <td>Nama Kementerian / Jabatan</td><td>:</td>
    <td style="border-bottom:0.5px solid #000;">&nbsp;</td>
  </tr>
</table>
';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('kew_ps_34.pdf', 'I');
