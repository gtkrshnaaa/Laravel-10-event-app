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
                <div class="card mt-4 shadow border-0">
                    <div class="card-header border-0">
                        <h5 class="card-title">Comments</h5>
                    </div>
                    <div class="card-body border-0">
                        <form action="/comments" method="post">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="input-group mb-3">
                                <input class="form-control" type="text" name="comment" placeholder="Write a comment...">
                                <button class="btn btn-outline-dark" type="submit"><i
                                        class="fas fa-paper-plane"></i></button>
                            </div>
                        </form>
                        <div style="max-height: 50vh; overflow-y: auto;">
                            @foreach ($comments as $comment)
                                @if ($post->id === $comment->post_id)
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <p class="mb-0">{{ $comment->users->name }}</p>
                                                <span
                                                    class="small text-muted fst-italic">{{ substr($comment->created_at, 0, 10) }}</span>
                                            </div>
                                            <hr class="mt-2 mb-3">
                                            <p>{{ $comment->comment }}</p>
                                            @if ($comment->user_id === Auth::user()->id)
                                                <p class="small mb-0">
                                                <form action="{{ route('comments.destroy', ['comment' => $comment->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-dark">Delete</button>
                                                </form>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
