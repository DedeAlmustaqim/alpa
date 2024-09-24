@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col-8">
            <div class="card p-2">
                <h4>{{ $title }}</h4>
                <div class="card-body">
                    <div class="container">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form class="" action="{{ url('/admin/setting-update') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ $config->id }}" name="id_config">
                            <div class="form-group">
                                <label for="">Nama Aplikasi</label>
                                <input type="text" name="app_name" id="app_name" class="form-control"
                                    value="{{ $config->app_name }}" placeholder="" aria-describedby="helpId">
                            </div>
                            <div class="form-group">
                                <label for="">Pemda</label>
                                <div class="col-md-12">
                                    <input type="text" name="pemda" id="pemda" class="form-control"
                                        value="{{ $config->pemda }}" placeholder="" aria-describedby="helpId">
                                </div>


                            </div>
                            <div class="form-group">
                                <label for="">Alamat</label>
                                <textarea class="form-control" name="alamat_config" id="alamat_config" rows="3">{{ $config->alamat }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <div class="col-6">
                                    <input type="email" class="form-control" name="email_config" id="email_config"
                                        value="{{ $config->email }}" aria-describedby="emailHelpId" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Tentang Aplikasi</label>
                                <textarea class="form-control" name="tentang_config" id="tentang_config" rows="3">{{ $config->tentang }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary float-end">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card p-2">
                <h4 class="card-title center">Logo</h4>

                <div class="card-body center">

                    <form action="{{url('/admin/setting-update-logo')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $config->id }}" name="id_config">
                        <div class="form-group">
                            <img src="{{ url('/') . $config->logo }}"
                                class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}"
                                alt="">
                        </div>
                        <div class="form-group">
                            <label for=""></label>
                            <input type="file" class="form-control-file" name="logo" id="" placeholder=""
                                aria-describedby="fileHelpId">
                        </div>

                        <button type="submit" class="btn btn-primary float-end">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {});
    </script>
@endsection
