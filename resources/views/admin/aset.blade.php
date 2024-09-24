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
                    <a href="javascript:void(0)" data-bs-target="#modalAddAset" data-bs-toggle="modal"
                        data-target="addProduct" class="toggle btn btn-primary d-none d-md-inline-flex"><em
                            class="icon ni ni-plus"></em><span>Tambah Aset</span></a>
                </div>
                <div class="col-4">
                    <div class="form-control-wrap text-right">
                        <div class="form-control-select">
                            <select class="form-control" id="statusDropdown">
                                <option value="" selected>Semua</option>
                                <option value="0">Tersedia</option>
                                <option value="1">Dipinjam</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <div class="table-responsive">
                <table width="100%" class="table table-bordered wrap" id="tblAset">
                    <thead class="table-light text-center">
                        <tr>

                            <th width="3%">No</th>
                            <th width="18%">Nama Aset</th>
                            <th width="10%">Foto</th>
                            <th width="18%">NIB</th>
                            <th width="18%">Kategori</th>
                            <th>Status</th>
                            <th width="18%">Unit Kerja</th>
                            <th width="5%"> </th>

                        </tr>
                    </thead>

                </table>
            </div>

        </div>
    </div>
    <div class="modal fade" id="modalAddAset" tabindex="1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Aset</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form id="formAddAset" method="POST" class="form-validate is-alter gy-3">
                        @if (auth()->user()->role === 'opd')
                            <input type="text" id="id_unit" hidden name="id_unit" value="{{ session('id_unit') }}">
                                @endif
                            @if (auth()->user()->role === 'admin') <div class="form-group">
                            
                                <label class="form-label" for="id_unit">Unit Kerja</label>
                                <div class="form-control-wrap ">
                                    <div class="form-control-select">


                                        <select class="form-control" id="id_unit" name="id_unit" required
                                            data-msg="Isi isian ini">
                                            <option value="">Pilih Unit Kerja</option>
                                            @foreach ($unit as $item)
                                                <option value="{{ $item->id }}">{{ $item->nm_unit }}</option>
                                            @endforeach
                                        </select>


                                    </div>
                                </div>
                        </div> @endif
                            <div class="form-group">

                                <label class="form-label" for="kategori">Kategori</label>
                                <div class="form-control-wrap ">
                                    <div class="form-control-select">

                                        <select class="form-control" id="kategori" name="kategori" required
                                            data-msg="Isi isian ini">
                                            <option value="">Pilih Kategori</option>
                                            @foreach ($kategori as $item)
                                                <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="nama_aset">Nama Aset</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="nama_aset" name="nama_aset" required
                                        data-msg="Isi isian ini">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="nama_aset">NIB Aset</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" id="nib_aset" name="nib_aset" required
                                        data-msg="Isi isian ini">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="id_desa">Deskripsi Aset</label>
                                <div class="form-control-wrap ">
                                    <div class="form-control-select">
                                        <textarea id="deskripsi" name="deskripsi" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="customFileLabel">Foto Aset</label>
                                <div class="form-control-wrap">
                                    <div class="form-file">
                                        <input type="file" class="form-file-input" id="img_aset" name="img_aset"
                                            required data-msg="Isi isian ini">
                                        <label class="form-file-label" for="img_aset">Pilih File</label>
                                    </div>
                                </div>
                                <small class="">Ukuran Maksimal 1 Mb, Format JPG/PNG</small>
                            </div>
                            <div class="form-group">
                                <button type="button" data-bs-dismiss="modal"
                                    class="btn btn-lg btn-danger ">Batal</button>
                                <button type="submit" class="btn btn-lg btn-primary ">Kirim</button>
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

            showAset()
            $('#statusDropdown').change(function() {
                showAset() // Reload data ketika status diubah
            });
            $('#modalAddAset').on('hidden.bs.modal', function() {
                // Reset form ketika modal ditutup
                $("#formAddAset")[0].reset();
            });
        });


        function modalAset() {
            $('#modalAset').modal('show')
        }

        function showAset() {
            var userRole =
                "{{ auth()->user()->role }}"; // Anda bisa mengganti ini dengan cara lain untuk mendapatkan role

            $('#tblAset').DataTable({
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
                    url: BASE_URL + "/admin/get-aset",
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
                    {
                        "orderable": false,
                        "data": function(data) {
                            var status = data.status == 0 ?
                                '<span class="badge bg-success">Tersedia</span>' :
                                '<span class="badge bg-warning">Dipinjam</span>';
                            return '<div class="text-center">' + status + '</div>';
                        }
                    },
                    {
                        "orderable": false,
                        "data": function(data) {
                            return '<div class="text-left">' + data.nm_unit + '</div>'
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
                                                                             <li><a href="` + BASE_URL +
                                `/admin/permohonan_detail/` + data.id + `" data-id="` +
                                data.id +
                                `"><em class="icon ni ni-edit"></em><span>Kelola</span></a></li>
                                                                            <li><a href="javasrcipt:void(0)" onClick="detaileAset(this)" data-id="` +
                                data.id +
                                `"><em class="icon ni ni-eye"></em><span>Detail Aset</span></a>
                                                                            <li><a href="javasrcipt:void(0)" onClick="deleteAset(this)" data-id="` +
                                data.id + `"><em class="icon ni ni-trash"></em><span>Hapus Aset</span></a></li>
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
