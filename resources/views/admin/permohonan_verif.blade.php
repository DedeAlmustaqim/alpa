@extends('layout.app')

@section('content')
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">{{ $title }}</h3>
            </div><!-- .nk-block-head-content -->
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em
                            class="icon ni ni-more-v"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">

                    </div>
                </div>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div>
    <div class="card card-bordered card-preview">

        <div class="card-inner full-width">



            <hr>
            <div class="table-responsive">
                <table width="100%" class="table table-bordered wrap" id="tblPermohonanAsetVerifAll">
                    <thead class="table-light text-center">
                        <tr>

                            <th width="5%">No</th>

                            <th width="12%">Pemohon</th>
                            <th width="12%"> Nama Aset</th>
                            <th>Foto Aset</th>
                            <th>Mulai - Berakhir<br>
                                Pengajuan Pemohon</th>
                            <th>Mulai - Berakhir<br>
                                disetujui</th>
                            <th>Surat Permohonan</th>
                            <th width="12%">Tgl diajukan</th>

                            <th width="5%"> </th>

                        </tr>
                    </thead>

                </table>
            </div>

        </div>
    </div>
    <div class="modal fade" id="modalPinjam" tabindex="-1" aria-labelledby="modalPinjamLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPinjamLabel">Detail Pinjaman Aset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-inner">
                            <div class="card-head">
                                <h5 class="card-title">Informasi Permohonan</h5>
                            </div>
                            <table class="table table-bordered">
                                <tbody>

                                    <tr>
                                        <th>Nama Pemohon</th>
                                        <td id="name_pemohon"></td>
                                    </tr>


                                    <tr>
                                        <th>Tgl Pengajuan Mulai</th>
                                        <td id="tgl_mulai"></td>
                                    </tr>
                                    <tr>
                                        <th>Tgl Pengajuan Akhir</th>
                                        <td id="tgl_akhir"></td>
                                    </tr>
                                    <tr>
                                        <th>Catatan</th>
                                        <td id="catatan"></td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td id="status"></td>
                                    </tr>
                                    <tr>
                                        <th>Surat Mohon</th>
                                        <td><a id="srt_mohon" class="btn btn-info btn-sm" target="_blank">Lihat Surat
                                                Mohon</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <hr>
                            <div class="card-head">
                                <h5 class="card-title" id="title-aksi"></h5>
                            </div>
                            <form id="formAcceptAset" class="gy-3" method="POST">
                                <input type="text" hidden id="id_aset_select" name="id_aset_select">
                                <input type="text" hidden id="id_mohon_select" name="id_mohon_select">
                                <div id="simpan-form">
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label class="form-label" for="site-name">Tanggal Mulai</label>
                                                <span class="form-note">Jadwal pengajuan mulai oleh pemohon</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <input type="date" id="jadwal_mulai" name="jadwal_mulai"
                                                                readonly class="form-control input-disabled">
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">

                                                                <div class="form-control-wrap">
                                                                    <input type="text" id="jadwal_mulai_time"
                                                                        name="jadwal_mulai_time"
                                                                        class="form-control input-disabled" readonly
                                                                        required pattern="[0-9]{2}:[0-9]{2}"
                                                                        title="Format waktu harus HH:mm">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label class="form-label" for="site-name">Tanggal Akhir</label>
                                                <span class="form-note">Jadwal pengajuan berakhir oleh pemohon</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <input type="date" id="jadwal_akhir" name="jadwal_akhir"
                                                                readonly class="form-control input-disabled ">
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">

                                                                <div class="form-control-wrap">
                                                                    <input type="text" id="jadwal_akhir_time"
                                                                        name="jadwal_akhir_time"
                                                                        class="form-control input-disabled" readonly
                                                                        required pattern="[0-9]{2}:[0-9]{2}"
                                                                        title="Format waktu harus HH:mm">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label class="form-label" for="site-off">Reschedule Jadwal Pinjam</label>
                                                <span class="form-note">Ubah jadwal Pinjam Pemohon.</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                    <input type="hidden" name="reschedule" value="0">

                                                    <input type="checkbox" class="custom-control-input" id="reschedule"
                                                        value="1" name="reschedule">
                                                    <label class="custom-control-label"
                                                        for="reschedule">Reschedule</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label" for="site-off">Alasan ditolak</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <textarea class="form-control" name="note_reject" id="note_reject" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>

                        </div>
                    </div>
                    <input hidden type="text" id="status_mohon" name="status_mohon">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><span id="btn-aksi"></span></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            showPermohonan()

            $('#modalAddAset').on('hidden.bs.modal', function() {
                // Reset form ketika modal ditutup
                $("#formAddAset")[0].reset();
            });

            $('#reschedule').change(function() {
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


        function modalAset() {
            $('#modalAset').modal('show')
        }

        function showPermohonan() {
            var userRole =
                "{{ auth()->user()->role }}"; // Anda bisa mengganti ini dengan cara lain untuk mendapatkan role

            $('#tblPermohonanAsetVerifAll').DataTable({
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
                    url: BASE_URL + "/admin/permohonan-verif-all-data",

                },
                "columns": [{
                        "orderable": false,
                        "data": function(data) {
                            return '<div class="text-left">' + data.id + '</div>'
                        }
                    },

                    {
                        "orderable": false,
                        "data": function(data) {
                            return `<span class="tb-product">
                                                            
                                                            <span class="title">` + data.name + `</span>
                                                        </span>`
                        }
                    },
                    {
                        "orderable": false,
                        "data": function(data) {
                            return '<div class="text-left">' + data.nama_aset + '</div>'
                        }
                    },
                    {
                        "orderable": false,
                        "data": function(data) {
                            return '<div class="text-center"><img align="center" src="' + data.img +
                                '" width="100px" alt="" class="thumb"></div>'
                        }
                    },
                    {
                        "orderable": false,
                        "data": function(data) {

                            return '<span class="text-center">' + status +
                                '<span class="badge bg-info">' + konversiFormatTanggal(
                                    data.tgl_mulai) + ' ' + data.jam_mulai +
                                '</span><br><span class="badge bg-danger">' + konversiFormatTanggal(
                                    data.tgl_akhir) + ' ' + data.jam_akhir + '</span></div>';
                        }
                    },
                    {
                        "orderable": false,
                        "data": function(data) {
                            var reschedule_mohon = data.reschedule_mohon == 0 ?
                                '<span class="badge bg-success">Tanpa Reshedule</span>' :
                                '<span class="badge bg-warning">Reschedule</span>';
                            return '<span class="text-center">' + status +
                                '<span class="badge bg-info">' + konversiFormatTanggal(
                                    data.tgl_mulai_accept) + ' ' + data.jam_mulai_accept +
                                '</span><br><span class="badge bg-danger">' + konversiFormatTanggal(
                                    data.tgl_akhir_accept) + ' ' + data.jam_akhir_accept +
                                '</span><span class="text-center">' + status +
                                ' ' + reschedule_mohon + '</div>';
                        }
                    },
                    {

                        "orderable": false,
                        "data": function(data, ) {
                            return '<div class="text-center"><a href="' + data.srt_mohon +
                                '" class="btn btn-secondary" target="_blank">Lihat</a></div>'
                        }
                    },
                    {
                        "orderable": false,
                        "data": function(data) {
                            return '<div class="text-left"><small>' + konversiFormatTanggal(data
                                    .date_verif_date) +
                                '<br>' + data.date_verif_time + '</small></div>'
                        }
                    },
                    {

                        "orderable": false,
                        "data": function(data, ) {

                            return `<div class="dropdown">
                                        <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                            <ul class="link-list-plain">
                                                <li><a href="` + BASE_URL +
                                `/admin/permohonan_detail/` + data.id + `" data-id="` +
                                data.id +
                                `" >Kelola</a></li>
                                                <li><a href="javascript:void(0)" onClick="modalPinjam(this)"  data-id="${data.id}" data-idmohon="${data.id_mohon}" data-aksi="2">Setuju</a></li>
                                                <li><a href="javascript:void(0)" onClick="modalPinjam(this)"  data-id="${data.id}" data-idmohon="${data.id_mohon}" data-aksi="4">Tolak</a></li>
                                            </ul>
                                        </div>
                                    </div>`




                        }
                    },

                ],
                // "columnDefs": [{
                //     "targets": 7, // Indeks kolom "Aksi"
                //     "visible": userRole !==
                //         'stakeholder', // Sembunyikan kolom "Aksi" jika role adalah stakeholder
                //     "searchable": false
                // }],
                rowCallback: function(row, data, iDisplayIndex) {
                    var info = this.fnPagingInfo();
                    var page = info.iPage;
                    var length = info.iLength;
                    var index = page * length + (iDisplayIndex + 1);
                    $('td:eq(0)', row).html(index);
                },
            });
        }

        function modalPinjam(elem) {
            var id_aset = $(elem).data("id");
            var id_mohon = $(elem).data("idmohon");
            var aksi = $(elem).data("aksi");
            $('#id_aset_setuju').val(id_aset)
            $.ajax({
                url: BASE_URL + '/admin/getDataMohon/' + id_mohon,
                type: "GET",

                success: function(response) {
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
                        $('#simpan-form').hide(); // Tampilkan textarea jika aksi adalah 4
                    }
                    $('#modalPinjam').modal('show')

                },
                error: function() {

                    Swal.fire('Gagal!', 'Terjadi kesalahan .', 'error');
                }
            });


        }
        $('#formAcceptAset').on('submit', function(e) {
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
                success: function(data) {
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

                        showPermohonan()
                        // $("#formAcceptAset")[0].reset();
                        $('#modalPinjam').modal('hide');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText); // Log error di console
                    Swal.fire('Error!', 'Terjadi kesalahan server.', 'error');
                }
            });

            return false;
        });


        function deleteAset(elem) {
            var id = $(elem).data("id");

            var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Ambil token CSRF

            var title = "Hapus"
            var msg = "Hapus Aset"

            Swal.fire({
                title: title,
                text: '',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Ya'
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: BASE_URL + '/admin/del-aset/' + id,
                        type: "POST",
                        data: {
                            _token: csrfToken, // Sertakan token CSRF di sini
                        },
                        success: function(data) {
                            Swal.fire('Berhasil!', msg, 'success');
                            $('#tblAset').DataTable().ajax.reload(null, false);

                        },
                        error: function() {

                            Swal.fire('Gagal!', 'Terjadi kesalahan .', 'error');
                        }
                    });

                }
            });
        }
    </script>
@endpush
