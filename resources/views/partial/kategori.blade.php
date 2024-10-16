<div class="col-md-12">
    <div class="product-pagination text-center">
        <h3 class="">Kategori : {{ isset($nm_kategori) ? $nm_kategori : 'Semua' }}</h3>
        <nav>
            <ul class="pagination">
                <li>
                    {{-- Jika tidak ada ID (tidak ada kategori yang dipilih), tampilkan class btn btn-primary untuk "Semua" --}}
                    <a href="{{ url('/') }}">
                        <span class="{{ empty($id) ? 'badge' : '' }}">Semua </span>
                    </a>
                </li>
                @foreach ($kategori as $k)
                    <li>
                        {{-- Cek apakah ID kategori di URL cocok dengan kategori yang sedang di-loop --}}
                        <a href="{{ url('/kategori/' . $k->id) }}">
                            <span class="{{ isset($id) && $id == $k->id ? 'badge bg-blue' : '' }}">
                                {{ $k->kategori }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</div>