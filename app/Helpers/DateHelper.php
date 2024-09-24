<?php

namespace App\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public static function formatTanggalIndonesia($date)
    {
        // Set lokal bahasa Indonesia
        Carbon::setLocale('id');

        // Format hari, tanggal-bulan-tahun, jam:menit
        return Carbon::parse($date)->translatedFormat('l, d F Y H:i');
    }
}
