<?php
require_once __DIR__ . '/tcpdf/tcpdf.php';

class MYPDF extends TCPDF
{
    public function Header()
    {
        // Top meta
        $this->SetFont('helvetica', '', 9);
        $this->Cell(0, 5, 'Pekeliling Perbendaharaan Malaysia', 0, 0, 'L');
        $this->Cell(0, 5, 'AM 6.3 Lampiran A', 0, 1, 'R');

        // Right code + No. Kad
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 6, 'KEW.PS-3', 0, 1, 'R');
        $this->SetFont('helvetica', '', 10);
        $this->Cell(0, 5, 'No.Kad: .................................', 0, 1, 'R');

        // Title
        $this->Ln(4);
        $this->SetFont('helvetica', 'B', 13);
        $this->Cell(0, 6, 'DAFTAR STOK', 0, 1, 'C');

        $this->Ln(3);
    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().' / '.$this->getAliasNbPages(), 0, 0, 'C');
    }
}

$pdf = new MYPDF('P', PDF_UNIT, 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NAZIMSAN');
$pdf->SetTitle('KEW.PS-3 - Daftar Stok');

$pdf->SetMargins(6, 35, 6); // leave room for header
$pdf->SetHeaderMargin(8);
$pdf->SetAutoPageBreak(true, 18);
$pdf->SetFont('helvetica', '', 8);
$pdf->AddPage();

$style = '
<style>
  .small{font-size:11pt;}
  .th{background-color:#d9d9d9; font-weight:bold; text-align:center;}
  .tl{background:#d9d9d9; font-weight:bold; text-align:center;}
  .thin-border td, .thin-border th { border:0.5px solid #000; }
  .sp{ height:10px; }
</style>
';

/* ---------- IDENT AREA ---------- */
$ident = '
<table border="0" width="100%" cellpadding="2" cellspacing="0">
  <tr>
    <td width="12%"><b>Nama Stor</b></td><td width="2%">:</td><td width="86%"><span style="border-bottom:0.5px solid #000; display:inline-block; width:96%;">&nbsp;</span></td>
  </tr>
  <tr>
    <td><b>Perihal Stok</b></td><td>:</td><td><span style="border-bottom:0.5px solid #000; display:inline-block; width:96%;">&nbsp;</span></td>
  </tr>
</table>
';

/* ---------- BAHAGIAN A ---------- */
$bahagianA = '
<div class="tl" style="text-align:center; padding:3px;">BAHAGIAN A</div><br>
<table class="thin-border" width="100%" cellpadding="5" cellspacing="0" style="border-collapse:collapse; margin-top:6px;">
  <tr>
    <th class="th" width="20%">No. Kod</th>
    <td width="40%"></td>
    <th class="th" width="20%">Kumpulan</th>
    <td width="20%"></td>
  </tr>
  <tr>
    <th class="th">Unit Pengukuran</th>
    <td></td>
    <th class="th">Pergerakan</th>
    <td></td>
  </tr>
  <tr>
    <th class="th" rowspan="2">Lokasi Penyimpanan Stok</th>
    <th class="th" width="10%">Gudang/<br>Seksyen</th>
    <th class="th" width="10%">Baris</th>
    <th class="th" width="10%">Rak</th>
    <th class="th" width="10%">Tingkat</th>
    <th class="th" width="20%">Petak</th>
    <th class="th" width="20%">Kod Lokasi Penuh</th>
  </tr>
  <tr>
    <td height="24"></td><td></td><td></td><td></td><td></td><td></td>
  </tr>
</table>
<div class="sp"></div>
';

/* ---------- PARAS STOK ---------- */
$paras = '
<table class="thin-border" width="100%" cellpadding="6" cellspacing="0" style="border-collapse:collapse; margin-top:6px;">
  <tr>
    <th class="th" colspan="2" style="font-weight:bold;">PARAS STOK</th>
  </tr>
  <tr>
    <th class="tl" width="10%">TAHUN</th>
    <th class="tl" width="30%">MAKSIMUM<br>(Kuantiti)</th>
    <th class="tl" width="30%">MENOKOK<br>(Kuantiti)</th>
    <th class="tl" width="30%">MINIMUM<br>(Kuantiti)</th>
  </tr>
  <tr>
    <td height="24"></td><td></td><td></td><td></td>
  </tr>
</table>
<div class="sp"></div>
';

/* ---------- TERIMAAN STOK SUKU TAHUN ---------- */
$terimaanSuku = '

<table class="thin-border" width="100%" cellpadding="5" cellspacing="0" style="border-collapse:collapse; margin-top:6px;">
  <tr>
    <th class="th" colspan="2" style="font-weight:bold;">TERIMAAN STOK SUKU TAHUN</th>
  </tr>
  <tr>
    <th class="tl" width="10%" rowspan="2">TAHUN</th>
    <th class="tl" width="22%" colspan="2">PERTAMA</th>
    <th class="tl" width="22%" colspan="2">KEDUA</th>
    <th class="tl" width="22%" colspan="2">KETIGA</th>
    <th class="tl" width="24%" colspan="2">KEEMPAT</th>
  </tr>
  <tr>
    <th class="tl">Kuantiti</th><th class="tl">Nilai (RM)</th>
    <th class="tl">Kuantiti</th><th class="tl">Nilai (RM)</th>
    <th class="tl">Kuantiti</th><th class="tl">Nilai (RM)</th>
    <th class="tl">Kuantiti</th><th class="tl">Nilai (RM)</th>
  </tr>
  <tr>
    <td height="24"></td>
    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>
  </tr>
</table>
';

/* ---------- KELUARAN STOK SUKU TAHUN ---------- */
$keluaranSuku = '
<table class="thin-border" width="100%" cellpadding="5" cellspacing="0" style="border-collapse:collapse; margin-top:6px;">
  <tr>
    <th class="th" colspan="2" style="font-weight:bold;">KELUARAN STOK SUKU TAHUN</th>
  </tr>
  <tr>
    <th class="tl" width="10%" rowspan="2">TAHUN</th>
    <th class="tl" width="22%" colspan="2">PERTAMA</th>
    <th class="tl" width="22%" colspan="2">KEDUA</th>
    <th class="tl" width="22%" colspan="2">KETIGA</th>
    <th class="tl" width="24%" colspan="2">KEEMPAT</th>
  </tr>
  <tr>
    <th class="tl">Kuantiti</th><th class="tl">Nilai (RM)</th>
    <th class="tl">Kuantiti</th><th class="tl">Nilai (RM)</th>
    <th class="tl">Kuantiti</th><th class="tl">Nilai (RM)</th>
    <th class="tl">Kuantiti</th><th class="tl">Nilai (RM)</th>
  </tr>
  <tr>
    <td height="24"></td>
    <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td> <-- NI SAMPLE DATA KOSONG --!>
  </tr>
</table>
';

/* ---------- TERIMAAN & KELUARAN TAHUNAN ---------- */
$tahunan = '
<table class="thin-border" width="100%" cellpadding="6" cellspacing="0" style="border-collapse:collapse; margin-top:6px;">
  <tr>
    <!-- Row 1 -->
    <th class="th" width="10%"></th>
    <th class="th" width="44%" colspan="2">TERIMAAN STOK TAHUNAN</th>
    <th class="th" width="46%" colspan="2">KELUARAN STOK TAHUNAN</th>
  </tr>
  <tr>
    <!-- Row 2 -->
    <th class="tl" width="10%">TAHUN</th>
    <th class="tl" width="22%">Kuantiti</th>
    <th class="tl" width="22%">Nilai (RM)</th>
    <th class="tl" width="22%">Kuantiti</th>
    <th class="tl" width="24%">Nilai (RM)</th>
  </tr>
  <!-- Row 3: data (fill later) -->
  <tr>
    <td></td><td></td><td></td><td></td><td></td>
  </tr>
</table>
';

$bahagianB = '
<div style="text-align:center; font-weight:bold; margin-bottom:4px;">BAHAGIAN B</div>
<div style="font-weight:bold; margin-bottom:4px;">Transaksi Stok<br></div>

<table class="thin-border" width="100%" cellpadding="5" cellspacing="0" style="border-collapse:collapse;">
  <tr>
    <!-- 1st row: must sum to 100% -->
    <th class="th" width="8%"  rowspan="2">Tarikh</th>
    <th class="th" width="12%" rowspan="2">No. PK/ BTB/ BPSS/ BPSP/ BPIN</th>
    <th class="th" width="12%" rowspan="2">Terima Daripada/ Keluar Kepada</th>
    <th class="th" width="24%" colspan="3">TERIMAAN</th>
    <th class="th" width="20%" colspan="2">KELUARAN</th>
    <th class="th" width="16%" colspan="2">BAKI</th>
    <th class="th" width="8%"  rowspan="2">Nama Pegawai</th>
    <!-- 8+12+12+24+20+16+8 = 100 -->
  </tr>
  <tr>
    <th class="th" width="8%">Kuantiti</th>
    <th class="th" width="8%">Seunit (RM)</th>
    <th class="th" width="8%">Jumlah (RM)</th>

    <th class="th" width="10%">Kuantiti</th>
    <th class="th" width="10%">Jumlah (RM)</th>

    <th class="th" width="8%">Kuantiti</th>
    <th class="th" width="8%">Jumlah (RM)</th>
  </tr>
  <tr>
    <td colspan="11" style="padding:6px;">Baki dibawa ke hadapan…………………………</td>
  </tr>
';

// generate empty grid rows (e.g., 25 lines)
for ($i=0; $i<15; $i++) {
  $bahagianB .= '<tr>'.
    str_repeat('<td height="16"></td>', 11) .
  '</tr>';
}

$bahagianB .= '
</table>
<div style="font-size:9pt; margin-top:8px;">
  <br><b>Nota:</b><br>
  PK = Pesanan Kerajaan &nbsp;&nbsp;<br>
  BTB = Borang Terimaan Barang-barang &nbsp;&nbsp;<br>
  BPSS = Borang Permohonan Stok (KEW.PS-7) &nbsp;&nbsp;<br>
  BPSP = Borang Permohonan Stok (KEW.PS-8) &nbsp;&nbsp;<br>
  BPIN = Borang Pindahan Stok (KEW.PS-11)
</div>';


//If you only want to start a new page when there isn’t enough space left 
//for the Bahagian B header, check remaining height:

// $need = 180; // mm (rough guess for B header + a few rows)
// $remain = $pdf->getPageHeight() - $pdf->getBreakMargin() - $pdf->GetY();
// if ($remain < $need) {
//     $pdf->AddPage();
// }
// $pdf->writeHTML($bahagianB, true, false, true, false, '');

// 1) Let Bahagian A render (tables, rows, etc.)
$pdf->writeHTML($style.$ident.$bahagianA.$paras.$terimaanSuku.$keluaranSuku.$tahunan, true, false, true, false, '');

// 2) Always begin Bahagian B on a new page
$pdf->AddPage();  // <- even if A spilled over multiple pages

// 3) Render Bahagian B
$pdf->writeHTML($style.$bahagianB, true, false, true, false, '');
$pdf->Output('kew_ps_3_daftar_stok.pdf', 'I');
