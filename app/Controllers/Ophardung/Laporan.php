<?php

namespace App\Controllers\Ophardung;

use App\Controllers\BaseController;
use App\Database\DbHelper;
use App\Database\DbHelperOphardung;
use App\Models\M_mitrakerja;
use App\Models\M_tenagakerja;
use App\Models\M_unitkerja;
use App\Models\OPHARDUNG\M_inventori;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

class Laporan extends BaseController
{
    protected $dbHelper;
    protected $dbHelperOphardung;

    protected $dbInventori;

    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->dbHelperOphardung = new DbHelperOphardung();

        $this->dbInventori = new M_inventori();
    }

    public function kegiatan()
    {
        if ($this->hasLogin) {
            if ($this->otoritas != "TENAGAKERJA") {

                $selDtAkses = $this->dtAksesMitra;
                $selComboDtAkses = $this->request->getVar("dtakses");

                $dtMitraKerja = $this->dbHelper->getMitraKerja($selDtAkses);

                if (is_null($selComboDtAkses)) {
                    $selComboDtAkses = $dtMitraKerja[0]['id'];
                }

                $selPeriode = $this->request->getVar('periode');
                $aksi = $this->request->getVar('cmdaksi');

                $selPeriode = (is_null($selPeriode)) ? date("Y-m-1") : $selPeriode;
                $aksi = (is_null($aksi)) ? 'rekapitulasi' : $aksi;

                if ($aksi == "export_kegiatan_ophar_to_xls") {
                    $this->export_kegiatan_ophardung($selComboDtAkses, $selPeriode);
                    return;
                }

                $this->dtContent['page'] = "ophardung_kegiatan";
                $this->dtContent['title'] = "Kegiatan";

                $this->dtContent['dtMitraKerja'] = $dtMitraKerja;

                $this->dtContent['selDtAkses'] = $selComboDtAkses;
                $this->dtContent['selPeriode'] = $selPeriode;

                $appCSS = loadCSS("kegiatan.css", "appcss");
                $appJSFoot = loadJS("ophardung/laporan_ophardung.js", "appjs");

                $this->dtContent['appCSS'] = $appCSS;
                $this->dtContent['appJSFoot'] = $appJSFoot;
            }
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function laporankegiatanperpetugas()
    {
        $keyData = $this->request->getVar("key_data");

        if ($this->hasLogin) {
            if ($this->otoritas != "TENAGAKERJA") {
                $expKeyData = explode("|", $keyData);

                $petugas_id = $expKeyData[0];
                $tanggal = $expKeyData[1];
                $mitrakerja_id = $expKeyData[2];
                $periode = $expKeyData[3];

                $dtKegiatan = $this->dbHelperOphardung->getKegiatanPetugasPerTanggal($petugas_id, $tanggal);

                $blnThn = ambil_angka_bulan_tahun($periode);
                $folderMK = addZeroSpaces($mitrakerja_id, "mk", 5);
                $pathFotoKegiatan = "./uploads/$this->appName/$folderMK/$blnThn/kegiatan/";

                $this->dtContent['page'] = "laporan_ophardung_kegiatanperpetugas";
                $this->dtContent['title'] = "Kegiatan";

                $this->dtContent['dtKegiatan'] = $dtKegiatan;

                $appCSS = loadCSS("kegiatan.css", "appcss");
                $appJSFoot = loadJS("ophardung/laporan_ophardung_kegiatan.js", "appjs");

                $this->dtContent['appCSS'] = $appCSS;
                $this->dtContent['appJSFoot'] = $appJSFoot;

                $this->dtContent['mitrakerja_id'] = $mitrakerja_id;
                $this->dtContent['periode'] = $periode;

                $this->dtContent['pathFotoKegiatan'] = $pathFotoKegiatan;
            }
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function inventori()
    {
        if ($this->hasLogin) {
            if ($this->otoritas != "TENAGAKERJA") {

                $selDtAkses = $this->dtAksesMitra;
                $selComboDtAkses = $this->request->getVar("dtakses");

                $dtMitraKerja = $this->dbHelper->getMitraKerja($selDtAkses);

                if (is_null($selComboDtAkses)) {
                    $selComboDtAkses = $dtMitraKerja[0]['id'];
                }

                $selPeriode = $this->request->getVar('periode');
                $aksi = $this->request->getVar('cmdaksi');

                $selPeriode = (is_null($selPeriode)) ? date("Y-m-1") : $selPeriode;
                $aksi = (is_null($aksi)) ? 'rekapitulasi' : $aksi;
                //dd($selComboDtAkses);
                $dtRekapInventori = $this->dbHelperOphardung->getRekapInventoriByMitrakerja($selComboDtAkses);
                $dtInventori = $this->dbHelperOphardung->getInventoriByMitrakerja($selComboDtAkses);
                //dd($dtRekapInventori);
                //dd($dtInventori);

                $this->dtContent['page'] = "laporan_ophardung_inventori";
                $this->dtContent['title'] = "Inventori";

                $this->dtContent['dtMitraKerja'] = $dtMitraKerja;

                $this->dtContent['selDtAkses'] = $selComboDtAkses;
                $this->dtContent['selPeriode'] = $selPeriode;

                $this->dtContent['dtRekapInventori'] = $dtRekapInventori;
                $this->dtContent['dtInventori'] = $dtInventori;

                $appJSFoot = loadJS("ophardung/inventori.js", "appjs");

                $this->dtContent['appJSFoot'] = $appJSFoot;
            }
        }

        return view($this->appName . '/v_app', $this->dtContent);
    }

    public function export_kegiatan_ophardung($mitrakerja_id, $periode)
    {
        $periodeBln = strtoupper(ambil_bulan_tahun($periode));

        $dbMitrakerja = new M_mitrakerja();
        $dtMitrakerja = $dbMitrakerja->getMitraKerja($mitrakerja_id);

        /* GET REKAP KEGIATAN OPHARDUNG */
        $nm_mitrakerja = $dtMitrakerja['mitrakerja'];
        /* END GET REKAP KEGIATAN */

        // path photo kegiatan
        $blnThn = ambil_angka_bulan_tahun();
        $folderMK = addZeroSpaces($mitrakerja_id, "mk", 5);
        $pathFotoKegiatan = "./uploads/$this->appName/$folderMK/$blnThn/kegiatan/";

        //load template
        $inputFileName = 'templates/laporan/ophardung_kegiatan.xlsx';
        $outputFileName = $nm_mitrakerja . ' - LAPORAN OPHARDUNG - ' . $periodeBln . '.xls';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);

        /* Isi Tabel REKAP */
        $dtRekapKegiatan = $this->dbHelperOphardung->getRekapKegiatanMitrakerja($dtMitrakerja, $periode)->getResultArray();
        $jmlRekapKegiatan = count($dtRekapKegiatan);

        $worksheet = $spreadsheet->setActiveSheetIndexByName('REKAP');

        $worksheet->getCell('A2')->setValue("PENEMPATAN : " . $nm_mitrakerja);
        $worksheet->getCell('A3')->setValue("BULAN : " . $periodeBln);

        $nourut = 1;
        $nrow = 6;
        foreach ($dtRekapKegiatan as $rekap) {
            $worksheet->getCell('A' . $nrow)->setValue($nourut);
            dd($rekap);
            $worksheet->getCell('B' . $nrow)->setValue(strtoupper($rekap['petugas']));
            $worksheet->getCell('C' . $nrow)->setValue($rekap['tgl_kegiatan']);
            $worksheet->getCell('D' . $nrow)->setValue($rekap['jml_kegiatan']);

            $nrow++;
            $nourut++;
            if ($nourut <= $jmlRekapKegiatan) {
                $worksheet->insertNewRowBefore($nrow, 1);
            }
        }

        /* Isi Tabel Inventori */
        $worksheet = $spreadsheet->setActiveSheetIndexByName('INVENTORI');

        $worksheet->getCell('A2')->setValue("PENEMPATAN : " . $nm_mitrakerja);
        $worksheet->getCell('A3')->setValue("BULAN : " . $periodeBln);

        $dt_inventori = $this->dbHelperOphardung->getInventoriByMitrakerja($mitrakerja_id);
        $jml_inventori = count($dt_inventori);
        $nourut = 1;
        $nrow = 6;
        //dd($dt_inventori);
        foreach ($dt_inventori as $inventori) {

            $worksheet->getCell('A' . $nrow)->setValue($nourut);
            $worksheet->getCell('B' . $nrow)->setValue(strtoupper($inventori['produk']));
            $worksheet->getCell('C' . $nrow)->setValue($inventori['jumlah']);
            $worksheet->getCell('D' . $nrow)->setValue($inventori['kondisi']);
            $worksheet->getCell('E' . $nrow)->setValue($inventori['keterangan']);

            $nrow++;
            $nourut++;
            if ($nourut <= $jml_inventori) {
                $worksheet->insertNewRowBefore($nrow, 1);
            }
        }

        /* Isi Sheet Kegiatan */
        $worksheet = $spreadsheet->setActiveSheetIndexByName('TGL_');

        $tgl_kegiatan = $dtRekapKegiatan[0]["tgl_kegiatan"];
        $onlyTgl = substr($tgl_kegiatan, 8, 2);
        $f_nm_sheet = "TGL_" . $onlyTgl;

        //rename first sheet kegiatan
        $worksheet->setTitle($f_nm_sheet);

        //clone sheet kegiatan
        foreach ($dtRekapKegiatan as $rekap) {
            $clonedWorksheet = clone $spreadsheet->getSheetByName($f_nm_sheet);
            $tgl_kegiatan = $rekap["tgl_kegiatan"];
            $onlyTgl = substr($tgl_kegiatan, 8, 2);
            $nm_sheet = "TGL_" . $onlyTgl;
            if ($nm_sheet != $f_nm_sheet) {
                $clonedWorksheet->setTitle($nm_sheet);
                $spreadsheet->addSheet($clonedWorksheet);
            }
        }

        //isi sheet kegiatan
        foreach ($dtRekapKegiatan as $rekap) {
            $petugas_id = $rekap["petugas_id"];
            $tgl_kegiatan = $rekap["tgl_kegiatan"];

            $onlyTgl = substr($tgl_kegiatan, 8, 2);
            $nm_sheet = "TGL_" . $onlyTgl;

            $worksheet = $spreadsheet->setActiveSheetIndexByName($nm_sheet);

            $worksheet->getCell('A2')->setValue("PENEMPATAN : " . $nm_mitrakerja);
            $worksheet->getCell('A3')->setValue("BULAN : " . $periodeBln);

            $dt_kegiatan = $this->dbHelperOphardung->getKegiatanPetugasPerTanggal($petugas_id, $tgl_kegiatan);
            $jml_kegiatan = count($dt_kegiatan);

            //temp sheet for load foto kegiatan
            $sheet = $spreadsheet->getActiveSheet();

            $nourut = 1;
            $nrow = 6;
            foreach ($dt_kegiatan as $kegiatan) {
                $worksheet->getCell('A' . $nrow)->setValue($nourut);
                $worksheet->getCell('B' . $nrow)->setValue($kegiatan['petugas']);
                $worksheet->getCell('C' . $nrow)->setValue($kegiatan['jenis']);
                $worksheet->getCell('D' . $nrow)->setValue($kegiatan['tanggal']);
                $worksheet->getCell('E' . $nrow)->setValue($kegiatan['lokasi']);
                $worksheet->getCell('F' . $nrow)->setValue($kegiatan['kondisi']);

                //get foto kegiatan
                $foto_kegiatan = $pathFotoKegiatan . $kegiatan['foto'];
                //dd($foto_kegiatan);
                if (isset($foto_kegiatan) && !empty($foto_kegiatan)) {
                    if (file_exists($foto_kegiatan)) {
                        $imageType = "png";

                        if (strpos($foto_kegiatan, ".png") === false) {
                            $imageType = "jpg";
                        }

                        $drawing = new MemoryDrawing();

                        $sheet->getRowDimension($nrow)->setRowHeight(70);
                        //$sheet->mergeCells('A' . $nrow . ':H' . $nrow);

                        $gdImage = ($imageType == 'png') ? imagecreatefrompng($foto_kegiatan) : imagecreatefrompng($foto_kegiatan);
                        $drawing->setName('Foto Kegiatan');
                        $drawing->setDescription('Gambar foto kegiatan');
                        $drawing->setResizeProportional(false);
                        $drawing->setImageResource($gdImage);
                        $drawing->setRenderingFunction(\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::RENDERING_JPEG);
                        $drawing->setMimeType(\PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing::MIMETYPE_DEFAULT);
                        $drawing->setWidth(80);
                        $drawing->setHeight(80);
                        $drawing->setOffsetX(5);
                        $drawing->setOffsetY(5);
                        $drawing->setCoordinates('G' . $nrow);
                        $drawing->setWorksheet($spreadsheet->getActiveSheet());
                    } else {
                        $worksheet->getCell('G' . $nrow)->setValue("TIDAK DITEMUKAN");
                    }
                } else {
                    $worksheet->getCell('G' . $nrow)->setValue("NO FOTO");
                }

                $worksheet->getCell('H' . $nrow)->setValue($kegiatan['keterangan']);

                $nrow++;
                $nourut++;
                if ($nourut <= $jml_kegiatan) {
                    $worksheet->insertNewRowBefore($nrow, 1);
                }
            }
        }

        //rename first sheet kegiatan
        $worksheet = $spreadsheet->setActiveSheetIndexByName($f_nm_sheet);
        $worksheet->setTitle("KEGIATAN " . $f_nm_sheet);

        //set active sheet to first sheet
        $worksheet = $spreadsheet->setActiveSheetIndexByName('REKAP');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //header('Content-Disposition: attachment; filename="' . urlencode($outputFileName) . '"');
        header('Content-Disposition: attachment; filename="' . $outputFileName . '"');
        $writer->save('php://output');
        exit();
        // $data = ['status' => "succes", 'mitrakerja_id' => $mitrakerja_id, 'periode' => $periode];
        // echo json_encode($data);
        //$writer->save($outputFileName);
    }
}
