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
                <table width="100%" class="table table-bordered wrap" id="tblPermohonanAsetRejectAll">
                    <thead class="table-light text-center">
                        <tr>

                            <th width="5%">No</th>
                            <th width="18%">Pemohon</th>
                            <th width="18%">Aset</th>
                            <th>Surat Permohonan</th>
                            <th>Mulai - Berakhir </th>
                            <th>Alasan ditolak</th>
                            <th>Ditolak pada</th>


                        </tr>
                    </thead>

                </table>
            </div>

        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            showPermohonan()


        });




        function showPermohonan() {
            var userRole =
                "{{ auth()->user()->role }}"; // Anda bisa mengganti ini dengan cara lain untuk mendapatkan role

            $('#tblPermohonanAsetRejectAll').DataTable({
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
                    url: BASE_URL + "/admin/permohonan-reject-all-data",

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
                            return '<div class="text-center"><img align="center" src="' + data.img +
                                '" width="100px" alt="" class="thumb"><br>' + data.nama_aset + '</div>'
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
                            return `<span class="tb-product">
                                                            
                                                            <span class="title">` + data.note_reject + `</span>
                                                        </span>`
                        }
                    },
                    {
                        "orderable": false,
                        "data": function(data) {



                            return konversiFormatTanggal(data.date_reject_date) + '' + data.date_reject_time;
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

        $('#formAddAset').on('submit', function(e) {
            e.preventDefault();
            var postData = new FormData($("#formAddAset")[0]);
            var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Ambil token CSRF
            postData.append('_token', csrfToken); // Sertakan token CSRF di FormData
            $.ajax({
                type: "post",
                url: BASE_URL + "/admin/aset", // Pastikan BASE_URL diatur dengan benar
                processData: false,
                contentType: false,
                data: postData,
                dataType: "JSON",
                success: function(data) {
                    if (data.success == false) {
                        toastr.clear();
                        data.errors.forEach(function(error) {
                            // Karena error adalah string, kita bisa langsung menampilkannya
                            NioApp.Toast('<h5>Gagal Simpan Data</h5><p class="text-danger">' +
                                error + '</p>', 'error');
                        });
                    } else if (data.success == true) {
                        Swal.fire('Berhasil', 'Data telah disimpan', 'success');
                        showAset()
                        $("#formAddAset")[0].reset();
                        $('#modalAddAset').modal('hide');
                    }
                },

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
