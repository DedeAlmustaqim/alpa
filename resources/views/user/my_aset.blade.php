@extends('layout_user.app')

@section('content')
    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">

                <div class="col-md-12">
                    <div class="product-content-right">
                        <div class="product-breadcroumb">
                            <a href="">Aset Saya</a>

                        </div>

                        <div class="row">


                            <div class="col-md-12">
                                <div class="product-content-right">
                                    <div class="woocommerce">
                                        <form method="post" action="#">
                                            <table cellspacing="0" class="shop_table cart">
                                                <thead>
                                                    <tr>

                                          
                                                        <th class="product-price">Nama Aset</th>
                                                        <th class="product-quantity">NIB</th>
                                                        <th class="product-subtotal">Status</th>
                                                        <th width="20%">Mulai - Berakhir<br>
                                                            (Pengajuan Pemohon)</th>
                                                        <th width="20%">Mulai - Berakhir<br>
                                                            (disetujui)</th>
                                                        <th class="product-subtotal">Reschedule</th>
                                                        <th class="product-subtotal"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($aset as $item)
                                                        <tr class="cart_item">
                                                           

                                                            <td class="product-name">
                                                                {{ $item->nama_aset }}
                                                            </td>

                                                            <td class="">
                                                                {{ $item->nib_aset }}
                                                            </td>

                                                            <td class="product-price">
                                                                @if ($item->status_permohonan == 0)
                                                                    <span class="text-primary">Sedang Dimohon</span>
                                                                @elseif ($item->status_permohonan == 1)
                                                                    <span class="text-warning">Dalam Verifikasi</span>
                                                                @elseif ($item->status_permohonan == 2)
                                                                    <span class="text-success">Disetujui</span>
                                                                    @elseif ($item->status_permohonan == 3)
                                                                    <span class="text-info">Selesai</span>
                                                                @elseif ($item->status_permohonan == 4)
                                                                    <span class="text-danger">Ditolak</span>
                                                                @endif
                                                            </td>



                                                            <td class="product-quantity">
                                                                <small>{{ konversiFormatTanggal($item->tgl_mulai . $item->jam_mulai) }}</small><br>
                                                                <small>{{ konversiFormatTanggal($item->tgl_akhir . $item->jam_akhir) }}</small>
                                                            </td>

                                                            <td class="product-quantity">
                                                                <small>
                                                                    @if ($item->tgl_mulai_accept && $item->jam_mulai_accept)
                                                                        {{ konversiFormatTanggal($item->tgl_mulai_accept . ' ' . $item->jam_mulai_accept) }}<br>
                                                                    @else
                                                                        {{ '' }}
                                                                    @endif
                                                                </small>
                                                                <small>
                                                                    @if ($item->tgl_akhir_accept && $item->jam_akhir_accept)
                                                                        {{konversiFormatTanggal($item->tgl_akhir_accept . ' ' . $item->jam_akhir_accept) }}
                                                                    @else
                                                                        {{ '' }}
                                                                    @endif
                                                                </small>
                                                            </td>
                                                            <td class="product-quantity">
                                                                @if ($item->tgl_akhir_accept && $item->jam_akhir_accept)
                                                                    <span
                                                                        class="{{ $item->reschedule_mohon == 0 ? 'text-success' : 'text-warning' }}"><b>
                                                                        {{ $item->reschedule_mohon == 0 ? 'Tidak' : 'Ya' }}
                                                                        </b></span>
                                                                @else
                                                                    {{ '' }}
                                                                @endif
                                                            </td>


                                                            <td>
                                                                <button class="btn btn-primary btn-sm">Detail</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </form>


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
