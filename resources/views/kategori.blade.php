@extends('layout_user.app')

@section('content')
@include('partial/kategori')
    {{-- <div class="slider-area">
        <!-- Slider -->
        <div class="block-slider block-slider4">
            <ul class="" id="bxslider-home4">
                <li>
                    <img src="{{ 'catalog/img/h4-slide.png' }}" alt="Slide">
                    <div class="caption-group">
                        <h2 class="caption title">
                            iPhone <span class="primary">6 <strong>Plus</strong></span>
                        </h2>
                        <h4 class="caption subtitle">Dual SIM</h4>
                        <a class="caption button-radius" href="#"><span class="icon"></span>Shop now</a>
                    </div>
                </li>
                <li><img src="{{ asset('catalog/img/h4-slide2.png') }}" alt="Slide">
                    <div class="caption-group">
                        <h2 class="caption title">
                            by one, get one <span class="primary">50% <strong>off</strong></span>
                        </h2>
                        <h4 class="caption subtitle">school supplies & backpacks.*</h4>
                        <a class="caption button-radius" href="#"><span class="icon"></span>Shop now</a>
                    </div>
                </li>
                <li><img src="{{ asset('catalog/img/h4-slide3.png') }}" alt="Slide">
                    <div class="caption-group">
                        <h2 class="caption title">
                            Apple <span class="primary">Store <strong>Ipod</strong></span>
                        </h2>
                        <h4 class="caption subtitle">Select Item</h4>
                        <a class="caption button-radius" href="#"><span class="icon"></span>Shop now</a>
                    </div>
                </li>
                <li><img src="{{ 'catalog/img/h4-slide4.png' }}" alt="Slide">
                    <div class="caption-group">
                        <h2 class="caption title">
                            Apple <span class="primary">Store <strong>Ipod</strong></span>
                        </h2>
                        <h4 class="caption subtitle">& Phone</h4>
                        <a class="caption button-radius" href="#"><span class="icon"></span>Shop now</a>
                    </div>
                </li>
            </ul>
        </div>
        <!-- ./Slider -->
    </div> <!-- End slider area --> --}}
   

    <div class="single-product-area">
        {{-- <input type="text" value={{$id}}> --}}
       
        <div class="container">
            
            <div class="row" id="aset-container">

            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="product-pagination text-center">
                        <nav>
                            <ul class="pagination">

                                <li><a id="load-more" style="display: none;" href="javascript:void(0);">Tampilkan Lebih
                                        Banyak</a></li>

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            let currentPage = 1;
            let id = "{{ $id }}"
            getAset(currentPage, id)
            $('#load-more').click(function() {
                currentPage++;
                getAset(currentPage);
            });
        })

        function getAset(page) {
            $.ajax({
                url: BASE_URL + '/get-aset?page=' + page, // URL dengan parameter halaman
                method: 'GET',
                success: function(response) {
                    const data = response.data;

                    if (data.length > 0) {
                        data.forEach(function(item) {
                            let trimmedDescription = item.deskripsi.length > 20 ?
                                item.deskripsi.substring(0, 20) + '...' :
                                item.deskripsi;

                            var tgl = konversiFormatTanggal(item.akhir_date)
                            var asetHTML = `
                        <div class="col-md-4 col-sm-6">
                        <div class="single-shop-product">
                        <div class="product-upper">
                            <img height="200px" src="${item.img}" alt="">
                             
                        </div>
                        <h2><a href="">${item.nama_aset}</a></h2>
                        <div class="product-description">
                        ${item.status === 0 
                        ? `
                            <span class="badge" style="padding:5px; position: absolute; background:#3cb371; font-size:12px; top: 20px; left: 20px;">Tersedia</span>
                        `
                        :  item.status === 1 
                        ? `
                        <span class="badge" style="padding:5px; position: absolute; background:#FF0000; font-size:12px; top: 20px; left: 20px;">Pemeliharaan</span>
                        `
                        : ''
                    }
                        <p class="text-secondary">NIB : ${item.nib_aset}</p>
                        <p class="text-secondary">${item.nm_unit}</p>
                    </div>

                       
                        <div class="product-option-shop">
                            <a class="add_to_cart_button"  href="${BASE_URL}/aset-detail/${item.id_aset}">Pinjam</a>
                            </div>
                        </div>
                        </div>
                        
                    `;
                            $('#aset-container').append(asetHTML);
                        });

                        // Show "Load More" button if there's more data, otherwise show "No More Assets"
                        if (response.current_page < response.last_page) {
                            $('#load-more').show();
                            $('#no-more-assets').hide();
                        } else {
                            $('#load-more').hide();
                            $('#no-more-assets').show(); // Show "No More Assets" message
                        }
                    } else {
                        $('#load-more').hide(); // Hide the button if no more data
                        $('#no-more-assets').show(); // Show "No More Assets" message
                    }
                },
                error: function() {
                    $('#load-more-container').append('<p>Error retrieving assets</p>');
                }
            });
        }
    </script>
@endpush
