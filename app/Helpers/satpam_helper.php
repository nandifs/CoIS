<?php
function createJadPiket($jmlhari)
{
    $shiftDef = array(1 => "P", "S", "M", "L");
    $sfStart = array(1 => "P", "S", "M", "L");

    //Cari Regu yang mendapatkan libur bertama
    $posL = array_search("L", $sfStart);

    ///Inisialisasi shift hari pertama berdasarkan shift dimulai untuk setiap regu
    $i = $posL;
    $restCal = array(1 => 1, 2, 3, 4);
    for ($nctr = 1; $nctr <= 4; $nctr++) {
        $restCal[$nctr] = $sfStart[$i];
        if ($i == 4)
            $i = 0;
        $i++;
    }

    //Cek shift selanjutnya untuk Regu setelah mendapatkan libur
    $nxtShiftR1 = $restCal[2];
    $nxtShiftR2 = $restCal[3];
    $nxtShiftR3 = $restCal[4];
    $nxtShiftR4 = $restCal[2];

    //Mulai mengkalkulasi jadwal shift
    //Inisialisasi minggu pertama untuk setiap regu
    if ($nxtShiftR1 == "M") {
        $restCal[2] = $restCal[2] . "LL";
        $restCal[3] = $restCal[3] . "PPLL";
        $restCal[4] = $restCal[4] . "SSSLL";
    } elseif ($nxtShiftR1 == "P") {
        $restCal[1] = $restCal[1] . "L";
        $restCal[2] = $restCal[2] . "PLL";
        $restCal[3] = $restCal[3] . "SSSL";
        $restCal[4] = $restCal[4] . "MMMMLL";
    } elseif ($nxtShiftR1 == "S") {
        $restCal[1] = $restCal[1] . "L";
        $restCal[2] = $restCal[2] . "SL";
        $restCal[3] = $restCal[3] . "MMLL";
        $restCal[4] = $restCal[4] . "PPPPLL";
    }

    $restCal[1] = calcJadPiket($restCal[1], $nxtShiftR1, $jmlhari);
    $restCal[2] = calcJadPiket($restCal[2], $nxtShiftR2, $jmlhari);
    $restCal[3] = calcJadPiket($restCal[3], $nxtShiftR3, $jmlhari);
    $restCal[4] = calcJadPiket($restCal[4], $nxtShiftR4, $jmlhari);


    if ($posL <> 1) {
        $temp = $restCal[$posL];
        $i = $posL;
        $j = $posL;
        for ($nctr = 1; $nctr <= 4; $nctr++) {
            if ($i == 4) $j = 1;
            $restCal[$i] = $restCal[$j];
            if ($i == 4) $i = 0;
            $i++;
            $j++;
        }
        $restCal[$i - 1] = $temp;
    }

    return $restCal;
}

function calcJadPiket($shift, $nsf, $jmlhari)
{
    $lenShift = strlen($shift);
    $sfa = $nsf;
    $i = 1;
    for ($nctr = $lenShift; $nctr < $jmlhari; $nctr++) {
        $shift = $shift . $sfa;
        if ($sfa == "L" & $nsf == "M") {
            $sfa = $nsf;
            $i = 1;
        } else {
            if ($i < 5) {
                if ($sfa == "L" && $i == 2) {
                    $sfa = $nsf;
                    $i = 0;
                }
                $i++;
            } else {
                if ($sfa == "P") $nsf = "S";
                if ($sfa == "S") $nsf = "M";
                if ($sfa == "M") $nsf = "P";

                $sfa = "L";
                $i = 1;
            }
        }
    }
    return $shift;
}
