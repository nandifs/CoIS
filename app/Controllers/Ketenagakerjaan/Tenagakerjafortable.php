<?php

namespace App\Controllers\Ketenagakerjaan;

use App\Controllers\BaseController;

use App\Database\DbHelper;
use App\Database\DbHTableKetenagakerjaan;

class Tenagakerjafortable extends BaseController
{
    protected $dbHelper;
    protected $DbHTableKetenagakerjaan;


    public function __construct()
    {
        $this->dbHelper = new DbHelper();
        $this->DbHTableKetenagakerjaan = new DbHTableKetenagakerjaan();
    }

    public function ajax_get_data_tenagakerja()
    {
        $dataId = $this->request->getVar('data_id');
        $expDataId = explode('|', $dataId);

        $vdata = $expDataId[0];
        $mitrakerja_id = $expDataId[1];

        $dbHForTable = new DbHTableKetenagakerjaan();

        $data = array();
        $no = $_POST['start'];
        if ($vdata == "tenagakerja") {
            $vSelect = "status,nip,nama,jabatan,unitkerja,penempatan,wilayahkerja,no_pks_p1,no_pkwt,tanggal_awal,tanggal_akhir,
                    no_identitas,tempat_lahir,tanggal_lahir,jenis_kelamin,agama,alamat,telepon,
                    bank_rek_payroll,no_rek_payroll,no_bpjs_kt,no_bpjs_ks,bank_rek_dplk,no_rek_dplk,
                    no_kartu_keluarga,nama_ibu,nama_pasangan_hidup,nama_anak_1,nama_anak_2,nama_anak_3,
                    pendidikan,program_studi,no_skk_1,no_skk_2,no_npwp,keterangan";

            $dtTenagakerja = $dbHForTable->getForTabelTenagakerja($mitrakerja_id, "stv__ketenagakerjaan_data_tk", $vSelect);
        } else if ($vdata == "upah") {
            $vSelect = "status,nip,nama,jabatan,wilayahkerja,c|upah_pokok,c|umk,
                        c|tunj_masa_kerja,c|tunj_transport,c|tunj_makan,c|tunj_keahlian,c|tunj_hari_raya,c|tunj_lainnya,
                        c|premi_bpjs_kt,c|premi_bpjs_ks,c|premi_dplk,
                        c|pot_bpjs_kt,c|pot_bpjs_ks,c|pot_adm,c|pot_seragam,c|pot_sanksi,c|pot_pajak,c|pot_lainnya";

            $dtTenagakerja = $dbHForTable->getForTabelTenagakerja($mitrakerja_id, "stv__ketenagakerjaan_data_haknormatif", $vSelect);
        }

        $thp = "c|umk,c|tunj_masa_kerja,c|tunj_transport,c|tunj_makan,c|tunj_keahlian,c|tunj_lainnya";
        $potongan = "c|pot_bpjs_kt,c|pot_bpjs_ks,c|pot_adm,c|pot_seragam,c|pot_sanksi,c|pot_pajak,c|pot_lainnya";
        $premi = "c|premi_bpjs_kt,c|premi_bpjs_ks,c|premi_dplk";

        //convert selected field name to array
        $vColoum = stringToArray($vSelect);
        $vArrTHP = stringToArray($thp);
        $vArrPotongan = stringToArray($potongan);
        $vArrPremi = stringToArray($premi);

        foreach ($dtTenagakerja as $tenagakerja) {
            $jmlTHP = 0.0;
            $jmlPremi = 0.0;
            $jmlPotongan = 0.0;

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $this->action($tenagakerja->id, $tenagakerja->nip, $tenagakerja->nama);
            foreach ($vColoum as $nmfield) {
                $retValue = coloumFormat($nmfield, $tenagakerja);
                $row[] = $retValue[0];
                $realValue = $retValue[1];

                if (in_array($nmfield, $vArrTHP)) {
                    $jmlTHP += (float) $realValue;
                }
                if (in_array($nmfield, $vArrPotongan)) {
                    $jmlPotongan += (float) $realValue;
                }
                if (in_array($nmfield, $vArrPremi)) {
                    $jmlPremi += (float) $realValue;
                }
            }
            if ($vdata == "upah") {
                $UpahDiTerima = $jmlTHP - $jmlPotongan;
                $row[] = number_format($UpahDiTerima, 2);
                $row[] = $tenagakerja->keterangan;
            }
            $row[] = $this->action($tenagakerja->id, $tenagakerja->nip, $tenagakerja->nama);

            $data[] = $row;
        }

        $output = array(
            "draw"                 => $_POST['draw'],
            "recordsTotal"         => $dbHForTable->count_all($mitrakerja_id),
            "recordsFiltered"      => $dbHForTable->count_filtered($mitrakerja_id),
            "data"                 => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    function action($tenagakerja_id, $tenagakerja_nip, $tenagakerja_nama)
    {
        //$action = "<div class='btn-group'> <button type='button' class='btn btn-success btn-sm' title='Edit' onclick='editData(\"$tenagakerja_nip\")'><i class='fa fa-edit'></i> Edit</button> <button type='button' class='btn btn-danger btn-sm' title='Hapus' onclick='deleteData($tenagakerja_id,\"$tenagakerja_nama\");'><i class=' fa fa-trash-alt'></i> Hapus</button> </div>";
        $action = "<div class='btn-group'> <button type='button' class='btn btn-success btn-sm' title='Informasi Detail' onclick='info_detail(\"$tenagakerja_nip\")'><i class='fa fa-info'></i> <strong>Detail</strong></button></div>";
        return $action;
    }
}
