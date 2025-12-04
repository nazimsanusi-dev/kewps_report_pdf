<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';
// test
class MYPDF extends TCPDF
{
    public function Header()
    {
        // Top meta line (left / right)
        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 5, 'Pekeliling Perbendaharaan Malaysia', 0, 0, 'L');
        $this->Cell(0, 5, 'AM 6.2 Lampiran A', 0, 1, 'R');

        // Form code and No. Rujukan
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 6, 'KEW.PS-1', 0, 1, 'R');

        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 5, '', 0, 1, 'R');

        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 5, 'No. Rujukan BTB:  ………………………………………', 0, 1, 'R');

        // Title
        $this->Ln(4);
        $this->SetFont('helvetica', 'B', 13);
        $this->Cell(0, 7, 'BORANG TERIMAAN BARANG-BARANG (BTB)', 0, 1, 'C');

        $this->Ln(4);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(), 0, 0, 'C');
    }
}

// ---------- OPTIONAL DYNAMIC DATA (fill or leave blank) ----------
$header = [
  'pembekal'   => '',   // nama & alamat pembekal / agen penghantaran/pemberi
  'jenis'      => '',   // jenis penerimaan
  'pk_rujukan' => '',
  'pk_tarikh'  => '',
  'do_nombor'  => '',
  'do_tarikh'  => '',
  'pengangkutan'=> ''
];

// Example items (add as many as needed)
$items = [
  // ['kod','perihal','unit','dipesan','do','diterima','seunit','jumlah','catatan']
  ['', '', '', '', '', '', '', '', ''],
  ['', '', '', '', '', '', '', '', ''],
  ['', '', '', '', '', '', '', '', ''],
];

// ---------- BUILD HTML ----------
$style = '
<style>
  .small{font-size:9pt;}
  .th{background-color:#d9d9d9; font-weight:bold; text-align:center;}
  .tdc{text-align:center;}
  .tdr{text-align:right;}
  .tdd{border-bottom:0.5px solid #000;}
  table { border-collapse: collapse; }
  .thin-border td, .thin-border th {border:0.5px solid #000;}
</style>
';

$topTable = '
<table class="thin-border" cellpadding="5" cellspacing="0" width="100%">
  <tr>
    <td class="th" width="22%" rowspan="2">Nama dan Alamat<br>Pembekal/<br>Agen Penghantaran/<br>Pemberi</td>
    <td class="th" width="12%" rowspan="2">Jenis<br>Penerimaan*</td>
    <td class="th" width="28%" colspan="2">Pesanan Kerajaan (PK)/ Kontrak/ Surat Kelulusan</td>
    <td class="th" width="20%" colspan="2">Nota Hantaran (DO)</td>
    <td class="th" width="18%" rowspan="2">Maklumat Pengangkutan</td>
  </tr>
  <tr>
    <td class="th" width="14%">Nombor/ Rujukan</td>
    <td class="th" width="14%">Tarikh</td>
    <td class="th" width="10%">Nombor</td>
    <td class="th" width="10%">Tarikh</td>
  </tr>
  <tr>
    <td height="40" valign="top">'.nl2br(htmlspecialchars($header['pembekal'])).'</td>
    <td valign="top">'.$header['jenis'].'</td>
    <td valign="top">'.$header['pk_rujukan'].'</td>
    <td valign="top">'.$header['pk_tarikh'].'</td>
    <td valign="top">'.$header['do_nombor'].'</td>
    <td valign="top">'.$header['do_tarikh'].'</td>
    <td valign="top">'.nl2br(htmlspecialchars($header['pengangkutan'])).'</td>
  </tr>
</table>
';

$spacing = '<div style="height:15px;"></div>'; // 15px space

$itemsHead = '
<table class="thin-border" cellpadding="4" cellspacing="0" width="100%" style="border-width:0.5px; margin-top:10px;">
  <tr>
    <td class="th" width="8%"  rowspan="2">No. Kod</td>
    <td class="th" width="30%" rowspan="2">Perihal<br>Barang-Barang</td>
    <td class="th" width="9%"  rowspan="2">Unit<br>Pengukuran</td>
    <!-- 3 × 9% = 27% -->
    <td class="th" width="27%" colspan="3">Kuantiti</td>
    <!-- 2 × 9% = 18% -->
    <td class="th" width="18%" colspan="2">Harga (RM)</td>
    <td class="th" width="8%"  rowspan="2">Catatan</td>
  </tr>
  <tr>
    <td class="th" width="9%">Dipesan<br>(PK)</td>
    <td class="th" width="9%">Nota Hantaran<br>(DO)</td>
    <td class="th" width="9%">Diterima</td>
    <td class="th" width="9%">Seunit</td>
    <td class="th" width="9%">Jumlah</td>
  </tr>
';

$rows = '';
foreach ($items as $r) {
  list($kod,$perihal,$unit,$pk,$do,$diterima,$seunit,$jumlah,$catatan) = array_pad($r,9,'');
  $rows .= '
  <tr>
    <td height="18">'.htmlspecialchars($kod).'</td>
    <td>'.htmlspecialchars($perihal).'</td>
    <td class="tdc">'.htmlspecialchars($unit).'</td>
    <td class="tdc">'.htmlspecialchars($pk).'</td>
    <td class="tdc">'.htmlspecialchars($do).'</td>
    <td class="tdc">'.htmlspecialchars($diterima).'</td>
    <td class="tdr">'.htmlspecialchars($seunit).'</td>
    <td class="tdr">'.htmlspecialchars($jumlah).'</td>
    <td>'.htmlspecialchars($catatan).'</td>
  </tr>';
}
$itemsTable = $itemsHead.$rows.'</table>';

$sign = '
<table border="0" cellpadding="6" cellspacing="0" width="100%" style="margin-top:14px;">
  <tr>
    <td width="50%" valign="top" style="border:0.5px solid #000; padding:10px;">
      <div></div>
      <div>............................................</div>
      <div class="small">(Tandatangan Pegawai Penerima)</div>
      
      <table width="100%" cellpadding="2">
        <tr>
            <td width="22%"><b>Nama:</b></td>
        </tr>
        <tr>
            <td><b>Jawatan:</b></td>
        </tr>
        <tr>
            <td><b>Jabatan:</b></td>
            </tr>
        <tr>
            <td><b>Tarikh:</b></td>
        </tr>
      </table>
    </td>
    <td width="50%" valign="top" style="border:0.5px solid #000; padding:10px;">
      <div></div>
      <div>............................................</div>
      <div class="small">(Tandatangan Pegawai Teknikal)</div>
     
      <table width="100%" cellpadding="2">
        <tr>
            <td width="22%"><b>Nama:</b></td>
        </tr>
        <tr>
            <td><b>Jawatan:</b></td>
        </tr>
        <tr>
            <td><b>Jabatan:</b></td>
            </tr>
        <tr>
            <td><b>Tarikh:</b></td>
        </tr>
      </table>

    </td>
  </tr>
</table>
';

// ---------- RENDER ----------
$pdf = new MYPDF('L', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-1 - Borang Terimaan Barang-Barang (BTB)');

$pdf->SetMargins(15, 48, 15);   // leave space for header
$pdf->SetHeaderMargin(8);
$pdf->SetAutoPageBreak(true, 18);
$pdf->SetFont('helvetica', '', 10);

$pdf->AddPage();
$pdf->writeHTML($style.$topTable.$spacing.$itemsTable.$spacing.$sign, true, false, true, false, '');
$pdf->Output('kew_ps_1_btb.pdf', 'I');

