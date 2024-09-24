@extends('layout_user.app')

@section('content')
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">

                <div class="col-md-12">
                    <div class="product-content-right">
                        <div class="product-breadcroumb">
                            <a href="">Home</a>
                            <a href="">{{ $aset->kategori }}</a>
                            <a href="">{{ $aset->nama_aset }}</a>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="product-images">
                                    <div class="product-main-img">
                                        <img width="500px" src="{{ asset($aset->img) }}" alt="">
                                    </div>


                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="product-inner">
                                    <h2 class="product-name">{{ $aset->nama_aset }}</h2>



                                    <div class="product-inner-category">
                                        <p>Kategori: {{ $aset->kategori }} </p>
                                        <p> {{ $aset->nm_unit }} </p>
                                    </div>

                                    <div role="tabpanel">
                                        <ul class="product-tab" role="tablist">
                                            <li role="presentation" class="active"><a href="#home" aria-controls="home"
                                                    role="tab" data-toggle="tab">Deskripsi</a></li>
                                            <li role="presentation"><a href="#profile" aria-controls="profile"
                                                    role="tab" data-toggle="tab">Ajukan Permohonan Pinjam</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade in active" id="home">
                                                <h2>Deskripsi</h2>
                                                <p>{{ $aset->deskripsi }}</p>


                                            </div>
                                            <div role="tabpanel" class="tab-pane fade" id="profile">
                                                @if (Auth::check())
                                                    <!-- Formulir ditampilkan jika pengguna sudah login -->
                                                    <form method="POST" id="formAsetMohon">
                                                        @csrf
                                                        <!-- Formulir Anda -->
                                                        <div class="submit-review">
                                                            <input hidden type="text" id="id_aset" name="id_aset"
                                                                value="{{ $aset->id }}">
                                                            <input hidden type="text" id="id_user" name="id_user"
                                                                value="{{ session('id') }}">
                                                            <div class="row g-3 align-center">
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="site-name">Tanggal
                                                                            Mulai</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <div class="form-control-wrap">
                                                                            <input type="date" name="tgl_mulai"
                                                                                id="tgl_mulai" class="form-control">

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row g-3 align-center">
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="site-name">Jam
                                                                            Mulai</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <div class="form-control-wrap">

                                                                            <input type="text" id="jam_mulai"
                                                                                name="jam_mulai"
                                                                                class="form-control input-disabled jam"
                                                                                required pattern="[0-9]{2}:[0-9]{2}"
                                                                                title="Format waktu harus HH:mm"
                                                                                placeholder="--:--">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row g-3 align-center">
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="site-name">Tanggal
                                                                            Berakhir</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <div class="form-control-wrap">
                                                                            <input type="date" name="tgl_akhir"
                                                                                id="tgl_akhir" class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row g-3 align-center">
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="site-name">Jam
                                                                            Berakhir</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <div class="form-group">
                                                                        <div class="form-control-wrap">

                                                                            <input type="text" id="jam_akhir"
                                                                                name="jam_akhir"
                                                                                class="form-control input-disabled jam"
                                                                                required pattern="[0-9]{2}:[0-9]{2}"
                                                                                title="Format waktu harus HH:mm"
                                                                                placeholder="--:--">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row g-3 align-center">
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="site-name">Catatan
                                                                            Pinjam</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-8">
                                                                    <div class="form-group">
                                                                        <div class="form-control-wrap">
                                                                            <textarea class="form-control" id="catatan" name="catatan"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row g-3 align-center">
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="site-name">Surat
                                                                            Permohonan</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-8">
                                                                    <div class="form-group">
                                                                        <div class="form-control-wrap">
                                                                            <input type="file" class="form-control"
                                                                                id="srt_mohon" name="srt_mohon">
                                                                            <label class="form-file-label"
                                                                                for="srt_mohon">Pilih File</label>
                                                                            <small class="">Ukuran Maksimal 1 Mb,
                                                                                Format PDF</small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <p><input type="submit" value="Kirim"></p>
                                                        </div>
                                                    </form>
                                                @else
                                                    <!-- Pesan atau konten lain yang ditampilkan jika pengguna belum login -->
                                                    <p>Anda harus login untuk mengakses form ini.</p>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.jam').on('input', function(e) {
                var value = $(this).val().replace(/\D/g, ''); // Hapus semua karakter non-digit
                if (value.length > 2) {
                    $(this).val(value.slice(0, 2) + ':' + value.slice(2, 4));
                } else {
                    $(this).val(value);
                }
            });

            $('.jam').on('blur', function(e) {
                var value = $(this).val();
                if (value.length === 4 && value.indexOf(':') === -1) {
                    $(this).val(value.slice(0, 2) + ':' + value.slice(2, 4));
                }
            });

        })
        $('#formAsetMohon').on('submit', function(e) {
            e.preventDefault();
            var postData = new FormData($("#formAsetMohon")[0]);
            var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Ambil token CSRF
            postData.append('_token', csrfToken); // Sertakan token CSRF di FormData
            $.ajax({
                type: "post",
                url: BASE_URL + "/user/permohonan", // Pastikan BASE_URL diatur dengan benar
                processData: false,
                contentType: false,
                data: postData,
                dataType: "JSON",
                success: function(data) {
                    if (data.success == false) {

                        if (data.message) {

                            $.toast({
                                heading: 'Peringatan',
                                text: data.message,
                                icon: 'warning',
                                position: 'mid-center',
                                stack: false
                            })
                        } else {
                            data.errors.forEach(function(error) {
                                $.toast({
                                    heading: 'Peringatan',
                                    text: error,
                                    icon: 'warning',
                                    position: 'mid-center',
                                    stack: false
                                })
                            });
                        }

                    } else if (data.success == true) {

                        // showAset()
                        $.toast('<h5>Berhasil Simpan Data</h5><p class="text-success"></p>',
                            'success')
                        $.toast({
                            heading: 'Berhasil',
                            text: '<h5>Berhasil Simpan Data</h5><p class="text-success"></p>',
                            icon: 'success',
                            position: 'mid-center',
                            stack: false
                        })
                        $("#formAsetMohon")[0].reset();
                        // $('#modalAddAset').modal('hide');
                    }
                },

            });
            return false;
        });
    </script>
@endpush
