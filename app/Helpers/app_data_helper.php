<?php

use App\Database\DbHelper;

function getValHNK($haknormatif)
{
    //konfersi rumus hak normatif ke array
    $vHN = str_replace(['(', ')'], "", $haknormatif);
    $vHN = str_replace(['*', '/', '+', '-'], ",", $vHN);
    $arrHN = explode(",", $vHN);

    //cari dan ganti semua parameter di rumus dengan nilainya
    $newSHK = $haknormatif;

    $dbHelper = new DbHelper();
    foreach ($arrHN as $key) {
        $komponen = $dbHelper->getDataByQuery('mkp__tenagakerja_haknormatif_komponen', 'komponen,rumus', "haknormatif='$key'")->getFirstRow();
        if (is_null($komponen)) {
            $value = $key;
        } else {
            $gkomp = json_decode($komponen->rumus, true);
            $value = $gkomp[$komponen->komponen];
        }

        //kembalikan menjadi string dengan rumus yang telah diganti nilainya
        $newSHK = str_replace("$key", $value, $newSHK);
    }
    $newSHK = getValHNK_II($newSHK);
    return $newSHK;
}

function getValHNK_II($haknormatif)
{
    //konfersi rumus hak normatif ke array
    $vHN = str_replace(['(', ')'], "", $haknormatif);
    $vHN = str_replace(['*', '/', '+', '-'], ",", $vHN);
    $arrHN = explode(",", $vHN);

    //cari dan ganti semua parameter di rumus dengan nilainya
    $newSHK = $haknormatif;

    $dbHelper = new DbHelper();
    foreach ($arrHN as $key) {
        $komponen = $dbHelper->getDataByQuery('mkp__tenagakerja_haknormatif_komponen', 'komponen,rumus', "haknormatif='$key'")->getFirstRow();
        if (is_null($komponen)) {
            $value = $key;
        } else {
            $gkomp = json_decode($komponen->rumus, true);
            $value = $gkomp[$komponen->komponen];
        }

        //kembalikan menjadi string dengan rumus yang telah diganti nilainya
        $newSHK = str_replace("$key", $value, $newSHK);
    }
    return $newSHK;
}
