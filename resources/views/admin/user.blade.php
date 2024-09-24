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
                <table width="100%" class="table table-bordered wrap" id="tblUser">
                    <thead class="table-light text-center">
                        <tr>

                            <th width="5%">No</th>
                            <th>Nama </th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th> Status</th>
                            <th> </th>

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

            show()

        });


        function show() {
            var userRole =
                "{{ auth()->user()->role }}"; // Anda bisa mengganti ini dengan cara lain untuk mendapatkan role

            $('#tblUser').DataTable({
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
                    url: BASE_URL + "/admin/user-data",

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
                            var active = data.active == 1 ? '<span class="text-success">Aktif</span>' :
                                '<span class="text-warning">Non-Aktif</span>';
                            return '<div class="text-center">' + active + '</div>'
                        }
                    },

                    {

                        "orderable": false,
                        "data": function(data, ) {
                            var btn = data.active == 0 ?
                                '<button class="btn btn-success" onClick="activitedUser(this)" data-id="' +
                                data
                                .id + '"  data-status="1">Aktifkan</button' :
                                '<button class="btn btn-warning" onClick="activitedUser(this)" data-id="' +
                                data
                                .id + '"  data-status="0">Non Aktifkan</button'
                            return '<div class="text-center">' + btn + '</div>'
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



        function activitedUser(elem) {
            var id = $(elem).data("id");
            var status = $(elem).data("status");

            var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Ambil token CSRF
            var title = status == 1 ? "Non-Aktifkan..?" : "Aktifkan..?"
            var msg = ''

            Swal.fire({
                title: title,
                text: msg,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Ya'
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        url: BASE_URL + '/admin/user/' + id + '/' + status,
                        type: "PUT",
                        data: {
                            _token: csrfToken, // Sertakan token CSRF di sini
                        },
                        success: function(data) {
                            Swal.fire('Berhasil!', msg, 'success');
                            $('#tblUser').DataTable().ajax.reload(null, false);
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
