<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF
{
    public function Header()
    {
        // Top meta
        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 5, 'Pekeliling Perbendaharaan Malaysia', 0, 0, 'L');
        $this->Cell(0, 5, 'AM 6.2 Lampiran B', 0, 1, 'R');

        // Form code + No. Rujukan
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 6, 'KEW.PS-2', 0, 1, 'R');

        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 6, '', 0, 1, 'R');

        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 5, 'No. Rujukan BPB: …………………………………………', 0, 1, 'R');

        // Title
        $this->Ln(3);
        $this->SetFont('helvetica', 'B', 13);
        $this->Cell(0, 7, 'BORANG  PENOLAKAN  BARANG-BARANG (BPB)', 0, 1, 'C');
        $this->Ln(3);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(), 0, 0, 'C');
    }
}

// ---------- OPTIONAL DATA STRUCTURES ----------
$hdr = [
  'pembekal'   => '',  // nama & alamat pembekal/agen
  'pk_rujukan' => '',  // No. PK/Kontrak
  'pk_tarikh'  => '',
  'do_nombor'  => '',  // No. DO
  'do_tarikh'  => '',
  'angkutan'   => '',  // Butir-butir Pengangkutan
  'ruj_btb'    => '',  // No. Ruj. Penerimaan (BTB)
];

$items = [
  // ['kod','perihal','dipesan','do','diterima','ditolak','beza','sebab','seunit','jumlah']
  ['', '', '', '', '', '', '', '', '', ''],
  ['', '', '', '', '', '', '', '', '', ''],
  ['', '', '', '', '', '', '', '', '', ''],
];

// ---------- STYLES ----------
$style = '
<style>
  .small{font-size:9pt;}
  .th{background-color:#d9d9d9; font-weight:bold; text-align:center;}
  .tdc{text-align:center;}
  .tdr{text-align:right;}
  .thin-border td, .thin-border th {border:0.5px solid #000;}
  .box{ border:0.5px solid #000; }
  .thleft{background:#d9d9d9; font-weight:bold; text-align:left;}
  .thin-border td, .thin-border th {border:0.5px solid #000;}
</style>
';

// ---------- TOP INFO TABLE ----------
$top = '
<table class="thin-border" cellpadding="5" cellspacing="0" width="100%" style="border-collapse:collapse;">
  <tr>
    <th class="th" width="23%">Nama dan Alamat Pembekal/<br>Agen Penghantaran</th>
    <th class="th" width="22%">No. Pesanan Kerajaan (PK)/<br>Kontrak dan Tarikh</th>
    <th class="th" width="17%">No. Nota Hantaran<br>(DO) dan Tarikh</th>
    <th class="th" width="20%">Butir-Butir Pengangkutan</th>
    <th class="th" width="18%">No. Ruj. Penerimaan<br>(No. Rujukan BTB)</th>
  </tr>
  <tr>
    <td height="34" valign="top">'.nl2br(htmlspecialchars($hdr["pembekal"])).'</td>
    <td valign="top">'.htmlspecialchars($hdr["pk_rujukan"]).'<br>'.htmlspecialchars($hdr["pk_tarikh"]).'</td>
    <td valign="top">'.htmlspecialchars($hdr["do_nombor"]).'<br>'.htmlspecialchars($hdr["do_tarikh"]).'</td>
    <td valign="top">'.nl2br(htmlspecialchars($hdr["angkutan"])).'</td>
    <td valign="top">'.htmlspecialchars($hdr["ruj_btb"]).'</td>
  </tr>
</table>
';

// ---------- ITEMS TABLE ----------
$head = '
<table class="thin-border" cellpadding="4" cellspacing="0" width="100%" style="border-collapse:collapse; margin-top:10px;">
  <tr>
    <th class="th" width="7%" rowspan="2">No. Kod</th>
    <th class="th" width="23%" rowspan="2">Perihal Barang</th>

    <th class="th" width="40%" colspan="5">Kuantiti</th>

    <th class="th" width="18%" rowspan="2">Sebab-Sebab Penolakan</th>

    <th class="th" width="12%" colspan="2">Harga (RM)</th>
  </tr>
  <tr>
    <th class="th" width="8%">Dipesan<br>(PK)</th>
    <th class="th" width="8%">Nota Hantaran<br>(DO)</th>
    <th class="th" width="8%">Diterima</th>
    <th class="th" width="8%">Ditolak</th>
    <th class="th" width="8%">Kurang/<br>Lebih (+/-)</th>

    <th class="th" width="6%">Seunit</th>
    <th class="th" width="6%">Jumlah</th>
  </tr>
';

$rows = '';
foreach ($items as $r) {
  list($kod,$perihal,$dipesan,$do,$diterima,$ditolak,$beza,$sebab,$seunit,$jumlah) = array_pad($r,10,'');
  $rows .= '
  <tr>
    <td class="tdc" height="18">'.htmlspecialchars($kod).'</td>
    <td>'.htmlspecialchars($perihal).'</td>
    <td class="tdc">'.htmlspecialchars($dipesan).'</td>
    <td class="tdc">'.htmlspecialchars($do).'</td>
    <td class="tdc">'.htmlspecialchars($diterima).'</td>
    <td class="tdc">'.htmlspecialchars($ditolak).'</td>
    <td class="tdc">'.htmlspecialchars($beza).'</td>
    <td>'.htmlspecialchars($sebab).'</td>
    <td class="tdr">'.htmlspecialchars($seunit).'</td>
    <td class="tdr">'.htmlspecialchars($jumlah).'</td>
  </tr>';
}
$itemsTbl = $head.$rows.'</table>';

// ---------- SIGNATURE / ACKNOWLEDGEMENT BLOCKS ----------
$sign = '
<table class="thin-border" width="100%" cellpadding="8" cellspacing="0" style="border-collapse:collapse; margin-top:12px;">
  <!-- Row 1: titles -->
  <tr>
    <th class="th" width="40%">Pegawai Penerima</th>
    <th class="th" width="60%" colspan="2">Akuan Terima Pembekal / Agen Penghantaran</th>
  </tr>

  <!-- Row 2: 50% | 25% | 25% -->
  <tr>
    <!-- 50% left block -->
    <td width="40%" valign="top">
      <div></div>
      <br>
      <table width="100%" cellspacing="0">
        <tr><td>.......................................................<br>(Tandatangan Pegawai Penerima)</td></tr>
        <tr><td width="28%">Nama:</td></tr>
        <tr><td>Jawatan:</td></tr>
        <tr><td>Tarikh:</td></tr>
        <tr><td>Cap Jabatan:</td></tr>
      </table>
    </td>

    <!-- FUTURE NOTE 12082025 NAZIM - CHECKBOX BIAR DULU SEBAB NYA NANTI NAK SYNC KAN DENGAN DATA , SO BOLEH JADI TARIK DARI DB RESULT NYA AND AUTO TICK -->

    <td width="30%" valign="top">
      <div class="small">Disahkan barang-barang ini diterima untuk tindakan atas sebab-sebab berikut:</div>
      <div class="small" style="margin-top:6px;">
        <table cellpadding="2" cellspacing="0" border="0">
            <tr>
            <td style="width:14px;">&#9744;</td>
            <td>Kuantiti Ditolak</td>
            </tr>
            <tr>
            <td>&#9744;</td>
            <td>Kuantiti Kurang</td>
            </tr>
            <tr>
            <td>&#9744;</td>
            <td>Kuantiti Lebih</td>
            </tr>
        </table>
      </div>
    </td>

    <!-- 25% right block -->
    <td width="30%" valign="top">
      <br>
      <br>
      <br>
      <table width="100%" cellpadding="1" cellspacing="0">
        <tr><td>.......................................................</td></tr>
        <tr><td width="32%">Nama:</td></tr>
        <tr><td>Tarikh:</td></tr>
        <tr><td>Cap Syarikat:</td></tr>
      </table>
    </td>
  </tr>
</table>
';

$spacing = '<div style="height:15px;"></div>'; // 15px space

// ---------- RENDER ----------
$pdf = new MYPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false); // Landscape
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-2 - Borang Penolakan Barang-Barang (BPB)');

$pdf->SetMargins(12, 45, 12);  // left, top, right
$pdf->SetHeaderMargin(8);
$pdf->SetAutoPageBreak(true, 16);
$pdf->SetFont('helvetica', '', 10);

$pdf->AddPage();
$pdf->writeHTML($style.$top.$spacing.$itemsTbl.$spacing.$sign, true, false, true, false, '');
$pdf->Output('kew_ps_2_bpb.pdf', 'I');
