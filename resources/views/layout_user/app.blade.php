<!DOCTYPE html>
<!--
 ustora by freshdesignweb.com
 Twitter: https://twitter.com/freshdesignweb
 URL: https://www.freshdesignweb.com/ustora/
-->
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>

    <!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200,300,700,600' rel='stylesheet'
        type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,100' rel='stylesheet' type='text/css'>


    <link rel="stylesheet" href="{{ asset('admin/src/jquery-toast-plugin-master/dist/jquery.toast.min.css') }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('catalog/css/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('catalog/css/font-awesome.min.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('catalog/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('catalog/style.css') }}">
    <link rel="stylesheet" href="{{ asset('catalog/css/responsive.css') }}">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        /* Gaya default untuk single-shop-product */
        .single-shop-product {
            flex: 1 1 calc(25% - 10px);
            /* Lebar fleksibel dengan jarak */
            display: flex;
            flex-direction: column;
            /* background-color: #f8f8f8; */
            transition: background-color 0.3s ease;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            /* Memastikan padding dan border dihitung dalam lebar */


        }

        .product-description {
            height: 100px;
            /* Sesuaikan dengan tinggi yang diinginkan */
            overflow: hidden;
            /* Menyembunyikan konten yang melampaui tinggi */
            margin-bottom: 10px;
            /* Jarak di bawah deskripsi */
        }

        .product-upper {
            height: 200px;
            /* Tinggi tetap untuk gambar */
            overflow: hidden;
            /* Menyembunyikan bagian gambar yang melebihi batas */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Efek hover */
        .single-shop-product:hover {
            background-color: #c4c1c1;
            /* Warna latar belakang saat hover */
        }

        .product-option-shop {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
            /* Tambahkan jarak di atas tombol jika diperlukan */
        }

        ,

        ul.pagination-custom {
            display: flex;
            justify-content: center;
            padding-left: 0;
            list-style: none;
            margin-top: 20px;
        }

        ul.pagination-custom li {
            margin: 0 5px;
        }

        ul.pagination-custom li a {
            display: block;
            padding: 10px 15px;
            color: #007bff;
            text-decoration: none;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            background-color: #fff;
            transition: background-color 0.3s ease;
        }

        ul.pagination-custom li a:hover {
            background-color: #f0f0f0;
        }

        ul.pagination-custom li a.bg-red {
            background-color: #dc3545;
            color: #fff;
        }

        ul.pagination-custom li a.btn-primary {
            background-color: #007bff;
            color: #fff;
        }

        ul.pagination-custom li a.btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="header-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="user-menu">
                        <ul>
                            <li><a href="{{ url('/') }}"><i class="fa fa-home"></i> {{ $config->pemda }}</a></li>
                            <li><a href="javascript:void(0)"> {{ $config->app_name }}</li>

                        </ul>
                    </div>
                </div>


            </div>
        </div>
    </div> <!-- End header area -->

    <div class="site-branding-area">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="logo">
                        <h1><a href="{{ url('/') }}"><img src="{{ asset($config->logo) }}"></a></h1>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="shopping-item">
                        <form action="">
                            <input type="text" placeholder="Cari Aset...">
                            <input type="submit" value="Cari">
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div> <!-- End site branding area -->

    <div class="mainmenu-area">
        <div class="container">
            <div class="row">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('/') }}">Aset </a></li>


                        @if (Auth::check())
                            <li><a href="{{ url('/user/list_aset') }}">Permohonan Saya</a></li>
                            <li>
                                <form id="logout-form-user" action="{{ url('/logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                                <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form-user').submit();">

                                    <span>Logout</span>
                                </a>
                            </li>
                        @endif

                        @if (!Auth::check())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                        @endif

                    </ul>
                </div>
            </div>
        </div>
    </div> <!-- End mainmenu area -->
    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>{{ $config->app_name }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="single-product-area">

        


        @yield('content')

        <div class="footer-top-area">
            <div class="zigzag-bottom"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="footer-about-us">
                            <h2><span>{{ $config->app_name }}</span></h2>
                            <p>{{ $config->tentang }}</p>

                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6">
                        <div class="footer-menu">
                            <h2 class="footer-wid-title">Kategori</h2>
                            <ul>
                                @foreach ($kategori as $k)
                                    <li><a href="{{ url('/kategori/' . $k->id) }}">{{ $k->kategori }}</a></li>
                                @endforeach


                            </ul>
                        </div>
                    </div>




                </div>
            </div>
        </div> <!-- End footer top area -->

        <div class="footer-bottom-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="copyright">
                            <p>&copy; {{ $config->pemda }} </p>
                        </div>
                    </div>


                </div>
            </div>
        </div> <!-- End footer bottom area -->
        <script src="{{ asset('catalog/js/jquery.min.js') }}"></script>
        <script src="{{ asset('admin/src/app.js') }}?v={{ \Carbon\Carbon::now()->timestamp }}"></script>
        <!-- Latest jQuery form server -->


        <!-- Bootstrap JS form CDN -->

        <script src="{{ asset('catalog/js/bootstrap.min.js') }}"></script>

        <!-- jQuery sticky menu -->
        <script src="{{ asset('catalog/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('catalog/js/jquery.sticky.js') }}"></script>

        <!-- jQuery easing -->
        <script src="{{ asset('catalog/js/jquery.easing.1.3.min.js') }}"></script>

        <!-- Main Script -->
        <script src="{{ asset('catalog/js/main.js') }}"></script>

        <!-- Slider -->
        <script type="text/javascript" src="{{ asset('catalog/js/bxslider.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('catalog/js/script.slider.js') }}"></script>



        <script type="text/javascript" src="{{ asset('admin/src/jquery-toast-plugin-master/dist/jquery.toast.min.js') }}">
        </script>

        @stack('scripts')
        <script>
            var BASE_URL = "{{ url('/', []) }}"
        </script>
</body>

</html>
