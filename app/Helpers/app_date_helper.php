<?php

/**
 * Konversi Tanggal MySQL ke hari, DD MMMM YYYY (Indonesia)
 *  
 * @param string $defa_date Tanggal dari MySQL (yyyy-mm-dd)
 * @param integer $format Format output yang di inginkan
 * 
 * @return mixed
 */

function waktu($defa_date = null, $format = 1)
{
    $array_hari = array(1 => 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu');
    $array_bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

    if (is_null($defa_date)) {
        $hari = $array_hari[date('N')];
        $bulan = $array_bulan[date('n')];

        $tanggal = date('j');
        $tahun = date('Y');
    } else {

        $date = date_create($defa_date); //create date from parameter

        $hari = $array_hari[date_format($date, 'N')];
        $bulan = $array_bulan[date_format($date, 'n')];

        $tanggal = date_format($date, 'j');
        $tahun = date_format($date, 'Y');
    }
    if ($format == 1) {
        $ret_date = $hari . ', ' . $tanggal . ' ' . $bulan . ' ' . $tahun;
    } else if ($format == 2) {
        $ret_date = $tanggal . ' ' . $bulan . ' ' . $tahun;
    }

    return $ret_date;
}

function ambil_tgl()
{
    $today = date('d/m/Y');
    return $today;
}

function ambil_jam()
{
    $today = date('H:i');
    return $today;
}

function ambil_tanggal_jam($fdate = null)
{
    if ($fdate == "mysql") {
        $today = date('Y-m-d H:i:s');
    } else if ($fdate == "eng") {
        $today = date('m/d/Y  H:i:s');
    } else {
        //indo
        $today = date('d/m/Y  H:i:s');
    }
    return $today;
}

/** 
 * Fungsi untuk mengubah susunan format tanggal 
 * Dari English to MySQL 
 * -> mm/dd/yyyy ke yyyy-mm-dd 
 */
function ubah_tgl_etm($tanggal)
{
    $pisah = explode('/', $tanggal);
    $larik = array($pisah[2], $pisah[0], $pisah[1]);
    $satukan = implode('-', $larik);

    return $satukan;
}

/** 
 * Dari MySQL to English 
 * -> yyyy-mm-dd ke mm/dd/yyyy 
 **/
function ubah_tgl_mte($tanggal)
{
    $pisah = explode('-', $tanggal);
    $larik = array($pisah[1], $pisah[2], $pisah[0]);
    $satukan = implode('/', $larik);

    return $satukan;
}

/** 
 * Dari Indonesia to MySQL 
 * -> dd/mm/yyyy ke yyyy-mm-dd 
 **/
function ubah_tgl_itm($tanggal)
{
    $pisah = explode('/', $tanggal);
    $larik = array($pisah[2], $pisah[1], $pisah[0]);
    $satukan = implode('-', $larik);

    return $satukan;
}

/** 
 * Dari MySQL to Indonesia 
 * -> yyyy-mm-dd ke dd/mm/yyyy 
 **/
function ubah_tgl_mti($tanggal)
{
    $pisah = explode('-', $tanggal);
    $larik = array($pisah[2], $pisah[1], $pisah[0]);
    $satukan = implode('/', $larik);

    return $satukan;
}

function ambil_angka_bulan_tahun($tanggal = null)
{
    if (is_null($tanggal)) {
        $bln_tahun = date('mY');
    } else {
        //if tgl = 2020-01-01        
        $bln_tahun = substr($tanggal, 5, 2) . substr($tanggal, 0, 4);
    }

    return $bln_tahun;
}

function ambil_bulan_tahun($bulan = null)
{
    $array_bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

    if (is_null($bulan)) {
        $bulan = $array_bulan[date('n')];
        $tahun = date('Y');
    } else {
        $arr_bln = explode("-", $bulan);

        $bulan = $array_bulan[(int) $arr_bln[1]];
        $tahun = $arr_bln[0];
    }


    return $bulan . ' ' . $tahun;
}

// corrected by ben at sparkyb dot net
function ambil_jumlah_hari($month, $year)
{
    // calculate number of days in a month
    return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
}

// corrected by ben at sparkyb dot net
function hitung_total_jam($tgl1, $tgl2)
{
    $ctgl1 = date_create($tgl1);
    $ctgl2 = date_create($tgl2);

    $diff = date_diff($ctgl1, $ctgl2);
    $total_jam = ($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h + $diff->i / 60;

    return number_format($total_jam, 2);
}

function hitung_total_jam_to_string($tgl1, $tgl2)
{
    $ctgl1 = date_create($tgl1);
    $ctgl2 = date_create($tgl2);

    $diff = date_diff($ctgl1, $ctgl2);
    $total_jam = ($diff->y * 365.25 + $diff->m * 30 + $diff->d) * 24 + $diff->h;
    $menit =  $diff->i;
    $result = $total_jam . " Jam " . $menit . " Menit";

    return $result;
}

function getCurrentWeek()
{
    $monday = strtotime("last monday");
    $monday = date('w', $monday) == date('w') ? $monday + 7 * 86400 : $monday;
    $sunday = strtotime(date("Y-m-d", $monday) . " +6 days");
    // $this_week_sd = date("Y-m-d", $monday);
    // $this_week_ed = date("Y-m-d", $sunday);

    $this_week_sd = date("j M, Y", $monday);
    $this_week_ed = date("j M, Y", $sunday);
    return "$this_week_sd - $this_week_ed ";
}

function ambil_bulan_sebelumnya()
{
    return date('Y-m', strtotime('first day of last month'));
}

function ambil_bulan_setahun_kebelakang()
{
    $periode[] = date('Y-m-01');

    for ($nctr = 1; $nctr < 12; $nctr++) {
        $periode[] = date('Y-m-01', strtotime('-' . $nctr . ' month'));
    }

    return $periode;
}

/**
 * @return date
 */
function getDaysExclWeekend()
{
    $curdate = '2021-10-30';
    $mydate = getdate(strtotime($curdate));
    switch ($mydate['wday']) {
        case 0: // sun
        case 1: // mon
            $days = 4;
            break;
        case 2:
        case 3:
        case 4:
        case 5:
            $days = 6;
            break;
        case 6: // sat
            $days = 5;
            break;
    }
    return date('Y-m-d', strtotime("$curdate + $days days"));
}

/**
 * Menghitung jumlah hari tanpa hari sabtu dan minggu
 * @return days
 */
function getWeekdayDifference(\DateTime $startDate, \DateTime $endDate)
{
    $isWeekday = function (\DateTime $date) {
        return $date->format('N') < 6;
    };

    $days = $isWeekday($endDate) ? 1 : 0;

    while ($startDate->diff($endDate)->days > 0) {
        $days += $isWeekday($startDate) ? 1 : 0;
        $startDate = $startDate->add(new \DateInterval("P1D"));
    }

    return $days;
}
