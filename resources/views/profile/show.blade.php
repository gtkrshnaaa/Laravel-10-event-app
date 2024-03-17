{{-- resources/views/profile/show.blade.php --}}

@extends('layouts.layout')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow border-0">
                    <div class="card-header border-0">
                        <p class="float-start fw-semibold fst-italic">{{ $post->category }}</p>
                        <p class="float-end fw-semibold fst-italic">Posted by {{ $post->users->name }}</p>
                    </div>
                    <div class="card-body border-0">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="ratio ratio-16x9 mb-4">
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="card-img-top"
                                        style="object-fit: cover;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5 class="card-title d-inline">{{ $post->name }}</h5>
                                <p class="card-text">{{ $post->description }}</p>
                                <p><strong>Address:</strong> {{ $post->address }}</p>
                                <p><strong>Date:</strong> {{ $post->date }}</p>
                                <a href="{{ route('posts.index') }}" class="btn btn-dark">Back</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
