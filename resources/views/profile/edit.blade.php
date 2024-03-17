{{-- resources/views/profile/edit.blade.php --}}

@extends('layouts.layout')

@section('content')
<div class="container mt-3">
    <h1 class="text-center mb-3">Edit Post</h1>
    <form action="{{ route('profile.update', ['profile' => $post->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="user_id" value="{{ Auth::id() }}">
        <div class="mb-3">
            <label for="name" class="form-label">Title</label>
            <input type="text" class="form-control" name="name" placeholder="Enter title" value="{{ old('name', $post->name) }}">
        </div>
        @error('name')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" cols="30" rows="10" placeholder="Enter description">{{ old('description', $post->description) }}</textarea>
        </div>
        @error('description')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-select" name="category">
                <option selected disabled>Select Category</option>
                @foreach($categories as $category)
                <option value="{{ $category }}" {{$category === $post->category ? "selected" : ""}}>{{ $category }}</option>
                @endforeach
            </select>
        </div>
        @error('category')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" name="address" placeholder="Enter address" value="{{ old('address', $post->address) }}">
        </div>
        @error('address')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" name="date" value="{{ old('date', $post->date) }}">
        </div>
        @error('date')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" name="image">
            <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="img-thumbnail mt-2" style="max-width: 200px;">
        </div>
        @error('image')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" name="status">
                <option selected disabled>Status</option>
                @foreach($status as $s)
                <option value="{{ $s }}" {{ $s === $post->status ? "selected" : "" }}>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        @error('status')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn btn-primary mb-3">Edit Post</button>
    </form>
</div>
@endsection
