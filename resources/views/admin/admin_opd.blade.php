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
                    <a href="javascript:void(0)" data-bs-target="#modalAddAdmin" data-bs-toggle="modal"
                        data-target="addProduct" class="toggle btn btn-primary d-none d-md-inline-flex"><em
                            class="icon ni ni-plus"></em><span>Tambah Admin OPD</span></a>
                </div>
            </div>
            <hr>
            <div class="table-responsive">
                <table width="100%" class="table table-bordered wrap" id="tblAdminOpd">
                    <thead class="table-light text-center">
                        <tr>

                            <th width="5%">No</th>
                            <th>Nama </th>
                            <th >Email</th>
                            <th >No HP</th>
                            <th >Unit Kerja</th>
                            <th width="5%"> </th>

                        </tr>
                    </thead>

                </table>
            </div>

        </div>
    </div>
    <div class="modal fade" id="modalAddAdmin" tabindex="1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Aset</h5>
                    <a href="#" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <em class="icon ni ni-cross"></em>
                    </a>
                </div>
                <div class="modal-body">
                    <form id="formAddAdmin" method="POST" class="form-validate is-alter gy-3">
                        <div class="form-group">

                            <label class="form-label" for="id_unit">Unit Kerja</label>
                            <div class="form-control-wrap ">
                                <div class="form-control-select">
                                   
                                    <select class="form-control" id="id_unit_admin" name="id_unit_admin" required
                                        data-msg="Isi isian ini">
                                        <option value="">Pilih Unit Kerja</option>
                                        @foreach ($unit as $item)
                                            <option value="{{ $item->id }}">{{ $item->nm_unit }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="nama_admin">Nama</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="nama_admin" name="nama_admin" required
                                    data-msg="Isi isian ini">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email_admin">Email</label>
                            <div class="form-control-wrap">
                                <input type="email" class="form-control" id="email_admin" name="email_admin" required
                                    data-msg="Isi isian ini">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="no_hp_admin">NO HP (Aktif WA)</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" id="no_hp_admin" name="no_hp_admin" required
                                    data-msg="Isi isian ini">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="password_admin">Password</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control " hidden id="password_admin" name="password_admin" required
                                    data-msg="Isi isian ini" value="AsetKita">
                                    <small>Password default "AsetKita"</small>
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

            show()
            
            $('#modalAddAdmin').on('hidden.bs.modal', function() {
                // Reset form ketika modal ditutup
                $("#formAddAset")[0].reset();
            });
        });

       
        function show() {
            var userRole =
                "{{ auth()->user()->role }}"; // Anda bisa mengganti ini dengan cara lain untuk mendapatkan role

            $('#tblAdminOpd').DataTable({
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
                    url: BASE_URL + "/admin/admin-opd-data",
                    
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
                            return '<div class="text-left">' + data.email + '</div>'
                        }
                    },
                    {
                        "orderable": false,
                        "data": function(data) {
                            return '<div class="text-left">' + data.no_hp + '</div>'
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
                                                                             <li><a href="` + BASE_URL +`/admin/permohonan_detail/` + data.id + `" data-id="` +
                                data.id +`"><em class="icon ni ni-edit"></em><span>Kelola</span></a></li>
                                                                            
                                                                           
                                                                            <li><a href="javasrcipt:void(0)" onClick="deleteAdminOpd(this)" data-id="` +
                                data.id + `"><em class="icon ni ni-trash"></em><span>Hapus </span></a></li>
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

        $('#formAddAdmin').on('submit', function(e) {
            e.preventDefault();
            var postData = new FormData($("#formAddAdmin")[0]);
            var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Ambil token CSRF
            postData.append('_token', csrfToken); // Sertakan token CSRF di FormData
            $.ajax({
                type: "post",
                url: BASE_URL + "/admin/admin-opd", // Pastikan BASE_URL diatur dengan benar
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
                        show()
                        $("#formAddAdmin")[0].reset();
                        $('#modalAddAdmin').modal('hide');
                    }
                },

            });
            return false;
        });


        function deleteAdminOpd(elem) {
            var id = $(elem).data("id");

            var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Ambil token CSRF

            var title = "Hapus"
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
                        url: BASE_URL + '/admin/admin-opd/' + id,
                        type: "DELETE",
                        data: {
                            _token: csrfToken, // Sertakan token CSRF di sini
                        },
                        success: function(data) {
                            Swal.fire('Berhasil!', msg, 'success');
                            $('#modalAddAdmin').modal('hide')
                            $('#tblAdminOpd').DataTable().ajax.reload(null, false);

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
