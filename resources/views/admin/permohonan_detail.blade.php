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
                    <h4 class="product-price text-primary">{{ $aset->kategori }}</small>
                    </h4>
                    <h2 class="product-title">{{ $aset->nama_aset }}</h2>
                    <p class="">{{ $aset->nm_unit }}</p>

                    <div class="">
                        <small>Deksripsi : {{ $aset->deskripsi }}</small>
                    </div>



                </div><!-- .col -->
                <div class="col-lg-8">
                    <div class="product-info mt-5 me-xxl-5">
                        <div class="example-alerts mb-2">
                            <div class="example-alert">
                                <div class="alert alert-primary alert-icon">
                                    <div id="status_aset_alert"></div>
                                    <em class="icon ni ni-alert-circle"></em>
                                </div>
                            </div>


                        </div>
                        <hr>
                        <h4>Daftar Permohonan Disetujui <div id="status-2"></div>
                        </h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table width="100%" class="table table-bordered wrap" id="tblPermohonanAsetAccept">
                                        <thead class="table-light text-center">
                                            <tr>

                                                <th width="5%">No</th>

                                                <th width="15%">Pemohon</th>

                                                <th>Surat Permohonan</th>

                                                <th>Mulai (disetujui)</th>
                                                <th>Berakhir (disetujui)</th>
                                                <th>Reschedule </th>
                                                <th width="5%">Aksi </th>

                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!-- .product-info -->
                </div><!-- .col -->
            </div><!-- .row -->
            <div class="row">
                <div class="card card-bordered card-preview">
                    <div class="card-inner">
                        <button class="btn btn-secondary float-end" onclick="refreshData()" >Refresh Data</button>
                        <ul class="nav nav-tabs mt-n3" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#tabItem1" aria-selected="true"
                                    role="tab">Daftar Permohonan <div id="status-0"></div></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#tabItem4" aria-selected="true"
                                    role="tab">Dalam Verifikasi <div id="status-1"></div></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#tabItem2" aria-selected="false"
                                    tabindex="-1" role="tab">Pinjaman Selesai <div id="status-3"></div></a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#tabItem3" aria-selected="false"
                                    tabindex="-1" role="tab">Permohonan ditolak <div id="status-4"></div></a>
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
                                                <th>Surat Permohonan</th>
                                                @if (auth()->user()->role !== 'verifikator')
                                                    <th width="25%">Aksi </th>
                                                @endif
                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabItem4" role="tabpanel">
                                <div class="table-responsive">
                                    <table width="100%" class="table table-bordered wrap" id="tblPermohonanAsetVerif">
                                        <thead class="table-light text-center">
                                            <tr>

                                                <th width="5%">No</th>

                                                <th width="15%">Pemohon</th>
                                                <th>Surat Permohonan</th>
                                                <th>Mulai (disetujui)</th>
                                                <th>Berakhir (disetujui)</th>
                                                <th>Reschedule </th>
                                                <th>Diterima </th>
                                                <th width="5%">Aksi </th>

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

                                                <th>Surat Permohonan</th>

                                                <th>Mulai (disetujui)</th>
                                                <th>Berakhir (disetujui)</th>
                                                <th>Riwayat</th>
                                                <th width="5%"> </th>

                                            </tr>
                                        </thead>

                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabItem3" role="tabpanel">
                                <table width="100%" class="table table-bordered wrap" id="tblPermohonanAsetReject">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th width="5%">No</th>
                                            <th width="18%">Pemohon</th>
                                            <th>Surat Permohonan</th>
                                            <th>Mulai </th>
                                            <th>Berakhir</th>
                                            <th>Alasan ditolak</th>
                                            <th>Ditolak pada</th>


                                        </tr>
                                    </thead>

                                </table>
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
    <script src="{{ asset('admin/src/permohonan_detail.js') }}?v={{ \Carbon\Carbon::now()->timestamp }}"></script>
@endpush
