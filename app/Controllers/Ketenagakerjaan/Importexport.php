<?php

namespace App\Controllers\Ketenagakerjaan;

use App\Controllers\BaseController;

use App\Database\DbHelper;

use App\Models\M_tenagakerja;
use App\Models\M_tenagakerja_detail;
use App\Models\M_tenagakerja_temporary;

class Importexport extends BaseController
{
    protected $dbHelper;
    protected $dbTenagakerja;
    protected $dbTenagakerjaDetail;


    public function __construct()
    {
        $this->dbHelper = new DbHelper();

        $this->dbTenagakerja = new M_tenagakerja();
        $this->dbTenagakerjaDetail = new M_tenagakerja_detail();
    }

    public function import_tenagakerja()
    {
        //Cek otoritas user
        if ($this->oto_id != "99" && $this->oto_id != "1" && $this->oto_id != "2") {
            return redirect()->to("/");
        }

        $filter_temp = ["import_oleh " => $this->user_id];
        $dtTenagakerjaTemp = $this->dbHelper->getTenagakerjaTemporary($filter_temp);

        $appJS =  loadJS('bs-custom-file-input/bs-custom-file-input.min.js', 'adminlte_plugins');
        $appJS .=  loadJS('tenagakerja/data_tenagakerja.js', 'appjs');

        $this->dtContent['title'] = "Data Tenaga Kerja";
        $this->dtContent['page'] = "tenagakerja_detail_import";

        $this->dtContent['dtTenagakerjaTemp'] = $dtTenagakerjaTemp;
        $this->dtContent['appJSFoot'] = $appJS;

        return view($this->appName . '/v_app', $this->dtContent);
    }

    /**
     * IMPORT FOR DATA TENAGAKERJA
     */

    public function validasi_data_import_tk_xlsx()
    {
        $user_id = $this->user_id;

        //hapus data kontrak di tabel temporary jika sudah ada data dengan user dan tanggal import yang sama
        $filter_deleted = ["import_oleh" => $user_id];
        $this->dbHelper->deleteTenagakerjaTemporary($filter_deleted);

        $cek_file_import = "OK";

        $jml_data_baru = 0;
        $jml_data_updated = 0;

        $jml_data_gl = 0; //jumlah data tidak dapat diimport/Gagal Import

        $row_number = 0;

        //validasi file excel yang akan di import
        $validation = \Config\Services::validation();
        $file = $this->request->getFile('imp_file');
        $datafile = array('imp_file' => $file);

        $redirectPath = '/ketenagakerjaan_import_tenagakerja';

        if ($validation->run($datafile, 'import_excel') == FALSE) {
            session()->setFlashdata('errors', $validation->getErrors());
            return redirect()->to($redirectPath);
        } else {

            // ambil extension dari file excel
            $extension = $file->getClientExtension();

            // format excel 2007 ke bawah
            if ('xls' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                // format excel 2010 ke atas
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $reader->load($file);

            $data = $spreadsheet->getActiveSheet()->toArray();

            $dtTenagakerjaTemp = new M_tenagakerja_temporary();

            $batchData = array();
            foreach ($data as $idx => $row) {
                //Cek kolom terakhir file import
                //Jika panjang kolom tidak sesuai berarti salah file import
                if ($row_number == 0) {
                    $cek_cols = count($row);
                    if ($cek_cols != 64) {
                        $cek_file_import = "GAGAL IMPORT DATA TENAGA KERJA: Kolom file import tidak sesuai. Proses import dibatalkan.";
                        break;
                    }
                }

                // lewati baris ke 0 dan ke 1 pada file excel
                // dalam kasus ini, array ke 0 adalah paratitle                
                if ($idx < 4) {
                    continue;
                }

                //Set row number
                $row_number++;

                $status_import = "Import Data";
                $validasi = array();

                //cek and get kontrak id from kolom no pks
                $no_pks = trim($row[11]);
                $kontrak_pks = $this->dbHelper->getKontrakIdByNoP1($no_pks);
                $kontrak_pks_id = (is_null($kontrak_pks)) ? 0 : $kontrak_pks->id;

                // get data tenagakerja from excel
                $nip = trim($row[1]);
                $cek_tenagakerja = $this->dbHelper->getTenagakerjaIdByNIP($nip);
                $tenagakerja_id = (is_null($cek_tenagakerja)) ? 0 : $cek_tenagakerja->id;
                if (is_null($cek_tenagakerja)) {
                    $jml_data_baru++;
                } else {
                    $status_import = "Update Data";
                    $jml_data_updated++;
                }

                $nama = trim($row[2]);
                $tmp_lahir = trim($row[3]);
                $tgl_lahir = ubah_tgl_itm(trim($row[4]));

                $no_identitas = trim($row[5]);
                $jns_kel = strtoupper(trim($row[6]));
                $agama = strtoupper(trim($row[7]));
                $alamat = trim($row[8]);
                $telepon = trim($row[9]);
                $email = trim($row[10]);

                if ($jns_kel == "PRIA" || $jns_kel == "LAKI-LAKI" || $jns_kel == "LAKI LAKI") {
                    $jns_kelamin = "L";
                } else if ($jns_kel == "PEREMPUAN" || $jns_kel == "WANITA") {
                    $jns_kelamin = "P";
                } else {
                    $jns_kelamin = "-";
                }

                $dtAgama = $this->dbHelper->getAgamaIdByNama($agama);
                $agama_id = (is_null($dtAgama)) ? 0 : $dtAgama->id;

                $no_pkwt = trim($row[12]);
                $tgl_awal = ubah_tgl_itm(trim($row[13]));
                $tgl_akhir = ubah_tgl_itm(trim($row[14]));

                //cek tanggal awal dan tanggal akhir pkwt/pkwtt

                $jabatan = trim($row[15]);
                $wil_kerja = trim($row[16]);
                $unit_kerja = trim($row[17]);
                $mitra_kerja = trim($row[18]);
                $penempatan = $mitra_kerja . " " . trim($row[19]);
                $keterangan = trim($row[20]);


                //cek and get id jabatan, wil_kerja, unitkerja, mitrakerja dan penempatan                
                $dtJabatan = $this->dbHelper->getJabatanIdBySingkatan($jabatan);
                $dtUnitkerja = $this->dbHelper->getUnitKerjaIdByNama($unit_kerja);
                $dtMitrakerja = $this->dbHelper->getMitrakerjaIdByNama($mitra_kerja);
                $dtPenempatan = $this->dbHelper->getMitrakerjaIdByNama($penempatan);
                $dtWilayah = $this->dbHelper->getWilayahKerjaIdBySingkatan($wil_kerja);

                $jabatan_id = (is_null($dtJabatan)) ? 0 : $dtJabatan->id;
                $unitkerja_id = (is_null($dtUnitkerja)) ? 0 : $dtUnitkerja->id;
                $mitrakerja_id = (is_null($dtMitrakerja)) ? 0 : $dtMitrakerja->id;
                $penempatan_id = (is_null($dtPenempatan)) ? 0 : $dtPenempatan->id;
                $wilayah_id = (is_null($dtWilayah)) ? 0 : $dtWilayah->id;

                $no_npwp = trim($row[21]);
                $no_kartu_keluarga = trim($row[22]);
                $no_bpjs_kt = trim($row[23]);
                $no_bpjs_ks = trim($row[24]);
                $no_rek_payroll = trim($row[25]);
                $bank_rek_payroll = trim($row[26]);
                $no_rek_dplk = trim($row[27]);
                $bank_rek_dplk = trim($row[28]);

                $no_npwp = ($no_npwp != "") ? str_replace("'", "", $no_npwp) : "";
                $no_kartu_keluarga = ($no_kartu_keluarga != "") ? str_replace("'", "", $no_kartu_keluarga) : "";
                $no_bpjs_kt = ($no_bpjs_kt != "") ? str_replace("'", "", $no_bpjs_kt) : "";
                $no_bpjs_ks = ($no_bpjs_ks != "") ? str_replace("'", "", $no_bpjs_ks) : "";
                $no_rek_payroll = ($no_rek_payroll != "") ? str_replace("'", "", $no_rek_payroll) : "";
                $no_rek_dplk = ($no_rek_dplk != "") ? str_replace("'", "", $no_rek_dplk) : "";

                $dtBankPayroll = $this->dbHelper->getBankIdBySingkatan($bank_rek_payroll);
                $dtBankDPLK = $this->dbHelper->getBankIdBySingkatan($bank_rek_dplk);

                $bank_rek_payroll_id =  (is_null($dtBankPayroll)) ? 0 : $dtBankPayroll->id;
                $bank_rek_dplk_id =  (is_null($dtBankDPLK)) ? 0 : $dtBankDPLK->id;

                $pendidikan = trim($row[29]);

                $pendidikan = ($pendidikan == "STM") ? "SMK" : $pendidikan;
                $pendidikan = ($pendidikan == "SMU") ? "SLTA" : $pendidikan;

                $dtPendidikan = $this->dbHelper->getJenjangPendidikanByNama($pendidikan);
                $pendidikan_id =  (is_null($dtPendidikan)) ? 0 : $dtPendidikan->id;

                $prog_studi = trim($row[30]);

                $nama_ibu = trim($row[31]);
                $nama_pasangan = trim($row[32]);
                $nama_anak_1 = trim($row[33]);
                $nama_anak_2 = trim($row[34]);
                $nama_anak_3 = trim($row[35]);

                $no_skk1 = trim($row[36]);
                $no_skk2 = trim($row[37]);

                //Validasi data import
                if (is_null($kontrak_pks_id)) {
                    $validasi[] = "- Kontrak/SPK tidak ditemukan";
                }

                if (is_null($dtUnitkerja)) {
                    $validasi[] = "- Unit Kerja tidak ditemukan";
                }

                if (is_null($dtMitrakerja)) {
                    $validasi[] = "- Data Mitra Kerja/Customer tidak ditemukan";
                }

                if (is_null($dtPenempatan)) {
                    $validasi[] = "- Unit tempat penempatan tidak ditemukan";
                }

                if (is_null($dtWilayah)) {
                    $validasi[] = "- Wilayah kerja tidak ditemukan";
                }

                if (is_null($dtBankPayroll)) {
                    $validasi[] = "- Data Bank Rek Payroll tidak ditemukan";
                }

                if (is_null($dtBankDPLK)) {
                    $validasi[] = "- Data Bank Rek DPLK tidak ditemukan";
                }

                if (is_null($dtAgama)) {
                    $validasi[] = "- Agama '$agama' tidak ditemukan";
                }

                if ($jns_kelamin == "-") {
                    $validasi[] = "- Jenis kelamin '$jns_kel' tidak ditemukan. Gunakan 'LAKI-LAKI/PEREMPUAN'";
                }

                if (is_null($dtPendidikan)) {
                    $validasi[] = "- Jenjang Pendidikan '$pendidikan' tidak ditemukan";
                }

                if (empty($validasi)) {
                    $ket_validasi = "Menunggu konfirmasi";
                } else {
                    $status_import = "GAGAL IMPORT";
                    $ket_validasi = implode("<br>", $validasi);
                    $jml_data_gl++;
                }

                $imp_data = [
                    "status_import"  => $status_import,
                    "validasi"       => $ket_validasi,

                    "kontrak_pks_id" => $kontrak_pks_id,
                    "tenagakerja_id" => $tenagakerja_id,
                    "nip"  => $nip,
                    "nama" => $nama,

                    "no_identitas"  => $no_identitas,
                    "tempat_lahir"  => $tmp_lahir,
                    "tanggal_lahir" => $tgl_lahir,
                    "jenis_kelamin" => $jns_kelamin,
                    "agama_id" => $agama_id,
                    "alamat"  => $alamat,
                    "telepon" => $telepon,
                    "email"   => $email,

                    "no_pkwt"       => $no_pkwt,
                    "tanggal_awal"  => $tgl_awal,
                    "tanggal_akhir" => $tgl_akhir,

                    "jabatan_id"    => $jabatan_id,
                    "unitkerja_id"  => $unitkerja_id,
                    "mitrakerja_id" => $mitrakerja_id,
                    "penempatan_id" => $penempatan_id,
                    "wilayah_id"    => $wilayah_id,

                    "no_npwp"          => $no_npwp,
                    "no_kartu_keluarga" => $no_kartu_keluarga,
                    "no_bpjs_kt"       => $no_bpjs_kt,
                    "no_bpjs_ks"       => $no_bpjs_ks,
                    "no_rek_payroll"   => $no_rek_payroll,
                    "bank_rek_payroll" => $bank_rek_payroll,
                    "bank_rek_payroll_id" => $bank_rek_payroll_id,
                    "no_rek_dplk"      => $no_rek_dplk,
                    "bank_rek_dplk"    => $bank_rek_dplk,
                    "bank_rek_dplk_id"    => $bank_rek_dplk_id,

                    "pendidikan_id" => $pendidikan_id,
                    "program_studi"       => $prog_studi,

                    "nama_ibu"            => $nama_ibu,
                    "nama_pasangan_hidup" => $nama_pasangan,
                    "nama_anak_1"         => $nama_anak_1,
                    "nama_anak_2"         => $nama_anak_2,
                    "nama_anak_3"         => $nama_anak_3,

                    "no_skk_1" => $no_skk1,
                    "no_skk_2" => $no_skk2,

                    "keterangan" => $keterangan,

                    "import_tanggal" => date('Y-m-d H:i:s'),
                    "import_oleh" => $user_id
                ];

                // Save data to batch
                $batchData[] = $imp_data;
            }

            if ($cek_file_import == "OK") {
                if (count($batchData) != 0) {
                    $simpan = $dtTenagakerjaTemp->insertBatchDataFromXls($batchData);
                    if ($simpan) {
                        $jml_data_import = $simpan;
                        if ($jml_data_import == 0) {
                            session()->setFlashdata('warning', 'Data Tenaga kerja tidak berhasil di import.<br>Silahkan cek kembali file excel yang akan di import.');
                        } else {
                            $ket_hasil_validasi =  '<hr>' .
                                'Jumlah data yang akan di import   : ' . $jml_data_import . ' Data Ditemukan<br><br>' .

                                '- Data Baru      : ' . $jml_data_baru . ' Ditemukan.<br>' .
                                '- Pembaruan Data : ' . $jml_data_updated . ' Ditemukan.<br><br>';

                            if ($jml_data_gl == 0) {
                                $ket_hasil_validasi .= 'Proses Validasi Data Selesai. <br> Silahkan lanjutkan dengan mengklik tombol "KOMFIRMASI" di akhir halaman ini.';
                            } else {
                                $ket_hasil_validasi .= 'Hasil validasi : ' . $jml_data_gl . ' Data tidak dapat di import.<br><br>';
                                $ket_hasil_validasi .= 'FILE EXCEL TIDAK DAPAT DI IMPORT !!!<br><br> Cek kembali data pada file excel yang akan diimport.';
                            }
                            session()->setFlashdata('success-validation-import', $ket_hasil_validasi);
                        }
                    } else {
                        session()->setFlashdata('danger2', 'Data Tenaga kerja tidak berhasil di import.<br>Silahkan cek kembali file excel yang akan di import.');
                    }
                }
            } else {
                session()->setFlashdata('danger2', $cek_file_import);
            }

            return redirect()->to($redirectPath);
        }
    }

    public function proses_data_import_tk_xlsx()
    {
        $user_id = $this->user_id;

        $batchImportData = array();
        $batchUpdateData = array();

        $batchImportDataDetail = array();
        $batchUpdateDataDetail = array();

        $jml_import = 0;
        $jml_update = 0;

        $redirectPath = '/ketenagakerjaan_import_tenagakerja';

        $filter_temp = ["import_oleh " => $user_id];
        $dtTenagakerjaTemp = $this->dbHelper->getTenagakerjaTemporary($filter_temp);

        foreach ($dtTenagakerjaTemp as $rowdata) {

            $status_import = $rowdata['status_import'];
            $validasi = $rowdata['validasi'];

            $nip = $rowdata['nip'];
            $kata_kunci = password_hash($nip, PASSWORD_BCRYPT);

            if (strtoupper($status_import) == 'IMPORT DATA') {
                if ($validasi == "Menunggu konfirmasi") {
                    $imp_data = [
                        "nip" => $nip,
                        "nama" => $rowdata['nama'],
                        "jabatan_id" => $rowdata['jabatan_id'],
                        "unitkerja_id" => $rowdata['unitkerja_id'],
                        "penempatan_id" => $rowdata['penempatan_id'],
                        "wilayah_id" => $rowdata['wilayah_id'],
                        "email" => $rowdata['email'],
                        "kata_kunci" => $kata_kunci,
                        "otoritas_id" => 4,
                        "status_id" => 1,
                        "apps_id" => 0,
                        "created_at" => date('Y-m-d H:i:s'),
                        "updated_at" => date('Y-m-d H:i:s'),
                        "updated_from" => "I"
                    ];

                    // Save to batchdata
                    $batchImportData[] = $imp_data;
                }
            } else if (strtoupper($status_import) == 'UPDATE DATA') {
                if ($validasi == "Menunggu konfirmasi") {
                    $upd_data = [
                        "id" => $rowdata['tenagakerja_id'],
                        "nip" => $nip,
                        "nama" => $rowdata['nama'],
                        "jabatan_id" => $rowdata['jabatan_id'],
                        "unitkerja_id" => $rowdata['unitkerja_id'],
                        "penempatan_id" => $rowdata['penempatan_id'],
                        "wilayah_id" => $rowdata['wilayah_id'],
                        "email" => $rowdata['email'],
                        "kata_kunci" => $kata_kunci,
                        "otoritas_id" => 4,
                        "status_id" => 1,
                        "apps_id" => 0,
                        "updated_at" => date('Y-m-d H:i:s'),
                        "updated_from" => "I",
                    ];

                    // Save to batchdata
                    $batchUpdateData[] = $upd_data;
                }
            }
        }

        if (count($batchImportData) != 0) {
            $simpan = $this->dbTenagakerja->insertBatchDataFromXls($batchImportData);
            $jml_import = $simpan;
        }

        if (count($batchUpdateData) != 0) {
            $simpan_update = $this->dbTenagakerja->updateBatchDataFromXls($batchUpdateData);
            $jml_update = $simpan_update;
        }

        //import data detail
        foreach ($dtTenagakerjaTemp as $rowdata) {
            $status_import = $rowdata['status_import'];
            $validasi = $rowdata['validasi'];

            $nip = $rowdata['nip'];
            $dtTenagakerja = $this->dbHelper->getTenagakerjaIdByNIP($nip);
            $pegawai_id = $dtTenagakerja->id;

            $imp_data_detail = [
                "pegawai_id" => $pegawai_id,
                "kontrak_pks_id" => $rowdata['kontrak_pks_id'],
                "no_identitas" => $rowdata['no_identitas'],
                "tempat_lahir" => $rowdata['tempat_lahir'],
                "tanggal_lahir" => $rowdata['tanggal_lahir'],
                "jenis_kelamin" => $rowdata['jenis_kelamin'],
                "agama_id" => $rowdata['agama_id'],
                "alamat" => $rowdata['alamat'],
                "telepon" => $rowdata['telepon'],
                "pendidikan_id" => $rowdata['pendidikan_id'],
                "program_studi" => $rowdata['program_studi'],

                "no_pkwt"       => $rowdata['no_pkwt'],
                "tanggal_awal"  => $rowdata['tanggal_awal'],
                "tanggal_akhir" => $rowdata['tanggal_akhir'],

                "no_npwp"          => $rowdata['no_npwp'],
                "no_kartu_keluarga" => $rowdata['no_kartu_keluarga'],
                "no_bpjs_kt"       => $rowdata['no_bpjs_kt'],
                "no_bpjs_ks"       => $rowdata['no_bpjs_ks'],
                "no_rek_payroll"   => $rowdata['no_rek_payroll'],
                "bank_rek_payroll_id" => $rowdata['bank_rek_payroll_id'],
                "no_rek_dplk"      => $rowdata['no_rek_dplk'],
                "bank_rek_dplk_id"    => $rowdata['bank_rek_dplk_id'],

                "nama_ibu"            => $rowdata['nama_ibu'],
                "nama_pasangan_hidup" => $rowdata['nama_pasangan_hidup'],
                "nama_anak_1"         => $rowdata['nama_anak_1'],
                "nama_anak_2"         => $rowdata['nama_anak_2'],
                "nama_anak_3"         => $rowdata['nama_anak_3'],

                "no_skk_1" => $rowdata['no_skk_1'],
                "no_skk_2" => $rowdata['no_skk_2'],

                "keterangan" => $rowdata['keterangan'],
            ];

            if (strtoupper($status_import) == 'IMPORT DATA') {
                if ($validasi == "Menunggu konfirmasi") {
                    $batchImportDataDetail[] = $imp_data_detail;
                }
            } else if (strtoupper($status_import) == 'UPDATE DATA') {
                if ($validasi == "Menunggu konfirmasi") {
                    $batchUpdateDataDetail[] = $imp_data_detail;
                }
            }
        }

        if (count($batchImportDataDetail) != 0) {
            $simpan_detail = $this->dbTenagakerjaDetail->insertBatchDataFromXls($batchImportDataDetail);
        }

        if (count($batchUpdateDataDetail) != 0) {
            $simpan_update_detail = $this->dbTenagakerjaDetail->updateBatchDataFromXls($batchUpdateDataDetail);
        }

        //hapus data kontrak di tabel temporary jika sudah berhasil di import ke tabel utama
        if ($jml_import != 0 || $jml_update != 0) {
            $this->dbHelper->deleteTenagakerjaTemporary($filter_temp);
        }

        if (($jml_import + $jml_update) != 0) {
            $ket_import =  '<hr>' .
                'Jumlah data    : ' . $jml_import . '<br>' .
                'Data Baru      : ' . $jml_import . ' Berhasil di import.<br>' .
                'Pembaruan Data : ' . $jml_update . ' Berhasil di perbarui.<br><br>' .
                'Proses Import Data Selesai.';
            session()->setFlashdata('success-import', $ket_import);
        }

        return redirect()->to($redirectPath);
    }
}
