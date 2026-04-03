<?php
// function.php
function hitungNilaiAkhir($tugas, $uts, $uas) {
    return ($tugas * 0.3) + ($uts * 0.3) + ($uas * 0.4);
}

function grade($nilai) {
    if ($nilai >= 85) return "A";
    elseif ($nilai >= 70) return "B";
    elseif ($nilai >= 60) return "C";
    elseif ($nilai >= 50) return "D";
    else return "E";
}

function status($nilai) {
    return $nilai >= 60 ? "Lulus" : "Tidak Lulus";
}
