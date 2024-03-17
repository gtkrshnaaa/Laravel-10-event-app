{{-- resources/views/profile/index.blade.php --}}

@extends('layouts.layout')

@section('content')
    <div class="container mt-5">
        @if (session('msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('msg') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card mb-5">
            <div class="card-body d-flex justify-content-between">
                <p class="d-inline">{{ Auth::user()->name }}</p>
                <div>
                    <a href="{{ route('edit-name') }}">Edit Name</a>
                    <a class="d-inline nav-link" href="/logout">Logout</a>
                </div>
            </div>
        </div>

        <div class="input-group mb-3">
            <input type="text" id="searchInput" class="form-control fw-medium border-2" placeholder="Search by title"
                style="background-color: white; color: black; outline: none; box-shadow: none; ">
            <button class="btn btn-outline-secondary" type="button" id="searchButton">
                <i class="fas fa-search"></i>
            </button>
        </div>

        <a href="{{ route('profile.create') }}" class="btn btn-dark">New Post</a>
        <div class="row" id="postContainer">
            <!-- Daftar posting akan dimuat di sini -->
            @foreach ($posts as $post)
                <div class="col-md-12 mt-3">
                    <div class="card shadow border-0">
                        <div class="card-header border-0">
                            <p class="float-start fw-semibold fst-italic">{{ $post->category }}</p>
                            <p class="float-end fw-semibold fst-italic">Status: {{ $post->status }}</p>
                        </div>
                        <div class="row g-0">
                            <div class="col-md-4">
                                <div class="ratio ratio-16x9">
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image"
                                        class="card-img-top p-2" style="object-fit: cover; border-radius: 12px;">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="d-inline card-title">{{ $post->name }}</h5>
                                    <p class="card-text">{{ substr($post->description, 0, 100) }}...</p>
                                    <a href="{{ route('profile.show', ['profile' => $post->id]) }}"
                                        class="btn btn-dark">View</a>
                                    <a href="{{ route('profile.edit', ['profile' => $post->id]) }}"
                                        class="btn btn-dark">Edit</a>
                                    <form action="{{ route('profile.destroy', ['profile' => $post->id]) }}" method="post"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                                    </form>
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
            $('.cardp').each(function() {
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
