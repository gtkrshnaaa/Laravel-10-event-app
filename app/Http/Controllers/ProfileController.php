<?php

// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\StorePostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Tambahkan ini untuk menggunakan fungsi penyimpanan

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())
            ->orderByDesc('id')
            ->simplePaginate(12);
        $user = Auth::user();
        return view('profile.index', compact('posts', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ['music events', 'sports events', 'cultural events', 'business events', 'social events', 'educational events'];
        $status = ['public', 'private'];

        return view('profile.create', compact('categories', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        // Validate the incoming request using StorePostRequest
        $validated = $request->validated();

        // Simpan gambar jika ada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('post_images');
            $validated['image'] = $imagePath;
        }

        // Create new post with validated data
        Post::create($validated);

        // Redirect back with success message
        return redirect('/profile')->with('msg', config('message.msg.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $profile)
    {
        if (auth()->id() != $profile->user_id) {
            abort(404);
        }
        return view('profile.show')->with('post', $profile);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $profile)
    {
        $this->authorize('view', $profile);

        $categories = ['music events', 'sports events', 'cultural events', 'business events', 'social events', 'educational events'];

        $status = ['public', 'private'];

        return view('profile.edit')
            ->with('status', $status)
            ->with('categories', $categories)
            ->with('post', $profile);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $profile)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:1500',
            'category' => 'required|in:music events,sports events,cultural events,business events,social events,educational events',
            'status' => 'required|in:public,private',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'required|string|max:255',
            'date' => 'required|date',
        ]);
    
        // Update data post
        $profile->update($validated);
    
        // Update gambar jika ada perubahan
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('post_images');
            $profile->image = $imagePath;
            $profile->save();
        }
    
        return redirect('/profile')->with('msg', config('message.msg.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $profile)
    {
        // Hapus gambar terkait sebelum menghapus post
        if ($profile->image) {
            Storage::delete($profile->image);
        }
        
        $profile->delete();
        return redirect('/profile')->with('msg', config('message.msg.deleted'));
    }

    /**
     * Show the form for editing the name.
     */
    public function editName()
    {
        $user = Auth::user();
        return view('profile.edit-name', compact('user'));
    }

    /**
     * Update the name in storage.
     */
    public function updateName(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than :max characters.',
        ]);
        $user->name = $request->name;
        $user->save();
        return redirect()->route('profile.index')->with('success', 'Name updated successfully');
    }
}
