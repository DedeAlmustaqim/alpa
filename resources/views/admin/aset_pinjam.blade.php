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


            <div class="table-responsive">
                <table width="100%" class="table table-bordered wrap" id="tblAsetPinjam">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th width="15%">Nama Aset</th>
                            <th width="10%">Foto</th>
                            <th>NIB</th>
                            <th>Kategori</th>
                            <th>Jumlah Peminjam</th>
                            <th>Unit Kerja</th>
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
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            showAsetPinjam()

        });



        function showAsetPinjam() {
            var userRole =
                "{{ auth()->user()->role }}"; // Anda bisa mengganti ini dengan cara lain untuk mendapatkan role

            $('#tblAsetPinjam').DataTable({
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
                    url: BASE_URL + "/admin/get-aset-pinjam-data",

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
                                                            
                                                            <span class="title">` + data.nama_aset + `</span>
                                                        </span>`
                        }
                    },
                    {
                        "orderable": false,
                        "data": function(data) {
                            return '<div class="text-left"><img src="' + data.img +
                                '" width="100px" alt="" class="thumb"></div>'
                        }
                    },
                    {
                        "orderable": false,
                        "data": function(data) {
                            return '<div class="text-left">' + data.nib_aset + '</div>'
                        }
                    },
                    {
                        "orderable": false,
                        "data": function(data) {
                            return '<div class="text-left">' + data.kategori + '</div>'
                        }
                    },
                    // Kolom status dan tanggal
                    {
                        "orderable": false,
                        "data": function(data) {
                            return '<div class="text-left">' + data.dipinjam + '</div>'
                        }
                    },

                   



                    {
                        "orderable": false,
                        "data": function(data) {
                            return '<div class="text-left">' + data.nm_unit	 + '</div>'
                        }
                    },
                    {

                        "orderable": false,
                        "data": function(data, ) {
                            return `<a class="btn btn-secondary" href="` + BASE_URL +
                                `/admin/permohonan_detail/` + data.id + `" data-id="` +
                                data.id +
                                `"><em class="icon ni ni-edit"></em><span>Kelola</span></a>`
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
                    // Update countdown setiap detik
                    
                },
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
                            showAsetPinjam()



                        },
                        error: function() {

                            Swal.fire('Gagal!', 'Terjadi kesalahan .', 'error');
                        }
                    });

                }
            });
        }

        function detailPeminjam(elem) {
            var id = $(elem).data("id");


            $.ajax({
                url: BASE_URL + '/admin/getDataMohon/' + id,
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
    </script>
@endpush
