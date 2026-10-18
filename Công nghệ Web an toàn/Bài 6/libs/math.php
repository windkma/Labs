<?php
// ==========================================
// 1. THƯ VIỆN HÀM XỬ LÝ MẢNG 1 CHIỀU
// ==========================================

function tongDay($mangSo) {
    $sum = 0;
    foreach ($mangSo as $val) {
        $sum += $val;
    }
    return $sum;
}

function avgDay($mangSo) {
    $count = count($mangSo);
    if ($count == 0) return 0;
    return round(tongDay($mangSo) / $count, 2);
}

function minDay($mangSo) {
    if (empty($mangSo)) return 0;
    $min = $mangSo[0];
    foreach ($mangSo as $val) {
        if ($val < $min) $min = $val;
    }
    return $min;
}

function maxDay($mangSo) {
    if (empty($mangSo)) return 0;
    $max = $mangSo[0];
    foreach ($mangSo as $val) {
        if ($val > $max) $max = $val;
    }
    return $max;
}

function sortDay($mangSo) {
    sort($mangSo);
    return $mangSo;
}

function daoNguocDay($mangSo) {
    return array_reverse($mangSo);
}

// ==========================================
// 2. THƯ VIỆN HÀM XỬ LÝ MA TRẬN (MẢNG 2 CHIỀU)
// ==========================================

function maxMatran($m) {
    $max = $m[0][0];
    for ($i = 0; $i < count($m); $i++) {
        for ($j = 0; $j < count($m[$i]); $j++) {
            if ($m[$i][$j] > $max) $max = $m[$i][$j];
        }
    }
    return $max;
}

function minMatran($m) {
    $min = $m[0][0];
    for ($i = 0; $i < count($m); $i++) {
        for ($j = 0; $j < count($m[$i]); $j++) {
            if ($m[$i][$j] < $min) $min = $m[$i][$j];
        }
    }
    return $min;
}

function tongTrenCheoChinh($m) {
    $sum = 0;
    $n = count($m);
    for ($i = 0; $i < $n; $i++) {
        $sum += $m[$i][$i];
    }
    return $sum;
}

function tongTrenCheoPhu($m) {
    $sum = 0;
    $n = count($m);
    for ($i = 0; $i < $n; $i++) {
        $sum += $m[$i][$n - 1 - $i];
    }
    return $sum;
}

function tinhMatranTong($m1, $m2) {
    $res = [];
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            $res[$i][$j] = $m1[$i][$j] + $m2[$i][$j];
        }
    }
    return $res;
}

function tinhMatranHieu($m1, $m2) {
    $res = [];
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            $res[$i][$j] = $m1[$i][$j] - $m2[$i][$j];
        }
    }
    return $res;
}

function tinhMatranTich($m1, $m2) {
    $res = [];
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            $res[$i][$j] = 0;
            for ($k = 0; $k < 3; $k++) {
                $res[$i][$j] += $m1[$i][$k] * $m2[$k][$j];
            }
        }
    }
    return $res;
}
?>