function konversiFormatTanggal(tanggal) {
    var hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    var bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    var tanggalObj = new Date(tanggal);

    // Mendapatkan hari, tanggal, bulan, dan tahun
    var hariStr = hari[tanggalObj.getDay()];
    var tanggalStr = tanggalObj.getDate();
    var bulanStr = bulan[tanggalObj.getMonth()];
    var tahunStr = tanggalObj.getFullYear();

    // Mendapatkan jam, menit, dan detik
    var jamStr = ("0" + tanggalObj.getHours()).slice(-2);
    var menitStr = ("0" + tanggalObj.getMinutes()).slice(-2);
    var detikStr = ("0" + tanggalObj.getSeconds()).slice(-2);

    // Menggabungkan dalam format yang diinginkan
    var formatTanggal =  tanggalStr + " " + bulanStr + " " + tahunStr ;

    return formatTanggal;
}

function konversiFormatTanggalTanpaHari(tanggal) {
    var hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    var bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    var tanggalObj = new Date(tanggal);

    // Mendapatkan hari, tanggal, bulan, dan tahun
    var hariStr = hari[tanggalObj.getDay()];
    var tanggalStr = tanggalObj.getDate();
    var bulanStr = bulan[tanggalObj.getMonth()];
    var tahunStr = tanggalObj.getFullYear();

    // Mendapatkan jam, menit, dan detik
    var jamStr = ("0" + tanggalObj.getHours()).slice(-2);
    var menitStr = ("0" + tanggalObj.getMinutes()).slice(-2);
    var detikStr = ("0" + tanggalObj.getSeconds()).slice(-2);

    // Menggabungkan dalam format yang diinginkan
    var formatTanggal = tanggalStr + " " + bulanStr + " " + tahunStr + " Pukul " + jamStr + ":" + menitStr + ":" + detikStr;

    return formatTanggal;
}

// Contoh penggunaan
var tanggalContoh = '2024-06-01T20:37:00';
console.log(konversiFormatTanggal(tanggalContoh));
// Output: "Minggu, 1 Juni 2024 Pukul 20:37:00"


function konversiTanggal(tanggal) {
    var tanggalObj = new Date(tanggal);

    // Mendapatkan tanggal, bulan, dan tahun
    var tanggalStr = ("0" + tanggalObj.getDate()).slice(-2);
    var bulanStr = ("0" + (tanggalObj.getMonth() + 1)).slice(-2);
    var tahunStr = tanggalObj.getFullYear();



    // Menggabungkan dalam format yang diinginkan
    var formatTanggal = tanggalStr + "-" + bulanStr + "-" + tahunStr ;

    return formatTanggal;
}

function konversiJam(tanggal) {
    var tanggalObj = new Date(tanggal);

    // Mendapatkan tanggal, bulan, dan tahun
    var tanggalStr = ("0" + tanggalObj.getDate()).slice(-2);
    var bulanStr = ("0" + (tanggalObj.getMonth() + 1)).slice(-2);
    var tahunStr = tanggalObj.getFullYear();

    // Mendapatkan jam, menit, dan detik
    var jamStr = ("0" + tanggalObj.getHours()).slice(-2);
    var menitStr = ("0" + tanggalObj.getMinutes()).slice(-2);
    var detikStr = ("0" + tanggalObj.getSeconds()).slice(-2);

    // Menggabungkan dalam format yang diinginkan
    var formatTanggal = jamStr + ":" + menitStr ;

    return formatTanggal;
}

