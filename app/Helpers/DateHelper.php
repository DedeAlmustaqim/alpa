<?php

if (!function_exists('konversiFormatTanggal')) {
    function konversiFormatTanggal($tanggal)
    {
        $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        // Konversi tanggal ke timestamp
        $tanggalObj = strtotime($tanggal);

        // Mendapatkan hari, tanggal, bulan, dan tahun
        $hariStr = $hari[date('w', $tanggalObj)];
        $tanggalStr = date('j', $tanggalObj);
        $bulanStr = $bulan[date('n', $tanggalObj) - 1];
        $tahunStr = date('Y', $tanggalObj);

        // Menggabungkan dalam format yang diinginkan
        $formatTanggal = $hariStr . ', ' . $tanggalStr . ' ' . $bulanStr . ' ' . $tahunStr;

        return $formatTanggal;
    }
}
