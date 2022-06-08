<?php

namespace App\Controllers\Presensi\Backoffice;

use App\Controllers\BaseController;
use App\Database\DbHelper;
use App\Models\M_unitkerja;
use App\Models\M_pegawai;
use App\Models\M_presensi;

use DateTime;

class Presensipegawai extends BaseController
{
    protected $dbPresensiPegawai;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();

        $this->dbPresensiPegawai = new M_presensi();
        $this->dbPegawai = new M_pegawai();
    }

    public function index()
    {
        $selDtAkses = $this->dtAksesMitra;
        $selComboDtAkses = $this->request->getVar("dtakses");

        $dtUnitkerja = $this->dbHelper->getUnitkerja($selDtAkses);

        if (is_null($selComboDtAkses)) {
            $selComboDtAkses = $dtUnitkerja[0]['id'];
        }

        $selPeriode = $this->request->getVar('periode');
        $aksi = $this->request->getVar('cmdaksi');

        $selPeriode = (is_null($selPeriode)) ? date("Y-m-1") : $selPeriode;
        $aksi = (is_null($aksi)) ? 'rekapitulasi' : $aksi;

        $startDate = new DateTime('first day of this month');
        $nowDate = new DateTime('NOW');

        //Get jml hari kerja tanpa sabtu dan minggu
        $jmlHariKerja = (int) getWeekdayDifference($startDate, $nowDate);

        $selDbUnitkerja = new M_unitkerja();
        $selDtUnitkerja = $selDbUnitkerja->getUnitkerja($selComboDtAkses);

        if ($aksi == 'detail') {
            $dtPresensi = $this->dbHelper->getPresensiPegawaiByUnitkerja($selPeriode, $selDtUnitkerja);
            $this->dtContent['page'] = "presensi";
        } else if ($aksi == "rekapitulasi") {
            $dtPresensi = $this->dbHelper->getRekapPresensiPegawaiByUnitkerja($selPeriode, $selDtUnitkerja);
            $this->dtContent['page'] = "presensi_rekap";
        }

        if ($aksi == "cetak_presensi") {
        } else if ($aksi == "export_presensi_to_xls") {
            $dtPresensi = $this->dbHelper->getPresensiPegawaiByUnitkerja($selPeriode, $selDtUnitkerja);
            $dtRekapPresensi = $this->dbHelper->getRekapPresensiPegawaiByUnitkerja($selPeriode, $selDtUnitkerja);
            $this->export_presensi_to_xls($selPeriode, $dtPresensi, $dtRekapPresensi, $jmlHariKerja);
            exit();
        }

        $jmlPegawai = $this->dbHelper->getJmlPegawaiByUnitkerja($selDtUnitkerja);

        $jmlHadir = $this->dbHelper->countKehadiranPegawaiByUnitkerja(1, $selPeriode, $selDtUnitkerja);
        $jmlSakit = $this->dbHelper->countKehadiranPegawaiByUnitkerja(2, $selPeriode, $selDtUnitkerja);
        $jmlCuti  = $this->dbHelper->countKehadiranPegawaiByUnitkerja(3, $selPeriode, $selDtUnitkerja);
        $jmlIzinDgnKeterangan = $this->dbHelper->countKehadiranPegawaiByUnitkerja(4, $selPeriode, $selDtUnitkerja);

        $ttlHariKerjaSemuaPegawai = $jmlPegawai * $jmlHariKerja;

        if ($jmlHadir == 0) {
            $persentaseKehadiran = 0;
            $jmlTidakHadir = 0;
            $jmlTanpaKeterangan = 0;
            $persentaseTidakHadir = 0;
        } else {
            $jmlTidakHadir = ($jmlSakit + $jmlCuti + $jmlIzinDgnKeterangan);
            $persentaseKehadiran = number_format(($jmlHadir / $ttlHariKerjaSemuaPegawai) * 100);
            $persentaseTidakHadir = number_format(($jmlTidakHadir / $ttlHariKerjaSemuaPegawai) * 100);
            $jmlTanpaKeterangan = number_format((($ttlHariKerjaSemuaPegawai - ($jmlHadir + $jmlTidakHadir)) / $ttlHariKerjaSemuaPegawai) * 100);
        }

        //Rekap Presensi
        $dtRekapPresensi['persentaseKehadiran'] = $persentaseKehadiran;
        $dtRekapPresensi['jmlTidakHadir'] = $persentaseTidakHadir;
        $dtRekapPresensi['jmlTanpaKeterangan'] = $jmlTanpaKeterangan;

        $dtRekapPresensi['jmlHadirSaatIni'] = $this->dbHelper->countBertugasSaatIni($selDtAkses);

        //Content Data
        $this->dtContent['selDtAkses'] = $selComboDtAkses;
        $this->dtContent['selPeriode'] = $selPeriode;

        $this->dtContent['title'] = "PRESENSI PEGAWAI";

        $this->dtContent['dtUnitkerja'] = $dtUnitkerja;

        $this->dtContent['dtRekapPresensi'] = $dtRekapPresensi;
        $this->dtContent['dtPresensi'] = $dtPresensi;
        $this->dtContent['jmlHariKerja'] = $jmlHariKerja;

        $appJSFoot = loadJS("presensi/presensi_data.js", "appjs");
        $this->dtContent['appJSFoot'] = $appJSFoot;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    //--------------------------------------------------------------------
    public function approval($id)
    {
        if ($this->hasLogin) {

            $pathCSS = "\t" . '<link rel="stylesheet" href="' . base_url() . '/app';
            $pathJS = "\t" . '<script src="' . base_url() . '/app';

            $appCSS = $pathCSS . '/plugins/webcam-easy/css/webcam-app.css">' . PHP_EOL;
            $appCSS = $appCSS . $pathCSS . '/css/presensi.css">';

            $appJSFoot =  $pathJS . '/plugins/webcam-easy/js/webcam-easy.min.js"></script>' . PHP_EOL;
            $appJSFoot = $appJSFoot . $pathJS . '/plugins/webcam-easy/js/html2canvas.min.js"></script>' . PHP_EOL;
            $appJSFoot = $appJSFoot . $pathJS . '/js/webcam-easy.app.js"></script>' . PHP_EOL;
            $appJSFoot = $appJSFoot . $pathJS . '/plugins/signature-pad/jquery.signaturepad.js"></script>' . PHP_EOL;
            $appJSFoot = $appJSFoot . $pathJS . '/js/presensi.js"></script>';

            $dtPresensi = $this->dbPresensiPegawai->getPresensi($id);

            $pegawaiId = $dtPresensi['pekerja_id'];
            $dtPegawai = $this->dbPegawai->getPegawaiDetail($pegawaiId);

            $approvalBy = $this->dtUser['uid'];

            $this->dtContent['appCSS'] = $appCSS;
            $this->dtContent['appJSFoot'] = $appJSFoot;
            $this->dtContent['page'] = "presensi_approval";
            $this->dtContent['title'] = "Approval Presensi";
            $this->dtContent['dtPegawai'] = $dtPegawai;
            $this->dtContent['dtPresensi'] = $dtPresensi;
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function detail()
    {
        $actionkey = "detail";
        $keyData = $this->request->getVar("key_data");
        $exKeyData = explode("|", $keyData);

        $id = $exKeyData[0];
        $unitkerja_id = $exKeyData[1];
        $periode = $exKeyData[2];

        $appCSS = loadCSS("presensi.css", "appcss");

        $appJSFoot = loadJS("presensi/presensi_detail.js", "appjs");

        $dtPresensi = $this->dbPresensiPegawai->getPresensi($id);

        $pegawaiId = $dtPresensi['pekerja_id'];
        $dtPegawai = $this->dbPegawai->getPegawaiDetail($pegawaiId);

        $this->dtContent['title'] = "Kehadiran Pegawai";
        $this->dtContent['page'] = "presensi_detail";
        $this->dtContent['appCSS'] = $appCSS;
        $this->dtContent['appJSFoot'] = $appJSFoot;
        $this->dtContent['dtPegawai'] = $dtPegawai;
        $this->dtContent['dtPresensi'] = $dtPresensi;

        //for back button
        $this->dtContent['actionkey'] = $actionkey;
        $this->dtContent['unitkerja_id'] = $unitkerja_id;
        $this->dtContent['periode'] = $periode;


        /* folder all upload image/foto for unitkerja*/
        $blnThn = ambil_angka_bulan_tahun($dtPresensi["tanggal_1"]);
        $pathUploadImg = base_url("/uploads/AMKP/$blnThn/");

        $this->dtContent['pathUploadImg'] = $pathUploadImg;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function export_presensi_to_xls($periode, $dtPresensi, $dtRekapPresensi, $jmlHariKerja)
    {
        $periodeBln = strtoupper(ambil_bulan_tahun($periode));

        $inputFileName = 'templates/presensi/presensi.xlsx';
        $outputFileName = 'LAPORAN PRESENSI BULAN ' . $periodeBln . '.xls';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);

        //ISI SHEET REKAPITULASI        
        $worksheet = $spreadsheet->setActiveSheetIndexByName('rekapitulasi');
        $jmldata = count($dtRekapPresensi);

        $worksheet->getCell('A1')->setValue("REKAPITULASI PRESENSI BULAN : " . $periodeBln);

        $no = 1;
        $nrow = 3;
        foreach ($dtRekapPresensi as $rowData) {
            $jmlPresensi = ($rowData['jml_kehadiran'] + $rowData['jml_sakit'] + $rowData['jml_cuti'] + $rowData['jml_ijin']);
            $jmlTnpKet = 0;
            if ($jmlTnpKet <= $jmlPresensi) {
                $jmlTnpKet = $jmlHariKerja - $jmlPresensi;
            }

            $worksheet->getCell('A' . $nrow)->setValue($no);
            $worksheet->getCell('B' . $nrow)->setValue($rowData['nip']);
            $worksheet->getCell('C' . $nrow)->setValue($rowData['petugas']);
            $worksheet->getCell('D' . $nrow)->setValue($rowData['unitkerja']);
            $worksheet->getCell('E' . $nrow)->setValue($rowData['penempatan']);
            $worksheet->getCell('F' . $nrow)->setValue($rowData['jml_kehadiran']);
            $worksheet->getCell('G' . $nrow)->setValue($rowData['jml_sakit']);
            $worksheet->getCell('H' . $nrow)->setValue($rowData['jml_cuti']);
            $worksheet->getCell('I' . $nrow)->setValue($rowData['jml_ijin']);
            $worksheet->getCell('J' . $nrow)->setValue($jmlTnpKet);
            $no++;
            $nrow++;
            if ($no <= $jmldata) {
                $worksheet->insertNewRowBefore($nrow, 1);
            }
        }

        //ISI SHEET DETAIL  
        $worksheet = $spreadsheet->setActiveSheetIndexByName('daftar');
        $jmldata = count($dtPresensi);
        //dd($dtPresensi);

        $worksheet->getCell('A1')->setValue("DAFTAR PRESENSI BULAN : " . $periodeBln);

        $no = 1;
        $nrow = 3;
        foreach ($dtPresensi as $rowData) {
            $worksheet->getCell('A' . $nrow)->setValue($no);
            $worksheet->getCell('B' . $nrow)->setValue($rowData['nip']);
            $worksheet->getCell('C' . $nrow)->setValue($rowData['petugas']);
            $worksheet->getCell('D' . $nrow)->setValue($rowData['unitkerja']);
            $worksheet->getCell('E' . $nrow)->setValue($rowData['penempatan']);
            $worksheet->getCell('F' . $nrow)->setValue($rowData['presensi']);
            $worksheet->getCell('G' . $nrow)->setValue($rowData['tanggal_1']);
            $worksheet->getCell('H' . $nrow)->setValue($rowData['tanggal_2']);
            $worksheet->getCell('I' . $nrow)->setValue($rowData['foto_1']);
            $worksheet->getCell('J' . $nrow)->setValue($rowData['foto_2']);
            $worksheet->getCell('K' . $nrow)->setValue($rowData['keterangan_1']);
            $worksheet->getCell('L' . $nrow)->setValue($rowData['keterangan_2']);
            $worksheet->getCell('M' . $nrow)->setValue($rowData['status']);

            $no++;
            $nrow++;
            if ($no <= $jmldata) {
                $worksheet->insertNewRowBefore($nrow, 1);
            }
        }

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //header('Content-Disposition: attachment; filename="' . urlencode($outputFileName) . '"');
        header('Content-Disposition: attachment; filename="' . $outputFileName . '"');
        $writer->save('php://output');
        exit();
        //$writer->save($outputFileName);
    }
}
