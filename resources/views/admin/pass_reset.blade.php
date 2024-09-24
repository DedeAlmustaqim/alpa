@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col-8">
            <div class="card p-4">
                <h4>{{ $title }}</h4>
                <div class="card-body">
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
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    @error('repeat_password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <div class="container">

                        <form class="" action="{{ url('/admin/pass-reset') }}" method="POST">
                            @csrf
                            <input type="hidden" value="{{ session('id') }}" name="id_user_pass">
                            <div class="form-group">
                                <label for="">Password</label>
                                <div class="col-6">
                                    <input type="password" class="form-control" name="password" id="password"
                                        aria-describedby="emailHelpId" placeholder="">
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="">Konfirmasi Password</label>
                                <div class="col-6">
                                    <input type="password" class="form-control" name="repeat_password" id="repeat_password"
                                        aria-describedby="emailHelpId" placeholder="">
                                </div>

                            </div>
                            <button type="submit" class="btn btn-primary float-end">Simpan</button>
                        </form>
                    </div>
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
