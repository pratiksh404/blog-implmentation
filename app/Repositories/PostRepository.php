<?php

namespace App\Repositories;

use App\Models\Admin\Category;
use App\Contracts\PostRepositoryInterface;
use App\Http\Requests\PostRequest;
use App\Models\Admin\Post;
use App\Models\Admin\Template;
use Illuminate\Support\Facades\Cache;

class PostRepository implements PostRepositoryInterface
{
    // Post Index
    public function indexPost()
    {
        Cache::rememberForever('posts', function () {
            return Post::with('author')->latest()->get();
        });
        return [];
    }

    // Post Create
    public function createPost()
    {
        $categories = Cache::get('categories', Category::latest()->get());
        return compact('categories');
    }

    // Post Store
    public function storePost(PostRequest $request)
    {
        $post = Post::create($request->validated());
        $this->attachCategories($post);
        $request->image ? $this->uploadImage($post) : '';
    }

    // Post Show
    public function showPost(Post $post)
    {
        return compact('post');
    }

    // Post Edit
    public function editPost(Post $post)
    {
        $categories = Cache::get('categories', Category::latest()->get());
        return compact('post', 'categories');
    }

    // Post Update
    public function updatePost(PostRequest $request, Post $post)
    {
        $request->image ? $this->uploadImage($post) : '';
        $this->attachCategories($post);
    }

    // Post Destroy
    public function destroyPost(Post $post)
    {
        $post->image ? $post->hardDelete('image') : '';
        isset($post->categories) ? $post->categories()->detach() : '';
        $post->delete();
    }

    // Upload Image
    protected function uploadImage(Post $post)
    {
        if (request()->image) {
            $thumbnails = [
                'storage' => 'website/post/' . validImageFolder($post->id, 'post'),
                'width' => '1200',
                'height' => '630',
                'quality' => '100',
                'thumbnails' => [
                    [
                        'thumbnail-name' => 'medium',
                        'thumbnail-width' => '730',
                        'thumbnail-height' => '500',
                        'thumbnail-quality' => '90',
                    ],
                    [
                        'thumbnail-name' => 'small',
                        'thumbnail-width' => '80',
                        'thumbnail-height' => '70',
                        'thumbnail-quality' => '70',
                    ],
                ],
            ];
            $post->makeThumbnail('image', $thumbnails);
        }
    }

    /* Attach Categories */
    protected function attachCategories(Post $post)
    {
        request()->validate([
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
        ]);
        if (request()->has('categories')) {
            $post->categories()->sync(request()->categories);
        }
    }
}
