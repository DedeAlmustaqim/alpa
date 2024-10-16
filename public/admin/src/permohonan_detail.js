$(document).ready(function () {

    $('.time-picker').timepicker({
        'timeFormat': 'H:i'
    });
    var id = $('#id_aset_mohon').val()
    refreshData()



    $('#modalPinjam').on('hidden.bs.modal', function () {
        // Reset form ketika modal ditutup

    });

    $('#reschedule').change(function () {
        if ($(this).is(':checked')) {
            // Jika checkbox diaktifkan, input akan bisa diubah dan warna diatur ulang
            $('#jadwal_mulai').prop('readonly', false).removeClass('input-disabled');
            $('#jadwal_mulai_time').prop('readonly', false).removeClass('input-disabled');
            $('#jadwal_akhir_time').prop('readonly', false).removeClass('input-disabled');
            $('#jadwal_akhir').prop('readonly', false).removeClass('input-disabled');
        } else {
            // Jika checkbox dimatikan, input menjadi readonly dan warna abu-abu
            $('#jadwal_mulai').prop('readonly', true).addClass('input-disabled');
            $('#jadwal_mulai_time').prop('readonly', true).addClass('input-disabled');
            $('#jadwal_akhir_time').prop('readonly', true).addClass('input-disabled');
            $('#jadwal_akhir').prop('readonly', true).addClass('input-disabled');
        }
    });
});

function refreshData() {
    var id = $('#id_aset_mohon').val()
    showASetId(id)
    showPermohonan(id)
    showPermohonanVerif(id)
    showPermohonanAccept(id)
    showPermohonanFinish(id)
    showPermohonanReject(id)
    showAStatus(id)
}

function modalPinjam(elem) {
    var id_aset = $(elem).data("id");
    var id_mohon = $(elem).data("idmohon");
    var aksi = $(elem).data("aksi");
    $('#id_aset_setuju').val(id_aset)
    $.ajax({
        url: BASE_URL + '/admin/getDataMohon/' + id_mohon,
        type: "GET",

        success: function (response) {
            var data = typeof response === "string" ? JSON.parse(response) : response;

            // Set data to table fields
            $('#name_pemohon').text(data.name);
            $('#catatan').text(data.catatan);
            $('#tgl_mulai').text(konversiFormatTanggal(data.tgl_mulai));
            $('#tgl_akhir').text(konversiFormatTanggal(data.tgl_akhir));
            $('#status').text(data.status == 0 ? 'Sedang Dimohon' : 'Disetujui');
            $('#srt_mohon').attr('href', data.srt_mohon);

            $('#jadwal_mulai').val(data.tgl_mulai)
            $('#jadwal_mulai_time').val(data.jam_mulai)
            $('#jadwal_akhir').val(data.tgl_akhir)
            $('#jadwal_akhir_time').val(data.jam_akhir)
            $('#id_aset_select').val(data.id_aset)
            $('#id_mohon_select').val(data.id_mohon)

            // Tentukan teks berdasarkan nilai aksi
            var titleText = '';
            var buttonText = '';

            if (aksi == 1) {
                titleText = 'Ajukan Verifikasi Permohonan';
                buttonText = 'Ajukan Verifikasi';
            } else if (aksi == 2) {
                titleText = 'Setujui Permohonan';
                buttonText = 'Setujui';
            } else if (aksi == 4) {
                titleText = 'Tolak Permohonan';
                buttonText = 'Tolak';
            }

            // Set teks untuk #title-aksi dan #btn-aksi
            $('#title-aksi').text(titleText);
            $('#btn-aksi').text(buttonText);

            $('#status_mohon').val(aksi);

            if (aksi != 4) {
                $('#note_reject').hide(); // Sembunyikan textarea jika aksi bukan 4
                $('#simpan-form').show(); // Sembunyikan textarea jika aksi bukan 4
            } else {
                $('#note_reject').show();
                $('#simpan-form').hide();  // Tampilkan textarea jika aksi adalah 4
            }
            $('#modalPinjam').modal('show')

        },
        error: function () {

            Swal.fire('Gagal!', 'Terjadi kesalahan .', 'error');
        }
    });


}

function showPermohonan(id) {

    console.log(userRole)
    $('#tblPermohonanAset').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bInfo": true,
        "bAutoWidth": false,

        "order": [
            [0, 'asc']
        ],
        "language": {
            "lengthMenu": "Tampilkan&nbsp;   _MENU_  &nbsp;item per halaman",
            "zeroRecords": "Tidak ada data yang ditampilkan",
            "info": "Menampilkan Halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data yang ditampilkan",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "search": "Cari&nbsp;",
            "paginate": {
                "first": "Awal",
                "last": "Akhir",
                "next": ">",
                "previous": "<"
            },
        },
        "displayLength": 25,
        ajax: {
            url: BASE_URL + "/admin/getAsetMohon/" + id,

        },
        "columns": [{
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left">' + data.id + '</div>'
            }
        },


        {
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left">' + data.name + '</div>'
            }
        },


        {
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left">' + konversiFormatTanggal(data.tgl_mulai) +
                    '</div>'
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left">' + konversiFormatTanggal(data.tgl_akhir) +
                    '</div>'
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                return '<div class="text-center"><a  class="btn btn-primary" target="_blank" href="' + data.srt_mohon +
                    '"> Lihat</a></div>'
            }
        },
        {

            "orderable": false,
            "data": function (data,) {
                return `<div class="text-center">
                        <button class="btn btn-success btn-sm" onClick="modalPinjam(this)"  data-id="${data.id}" data-idmohon="${data.id_mohon}" data-aksi="1">Ajukan Verifikasi</button>
                        <button class="btn btn-danger btn-sm"  onClick="modalPinjam(this)"  data-id="${data.id}" data-idmohon="${data.id_mohon}" data-aksi="4">Tolak</button>
                                                      
                        </div>`
            }
        },
        ],
        "columnDefs": [{
            "targets": 5, // Indeks kolom "Aksi"
            "visible": userRole !==
                'verifikator', // Sembunyikan kolom "Aksi" jika role adalah stakeholder
            "searchable": false
        }],
        rowCallback: function (row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
        },
    });
}

function showPermohonanVerif(id) {
   

    $('#tblPermohonanAsetVerif').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bInfo": true,
        "bAutoWidth": false,
        "columnDefs": [{
            "visible": false,
        }],
        "order": [
            [0, 'asc']
        ],
        "language": {
            "lengthMenu": "Tampilkan&nbsp;   _MENU_  &nbsp;item per halaman",
            "zeroRecords": "Tidak ada data yang ditampilkan",
            "info": "Menampilkan Halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data yang ditampilkan",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "search": "Cari&nbsp;",
            "paginate": {
                "first": "Awal",
                "last": "Akhir",
                "next": ">",
                "previous": "<"
            },
        },
        "displayLength": 25,
        ajax: {
            url: BASE_URL + "/admin/get-data-mohon-verif/" + id,

        },
        "columns": [{
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left">' + data.id + '</div>'
            }
        },


        {
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left">' + data.name + '</div>'
            }
        },




        {
            "orderable": false,
            "data": function (data) {
                return '<a  class="btn btn-primary" target="_blank" href="' + data.srt_mohon +
                    '"> Lihat</a>'
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left">' + konversiFormatTanggal(data
                    .tgl_mulai_accept) +
                    '<br>' + data.jam_mulai_accept + '</div>'
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left">' + konversiFormatTanggal(data
                    .tgl_akhir_accept) +
                    '<br>' + data.jam_akhir_accept + '</div>'
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left">' + (data.reschedule ? 'Reschedule' : 'Tidak') +
                    '</div>';
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left"><small>' + konversiFormatTanggal(data
                    .date_verif_date) +
                    '<br>' + data.date_verif_time + '</small></div>'
            }
        },
        {

            "orderable": false,
            "data": function (data,) {

                return `<div class="dropdown">
                                                    <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                                        <ul class="link-list-plain">
                                                            <li><a href="javascript:void(0)" onClick="modalPinjam(this)"  data-id="${data.id}" data-idmohon="${data.id_mohon}" data-aksi="2">Setuju</a></li>
                                                            <li><a href="javascript:void(0)" onClick="modalPinjam(this)"  data-id="${data.id}" data-idmohon="${data.id_mohon}" data-aksi="4">Tolak</a></li>
                                                        </ul>
                                                    </div>
                                                </div>`




            }
        },
        ],
        "columnDefs": [{
            "targets": 7, // Indeks kolom "Aksi"
            "visible": userRole !==
                'opd', // Sembunyikan kolom "Aksi" jika role adalah stakeholder
            "searchable": false
        }],
        rowCallback: function (row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
        },
    });
}

function showPermohonanReject(id) {
    var userRole =
        "{{ auth()->user()->role }}"; // Anda bisa mengganti ini dengan cara lain untuk mendapatkan role

    $('#tblPermohonanAsetReject').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bInfo": true,
        "bAutoWidth": false,
        "columnDefs": [{
            "visible": false,
        }],
        "order": [
            [0, 'asc']
        ],
        "language": {
            "lengthMenu": "Tampilkan&nbsp;   _MENU_  &nbsp;item per halaman",
            "zeroRecords": "Tidak ada data yang ditampilkan",
            "info": "Menampilkan Halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data yang ditampilkan",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "search": "Cari&nbsp;",
            "paginate": {
                "first": "Awal",
                "last": "Akhir",
                "next": ">",
                "previous": "<"
            },
        },
        "displayLength": 25,
        ajax: {
            url: BASE_URL + "/admin/get-data-mohon-reject/" + id,

        },
        "columns": [{
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left">' + data.id + '</div>'
            }
        },


        {
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left">' + data.name + '</div>'
            }
        },




        {
            "orderable": false,
            "data": function (data) {
                return '<a  class="btn btn-primary" target="_blank" href="' + data.srt_mohon +
                    '"> Lihat</a>'
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left">' + konversiFormatTanggal(data
                    .tgl_mulai) +
                    '<br>' + data.jam_mulai + '</div>'
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left">' + konversiFormatTanggal(data
                    .tgl_akhir) +
                    '<br>' + data.jam_akhir + '</div>'
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left">' + data.note_reject + '</div>'
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left"><small>' + konversiFormatTanggal(data
                    .date_reject_date) +
                    '<br>' + data.date_reject_time + '</small></div>'
            }
        },

        ],
        // "columnDefs": [{
        //     "targets": 7, // Indeks kolom "Aksi"
        //     "visible": userRole !==
        //         'stakeholder', // Sembunyikan kolom "Aksi" jika role adalah stakeholder
        //     "searchable": false
        // }],
        rowCallback: function (row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
        },
    });
}

function showPermohonanAccept(id) {
    var userRole =
        "{{ auth()->user()->role }}"; // Anda bisa mengganti ini dengan cara lain untuk mendapatkan role

    $('#tblPermohonanAsetAccept').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        "bPaginate": false,
        "bLengthChange": false,
        "bFilter": false,
        "bInfo": false,
        "bAutoWidth": true,
        "columnDefs": [{
            "visible": false,
        }],
        "order": [
            [0, 'asc']
        ],
        "language": {
            "lengthMenu": "Tampilkan&nbsp;   _MENU_  &nbsp;item per halaman",
            "zeroRecords": "Tidak ada data yang ditampilkan",
            "info": "Menampilkan Halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data yang ditampilkan",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "search": "Cari&nbsp;",
            "paginate": {
                "first": "Awal",
                "last": "Akhir",
                "next": ">",
                "previous": "<"
            },
        },
        "displayLength": 25,
        ajax: {
            url: BASE_URL + "/admin/get-data-mohon-accept/" + id,

        },
        "columns": [{
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left">' + data.id + '</div>'
            }
        },


        {
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left">' + data.name + '</div>'
            }
        },




        {
            "orderable": false,
            "data": function (data) {
                return '<a  class="btn btn-primary" target="_blank" href="' + data.srt_mohon +
                    '"> Lihat</a>'
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left"><small>' + konversiFormatTanggal(data
                    .tgl_mulai_accept) +
                    '<br>' + data.jam_mulai_accept + '</small></div>'
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left"><small>' + konversiFormatTanggal(data
                    .tgl_akhir_accept) +
                    '<br>' + data.jam_akhir_accept + '</small></div>'
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left">' + (data.reschedule ? 'Reschedule' : 'Tidak') +
                    '</div>';
            }
        },

        {

            "orderable": false,
            "data": function (data,) {

                return `<button class="btn btn-success btn-sm" onclick="finishAset(this)"  data-idmohon="${data.id_mohon}">Selesaikan Pinjam</button>`




            }
        },
        ],
        // "columnDefs": [{
        //     "targets": 7, // Indeks kolom "Aksi"
        //     "visible": userRole !==
        //         'stakeholder', // Sembunyikan kolom "Aksi" jika role adalah stakeholder
        //     "searchable": false
        // }],
        rowCallback: function (row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
        },
    });
}

function showPermohonanFinish(id) {
    var userRole =
        "{{ auth()->user()->role }}"; // Anda bisa mengganti ini dengan cara lain untuk mendapatkan role

    $('#tblPermohonanAsetFinish').DataTable({
        processing: true,
        serverSide: true,
        destroy: true,
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bInfo": true,
        "bAutoWidth": false,
        "columnDefs": [{
            "visible": false,
        }],
        "order": [
            [0, 'asc']
        ],
        "language": {
            "lengthMenu": "Tampilkan&nbsp;   _MENU_  &nbsp;item per halaman",
            "zeroRecords": "Tidak ada data yang ditampilkan",
            "info": "Menampilkan Halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data yang ditampilkan",
            "infoFiltered": "(filtered from _MAX_ total records)",
            "search": "Cari&nbsp;",
            "paginate": {
                "first": "Awal",
                "last": "Akhir",
                "next": ">",
                "previous": "<"
            },
        },
        "displayLength": 25,
        ajax: {
            url: BASE_URL + "/admin/getAsetMohonFinish/" + id,

        },
        "columns": [{
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left">' + data.id + '</div>'
            }
        },


        {
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left">' + data.name + '</div>'
            }
        },




        {

            "orderable": false,
            "data": function (data,) {
                return '<a href="' + data.srt_mohon +
                    '" class="btn btn-secondary" target="_blank">Lihat</a>'
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left">' + konversiFormatTanggal(data
                    .tgl_mulai_accept) +
                    '<br>' + data.jam_mulai_accept + '</div>'
            }
        },
        {
            "orderable": false,
            "data": function (data) {
                return '<div class="text-left">' + konversiFormatTanggal(data
                    .tgl_akhir_accept) +
                    '<br>' + data.jam_akhir_accept + '</div>'
            }
        },
        {
            "orderable": false,
            "data": function (data) {


                var html =
                    `<small>Diterima : ${konversiFormatTanggal(data.date_verif_date)} ${data.date_verif_time}</small><br>
                            <small>Diverifikasi :  ${konversiFormatTanggal(data.date_verif_date)} ${data.date_verif_time}</small>
                                <br><small>Diselesaikan :  ${konversiFormatTanggal(data.date_finish_date)} ${data.date_finish_time}</small>`

                return html;
            }
        },
        ],
        // "columnDefs": [{
        //     "targets": 7, // Indeks kolom "Aksi"
        //     "visible": userRole !==
        //         'stakeholder', // Sembunyikan kolom "Aksi" jika role adalah stakeholder
        //     "searchable": false
        // }],
        rowCallback: function (row, data, iDisplayIndex) {
            var info = this.fnPagingInfo();
            var page = info.iPage;
            var length = info.iLength;
            var index = page * length + (iDisplayIndex + 1);
            $('td:eq(0)', row).html(index);
        },
    });
}

$('#formAcceptAset').on('submit', function (e) {
    e.preventDefault();
    var postData = new FormData($("#formAcceptAset")[0]);
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    postData.append('_token', csrfToken);
    var rescheduleStatus = $('#reschedule').is(':checked') ? 1 : 0;
    console.log(postData.get('reschedule'));
    $.ajax({
        type: "post",
        url: BASE_URL + "/admin/accept-aset",
        processData: false,
        contentType: false,
        data: postData,
        dataType: "JSON",
        success: function (data) {
            console.log(data); // Debugging log

            if (data.success == false) {
                toastr.clear();

                // Menampilkan error, jika ada, langsung menampilkan string error atau pesan umum
                if (data.errors && Array.isArray(data.errors) && data.errors.length > 0) {
                    // Ambil error pertama dari array dan tampilkan
                    NioApp.Toast('<h5>Gagal Simpan Data</h5><p class="text-danger">' + data
                        .errors[0] + '</p>', 'error');
                } else {
                    // Jika tidak ada errors, tampilkan pesan 'message'
                    NioApp.Toast('<h5>Gagal Simpan Data</h5><p class="text-danger">' + data
                        .message + '</p>', 'error');
                }
            } else if (data.success == true) {
                var id = $('#id_aset_mohon').val()
                Swal.fire('Berhasil', 'Data telah disimpan', 'success');

                refreshData()
                // $("#formAcceptAset")[0].reset();
                $('#modalPinjam').modal('hide');
            }
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText); // Log error di console
            Swal.fire('Error!', 'Terjadi kesalahan server.', 'error');
        }
    });

    return false;
});

function showASetId(id) {
    $.ajax({
        url: BASE_URL + '/admin/getDataAsetId/' + id,
        type: "GET",

        success: function (response) {
            var data = typeof response === "string" ? JSON.parse(response) : response;

            // Set data to table fields
            $('#img_aset').attr('src', data.img);

            if (data.status == 0) {

                $('#status_aset_alert').html(' <h6>Status : Tersedia</h6>');


            } else if (data.status == 1) {

                $('#status_aset_alert').html(' <h6 class="text-danger">Status : Pemeliharaan</h6>');
            }
        },
        error: function () {

            Swal.fire('Gagal!', 'Terjadi kesalahan .', 'error');
        }
    });
}


function showAStatus(id) {
    $.ajax({
        url: BASE_URL + '/admin/get-data-status/' + id,
        type: "GET",

        success: function (response) {
            var data = typeof response === "string" ? JSON.parse(response) : response;

            console.log()

            $('#status-0').html('<span class="badge bg-secondary">' + data.sedang_dimohon + '</span>');
            $('#status-1').html('<span class="badge bg-info">' + data.dalam_verifikasi + '</span>');
            $('#status-2').html('<span class="badge bg-success">' + data.disetujui + '</span>');
            $('#status-3').html('<span class="badge bg-primary">' + data.selesai + '</span>');
            $('#status-4').html('<span class="badge bg-danger">' + data.ditolak + '</span>');

        },
        error: function () {

            Swal.fire('Gagal!', 'Terjadi kesalahan .', 'error');
        }
    });
}

function finishAset(elem) {

    var id_mohon = $(elem).data("idmohon");


    var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Ambil token CSRF

    var title = "Selesaikan Status Pinjam"
    var msg = ""

    Swal.fire({
        title: title,
        text: '',
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Ya'
    }).then(function (result) {
        if (result.value) {
            $.ajax({
                url: BASE_URL + '/admin/finishAset/' + id_mohon,
                type: "POST",
                data: {
                    _token: csrfToken, // Sertakan token CSRF di sini
                },
                success: function (data) {
                    Swal.fire('Berhasil!', msg, 'success');
                    refreshData()


                },
                error: function () {

                    Swal.fire('Gagal!', 'Terjadi kesalahan .', 'error');
                }
            });

        }
    });
}