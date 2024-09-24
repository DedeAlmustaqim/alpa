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

            <div class="row m-2">
                <div class="col-3">
                    <a href="javascript:void(0)" data-bs-target="#modalKategori" data-bs-toggle="modal"
                        data-target="addProduct" class="toggle btn btn-primary d-none d-md-inline-flex"><em
                            class="icon ni ni-plus"></em><span>Tambah Kategori</span></a>
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table class="table table-bordered wrap" id="tblKategori">
                    <thead class="table-light text-center">
                        <tr>

                            <th width="5%">No</th>
                            <th>Kategori </th>

                            <th width="5%"> </th>

                        </tr>
                    </thead>

                </table>
            </div>

        </div>
    </div>
    <div class="modal fade" id="modalKategori" tabindex="1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kategori</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form id="formKategori" method="POST" class="form-validate is-alter gy-3">


                        <div class="form-group">
                            <label class="form-label" for="kategori">Kategori</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="kategori" name="kategori" required
                                    data-msg="Isi isian ini">
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" data-bs-dismiss="modal" class="btn btn-lg btn-danger ">Batal</button>
                            <button type="submit" class="btn btn-lg btn-primary ">Simpan</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <span class="sub-text">Periksa kembali isian Anda sebelum Kirim</span>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalKategoriEdit" tabindex="1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kategori</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form id="formKategoriEdit" method="POST" class="form-validate is-alter gy-3">

                        <input type="text" hidden id="id_kategori" name="id_kategori">
                        <div class="form-group">
                            <label class="form-label" for="kategori">Kategori</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="kategori_edit" name="kategori_edit" required
                                    data-msg="Isi isian ini">
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" data-bs-dismiss="modal" class="btn btn-lg btn-danger ">Batal</button>
                            <button type="submit" class="btn btn-lg btn-primary ">Simpan</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light">
                    <span class="sub-text">Periksa kembali isian Anda sebelum Kirim</span>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            showKategori()

        });


        function modalKategori() {
            $('#modalKategori').modal('show')
        }

        function modalKategoriEdit(elem) {
            var id = $(elem).data("id");
            var kategori = $(elem).data("kategori");
            $('#modalKategoriEdit').modal('show')
            $('#id_kategori').val(id)
            $('#kategori_edit').val(kategori)
        }

        function showKategori() {
            var userRole =
                "{{ auth()->user()->role }}"; // Anda bisa mengganti ini dengan cara lain untuk mendapatkan role

            $('#tblKategori').DataTable({
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
                    url: BASE_URL + "/admin/kategori-data",
                    data: function(d) {
                        d.status = $('#statusDropdown').val(); // Kirim status ke backend
                    }
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
                                                            
                                                            <span class="title">` + data.kategori + `</span>
                                                        </span>`
                        }
                    },


                    {

                        "orderable": false,
                        "data": function(data, ) {
                            return `<ul class="nk-tb-actions gx-1 my-n1">
                                                            <li class="me-n1">
                                                                <div class="dropdown">
                                                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                    <div class="dropdown-menu dropdown-menu-end">
                                                                        <ul class="link-list-opt no-bdr">
                                                                             <li><a href="javasrcipt:void(0)" data-id="` +
                                data.id +
                                `" onClick="modalKategoriEdit(this)" data-kategori="` + data.kategori +
                                `"><em class="icon ni ni-edit"></em><span>Edit</span></a></li>
                                                                         
                                                                            
                                                                            <li><a href="javasrcipt:void(0)" onClick="deleteKategori(this)" data-id="` +
                                data.id + `" data-kategori="` + data.kategori + `"><em class="icon ni ni-trash"></em><span>Hapus</span></a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>`
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

        $('#formKategori').on('submit', function(e) {
            e.preventDefault();
            var postData = new FormData($("#formKategori")[0]);
            var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Ambil token CSRF
            postData.append('_token', csrfToken); // Sertakan token CSRF di FormData
            $.ajax({
                type: "post",
                url: BASE_URL + "/admin/kategori", // Pastikan BASE_URL diatur dengan benar
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
                        showKategori()
                        $("#formKategori")[0].reset();
                        $('#modalKategori').modal('hide');
                    }
                },

            });
            return false;
        });

        $('#formKategoriEdit').on('submit', function(e) {
            e.preventDefault();
            var postData = new FormData($("#formKategoriEdit")[0]);
            var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Ambil token CSRF
            postData.append('_token', csrfToken); // Sertakan token CSRF di FormData
            $.ajax({
                type: "post",
                url: BASE_URL + "/admin/kategori-edit", // Pastikan BASE_URL diatur dengan benar
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
                        showKategori()
                        $("#formKategori")[0].reset();
                        $('#modalKategoriEdit').modal('hide');
                    }
                },

            });
            return false;
        });

        function deleteKategori(elem) {
            var id = $(elem).data("id");

            var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Ambil token CSRF

            var title = "Hapus"
            var msg = "Hapus Kategori"

            Swal.fire({
                title: title,
                text: '',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Ya'
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: BASE_URL + '/admin/kategori-delete/' + id,
                        type: "POST",
                        data: {
                            _token: csrfToken, // Sertakan token CSRF di sini
                        },
                        success: function(data) {
                            Swal.fire('Berhasil!', msg, 'success');
                            $('#tblKategori').DataTable().ajax.reload(null, false);

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
