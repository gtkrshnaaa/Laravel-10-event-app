@extends('layouts.layout')

@section('content')
    <div class="container mt-5">
        @if (session('msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('msg') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="input-group mb-3">
            <input type="text" id="searchInput" class="form-control fw-medium border-2" placeholder="Search by title"
                style="background-color: white; color: black; outline: none; box-shadow: none; ">
            <button class="btn btn-outline-secondary" type="button" id="searchButton">
                <i class="fas fa-search"></i>
            </button>
        </div>


        <div class="container mt-3">
            <div class="row">
                <div class="col-md-12">
                    <div class="btn-group d-flex justify-content-center flex-wrap px-2" role="group"
                        aria-label="Filter by Category">
                        @foreach ($categories as $category)
                            <div style="margin: 1%;">
                                <button type="button" class="btn btn-outline-dark filter-category text-sm fw-medium border-0 shadow"
                                    data-category="{{ $category }}">{{ ucfirst($category) }}</button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="postContainer">
            <!-- Daftar posting akan dimuat di sini -->
            @foreach ($posts as $post)
                <div class="col-md-12 mt-3">
                    <div class="card shadow border-0">
                        <div class="card-header border-0">
                            <p class="float-start fw-semibold fst-italic">{{ $post->category }}</p>
                            <p class="float-end fw-semibold fst-italic">Posted by {{ $post->users->name }}</p>
                        </div>
                        <div class="row g-0">
                            <div class="col-md-4">
                                <div class="ratio ratio-16x9">
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image"
                                        class="card-img-top p-2" style="object-fit: cover; border-radius: 12px;">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body border-0">
                                    <h5 class="card-title d-inline">{{ $post->name }}</h5>
                                    <p class="card-text">{{ substr($post->description, 0, 100) }}...</p>
                                    <a href="{{ route('posts.show', ['post' => $post->id]) }}" class="btn btn-dark">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-3 float-end">
            {{ $posts->links() }}
        </div>
    </div>
@endsection



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    $(document).ready(function() {
        // Cek apakah ada kata kunci pencarian yang tersimpan di local storage
        var savedSearchText = localStorage.getItem('searchText');
        if (savedSearchText) {
            $('#searchInput').val(savedSearchText); // Setel nilai input pencarian sesuai dengan yang tersimpan
            filterPosts(savedSearchText); // Lakukan pencarian dengan kata kunci yang tersimpan
        }

        // Tangani perubahan dalam input pencarian
        $('#searchInput').on('input', function() {
            var searchText = $(this).val().toLowerCase(); // Ambil nilai input pencarian
            localStorage.setItem('searchText',
                searchText); // Simpan kata kunci pencarian ke local storage
            filterPosts(searchText); // Lakukan pencarian dengan kata kunci baru
        });

        // Fungsi untuk menyaring posting berdasarkan kata kunci pencarian
        function filterPosts(searchText) {
            $('.card').each(function() {
                var titleText = $(this).find('.card-title').text().toLowerCase(); // Ambil teks judul
                if (titleText.indexOf(searchText) === -1) {
                    $(this).hide(); // Sembunyikan kartu jika tidak cocok
                } else {
                    $(this).show(); // Tampilkan kartu jika cocok
                }
            });
        }

        $('.filter-category').click(function() {
            var category = $(this).data('category');
            // Redirect ke halaman yang sama dengan parameter kategori
            window.location.href = "{{ route('posts.index') }}?category=" + category;
        });
    });
</script>
