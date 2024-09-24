@extends('layout.app')

@section('content')
    <style>
        /* Gaya untuk input yang dinonaktifkan */
        .input-disabled {
            background-color: #e9ecef;
            /* Warna abu-abu muda */
            cursor: not-allowed;
        }
    </style>
    <input type="text" hidden name="id_aset_mohon" id="id_aset_mohon" value="{{ $aset->id }}">
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
    <div class="card">
        <div class="card-inner">
            <div class="row pb-5">
                <div class="col-lg-4">

                    <div class="product-thumb">

                        <img class="card-img-top" alt="" id="img_aset">



                    </div>
                    <hr>
                    <div class="example-alerts mb-2">
                        <div class="example-alert">
                            <div class="alert alert-primary alert-icon">
                                <div id="status_aset_alert"></div>
                                <em class="icon ni ni-alert-circle"></em>
                            </div>
                        </div>


                    </div>
                    <div class="alert alert-warning alert-icon">
                        <h6>Pilih Peminjam Aset dari daftar Pemohon</h6>
                        <em class="icon ni ni-alert-circle"></em>
                        <ul>
                            <li><strong>Penting </strong> Hanya bisa dipilih salah satu</li>
                            <li>Selesaikan status pinjam untuk memilih lagi pemohon</li>
                        </ul>

                    </div>
                </div><!-- .col -->
                <div class="col-lg-8">
                    <div class="product-info mt-5 me-xxl-5">
                        <h4 class="product-price text-primary">{{ $aset->kategori }}</small>
                        </h4>
                        <h2 class="product-title">{{ $aset->nama_aset }}</h2>
                        <p class="">{{ $aset->nm_unit }}</p>

                        <div class="product-excrept text-soft">
                            <p class="lead">Deksripsi : {{ $aset->deskripsi }}</p>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <div id="showPeminjamDesc"></div>

                            </div>

                        </div>




                    </div><!-- .product-info -->
                </div><!-- .col -->
                <div class="col-lg-3">



                </div><!-- .col -->
            </div><!-- .row -->
            <div class="row">
                <div class="card card-bordered card-preview">
                    <div class="card-inner">
                        <ul class="nav nav-tabs mt-n3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#tabItem1" aria-selected="true"
                                    role="tab">Daftar Permohonan</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#tabItem2" aria-selected="false"
                                    tabindex="-1" role="tab">Pinjaman Selesai</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#tabItem3" aria-selected="false"
                                    tabindex="-1" role="tab">Permohonan ditolak</a>
                            </li>

                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabItem1" role="tabpanel">
                                <div class="table-responsive">
                                    <table width="100%" class="table table-bordered wrap" id="tblPermohonanAset">
                                        <thead class="table-light text-center">
                                            <tr>

                                                <th width="5%">No</th>

                                                <th width="18%">Pemohon</th>
                                                <th width="18%">Mulai</th>
                                                <th width="18%">Berakhir</th>
                                                <th width="18%">Surat Permohonan</th>
                                                <th width="5%"> </th>

                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabItem2" role="tabpanel">
                                <div class="table-responsive">
                                    <table width="100%" class="table table-bordered wrap" id="tblPermohonanAsetFinish">
                                        <thead class="table-light text-center">
                                            <tr>

                                                <th width="5%">No</th>

                                                <th width="18%">Pemohon</th>
                                                <th>Mulai</th>
                                                <th> Berakhir</th>
                                                <th>Surat Permohonan</th>

                                                <th>Mulai (disetujui)</th>
                                                <th>Berakhir (disetujui)</th>
                                                <th width="5%"> </th>

                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabItem3" role="tabpanel">
                                <p>Fugiat id quis dolor culpa eiusmod anim velit excepteur proident dolor aute qui magna. Ad
                                    proident laboris ullamco esse anim Lorem Lorem veniam quis Lorem irure occaecat velit
                                    nostrud magna nulla. Velit et et proident Lorem do ea tempor officia dolor.
                                    Reprehenderit Lorem aliquip labore est magna commodo est ea veniam consectetur.</p>
                            </div>

                        </div>
                    </div>
                </div>

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
                                <h5 class="card-title">Setujui Permohonan</h5>
                            </div>
                            <form id="formAcceptAset" class="gy-3" method="POST">
                                <input type="text" id="id_aset_select" name="id_aset_select">
                                <input type="text" id="id_mohon_select" name="id_mohon_select">
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
                                                                    class="form-control input-disabled" readonly required
                                                                    pattern="[0-9]{2}:[0-9]{2}"
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
                                                                    class="form-control input-disabled" readonly required
                                                                    pattern="[0-9]{2}:[0-9]{2}"
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
                                                <label class="custom-control-label" for="reschedule">Reschedule</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Kirim</button>
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

            $('.time-picker').timepicker({
                'timeFormat': 'H:i'
            });



            var id = $('#id_aset_mohon').val()
            showASetId(id)
            showPermohonan(id)
            showPermohonanFinish(id)

            $('#modalPinjam').on('hidden.bs.modal', function() {
                // Reset form ketika modal ditutup

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


        function modalPinjam(elem) {
            var id_aset = $(elem).data("id");
            var id_mohon = $(elem).data("idmohon");
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
                    $('#modalPinjam').modal('show')

                },
                error: function() {

                    Swal.fire('Gagal!', 'Terjadi kesalahan .', 'error');
                }
            });


        }

        function showPermohonan(id) {
            var userRole =
                "{{ auth()->user()->role }}"; // Anda bisa mengganti ini dengan cara lain untuk mendapatkan role

            $('#tblPermohonanAset').DataTable({
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
                    url: BASE_URL + "/admin/getAsetMohon/" + id,

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
                            return '<div class="text-left">' + data.name + '</div>'
                        }
                    },


                    {
                        "orderable": false,
                        "data": function(data) {
                            return '<div class="text-left">' + konversiFormatTanggal(data.tgl_mulai) +
                                '</div>'
                        }
                    },
                    {
                        "orderable": false,
                        "data": function(data) {
                            return '<div class="text-left">' + konversiFormatTanggal(data.tgl_akhir) +
                                '</div>'
                        }
                    },
                    {
                        "orderable": false,
                        "data": function(data) {
                            return '<a  class="btn btn-primary" target="_blank" href="' + data.srt_mohon +
                                '"> Lihat</a>'
                        }
                    },
                    {

                        "orderable": false,
                        "data": function(data, ) {
                            return '<button class="btn btn-success" onClick="modalPinjam(this)"  data-id="' +
                                data.id_aset +
                                '" data-idmohon="' + data.id_mohon + '"> Setujui </button>'
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
                        "data": function(data) {
                            return '<div class="text-left">' + data.id + '</div>'
                        }
                    },


                    {
                        "orderable": false,
                        "data": function(data) {
                            return '<div class="text-left">' + data.name + '</div>'
                        }
                    },


                    {
                        "orderable": false,
                        "data": function(data) {
                            return '<div class="text-left">' + konversiFormatTanggal(data.tgl_mulai) +
                                '</div>'
                        }
                    },
                    {
                        "orderable": false,
                        "data": function(data) {
                            return '<div class="text-left">' + konversiFormatTanggal(data.tgl_akhir) +
                                '</div>'
                        }
                    },

                    {

                        "orderable": false,
                        "data": function(data, ) {
                            return '<a href="' + data.srt_mohon +
                                '" class="btn btn-secondary" target="_blank">Lihat</a>'
                        }
                    },
                    {
                        "orderable": false,
                        "data": function(data) {
                            return '<div class="text-left">' + konversiFormatTanggal(data
                                    .tgl_mulai_accept) +
                                '<br>' + data.jam_mulai_accept + '</div>'
                        }
                    },
                    {
                        "orderable": false,
                        "data": function(data) {
                            return '<div class="text-left">' + konversiFormatTanggal(data
                                    .tgl_akhir_accept) +
                                '<br>' + data.jam_akhir_accept + '</div>'
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
                        showPermohonan();
                        showASetId(id)
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

        function showASetId(id) {
            $.ajax({
                url: BASE_URL + '/admin/getDataAsetId/' + id,
                type: "GET",

                success: function(response) {
                    var data = typeof response === "string" ? JSON.parse(response) : response;

                    // Set data to table fields
                    $('#img_aset').attr('src', data.img);

                    if (data.status == 0) {

                        $('#status_aset_alert').html(' <h6>Status : Tersedia</h6>');

                        $('#showPeminjamDesc').html('<span class="badge bg-warning">Belum dipinjamkan</span>')
                    } else if (data.status == 1) {
                        var reschedule = (data.reschedule == 1) ? 'Reschedule' : 'Tidak di Reschedule';

                        var html = `<h6>Status : Dipinjam</h6><h6>` + reschedule + `</h6><span>Mulai :` +
                            konversiFormatTanggal(data.mulai_date) + `-` + data.mulai_time +
                            `</span><br><span>Berakhir :` + konversiFormatTanggal(data.akhir_date) + `-` + data
                            .akhir_time + ` </span>`
                        $('#status_aset_alert').html(html);


                        $.ajax({
                            url: BASE_URL + '/admin/getDataMohon/' + data.id_mohon,
                            type: "GET",

                            success: function(response) {
                                var status = (response.status == 1) ? 'Disetujui' : '';

                                // Set data to table fields
                                var htmlPeminjam = `<table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th colspan="2" class="text-center bg-azure"><h6 class="text-white">Informasi Permohonan disetujui</h6></th>
                                        
                                    </tr>
                                    <tr>
                                        <th>Nama Pemohon</th>
                                        <td>` + response.name + `</td>
                                    </tr>


                                    <tr>
                                        <th>Pengajuan Mulai Pemohon</th>
                                        <td>` + konversiFormatTanggal(response.tgl_mulai) + `  ` + response.jam_mulai + `</td>
                                    </tr>
                                    <tr>
                                        <th>Pengajuan Berakhir Pemohon</th>
                                       <td>` + konversiFormatTanggal(response.tgl_akhir) + `  ` + response.jam_akhir + `</td>
                                    </tr>
                                    <tr>
                                        <th>Catatan</th>
                                        <td>` + response.catatan + `</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>` + status + `</td>
                                    </tr>
                                    <tr>
                                        <th>Surat Mohon</th>
                                        <td><a href="` + response.srt_mohon +
                                    `" class="btn btn-info btn-sm" target="_blank">Lihat Surat
                                                Mohon</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        
                                        <td colspan="2" class="text-center bg-azure"><button class="btn btn-secondary" onClick="finishAset(this)"  data-id="` +
                                    response.id_aset + `" data-idmohon="` + response.id_mohon + `"> Selesaikan Status Pinjam </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>`
                                $('#showPeminjamDesc').html(htmlPeminjam)

                            },
                            error: function() {

                                Swal.fire('Gagal!', 'Terjadi kesalahan .', 'error');
                            }
                        });
                    }
                },
                error: function() {

                    Swal.fire('Gagal!', 'Terjadi kesalahan .', 'error');
                }
            });
        }



        function finishAset(elem) {
            var id = $(elem).data("id");
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
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: BASE_URL + '/admin/finishAset/' + id + '/' + id_mohon,
                        type: "POST",
                        data: {
                            _token: csrfToken, // Sertakan token CSRF di sini
                        },
                        success: function(data) {
                            Swal.fire('Berhasil!', msg, 'success');
                            showPermohonan(id);
                            showPermohonanFinish(id);
                            showASetId(id)
                          


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
