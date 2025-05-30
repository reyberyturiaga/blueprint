<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('index', Post::class);

        $posts = Post::all();

        return view('post.index', [
            'posts' => $posts,
        ]);
    }

    public function create(Request $request): View
    {
        Gate::authorize('create', Post::class);

        return view('post.create');
    }

    public function store(PostStoreRequest $request): RedirectResponse
    {
        Gate::authorize('store', Post::class);


        $post = Post::create($request->validated());

        $request->session()->flash('post.id', $post->id);

        return redirect()->route('posts.index');
    }

    public function show(Request $request, Post $post): View
    {
        Gate::authorize('show', $post);

        return view('post.show', [
            'post' => $post,
        ]);
    }

    public function edit(Request $request, Post $post): View
    {
        Gate::authorize('edit', $post);

        return view('post.edit', [
            'post' => $post,
        ]);
    }

    public function update(PostUpdateRequest $request, Post $post): RedirectResponse
    {
        Gate::authorize('update', $post);


        $post->update($request->validated());

        $request->session()->flash('post.id', $post->id);

        return redirect()->route('posts.index');
    }

    public function destroy(Request $request, Post $post): RedirectResponse
    {
        Gate::authorize('destroy', $post);

        $post->delete();

        return redirect()->route('posts.index');
    }
}
